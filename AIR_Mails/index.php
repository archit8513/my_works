<?php
if(isset($_POST['submit'])){
    $name = trim($_POST['name']." ".$_POST['last_name']);
    $email_id = trim(strtolower($_POST['email']));
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];
    $dob = $_POST['dob'];

    if($password == $cpassword){
        $conn = mysqli_connect("localhost","root","","projects");
        $sql = "INSERT INTO `air_mails`(`name`, `email_id`, `pass`, `dob`,`reg_time`) VALUES ('$name','$email_id','$password','$dob',NOW())";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo "<script>
            alert('Registration Successful');
            window.location.href='login.php';</script>";
        }else{
            echo "<script>alert('User alredy exist')</script>";
        }
}
else{
    echo "<script>alert('Password not matched')</script>";
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
    <title>AIR-mail Registration</title>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="">Registration</a></li>
                <li><a href="profile.php">About</a></li>
            </ul>
        </div>
        <center>
            <h1 class="reg">Registration</h1>
        <div class="reg_form">
            
            <div class="coiteiner">
               
                <form method="post">
                     
                    <input type="text" placeholder="Name" name="name" require><br>
                    <input type="text" placeholder="Last Name" name="last_name"><br>
                    <input type="email" placeholder="User Id" name="email" require><br>
                    <input type="password" placeholder="Password" name="pass" require><br>
                    <input type="password" placeholder="Confirm Password" name="cpass" require><br>
                    <label >Date of Birth:</label>
                    <input type="date" name="dob" class="dob_input" require><br>
                    <button type="submit" id="sub_btn" name="submit">Submit</button>
                    <button type="reset">Reset</button>
                    
                </form>
            <div class="log_link">
               <a href="login.php"  class="link_text"> Already have an account ?</a>
            </div>
            </div>
        </center>
        </div>
    </div>
</body>
<script>
</script>

</html>