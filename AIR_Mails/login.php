<?php
if(isset($_POST['submit'])){
session_start();


$Id = trim(strtolower($_POST['email']));
$password = $_POST['pass'];

$conn = mysqli_connect("localhost","root","","projects");
$sql = "SELECT * FROM `air_mails` WHERE `email_id` = '$Id'";

$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
    if($num<=0){
        echo "<script>alert('User not exist')</script>";
        }
        else{
            $row =  mysqli_fetch_assoc($result);
                if($row['pass'] == $password){

                    $_SESSION['login_id'] = trim(strtolower($_POST['email']));
                    
                    $sql2 = "SELECT * FROM `air_mails` WHERE `email_id` = '$Id'";
                    $result2 = mysqli_query($conn,$sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $sender_name = $row2['name'];

                    $_SESSION['username']=$sender_name;
                        echo "<script>alert('Login Successful')</script>";

                    header("location:profile.php");
                }
                else{
                    echo "<script>alert('Password is wrong')</script>";
                    }
        }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url("style.css");
    </style>
    <title>AIR-mail Login</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
</script>

    <div class="main">
        <div class="navbar_main">
            <div><h1 class="Sname">AIR mail</h1>
</div>            
            <ul>
                <li><a href="">Login</a></li>
                <li><a href="index.php">Registration</a></li>
                <li><a href="profile.php">About</a></li>
            </ul>
        </div>
        <center>
        <h1 class="reg">Login</h1>
        <div class="reg_form">
            
            <div class="coiteiner">
                <form method="post">
                     
                    
                    <input type="email" placeholder="Email Id" name="email"><br>
                    <input type="password" placeholder="Password" name="pass"><br>
               
                    <button type="submit" name="submit">Submit</button>
                    <button type="reset">Reset</button>
                    
                </form>
                <div class="reg_link">
                    <a href="index.php"  class="link_text">Create new Account?</a>
                 </div>
            </div>
        </center>
        </div>
    </div>
</body>

</html>