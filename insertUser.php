<?php
require_once 'include/config.php';

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$firstNameUser = $data['firstNameUser'];
$lastNameUser = $data['lastNameUser'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$admin = $data['admin'];

$query = "INSERT INTO users (username, firstNameUser, lastNameUser, password, admin) VALUES (:username, :firstNameUser, :lastNameUser, :password, :admin)";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':firstNameUser', $firstNameUser);
$stmt->bindParam(':lastNameUser', $lastNameUser);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':admin', $admin);
$stmt->execute();
 ?>