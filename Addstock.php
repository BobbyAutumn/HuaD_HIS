<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['addstock'])) {
    $medID = $_GET['medID'];
    $amount = $_POST['amount'];
    $staffID = $_SESSION['staffID'];
    date_default_timezone_set('Asia/Bangkok');
    $regisTime = date('Y-m-d H:i:s');

    $query = "SELECT MAX(TRIM(LEADING 'L' FROM stockID)) as stock_id FROM Stocking;";
    $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
    $row = $result->fetch_assoc();
    $last_stock_id = empty($row['stock_id']) ? 0 : $row['stock_id'];
    $lastnumid = ltrim($last_stock_id, "0");
    $stockID = 'L' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);

    $oldamountquery = "SELECT amountdose FROM Medicine WHERE medID='$medID'";
    $result = $mysqli->query($oldamountquery);
    $oldamount = $result->fetch_array();
    $oldamount = $oldamount['amountdose'];
    $newamount = $oldamount + $amount;

    $queryupdate = "UPDATE Medicine SET amountdose='$newamount' WHERE medID='$medID'";
    $resultupdate = $mysqli->query($queryupdate);

    $insertquery = "INSERT INTO Stocking (stockID, medID,staffID,amount,regisTime,Type) VALUES ('$stockID', '$medID','$staffID','$amount','$regisTime','Add')";
    $result2 = $mysqli->query($insertquery);
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
    <div class="container" style="margin-left: 20.5%;">
        <div class="row ">
            <h2 class="mt-3 text-primary" style="font-weight: 400;">Add Stock</h2>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-10 mb-3" style="margin-left: 20%;">
                    <form action="Addstock.php?medID=<?php echo $medID; ?>" method="post">
                        <div class="container">
                            <div class="row">
                                <label class="col-form-label col-3">Medicine ID:</label><br>
                                <div class="form-control col-3" style="border:none; box-shadow:none;"> <?php echo $info['medID'] ?> </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-3">Medicine Name:</label><br>
                                <div class="form-control col-3" style="border:none; box-shadow:none;"> <?php echo $info['medName'] ?> </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-3">Staff ID:</label><br>
                                <div class="form-control col-3" style="border:none; box-shadow:none;"> <?php echo $_SESSION['staffID'] ?> </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-3">Staff Name:</label><br>
                                <div class="form-control col-3" style="border:none; box-shadow:none;"> <?php echo $_SESSION['staffTitle'] . ' ' . $_SESSION['staffFN'] . ' ' . $_SESSION['staffLN'] ?> </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-3">Amount Left: </label>
                                <div class="form-control col-4" style="border:none; box-shadow:none;"> <?php echo $info['amountdose'] ?> </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-3">Amount to Add: </label>
                                <div class="col-4 form-group ">
                                    <input type="text" class="form-control" name="amount">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <button type="submit" class="btn btn-primary" name="addstock">Add Stock</button>
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