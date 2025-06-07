<?php
session_start();
include('dbconnect.php');
include('header.php');

if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($dbcon, trim($_POST['username']));
	$pwd = trim($_POST['pwd']);
	$query = mysqli_prepare($dbcon, "SELECT * FROM userlogin WHERE staffid = ?");
	mysqli_stmt_bind_param($query, "s", $username);
	mysqli_stmt_execute($query);
	$result = mysqli_stmt_get_result($query);

	if ($row = mysqli_fetch_assoc($result)) {
		if (password_verify($pwd, $row['password'])) {
			$_SESSION['staffid'] = $row['staffid'];
			$_SESSION['role'] = $row['status'];

			exit();
		} else {
			$_SESSION['error'] = 'Invalid password' . $pwd;
		}
	} else {
		$_SESSION['error'] = 'Staff ID not found' . $username;
	}
}

header('Location: login.php');
exit();
