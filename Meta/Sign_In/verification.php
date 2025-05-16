<!DOCTYPE html>
<?php
include('../database/include.php');

if (isset($_SESSION['temp_email']) && isset($_SESSION['temp_otp'])) {
} else {
    echo "<script>alert('you need to login first!!')
setTimeout(window.location.href = '../log_in/login.php', 3000)
</script>";
}

$target_dir = "../profile/uploads/";
$user_mn = $_SESSION['temp_phone'];
$uploadOk = 1;

if (isset($_POST["confirm"])) {

    $OTP = $_POST['OTP'];

    $name = $_SESSION['temp_name'];
    $temp_otp = $_SESSION['temp_otp'];
    $email = $_SESSION['temp_email'];
    $password = $_SESSION['temp_password'];
    $phone = $_SESSION['temp_phone'];

    if ($OTP == $temp_otp) {

        if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<script>alert(File is not an image);</script>";
                $uploadOk = 0;
            }


            $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));

            $newfilename = $user_mn . "." . $imageFileType;
            $target_file = $target_dir . $newfilename;

            if ($imageFileType != "png") {
                // echo $imageFileType;
                echo "<script>alert(Sorry, only PNG  files are allowed.);</script>";
                $uploadOk = 0;
            }
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "<script>alert('only less then 500Kb photo allowed');</script>";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        $password = md5($password);
        $sqlquery = "INSERT INTO `metadata`(`name`, `email`, `phone`, `password`, `datetime`) VALUES ('$name','$email','$phone','$password',current_timestamp())";

        if ($con->query($sqlquery) == true) {
            echo "<script>alert('Email Verified Successfully');
            setTimeout(window.location.href = '../Sign_In/lout.php', 3000)
            </script>";
        } else {
            echo "<script>alert('Email already in use. Please try a different email address!');</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP');</script>";
    }
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='index.css'>
    <link rel="icon" type="image" href="logo_icon.png">
    <title>Email Verification</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <div class="navbar_meta">
        <div style="display: flex;"><img src="logo.png" width="60px" height="60px" class="logo" />
            <h1> Meta Connect</h1>
        </div>
    </div>

    <center>
        <div class='container'>


            <div class="profile_edit">
                <form method="POST" enctype="multipart/form-data">
                    <h1>Email Verification</h1>
                    <input type='email' class='email' id='email' name='email' placeholder="Email" value="<?php echo $_SESSION['temp_email']; ?>" disabled />
                    <input type='text' class='email' id='otp' name='OTP' placeholder="Email OTP" />
                    <div class="pro_pic">
                        <img src="y.png" alt="Profile Picture" width="100px" height="100px">
                    </div>
                    <label for="fileToUpload">Upload Picture</label><br>
                    <input type="file" name="fileToUpload" id="fileToUpload">


                    <button class='Submit' name="confirm" type="submit">Confirm</button>
                    <?php
                    ?>

                </form>
            </div>

        </div>
    </center>
</body>

</html>