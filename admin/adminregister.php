<?php
require_once('../database/Database.php');
$db = new Database(); 

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('dbconnect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $password = $_POST['pwd']; 
    $status = $_POST['status']; 
    $username = $_POST['username']; 
    $fname = $_POST['fname'];
    $oname = $_POST['oname'];
   
    // Hash the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $sql = "INSERT INTO userlogin (status, password, staffid, surname, othernames)
            VALUES (?, ?, ?, ?, ?)";

    // Use prepared statement
    $stmt = $dbcon->prepare($sql);
    $stmt->bind_param("sssss", $status, $hashed_password, $username, $fname, $oname);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "Admin user registered successfully";
        $_SESSION['message_type'] = "success";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Error registering admin user: " . $stmt->error;
        $_SESSION['message_type'] = "error";
        header("Location: ../index.php");
        exit();
    }

    $stmt->close();
} else {
    // If accessed directly without form submission, redirect to index
    header("Location: ../index.php");
    exit();
}
?>
