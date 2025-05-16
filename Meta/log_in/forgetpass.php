<!DOCTYPE html>
<?php
include('./../database/include.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
$mail = new PHPMailer(true);

if (isset($_POST['fpass_submit']) && $_POST['g-recaptcha-response'] != "") {

    $secret = 'captcha secret';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {



        $mobile_n = $_POST['mobile_num'];
        $email = trim(strtolower($_POST['user_email']));

        $sql = "SELECT * FROM `metadata` WHERE `email`='$email' and `phone` ='$mobile_n'";
        $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $pass = $row['password'];
            $to = $email;

            $new_pass = password_generate(8);
            $new_pass_hash = md5(trim($new_pass));



            try {

                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com;';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'test@gmail.com';
                $mail->Password   = 'yourpassword';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('test@gmail.com', 'Meta Connect');
                $mail->addAddress($to, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Password Recovery for Meta Connect';
                $mail->Body    = '<p><b>Dear ' . $name . ',</b></p><br>
                                <p> Forgot Password? No problem! <br>
                                Your New login Password is : ' . $new_pass . ' </p>                         
                                <p>you can change your password after login using this password and resume your journey.</p>
                                <p>Regards,<br>
                                <b>Meta Connect</b></p>';
                $mail->send();

                $update_sql = "UPDATE `metadata` SET `password`='$new_pass_hash' WHERE `email`='$email' AND `phone`='$mobile_n'";
                $result1 = mysqli_query($con, $update_sql);

                echo "<script>alert('Mail has been sent successfully!');";
                echo "window.location.href='../log_in/login.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                echo "window.location.href='../log_in/login.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Capcha Error');</script>";
    }
}

function password_generate($chars)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($data), 0, $chars);
}

?>


<html lang="en">

<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url("LogIn.css");
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
    <title>Forget Password</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <div class="navbar_meta">
        <div class="logo_name">
            <img src="logo.png" width="60px" height="60px" class="logo" />
            <h1> Meta Connect</h1>
        </div>

        <div class="dropdown setting_ic">
            <a class="setting_ic" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </a>

            <ul class="dropdown-menu mt-md-2">
                <li><a class="dropdown-item" href='../log_in/login.php'>Login</a></li>
                <li><a class="dropdown-item" href='../index.php'>Sign Up</a></li>
                <li><a class="dropdown-item" href='../log_in/forgetpass.php'>Forget Password</a></li>

            </ul>
        </div>

    </div>
    <center>
        <div class='container'>


            <h1>Forget Password</h1>
            <form method="POST">
                <p class="error" id="error"></p>
                <input type='text' class='name' id='name' name='mobile_num' placeholder="Mobile Number" required maxlength="10" oninput="velidmn()">
                <input type='email' class='email' id='email' name='user_email' placeholder="Email" required>

                <a href='../index.php' class='acc'>If do not have account ? Make one.</a>
                <div class="g-recaptcha" data-sitekey="6LdtbWskAAAAAJ7JClJlHbT12Xc-NcVqhDuFe_KO"></div>
                <br/>
                <button class='submit' type="submit" name="fpass_submit" onclick="return confirm('Are you sure you want to Reset your password!!');">Submit</button>


            </form>

        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

</body>
<script>
    function velidmn() {

        var mobile_n = document.getElementById("name");
        var val = mobile_n.value;
        var len = val.length;

        var is = (/\d$/g).test(val);

        if (!is) {
            mobile_n.value = val.substring(0, len - 1);
        }
    }
</script>

</html>

<?php
if (isset($_POST['fpass_submit']) && $_POST['g-recaptcha-response'] == "") {
    echo "<script>document.getElementById('error').innerHTML = 'Please Check the Capcha';</script>";
}

?>