<!DOCTYPE html>
<?php
include('../database/include.php');

if (isset($_POST['lsubmit']) && $_POST['g-recaptcha-response'] != "") {

    $check =0;
    $secret = '6LdtbWskAAAAAKI-t3III9XG4HpJkG72Q2gaHD59';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {


        $uname = trim($_POST['mobile_num']);
        $password = $_POST['password'];
        $password = md5($password);
    
        if (!$con) {
            echo " not connected";
        }

        $sql = "SELECT * FROM `metadata` ORDER BY `name` DESC";
        $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
    
            if ($uname == $row['phone']) {
                $check = 1;
    
                if ($password == $row['password']) {
    
                    echo "<p class ='ans' > Your login succesful !!</p>";
                    $_SESSION['mobile_num'] = $uname;
                    date_default_timezone_set("Asia/Calcutta");
                    setcookie('uname', $row['name'], time() + 3600, '/');
                    $_SESSION['user_id'] = $row['u_id'];
                    header("Location: ../profile/profile.php");
                    exit();
                    break;
                } else {
                    if ($check == 1) {
                        echo "<script>window.onload = function(){
                            document.getElementById('error').innerHTML = 'Wrong Password';}</script>";
                        break;
                    }
                    echo "<script>window.onload = function(){
                        document.getElementById('error').innerHTML = 'Username Not Found';}</script>";
                    break;
                }
            }
        }
        if (!$check) {
            echo "<script>window.onload = function(){
                document.getElementById('error').innerHTML = 'Username Not Found';}</script>";
        }

            
        
    } else {
        echo "<script>alert('Capcha Error');</script>";
    }
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
    <title>Log In</title>
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


            <h1>Log In</h1>
            <form method="POST">
                <p class="error" id="error"></p>
                <input type='text' class='name' id='name' name='mobile_num' placeholder="Mobile Number" required oninput="velidmn()">
                <input type='password' class='password' id='password' name='password' placeholder="Password" required>

                <a href='../index.php' class='acc'>If do not have account ? Make one.</a>
                <div class="g-recaptcha" data-sitekey="6LdtbWskAAAAAJ7JClJlHbT12Xc-NcVqhDuFe_KO"></div>
                <br />
                <button class='submit' type="submit" name="lsubmit">Login</button>


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

        if (val.length > 10) {
            mobile_n.value = val.substring(0, 10);

        }
        var is = (/\d$/g).test(val);

        if (!is) {
            mobile_n.value = val.substring(0, len - 1);
        }
    }

    
</script>

</html>

<?php
if (isset($_POST['lsubmit']) && $_POST['g-recaptcha-response'] == "") {
    echo "<script>document.getElementById('error').innerHTML = 'Please Check the Capcha';</script>";
}
?>