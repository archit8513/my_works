
<?php
   $check = false;
if(isset($_POST['name'])){
 
    $con = mysqli_connect("localhost","root","");


    $name = $_POST['name'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $phone = $_POST['phone'];
    $cpassword = $_POST['cpassword'];

    

    if($password==$cpassword){
        $sqlquery = "INSERT INTO `projects`.`metadata`(`name`, `email`, `phone`, `password`, `datetime`) VALUES ('$name','$email','$phone','$password',current_timestamp())";

        if($con->query($sqlquery)==true) {
             $check = true;
        }
        else {
            echo "<p class='response'>Insertion problem has been faced .</p>";
        }
        $con->close();
        }
    else{

         echo "<p class ='err'>password not match!! <p>";

    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='asas.css'>
    <title>Log In/Sign In</title>
</head>
<body>
    
<div class="navbar"> 
        <h1>Meta Connect</h1>
        <ul>
        <li><a class='option' href='http://localhost/website/main/Homepage.html' >Home</a></li>
            
            <li><a class='option' href='http://localhost/website/log_in/login.php' >Login</a></li>
            <li><a class='option' href='http://localhost/website/Sign_In/index.php' >Sign Up</a></li>
            <li><a class='option' href='#' >About Us</a></li>
            <li><a class='option' href='#' >Help</a></li>
            
        </ul>
</div>
    
    
    <div class='container'>
        
    <center>
    <form method="POST" action='index.php'>
        <input type='text' class='name' id='name' name='name' placeholder="Enter your name">
        <input type='text' class='email' id='email' name='email' placeholder="Enter your email">
        <input type='text' class='phone' id='phone' name='phone' placeholder="Enter your phone">
        <input type='password' class='password' id='password' name='password' placeholder="Create password">
        <input type='password' class='password' id='Cpassword' name='cpassword' placeholder="Confirm password">
        
        <a href='http://localhost/website/log_in/login.php' class ='acc'>Already have an account ?</a> 
        <button class='Submit'>Submit</button>
        <?php
        if($check){
            echo "<p class = 'response'>  Your Registration is successful!!</p>";
        }
        ?>
        
    </form>
</center>
    </div>
</body>
</html>
