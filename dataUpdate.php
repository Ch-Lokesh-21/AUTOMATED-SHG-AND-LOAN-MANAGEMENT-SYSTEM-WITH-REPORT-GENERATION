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
if (isset($_POST["mdumcif"])) {
    $mcif = $_POST["mdumcif"];
    $sqlSearchQuery = "SELECT * FROM `memberdetails` WHERE `mcif` = $mcif";
    $res = mysqli_query($conn, $sqlSearchQuery);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
        } else {
            $row = null;
        }
    }
} else {
    $row = null;
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
    <div class="nav-bar" id="upd-nav-bar">
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
    <div class="dubox">
        <b>Update Member Details </b>
        <form action="dataEdit.php" method="post">
            <div class="mem mb-3">
                <input type="hidden" name="mupdate" id="mupdate">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd1" name="mupd1"  required readonly>
                    <label for="mupd1">MCIF Number<span class="required">*</span></label>
                </div>
                <input type="hidden" name="mupd2" id="mupd2" placeholder="CIF Number">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd3" name="mupd3" placeholder="Name" required>
                    <label for="mupd3">Name<span class="required">*</span></label>
                </div>
                <div class="form-check mb-3">
                    <h6>Date of Birth<span class="required">*</span></h6>
                    <input class="form-control" type="date" name="mupd4" id="mupd4" required oninput="findAge()">
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd5" name="mupd5" placeholder="Age" readonly required>
                    <label for="mupd5">Age<span class="required">*</span></label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd6">Select Gender<span class="required">*</span></label></b>
                    <select name="mupd6" id="mupd6" required>
                        <option selected value="">Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd7">Select Marital Status<span class="required">*</span></label></b>
                    <select name="mupd7" id="mupd7" required>
                        <option selected value="">Select Status</option>
                        <option value="M01">Married</option>
                        <option value="M02">Separated</option>
                        <option value="M03">Divorced</option>
                        <option value="M04">Widowed</option>
                        <option value="M05">Unmarried</option>
                        <option value="M06">Untagged</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd8" name="mupd8" placeholder="Key Person Name" required>
                    <label for="mupd8">Key Person Name<span class="required">*</span></label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd9">Select Key Person Relation<span class="required">*</span></label></b>
                    <select name="mupd9" id="mupd9" required>
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
                    <input type="text" class="form-control" id="mupd10" name="mupd10" placeholder="Nominee Name">
                    <label for="mupd10">Nominee Name</label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd11">Select Nominee Relation </label></b>
                    <select name="mupd11" id="mupd11">
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
                    <input type="number" class="form-control" id="mupd12" name="mupd12" placeholder="Nominee Age">
                    <label for="mupd12">Nominee Age</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd13" name="mupd13" placeholder="Voter ID">
                    <label for="mupd13">Voter ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd14" name="mupd14" placeholder="UID" required>
                    <label for="mupd14">UID<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd15" name="mupd15" placeholder="PAN Card Number">
                    <label for="mupd15">PAN Card Number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd16" name="mupd16" placeholder="Ration Card Number">
                    <label for="mupd16">Ration Card Number</label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd17">Telephone Number Type Indicator </label></b>
                    <select name="mupd17" id="mupd17">
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
                    <input type="number" class="form-control" id="mupd18" name="mupd18" placeholder="Telephone Number">
                    <label for="mupd18">Telephone Number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd19" name="mupd19" placeholder="Bank name">
                    <label for="mupd19">Bank name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd20" name="mupd20" placeholder="Branch name">
                    <label for="mupd20">Branch name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd21" name="mupd21" placeholder="Acccount number">
                    <label for="mupd21">Account number</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd22" name="mupd22" placeholder="Occupation">
                    <label for="mupd22">Occupation</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd23" name="mupd23" placeholder="Monthly Income" step="0.01" required>
                    <label for="mupd23">Monthly Income<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd24" name="mupd24" placeholder="Monthly Expense" step="0.01" required>
                    <label for="mupd24">Monthly Expense<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd25" name="mupd25" placeholder="Caste">
                    <label for="mupd25">Caste</label>
                </div>
                <div class="form-check mb-3">
                    <b><label for="mupd26">Group Leader Indicator </label></b>
                    <select name="mupd26" id="mupd26">
                        <option value=""selected>Group Leader Indicator</option>
                        <option value="N">No</option>
                        <option value="Y">Yes</option>
                    </select>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd27" name="mupd27" placeholder="Permanent Address" required>
                    <label for="mupd27">Permanent Address<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd28" name="mupd28" placeholder="State Code" required>
                    <label for="mupd28">State Code<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd29" name="mupd29" placeholder="Pin Code" required>
                    <label for="mupd29">Pin Code<span class="required">*</span></label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="mupd30" name="mupd30" onclick="sameAsPermanent()">
                    <label class="form-check-label" for="mupd30">Same as Permanent Address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd31" name="mupd31" placeholder="Current Address" required>
                    <label for="mupd31">Current Address<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mupd32" name="mupd32" placeholder="State Code" required>
                    <label for="mupd32">State Code<span class="required">*</span></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="mupd33" name="mupd33" placeholder="Pin Code" required>
                    <label for="mupd33">Pin Code<span class="required">*</span></label>
                </div>
            </div>
            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery js -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- data tables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="./script.js"></script>
    <script>
        <?php if ($row) : ?>
            document.getElementById('mupd1').value = <?php echo json_encode($row["mcif"]); ?>;
            document.getElementById('mupd2').value = <?php echo json_encode($row["CIF"]); ?>;
            document.getElementById('mupd3').value = <?php echo json_encode($row["name"]); ?>;
            document.getElementById('mupd4').value = <?php echo json_encode($row["dob"]); ?>;
            document.getElementById('mupd5').value = <?php echo json_encode($row["age"]); ?>;
            document.getElementById('mupd6').value = <?php echo json_encode($row["gender"]); ?>;
            document.getElementById('mupd7').value = <?php echo json_encode($row["marital"]); ?>;
            document.getElementById('mupd8').value = <?php echo json_encode($row["kpn"]); ?>;
            document.getElementById('mupd9').value = <?php echo json_encode($row["kpr"]); ?>;
            document.getElementById('mupd10').value = <?php echo json_encode($row["nname"]); ?>;
            document.getElementById('mupd11').value = <?php echo json_encode($row["nrel"]); ?>;
            document.getElementById('mupd12').value = <?php if ($row["nage"] == 0) echo json_encode(null);
                                                        else echo json_encode($row["nage"]); ?>;
            document.getElementById('mupd13').value = <?php echo json_encode($row["vid"]); ?>;
            document.getElementById('mupd14').value = <?php echo json_encode($row["uid"]); ?>;
            document.getElementById('mupd15').value = <?php echo json_encode($row["pan"]); ?>;
            document.getElementById('mupd16').value = <?php echo json_encode($row["ration"]); ?>;
            document.getElementById('mupd17').value = <?php echo json_encode($row["telind"]); ?>;
            document.getElementById('mupd18').value = <?php if ($row["telphn"] == 0) echo json_encode(null);
                                                        else echo json_encode($row["telphn"]); ?>;
            document.getElementById('mupd19').value = <?php echo json_encode($row["accBankName"]); ?>;
            document.getElementById('mupd20').value = <?php echo json_encode($row["accBranchName"]); ?>;
            document.getElementById('mupd21').value = <?php echo json_encode($row["accAccNo"]); ?>;
            document.getElementById('mupd22').value = <?php echo json_encode($row["occ"]); ?>;
            document.getElementById('mupd23').value = <?php echo json_encode($row["mincome"]); ?>;
            document.getElementById('mupd24').value = <?php echo json_encode($row["mexp"]); ?>;
            document.getElementById('mupd25').value = <?php echo json_encode($row["caste"]); ?>;
            document.getElementById('mupd26').value = <?php if ($row["gli"] == null) echo json_encode(null);
                                                        else echo json_encode($row["gli"]); ?>;
            document.getElementById('mupd27').value = <?php echo json_encode($row["padd"]); ?>;
            document.getElementById('mupd28').value = <?php echo json_encode($row["psc"]); ?>;
            document.getElementById('mupd29').value = <?php echo json_encode($row["ppc"]); ?>;
            document.getElementById('mupd31').value = <?php echo json_encode($row["cadd"]); ?>;
            document.getElementById('mupd32').value = <?php echo json_encode($row["csc"]); ?>;
            document.getElementById('mupd33').value = <?php echo json_encode($row["cpc"]); ?>;
        <?php endif; ?>
    </script>
    <script>
        function sameAsPermanent() {
            let checkBox = document.getElementById(`mupd30`);
            if (checkBox.checked) {
                document.getElementById(`mupd31`).value = document.getElementById(`mupd27`).value;
                document.getElementById(`mupd32`).value = document.getElementById(`mupd28`).value;
                document.getElementById(`mupd33`).value = document.getElementById(`mupd29`).value;
            } else {
                document.getElementById(`mupd31`).value = null;
                document.getElementById(`mupd32`).value = null;
                document.getElementById(`mupd33`).value = null;
            }
        }

        function findAge(idx) {
            let dobValue = document.getElementById(`mupd4`).value;
            if (dobValue) {
                let dob = new Date(dobValue);
                let today = new Date();
                let age = parseInt(today.getFullYear() - dob.getFullYear());
                let monthDifference = today.getMonth() - dob.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                if (age < 0) {
                    document.getElementById(`mupd5`).value = null;
                    alert(`Enter valid Date of Birth`);
                    return;
                }
                document.getElementById(`mupd5`).value = age;
            } else {
                document.getElementById(`mupd5`).value = null;
            }
        }
    </script>
</body>

</html>