<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $adminemail = $_SESSION['adminemail'];
    $adminpass = $_SESSION['adminpass']; 
}else{
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php')</script>";
}

if (isset($_GET['newsid'])) {
    $newsid = $_GET['newsid'];
}else{
    echo "<script>alert('Error');</script>";
    echo "<script>window.location.replace('mainpage.php')</script>";
}

$sqlloadnews = "SELECT * FROM `tbl_news` WHERE `news_id` = '$newsid'";

include("dbconnect.php"); // database connection
$stmt = $conn->prepare($sqlloadnews);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($number_of_rows > 0) {
    $newstitle = $rows[0]['news_title'];
    $newsdetails = $rows[0]['news_content'];
    $newsdate = date_format(date_create($rows[0]['news_date']),"d-m-Y h:i a");
    $newsfilename = $rows[0]['news_filename'];
}
?>

<html>

<head>
    <title>News Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header class="w3-container w3-black">
        <h1>News Details</h1>
    </header>
    <div class="w3-container" style="max-width: 800px;margin:auto">
        <br>
        <form action="newsdetails.php" method="POST" enctype="multipart/form-data">
            <div class="w3-container w3-center">
                <img src="uploads/<?php echo $newsfilename; ?>" alt="News Image" style="width: 40%">
            </div>
            <div style="height: 20px"></div>
            <input class="w3-input w3-border w3-round" type="text" name="title" required placeholder="Title"
                value="<?php echo $newstitle; ?>">
            <p>Date: <?php echo $newsdate; ?></p>
            <textarea class="w3-input w3-border w3-round" name="content" required placeholder="News Content" rows="10"
                cols="50"><?php echo $newsdetails; ?></textarea>
            <p>
                <label for="myfileid">Select a file (png):</label>
                <input type="file" id="myfileid" name="newsfile" accept=".png" required>
            </p>
            <br>
            <input class="w3-input w3-border w3-button w3-teal w3-round" type="submit" name="update"
                value="Update News">
        </form>
        <br>
    </div>
    <footer class="w3-teal w3-bottom">
        <p style="text-align: center">Copyright &copy; 2023 Slumberjer Event Sdn Bhd</p>
    </footer>
</body>

</html>