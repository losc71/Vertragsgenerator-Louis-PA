<?php
require_once 'include/config.php';
function isAdmin()
{
    global $db;
    // check if session is set
    if (!isset($_SESSION['username'])) {
        return false;
    }
    // check if user is admin
    $query = "SELECT admin FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user['admin'] == 1) {
        return true;
    } else {
        return false;
    }
}
?>