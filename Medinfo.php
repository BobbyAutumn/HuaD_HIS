<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['editmedicine'])) {
    $medID = $_GET['medID'];
    $medName = $_POST['medName'];
    $medType = $_POST['medType'];
    $brand = $_POST['brand'];
    $priceperdose = $_POST['priceperdose'];
    $gramperdose = $_POST['gramperdose'];
    $cabinetID = $_POST['cabinetID'];
    $annotation = $_POST['annotation'];
    $target_dir = "MedImage/";
    $medPic = $target_dir . basename($_FILES["medPic"]["name"]);

    if ($medPic != "MedImage/") {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($medPic, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["medPic"]["tmp_name"]);
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
            if (move_uploaded_file($_FILES["medPic"]["tmp_name"], $medPic)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $queryupdate = "UPDATE Medicine SET medName='$medName', medType='$medType', priceperdose='$priceperdose',brand='$brand', 
gramperdose='$gramperdose', cabinetID='$cabinetID',annotation='$annotation',medPic='$medPic' WHERE medID='$medID'";
        $resultupdate = $mysqli->query($queryupdate);
    } else {
        $queryupdate = "UPDATE Medicine SET medName='$medName', medType='$medType', priceperdose='$priceperdose',brand='$brand', 
gramperdose='$gramperdose', cabinetID='$cabinetID',annotation='$annotation' WHERE medID='$medID'";
        $resultupdate = $mysqli->query($queryupdate);
    }
}
$medID = $_GET['medID'];
$queryinfo = "SELECT * FROM Medicine WHERE medID='$medID'";
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
                <div class="row border-bottom bg-info">
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
                <h2 class="mt-3 text-primary" style="font-weight: 400;">Medicine Information</h2>
            </div>
            <form class="container mt-4" action="Medinfo.php?medID=<?php echo $medID; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 text-center"><img class="img-fluid d-block" <?php echo "src='" . $info['medPic'] . "'" ?> width="">
                        <div class="form-group mt-3">
                            <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="medPic">
                        </div>
                        <h5 class="text-primary"><?php echo $info['brand'] . ' - ' . $info['medName']; ?></h5>
                        <button type="submit" class="btn btn-primary" name="editmedicine">Edit Medicine Info</button>
                    </div>
                    <div class="col-md-8" style="margin-left: 8%;">
                        <div class="row ">
                            <label class="col-form-label col-3">Medicine ID: </label>
                            <div class="col-2 form-group ">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['medID'] ?> </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Medicine Name: </label>
                            <div class="col-4 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['medName'] ?>" name="medName">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Brand: </label>
                            <div class="col-4 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['brand'] ?>" name="brand">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Medicine Type: </label>
                            <div class="col-4 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['medType'] ?>" name="medType">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Cabinet No.: </label>
                            <div class="col-4 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['cabinetID'] ?>" name="cabinetID">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Gram/Dose: </label>
                            <div class="col-2 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['gramperdose'] ?> " name="gramperdose">
                            </div>
                            <label class="col-form-label col-3">Price/Dose(Baht): </label>
                            <div class="col-2 form-group ">
                                <input type="text" class="form-control" value="<?php echo $info['priceperdose'] ?>" name="priceperdose">
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-form-label col-3">Dose Left: </label>
                            <div class="col-2 form-group ">
                                <div class="form-control" style="border:none; box-shadow:none;"> <?php echo $info['amountdose'] ?> </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-2">Annotation: </label>
                            <div class="col-9 form-group">
                                <textarea rows="4" class="form-control" name="annotation"><?php echo $info['annotation'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <a class="btn btn-primary mr-3 mt-4" style="width:15%" href="Addstock.php?medID=<?php echo $medID ?>">Add Stock
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>