<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_GET['caseID'])) {
    $caseID = $_GET['caseID'];
    $query = "SELECT * FROM PatientCase WHERE caseID='$caseID'";
    $result = $mysqli->query($query);
    $caseinfo = $result->fetch_array();
    if (isset($_POST['editcase'])) {
        $medCost = $caseinfo['medCost'];
        $serviceCost = $_POST['serviceCost'];
        $totalCost = $medCost + $serviceCost;
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $sbp = $_POST['sbp'];
        $dbp = $_POST['dbp'];
        $diseaseName = $_POST['diseaseName'];
        $payMethod = $_POST['payMethod'];
        $payStatus = $_POST['payStatus'];
        $annotation = $_POST['annotation'];

        $querydisease = "SELECT diseaseID FROM Disease d WHERE d.diseaseName='$diseaseName'";
        $resultdisease = $mysqli->query($querydisease);
        $diseaseID = $resultdisease->fetch_array();
        $diseaseID = $diseaseID['diseaseID'];

        $queryupdate = "UPDATE PatientCase SET weight='$weight', height='$height', sbp='$sbp', 
dbp='$dbp', diseaseID='$diseaseID', payMethod='$payMethod',payStatus='$payStatus',annotation='$annotation', serviceCost='$serviceCost', totalCost='$totalCost' WHERE caseID='$caseID'";
        $resultupdate = $mysqli->query($queryupdate);
    }

    $querycase = "SELECT c.*,d.*,s.* FROM PatientCase c,Disease d,Staff s WHERE caseID='$caseID' AND d.diseaseID=c.diseaseID AND s.staffID=c.staffID";
    $querypatient = "SELECT p.*,c.* FROM Patient p,PatientCase c WHERE c.caseID = '$caseID' AND p.patientID=c.patientID";
    $querystaff = "SELECT s.*,c.*,r.* FROM Staff s,PatientCase c,StaffRole r WHERE c.caseID = '$caseID' AND s.staffID=c.staffID AND r.roleID=s.roleID";
    $resultcase = $mysqli->query($querycase);
    $resultpatient = $mysqli->query($querypatient);
    $resultstaff = $mysqli->query($querystaff);
    $caseinfo = $resultcase->fetch_array();
    $patientinfo = $resultpatient->fetch_array();
    $staffinfo = $resultstaff->fetch_array();
} else {
    $patientID = $_GET['patientID'];
    if (isset($_POST['addcase'])) {
        $idquery = "SELECT MAX(TRIM(LEADING 'C' FROM caseID)) as case_id FROM PatientCase;";
        $idresult = $mysqli->query($idquery) or die('There was an error running the query [' . $mysqli->error . ']');
        $row = $idresult->fetch_assoc();
        $last_case_id = empty($row['case_id']) ? 0 : $row['case_id'];
        $lastnumid = ltrim($last_case_id, "0");
        $caseID = 'C' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);


        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $sbp = $_POST['sbp'];
        $dbp = $_POST['dbp'];

        $diseaseName = $_POST['diseaseName'];
        $queryDisease = "SELECT diseaseID FROM Disease d WHERE d.diseaseName='$diseaseName'";
        $resultDisease = $mysqli->query($queryDisease);
        $disease = $resultDisease->fetch_array();
        $diseaseID = $disease['diseaseID'];

        $annotation = $_POST['annotation'];

        $staffID = $_SESSION['staffID'];

        date_default_timezone_set('Asia/Bangkok');
        $regisTime = date('Y-m-d H:i:s');

        $queryadd = "INSERT INTO PatientCase (caseID, patientID, weight,height,sbp,dbp,diseaseID,staffID,payStatus,regisTime,annotation) 
    VALUES ('$caseID', '$patientID','$weight','$height','$sbp','$dbp','$diseaseID','$staffID','Incomplete','$regisTime','$annotation')";
        $resultadd = $mysqli->query($queryadd);
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body>
    <div class="h-100 border-right " style="float: left; width: 18%; position: fixed;">
        <div class="container">
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
                <div class="row border-bottom">
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
        <div class="row ">
            <?php
            if (isset($_GET['caseID'])) {
                echo '<h2 class="mt-3 text-primary" style="font-weight: 400;">Case Information</h2>';
            } else {
                echo '<h2 class="mt-3 text-primary" style="font-weight: 400;">Add Case</h2>';
            }
            ?>

        </div>
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-10 mb-3" style="margin-left: 5%;">
                    <?php
                    if (isset($_GET['caseID'])) {
                        echo '<form action="CaseInformation.php?caseID=' . $caseinfo['caseID'] . '" method="post">
                        <div class="container">
                            <div class="row">
                                <label class="col-form-label col-2">Case ID: </label>
                                <div class="col-3 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $caseinfo['caseID'] . '</div>
                                </div>
                                <label class="col-form-label col-2 text-center">Patient ID: </label>
                                <div class="col-3 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $caseinfo['patientID'] . '</div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Patient Name: </label>
                                <div class="col-4 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $patientinfo['patientTitle'] . ' ' . $patientinfo['patientFN'] . ' ' . $patientinfo['patientLN'] . '</div>
                                </div>
                                <label class="col-form-label col-2 text-center">Register Time: </label>
                                <div class="col-3 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $caseinfo['regisTime'] . '</div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Doctor Name: </label>
                                <div class="col-4 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $staffinfo['staffTitle'] . ' ' . $staffinfo['staffFN'] . ' ' . $staffinfo['staffLN'] . '</div>
                                </div>
                                <label class="col-form-label col-2 text-center">Role: </label>
                                <div class="col-3 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $staffinfo['roleName'] . '</div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Weight: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Weight" name="weight" value="' . $caseinfo['weight'] . '">
                                </div>
                                <label class="col-form-label col-2 text-center">Height: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Height" name="height" value="' . $caseinfo['height'] . '">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Systolic BP: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter SBP" name="sbp" value="' . $caseinfo['sbp'] . '">
                                </div>
                                <label class="col-form-label col-2 text-center">Diastolic BP: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter DBP" name="dbp" value="' . $caseinfo['dbp'] . '">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Disease Name: </label>
                                <div class="col-3 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Disease" name="diseaseName" value="' . $caseinfo['diseaseName'] . '">
                                </div>
                                <label class="col-form-label col-2 text-center">Total Cost: </label>
                                <div class="col-2 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $caseinfo['totalCost'] . '</div>
                                </div>
                                
                                
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Service Cost: </label>
                                <div class="col-3 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Service Cost" name="serviceCost" value="' . $caseinfo['serviceCost'] . '">
                                </div>
                                <label class="col-form-label col-2 text-center">Medicine Cost: </label>
                                <div class="col-3 form-group">
                                    <div class="form-control" style="border:none; box-shadow:none;">' . $caseinfo['medCost'] . '</div>
                                </div>
                                <div class="col-2 form-group">
                                    <div class="form-control" style=" border:none; box-shadow:none;"><a href="Prescription.php?caseID=' . $caseID . '">Prescription</a></div> 
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Pay Method: </label>
                                <div class="col-3 form-group ">
                                    <select class="form-select form-control" name="payMethod">
                                        <option ';
                        if ($caseinfo['payMethod'] == 'Cash') {
                            echo 'selected';
                        }
                        echo '>Cash</option>
                                        <option ';
                        if ($caseinfo['payMethod'] == 'Insurance') {
                            echo 'selected';
                        }
                        echo '>Insurance</option>
                                        <option ';
                        if ($caseinfo['payMethod'] == 'Credit/Debit') {
                            echo 'selected';
                        }
                        echo '>Credit/Debit</option>
                                        <option';
                        if ($caseinfo['payMethod'] == 'Bank Transfer') {
                            echo 'selected';
                        }
                        echo '>Bank Transfer</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-2 text-center">Pay Status: </label>
                                <div class="col-3 form-group ">
                                    <select class="form-select form-control" name="payStatus">
                                        <option ';
                        if ($caseinfo['payStatus'] == 'Completed') {
                            echo 'selected';
                        }
                        echo
                        '>Completed</option>
                                        <option ';
                        if ($caseinfo['payStatus'] == 'Incomplete') {
                            echo 'selected';
                        }
                        echo '>Incomplete</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Annotation: </label>
                                <div class="col-9 form-group">
                                    <textarea rows="4" class="form-control" name="annotation">' . $caseinfo['annotation'] . '</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary" name="editcase">Confirm Edit</button>
                                </div>
                            </div>

                        </div>

                    </form>';
                    } else {
                        echo '<form action="CaseInformation.php?patientID=' . $patientID . '" method="post">
                        <div class="container">
                            <div class="row">
                                <label class="col-form-label col-2">Patient ID: </label>
                                <div class="col-3 form-group">
                                    <div type="text" class="form-control" style="border:none; box-shadow:none;"> ' . $patientID . '</div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Weight: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Weight" name="weight">
                                </div>
                                <label class="col-form-label col-2 text-center">Height: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Height" name="height">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Systolic BP: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter SBP" name="sbp">
                                </div>
                                <label class="col-form-label col-2 text-center">Diastolic BP: </label>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control" placeholder="Enter DBP" name="dbp">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Disease Name: </label>
                                <div class="col-3 form-group">
                                    <input type="text" class="form-control" placeholder="Enter Disease" name="diseaseName">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-2">Annotation: </label>
                                <div class="col-10 form-group">
                                    <textarea rows="3" class="form-control" name="annotation">

                                    </textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary" name="addcase">Add Case</button>
                                </div>
                            </div>

                        </div>

                    </form>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>