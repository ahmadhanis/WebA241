<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
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
            <p class="">Remember Me &nbsp;&nbsp;&nbsp;<input type="checkbox" name="rememberme" id="checkboxid"></p>
            <input class="w3-input w3-round w3-button w3-teal" type="submit" value="Login">
        </form>
    </div>
    <div class="" style="height:200px">
    </div>
    <footer class="w3-container w3-grey">
        <p style="text-align: center">
            Copyright &copy; 2023 Slumberjer Event Sdn Bhd
        </p>
    </footer>
</body>

</html>