<?php 

include('header.php');
include('dbconnect.php');

// Sanitize and validate input
$staffid = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$oname = filter_input(INPUT_POST, 'oname', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

// Prepare the SQL statement
if (empty($status)) {
    $sql = "UPDATE userlogin SET surname = ?, othernames = ? WHERE staffid = ?";
    $params = [$fname, $oname, $staffid];
} else {
    $sql = "UPDATE userlogin SET surname = ?, othernames = ?, status = ? WHERE staffid = ?";
    $params = [$fname, $oname, $status, $staffid];
}

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($dbcon, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo "<script type='text/javascript'>
            alert('Staff Edited Successfully');
            document.location='user.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Error: " . mysqli_stmt_error($stmt) . "');
            history.back();
        </script>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script type='text/javascript'>
        alert('Error: " . mysqli_error($dbcon) . "');
        history.back();
    </script>";
}

mysqli_close($dbcon);

 ?>
