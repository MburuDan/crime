<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
include('header.php');
include('dbconnect.php');

// Check if there's an admin in the database
$admin_check_query = "SELECT * FROM userlogin WHERE status = 'Admin' LIMIT 1";
$result = $conn->query($admin_check_query);
$admin_exists = $result->rowCount() > 0;

if(isset($_SESSION['staffid']) && isset($_SESSION['status'])){
    if($_SESSION['status']=='Admin'){
        header("Location: admin/");
        exit();
    }
    elseif($_SESSION['status']=='CID'){
        header("Location: cid/");
        exit();
    }
    elseif($_SESSION['status']=='NCO'){
        header("Location: officer/");
        exit();
    }
}

if (!$admin_exists) {
    // Show admin registration form
    ?>
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Admin Registration</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="admin/adminregister.php" method="post" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="staffid">Staff ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="staffid" placeholder="Enter Staff ID" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="surname">Surname:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fname" id="surname" placeholder="Enter Surname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="othernames">Other Names:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="oname" id="othernames" placeholder="Enter Other Names" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="password">Password:</label>
                        <div class="col-sm-10"> 
                            <input type="password" class="form-control" name="pwd" id="password" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="confirm_password">Confirm Password:</label>
                        <div class="col-sm-10"> 
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="Admin">
                    <script>
                        document.querySelector('form').addEventListener('submit', function(e) {
                            var password = document.getElementById('password');
                            var confirm_password = document.getElementById('confirm_password');
                            if (password.value != confirm_password.value) {
                                e.preventDefault();
                                alert('Passwords do not match');
                            }
                        });
                    </script>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" name="register_admin" class="btn btn-primary">Register Admin
                            <span class="glyphicon glyphicon-user"></span>
                            </button>
                        </div>
                    </div>
                </form>
                <?php
                if(isset($_SESSION['error'])){
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                if(isset($_SESSION['success'])){
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
    <?php
} else {
    // Show existing login form
    ?>
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Please Login Here</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="logincheck.php" method="post" role="form" >
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="un">Staff ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="staffid" id="un" placeholder="Enter Staff ID" autofocus="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Password:</label>
                        <div class="col-sm-10"> 
                            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter password" required="">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" name="login" class="btn btn-default">Login
                            <span class="glyphicon glyphicon-check" ></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                            if(isset($_SESSION['error'])){
                                echo "
                                    <span class='alert alert-danger text-center mt-10'>
                                        ".$_SESSION['error']." 
                                    </span>
                                ";
                                unset($_SESSION['error']);
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
    <?php
}
?>

<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

</body>
</html>
