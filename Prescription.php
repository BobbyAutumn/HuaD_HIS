<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['add'])) {
    $medID = $_POST['medID'];
    $caseID = $_GET['caseID'];
    $numDose = $_POST['numDose'];
    $querymed = "SELECT m.* FROM Medicine m WHERE m.medID='$medID'";
    $resultmed = $mysqli->query($querymed);
    $medinfo = $resultmed->fetch_array();
    $totalPrice = $medinfo['priceperdose'] * $numDose;
    $leftdose = $medinfo['amountdose'] - $numDose;

    $staffID = $_SESSION['staffID'];

    if ($leftdose <= 0) {
        echo 'error';
    } else {
        $staffID =  $_SESSION['staffID'];
        date_default_timezone_set('Asia/Bangkok');
        $regisTime = date('Y-m-d H:i:s');

        $query = "SELECT MAX(TRIM(LEADING 'I' FROM prescriptionID)) as prescription_id FROM Prescription;";
        $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
        $row = $result->fetch_assoc();
        $last_prescription_id = empty($row['prescription_id']) ? 0 : $row['prescription_id'];
        $lastnumid = ltrim($last_prescription_id, "0");
        $prescriptionID = 'I' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

        $query = "SELECT MAX(TRIM(LEADING 'L' FROM stockID)) as stock_id FROM Stocking;";
        $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
        $row = $result->fetch_assoc();
        $last_stock_id = empty($row['stock_id']) ? 0 : $row['stock_id'];
        $lastnumid = ltrim($last_stock_id, "0");
        $stockID = 'L' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

        $insertquery = "INSERT INTO Prescription (prescriptionID, medID,caseID,numDose,totalPrice) VALUES ('$prescriptionID', '$medID','$caseID','$numDose','$totalPrice')";
        $result = $mysqli->query($insertquery);
        $insertquery2 = "INSERT INTO Stocking (stockID, medID,staffID,amount,regisTime,Type) VALUES ('$stockID', '$medID','$staffID','$numDose','$regisTime','Drop(Prescription)')";
        $result2 = $mysqli->query($insertquery2);
        if($result2){

        } else{
            $mysqli->error;
        }
        $queryupdate2 = "UPDATE Medicine SET amountdose='$leftdose' WHERE medID='$medID'";
        $resultupdate2 = $mysqli->query($queryupdate2);

        $queryupdate = "UPDATE PatientCase SET totalCost = totalCost + '$totalPrice' WHERE caseID='$caseID'";
        $resultupdate = $mysqli->query($queryupdate);
    }
}
$caseID = $_GET['caseID'];
$patientquery = "SELECT p.*,c.* FROM Patient p,PatientCase c WHERE c.caseID = '$caseID' AND p.patientID=c.patientID";
$medquery = "SELECT c.*,m.*,p.* FROM PatientCase c, Medicine m, Prescription p WHERE p.caseID='$caseID' AND c.caseID=p.caseID AND m.medID=p.medID";
$querystaff = "SELECT s.*,c.*,r.* FROM Staff s,PatientCase c,StaffRole r WHERE c.caseID = '$caseID' AND s.staffID=c.staffID AND r.roleID=s.roleID";
$resultpatient = $mysqli->query($patientquery);
$resultstaff = $mysqli->query($querystaff);
$resultmed = $mysqli->query($medquery);
$caseinfo = $resultpatient->fetch_array();
$staffinfo = $resultstaff->fetch_array();
$totalquery = "SELECT SUM(totalPrice) AS total FROM Prescription WHERE caseID='$caseID'";
$resulttotal = $mysqli->query($totalquery);
$total = $resulttotal->fetch_array();
$total = $total['total'];

$queryupdate = "UPDATE PatientCase SET medCost='$total' WHERE caseID='$caseID'";
$resultupdate = $mysqli->query($queryupdate);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body style="overflow-x:hidden;">
    <div class="h-100 border-right" style="float: left; width: 18%; position: fixed;">
        <div class="container ml-0">
            <div class="row border-bottom h-25 ml-0">
                <div class="col-md-12 ml-3 my-3"><img class="img-fluid d-block w-75" src="pic/Hua-D logo.png"></div>
            </div>
            <?php
            if ($_SESSION['accountType'] == 'Admin' || $_SESSION['accountType'] == 'Doctor') {
                echo '<a href="patientinformation.php">
                <div class="row border-bottom bg-info">
                <div class="col-md-4 my-auto"><img class="img-fluid d-block w-75" src="pic/patientinfo.png"></div>
                <div class="col-md-8 my-3">
                    <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Patient Information</h6>
                </div>
                </div>
            </a>';
            }
            ?>
            <?php
            if ($_SESSION['accountType'] == 'Admin' || $_SESSION['accountType'] == 'HR') {
                echo '<a href="staffinformation.php">
                <div class="row border-bottom ">
                <div class="col-md-4 my-auto"><img class="img-fluid d-block w-75" src="pic/staffinfo.png"></div>
                <div class="col-md-8 my-3">
                    <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Staff Information</h6>
                </div>
                </div>
            </a>';
            }
            ?>
            <?php
            if ($_SESSION['accountType'] == 'Admin' || $_SESSION['accountType'] == 'Pharmacist') {
                echo '<a href="medicinestock.php">
                <div class="row border-bottom">
                <div class="col-md-4 my-auto"><img class="img-fluid d-block w-75" src="pic/medstock.png"></div>
                <div class="col-md-8 my-3">
                    <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Medicine Stocking</h6>
                </div>
                </div>
            </a>';
            }
            ?>
            <a href="myprofile.php">
                <div class="row border-bottom">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-3" src="pic/profile.png"></div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">My Profile</h6>
                    </div>
                </div>
            </a>
            <div class="row h-50">
                <div class="d-flex col-md-12 mt-5 h-50 justify-content-center"><a class="btn btn-outline-dark mt-0 " href="logout.php">Logout <i class="fa fa-sign-out fa-fw"></i> </a></div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-left: 20.5%;">
        <div class="row">
            <h2 class="mt-3 text-primary" style="font-weight: 400;">Prescription</h2>
        </div>
        <div class="col-md-10" style="margin-left: 5%;">
            <div class="row">
                <label class="col-form-label col-2">Case ID: </label>
                <div class="col-4 form-group mb-0">
                    <div class="form-control" style="border:none; box-shadow:none;"><?php echo $caseinfo['caseID'] ?></div>
                </div>
                <label class="col-form-label col-2 text-center">Patient Name: </label>
                <div class="col-3 form-group mb-0">
                    <div class="form-control" style="border:none; box-shadow:none;"><?php echo $caseinfo['patientTitle'] . ' ' . $caseinfo['patientFN'] . ' ' . $caseinfo['patientLN'] ?></div>
                </div>
            </div>
            <div class="row">
                <label class="col-form-label col-2">Doctor Name: </label>
                <div class="col-4 form-group mb-0">
                    <div class="form-control" style="border:none; box-shadow:none;"><?php echo $staffinfo['staffTitle'] . ' ' . $staffinfo['staffFN'] . ' ' . $staffinfo['staffLN'] ?></div>
                </div>
                <label class="col-form-label col-2 text-center">Role: </label>
                <div class="col-3 form-group mb-0">
                    <div class="form-control" style="border:none; box-shadow:none;"><?php echo $staffinfo['roleName'] ?></div>
                </div>
            </div>
            <form class="row" method="post" action="Prescription.php?caseID=<?php echo $caseID ?>">
                <label class="col-form-label col-2">Medicine ID: </label>
                <div class="col-3 form-group">
                    <input type="text" class="form-control" placeholder="Enter MedID" name="medID">
                </div>
                <label class="col-form-label col-2 text-center">Dose: </label>
                <div class="col-3 form-group">
                    <input type="text" class="form-control" placeholder="Enter Dose" name="numDose">
                </div>
                <div class="col form-group">
                    <button type="submit" class="btn btn-primary " name="add">Add Medicine</button>
                </div>
            </form>
        </div>
        <div class="row ml-3 mr-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="w-100 table table-striped table-borderless table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Medicine Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Price/Dose</th>
                                <th scope="col">Gram/Dose</th>
                                <th scope="col">Dose</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($info = $resultmed->fetch_array()) {
                                echo "<tr>";
                                echo "<td>" . $info["medName"] . "</td>";
                                echo "<td>" . $info["brand"] . "</td>";
                                echo "<td>" . $info["priceperdose"] . "</td>";
                                echo "<td>" . $info["gramperdose"] . "</td>";
                                echo "<td>" . $info["numDose"] . "</td>";
                                echo "<td>" . $info["totalPrice"] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-form-label col-2">Total Price: </label>
            <div class="col-4 form-group">
                <div class="form-control" style="border:none; box-shadow:none;"><?php echo $total ?> Baht</div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>