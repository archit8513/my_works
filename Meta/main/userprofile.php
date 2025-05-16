<?php
include('../database/include.php'); 

if(isset($_POST['userprofile']) or isset($_POST['follow']) or isset($_SESSION['other_user_id'])){

    if(isset($_POST['id']))
    {
        $userid = $_POST['id'];
        $_SESSION['other_user_id'] = $_POST['id'];
    }
    elseif(isset($_POST['followid'])){
        $userid = $_POST['followid'];
        $_SESSION['other_user_id'] = $_POST['followid'];
    }
    elseif(isset($_SESSION['other_user_id'])){
        $userid = $_SESSION['other_user_id'];
    }
    else{
        echo "<script>
    setTimeout(window.location.href = '../profile/feed.php', 3000)
    </script>";
    }
    
    $selectuser = "SELECT * FROM `metadata` WHERE `u_id`='$userid'";
    $view_user = mysqli_query($con, $selectuser);
    $row = mysqli_fetch_assoc($view_user);
    $username = $row['name'];
    $mn = $row['phone'];
    $img = '../profile/uploads/' .$mn. '.png';
    $img = file_exists($img) ? $img : '../profile/uploads/y.png';

}
else{
    echo "<script>
    setTimeout(window.location.href = '../profile/feed.php', 3000)
    </script>";

}

function user_check($str1,$str2,$con){

    $likeduserid = $_SESSION['user_id'];
   
    $sql = "SELECT * FROM `tweets` WHERE `date_time`='$str1' and `name`='$str2'";
    $result_check = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result_check);
    
    if($num==1){
        $row_check = mysqli_fetch_assoc($result_check);
        $likes = $row_check['user_like'];
        $array = explode("|",$likes);
        $flag = true;
        foreach($array as $value){
            if($value==strval($likeduserid)){
                $flag = false;
                break;
            }
        }
    }
    return $flag;

};

function followcheck($fid,$fwerid,$con){
    
    $sql = "SELECT * FROM `metadata` WHERE `u_id`='$fwerid'";
    $result_check = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result_check);

    $array = explode("|",$row['followedid']);
    $follow_flag = true;
    foreach($array as $value){
        if($value==strval($fid)){
            $follow_flag= false;
            break;
        }
    }
    return $follow_flag;
    
};

if(isset($_POST['follow'])){
    $followeduserid = $_POST['followid'];
    $followerid = $_SESSION['user_id'];

    if(followcheck($followeduserid,$followerid,$con)){
        $sql = "UPDATE `metadata` SET `following`=`following`+1 , `followedid`=CONCAT(`followedid`,'|' ,'$followeduserid')  WHERE `u_id`=  $followerid";
        $follow_update ="UPDATE `metadata` SET `follower`=`follower`+1 WHERE u_id = $followeduserid";
        $result = mysqli_query($con, $sql);
        $result2 = mysqli_query($con, $follow_update);
    }    

}


?>



<!DOCTYPE html>
<html>

<head>
    <!-- <link rel="stylesheet" href=""> -->
    <style>
        @import url("profile.css");
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
    <title>Profile</title>
</head>

<body>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

 


    <!-- Username and feed -->
    <div>
        <div class="username_div">
        <div class="logo_name">
            <a href="../profile/profile.php"><img src="<?php 
            $img_pic = '../profile/uploads/'.$_SESSION['mobile_num'].'.png';
            $img_pic = file_exists($img_pic) ? $img_pic : '../profile/uploads/y.png'; 
            echo $img_pic?>" width="44px" height="44px"></a>

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
                 <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
                </a>

                <ul class="dropdown-menu mt-md-2">
                    <li><a class="dropdown-item" href="../profile/feed.php">Feed</a></li>
                
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

                    $id = $mn;
                    $qey = "SELECT * FROM `metadata` WHERE phone=$id;";
                    if (isset($_COOKIE['uname'])) {
                        echo $username;
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
                ?>
            </div>
        </div>
        <div class='pro_info'>
            <div class='num'>
                <p><?php echo $row['post'];?></p>
                <p>Post</p>
            </div>
            <div class='num'>
                <p><?php echo $row['follower'];?></p>
                <p>Followers</p>
            </div>
            <div class='num'>
                <p><?php echo $row['following'];?></p>
                <p>Following</p>
            </div>
            
            <div class='butn_div'>
            <form method='POST'>
                <input type='hidden' name='followid' value='<?php echo $userid;?>'>
                <?php 
                if(followcheck($userid,$_SESSION['user_id'],$con)){
                            echo "<button class='butn' name='follow' type='submit' onclick=''>Follow</button>";
                }
                else{
                    echo "<button class='butn_f' name='follow' type='submit' onclick='' disabled>Following</button>";
                }
                echo "<button class='butn' name='feed' type='button' onclick='tofeed()'>Feed</button>";
                ?>
                
                </form>
            </div>
        </div>
    </div>
                <hr>
                </hr>
                <div class='tweets'>

                    <?php
                    $profile_tweet = "SELECT * FROM `tweets` ORDER BY `date_time` DESC;";
                    $count = 0;
                    $result = mysqli_query($con, $profile_tweet);

                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($mn == $row['phone']) {
                            $count = 1;

                            date_default_timezone_set("Asia/Calcutta");
                            $datetime_1 = $row['date_time'];
                            $datetime_2 = date("Y-m-d H:i:s", time());
                            $tweetlike = $row['date_time'] . "^" . $row['name'];
                            $tweetlike_p = $tweetlike."p";
                            $btnid= $tweetlike."btn";

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
                                    <img src='<?php echo $img; ?>' width='35px' height='35px'>
                                    <div><?php echo $username; ?></div>
                                </div>
                                <div class='card-body tweet_body'>
                                    <h5 class='card-title'><div class="hash_tag">@</div><?php echo $row['title']; ?></h5>
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
                        echo "<center><h2>No Post Yet</h2></center>";
                    }
                    ?>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>
<script>
   
   function tofeed() {
        window.location.href = '../profile/feed.php';

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

        xhttp.open("GET", "../profile/likes.php?q=" + id, true);
        xhttp.send();

    }


</script>

</html>