<?php
require_once 'include/config.php';
require 'include/functions/adminCheck.php';
session_start();


if (!isAdmin()) {
    header("Location: logout.php");
    exit();
}

//Query for the details of all users
$query = "SELECT * FROM users";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $_SESSION['username']);
$stmt->execute();
$user = $stmt->fetch();

$stmt = $db->prepare($query);

$stmt->execute();
$result = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="de">

<head>
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
    <a class="iconLeft" href="admin.php"><i class="fa-solid fa-xmark fa-xl"></i></a>
    <a class="iconRight" href="logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>
    <div class="adminContainer">
        <img class="logo" name="logo.img" src="img/Logo_small.gif" width="20%" />
        <div class="columnNewUser">
            <div class="adminOverView">

                <h2>User Panel</h2>
                <button class="addUser" onclick="location.href='newUser.php'"><i class="fa-solid fa-plus"></i></button>
                <table id="adminTable">
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Rechte</th>
                    </tr>
                    <?php
                    $loggedInUserId = $_SESSION['id']; // get the id of the logged-in user
                    //Displaying all user in a table
                    foreach ($result as $row) {
                        echo '<tr class="adminTableRowResult">';
                        echo '<td class="adminTablePad">' . $row['username'] . '</td>';
                        echo '<td class="adminTablePad">' . $row['firstNameUser'] . ' ' . $row['lastNameUser'] . '</td>';
                        if ($row['admin'] == 0) {
                            echo '<td class="adminTablePad">User</td>';
                        } else {
                            echo '<td class="adminTablePad">Admin</td>';
                        }
                        echo '<td class="adminTableCenter">
                                <button class="editButton" data-user-id="' . $row['id'] . '">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </td>';
                        if ($row['id'] != $loggedInUserId) {
                            echo '<td class="adminTableCenter">
                                    <button class="deleteButton" data-user-id="' . $row['id'] . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>';
                        } else {
                            echo '<td></td>';
                        }
                        echo '</tr>';
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
</body>
<script>
    //Confirmation before deleting user and sending Data to deleteDbUser.php for deleting from DB
    $(document).ready(function () {
        $('.deleteButton').on('click', function () {
            let userId = $(this).data('user-id');
            if (confirm("Möchten sie den User unwiederruflich löschen?")) {
                $.ajax({
                    type: 'POST',
                    url: 'deleteDbUser.php',
                    data: {
                        user_id: userId
                    },
                    success: function (response) {
                        location.reload();
                    }
                });
            }
        });
    });
    //Binding the user Id to edit the user and then redirect to editUser.php
    $(document).ready(function () {
        $('.editButton').on('click', function () {
            let userId = $(this).data('user-id');
            window.location.href = "editUser.php?user_id=" + userId;
        });
    });
</script>


</html>