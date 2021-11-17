<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['addstaff'])) {
    $staffTitle = $_POST['staffTitle'];
    $staffFN = $_POST['staffFN'];
    $staffLN = $_POST['staffLN'];
    $staffIdenID = $_POST['staffIdenID'];
    $staffTel = $_POST['staffTel'];
    $staffDoB = $_POST['staffDoB'];
    $staffGender = $_POST['staffGender'];
    $staffTel = $_POST['staffTel'];
    $staffRole = $_POST['staffRole'];

    $target_dir = "StaffImage/";
    $staffPic = $target_dir . basename($_FILES["staffPic"]["name"]);
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

    $dateOfBirth = $_POST['staffDOB'];
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $staffAge = $diff->format('%y');

    $query = "SELECT MAX(TRIM(LEADING 'S' FROM staffID)) as staff_id FROM Staff;";
    $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
    $row = $result->fetch_assoc();
    $last_staff_id = empty($row['staff_id']) ? 0 : $row['staff_id'];
    $lastnumid = ltrim($last_staff_id, "0");
    $staffID = 'S' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

    $rolequery = "SELECT roleID FROM StaffRole WHERE roleName='$staffRole'";
    $result1 = $mysqli->query($rolequery);
    $role = $result1->fetch_array();
    $roleID = $role['roleID'];

    $insertquery = "INSERT INTO Staff (staffID, staffTitle,staffFN,staffLN,staffIdenID,staffTel,staffAge,staffGender,roleID,staffDoB,staffPic) 
    VALUES ('$staffID', '$staffTitle','$staffFN','$staffLN','$staffIdenID','$staffTel','$staffAge','$staffGender','$roleID','$staffDoB','$staffPic')";
    $result = $mysqli->query($insertquery);
    if ($result) {
    } else {
        echo $mysqli->error;
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
    <div class="container" style="margin-left: 20.5%;">
        <div class="row ">
            <h2 class="mt-3 text-primary" style="font-weight: 400;">Add New Staff</h2>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-10 mb-3" style="margin-left: 20%;">
                    <form action="Addnewstaff.php" method="post" enctype="multipart/form-data">
                        <div class="container">
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="img">Select image</label><br>
                                    <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="staffPic">
                                </div>
                                <div class="col-2 form-group">
                                    <label for="title">Title</label><br>
                                    <select class="form-select form-control" id="title" name="staffTitle">
                                        <option>Select title</option>
                                        <option>Mr.</option>
                                        <option>Ms.</option>
                                        <option>Mrs.</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff First Name" name="staffFN">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff Last Name" name="staffLN">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Identification ID</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff Identification Number" name="staffIdenID">
                                </div>
                                <div class="col-4 form-group">
                                    <label>Telephone</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff Telephone Number" name="staffTel">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="yyyy-mm-dd" name="staffDoB">
                                </div>
                                <div class="col-3 form-group">
                                    <label>Gender</label><br>
                                    <select class="form-select form-control" name="staffGender">
                                        <option>Select Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Role</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff Role" name="staffRole">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary" name="addstaff">Add Staff</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>