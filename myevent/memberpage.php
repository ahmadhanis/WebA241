<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $adminemail = $_SESSION['adminemail'];
    $adminpass = $_SESSION['adminpass']; 
}else{
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php')</script>";
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    $memberid = $_GET['member_id'];
    if ($operation == "delete") {
        $sqldeletemember = "DELETE FROM `tbl_members` WHERE `member_id` = '$memberid'";
        try{
            include("dbconnect.php"); // database connection
            $conn->query($sqldeletemember);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('memberpage.php')</script>";
        }catch(PDOException $e){
            echo "<script>alert('Failed!!!')</script>";
            echo "<script>window.location.replace('memberpage.php')</script>";
        }
    }
}

//load data
$results_per_page = 9;
if (isset($_GET["pageno"])) {
    $pageno = (int) $_GET["pageno"];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

include("dbconnect.php"); // database connection

$sqlloadmembers = "SELECT * FROM `tbl_members`";
$stmt = $conn->prepare($sqlloadmembers);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$number_of_page = ceil($number_of_rows / $results_per_page);
$sqlloadmembers = $sqlloadmembers . " LIMIT $page_first_result, $results_per_page";
$stmt = $conn->prepare($sqlloadmembers);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Portal</title>
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
 
        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .w3-grid-template {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                grid-gap: 10px;
            }
        }

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            .w3-grid-template {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-gap: 10px;
            }
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {
            .w3-grid-template {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                grid-gap: 10px;
            }
        }

        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992px) {
            .w3-grid-template {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-gap: 10px;
            }
        }

        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
            .w3-grid-template {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-top w3-card" style="z-index:3;width:250px" id="mySidebar">
        <div class="w3-container w3-display-container w3-padding-16">
            <i onclick="close_menu()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
            <h3 class="w3-wide"><b>Members</b></h3>
        </div>
        <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
            <a href="mainpage.php" class="w3-bar-item w3-button">News</a>
            <a href="memberpage.php" class="w3-bar-item w3-button">Members</a>
            <a href="eventpage.php" class="w3-bar-item w3-button">Events</a>
            <a href="profilepage.php" class="w3-bar-item w3-button">profile</a>
            <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Top hamburger menu -->
    <header class="w3-bar w3-top w3-hide-large w3-xlarge">
        <div class="w3-bar-item w3-padding-24 w3-wide"></div>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="open_menu()"><i
                class="fa fa-bars"></i></a>
        <div class="w3-hide-large w3-padding-24 w3-wide w3-right">
            <h6>Members</h6>
        </div>
    </header>
    <!-- Top hamburger menu -->

    <!-- Content -->
    <div class="w3-main" style="margin-left:250px">
        <header class="w3-center w3-teal w3-padding-32">
            <h1>Members</h1>
            <p>Your One Stop Event Manager</p>
        </header>
        <div class="w3-container" style="margin:auto">
            <div class="w3-grid-template" style="padding-top:20px;padding-bottom:20px">
                <?php
                    if ($number_of_rows > 0){
                        foreach ($rows as $row) {
                            $member_id = $row['member_id'];
                            $member_email = $row['member_email'];
                            $member_name = $row['member_name'];
                            $member_phone = $row['member_phone'];
                            $member_address = $row['member_address'];
                            $member_datereg = date_format(date_create($row['member_datereg']),"d-m-Y h:i a");

                            echo "<div class='w3-card-4 w3-light-grey w3-hover-shadow'>
                                    <div class='w3-container w3-padding w3-border-bottom'>
                                        <h3 class='w3-text-blue'>$member_name</h3>
                                        <h5 class='w3-text-grey'>$member_email</h5>
                                    </div>
                                    <div class='w3-container w3-padding'>
                                        <p><strong>Phone:</strong> $member_phone</p>
                                        <p><strong>Address:</strong> $member_address</p>
                                        <p><strong>Date Registered:</strong> $member_datereg</p>
                                    </div>
                                    <div class='w3-container w3-center w3-padding'>
                                        <a href='editmember.php?member_id=$member_id' class='w3-button w3-yellow w3-hover-grey'>Edit</a>
                                        <a href='memberpage.php?submit=delete&member_id=$member_id' class='w3-button w3-red w3-hover-grey' 
                                            onclick='return confirm(\"Are you sure you want to delete this member?\")' >Delete</a>
                                    </div>
                                </div>";
                        }
                    }else{
                        echo "<p>No data found.</p>";
                    }
                ?>
            </div>
            <?php
         echo "<div class='w3-container w3-padding w3-row w3-center'>";
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "memberpage.php?pageno=' .$page .'" style= "text-decoration: none">&nbsp&nbsp' .$page ." </a>";
            }
         echo " ( " . $pageno . " )";
         echo "</div>";
        ?>
        </div>
        <footer class="w3-teal w3-padding-24">
            <p style="text-align: center">Copyright &copy; 2023 Slumberjer Event Sdn Bhd</p>
        </footer>
    </div>
    <!-- Content -->

    <script>
    function open_menu() {
        document.getElementById("mySidebar").style.display = "block";
    }

    function close_menu() {
        document.getElementById("mySidebar").style.display = "none";
    }
    </script>
</body>

</html>