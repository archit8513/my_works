<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        @import url("style.css");
    </style>
</head>

<body>
    <div class="email_viwe">
        <?php
        session_start();
        if (isset($_SESSION['id_viwe'])) {

            $e_id = $_SESSION['id_viwe'];

            $conn = mysqli_connect("localhost", "root", "", "projects");
            $qurey = "SELECT * FROM `emails` WHERE id='$e_id'";
            $result = mysqli_query($conn, $qurey);

            while ($row = mysqli_fetch_assoc($result)) {
                $sender = $row['sender'];
                $receiver = $row['receiver'];
                $subject = $row['subject'];
                $message = $row['message'];
                $date_time = $row['date_time'];
                $date = date("d-m-Y H:i", strtotime($date_time));
                $idofmail = $row['id'];

        ?>

                <form>
                    <div class="viwe_heder">
                        <h2>Air mails</h2>

                        <div class="cross" onclick="back()">
                            <i class="bi bi-x-square-fill"></i>
                        </div>


                    </div>
                       
                    <label> From:</label><input type="text" name="s_id" id="s_id" value="<?php echo "$sender"; ?>" disabled>
                    <p style="display: inline;"><label>Date:</label><?php echo "$date"; ?><br>
                        <hr>
                        <label> To:</label><input type="text" name="r_id" id="r_id" value="<?php echo "$receiver"; ?>" disabled><br>
                        <hr>
                        <label> Subject:</label><input type="text" name="sub" id="sub" value="<?php echo "$subject"; ?>" disabled><br>
                        <hr>
                        <label> Message:</label><br><textarea type="text" name="msg" id="msg" disabled><?php echo "$message"; ?></textarea><br>
                </form>

    </div>
<?php
            }
        }
?>
</body>

<script>
    function back() {
        console.log("back");
        window.history.back();
    }
</script>

</html>