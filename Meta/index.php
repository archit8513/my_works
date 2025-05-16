<!DOCTYPE html>
<?php
include('database/include.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

function check_pass($pass, $cpass, $pn)
{
    $check = false;

    if ($pass == $cpass and $pass and $cpass) {
        if (strlen($pn) != 10) {
            echo "<script>window.onload = function(){
            document.getElementById('error').innerHTML = 'Invalid Phone Number';}</script>";
        } else {
            $check = true;
        }
    } else {

        echo "<script>
        window.onload = function(){document.getElementById('error').innerHTML = 'Password Does Not Match';}</script>";
        $check = false;
    }
    return $check;
};

// email sent
if (isset($_POST['f_submit']) && $_POST['g-recaptcha-response'] != "") {

    $secret = 'captcha_secret';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {

        //first validate then insert in db
        // echo "Your registration has been successfully done!";



        $_SESSION['temp_name'] = $_POST['name'];
        $_SESSION['temp_email'] = trim(strtolower($_POST['email']));
        $password = $_SESSION['temp_password'] = $_POST['password'];
        $phone = $_SESSION['temp_phone'] = $_POST['phone'];
        $cpassword = $_SESSION['temp_cpassword'] = $_POST['cpassword'];

        if (check_pass($password, $cpassword, $phone)) {
            $email = trim(strtolower($_POST['email']));


            $name = $_POST['name'];
            $to = $email;

            $ot_pass = password_generate(6);
            $_SESSION['temp_otp'] = $ot_pass;



            try {

                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com;';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'youremail@gmail.com';
                $mail->Password   = 'yourpass';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('test@info.com', 'Meta Connect');
                $mail->addAddress($to, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification OTP | Meta Connect';
                $mail->Body    = '<p><b>Dear ' . $name . ',</b></p><br>
                              <p> Your registration is Done!<br>
                              Your Email verification OTP is : ' . $ot_pass . ' </p>                         
                              <p>you can now login to your Account.</p>
                              <p>Regards,<br>
                              <b>Meta Connect</b></p>';
                $mail->send();
                echo "<script>alert('Email verification OTP has been sent!');";
                echo "window.location.href='Sign_In/verification.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                echo "window.location.href='index.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Capcha Error');</script>";
    }
}

function password_generate($chars)
{
    $data = '1234567890';
    return substr(str_shuffle($data), 0, $chars);
}

?>

<html lang="en">

<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="Sign_In/logo_icon.png">
    <style>
        @import url("Sign_In/index.css");
    </style>
    <title>Sign Up</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <div class="navbar_meta">
        <div class="logo_name">
            <img src="Sign_In/logo.png" width="60px" height="60px" class="logo" />
            <h1> Meta Connect</h1>
        </div>


        <div class="dropdown setting_ic">
            <a class="setting_ic" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </a>

            <ul class="dropdown-menu mt-md-2">
                <li><a class="dropdown-item" href='log_in/login.php'>Login</a></li>
                <li><a class="dropdown-item" href='index.php'>Sign Up</a></li>
                <li><a class="dropdown-item" href='log_in/forgetpass.php'>Forget Password</a></li>

            </ul>
        </div>


    </div>

    <center>
        <div class='container'>


            <h1>Sign Up</h1>
            <p class="error" id="error"></p>
            <form method="POST">
                <input type='text' class='name' id='name' name='name' placeholder="Name" oninput="velidname()" onfocusout="edit()" />
                <input type='email' class='email' id='email' name='email' placeholder="Email" />
                <input type='text' class='phone' id='phone' name='phone' placeholder="Mobile Number" oninput="velidmn()" />
                <input type='password' class='password' id='password' name='password' placeholder="Create password" oninput="velidpass(password)" />
                <input type='password' class='password' id='Cpassword' name='cpassword' placeholder="Confirm password" oninput="velidpass(cpassword)" />

                <p class="pass_err" id="pass_err"></p>
                <a href='log_in/login.php' class='acc'>Already have an account ?</a>
                <div class="g-recaptcha" data-sitekey="6LdtbWskAAAAAJ7JClJlHbT12Xc-NcVqhDuFe_KO"></div>
                <br/>
                <button class='Submit' onclick='' formtarget="_self" name="f_submit" onclick="return confirm('Confirm Your registrastion?');">Submit</button>
               
                <?php
                if (isset($_POST['f_submit'])) {
                    if (check_pass($_POST['password'], $_POST['cpassword'], $_POST['phone'])) {
                    } else {
                        echo "<p class='response'>Invalid Credentials</p>";
                    }

                    if($_POST['g-recaptcha-response'] == ""){
                        echo "<script>document.getElementById('error').innerHTML = 'Please Check the Capcha';</script>";
                    }
                }
                
                ?>

            </form>

        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

</body>
<script>
    function velidmn() {

        var mobile_n = document.getElementById("phone");
        var val = mobile_n.value;
        var len = val.length;

        if (val.length > 10) {
            mobile_n.value = val.substring(0, 10);

        }
        var is = (/\d$/g).test(val);

        if (!is) {
            mobile_n.value = val.substring(0, len - 1);
        }
    }

    function velidname() {

        var name = document.getElementById("name");
        var val = name.value;
        var len = val.length;


        if (len > 22) {
            name.value = val.substring(0, 22);

        }
        var is = (/[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\0-9]/).test(val);
        if (is) {
            name.value = val.substring(0, len - 1);
        }
    }

    function edit() {
        var name = document.getElementById("name");
        var val = name.value;
        var len = val.length;

        var is = (/[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\0-9]/).test(val);
        if (is) {
            name.value = "";
        }
    }

    function velidpass(pass) {
        var err = document.getElementById("pass_err");
        var val = pass.value;
        var len = val.length;
        // console.log(len);
        if (len > 22) {
            pass.value = val.substring(0, 22);
            err.innerHTML = "Password must be less than 22 characters";

        } else {
            err.innerHTML = "";
        }
    }
</script>

</html>