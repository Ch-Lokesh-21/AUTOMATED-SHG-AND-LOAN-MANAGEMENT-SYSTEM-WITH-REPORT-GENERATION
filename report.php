<?php
session_start();
include 'connection.php';
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
if ($conn) {
    header("Content-Type: text/plain");
    header('Content-Disposition: attachment; filename="report.txt"');
    $query = "SELECT * FROM `shgdetails` 
              NATURAL JOIN `memberdetails` 
              NATURAL JOIN `loan` 
              NATURAL JOIN `branches` ORDER BY `CIF`,`mcif`;";
    $res = mysqli_query($conn, $query);
    if ($res) {
        $getDate = mysqli_fetch_assoc($res);
        $inputDate = $getDate["date"];
        $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
        $formattedDate = $dateObject->format("d-m-Y");
        $finalDate = preg_replace("/-/", "", $formattedDate);
        echo "HDRHMMFI1.9CU10820001AP STATE COOP                           ".$finalDate.$finalDate."   tRANSUNIONclpc@2024           INHOUSE                       INHOUSE                       \n";
        while ($row = mysqli_fetch_assoc($res)) {
            $x = "CNSCRD|";
            $x .= $row["mcif"] . '|';
            $x .= $row["BrCode"] . '|';
            $x .= $row["BrCode"] . '|';
            $x .= $row["CIF"] . '|';
            $x .= $row["name"] . '||||';

            $inputDate = $row["dob"];
            $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
            $formattedDate = $dateObject->format("d-m-Y");
            $finalDate = preg_replace("/-/", "", $formattedDate);
            $x .= $finalDate . '||';
            $x .= $row["age"] . '|';
            $x .= $row["gender"] . '|';
            $x .= $row["marital"] . '|';
            $x .= $row["kpn"] . '|';
            $x .= $row["kpr"] . '|||||||||';
            $x .= $row["nname"] . '|';
            $x .= $row["nrel"] . '|';
            if ($row["nage"] == 0) {
                $x .= '|';
            } else {
                $x .= $row["nage"] . '|';
            }
            $x .= $row["vid"] . '|';
            $x .= $row["uid"] . '|';
            $x .= $row["pan"] . '|';
            $x .= $row["ration"] . '|||||||';
            $x .= $row["telind"] . '|';
            if ($row["telphn"] == 0) {
                $x .= '||||||';
            } else {
                $x .= $row["telphn"] . '||||||';
            }
            $x .= $row["accBankName"] . '|';
            $x .= $row["accBranchName"] . '|';
            $x .= $row["accAccNo"] . '|';
            $x .= $row["occ"] . '|';
            $x .= $row["mincome"] . '|';
            $x .= $row["mexp"] . '||';
            $x .= $row["caste"] . '|';
            $x .= $row["gli"] . '|||';
            $x .= 'ADRCR|';
            $x .= $row["padd"] . '|';
            $x .= $row["psc"] . '|';
            $x .= $row["ppc"] . '|';
            $x .= $row["cadd"] . '|';
            $x .= $row["csc"] . '|';
            $x .= $row["cpc"] . '||';
            $x .= 'ACTCRD|';
            $x .= $row["accNo"] . '|';
            $x .= $row["accNo"] . '|';
            $x .= $row["BrCode"] . '|';
            $x .= $row["BrCode"] . '|';
            $x .= $row["loo"] . '|';
            
            $inputDate = $row["date"];
            if ($inputDate != "0000-00-00") {
                $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
                $formattedDate = $dateObject->format("d-m-Y");
                $finalDate = preg_replace("/-/", "", $formattedDate);
            } else {
                $finalDate = "";
            }
            $x .= $finalDate . '|';

            $x .= $row["lc"] . '|';
            $x .= $row["CIF"] . '||';
            $x .= $row["purpose"] . '|';
            $x .= $row["accSt"] . '|';

            $inputDate = $row["adate"];
            if ($inputDate != "0000-00-00") {
                $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
                $formattedDate = $dateObject->format("d-m-Y");
                $finalDate = preg_replace("/-/", "", $formattedDate);
            } else {
                $finalDate = "";
            }
            $x .= $finalDate . '|';

            $inputDate = $row["sdate"];
            if ($inputDate != "0000-00-00") {
                $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
                $formattedDate = $dateObject->format("d-m-Y");
                $finalDate = preg_replace("/-/", "", $formattedDate);
            } else {
                $finalDate = "";
            }
            $x .= $finalDate . '|';

            $inputDate = $row["odate"];
            if ($inputDate != "0000-00-00") {
                $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
                $formattedDate = $dateObject->format("d-m-Y");
                $finalDate = preg_replace("/-/", "", $formattedDate);
            } else {
                $finalDate = "";
            }
            $x .= $finalDate . '|';

            $inputDate = $row["cdate"];
            if ($inputDate != "0000-00-00") {
                $dateObject = DateTime::createFromFormat("Y-m-d", $inputDate);
                $formattedDate = $dateObject->format("d-m-Y");
                $finalDate = preg_replace("/-/", "", $formattedDate);
            } else {
                $finalDate = "";
            }
            $x .= $finalDate . '|||';

            $x .= $row["amtSanc"] . '|';
            $x .= $row["Tamt"] . '|';
            $x .= $row["noi"] . '|';
            $x .= $row["repFrq"] . '|';
            $x .= $row["minAmtDue"] . '|';
            $x .= $row["curBal"] . '|';
            $x .= $row["amtOvr"] . '|';
            $x .= $row["dpd"].'||||||||||||';
            echo $x . "\n";
        }
        echo "TRLHMMFI1.9CU10820001                    \n";
    } else {
        die("Unable to Fetch Data from Database: " . mysqli_error($conn));
    }
} else {
    die("Unable to Connect to Database");
}
