<?php
include('../database/include.php');

if (isset($_SESSION['mobile_num'])) {
    $img = 'uploads/' . $_SESSION['mobile_num'] . '.png';
    $img = file_exists($img) ? $img : 'y.png';
} else {
    echo "<script>alert('you need to login first!!')
        setTimeout(window.location.href = '../log_in/login.php', 3000)
        </script>";
}

$target_dir = "uploads/";
$user_mn = $_SESSION['mobile_num'];
$uploadOk = 1;

if (isset($_POST["submit"])) {

    $oldname = $_COOKIE['uname'];
    $old_id = $_SESSION['mobile_num'];
    $newname = htmlspecialchars($_POST['changename']);

    if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            // echo $check["mime"];
            $uploadOk = 1;
        } else {
            // echo "File is not an image.";
            $uploadOk = 0;
        }


        $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));

        // echo $imageFileType . "<br>";
        $newfilename = $user_mn . "." . $imageFileType;
        $target_file = $target_dir . $newfilename;

        if ($imageFileType != "png") {
            // echo $imageFileType;
            $uploadOk = 0;
            echo "<script>alert('Sorry, only PNG  files are allowed');</script>";
           
        }
        
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "<script>alert('only less then 500Kb photo allowed');</script>";
            $uploadOk = 0;
          }

        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if ($uploadOk==1) {
        $editname = "UPDATE `metadata` SET `name`='$newname' WHERE `name`='$oldname' AND `phone`='$old_id'";
        $editname_tweet = "UPDATE `tweets` SET `name`='$newname' WHERE `name`='$oldname' AND `phone`='$old_id'";
        $flag = mysqli_query($con, $editname);
        $flag1 = mysqli_query($con, $editname_tweet);
        if ($flag && $flag1) {

            setcookie('uname', $newname, time() + (3600), "/");
            $newname1 = $_COOKIE['uname'];
            echo "<script>alert('Profile changed');</script>";
        }

        echo "<script>window.location.href='../profile/profile.php'</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <style>
        @import url("profile.css");
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image" href="../Sign_In/logo_icon.png">
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
            <a href="../profile/profile.php"><img src="<?php echo $img; ?>" width="44px" height="44px"></a>

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
                    <li><a class="dropdown-item" href="../profile/profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="../profile/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <center>
        <div class="profile_edit">
            <form action="edit.php" method="post" enctype="multipart/form-data">
                <h1>Edit Profile</h1>

                <div class="pro_pic">
                    <img src="<?php echo $img; ?>" alt="Profile Picture" width="200px" height="200px">
                </div>
                <label for="fileToUpload">Edit Picture</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload">

                <div class="change_name">
                    <label for="changename">Change Name</label><br>
                    <input type="text" name="changename" id="changename" placeholder="Enter New Name" value="<?php echo $_COOKIE['uname']; ?>" oninput="velidname()"><br>
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>
<script>

function velidname() {

var name = document.getElementById("changename");
var val = name.value;
var len = val.length;


    if (len > 22) {
        name.value = val.substring(0, 22);

    }
    var is = (/[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\0-9]/).test(val);
    if(is){
        name.value = val.substring(0, len- 1);
    }
}
</script>

</html>