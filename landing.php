<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM sempprojectusers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    // // Check for confirm password field
    // if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    //     $password_err = "Passwords should match";
    // }


    // If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err)) {
        $sql = "INSERT INTO sempprojectusers (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: homebeforelogin.php");
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
  

//  echo "Today is " . date("Y/m/d") . "<br>" ;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style2.css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/8fb8e03dbe.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Lemonada&family=Permanent+Marker&family=Ubuntu+Mono&display=swap" rel="stylesheet">



    <title>Document</title>
</head>

<body>
    <section class="main">
        <div class="container title">
            <div class="row">
                <div class="col-12">
                    <h2></h2>
                    <h2 class="titlesize"><i class="fas fa-bed"></i>
                       <span class="auto-input2"></span>
                    </h2>
                    <!-- <h2>semp</h2> -->

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row sidetext">
                <h3>
                    Explore the wolrd and
                </h3>
                <h3>let us help u finding the best hotels around you</h3>
            </div>
        </div>
        <div class="container fill">
            <div class="row">
                <div class="col-6">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="uname">Email address or Username</label>
                            <input type="email" class="form-control" name="username" aria-describedby="emailHelp" placeholder="Your email or username" required>
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div> <br>
                        <div class="form-group">
                            <label for="pswd">Password</label>
                            <input type="password" class="form-control" name="password" placeholder=" Your password" required>
                        </div> <br>

                        <button type="submit" class="btn btn-light btnnew" >REGISTER</button>
                        
                    <!-- <div id="liveAlertPlaceholder"></div>
                    <button type="submit" class="btn btn-primary" id="liveAlertBtn">Show live alert</button> -->
                    </form>



                </div>
            </div>
        </div>

    </section>

    <script>

    var alertPlaceholder = document.getElementById('liveAlertPlaceholder')
var alertTrigger = document.getElementById('liveAlertBtn')

function alert(message, type) {
  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

  alertPlaceholder.append(wrapper)
}

if (alertTrigger) {
  alertTrigger.addEventListener('click', function () {
    alert('Nice, you triggered this alert message!', 'success')
  })
}
</script>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        var typed = new Typed(".auto-input2", {
            strings: ["WT LAB"],
            typeSpeed: 100,
            backSpeed: 100,

            loop: true,
        })
    </script>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>

</body>

</html>