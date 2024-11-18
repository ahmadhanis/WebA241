<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $adminemail = $_SESSION['adminemail'];
    $adminpass = $_SESSION['adminpass']; 
}else{
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php')</script>";
}

//form data handler
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $filename = "news-" . date("dmY")."-". randomString(5).".png";
    $target_dir = "uploads/";
    $target_file = $target_dir . $filename ;
   
    $sqlinews = "INSERT INTO `tbl_news`(`news_title`, `news_content`, `news_filename`) VALUES ('$title',' $content','$filename')";
    try{
        include("dbconnect.php"); // database connection
        $conn->query($sqlinews);
        move_uploaded_file($_FILES["newsfile"]["tmp_name"], $target_file);
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    }catch(PDOException $e){
        echo "<script>alert('Failed!!!')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    }
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    $newsid = $_GET['newsid'];
    if ($operation == "delete") {
        $sqldeletenews = "DELETE FROM `tbl_news` WHERE `news_id` = '$newsid'";
        try{
            include("dbconnect.php"); // database connection
            $conn->query($sqldeletenews);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }catch(PDOException $e){
            echo "<script>alert('Failed!!!')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }
    }
}

//load data

include("dbconnect.php"); // database connection
$sqlloadnews = "SELECT * FROM `tbl_news`";
$stmt = $conn->prepare($sqlloadnews);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

function randomString($length = 10)
{
    $characters =
        "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function truncate($string, $length, $dots = "...")
{
    return strlen($string) > $length
        ? substr($string, 0, $length - strlen($dots)) . $dots
        : $string;
}

//form data handler


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Portal</title>
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-top w3-card" style="z-index:3;width:250px" id="mySidebar">
        <div class="w3-container w3-display-container w3-padding-16">
            <i onclick="close_menu()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
            <h3 class="w3-wide"><b>News</b></h3>
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
            <h6>News</h6>
        </div>
    </header>
    <!-- Top hamburger menu -->

    <!-- Content -->
    <div class="w3-main" style="margin-left:250px">
        <header class="w3-center w3-teal w3-padding-32">
            <h1>News</h1>
            <p>Your One Stop Event Manager</p>
        </header>
        <div class="w3-right w3-bar-item">
        <button class="w3-button w3-teal w3-round w3-margin"
        onclick="document.getElementById('idabout').style.display='block'">About</button>

            <button class="w3-button w3-teal w3-round w3-margin"
                onclick="document.getElementById('id01').style.display='block'">New News</button>
        </div>
        <div style="height:80px"></div>
            <!-- table section  -->
            <div class="w3-container" style="height: 1200px;margin:auto;overflow-y: auto">
                <?php
                if($number_of_rows > 0){
                    echo "<table class='w3-table-all'>";
                    echo "<tr><th>No</th><th>Title</th><th>Content</th><th>Date</th><th>Action</th></tr>";
                    $i =1;
                    foreach ($rows as $news) { //array traversal
                        $newsid = $news['news_id'];
                        $newstitle = $news['news_title'];
                        $newscontent = truncate($news['news_content'],250);
                        $newsfilename = $news['news_filename'];
                        $newsdate = date_format(date_create($news['news_date']),"d-m-Y h:i a");
                        echo "<tr>
                                <td>$i</td>
                                <td>$newstitle</td>
                                <td>$newscontent</td>
                                <td>$newsdate</td>
                                <td>
                                <a href='editnews.php?newsid=$newsid' class='w3-button w3-round w3-green'  >&nbsp;Edit&nbsp;&nbsp;</a>
                                <div style='margin-bottom:5px'></div>
                                <a href='mainpage.php?submit=delete&newsid=$newsid' class='w3-button w3-round w3-red' onclick=\"return confirm ('Delete this news no $i?');\" >Delete</a>
                                <div style='margin-bottom:5px'></div>
                                <a href='' class='w3-button w3-round w3-yellow' >&nbsp;View&nbsp;</a>
                                </td>
                            </tr>";
                        $i++;
                    }
                    echo "</table>";
                }
            ?>
            </div>

            <footer class="w3-teal w3-padding-24">
                <p style="text-align: center">Copyright &copy; 2023 Slumberjer Event Sdn Bhd</p>
            </footer>
        </div>
        <!-- Content -->

        <!-- modal window -->
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-teal">
                    <span onclick="document.getElementById('id01').style.display='none'"
                        class="w3-button w3-display-topright  fa fa-close"></span>
                    <h2>New News</h2>
                </header>
                <div class="w3-container">
                    <br>
                    <form action="mainpage.php" method="POST" enctype="multipart/form-data">
                        <input class="w3-input w3-border w3-round" type="text" name="title" required
                            placeholder="Title"><br>
                        <textarea class="w3-input w3-border w3-round" name="content" required placeholder="News Content"
                            rows="10" cols="50"></textarea>
                        <p>
                            <label for="myfileid">Select a file (png):</label>
                            <input type="file" id="myfileid" name="newsfile" accept=".png" required>
                        </p>
                        <br>
                        <input class="w3-input w3-border w3-button w3-teal w3-round" type="submit" name="submit"
                            value="Insert News">
                    </form>
                    <br>
                </div>
                <footer class="w3-container w3-teal w3-center">
                    <p>Slumberjer Event</p>
                </footer>
            </div>
        </div>
        <!-- modal window -->

        <div id="idabout" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-teal">
                    <span onclick="document.getElementById('idabout').style.display='none'"
                        class="w3-button w3-display-topright  fa fa-close"></span>
                    <h3>About App</h3>
                </header>
                <div class="w3-container w3-padding">
                    <p>This application develop for Slumberjer Event Sdn Bhd<p>
                </div>
            </div>
        </div>

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