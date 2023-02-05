<?php
session_start();

if (isset($_SESSION['login_id'])) {
    $userid = $_SESSION['login_id'];

    if (isset($_POST['send'])) {
        $to = trim(strtolower($_POST['receiver_id']));
        $subject = $_POST['subject'];
        $message = $_POST['mesg'];

        $var = explode("@", $to);
        date_default_timezone_set('Asia/Kolkata');
        $var2 = time();
        $mail_id = trim(strtolower($var2 . "@" . $var[0]));

        $conn = mysqli_connect("localhost", "root", "", "projects");
        $sql = "INSERT INTO `emails`(`id`, `sender`, `receiver`, `message`, `subject`, `date_time`) VALUES ('$mail_id','$userid','$to','$message','$subject',now())";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Mail Sent')</script>";
        } else {
            echo "<script>alert('Mail not Sent')</script>";
        }
    }

    if (isset($_POST['alldelete'])) {
        $del_id = $_SESSION['login_id'];
        echo "<script>
                    console.log( document.cookie);</script>";


        if (isset($_COOKIE['temp'])) {
            $yes_no = $_COOKIE['temp'];
        } else {
            $yes_no = false;
        }
        
        if ($yes_no == 'true') {

            $conn = mysqli_connect("localhost", "root", "", "projects");
            $sql = "UPDATE `emails` SET `r_trash`='1' WHERE `receiver` = '$del_id'";
            $sql1 = "UPDATE `emails` SET `trash`='1' WHERE `sender` = '$del_id'";
            $result = mysqli_query($conn, $sql);
            $result1 = mysqli_query($conn, $sql1);
            if ($result && $result1) {
                echo "<script>alert('ALL mail deleted')</script>";
            } else {
                echo "<script>alert('Not deleted')</script>";
            }
            $conn->close();
            date_default_timezone_set('Asia/Kolkata');
        } else {
            date_default_timezone_set('Asia/Kolkata');
            // setcookie('temp','', time()-3600);

        }
    }
} else {
    header("location:login.php");
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url("style.css");
    </style>
    <title>Desktop</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <div class="new_mail" id="new_mail">
        <div style="display: flex;">
            <h2 style="margin-left:15px;">New Email</h2>
            <div onclick="toback()">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" style="margin-left:584px;cursor:pointer;">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </div>
        </div>
        <form method="POST">

            <hr>
            <lable for="name">To:</lable><input type="email" name="receiver_id" id="name" /><br>
            <hr>
            <lable for="subject">Subject:</lable><input type="text" name="subject" id="subject" /><br>
            <hr>
            <lable for="name">Message:</lable><br><textarea type="text" placeholder="Message" name="mesg"></textarea><br>
            <hr>
            <button type="submit" name="send">Send</button>
            <button type="reset">Clear</button>
        </form>
    </div>

    <div class="main">
        <div class="navbar_main">
            <div>
                <h1 class="Sname">AIR mail</h1>
            </div>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="index.php">Registration</a></li>
                <li><a href="about.html">About</a></li>
            </ul>
        </div>

        <div class="usernamediv">

            <div class="user_profile">
                <img src="x.png" alt="" height="40px" width="40px">
            </div>
            <div class="usernametext">
                <h3><?php echo "$userid" ?></h3>
            </div>
            <div class="logout">
                <a href="logout.php"><i class="bi bi-power"></i> </a>
            </div>

        </div>
        <div class="screen">
            <div class="menu">
                <div class="menu_item" onclick="change(this)" id="inbox">
                <a href="emails.php" target="iframe"><p class="menu_text">All Inboxs</p></a>
                </div>
                <div class="menu_item" onclick="change(this)" id="send">
                <a href="send.php" target="iframe"><p class="menu_text">Send</p></a>
                </div>
                <div class="menu_item" onclick="change(this)" id="trash">
                <a href="trash.php" target="iframe"><p class="menu_text">Trash</p></a>
                </div>

                <button type="button" class="compose_btn" onclick="newemail()">Compose</button>

            </div>
            <div class="mail">
                <div class="topbar">
                    <input type="checkbox" class="allselect"><label class="allselect_text">All select</label>
                    <div class="alldelete_box">
                        <form method="post">
                            <button type="submit" name="alldelete" onclick="fun();"><i class="bi bi-trash-fill"></i></button>
                        </form>
                        <p>Delete All</p>
                    </div>
                </div>
                <div class="air_mails">
                    <iframe src="emails.php" frameborder="0" height="100%" width="100%" name="iframe"></iframe>
                </div>

            </div>
        </div>
    </div>

</body>

<script>
    var newmail = document.getElementById('new_mail');

    function newemail() {
        newmail.style.display = "block";
        console.log("new adeed");
    }

    function toback() {
        newmail.style.display = "none";
        console.log("to back");
    }

    function fun() {
        var yes_no = confirm('Are you sure to delete this mail?');
        if (yes_no == true) {
            document.cookie = 'temp=' + yes_no;
        } else {
            document.cookie = 'temp=' + yes_no;
        }
    }

    function change(id) {

        var x = document.getElementsByClassName('menu_item');
        var len = x.length;

        for (var i = 0; i < len; i++) {
            x[i].style.backgroundColor = "rgb(8, 161, 110)";
        }
        id.style.backgroundColor = "rgb(2, 86, 58)";

    }
</script>

</html>