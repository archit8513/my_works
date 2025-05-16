<?php   
include('../database/include.php');
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

    $greenflag = 0;
    $redflag = 0;
    // echo $_GET['q']."<br>";
    // echo $_POST['likebtn']."<br>";
    if (isset($_GET['q'])) {
        $idoflike = $_GET['q'];
        $redirect = $idoflike."main";
        $str =explode("^",$idoflike);
        $likeduserid = $_SESSION['user_id'];
        // echo $str[0]."<br>";
        // echo $str[1];
          
            if(user_check($str[0],$str[1],$con)){
                $likequry = "UPDATE `tweets` SET `like_num`=`like_num`+1 , `user_like`= CONCAT(`user_like`,'|' ,'$likeduserid') WHERE `date_time`='$str[0]' and `name`='$str[1]'";
                $nice = mysqli_query($con,$likequry);
                $greenflag = 1;
            }
            else{
                $redflag = 1;
            }

        
        setcookie('tweetlikeid',"",time() - 24*3600, '/');
    }
    
if($greenflag===1 or $redflag===1){
        $qry1 = "SELECT * FROM `tweets` ORDER BY `date_time` DESC;";

        $result = mysqli_query($con, $qry1);
        $num = mysqli_num_rows($result);
    
        $id= trim(strtolower($_GET['q']));
        // echo "<br>".$id."<br>";

        while ($row = mysqli_fetch_assoc($result)) {
            $arr = array($row['date_time'],$row['name']);
            $mainid = implode("^",$arr);
            $mainid= trim(strtolower($mainid));
            // echo $id."56";
            // echo $mainid."<br>";
            // echo strcmp($mainid,$id)."<br>";
            if($mainid===$id){
            $like_num  = $row['like_num'];
           echo $like_num;
              break;
            }
               
            
    
        }

    }
?>