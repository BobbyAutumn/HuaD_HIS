<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['searchstaff'])) {
    $staffID = $_POST['staffid'];
    $staffName = $_POST['name'];
    $staffGender = $_POST['gender'];
    $staffRole = $_POST['role'];
    $staffDepartment = $_POST['department'];
    $firstquery = "CREATE OR REPLACE VIEW view1 AS SELECT Staff.*,StaffRole.roleName, StaffRole.department FROM Staff INNER JOIN StaffRole ON Staff.roleID=StaffRole.roleID ;";
    $queryPID = "CREATE OR REPLACE VIEW view2 AS SELECT * FROM view1 WHERE staffID LIKE '%$staffID%'";
    $queryName = "CREATE OR REPLACE VIEW view3 AS SELECT * from view2 WHERE (staffFN LIKE '%$staffName%') OR (staffLN LIKE '%$staffName%')";
    if ($_POST['gender'] == 'Any') {
        $queryGender = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3";
    } else {
        $queryGender = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE staffGender = '$staffGender'";
    }
    $queryRole = "CREATE OR REPLACE VIEW view5 AS SELECT * from view4 WHERE roleName LIKE '%$staffRole%'";
    $queryDepartment = "CREATE OR REPLACE VIEW view7 AS SELECT * FROM view5 WHERE department LIKE '%$staffDepartment%'";
    $querylast = "SELECT * FROM view7";
    $result1 = $mysqli->query($firstquery);
    $result2 = $mysqli->query($queryPID);
    $result3 = $mysqli->query($queryName);
    $result4 = $mysqli->query($queryGender);
    $result5 = $mysqli->query($queryRole);
    $result6 = $mysqli->query($queryDepartment);
    $result7 = $mysqli->query($querylast);
} else {
    $firstquery = "CREATE OR REPLACE VIEW view7 AS SELECT Staff.*,StaffRole.roleName, StaffRole.department FROM Staff INNER JOIN StaffRole ON Staff.roleID=StaffRole.roleID ;";
    $querylast = "SELECT * FROM view7 ORDER BY staffID";
    $result1 = $mysqli->query($firstquery);
    $result7 = $mysqli->query($querylast);
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
            <form class="row" action="staffinformation.php" method="post">
                <div class="d-inline-flex mt-3 mr-3" style="max-width:12%;">
                    <a class="btn btn-dark" href="">SID</a>
                    <div class="input-group">
                        <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="staffid" placeholder="Search" <?php if (isset($_POST['searchstaff'])) {
                                                                                                                                        echo 'value=' . $_POST['staffid'];
                                                                                                                                    } ?>>
                    </div>
                </div>
                <div class="d-inline-flex mt-3 mr-3" style="max-width:22%;">
                    <a class="btn btn-dark" href="">Name</a>
                    <div class="input-group">
                        <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="name" placeholder="Search" <?php if (isset($_POST['searchstaff'])) {
                                                                                                                                    echo 'value=' . $_POST['name'];
                                                                                                                                } ?>>
                    </div>
                </div>
                <div class="d-inline-flex mt-3 mr-3" style="max-width:15%;">
                    <a class="btn btn-dark" href="">Gender</a>
                    <div>
                        <select class="form-select form-control" name="gender" style="height:100%; border-color: rgb(184, 184, 184); margin-left:10%;">
                            <option <?php if (isset($_POST['searchstaff'])) {
                                        if ($_POST["gender"] == "Any") {
                                            echo "selected";
                                        }
                                    } ?>>Any</option>
                            <option <?php if (isset($_POST['searchstaff'])) {
                                        if ($_POST["gender"] == "Male") {
                                            echo "selected";
                                        }
                                    } ?>>Male</option>
                            <option <?php if (isset($_POST['searchstaff'])) {
                                        if ($_POST["gender"] == "Female") {
                                            echo "selected";
                                        }
                                    } ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="d-inline-flex mt-3 mr-3" style="max-width:14%;">
                    <a class="btn btn-dark" href="">Role</a>
                    <div>
                        <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="role" placeholder="Search" <?php if (isset($_POST['searchstaff'])) {
                                                                                                                                    echo 'value=' . $_POST['role'];
                                                                                                                                } ?>>
                    </div>
                </div>
                <div class="d-inline-flex mt-3 mr-2" style="max-width:18%;">
                    <a class="btn btn-dark" href="">Department</a>
                    <div>
                        <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="department" placeholder="Search" <?php if (isset($_POST['searchstaff'])) {
                                                                                                                                            echo 'value=' . $_POST['department'];
                                                                                                                                        } ?>>
                    </div>
                </div>

                <div class="col-1 d-inline-flex mt-3">
                    <button type="submit" class="btn btn-primary" name="searchstaff">Search</button>
                </div>
            </form>
        </div>


        <div class="row" style="margin-left: 7%; margin-top: 2%;">
            <div class="col-md-12 d-inline-flex mt-1">
                <h7 class="" style="text-decoration: underline;">Result: <?php echo mysqli_num_rows($mysqli->query("SELECT * FROM view6")); ?> Row</h7>
                <h6 class="" style="margin-left: 65%;"><a href="Addrole.php"> Add Staff Role</a>&nbsp;<span class="badge badge-success rounded-circle">+</span></h6>
                <h6 class="" style="margin-left: 2%;"><a href="Addnewstaff.php"> Add new Staff</a>&nbsp;<span class="badge badge-success rounded-circle">+</span></h6>
            </div>
        </div>
        <div class="row ml-3 mr-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="w-100 table table-striped table-borderless table-hover">
                        <thead>
                            <tr>
                                <th scope="col">StaffID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">age</th>
                                <th scope="col">Role</th>
                                <th scope="col">Department</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result7->fetch_array()) {
                                echo "<tr>";
                                echo "<td>" . $row["staffID"] . "</td>";
                                echo "<td>" . $row["staffFN"] . "</td>";
                                echo "<td>" . $row["staffLN"] . "</td>";
                                echo "<td>" . $row["staffGender"] . "</td>";
                                echo "<td>" . $row["staffAge"] . "</td>";
                                echo "<td>" . $row["roleName"] . "</td>";
                                echo "<td>" . $row["department"] . "</td>";
                                echo '<td><a href="editstaffinfo.php?staffID=' . $row["staffID"] . '"><img src="pic/search.png" height="20"></a></td>';
                                echo '<td><a href="Delete.php?staffID=' . $row["staffID"] . '"><img src="pic/delete.png" height="20"></a></td>';
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>