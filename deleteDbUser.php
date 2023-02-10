<?php
require_once 'include/config.php';

$userId = $_POST['user_id'];

$query = "DELETE FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
?>
