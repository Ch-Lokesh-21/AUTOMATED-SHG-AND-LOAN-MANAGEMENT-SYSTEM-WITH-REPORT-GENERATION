<?php
session_start();
include 'connection.php';
if(!$conn)
{
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
$is_inserted = false;
if (isset($_POST["dataSub"])) {
    if ($conn) {
        $gcif = $_POST["gcif"];
        $gbrcode = $_POST["gbrcode"];
        $len = $_POST["gcount"];
        for ($i = 1; $i <= $len; $i++) {
            $mcif = $_POST["m{$i}mcif"];
            $name = $_POST["m{$i}name"];
            $dob = $_POST["m{$i}dob"];
            $age = $_POST["m{$i}age"];
            $gender = $_POST["m{$i}gender"];
            $marital = $_POST["m{$i}marital"];
            $kpn = $_POST["m{$i}keypn"];
            $kpr = $_POST["m{$i}keyrel"];
            $nname = $_POST["m{$i}nominame"];
            $nrel = $_POST["m{$i}nomrel"];
            $nage = $_POST["m{$i}nomage"];
            $vid = $_POST["m{$i}voteid"];
            $uid = $_POST["m{$i}uid"];
            $pan = $_POST["m{$i}pan"];
            $ration = $_POST["m{$i}ration"];
            $telind = $_POST["m{$i}telind"];
            $telphn = $_POST["m{$i}telphone"];
            $accBankName = $_POST["m{$i}accbankname"];
            $accBranchName = $_POST["m{$i}accbankbranch"];
            $accAccNo = $_POST["m{$i}accbanknum"];
            $occ = $_POST["m{$i}occupation"];
            $mincome = $_POST["m{$i}monincome"];
            $mexp = $_POST["m{$i}monexp"];
            $caste = $_POST["m{$i}caste"];
            $gli = $_POST["m{$i}gli"];
            $padd = $_POST["m{$i}padd"];
            $psc = $_POST["m{$i}psc"];
            $ppc = $_POST["m{$i}ppc"];
            $cadd = $_POST["m{$i}cadd"];
            $csc = $_POST["m{$i}csc"];
            $cpc = $_POST["m{$i}cpc"];
            $loki = "INSERT INTO `memberdetails`(`mcif`, `CIF`, `name`, `dob`, `age`, `gender`, `marital`, `kpn`, `kpr`, `nname`, `nrel`, `nage`, `vid`, `uid`, `pan`, `ration`, `telind`, `telphn`, `accBankName`, `accBranchName`, `accAccNo`, `occ`, `mincome`, `mexp`, `caste`, `gli`, `padd`, `psc`, `ppc`, `cadd`, `csc`, `cpc`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]','[value-18]','[value-19]','[value-20]','[value-21]','[value-22]','[value-23]','[value-24]','[value-25]','[value-26]','[value-27]','[value-28]','[value-29]','[value-30]','[value-31]','[value-32]')";
            $sqlQuery = "INSERT INTO `memberdetails` (`mcif`, `CIF`,`name`, `dob`, `age`, `gender`, `marital`, `kpn`, `kpr`, `nname`, `nrel`, `nage`, `vid`, `uid`, `pan`, `ration`, `telind`, `telphn`, `accBankName`, `accBranchName`, `accAccNo`, `occ`, `mincome`, `mexp`, `caste`, `gli`, `padd`, `psc`, `ppc`, `cadd`, `csc`, `cpc`) VALUES ('$mcif', '$gcif','$name', '$dob', '$age', '$gender', '$marital', '$kpn', '$kpr', '$nname', '$nrel', '$nage', '$vid', '$uid', '$pan', '$ration', '$telind', '$telphn', '$accBankName', '$accBranchName', '$accAccNo', '$occ', '$mincome', '$mexp', '$caste', '$gli', '$padd', '$psc', '$ppc', '$cadd', '$csc', '$cpc');";
            if (mysqli_query($conn, $sqlQuery)) {
                $is_inserted = true;
            } else {
                echo "Error: " . $sqlQuery . "<br>" . mysqli_error($conn);
                die();
            }
        }
        mysqli_close($conn);
    } else {
        echo "Connection failed: " . mysqli_connect_error();
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCOB | SHG</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" sizes="32x32" href="./logo.jpeg"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
</head>
<body> 
    <?php
    if ($is_inserted) {
        $_SESSION['message']="Members Data Inserted";
        header('Location: display.php');
    }
    ?>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <!-- jquery js -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> 
    <!-- data tables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="./script.js"></script>
</body>
</html>