<?php
require 'include/functions/adminCheck.php';
session_start();
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

// Retrieve user ID from the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    // Query the database to retrieve the user's information
    $query = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();
} else {
    header("Location: userPanel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
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
                <h2>Edit User</h2>
                <div id="edit-user-modal">
                    <form id="edit-user-form" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                        <input placeholder="Username" type="text" id="username" name="username"
                            value="<?php echo $user['username'] ?>" require><br>
                        <input placeholder="Vorname" type="text" id="firstNameUser" name="firstNameUser"
                            value="<?php echo $user['firstNameUser'] ?>"><br>
                        <input placeholder="Nachname" type="text" id="lastNameUser" name="lastNameUser"
                            value="<?php echo $user['lastNameUser'] ?>"><br>
                        <label class="rad-label" for="admin"><input type="checkbox" class="rad-input" id="admin"
                                name="admin" <?php if ($user['admin'])
                                    echo 'checked' ?> />

                                <div class="rad-design"></div>
                                <div class="rad-text">Admin</div>
                            </label>
                            <button type="submit" id="submit-edit-user-form">Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //Sending the values to the updateUser.php to insert into the DB
            window.addEventListener("load", function () {
                document.getElementById("edit-user-form").addEventListener("submit", function (e) {
                    e.preventDefault();
                    var user_id = document.querySelector('input[name="user_id"]').value;
                    var username = document.querySelector('input[name="username"]').value;
                    var firstNameUser = document.querySelector('input[name="firstNameUser"]').value;
                    var lastNameUser = document.querySelector('input[name="lastNameUser"]').value;
                    var admin = document.getElementById("admin").checked;
                    fetch('./updateUser.php', {
                        method: 'POST',
                        body: JSON.stringify({ user_id: user_id, username: username, firstNameUser: firstNameUser, lastNameUser: lastNameUser, admin: admin }),
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if (response.ok) {
                            var formData = new FormData(document.getElementById("edit-user-form"));
                            fetch('updateUser.php', {
                                method: 'POST',
                                body: formData
                            })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    alert("Änderungen erfolgreich gespeichert");
                                    location.href = "userPanel.php";
                                });
                        } else {
                            // Handle the error, for example by displaying an error message
                        }
                    }).catch(error => {
                        // Handle network errors
                    });
                });
            });


        </script>
    </body>

    </html>