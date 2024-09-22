<?php
session_start();
include 'connection.php';
if (!$conn) {
    die("Unable to Connect to Data Base");
}
if(!isset($_SESSION["admin"]) && !isset($_SESSION["user"]))
{
    header('location:index.php');
}
if (isset($_SESSION["admin"])) {
    $Admin = openssl_decrypt($_SESSION["admin"],$chiper,$key,$options,$iv);
}
if (isset($_SESSION["user"])) {
    $User = $_SESSION["user"];
    $getUserBr = "SELECT * FROM `user` NATURAL JOIN `branches` WHERE `branches`.`ifsc`='$User';";
    $res = mysqli_query($conn, $getUserBr);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $UserBr = $row["BrCode"];
        $UserBrName = $row["BrName"];
        $_SESSION["user-br"] = $UserBr;
        $_SESSION["user-br-name"] = $UserBrName;
    } else {
        die("Unable to Fetch Data");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCOB | SHG</title>
    <link rel="stylesheet" href="./style1.css">
    <link rel="icon" sizes="32x32" href="./logo.jpeg">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body id="up-body">
    <div class="cont">
    <div class="nav-bar mb-3">
        <div class="nav-img">
            <img src="./logo.jpeg" alt="APCOB">
        </div>
        <div class="nav-msg">
            <b>Andhra Pradesh State Cooperative Bank Ltd.</b>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                        if(isset($_SESSION["admin"]) && isset($Admin))
                        {
                            echo $Admin;
                        }
                        else if(isset($_SESSION["user"]) && isset($UserBrName))
                        {
                            echo $UserBrName;
                        }
                        else
                        {
                            echo "user";
                        }
                    ?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="display.php">Home</a></li>
                    <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="upd-box mb-3">
        <span id="upd-span"><p>Format of the Excel Sheets : </p></span>
        <a href="shg_format.xlsx" target="_blank"><button class="btn btn-primary">SHG Details</button></a>
        <a href="mem_format.xlsx" target="_blank"><button class="btn btn-primary">Member Details</button></a>
        <a href="loan_format.xlsx" target="_blank"><button class="btn btn-primary">Loan Details</button></a>
    </div>
        <div class="msgs mb-3">
            <?php
            if (isset($_SESSION["err"])) {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>' . $_SESSION["err"] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                unset($_SESSION["err"]);
            }
            if (isset($_SESSION["msg"])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>'  . $_SESSION["msg"] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>' . '<div id="dwn"><b>Download The Report Here : </b><form action="report.php">
                        <input type="submit" value="Download" clas="btn btn-primary" id="dow" name="dow"> </form> </div>';
                unset($_SESSION["msg"]);
            }
            ?>
        </div>
        <div class="box">
            <form action="insert.php" method="post" id="myform" enctype="multipart/form-data" class="mb-3 upld">
                <div class="mb-4 inf">
                    <label for="import_file1" class="form-label">Upload SHG Details Excel File Here</label>
                    <input class="form-control" type="file" id="import_file1" name="import_file1">
                </div>
                <div class="mb-4 inf">
                    <label for="import_file2" class="form-label">Upload Member Details Excel File Here</label>
                    <input class="form-control" type="file" id="import_file2" name="import_file2">
                </div>
                <div class="mb-4 inf">
                    <label for="import_file3" class="form-label">Upload Loan Details Excel File Here</label>
                    <input class="form-control" type="file" id="import_file3" required name="import_file3">
                </div>
                <div class="inp">
                    <input type="submit" value="Upload" class="btn" name="sub" id="sub">
                </div>
            </form>
        </div>
    </div>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery js  -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>

</html>