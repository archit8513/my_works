

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='stylesheet' href='as.css'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
<form method="POST">
    <input type='text' class='name' id='name' name='name' placeholder="Enter your phone number">
    <input type='password' class='password' id='password' name='password' placeholder="Enter password">

    <a href='http://localhost/website/Sign_In/index.php' class = 'acc'>If do not have account ? Make one.</a> 
    <button class='submit'>Login</button>
    
   
</form>
</center>
</div>
</body>
</html>

<?php
 $check = 0;


if(isset($_POST['name'])) {
    

$con = mysqli_connect("localhost","root","");

$uname = $_POST['name'];
$password = $_POST['password'];


if(!$con) {
    echo " not connected";
}


$sql ="SELECT * FROM `projects`.`metadata` ORDER BY `name` DESC";
$result = mysqli_query($con,$sql);

$num= mysqli_num_rows($result);
    while ($row= mysqli_fetch_assoc($result)) {
        
        if($uname==$row['phone']) { 
            $check=1;
            if($password==$row['password']) {
            
                echo "<p class ='ans' > Your login succesful !!</p>";
                break;
            }
            else{
                if($check==1){
                    echo "<p class ='ans' > wrong password </p>";
                    break;
                }
                echo "<p class ='ans' > wrong username </p>";
                break;
            }   
        }    
}
    if(!$check){
        echo "<p class ='ans' > wrong username </p";
    }
}

?>



