<!DOCTYPE html>
<?php
include('../database/include.php');
// cheaking if user is liked  or not
function user_check($str1, $str2,$con)
{

    $likeduserid = $_SESSION['user_id'];


    $sql = "SELECT * FROM `tweets` WHERE `date_time`='$str1' and `name`='$str2'";
    $result_check = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result_check);

    if ($num == 1) {
        $row_check = mysqli_fetch_assoc($result_check);
        $likes = $row_check['user_like'];
        $array = explode("|", $likes);
        $flag = true;
        foreach ($array as $value) {
            if ($value == strval($likeduserid)) {
                $flag = false;
                break;
            }
        }
    }
    return $flag;
};

// password change
if (isset($_POST['pass_submit'])) {


    $userid = $_COOKIE['uname'];
    $user_mn = $_SESSION['mobile_num'];
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $cnewpass = $_POST['cnewpass'];
    if ($newpass != "" && $cnewpass != "" && $oldpass != "") {
        if ($newpass == $cnewpass) {
            $oldpass = md5($oldpass);
            $newpass = md5($newpass);
            $sql = "UPDATE `metadata` SET `password`='$newpass' WHERE `name`='$userid' AND `phone`='$user_mn' AND `password`='$oldpass'";
            $result = mysqli_query($con, $sql);
            
                if (mysqli_affected_rows($con)>0) {
                    echo "<script>alert('Password changed')</script>";
                    header("Refresh:0");
                }
             else {
                echo "<script>alert('Wrong Current Password')</script>";
            }
        } else {
            echo "<script>alert('Password not matched')</script>";
        }
    }
}

if(isset($_SESSION['mobile_num']) && file_exists('uploads/'.$_SESSION['mobile_num'].'.png')){
    $img = 'uploads/'.$_SESSION['mobile_num'].'.png';
}else{
    $img = 'y.png';
}


?>




<html>

<head>
    <!-- <link rel="stylesheet" href="profile.css"> -->
    <style>
        @import url("profile.css");
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
    <title>Profile</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>


    <!-- change password-->
    <div class="editname" id="old_pass">
        <div>
            <h1 style="margin-left:20px;">Meta Connects</h1>
            <div onclick="pass_toback()">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </div>
        </div>

        <form method="POST">
            <h3 style="margin-top: 30px;">Edit Password</h3>
            <input type="password" placeholder="Current Password" name="oldpass" /><br>
            <input type="text" placeholder="New Password" name="newpass" maxlength="22"/><br>
            <input type="text" placeholder="Confirm Password" name="cnewpass" maxlength="22"/><br>
            <button type="submit" name="pass_submit">Change</button>
            <button type="reset">Clear</button>
        </form>
    </div>
    <!-- Username and feed -->
    <div>
        <div class="username_div">
        <div class="logo_name">
            <a href="../profile/profile.php"><img src="<?php echo $img ?>" width="44px" height="44px"></a>

            <h1>
                <?php
                if (isset($_SESSION['mobile_num'])) {
                    echo $_COOKIE['uname'];
    
                } else {
                    echo "<script>alert('you need to login first!!')
               setTimeout(window.location.href = '../log_in/login.php', 3000)
               </script>";
                }
                ?>
            </h1>
        </div>
            <div class="dropdown setting_ic">
                <a class="setting_ic" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </a>

                <ul class="dropdown-menu mt-md-2">
                    <li><a class="dropdown-item" href="../profile/feed.php">Feed</a></li>
                    <li><a class="dropdown-item" herf="" onclick="changepass()">Change password</a></li>
                    <li><a class="dropdown-item" href="../profile/logout.php">Logout</a></li>

                </ul>
            </div>
        </div>
    </div>

    <div class="contain">

        <div class="profile">

            <?php
            if (isset($_SESSION['mobile_num'])) {
            ?>

                <div class="profile_pic">
                    <img src="<?php echo $img ?>" height="250px" width="250px">
                </div>
                <div class="username">

                <?php

                $id = $_SESSION['mobile_num'];
                $qey = "SELECT * FROM `metadata` WHERE phone=$id;";
                if (isset($_COOKIE['uname'])) {
                    echo $_COOKIE['uname'];
                } else {
                    echo "<script>alert('did not connect!!');</script>";
                }
            } else {
                echo "<script>alert('you need to login first!!')
               setTimeout(window.location.href = '../log_in/login.php', 3000)
               </script>";
            }
            $result = mysqli_query($con, $qey);
            $row = mysqli_fetch_assoc($result);
            echo "
            </div>
        </div>
        <div class='pro_info'>
            <div class='num'>
                <p>" . $row['post'] . "</p>
                <p>Post</p>
            </div>
            <div class='num'>
                <p>" . $row['follower'] . "</p>
                <p>Followers</p>
            </div>
            <div class='num'>
                <p>" . $row['following'] . "</p>
                <p>Following</p>
            </div>
            
            <div class='butn_div'>
                <button class='butn' name='edit' type='button' onclick='extra()'>Edit</button>
                <button class='butn' name='feed' type='button' onclick='tofeed()'>Feed</button>
            </div>
        </div>
    </div>";
                ?>
                <hr>
                </hr>
                <div class='tweets'>

                    <?php
                    $profile_tweet = "SELECT * FROM `tweets` ORDER BY `date_time` DESC;";
                    $count = 0;
                    $result = mysqli_query($con, $profile_tweet);

                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($_SESSION['mobile_num'] == $row['phone']) {
                            $count = 1;

                            date_default_timezone_set("Asia/Calcutta");
                            $datetime_1 = $row['date_time'];
                            $datetime_2 = date("Y-m-d H:i:s", time());
                            $tweetlike = $row['date_time'] . "^" . $row['name'];
                            $tweetlike_p = $tweetlike . "p";
                            $btnid = $tweetlike . "btn";

                            $start_datetime = new DateTime($datetime_2);
                            $diff = $start_datetime->diff(new DateTime($datetime_1));
                            $like_num  = $row['like_num'];


                            if ($diff->m == 0) {
                                if ($diff->d == 0) {
                                    if ($diff->h == 0) {
                                        if ($diff->i == 0) {
                                            $time =  $diff->s . " sec ago";
                                        } else {
                                            $time =  $diff->i . " min ago";
                                        }
                                    } else {
                                        $time =  $diff->h . " hour ago";
                                    }
                                } else {
                                    $time =  $diff->d . " day ago";
                                }
                            } else {
                                $time =  $diff->m . " month ago";
                            }


                    ?>

                            <div class='card border-light mb-3 tweet'>
                                <div class='card-header border-light tweet_header'>
                                    <img src='<?php echo $img?>' width='35px' height='35px'>
                                    <div><?php echo $_COOKIE['uname']; ?></div>
                                </div>
                                <div class='card-body tweet_body'>
                                    <h5 class='card-title'> <div class="hash_tag">@</div><?php echo $row['title']; ?></h5>
                                    <p class='card-text'><?php echo $row['masg']; ?></p>
                                </div>
                                <div class='card-footer tweet_footer'>

                                    <div type='button' class='icon' id="<?php echo "$tweetlike"; ?>" onclick="<?php echo "l('$tweetlike')"; ?>">
                                        <button type='button' id="<?php echo "$btnid"; ?>">
                                            <?php
                                            $string = explode("^", $tweetlike);
                                            if (user_check($string[0], $string[1],$con)) {

                                                echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                                        <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z' />
                                                        </svg>";
                                            } else {
                                                echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                                        </svg>";
                                            }

                                            ?>
                                        </button>
                                        <p class="l_num" id="<?php echo $tweetlike_p; ?>"> <?php echo $like_num; ?></p>
                                    </div>


                                    <div class='icon'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat' viewBox='0 0 16 16'>
                                            <path d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z' />
                                        </svg>
                                        <?php echo $row['com_num']; ?>
                                    </div>
                                    <div class='icon'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-download' viewBox='0 0 16 16'>
                                            <path d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z' />
                                            <path d='M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z' />
                                        </svg>
                                    </div>
                                    <div class='icon'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-three-dots-vertical' viewBox='0 0 16 16'>
                                            <path d='M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z' />
                                        </svg>
                                        <?php echo $time; ?>
                                    </div>
                                </div>
                            </div>

                    <?php

                        }
                    }
                    if ($count == 0) {
                        echo "<center><h2>you didn't post yet</h2></center>";
                    }

                    ?>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>
<script>
    function tofeed() {
        window.location.href = 'feed.php';

    }

    function l(id) {
        console.log(id);
        var fill = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/></svg>";
        var btnid = id + "btn";
        var pid = id + "p";
        document.getElementById(btnid).innerHTML = fill;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            console.log(this.responseText);
            document.getElementById(pid).innerHTML = this.responseText;

        }

        xhttp.open("GET", "likes.php?q=" + id, true);
        xhttp.send();

    }

    var passchange = document.getElementById('old_pass');

    function changepass() {
        passchange.style.display = "block";
        // console.log("to pass change");

    }

    function pass_toback() {
        passchange.style.display = "none";
        // console.log("to back from pass change");
    }

    function extra() {
        window.location.href = 'edit.php';
    }
</script>

</html>