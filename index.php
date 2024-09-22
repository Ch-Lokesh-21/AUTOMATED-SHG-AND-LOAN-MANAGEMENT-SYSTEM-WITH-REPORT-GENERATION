<?php
session_start();
include 'connection.php';
if (!$conn) {
    die("Unable to Connect to Data Base");
}
if (isset($_POST["ad-id"])) {
    $id = openssl_encrypt($_POST["ad-id"],$chiper,$key,$options,$iv);
    $pass = openssl_encrypt($_POST["ad-pass"],$chiper,$key,$options,$iv);
    $searchQuery = "SELECT * FROM `admin` WHERE `id` = '$id' AND `password` = '$pass';";
    $res = mysqli_query($conn, $searchQuery);
    if ($res) {
        if (mysqli_num_rows($res) == 1) {
            $_SESSION["admin"] = $id;
            header('location:display.php');
        } else {
            $in_pass = "Enter Valid Credentials";
        }
    } else {
        die(mysqli_error($conn));
    }
}
if (isset($_POST["us-id"])) {
    $id = openssl_encrypt($_POST["us-id"],$chiper,$key,$options,$iv);
    $pass = openssl_encrypt($_POST["us-pass"],$chiper,$key,$options,$iv);
    $searchQuery = "SELECT * FROM `user` WHERE `ifsc` = '$id' AND `password` = '$pass';";
    $res = mysqli_query($conn, $searchQuery);
    if ($res) {
        if (mysqli_num_rows($res) == 1) {
            $_SESSION["user"] = $id;
            header('location:display.php');
        } else {
            $in_pass = "Enter Valid Credentials";
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" sizes="32x32" href="./logo.jpeg">
    <link rel="stylesheet" href="./style1.css">
    <title>APCOB | Login</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body id="login-body">
    <div class="nav-bar">
        <div class="nav-img">
            <img src="./logo.jpeg" alt="APCOB">
        </div>
        <div class="nav-msg">
            <b>Andhra Pradesh State Cooperative Bank Ltd.</b>
        </div>
    </div>
    <?php
    if (isset($in_pass)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>' . $in_pass . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        unset($in_pass);
    }
    ?>
    <div class="btn-grp">
        <button class="btn btn-success" type="button" id="apcob">APCOB</button>
        <button class="btn btn-success" type="button" id="dccb">DCCB</button>
    </div>
    <div class="login-box">
        <div class="admin-login">
            <div class="mb-3">
                <b>APCOB Login</b>
            </div>
            <div class="admin-form">
                <form action="index.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="ad-id" name="ad-id" placeholder="User Id" required>
                        <label for="ad-id">User Id</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="ad-pass" name="ad-pass" placeholder="Password" required>
                        <label for="ad-pass">Password</label>
                    </div>
                    <div class="form-floating" id="ad-sub">
                        <input type="submit" value="Login" name="ad-login" id="ad-login" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
        <div class="user-login">
            <div class="mb-3">
                <b>DCCB Login</b>
            </div>
            <div class="user-form">
                <form action="index.php" method="post">
                    <div class="form-floating mb-3" id="us-br">
                        <p><label for="us-id">Choose a branch : </label></p>
                        <select name="us-id" id="us-id">
                            <option selected>Select Branch</option>
                            <option value="APBL0000106">Tirupati</option>
                            <option value="APBL0000126">Governorpet</option>
                            <option value="APBL0000003">Brundavan Gardens</option>
                            <option value="APBL0000004">Gannavaram</option>
                            <option value="APBL0000006">KR Market</option>
                            <option value="APBL0000007">Ramavarappadu</option>
                            <option value="APBL0000005">Gollapudi</option>
                            <option value="APBL0000008">Venugopal Nagar</option>
                            <option value="APBL0000009">Rayapudi</option>
                            <option value="APBL0000010">Kanuru</option>
                            <option value="APBL0000011">Currency Nagar</option>
                            <option value="APBL0000012">Mangalagiri</option>
                            <option value="APBL0000013">Moghalrajapuram</option>
                            <option value="APBL0000014">Chenchupeta</option>
                            <option value="APBL0000015">AT Agraharam </option>
                            <option value="APBL0000016">Hanuman Junction</option>
                            <option value="APBL0000017">Challapalli</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="us-pass" name="us-pass" placeholder="Password" required>
                        <label for="us-pass">Password</label>
                    </div>
                    <div class="form-floating" id="us-sub">
                        <input type="submit" value="Login" name="us-login" id="us-login" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery js  -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
<script>
    document.getElementById('apcob').addEventListener("click", () => {
        document.querySelector(".admin-login").style.display = "flex";
        document.querySelector(".user-login").style.display = "none";
    });
    document.getElementById('dccb').addEventListener("click", () => {
        document.querySelector(".user-login").style.display = "flex";
        document.querySelector(".admin-login").style.display = "none";
    });
</script>

</html>