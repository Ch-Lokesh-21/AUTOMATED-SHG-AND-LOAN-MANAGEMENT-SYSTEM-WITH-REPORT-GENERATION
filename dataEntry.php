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
$count = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APCOB | SHG</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" sizes="32x32" href="./logo.jpeg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
</head>

<body>
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
    <div class="dbox">
        <div class="details">
            <?php
            echo '<p>Group CIF No : <b>' . $_POST["getcif"] . '</b></p>';
            echo '<p>SHG Name : <b>' . openssl_decrypt($_POST["getshgname"],$chiper,$key,$options,$iv) . '</b></p>';
            echo '<p>Br No : <b>' . $_POST["getbrcode"] . '</b></p>';
            echo '<p>Branch Name : <b>' . $_POST["getbrname"] . '</b></p>';
            ?>
        </div>
        <div class="btn-box">
            <button type="button" class="btn btn-success" onclick="addMember()">Add Member</button>
            <button type="button" class="btn btn-danger" onclick="deleteMember()">Delete Member</button>
        </div>
        <form action="dataInsert.php" method="post">
            <input type="hidden" name="dataSub" id="dataSub">
            <input type="hidden" name="gcif" id="gcif" value="<?php echo $_POST['getcif']; ?>">
            <input type="hidden" name="gbrcode" id="gbrcode" value="<?php echo $_POST['getbrcode']; ?>">
            <?php
            for ($i = 1; $i <= $count; $i++) {
            ?>
                <div class="mem mb-3" id="mem<?php echo $i; ?>">
                    <h5 id="mem<?php echo $i; ?>heading">Member <?php echo $i; ?> Details</h5>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i; ?>mcif" name="m<?php echo $i; ?>mcif" placeholder="MCIF Number" required>
                        <label for="m<?php echo $i; ?>mcif">MCIF Number <span class="required">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>name" name="m<?php echo $i; ?>name" placeholder="Name" required>
                        <label for="m<?php echo $i; ?>name">Name <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <h6>Date of Birth <span class="required">*</span></h6>
                        <input class="form-control" type="date" name="m<?php echo $i; ?>dob" id="m<?php echo $i; ?>dob" required oninput="findAge(<?php echo $i ?>)">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i; ?>age" name="m<?php echo $i; ?>age" placeholder="Age" readonly required>
                        <label for="m<?php echo $i; ?>age">Age <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i; ?>gender">Select Gender <span class="required">*</span></label></b>
                        <select name="m<?php echo $i; ?>gender" id="m<?php echo $i; ?>gender" required>
                            <option selected value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>                                                                                                                                                                                                                                                                                                                               
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i; ?>marital">Select Marital Status <span class="required">*</span></label></b>
                        <select name="m<?php echo $i; ?>marital" id="m<?php echo $i; ?>marital" required>
                            <option selected value="">Select Marital Status</option>
                            <option value="M01">Married</option>
                            <option value="M02">Separated</option>
                            <option value="M03">Divorced</option>
                            <option value="M04">Widowed</option>
                            <option value="M05">Unmarried</option>
                            <option value="M06">Untagged</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>keypn" name="m<?php echo $i; ?>keypn" placeholder="Key Person Name" required>
                        <label for="m<?php echo $i; ?>keypn">Key Person Name <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i; ?>keyrel">Select Key Person Relation <span class="required">*</span></label></b>
                        <select name="m<?php echo $i; ?>keyrel" id="m<?php echo $i; ?>keyrel" required>
                            <option selected value="">Select Relation</option>
                            <option value="K01">Father</option>
                            <option value="K02">Husband</option>
                            <option value="K03">Mother</option>
                            <option value="K04">Son</option>
                            <option value="K05">Daughter</option>
                            <option value="K06">Wife</option>
                            <option value="K07">Brother</option>
                            <option value="K08">Mother-In-law</option>
                            <option value="K09">Father-In-law</option>
                            <option value="K10">Daugther-In-law</option>
                            <option value="K11">Sister-In-law</option>
                            <option value="K12">Son-In-law</option>
                            <option value="K13">Brother-In-law</option>
                            <option value="K15">Other</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>nominame" name="m<?php echo $i; ?>nominame" placeholder="Nominee Name">
                        <label for="m<?php echo $i; ?>nominame">Nominee Name</label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i; ?>nomrel">Select Nominee Relation </label></b>
                        <select name="m<?php echo $i; ?>nomrel" id="m<?php echo $i; ?>nomrel">
                            <option selected value="">Select Relation</option>
                            <option value="K01">Father</option>
                            <option value="K02">Husband</option>
                            <option value="K03">Mother</option>
                            <option value="K04">Son</option>
                            <option value="K05">Daughter</option>
                            <option value="K06">Wife</option>
                            <option value="K07">Brother</option>
                            <option value="K08">Mother-In-law</option>
                            <option value="K09">Father-In-law</option>
                            <option value="K10">Daugther-In-law</option>
                            <option value="K11">Sister-In-law</option>
                            <option value="K12">Son-In-law</option>
                            <option value="K13">Brother-In-law</option>
                            <option value="K15">Other</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i; ?>nomage" name="m<?php echo $i; ?>nomage" placeholder="Nominee Age">
                        <label for="m<?php echo $i; ?>nomage">Nominee Age</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>voteid" name="m<?php echo $i; ?>voteid" placeholder="Voter ID">
                        <label for="m<?php echo $i; ?>voteid">Voter ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>uid" name="m<?php echo $i; ?>uid" placeholder="UID" required>
                        <label for="m<?php echo $i; ?>uid">UID <span class="required">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>pan" name="m<?php echo $i; ?>pan" placeholder="PAN Card Number">
                        <label for="m<?php echo $i; ?>pan">PAN Card Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>ration" name="m<?php echo $i; ?>ration" placeholder="Ration Card Number">
                        <label for="m<?php echo $i; ?>ration">Ration Card Number</label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i ?>telind">Telephone Number Type Indicator </label></b>
                        <select name="m<?php echo $i ?>telind" id="m<?php echo $i ?>telind">
                            <option selected value="">Select Type</option>
                            <option value="P01">Residence</option>
                            <option value="P02">Company</option>
                            <option value="P03">Mobile</option>
                            <option value="P04">Permanent</option>
                            <option value="P07">Other</option>
                            <option value="P08">Untagged</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i; ?>telphone" name="m<?php echo $i; ?>telphone" placeholder="Telephone Number">
                        <label for="m<?php echo $i; ?>telphone">Telephone Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>accbankname" name="m<?php echo $i; ?>accbankname" placeholder="Bank name">
                        <label for="m<?php echo $i; ?>accbankname">Bank name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>accbankbranch" name="m<?php echo $i; ?>accbankbranch" placeholder="Branch name">
                        <label for="m<?php echo $i; ?>accbankbranch">Branch name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>accbanknum" name="m<?php echo $i; ?>accbanknum" placeholder="Account number">
                        <label for="m<?php echo $i; ?>accbanknum">Account number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i; ?>occupation" name="m<?php echo $i; ?>occupation" placeholder="Occupation">
                        <label for="m<?php echo $i; ?>occupation">Occupation</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i ?>monincome" name="m<?php echo $i ?>monincome" placeholder="Monthly Income" step="0.01" required>
                        <label for="m<?php echo $i ?>monincome">Monthly Income <span class="required">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i ?>monexp" name="m<?php echo $i ?>monexp" placeholder="Monthly Expense" step="0.01" required>
                        <label for="m<?php echo $i ?>monexp">Monthly Expense <span class="required">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i ?>caste" name="m<?php echo $i ?>caste" placeholder="Caste">
                        <label for="m<?php echo $i ?>caste">Caste</label>
                    </div>

                    <div class="form-check mb-3">
                        <b><label for="m<?php echo $i ?>gli">Group Leader Indicator </label></b>
                        <select name="m<?php echo $i ?>gli" id="m<?php echo $i ?>gli">
                            <option value="">Select</option>
                            <option value="N">No</option>
                            <option value="Y">Yes</option>
                        </select>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i ?>padd" name="m<?php echo $i ?>padd" placeholder="Permanent Address" required>
                        <label for="m<?php echo $i ?>padd">Permanent Address <span class="required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i ?>psc" name="m<?php echo $i ?>psc" placeholder="State Code" required>
                        <label for="m<?php echo $i ?>psc">State Code <span class="required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i ?>ppc" name="m<?php echo $i ?>ppc" placeholder="Pin Code" required>
                        <label for="m<?php echo $i ?>ppc">Pin Code <span class="required">*</span></label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="m<?php echo $i ?>sap" name="m<?php echo $i ?>sap" onclick="sameAsPermanent(<?php echo $i ?>)">
                        <label class="form-check-label" for="m<?php echo $i ?>sap">Same as Permanent Address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i ?>cadd" name="m<?php echo $i ?>cadd" placeholder="Current Address" required>
                        <label for="m<?php echo $i ?>cadd">Current Address <span class="required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m<?php echo $i ?>csc" name="m<?php echo $i ?>csc" placeholder="State Code" required>
                        <label for="m<?php echo $i ?>csc">State Code <span class="required">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m<?php echo $i ?>cpc" name="m<?php echo $i ?>cpc" placeholder="Pin Code" required>
                        <label for="m<?php echo $i ?>cpc">Pin Code <span class="required">*</span></label>
                    </div>
                </div>
            <?php
            }
            ?>
            <input type="hidden" name="gcount" id="gcount" value="1">
            <button type="submit" class="btn btn-primary" id="getsub" name="getsub">Submit</button>
        </form>
    </div>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- jquery js  -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- data tables  -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="./script.js"></script>
    <script>
        let count = <?php echo $count; ?>;

        function addMember() {
            count++;
            let subBtn = document.getElementById("getsub");
            let newMember = `
                <div class="mem mb-3" id="mem${count}">
                    <h5 id="mem${count}heading">Member ${count} Details</h5>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m${count}mcif" name="m${count}mcif" placeholder="MCIF Number" required>
                        <label for="m${count}mcif">MCIF Number <span class="required">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m${count}name" name="m${count}name" placeholder="Name" required>
                        <label for="m${count}name">Name <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <h6>Date of Birth <span class="required">*</span></h6>
                        <input class="form-control" type="date" name="m${count}dob" id="m${count}dob" required oninput="findAge(${count})" required>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m${count}age" name="m${count}age"
                        placeholder="Age" readonly required>
                        <label for="m${count}age">Age <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m${count}gender">Select Gender <span class="required">*</span></label></b>
                        <select name="m${count}gender" id="m${count}gender" required>
                            <option selected value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m${count}marital">Select Marital Status <span class="required">*</span></label></b>
                        <select name="m${count}marital" id="m${count}marital" required>
                            <option selected value="">Select Marital Status</option>
                            <option value="M01">Married</option>
                            <option value="M02">Separated</option>
                            <option value="M03">Divorced</option>
                            <option value="M04">Widowed</option>
                            <option value="M05">Unmarried</option>
                            <option value="M06">Untagged</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m${count}keypn" name="m${count}keypn" placeholder="Key Person Name" required>
                        <label for="m${count}keypn">Key Person Name <span class="required">*</span></label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m${count}keyrel">Select Key Person Relation <span class="required">*</span></label></b>
                        <select name="m${count}keyrel" id="m${count}keyrel" required>
                            <option selected value="">Select Relation</option>
                            <option value="K01">Father</option>
                            <option value="K02">Husband</option>
                            <option value="K03">Mother</option>
                            <option value="K04">Son</option>
                            <option value="K05">Daughter</option>
                            <option value="K06">Wife</option>
                            <option value="K07">Brother</option>
                            <option value="K08">Mother-In-law</option>
                            <option value="K09">Father-In-law</option>
                            <option value="K10">Daugther-In-law</option>
                            <option value="K11">Sister-In-law</option>
                            <option value="K12">Son-In-law</option>
                            <option value="K13">Brother-In-law</option>
                            <option value="K15">Other</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m${count}nominame" name="m${count}nominame" placeholder="Nominee Name">
                        <label for="m${count}nominame">Nominee Name</label>
                    </div>
                    <div class="form-check mb-3">
                        <b><label for="m${count}nomrel">Select Nominee Relation </label></b>
                        <select name="m${count}nomrel" id="m${count}nomrel">
                            <option selected value="">Select Relation</option>
                            <option value="K01">Father</option>
                            <option value="K02">Husband</option>
                            <option value="K03">Mother</option>
                            <option value="K04">Son</option>
                            <option value="K05">Daughter</option>
                            <option value="K06">Wife</option>
                            <option value="K07">Brother</option>
                            <option value="K08">Mother-In-law</option>
                            <option value="K09">Father-In-law</option>
                            <option value="K10">Daugther-In-law</option>
                            <option value="K11">Sister-In-law</option>
                            <option value="K12">Son-In-law</option>
                            <option value="K13">Brother-In-law</option>
                            <option value="K15">Other</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="m${count}nomage" name="m${count}nomage" placeholder="Nominee Age">
                        <label for="m${count}nomage">Nominee Age</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="m${count}voteid" name="m${count}voteid" placeholder="Voter ID">
                        <label for="m${count}voteid">Voter ID</label>
                    </div>
                    <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}uid" name="m${count}uid"
                        placeholder="UID" required>
                    <label for="m${count}uid">UID <span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}pan" name="m${count}pan"
                        placeholder="PAN Card Number" >
                    <label for="m${count}pan">PAN Card Number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}ration"
                        name="m${count}ration" placeholder="Ration Card Number" >
                    <label for="m${count}ration">Ration Card Number</label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="m${count}telind">Telephone Number Type Indicator </label></b>
                    <select name="m${count}telind" id="m${count}telind">
                        <option selected value="">Select Type</option>
                        <option value="P01">Residence</option>
                        <option value="P02">Company</option>
                        <option value="P03">Mobile</option>
                        <option value="P04">Permanent</option>
                        <option value="P07">Other</option>
                        <option value="P08">Untagged</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="m${count}telphone" name="m${count}telphone" placeholder="Telephone Number">
                    <label for="m${count}telphone">Telephone Number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}accbankname" name="m${count}accbankname" placeholder="Bank name">
                    <label for="m${count}accbankname">Bank name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}accbankbranch" name="m${count}accbankbranch" placeholder="Branch name">
                    <label for="m${count}accbankbranch">Branch name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}accbanknum" name="m${count}accbanknum" placeholder="Account number">
                    <label for="m${count}accbanknum">Account number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}occupation" name="m${count}occupation" placeholder="Occupation">
                    <label for="m${count}occupation">Occupation</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="m${count}monincome" name="m${count}monincome" placeholder="Monthly Income" step="0.01" required>
                    <label for="m${count}monincome">Monthly Income <span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="m${count}monexp" name="m${count}monexp" placeholder="Monthly Expense" step="0.01" required>
                    <label for="m${count}monexp">Monthly Expense <span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}caste" name="m${count}caste" placeholder="Caste">
                    <label for="m${count}caste">Caste</label>
                </div>

                <div class="form-check mb-3">
                    <b><label for="m${count}gli">Group Leader Indicator </label></b>
                    <select name="m${count}gli" id="m${count}gli">
                        <option value="">Select</option>
                        <option value="N">No</option>
                        <option value="Y">Yes</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}padd" name="m${count}padd"
                        placeholder="Permanent Address" required>
                    <label for="m${count}padd">Permanent Address <span class="required">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}psc" name="m${count}psc"
                        placeholder="State Code" required>
                    <label for="m${count}psc">State Code <span class="required">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="m${count}ppc" name="m${count}ppc"
                        placeholder="Pin Code" required>
                    <label for="m${count}ppc">Pin Code <span class="required">*</span></label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="m${count}sap" name="m${count}sap" onclick="sameAsPermanent(${count})">
                    <label class="form-check-label" for="m${count}sap">Same as Permanent Address</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}cadd" name="m${count}cadd"
                        placeholder="Current Address" required>
                    <label for="m${count}cadd">Current Address <span class="required">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}csc" name="m${count}csc"
                        placeholder="State Code" required>
                    <label for="m${count}csc">State Code <span class="required">*</span></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="m${count}cpc" name="m${count}cpc"
                        placeholder="Pin Code" required>
                    <label for="m${count}cpc">Pin Code <span class="required">*</span></label>
                </div>
                </div>
            `;
            subBtn.insertAdjacentHTML('beforebegin', newMember);
            document.getElementById("gcount").value = count;
        }

        function deleteMember() {
            if (count > 1) {
                let ele = document.getElementById(`mem${count}`);
                ele.remove();
                count--;
                document.getElementById("gcount").value = count;
            } else {
                alert("There is only one member in the group");
            }
        }

        function sameAsPermanent(idx) {
            let checkBox = document.getElementById(`m${idx}sap`);
            if (checkBox.checked) {
                document.getElementById(`m${idx}cadd`).value = document.getElementById(`m${idx}padd`).value;
                document.getElementById(`m${idx}csc`).value = document.getElementById(`m${idx}psc`).value;
                document.getElementById(`m${idx}cpc`).value = document.getElementById(`m${idx}ppc`).value;
            } else {
                document.getElementById(`m${idx}cadd`).value = null;
                document.getElementById(`m${idx}csc`).value = null;
                document.getElementById(`m${idx}cpc`).value = null;
            }
        }

        function findAge(idx) {
            let dobValue = document.getElementById(`m${idx}dob`).value;
            if (dobValue) {
                let dob = new Date(dobValue);
                let today = new Date();
                let age = parseInt(today.getFullYear() - dob.getFullYear());
                let monthDifference = today.getMonth() - dob.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                if (age < 0) {
                    document.getElementById(`m${idx}age`).value = null;
                    alert(`Enter valid Date of Birth for Member ${idx}`);
                    return;
                }
                document.getElementById(`m${idx}age`).value = age;
            } else {
                document.getElementById(`m${idx}age`).value = null;
            }
        }
    </script>
</body>

</html>