<?php
if (isset($_POST['submit'])) {
    $email = $_POST['useremail'];
    $passwordraw = $_POST['password'];
    $password = sha1($passwordraw);
    $sqllogin = "SELECT  `admin_email`, `admin_password` FROM `tbl_admins` WHERE `admin_email` = '$email' AND `admin_password` = '$password'";
    
    try{
        include("dbconnect.php"); // database connection
        $stmt = $conn->prepare($sqllogin);
        $stmt->execute();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            session_start();
            $_SESSION['sessionid'] = session_id();
            $_SESSION['adminemail'] = $email;
            $_SESSION['adminpass'] = $passwordraw;
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }else{
            echo "<script>alert('Failed')</script>";
        }
    }catch(PDOException $e){
        echo "<script>alert('Failed!!!')</script>";
    }
}
?>

<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body onload="loadData()">
    <header class="w3-center w3-padding-32 w3-teal">
        <div class="w3-margin">
            <h1>Slumberjer Event Sdn Bhd</h1>
            <h3>Your One Stop Event Manager</h3>
        </div>
    </header>
    <div class="w3-hide-small" style="height:100px">
    </div>
    <div class="w3-container" style="max-width: 600px;margin:auto">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <input class="w3-input w3-round w3-border" type="text" id="useremailid" name="useremail"
                placeholder="Enter Email" required><br>
            <input class="w3-input w3-round w3-border" type="password" id="passwordid" name="password"
                placeholder="Enter Password" required><br>
            <p class="">Remember Me &nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="rememberme" id="checkboxid" onclick="rememberMe()">
            </p>
            <input class="w3-input w3-round w3-button w3-teal" type="submit" name="submit" value="Login">
        </form>
    </div>
    <div class="w3-center w3-container">
        <a href="registration.php">Register</a>
    </div>
    <div class="" style="height:200px">
    </div>
    <footer class="w3-container w3-grey">
        <p style="text-align: center">
            Copyright &copy; 2023 Slumberjer Event Sdn Bhd
        </p>
    </footer>
</body>

<script>
function rememberMe() {
    if (document.getElementById('checkboxid').checked) {
        var useremail = document.getElementById('useremailid').value;
        var password = document.getElementById('passwordid').value;
        var remember = document.getElementById('checkboxid').value;
        localStorage.setItem('useremail', useremail);
        localStorage.setItem('password', password);
        localStorage.setItem('remember', remember);
        alert('Success');
    } else {
        localStorage.removeItem('useremail');
        localStorage.removeItem('password');
        localStorage.removeItem('remember');
        document.getElementById('useremailid').value = '';
        document.getElementById('passwordid').value = '';
        document.getElementById('checkboxid').checked = false;
        alert('Removed')
    }
}

function loadData() {
    document.getElementById('useremailid').value = localStorage.getItem('useremail');
    document.getElementById('passwordid').value = localStorage.getItem('password');
    document.getElementById('checkboxid').checked = localStorage.getItem('remember');
}
</script>

</html>