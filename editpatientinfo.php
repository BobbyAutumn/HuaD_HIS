<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
$patientID = $_GET['patientID'];
$queryinfo = "SELECT * FROM Patient WHERE patientID='$patientID'";
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
                <div class="col-md-12 mx-auto my-3"><img class="img-fluid d-block w-75" src="pic/Hua-D logo.png"></div>
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
                echo '<a href="medicinestock.html">
                <div class="row border-bottom">
                <div class="col-md-4 my-auto"><img class="img-fluid d-block w-75" src="pic/medstock.png"></div>
                <div class="col-md-8 my-3">
                    <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Medicine Stocking</h6>
                </div>
                </div>
            </a>';
            }
            ?>


            <a href="">
                <div class="row border-bottom">
                    <div class="col-md-4 my-auto"><img class="img-fluid d-block w-75" src="pic/insight.png"></div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Insight Data</h6>
                    </div>
                </div>
            </a>
            <a href="myprofile.html">
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
            <form class="container mt-4">
                <div class="row">
                    <div class="col-md-3 text-center"><img class="img-fluid d-block" <?php echo "src='" . $info['patientPic'] . "'" ?> width="">
                        <div class="form-group mt-3">
                            <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="patientPic">
                        </div>
                        <h5 class="text-primary"><?php echo $info['patientTitle'] . " " . $info['patientFN'] . " " . $info['patientLN']; ?></h5>
                        <button type="submit" class="btn btn-primary" name="editinfo">Edit Patient Info</button>
                    </div>
                    <div class="col-md-8" style="margin-left: 8%;">
                        <div class="row ">
                            <label class="col-form-label col-3">Patient ID: </label>
                            <div class="col-2 form-group ">
                                <div class="form-control"> <?php echo $info['patientID'] ?> </div>
                            </div>
                            <label class="col-form-label col-3">Identification ID: </label>
                            <div class="col-3 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientIdenID'] ?>" name="patientIdenID">
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
                            <div class="col-md-8 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['patientTel'] ?>" name="patientTel">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Age: </label>
                            <div class="col-2 form-group">
                                <div class="form-control"> <?php echo $info['patientAge'] ?> </div>
                            </div>
                            <label class="col-form-label col-2">Date of Birth: </label>
                            <div class="col-4 form-group">
                                <input type="date" class="form-control" value="<?php echo $info['patientDoB'] ?>" name="patientDoB">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Gender: </label>
                            <div class="col-md-8 form-group ">
                                <select class="form-select form-control" name="patientGender">
                                    <option>Select Gender</option>
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
                            <label class="col-form-label col-3">Treatment History: </label>
                            <div class="col-md-8 mb-3">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                        16/08/2016 &nbsp;&nbsp;J00-Acute nasopharyngitis <span><a href=""><i class="fa fa-search"></i></a></span> </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                        16/08/2016 &nbsp;&nbsp;J00-Acute nasopharyngitis <span><a href=""><i class="fa fa-search"></i></a></span> </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                        16/08/2016 &nbsp;&nbsp;J00-Acute nasopharyngitis <span><a href=""><i class="fa fa-search"></i></a></span> </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                        16/08/2016 &nbsp;&nbsp;J00-Acute nasopharyngitis <span><a href=""><i class="fa fa-search"></i></a></span> </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                        16/08/2016 &nbsp;&nbsp;J00-Acute nasopharyngitis <span><a href=""><i class="fa fa-search"></i></a></span> </li>
                                    <a href="">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Add
                                            Case <span class="badge badge-primary badge-circle">+</span> </li>
                                    </a>
                                </ul>
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