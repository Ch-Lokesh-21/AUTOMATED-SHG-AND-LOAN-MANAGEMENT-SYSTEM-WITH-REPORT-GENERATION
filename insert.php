<?php
session_start();
include 'connection.php';
if (!$conn) {
    die("Unable to Connect to the Data Base");
}
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
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
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
function calculateAge($dob)
{
    $dob = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
}
if ($conn) {
    if (isset($_POST["sub"])) {
        $fileName1 = $_FILES["import_file1"]["name"];
        $fileName2 = $_FILES["import_file2"]["name"];
        $fileName3 = $_FILES["import_file3"]["name"];
        $file_ext1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $file_ext2 = pathinfo($fileName2, PATHINFO_EXTENSION);
        $file_ext3 = pathinfo($fileName3, PATHINFO_EXTENSION);
        $allowed_ext = ['xlsx'];
        if ($fileName1 != null && !in_array($file_ext1, $allowed_ext)) {
            $_SESSION["err"] = "Please Upload Excel File";
            header("location:upload.php");
        }
        if ($fileName2 != null && !in_array($file_ext2, $allowed_ext)) {
            $_SESSION["err"] = "Please Upload Excel File";
            header("location:upload.php");
        }
        if ($fileName3 != null && !in_array($file_ext3, $allowed_ext)) {
            $_SESSION["err"] = "Please Upload Excel File";
            header("location:upload.php");
        }
        if ($fileName1 != null && in_array($file_ext1, $allowed_ext)) {
            $filePath1 = $_FILES["import_file1"]["tmp_name"];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath1);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $cif_list_from_excel = [];
            $sqlGetAllCIFs = "SELECT CIF FROM `shgdetails`";
            $resGetAllCIFs = mysqli_query($conn, $sqlGetAllCIFs);
            if (!$resGetAllCIFs) {
                die("Error retrieving CIFs: " . mysqli_error($conn));
            }
            $cif_list_from_db = [];
            while ($row = mysqli_fetch_assoc($resGetAllCIFs)) {
                $cif_list_from_db[] = $row['CIF'];
            }
            $count = 1;
            foreach ($data as $row) {
                if ($count == 1) {
                    $count++;
                    continue;
                } else {
                    $brCode = $row['0'];
                    $cif = $row['1'];
                    $shgName = openssl_encrypt($row['2'],$chiper,$key,$options,$iv);
                    $cif_list_from_excel[] = $cif;
                    echo $cif;
                    $sqlSearchQuery = "SELECT * FROM `shgdetails` WHERE `CIF` = $cif";
                    $res = mysqli_query($conn, $sqlSearchQuery);
                    if ($res) {
                        if (mysqli_num_rows($res) > 0) {
                            $updateQuery = "UPDATE `shgdetails` SET `BrCode` = '$brCode', `SHGName` = '$shgName' WHERE `shgdetails`.`CIF` = $cif;";
                            $res = mysqli_query($conn, $updateQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload SHG Details" . mysqli_error($conn));
                            }
                        } else {
                            $insertQuery = "INSERT INTO `shgdetails` (`BrCode`, `CIF`, `SHGName`) VALUES ('$brCode', '$cif', '$shgName');";
                            $res = mysqli_query($conn, $insertQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload SHG Details" . mysqli_error($conn));
                            }
                        }
                    } else {
                        die("Error retrieving CIFs: " . mysqli_error($conn));
                    }
                }
                $count++;
            }
            $cif_list_to_delete = array_diff($cif_list_from_db, $cif_list_from_excel);
            // if (!empty($cif_list_to_delete)) {
            //     $cif_list_to_delete_str = implode("','", $cif_list_to_delete);
            //     $deleteInLoan = "DELETE FROM `loan` WHERE `CIF` IN ('$cif_list_to_delete_str')";
            //     $deleteInMem = "DELETE FROM `memberdetails` WHERE `CIF` IN ('$cif_list_to_delete_str')";
            //     $deleteQuery = "DELETE FROM `shgdetails` WHERE `CIF` IN ('$cif_list_to_delete_str')";
            //     $res1 = mysqli_query($conn, $deleteInLoan);
            //     $res2 = mysqli_query($conn, $deleteInMem);
            //     if ($res1 && $res2) {
            //         $res = mysqli_query($conn, $deleteQuery);
            //         if (!$res) {
            //             $is_shg = false;
            //             die("Error deleting records: " . mysqli_error($conn));
            //         } else {
            //             $is_shg = true;
            //         }
            //     } else {
            //         die("Error deleting records: " . mysqli_error($conn));
            //     }
            // }
        }
        if ($fileName2!=null && in_array($file_ext2, $allowed_ext)) {
            $filePath2 = $_FILES["import_file2"]["tmp_name"];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath2);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $mcif_list_from_excel = [];
            $sqlGetAllmcifs = "SELECT mcif FROM `memberdetails`";
            $resGetAllmcifs = mysqli_query($conn, $sqlGetAllmcifs);
            if (!$resGetAllmcifs) {
                die("Error retrieving MCIFs: " . mysqli_error($conn));
            }
            $mcif_list_from_db = [];
            while ($row = mysqli_fetch_assoc($resGetAllmcifs)) {
                $mcif_list_from_db[] = $row['mcif'];
            }
            $count = 1;
            foreach ($data as $row) {
                if ($count == 1) {
                    $count++;
                    continue;
                } else {
                    $CIF = $row['0'];
                    $mcif = $row['1'];
                    $name = $row['2'];
                    $dob = $row['3'];
                    $age = calculateAge($dob);
                    $gender = $row['4'];
                    $marital = $row['5'];
                    $kpn = $row['6'];
                    $kpr = $row['7'];
                    $nname = $row['8'];
                    $nrel = $row['9'];
                    $nage = $row['10'];
                    $vid = $row['11'];
                    $uid = $row['12'];
                    $pan = $row['13'];
                    $ration = $row['14'];
                    $telind = $row['15'];
                    $telphn = $row['16'];
                    $accBankName = $row['17'];
                    $accBranchName = $row['18'];
                    $accAccNo = $row['19'];
                    $occ = $row['20'];
                    $mincome = $row['21'];
                    $mexp = $row['22'];
                    $caste = $row['23'];
                    $gli = $row['24'];
                    $padd = $row['25'];
                    $psc = $row['26'];
                    $ppc = $row['27'];
                    $cadd = $row['28'];
                    $csc = $row['29'];
                    $cpc = $row['30'];
                    $mcif_list_from_excel[] = $mcif;
                    $sqlSearchQuery = "SELECT * FROM `memberdetails` WHERE `mcif` = $mcif";
                    $res = mysqli_query($conn, $sqlSearchQuery);
                    if ($res) {
                        if (mysqli_num_rows($res) > 0) {
                            $updateQuery = "UPDATE `memberdetails` 
                                SET `CIF` = '$CIF', 
                                `name` = '$name', 
                                `dob` = '$dob', 
                                `age` = '$age', 
                                `gender` = '$gender', 
                                `marital` = '$marital', 
                                `kpn` = '$kpn', 
                                `kpr` = '$kpr', 
                                `nname` = '$nname', 
                                `nrel` = '$nrel', 
                                `nage` = '$nage', 
                                `vid` = '$vid', 
                                `uid` = '$uid', 
                                `pan` = '$pan', 
                                `ration` = '$ration', 
                                `telind` = '$telind', 
                                `telphn` = '$telphn', 
                                `accBankName` = '$accBankName', 
                                `accBranchName` = '$accBranchName', 
                                `accAccNo` = '$accAccNo', 
                                `occ` = '$occ', 
                                `mincome` = '$mincome', 
                                `mexp` = '$mexp', 
                                `caste` = '$caste', 
                                `gli` = '$gli', 
                                `padd` = '$padd', 
                                `psc` = '$psc', 
                                `ppc` = '$ppc', 
                                `cadd` = '$cadd', 
                                `csc` = '$csc', 
                                `cpc` = '$cpc' 
                                WHERE `mcif` = '$mcif'";
                            $res = mysqli_query($conn, $updateQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload Member Details" . mysqli_error($conn));
                            }
                        } else {
                            $insertQuery = "INSERT INTO `memberdetails` (`CIF`, `mcif`, `name`, `dob`, `age`, `gender`, `marital`, `kpn`, `kpr`, `nname`, `nrel`, `nage`, `vid`, `uid`, `pan`, `ration`, `telind`, `telphn`, `accBankName`, `accBranchName`, `accAccNo`, `occ`, `mincome`, `mexp`, `caste`, `gli`, `padd`, `psc`, `ppc`, `cadd`, `csc`, `cpc`) VALUES ('$CIF', '$mcif', '$name', '$dob', '$age', '$gender', '$marital', '$kpn', '$kpr', '$nname', '$nrel', '$nage', '$vid', '$uid', '$pan', '$ration', '$telind', '$telphn', '$accBankName', '$accBranchName', '$accAccNo', '$occ', '$mincome', '$mexp', '$caste', '$gli', '$padd', '$psc', '$ppc', '$cadd', '$csc', '$cpc');";
                            $res = mysqli_query($conn, $insertQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload Member Details" . mysqli_error($conn));
                            }
                        }
                    } else {
                        die("Error retrieving MCIFs: " . mysqli_error($conn));
                    }
                }
                $count++;
            }
            $mcif_list_to_delete = array_diff($mcif_list_from_db, $mcif_list_from_excel);
            // if (!empty($mcif_list_to_delete)) {
            //     $mcif_list_to_delete_str = implode("','", $mcif_list_to_delete);
            //     $deleteQuery = "DELETE FROM `memberdetails` WHERE `mcif` IN ('$mcif_list_to_delete_str')";
            //     $res = mysqli_query($conn, $deleteQuery);
            //     if (!$res) {
            //         $is_mem = false;
            //         die("Error deleting records: " . mysqli_error($conn));
            //     } else {
            //         $is_mem = true;
            //     }
            // }
        }
        if ($fileName3!=null && in_array($file_ext3, $allowed_ext)) {
            $filePath3 = $_FILES["import_file3"]["tmp_name"];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath3);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $cif_list_from_loan_excel = [];
            $sqlGetAllLoancifs = "SELECT CIF FROM `loan`";
            $resGetAllLoancifs = mysqli_query($conn, $sqlGetAllLoancifs);
            if (!$resGetAllLoancifs) {
                die("Error retrieving MCIFs: " . mysqli_error($conn));
            }
            $cif_list_from_loan_db = [];
            while ($row = mysqli_fetch_assoc($resGetAllLoancifs)) {
                $cif_list_from_loan_db[] = $row['CIF'];
            }
            $count = 1;
            foreach ($data as $row) {
                if ($count == 1) {
                    $count++;
                    continue;
                } else {
                    $accNo = $row['0'];
                    $loo = $row['1'];
                    $date = $row['2'];
                    $lc = $row['3'];
                    $CIF = $row['4'];
                    $purpose = $row['5'];
                    $accSt = $row['6'];
                    $adate = $row['7'];
                    $sdate = $row['8'];
                    $odate = $row['9'];
                    $cdate = $row['10'];
                    $amtSanc = $row['11'];
                    $Tamt = $row['12'];
                    $noi = $row['13'];
                    $repFrq = $row['14'];
                    $minAmtDue = $row['15'];
                    $curBal = $row['16'];
                    $amtOvr = $row['17'];
                    $dpd = $row['18'];
                    $cif_list_from_loan_excel[] = $CIF;
                    $sqlSearchQuery = "SELECT * FROM `loan` WHERE `CIF`=$CIF";
                    $res = mysqli_query($conn, $sqlSearchQuery);
                    if ($res) {
                        if (mysqli_num_rows($res) > 0) {
                            $updateQuery = "UPDATE `loan` SET `accNo` = '$accNo', `loo` = '$loo', `date` = '$date', `lc` = '$lc', `purpose` = '$purpose', `accSt` = '$accSt', `adate` = '$adate', `sdate` = '$sdate', `odate` = '$odate', `cdate` = '$cdate', `amtSanc` = '$amtSanc', `Tamt` = '$Tamt', `noi` = '$noi', `repFrq` = '$repFrq', `minAmtDue` = '$minAmtDue', `curBal` = '$curBal', `amtOvr` = '$amtOvr', `dpd` = '$dpd' WHERE `CIF` = '$CIF';";
                            $res = mysqli_query($conn, $updateQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload Loan Details" . mysqli_error($conn));
                            }
                        } else {
                            $insertQuery = "INSERT INTO `loan` (`accNo`, `loo`, `date`, `lc`, `CIF`, `purpose`, `accSt`, `adate`, `sdate`, `odate`, `cdate`, `amtSanc`, `Tamt`, `noi`, `repFrq`, `minAmtDue`, `curBal`, `amtOvr`, `dpd`) VALUES ('$accNo', '$loo', '$date', '$lc', '$CIF', '$purpose', '$accSt', '$adate', '$sdate', '$odate', '$cdate', '$amtSanc', '$Tamt', '$noi', '$repFrq', '$minAmtDue', '$curBal', '$amtOvr', '$dpd');";
                            $res = mysqli_query($conn, $insertQuery);
                            if ($res) {
                                $_SESSION["query_err"]=true;
                            } else {
                                $_SESSION["query_err"]=false;
                                die("Unable to upload Loan Details" . mysqli_error($conn));
                            }
                        }
                    } else {
                        die("Error retrieving Loan CIFs: " . mysqli_error($conn));
                    }
                }
                $count++;
            }
            $cif_loan_list_to_delete = array_diff($cif_list_from_loan_db, $cif_list_from_loan_excel);
            // if (!empty($cif_loan_list_to_delete)) {
            //     $cif_loan_list_to_delete_str = implode("','", $cif_loan_list_to_delete);
            //     $deleteQuery = "DELETE FROM `loan` WHERE `CIF` IN ('$cif_loan_list_to_delete_str')";
            //     $res = mysqli_query($conn, $deleteQuery);
            //     if (!$res) {
            //         $is_loan = false;
            //         die("Error deleting records: " . mysqli_error($conn));
            //     } else {
            //         $is_loan = true;
            //     }
            // }
        }
    }
    else
    {
        header("location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCOB | SHG</title>
    <link rel="icon" sizes="32x32" href="./logo.jpeg">
</head>
<body>
    <div class="box">
        <?php
        if(isset($_SESSION["query_err"]) && $_SESSION["query_err"]==true)
        {
            unset($_SESSION["query_err"]);
            $_SESSION["msg"] = "Data Uploaded Sucessfully";
            header("location:upload.php");
        }
        ?>
    </div>
</body>
</html>