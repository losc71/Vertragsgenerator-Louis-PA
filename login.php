<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_POST["submit"])) {

    include 'include/config.php';
//Login proccess
    if (isset($_POST['username']) && isset($_POST['password'])) {
  
        $username = $_POST['username'];
        $password = $_POST['password'];
      
        // Hash the password using password_hash()
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      
        //Checking the DB for the user
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->prepare("SELECT * FROM users WHERE username=:username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result && password_verify($password, $result['password'])) {
                echo "Logged in!";
                $_SESSION['username'] = $result['username'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['id'] = $result['id'];
                header("Location: index.php");
                exit();
            } else {
                // The password was incorrect, so send the user back to the login page with an error message
                $_SESSION['error_message'] = "Falscher Username oder Passwort";
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $db = null;
      
      }
    } 


?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=0" />
    <meta http-equiv="ScreenOrientation" content="autoRotate:disabled" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

    <link href="css/custom.css?ver=100" type="text/css" rel="stylesheet" />
    <link rel="icon" href="img/metaball_02.png" type="imgage/icon" />


</head>

<body oncontextmenu="return false">
    <img class="logo" src="img/Logo_small.gif" width="200px" />
    <div class="adminOverView">
    <?php 
      if (isset($_SESSION['error_message'])) {
        echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
        unset($_SESSION['error_message']);
      } 
    ?>
        <p class="blocked">Login:</p>
        <form method="POST" id="login-form">
            <input class="input" type="text" name="username" placeholder="Username" /><br />
            <input class="input" type="password" id="password" name="password" placeholder="Passwort" /><br />
            <input id="submit-login" class="submit" type="submit" name="submit" value="Login" />
        </form>
    </div>

</body>

</html>