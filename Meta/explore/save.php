<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("explore.css");
    </style>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
    <title>saved</title>
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
            <a href="../profile/profile.php"><img src="x.png" width="44px" height="44px"></a>

            <h1>
                <?php
                include('../database/include.php'); 
                if (isset($_SESSION['mobile_num'])) {
                    echo 'raju';
                } else {
                    echo 'raju';
                }
                ?>
            </h1>
            <div class="dropdown setting_ic">
                <a class="setting_ic" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                 <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
                </a>

                <ul class="dropdown-menu mt-md-2">
                    <li><a class="dropdown-item" href="../profile/Feed.php">Feed</a></li>
                    <li><a class="dropdown-item" href="../profile/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="explor_bar">
        <ul>
            <li><a class='option' href='../profile/feed.php'><i class="bi bi-house"></i>Home</a></li>
            <li><a class='option' href='../explore/trending.php'><i class="bi bi-graph-up-arrow"></i>Trending</a></li>
            <li><a class='option' href=''><i class="bi bi-bookmark"></i>Saved</a></li>
        </ul>
    </div>
    <center>

    <h2 style="color: rgb(43, 56, 94);margin-bottom:40px;">Saved post by you</h2>
    </center>
    <?php

    $saved_list = "SELECT * FROM `tweets` ORDER BY `date_time` DESC;";
    $result = mysqli_query($con, $saved_list);
    $num = mysqli_num_rows($result);
    $counter = 0;
    while ($row = mysqli_fetch_assoc($result)) {

        date_default_timezone_set("Asia/Calcutta");
        $datetime_1 = $row['date_time'];
        $datetime_2 = date("Y-m-d H:i:s", time());
        $tweetlike = trim($row['date_time'] . "^" . $row['name']);
        $tweetlike2 = $tweetlike . "main";
        $btnid = $tweetlike . "btn";
        $start_datetime = new DateTime($datetime_2);
        $diff = $start_datetime->diff(new DateTime($datetime_1));
        $valu  = $row['like_num'];


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


        if($row['phone']==1234567890){
            $img = 'x.png';
        }
        else{
            $img = 'y.png';
        }
 if($counter%5==0 ){       
        echo "
<form method='POST'>       
<div class='card border-light mb-3 tweet' id='$tweetlike2'>
<div class='card-header border-light tweet_header'>
    <img src='$img' width='35px' height='35px'>
    <div>" . $row['name'] . "</div>
</div>
<div class='card-body tweet_body'>
    <h5 class='card-title'>" . $row['title'] . "</h5>
    <p class='card-text'>" . $row['masg'] . "</p>
</div>
<div class='card-footer tweet_footer'>
    <div type='button' class='icon' id='$tweetlike' onclick='l(`$tweetlike`)'>
        <button type='submit' id='$btnid'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
            <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z' />
        </svg></button>
        " . $row['like_num'] . "</div>
    <div class='icon'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat' viewBox='0 0 16 16'>
            <path d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z' />
        </svg>
        " . $row['com_num'] . "</div>
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
        " . $time . "</div>
</div>
</div>
</form>
";

 }
 $counter=$counter+1;
    }

    ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

</body>

</html>