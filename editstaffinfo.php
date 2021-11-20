<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['editstaff'])) {
    $staffID = $_GET['staffID'];
    $staffTitle = $_POST['staffTitle'];
    $staffFN = $_POST['staffFN'];
    $staffLN = $_POST['staffLN'];
    $staffIdenID = $_POST['staffIdenID'];
    $staffTel = $_POST['staffTel'];
    $staffGender = $_POST['staffGender'];
    $staffDoB = $_POST['staffDoB'];
    $target_dir = "StaffImage/";
    $staffPic = $target_dir . basename($_FILES["staffPic"]["name"]);
    $roleName = $_POST['roleName'];
    $queryrole = "SELECT roleID FROM StaffRole WHERE roleName='$roleName'";
    $resultrole = $mysqli->query($queryrole);
    $roleID = $resultrole->fetch_array();
    $roleID = $roleID['roleID'];


    $dateOfBirth = $_POST['staffDoB'];
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $staffAge = $diff->format('%y');

    if ($staffPic != "StaffImage/") {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($staffPic, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["staffPic"]["tmp_name"]);
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
            if (move_uploaded_file($_FILES["staffPic"]["tmp_name"], $staffPic)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $queryupdate = "UPDATE Staff SET staffTitle='$staffTitle', staffFN='$staffFN', staffLN='$staffLN', 
staffIdenID='$staffIdenID', staffTel='$staffTel', staffGender='$staffGender',staffAge='$staffAge',staffDoB='$staffDoB',staffPic='$staffPic',roleID='$roleID' WHERE staffID='$staffID'";
        $resultupdate = $mysqli->query($queryupdate);
    } else {
        $queryupdate = "UPDATE Staff SET staffTitle='$staffTitle', staffFN='$staffFN', staffLN='$staffLN', 
staffIdenID='$staffIdenID', staffTel='$staffTel', staffGender='$staffGender',staffAge='$staffAge',staffDoB='$staffDoB',roleID='$roleID' WHERE staffID='$staffID'";
        $resultupdate = $mysqli->query($queryupdate);
    }
}
$staffID = $_GET['staffID'];
$queryinfo = "SELECT r.*,s.* FROM Staff s,StaffRole r WHERE staffID='$staffID' AND r.roleID=s.roleID";
$queryinfo2 = "CALL ShowStaffInfo('$staffID')";
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

<body style="overflow-x: hidden;">
    <div class="h-100 border-right" style="float: left; width: 18%; position: fixed;">
        <div class="container ml-0">
            <div class="row border-bottom h-25 ml-0">
                <div class="col-md-12 ml-3 my-3"><img class="img-fluid d-block w-75" src="pic/Hua-D logo.png"></div>
            </div>
            <?php
            if ($_SESSION['accountType'] == 'Admin' || $_SESSION['accountType'] == 'Doctor') {
                echo '<a href="patientinformation.php">
                <div class="row border-bottom">
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
                <div class="row border-bottom bg-info">
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
                <h2 class="mt-3 text-primary" style="font-weight: 400;">Staff Information</h2>
            </div>
            <form class="container mt-4" action="editstaffinfo.php?staffID=<?php echo $staffID; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 text-center"><img class="img-fluid d-block" <?php echo "src='" . $info['staffPic'] . "'" ?> width="">
                        <div class="form-group mt-3">
                            <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="staffPic">
                        </div>
                        <h5 class="text-primary"><?php echo $info['staffTitle'] . " " . $info['staffFN'] . " " . $info['staffLN']; ?></h5>
                        <button type="submit" class="btn btn-primary" name="editstaff">Edit Staff Info</button>
                    </div>
                    <div class="col-md-8" style="margin-left: 8%;">
                        <div class="row ">
                            <label class="col-form-label col-3">Staff ID: </label>
                            <div class="col-2 form-group ">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['staffID'] ?> </div>
                            </div>
                            <label class="col-form-label col-3 text-center">Identification ID: </label>
                            <div class="col-3 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['staffIdenID'] ?>" name="staffIdenID">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Title: </label>
                            <div class="col-md-2 form-group ">
                                <select class="form-select form-control" name="staffTitle">
                                    <option <?php if ($info['staffTitle'] == 'Mr.') {
                                                echo 'selected';
                                            } ?>>Mr.</option>
                                    <option <?php if ($info['staffTitle'] == 'Mrs.') {
                                                echo 'selected';
                                            } ?>>Mrs.</option>
                                    <option <?php if ($info['staffTitle'] == 'Ms.') {
                                                echo 'selected';
                                            } ?>>Ms.</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">First Name: </label>
                            <div class="col-md-8 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['staffFN'] ?>" name="staffFN">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Last Name: </label>
                            <div class="col-md-8 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['staffLN'] ?>" name="staffLN">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Telephone No.: </label>
                            <div class="col-md-3 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['staffTel'] ?>" name="staffTel">
                            </div>
                            <label class="col-form-label col-2 text-center">Gender: </label>
                            <div class="col-md-3 form-group ">
                                <select class="form-select form-control" name="staffGender">
                                    <option <?php if ($info['staffGender'] == 'Male') {
                                                echo 'selected';
                                            } ?>>Male</option>
                                    <option <?php if ($info['staffGender'] == 'Female') {
                                                echo 'selected';
                                            } ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Age: </label>
                            <div class="col-2 form-group">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['staffAge'] ?> </div>
                            </div>
                            <label class="col-form-label col-2 text-center">Date of Birth: </label>
                            <div class="col-4 form-group">
                                <input type="date" class="form-control" value="<?php echo $info['staffDoB'] ?>" name="staffDoB">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Role: </label>
                            <div class="col-3 form-group">
                                <input type="text" class="form-control" value="<?php echo $info['roleName'] ?>" name="roleName">
                            </div>
                            <label class="col-form-label col-2 text-center">Department: </label>
                            <div class="col-3 form-group">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['department'] ?> </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Salary: </label>
                            <div class="col-3 form-group">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['salary'] ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous" style=""></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" style=""></script>
</body>

</html>