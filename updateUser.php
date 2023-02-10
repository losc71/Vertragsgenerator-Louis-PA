<?php
require_once 'include/config.php';

// Check if the form was submitted
if (isset($_POST['username'])) {
    // Retrieve the data from the form
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $firstNameUser = $_POST['firstNameUser'];
    $lastNameUser = $_POST['lastNameUser'];
    $admin = isset($_POST['admin']) ? 1 : 0;




    // Update the user's data in the database
    $query = "UPDATE users SET username = :username, firstNameUser = :firstNameUser, lastNameUser = :lastNameUser, admin = :admin WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':firstNameUser', $firstNameUser);
    $stmt->bindParam(':lastNameUser', $lastNameUser);
    $stmt->bindParam(':admin', $admin);
    if (!$stmt->execute()) {
        $error = $stmt->errorInfo();
        echo "Error: SQLSTATE: " . $error[0] . " Driver-specific error code: " . $error[1] . " Driver-specific error message: " . $error[2];
    }
    

    // Redirect the user back to the user panel
    header("Location: userPanel.php");
    exit();
}
?>

 
        
