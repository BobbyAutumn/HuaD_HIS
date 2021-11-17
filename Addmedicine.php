<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['addmedicine'])) {
    $medName = $_POST['medName'];
    $medType = $_POST['medType'];
    $brand = $_POST['brand'];
    $cabinetID = $_POST['cabinetID'];
    $amountdose = $_POST['amountdose'];
    $gramperdose = $_POST['gramperdose'];
    $priceperdose = $_POST['priceperdose'];
    $annotation = $_POST['annotation'];

    $target_dir = "MedImage/";
    $medPic = $target_dir . basename($_FILES["medPic"]["name"]);
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
    date_default_timezone_set('Asia/Bangkok');
    $regisTime = date('Y-m-d H:i:s');
    $staffID=$_SESSION['staffID'];

    $query = "SELECT MAX(TRIM(LEADING 'M' FROM medID)) as med_id FROM Medicine;";
    $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
    $row = $result->fetch_assoc();
    $last_med_id = empty($row['med_id']) ? 0 : $row['med_id'];
    $lastnumid = ltrim($last_med_id, "0");
    $medID = 'M' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

    $query = "SELECT MAX(TRIM(LEADING 'L' FROM stockID)) as stock_id FROM Stocking;";
    $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
    $row = $result->fetch_assoc();
    $last_stock_id = empty($row['stock_id']) ? 0 : $row['stock_id'];
    $lastnumid = ltrim($last_stock_id, "0");
    $stockID = 'L' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

    $insertquery = "INSERT INTO Medicine (medID, medName,brand,medType,priceperdose,gramperdose,amountdose,cabinetID,medPic,annotation) 
    VALUES ('$medID', '$medName','$brand','$medType','$priceperdose','$gramperdose','$amountdose','$cabinetID','$medPic','$annotation')";
    $result = $mysqli->query($insertquery);
    $insertquery = "INSERT INTO Stocking (stockID, medID,staffID,amount,regisTime,Type) VALUES ('$stockID', '$medID','$staffID','$amountdose','$regisTime','Add')";
    $result2 = $mysqli->query($insertquery);
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
    <div class="container" style="margin-left: 20.5%;">
        <div class="row">
            <h2 class="mt-3 text-primary" style="font-weight: 400;">Add New Medicine</h2>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-10 mb-3" style="margin-left: 20%;">
                    <form action="Addmedicine.php" method="post" enctype="multipart/form-data">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="img">Select image</label><br>
                                    <input class="form-control-file" style="font-size: 1rem; font-weight: 200;" id="img" type="file" name="medPic">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Medicine Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Medicine Name" name="medName">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Brand</label>
                                    <input type="text" class="form-control" placeholder="Enter Brand Name" name="brand">
                                </div>
                                <div class="col-4 form-group">
                                    <label>Medicine Type</label>
                                    <input type="text" class="form-control" placeholder="Enter Medicine Type" name="medType">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label>Cabinet No.</label>
                                    <input type="text" class="form-control" placeholder="Enter Cabinet Number" name="cabinetID">
                                </div>
                                <div class="col-4 form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" placeholder="Enter Amount" name="amountdose">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 form-group">
                                    <label>Gram/Dose</label>
                                    <input type="text" class="form-control" placeholder="Enter Gram Per Dose" name="gramperdose">
                                </div>
                                <div class="col-3 form-group">
                                    <label>Price/Dose(Baht)</label>
                                    <input type="text" class="form-control" placeholder="Enter Price Per Dose" name="priceperdose">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 form-group">
                                    <label>Annotation</label>
                                    <textarea rows="2" class="form-control" name="annotation">
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary" name="addmedicine">Add Medicine</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous" style=""></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" style=""></script>
</body>

</html>