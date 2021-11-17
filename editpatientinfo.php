<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['editpatient'])) {
    $patientID = $_GET['patientID'];
    $patientTitle = $_POST['patientTitle'];
    $patientFN = $_POST['patientFN'];
    $patientLN = $_POST['patientLN'];
    $patientIdenID = $_POST['patientIdenID'];
    $patientTel = $_POST['patientTel'];
    $patientGender = $_POST['patientGender'];
    $patientDoB = $_POST['patientDoB'];
    $target_dir = "PatientImage/";
    $patientPic = $target_dir . basename($_FILES["patientPic"]["name"]);

    $dateOfBirth = $_POST['patientDoB'];
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $patientAge = $diff->format('%y');

    if ($patientPic != "PatientImage/") {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($patientPic, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["patientPic"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["patientPic"]["tmp_name"], $patientPic)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $queryupdate = "UPDATE Patient SET patientTitle='$patientTitle', patientFN='$patientFN', patientLN='$patientLN', 
patientIdenID='$patientIdenID', patientTel='$patientTel', patientGender='$patientGender',patientDoB='$patientDoB',patientAge='$patientAge',patientPic='$patientPic' WHERE patientID='$patientID'";
        $resultupdate = $mysqli->query($queryupdate);
    } else {
        $queryupdate = "UPDATE Patient SET patientTitle='$patientTitle', patientFN='$patientFN', patientLN='$patientLN', 
patientIdenID='$patientIdenID', patientTel='$patientTel', patientGender='$patientGender',patientAge='$patientAge',patientDoB='$patientDoB' WHERE patientID='$patientID'";
        $resultupdate = $mysqli->query($queryupdate);
    }
}
$patientID = $_GET['patientID'];
$queryinfo = "SELECT * FROM Patient WHERE patientID='$patientID'";
$queryinfo2 = "CALL ShowPatientInfo('$patientID');";
$result = $mysqli->query($queryinfo);
$info = $result->fetch_array();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body style="overflow: hidden;">
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
    <div style="margin-left: 18%;">
        <div class="container" style="margin-left: 3%;">
            <div class="row">
                <h2 class="mt-3 text-primary" style="font-weight: 400;">Patient Information</h2>
            </div>
            <form class="container mt-4" action="editpatientinfo.php?patientID=<?php echo $patientID; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 text-center"><img class="img-fluid d-block" <?php echo "src='" . $info['patientPic'] . "'" ?> width="">
                        <div class="form-group mt-3">
                            <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="patientPic">
                        </div>
                        <h5 class="text-primary"><?php echo $info['patientTitle'] . " " . $info['patientFN'] . " " . $info['patientLN']; ?></h5>
                        <button type="submit" class="btn btn-primary" name="editpatient">Edit Patient Info</button>
                    </div>
                    <div class="col-md-8" style="margin-left: 8%;">
                        <div class="row ">
                            <label class="col-form-label col-3">Patient ID: </label>
                            <div class="col-2 form-group ">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['patientID'] ?> </div>
                            </div>
                            <label class="col-form-label col-3 text-center">Identification ID: </label>
                            <div class="col-3 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientIdenID'] ?>" name="patientIdenID">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Title: </label>
                            <div class="col-md-2 form-group ">
                                <select class="form-select form-control" name="patientTitle">
                                    <option <?php if ($info['patientTitle'] == 'Mr.') {
                                                echo 'selected';
                                            } ?>>Mr.</option>
                                    <option <?php if ($info['patientTitle'] == 'Mrs.') {
                                                echo 'selected';
                                            } ?>>Mrs.</option>
                                    <option <?php if ($info['patientTitle'] == 'Ms.') {
                                                echo 'selected';
                                            } ?>>Ms.</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">First Name: </label>
                            <div class="col-md-8 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientFN'] ?>" name="patientFN">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Last Name: </label>
                            <div class="col-md-8 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientLN'] ?>" name="patientLN">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Telephone No.: </label>
                            <div class="col-md-3 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientTel'] ?>" name="patientTel">
                            </div>
                            <label class="col-form-label col-2 text-center">Gender: </label>
                            <div class="col-md-3 form-group ">
                                <select class="form-select form-control" name="patientGender">
                                    <option <?php if ($info['patientGender'] == 'Male') {
                                                echo 'selected';
                                            } ?>>Male</option>
                                    <option <?php if ($info['patientGender'] == 'Female') {
                                                echo 'selected';
                                            } ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Age: </label>
                            <div class="col-2 form-group">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['patientAge'] ?> </div>
                            </div>
                            <label class="col-form-label col-2 text-center">Date of Birth: </label>
                            <div class="col-4 form-group">
                                <input type="date" class="form-control" value="<?php echo $info['patientDoB'] ?>" name="patientDoB">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Treatment History: </label>
                            <div class="col-md-8 mb-3">
                                <?php
                                $querytreatment = "SELECT c.*,d.* FROM PatientCase c,Disease d WHERE patientID='$patientID' AND d.diseaseID=c.diseaseID ORDER BY regisTime ASC; ";
                                $querytreatment2="CALL ShowPatientTreatment('$patientID');";
                                $resulttreatment = $mysqli->query($querytreatment);

                                echo '<ul class="list-group">';
                                while ($treatmentinfo = $resulttreatment->fetch_array()) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center bg-light">' . $treatmentinfo['regisTime'] . ' ' . $treatmentinfo['diseaseName'] . ' ' . $treatmentinfo['payStatus'] . '<span><a href="Caseinformation.php?caseID=' . $treatmentinfo['caseID'] . '"><i class="fa fa-search"></i></a><a href=""><i class="fa fa-delete"></i></a></span> </li>';
                                }
                                echo '<a href="CaseInformation.php?patientID=' . $patientID . '">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Add Case <span class="badge badge-primary badge-circle">+</span> </li>
                                        </a>
                                    </ul>';


                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>