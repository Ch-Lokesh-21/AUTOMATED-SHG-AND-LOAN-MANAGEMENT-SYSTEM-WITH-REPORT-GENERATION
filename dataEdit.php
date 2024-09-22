<?php
session_start();
include 'connection.php';
if (!$conn) {
    die("Unable to Connect to Data Base");
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
if (isset($_POST["mdeleting"])) {
    $Mcif = $_POST["mdeleting"];
    $delete_query = "DELETE FROM `memberdetails` WHERE `memberdetails`.`mcif` = $Mcif;";
    if ($conn) {
        if (mysqli_query($conn, $delete_query)) {
            $is_mdelete = true;
        } else {
            $is_mdelete = false;
            die("Unable to Delete Member's Delete" . mysqli_error($conn));
        }
    }
}
if (isset($_POST["mupdate"])) {
    $Mcif = $_POST["mupd1"];
    $Cif = $_POST["mupd2"];
    $Name = $_POST["mupd3"];
    $Dob = $_POST["mupd4"];
    $Age = $_POST["mupd5"];
    $Gender = $_POST["mupd6"];
    $Marital = $_POST["mupd7"];
    $Kpn = $_POST["mupd8"];
    $Kpr = $_POST["mupd9"];
    $Nname = $_POST["mupd10"];
    $Nrel = $_POST["mupd11"];
    $Nage = $_POST["mupd12"];
    $Vid = $_POST["mupd13"];
    $Uid = $_POST["mupd14"];
    $Pan = $_POST["mupd15"];
    $Ration = $_POST["mupd16"];
    $Telind = $_POST["mupd17"];
    $Telphn = $_POST["mupd18"];
    $AccBankName = $_POST["mupd19"];
    $AccBranchName = $_POST["mupd20"];
    $AccAccNo = $_POST["mupd21"];
    $Occ = $_POST["mupd22"];
    $Mincome = $_POST["mupd23"];
    $Mexp = $_POST["mupd24"];
    $Caste = $_POST["mupd25"];
    if (isset($_POST["mupd26"]))
        $Gli = $_POST["mupd26"];
    else
        $Gli = null;
    $Padd = $_POST["mupd27"];
    $Psc = $_POST["mupd28"];
    $Ppc = $_POST["mupd29"];
    $Cadd = $_POST["mupd31"];
    $Csc = $_POST["mupd32"];
    $Cpc = $_POST["mupd33"];
    $update_query = "UPDATE `memberdetails` SET 
        `CIF` = '$Cif',  
        `name` = '$Name', 
        `dob` = '$Dob', 
        `age` = '$Age', 
        `gender` = '$Gender', 
        `marital` = '$Marital', 
        `kpn` = '$Kpn', 
        `kpr` = '$Kpr', 
        `nname` = '$Nname', 
        `nrel` = '$Nrel', 
        `nage` = '$Nage', 
        `vid` = '$Vid', 
        `uid` = '$Uid', 
        `pan` = '$Pan', 
        `ration` = '$Ration', 
        `telind` = '$Telind', 
        `telphn` = '$Telphn', 
        `accBankName` = '$AccBankName', 
        `accBranchName` = '$AccBranchName', 
        `accAccNo` = '$AccAccNo', 
        `occ` = '$Occ', 
        `mincome` = '$Mincome', 
        `mexp` = '$Mexp', 
        `caste` = '$Caste', 
        `gli` = '$Gli', 
        `padd` = '$Padd', 
        `psc` = '$Psc', 
        `ppc` = '$Ppc', 
        `cadd` = '$Cadd', 
        `csc` = '$Csc', 
        `cpc` = '$Cpc' 
        WHERE `mcif` = '$Mcif'";
    if ($conn) {
        if (mysqli_query($conn, $update_query)) {
            $is_update = true;
        } else {
            $is_update = false;
            die("Unable to Update Member's data");
        }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
</head>

<body>
    <!-- Delete Member Modal -->
    <div class="modal fade" id="mdelete" tabindex="-1" aria-labelledby="mdeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="mdeleteLabel">Delete SHG</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Are You Sure Do You Want to Delete This Member ?</h3>
                    <form action="dataEdit.php" method="post">
                        <input type="hidden" name="mdeleting" id="mdeleting">
                        <input type="hidden" name="mdelcif" id="mdelcif">
                </div>
                <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <input type="submit" class="btn btn-primary" value="Yes">
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="nav-bar">
        <div class="nav-img">
            <img src="./logo.jpeg" alt="APCOB">
        </div>
        <div class="nav-msg">
            <b>Andhra Pradesh State Cooperative Bank Ltd.</b>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php
                    if (isset($_SESSION["admin"]) && isset($Admin)) {
                        echo $Admin;
                    } else if (isset($_SESSION["user"]) && isset($UserBrName)) {
                        echo $UserBrName;
                    } else {
                        echo "user";
                    }
                    ?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="display.php">Home</a></li>
                    <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mcmds">
        <?php
        if (isset($is_mdelete)) {
            if ($is_mdelete) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Member Deleted</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        if (isset($is_update)) {
            if ($is_update) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Member Details Upated</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        ?>
    </div>
    <div class="edit-box">
        <table class="table table-hover" id="editdataTable">
            <thead>
                <tr>
                    <th scope="col">Options</th>
                    <th scope="col">S.No</th>
                    <th scope="col">CIF No</th>
                    <th scope="col">SHG Name</th>
                    <th scope="col">MCIF No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Age</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Marital Status</th>
                    <th scope="col">Key Person Name</th>
                    <th scope="col">Key Person Relation</th>
                    <th scope="col">Nominee Name</th>
                    <th scope="col">Nominee Relation</th>
                    <th scope="col">Nominee Age</th>
                    <th scope="col">VID</th>
                    <th scope="col">UID</th>
                    <th scope="col">PAN</th>
                    <th scope="col">Ration Card</th>
                    <th scope="col">Telephone Indicator</th>
                    <th scope="col">Telephone Number</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">Account Number</th>
                    <th scope="col">Occupation</th>
                    <th scope="col">Monthly Income</th>
                    <th scope="col">Monthly Expense</th>
                    <th scope="col">Caste</th>
                    <th scope="col">Group Leader Indicator</th>
                    <th scope="col">Permanent Address</th>
                    <th scope="col">Permanent State Code</th>
                    <th scope="col">Permanent Pincode</th>
                    <th scope="col">Current Address</th>
                    <th scope="col">Current State Code</th>
                    <th scope="col">Current Pincode</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($conn) {
                    if (isset($_POST['editcif'])) {
                        $Cif = $_POST['editcif'];
                        $sql_query = "SELECT * FROM `memberdetails` NATURAL JOIN `shgdetails` WHERE CIF=$Cif;";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row["telphn"] == 0)
                                    $row["telphn"] = null;
                                if ($row["nage"] == 0)
                                    $row["nage"] = null;
                                $count++;
                                echo ' <tr>
                                <td>
                                    <div class="edit-opt">
                                        <form method="post" action="dataUpdate.php">
                                            <input type="hidden" name="mdumcif" id="mdumcif" value="' . $row["mcif"] . '">
                                            <button class="mupd btn btn-info ' . $row["CIF"] . '" id=' . $row["mcif"] . '>Update Member</button>
                                        </form>
                                        <button class="mdel btn btn-danger ' . $row["CIF"] . '" id=' . 'd' . $row["mcif"] . '>Delete Member</button>
                                    </div>
                                </td>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">' . $row["mcif"] . '</td>
                                <td scope="row">' . $row["name"] . '</td>
                                <td scope="row">' . $row["dob"] . '</td>
                                <td scope="row">' . $row["age"] . '</td>
                                <td scope="row">' . $row["gender"] . '</td>
                                <td scope="row">' . $row["marital"] . '</td>
                                <td scope="row">' . $row["kpn"] . '</td>
                                <td scope="row">' . $row["kpr"] . '</td>
                                <td scope="row">' . $row["nname"] . '</td>
                                <td scope="row">' . $row["nrel"] . '</td>
                                <td scope="row">' . $row["nage"] . '</td>
                                <td scope="row">' . $row["vid"] . '</td>
                                <td scope="row">' . $row["uid"] . '</td>
                                <td scope="row">' . $row["pan"] . '</td>
                                <td scope="row">' . $row["ration"] . '</td>
                                <td scope="row">' . $row["telind"] . '</td>
                                <td scope="row">' . $row["telphn"] . '</td>
                                <td scope="row">' . $row["accBankName"] . '</td>
                                <td scope="row">' . $row["accBranchName"] . '</td>
                                <td scope="row">' . $row["accAccNo"] . '</td>
                                <td scope="row">' . $row["occ"] . '</td>
                                <td scope="row">' . $row["mincome"] . '</td>
                                <td scope="row">' . $row["mexp"] . '</td>
                                <td scope="row">' . $row["caste"] . '</td>
                                <td scope="row">' . $row["gli"] . '</td>
                                <td scope="row">' . $row["padd"] . '</td>
                                <td scope="row">' . $row["psc"] . '</td>
                                <td scope="row">' . $row["ppc"] . '</td>
                                <td scope="row">' . $row["cadd"] . '</td>
                                <td scope="row">' . $row["csc"] . '</td>
                                <td scope="row">' . $row["cpc"] . '</td>
                              </tr>';
                            }
                        }
                    } else if (isset($is_mdelete)) {
                        if ($is_mdelete) {
                            $Cif = $_POST['mdelcif'];
                            $sql_query = "SELECT * FROM `memberdetails` NATURAL JOIN `shgdetails` WHERE CIF=$Cif;";
                            $result = mysqli_query($conn, $sql_query);
                            if ($result) {
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row["telphn"] == 0)
                                        $row["telphn"] = null;
                                    if ($row["nage"] == 0)
                                        $row["nage"] = null;
                                    $count++;
                                    echo ' <tr>
                                    <td>
                                        <div class="edit-opt">
                                            <form method="post" action="dataUpdate.php">
                                                <input type="hidden" name="mdumcif" id="mdumcif" value="' . $row["mcif"] . '">
                                                <button class="mupd btn btn-info ' . $row["CIF"] . '" id=' . $row["mcif"] . '>Update Member</button>
                                            </form>
                                            <button class="mdel btn btn-danger ' . $row["CIF"] . '" id=' . 'd' . $row["mcif"] . '>Delete Member</button>
                                        </div>
                                    </td>
                                    <td scope="row">' . $count . '</td>
                                    <td scope="row">' . $row["CIF"] . '</td>
                                    <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv)  . '</td>
                                    <td scope="row">' . $row["mcif"] . '</td>
                                    <td scope="row">' . $row["name"] . '</td>
                                    <td scope="row">' . $row["dob"] . '</td>
                                    <td scope="row">' . $row["age"] . '</td>
                                    <td scope="row">' . $row["gender"] . '</td>
                                    <td scope="row">' . $row["marital"] . '</td>
                                    <td scope="row">' . $row["kpn"] . '</td>
                                    <td scope="row">' . $row["kpr"] . '</td>
                                    <td scope="row">' . $row["nname"] . '</td>
                                    <td scope="row">' . $row["nrel"] . '</td>
                                    <td scope="row">' . $row["nage"] . '</td>
                                    <td scope="row">' . $row["vid"] . '</td>
                                    <td scope="row">' . $row["uid"] . '</td>
                                    <td scope="row">' . $row["pan"] . '</td>
                                    <td scope="row">' . $row["ration"] . '</td>
                                    <td scope="row">' . $row["telind"] . '</td>
                                    <td scope="row">' . $row["telphn"] . '</td>
                                    <td scope="row">' . $row["accBankName"] . '</td>
                                    <td scope="row">' . $row["accBranchName"] . '</td>
                                    <td scope="row">' . $row["accAccNo"] . '</td>
                                    <td scope="row">' . $row["occ"] . '</td>
                                    <td scope="row">' . $row["mincome"] . '</td>
                                    <td scope="row">' . $row["mexp"] . '</td>
                                    <td scope="row">' . $row["caste"] . '</td>
                                    <td scope="row">' . $row["gli"] . '</td>
                                    <td scope="row">' . $row["padd"] . '</td>
                                    <td scope="row">' . $row["psc"] . '</td>
                                    <td scope="row">' . $row["ppc"] . '</td>
                                    <td scope="row">' . $row["cadd"] . '</td>
                                    <td scope="row">' . $row["csc"] . '</td>
                                    <td scope="row">' . $row["cpc"] . '</td>
                                  </tr>';
                                }
                            }
                        }
                    } else {
                        if (isset($is_update) && $is_update) {
                            $Cif = $_POST['mupd2'];
                            $sql_query = "SELECT * FROM `memberdetails` NATURAL JOIN `shgdetails` WHERE CIF=$Cif;";
                            $result = mysqli_query($conn, $sql_query);
                            if ($result) {
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row["telphn"] == 0)
                                        $row["telphn"] = null;
                                    if ($row["nage"] == 0)
                                        $row["nage"] = null;
                                    $count++;
                                    echo ' <tr>
                                    <td>
                                        <div class="edit-opt">
                                            <form method="post" action="dataUpdate.php">
                                                <input type="hidden" name="mdumcif" id="mdumcif" value="' . $row["mcif"] . '">
                                                <button class="mupd btn btn-info ' . $row["CIF"] . '" id=' . $row["mcif"] . '>Update Member</button>
                                            </form>
                                            <button class="mdel btn btn-danger ' . $row["CIF"] . '" id=' . 'd' . $row["mcif"] . '>Delete Member</button>
                                        </div>
                                    </td>
                                    <td scope="row">' . $count . '</td>
                                    <td scope="row">' . $row["CIF"] . '</td>
                                    <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv)  . '</td>
                                    <td scope="row">' . $row["mcif"] . '</td>
                                    <td scope="row">' . $row["name"] . '</td>
                                    <td scope="row">' . $row["dob"] . '</td>
                                    <td scope="row">' . $row["age"] . '</td>
                                    <td scope="row">' . $row["gender"] . '</td>
                                    <td scope="row">' . $row["marital"] . '</td>
                                    <td scope="row">' . $row["kpn"] . '</td>
                                    <td scope="row">' . $row["kpr"] . '</td>
                                    <td scope="row">' . $row["nname"] . '</td>
                                    <td scope="row">' . $row["nrel"] . '</td>
                                    <td scope="row">' . $row["nage"] . '</td>
                                    <td scope="row">' . $row["vid"] . '</td>
                                    <td scope="row">' . $row["uid"] . '</td>
                                    <td scope="row">' . $row["pan"] . '</td>
                                    <td scope="row">' . $row["ration"] . '</td>
                                    <td scope="row">' . $row["telind"] . '</td>
                                    <td scope="row">' . $row["telphn"] . '</td>
                                    <td scope="row">' . $row["accBankName"] . '</td>
                                    <td scope="row">' . $row["accBranchName"] . '</td>
                                    <td scope="row">' . $row["accAccNo"] . '</td>
                                    <td scope="row">' . $row["occ"] . '</td>
                                    <td scope="row">' . $row["mincome"] . '</td>
                                    <td scope="row">' . $row["mexp"] . '</td>
                                    <td scope="row">' . $row["caste"] . '</td>
                                    <td scope="row">' . $row["gli"] . '</td>
                                    <td scope="row">' . $row["padd"] . '</td>
                                    <td scope="row">' . $row["psc"] . '</td>
                                    <td scope="row">' . $row["ppc"] . '</td>
                                    <td scope="row">' . $row["cadd"] . '</td>
                                    <td scope="row">' . $row["csc"] . '</td>
                                    <td scope="row">' . $row["cpc"] . '</td>
                                  </tr>';
                                }
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery js -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- data tables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="./script.js"></script>
    <script>
    $(document).ready(function() {
        $('#editdataTable').DataTable();
    });
    let deletes = document.getElementsByClassName('mdel');
    Array.from(deletes).forEach((val) => {
        val.addEventListener("click", (e) => {
            let mcif = e.target.id.substr(1, );
            let cif = e.target.getAttribute("class").substr(20, );
            mdeleting.value = mcif;
            mdelcif.value = cif;
            $('#mdelete').modal('toggle');
        });
    });
    </script>
</body>

</html>