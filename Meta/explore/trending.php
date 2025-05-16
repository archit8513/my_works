<!DOCTYPE html>
<html lang="en">
<?php 
include('../database/include.php');
if(!isset($_SESSION['mobile_num'])){
    header("location: ../log_in/login.php");
}
else{
    $img = '../profile/uploads/' . $_SESSION['mobile_num'] . '.png';
    $img = file_exists($img) ? $img : 'y.png';
}

?>
<head>
    <style>
        @import url("explore.css");
    </style>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
    <title>Trending</title>
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
            <a href="../profile/profile.php"><img src="<?php echo $img?>" width="44px" height="44px"></a>

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
                    <li><a class="dropdown-item" href="../profile/Feed.php">Feed</a></li>
                    <li><a class="dropdown-item" href="../profile/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="explor_bar">
        <ul>
            <li><a class='option' href='../profile/feed.php'><i class="bi bi-house"></i>Home</a></li>
            <li><a class='option' href=''><i class="bi bi-graph-up-arrow"></i>Trending</a></li>
        
        </ul>
    </div>
    <div class="trending_connects">
        <div class="card trend_card">
            <div class="card-header header">
                1. meta
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 500 </h5>
                <p class="card-text">Likes 2.0k &emsp;&emsp; Comment 167 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                2. newapp
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 400 </h5>
                <p class="card-text">Likes 1.5k &emsp;&emsp; Comment 78 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                3. connects
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 396 </h5>
                <p class="card-text">Likes 987 &emsp;&emsp; Comment 56 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                4. back_to_old_days
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 200 </h5>
                <p class="card-text">Likes 700 &emsp;&emsp; Comment 45 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                5. notworking
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 154 </h5>
                <p class="card-text">Likes 650 &emsp;&emsp; Comment 30 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                6. good_morning
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 98 </h5>
                <p class="card-text">Likes 500 &emsp;&emsp; Comment 17 </p>
            </div>
        </div>
        <div class="card trend_card">
            <div class="card-header header">
                7. copy_of_twitter
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Tweets: 56 </h5>
                <p class="card-text">Likes 100 &emsp;&emsp; Comment 2 </p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

</body>
<script>
    // fetch('https://jsonplaceholder.typicode.com/todos/1').then(response =>response.json()).then(json => console.log(json))
</script>

</html>