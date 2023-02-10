<?php
require 'include/functions/adminCheck.php';
session_start();
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuer User</title>
    <script src="https://kit.fontawesome.com/e785ad1786.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link href="css/custom.css?ver=100" type="text/css" rel="stylesheet" />
</head>

<body>
    <a class="iconLeft" href="userPanel.php"><i class="fa-solid fa-xmark fa-xl"></i></a>
    <a class="iconRight" href="logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>
    <div class="adminContainer">
        <img class="logo" name="logo.img" src="img/Logo_small.gif" width="20%" />
        <div class="columnNewUser">
            <div class="adminOverView">
                <h2>Neuer Benutzer</h2>
                <div id="create-user-modal">
                    <form id="create-user-form">
                        <input placeholder="Username" type="text" id="username" name="username" require><br>
                        <input placeholder="Vorname" type="text" id="firstNameUser" name="firstNameUser"><br>
                        <input placeholder="Nachname" type="text" id="lastNameUser" name="lastNameUser"><br>
                        <input placeholder="Password" type="password" id="password" name="password" require><br>
                        <label class="rad-label" for="admin"><input type="checkbox" class="rad-input" id="admin"
                                name="admin" />
                            <div class="rad-design"></div>
                            <div class="rad-text">Admin</div>
                        </label>
                        <button type="submit" id="submit-create-user-form">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

<script>
//Sending data of the inputs to insertUser.php to insert into DB
    document.getElementById("create-user-form").addEventListener("submit", function (e) {
        e.preventDefault();
        var username = document.getElementById("username").value;
        var firstNameUser = document.getElementById("firstNameUser").value;
        var lastNameUser = document.getElementById("lastNameUser").value;
        var password = document.getElementById("password").value;
        var admin = document.getElementById("admin").checked;
        fetch('/insertUser.php', {
            method: 'POST',
            body: JSON.stringify({ username: username, firstNameUser: firstNameUser, lastNameUser: lastNameUser, password: password, admin: admin }),
            headers: { 'Content-Type': 'application/json' }
        }).then(response => {
            if (response.ok) {
                // Redirect to the homepage
                window.location.href = "userPanel.php";
            } else {
                // Handle the error, for example by displaying an error message
            }
        }).catch(error => {
            // Handle network errors
        });
    });


</script>

</html>