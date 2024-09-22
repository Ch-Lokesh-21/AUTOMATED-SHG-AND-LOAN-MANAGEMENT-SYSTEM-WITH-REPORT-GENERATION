<?php
session_start();
include 'connection.php';
if (!$conn) {
    die("Unable to Connect to DataBase");
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
if ($conn) {
    if (isset($_POST["adding"])) {
        $BrCode = $_POST["addbranch"];
        $Cif = $_POST["addcif"];
        $shgName= openssl_encrypt($_POST["addshgname"],$chiper,$key,$options,$iv);
        $insert_query = "INSERT INTO `shgdetails`(`BrCode`, `CIF`, `SHGName`) VALUES ('$BrCode','$Cif','$shgName')";
        if (mysqli_query($conn, $insert_query)) {
            $is_insert = true;
        } else {
            $is_insert = false;
            die("Unable to Add SHG Name" . mysqli_error($conn));
        }
    }
    if (isset($_POST["deleting"])) {
        $Cif = $_POST["deleting"];
        $sqlSearchQuery = "SELECT * FROM `shgdetails` WHERE `CIF` = $Cif";
        $res = mysqli_query($conn, $sqlSearchQuery);
        if (!$res) {
            die("Unable to Delete SHG");
        }
        if ($res) {
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
            } else {
                $row = null;
                header('location:display.php');
            }
        }
        $brCode = $row["BrCode"];
        $deleteInLoan = "DELETE FROM `loan` WHERE `loan`.`CIF` =$Cif";
        $deleteInMem = "DELETE FROM `memberdetails` WHERE `memberdetails`.`CIF` = $Cif ";
        $deleteQuery = "DELETE FROM `shgdetails` WHERE `shgdetails`.`CIF` = $Cif ";
        $res1 = mysqli_query($conn, $deleteInLoan);
        $res2 = mysqli_query($conn, $deleteInMem);
        if ($res1 && $res2) {
            $res = mysqli_query($conn, $deleteQuery);
            if ($res) {
                $is_delete = true;
            } else {
                $is_delete = false;
                die("Unable to Delete SHG");
            }
        } else {
            $is_delete = false;
            die("Unable to Delete SHG");
        }
    }
    if (isset($_POST["updating"])) {
        $BrCode = $_POST["upbranch"];
        $Cif = $_POST["upcif"];
        $shgName = openssl_encrypt($_POST["upshgname"],$chiper,$key,$options,$iv);
        $update_query = "UPDATE `shgdetails` SET `BrCode`='$BrCode',`SHGName`='$shgName' WHERE `CIF`=$Cif";
        if (mysqli_query($conn, $update_query)) {
            $is_update = true;
        } else {
            $is_update = false;
            die("Unable to Update SHG");
        }
    }
} else {
    die("Unable to Connect to Data Base");
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
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- data tables css  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
</head>

<body>
    <!-- Add shg Modal -->
    <div class="modal fade" id="addgrp" tabindex="-1" aria-labelledby="addgrpLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addgrpLabel">Add SHG</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="display.php" method="post">
                        <label for="addbranch">Choose a branch : </label>
                        <select name="addbranch" id="addbranch">
                            <?php
                            if (isset($_SESSION["admin"])) {
                                echo '<option value="6">Tirupati</option>
                            <option value="26">Governorpet</option>
                            <option value="61">Brundavan Gardens</option>
                            <option value="62">Gannavaram</option>
                            <option value="63">KR Market</option>
                            <option value="64">Ramavarappadu</option>
                            <option value="65">Gollapudi</option>
                            <option value="66">Venugopal Nagar</option>
                            <option value="67">Rayapudi</option>
                            <option value="68">Kanuru</option>
                            <option value="69">Currency Nagar</option>
                            <option value="70">Mangalagiri</option>
                            <option value="71">Moghalrajapuram</option>
                            <option value="72">Chenchupeta</option>
                            <option value="73">AT Agraharam </option>
                            <option value="74">Hanuman Junction</option>
                            <option value="75">Challapalli</option>';
                            } else if (isset($_SESSION["user"])) {
                                echo '<option value="' . $UserBr . '" selected>' . $UserBrName . '</option>';
                            }
                            ?>
                        </select>
                        <div class="form-floating mb-3 mt-3">
                            <input type="number" class="form-control" id="addcif" name="addcif" placeholder="CIF Number" required>
                            <label for="addcif">CIF Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="addshgname" name="addshgname" placeholder="SHG Name" required>
                            <label for="addshgname">SHG Name</label>
                        </div>

                        <input type="hidden" name="adding" id="adding">
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Del shg Modal -->
    <div class="modal fade" id="deletegrp" tabindex="-1" aria-labelledby="deletegrpLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deletegrpLabel">Delete SHG</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Are You Sure Do You Want to Delete SHG ?</h3>
                    <form action="display.php" method="post">
                        <input type="hidden" name="deleting" id="deleting">
                </div>
                <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <input type="submit" class="btn btn-primary" value="Yes">
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- update shg modal -->
    <div class="modal fade" id="upgrp" tabindex="-1" aria-labelledby="upgrpLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upgrpLabel">Update SHG</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="display.php" method="post">
                        <label for="upbranch">Choose a branch : </label>
                        <select name="upbranch" id="upbranch">
                            <?php
                            if (isset($_SESSION["admin"])) {
                                echo '<option value="6">Tirupati</option>
                            <option value="26">Governorpet</option>
                            <option value="61">Brundavan Gardens</option>
                            <option value="62">Gannavaram</option>
                            <option value="63">KR Market</option>
                            <option value="64">Ramavarappadu</option>
                            <option value="65">Gollapudi</option>
                            <option value="66">Venugopal Nagar</option>
                            <option value="67">Rayapudi</option>
                            <option value="68">Kanuru</option>
                            <option value="69">Currency Nagar</option>
                            <option value="70">Mangalagiri</option>
                            <option value="71">Moghalrajapuram</option>
                            <option value="72">Chenchupeta</option>
                            <option value="73">AT Agraharam </option>
                            <option value="74">Hanuman Junction</option>
                            <option value="75">Challapalli</option>';
                            } else if (isset($_SESSION["user"])) {
                                echo '<option value="' . $UserBr . '" selected>' . $UserBrName . '</option>';
                            }
                            ?>
                        </select>
                        <div class="form-floating mb-3 mt-3">
                            <input type="number" class="form-control" id="upcif" name="upcif" placeholder="CIF Number" required readonly>
                            <label for="upcif">CIF Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="upshgname" name="upshgname" placeholder="SHG Name" required>
                            <label for="upshgname">SHG Name</label>
                        </div>
                        <input type="hidden" name="updating" id="updating">
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
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
                    <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="grp-cmd mt-3 mb-3">
            <div class="insert">
                <?php
                if (isset($is_insert)) {
                    if ($is_insert) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>SHG Added</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
                if (isset($is_delete)) {
                    if ($is_delete) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>SHG Deleted</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
                if (isset($is_update)) {
                    if ($is_update) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>SHG Updated</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>' . $_SESSION['message'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        unset($_SESSION['message']);
                }
                ?>
            </div>
        </div>
        <div class="int-cont">
            <?php
            if (isset($_SESSION["admin"])) {
                echo '<div class="inp">
                <form action="display.php" method="post">
                    <label for="branch">Choose a branch : </label>
                    <select name="branch" id="branch">
                        <option selected>Select Branch</option>
                        <option value="6">Tirupati</option>
                        <option value="26">Governorpet</option>
                        <option value="61">Brundavan Gardens</option>
                        <option value="62">Gannavaram</option>
                        <option value="63">KR Market</option>
                        <option value="64">Ramavarappadu</option>
                        <option value="65">Gollapudi</option>
                        <option value="66">Venugopal Nagar</option>
                        <option value="67">Rayapudi</option>
                        <option value="68">Kanuru</option>
                        <option value="69">Currency Nagar</option>
                        <option value="70">Mangalagiri</option>
                        <option value="71">Moghalrajapuram</option>
                        <option value="72">Chenchupeta</option>
                        <option value="73">AT Agraharam </option>
                        <option value="74">Hanuman Junction</option>
                        <option value="75">Challapalli</option>
                    </select>
                    <input type="submit" value="Submit" class="btn btn-success">
                </form>
            </div>';
            }
            ?>
            <div class="grp-opts">
                <button type="button" class="btn btn-primary" id="add-grp-btn">Add SHG</button>
                <?php
                    if(isset($_SESSION["admin"]))
                    {
                        echo '<a href="upload.php"><button type="button" class="btn btn-success" id="upl">Upload Data</button></a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="lcontainer">
        <table class="table table-hover" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">CIF No</th>
                    <th scope="col">Branch Code</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">SHG Name</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($conn) {
                    if (isset($_POST['branch']) && $_POST['branch']!="Select Branch") {
                        $brCode = $_POST['branch'];
                        $sql_query = "SELECT * FROM `branches` NATURAL JOIN `shgdetails` WHERE BrCode=$brCode;";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo ' <tr>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . $row["BrCode"] . '</td>
                                <td scope="row">' . $row["BrName"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">
                                <div class="opti">
                                <form action="dataEntry.php" method="post" class="edit-form">
                                <input type="hidden" name="getcif" id="getcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="getbrcode" id="getbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="getbrname" id="getbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="getshgname" id="getshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-primary">Add Members</button>
                                </form>
                                <button class="upd btn btn-secondary" id=' . $row['CIF'] . '>Update SHG</button>
                                <button class="del btn btn-danger" id=' . 'd' . $row["CIF"] . '>Delete SHG</button>
                                <form action="dataEdit.php" method="post" class="edit-form">
                                <input type="hidden" name="editcif" id="editcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="editbrcode" id="editbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="editbrname" id="editbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="editshgname" id="editshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-success">Edit Members</button>
                                </form>
                                </div>
                                </td>
                              </tr>';
                            }
                        }
                    } else if (isset($_SESSION["user"])) {
                        $sql_query = "SELECT * FROM `branches` NATURAL JOIN `shgdetails` WHERE BrCode=$UserBr";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo ' <tr>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . $row["BrCode"] . '</td>
                                <td scope="row">' . $row["BrName"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">
                                <div class="opti">
                                <form action="dataEntry.php" method="post" class="edit-form">
                                <input type="hidden" name="getcif" id="getcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="getbrcode" id="getbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="getbrname" id="getbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="getshgname" id="getshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-primary">Add Members</button>
                                </form>
                                <button class="upd btn btn-secondary" id=' . $row['CIF'] . '>Update SHG</button>
                                <button class="del btn btn-danger" id=' . 'd' . $row["CIF"] . '>Delete SHG</button>
                                <form action="dataEdit.php" method="post" class="edit-form">
                                <input type="hidden" name="editcif" id="editcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="editbrcode" id="editbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="editbrname" id="editbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="editshgname" id="editshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-success">Edit Members</button>
                                </form>
                                </div>
                                </td>
                              </tr>';
                            }
                        } else {
                            die("Unable to Fetch Data");
                        }
                    } else if (isset($_POST["adding"])) {
                        $brCode = $_POST["addbranch"];
                        $sql_query = "SELECT * FROM `branches` NATURAL JOIN `shgdetails` WHERE BrCode=$brCode";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo ' <tr>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . $row["BrCode"] . '</td>
                                <td scope="row">' . $row["BrName"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">
                                <div class="opti">
                                <form action="dataEntry.php" method="post" class="edit-form">
                                <input type="hidden" name="getcif" id="getcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="getbrcode" id="getbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="getbrname" id="getbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="getshgname" id="getshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-primary">Add Members</button>
                                </form>
                                <button class="upd btn btn-secondary" id=' . $row['CIF'] . '>Update SHG</button>
                                <button class="del btn btn-danger" id=' . 'd' . $row["CIF"] . '>Delete SHG</button>
                                <form action="dataEdit.php" method="post" class="edit-form">
                                <input type="hidden" name="editcif" id="editcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="editbrcode" id="editbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="editbrname" id="editbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="editshgname" id="editshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-success">Edit Members</button>
                                </form>
                                </div>
                                </td>
                              </tr>';
                            }
                        } else {
                            die("Unable to Fetch Data");
                        }
                    } else if (isset($_POST["updating"])) {
                        $brCode = $_POST["upbranch"];
                        $sql_query = "SELECT * FROM `branches` NATURAL JOIN `shgdetails` WHERE BrCode=$brCode";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo ' <tr>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . $row["BrCode"] . '</td>
                                <td scope="row">' . $row["BrName"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">
                                <div class="opti">
                                <form action="dataEntry.php" method="post" class="edit-form">
                                <input type="hidden" name="getcif" id="getcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="getbrcode" id="getbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="getbrname" id="getbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="getshgname" id="getshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-primary">Add Members</button>
                                </form>
                                <button class="upd btn btn-secondary" id=' . $row['CIF'] . '>Update SHG</button>
                                <button class="del btn btn-danger" id=' . 'd' . $row["CIF"] . '>Delete SHG</button>
                                <form action="dataEdit.php" method="post" class="edit-form">
                                <input type="hidden" name="editcif" id="editcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="editbrcode" id="editbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="editbrname" id="editbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="editshgname" id="editshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-success">Edit Members</button>
                                </form>
                                </div>
                                </td>
                              </tr>';
                            }
                        } else {
                            die("Unable to Fetch Data");
                        }
                    } else if (isset($_POST["deleting"])) {
                        $sql_query = "SELECT * FROM `branches` NATURAL JOIN `shgdetails` WHERE BrCode=$brCode";
                        $result = mysqli_query($conn, $sql_query);
                        if ($result) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo ' <tr>
                                <td scope="row">' . $count . '</td>
                                <td scope="row">' . $row["CIF"] . '</td>
                                <td scope="row">' . $row["BrCode"] . '</td>
                                <td scope="row">' . $row["BrName"] . '</td>
                                <td scope="row">' . openssl_decrypt($row["SHGName"],$chiper,$key,$options,$iv) . '</td>
                                <td scope="row">
                                <div class="opti">
                                <form action="dataEntry.php" method="post" class="edit-form">
                                <input type="hidden" name="getcif" id="getcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="getbrcode" id="getbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="getbrname" id="getbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="getshgname" id="getshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-primary">Add Members</button>
                                </form>
                                <button class="upd btn btn-secondary" id=' . $row['CIF'] . '>Update SHG</button>
                                <button class="del btn btn-danger" id=' . 'd' . $row["CIF"] . '>Delete SHG</button>
                                <form action="dataEdit.php" method="post" class="edit-form">
                                <input type="hidden" name="editcif" id="editcif" value="' . $row["CIF"] . '">
                                <input type="hidden" name="editbrcode" id="editbrcode" value="' . $row["BrCode"] . '">
                                <input type="hidden" name="editbrname" id="editbrname" value="' . $row["BrName"] . '">
                                <input type="hidden" name="editshgname" id="editshgname" value="' . $row["SHGName"] . '">
                                <button type="submit" class="btn btn-success">Edit Members</button>
                                </form>
                                </div>
                                </td>
                              </tr>';
                            }
                        } else {
                            die("Unable to Fetch Data");
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery js  -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- data tables  -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="./script.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        document.getElementById("add-grp-btn").addEventListener("click", () => {
            $('#addgrp').modal('toggle');
        });
        let deletes = document.getElementsByClassName('del');
        Array.from(deletes).forEach((val) => {
            val.addEventListener("click", (e) => {
                let cif = e.target.id.substr(1, );
                deleting.value = cif;
                $('#deletegrp').modal('toggle');
            });
        });
        let updates = document.getElementsByClassName('upd');
        Array.from(updates).forEach((val) => {
            val.addEventListener("click", (e) => {
                let tr = e.target.parentNode.parentNode.parentNode;
                let cif = e.target.id;
                let brco = tr.getElementsByTagName('td')[2].innerText;
                let brch = tr.getElementsByTagName('td')[3].innerText;
                let shgName = tr.getElementsByTagName('td')[4].innerText;
                upcif.value = cif;
                upbranch.value = brco;
                upshgname.value = shgName;
                $('#upgrp').modal('toggle');
            });
        });
    </script>
</body>

</html>