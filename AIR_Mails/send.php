<?php

session_start();
if(isset($_POST['trash'])){
    
    $id = $_POST['id'];
    $conn = mysqli_connect("localhost","root","","projects");
    $sql = "UPDATE `emails` SET `trash`='1' WHERE `id` = '$id'";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "<script>alert('Email moved to trash.');</script>";
    }
    else{
        echo "<script>alert('Error moving email to trash.');</script>";
    }
}

if(isset($_POST['emailopen'])){

    $e_id = $_POST['single_mail_id'];
   
    $_SESSION['id_viwe'] = $e_id;
    // echo"<script>alert('$e_id');</script>";
    // echo $_SESSION['id_viwe'];
    header("location:viwe.php");
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title></title>
    <style>
        @import url("style.css");
    </style>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <div class="email_container">

    <?php 
 
    if(isset($_SESSION['login_id'])){

        $userid = $_SESSION['login_id'];
        $conn = mysqli_connect("localhost","root","","projects");
        $sql = "SELECT * FROM `emails` WHERE `sender` = '$userid' AND `trash`='0' ORDER BY `date_time` DESC";
        $result = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
        if($num > 0){
            while($row = mysqli_fetch_assoc($result))
            {

                if(strlen($_SESSION['username'])>=20){
                    $sender_name = substr($_SESSION['username'],0,20)."...";
                }
                else{
                    $sender_name = $_SESSION['username'];
                }
                if(strlen($row['subject'])>=32){
                    $subject = substr($row['subject'],0,32)."...";
                }
                else{
                    $subject= $row['subject'];
                }
                
                $message = $row['message'];
                $date_time = $row['date_time'];
                $id = $row['id'];

   
    ?>
        <div class="email_box">
            <div><input type="checkbox" class="email_check"></div>
            <form method="post">
                            <input type="hidden" value="<?php echo "$id"; ?>" name="single_mail_id">
                            <button type="submit" name="emailopen" style="display:flex;">
                                <div class="e_name">
                                    <p><?php echo "$sender_name"; ?></p>
                                </div>
                                <div class="subject">
                                    <p><?php echo "$subject" ?></p>
                                </div>
                            </button>
                        </form>
          
             
            <div class="delete_box">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <button type="submit" name="trash"><i class="bi bi-trash-fill"></i></button>
                </form>
            </div>

        </div>
    </div>

    <?php              
            }



          }
          else{
              echo "<h1 class='no_email'>No Emails.</h1>";
          }
   
  }
  else{
    header("location:login.php");
   }
  ?>
</body>

</html>