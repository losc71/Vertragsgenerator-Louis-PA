<?php
require_once 'include/config.php';
require 'include/functions/adminCheck.php';
session_start();
//Checkif user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

//Query for admin to show all PDF and normal user just the PDF's of themself
$admin = isAdmin();
if ($admin == 1) {
    $query = "SELECT customers.*, users.firstNameUser, users.lastNameUser
              FROM customers
              JOIN users ON customers.hasCreated = users.username";
} else {
    $query = "SELECT customers.*, users.firstNameUser, users.lastNameUser
              FROM customers
              JOIN users ON customers.hasCreated = users.username 
              WHERE customers.hasCreated = :username";
}
$stmt = $db->prepare($query);
if (!$admin) {
    $stmt->bindParam(':username', $_SESSION['username']);
}
$stmt->execute();
$result = $stmt->fetchAll();




?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://kit.fontawesome.com/e785ad1786.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link href="css/custom.css?ver=100" type="text/css" rel="stylesheet" />
    <link rel="icon" href="img/metaball_02.png" type="imgage/icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon-180x180.png" />
</head>

<body>
    <a class="iconLeft" href="index.php"><i class="fa-solid fa-xmark fa-xl"></i></a>
    <a class="iconRight" href="logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>
    <div class="adminContainer">
        <img class="logo" name="logo.img" src="img/Logo_small.gif" width="20%" />
        <div class="column">
            <div class="adminOverView">
                <h2>Admin Panel</h2>
                <?php if ($admin == 1) {
                    echo '<button class="addUser" onclick="location.href=\'userPanel.php\'"><i class="fa-solid fa-users"></i></button>';
                } ?>
                <table id="adminTable">
                    <thead>
                        <tr>
                            <th>Firma</th>
                            <th>Ansprechspartner</th>
                            <th>Vertrag</th>
                            <th>Erstellt von</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($result as $row) {
                        echo '<tr class="adminTableRowResult">';
                        echo '<td class="adminTablePad">' . $row['enterprise'] . '</td>';
                        echo '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
                        echo '<td><a href="https://www.vertrag.door42.cloud/pdf/' . $row['contract'] . '" target="_blank"> <i class="fa-regular fa-folder-open"></i> </a></td>';
                        echo '<td>' . $row['firstNameUser'] . ' ' . $row['lastNameUser'] . '</td>';
                        echo '<td>' . date("d.m.Y", strtotime($row['date'])) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    //Table ordering
    $(document).ready(function () {
        $('#adminTable').DataTable({
            ordering: true,
            columnDefs: [
                { orderable: false, targets: 2 } //Column vertrag isnt' ordable
            ],
            order: [[4, 'desc']], // Orders default by date
            paging: false,
            info: false,
        });
    });
</script>

</html>