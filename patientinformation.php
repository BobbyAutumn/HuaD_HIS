<?php
session_start();
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['searchpatient'])) {
  $patientID = $_POST['patientid'];
  $patientName = $_POST['name'];
  $patientGender = $_POST['gender'];
  $patientAge = $_POST['age'];
  $patientDisease = $_POST['disease'];
  $queryPID = "CREATE OR REPLACE VIEW view1 AS SELECT * FROM Patient p WHERE p.patientID LIKE '%$patientID%'";
  $queryName = "CREATE OR REPLACE VIEW view2 AS SELECT * from view1 WHERE (patientFN LIKE '%$patientName%') OR (patientLN LIKE '%$patientName%')";
  if ($_POST['gender'] == 'Any') {
    $queryGender = "CREATE OR REPLACE VIEW view3 AS SELECT * from view2";
  } else {
    $queryGender = "CREATE OR REPLACE VIEW view3 AS SELECT * from view2 WHERE patientGender = '$patientGender'";
  }
  if ($_POST['age'] == 'Any') {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3";
  } elseif ($_POST['age'] == '1-20') {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE patientAge BETWEEN 1 AND 20";
  } elseif ($_POST['age'] == '21-40') {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE patientAge BETWEEN 21 AND 40";
  } elseif ($_POST['age'] == '41-60') {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE patientAge BETWEEN 21 AND 40";
  } elseif ($_POST['age'] == '61-80') {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE patientAge BETWEEN 61 AND 80";
  } else {
    $queryAge = "CREATE OR REPLACE VIEW view4 AS SELECT * from view3 WHERE patientAge > 80";
  }
  if ($patientDisease == '') {
    $queryDisease = "CREATE OR REPLACE VIEW view5 AS SELECT * FROM view4";
  } else {
    $queryDisease = "CREATE OR REPLACE VIEW view5 AS SELECT * FROM view4 WHERE view4.patientID IN (SELECT DISTINCT PatientCase.patientID FROM PatientCase WHERE PatientCase.diseaseID = (SELECT Disease.diseaseID FROM Disease WHERE diseaseName LIKE '%$patientDisease%'))";
  }
  $queryLastVisited = "CREATE OR REPLACE VIEW view6 AS SELECT patientID, MAX(regisTime) AS LastVisited FROM PatientCase GROUP BY patientID";
  $queryresult = "CREATE OR REPLACE VIEW view7 AS SELECT view5.*,view6.LastVisited FROM view5 LEFT JOIN view6 ON view5.patientID=view6.patientID;";
  $querylast = "SELECT * FROM view7";
  $result1 = $mysqli->query($queryPID);
  $result2 = $mysqli->query($queryName);
  $result3 = $mysqli->query($queryGender);
  $result4 = $mysqli->query($queryAge);
  $result5 = $mysqli->query($queryDisease);
  $result6 = $mysqli->query($queryLastVisited);
  $result7 = $mysqli->query($queryresult);
  $result8 = $mysqli->query($querylast);
} else {
  $queryDisease = "CREATE OR REPLACE VIEW view5 AS SELECT * FROM Patient";
  $queryLastVisited = "CREATE OR REPLACE VIEW view6 AS SELECT patientID, MAX(regisTime) AS LastVisited FROM PatientCase GROUP BY patientID";
  $queryresult = "CREATE OR REPLACE VIEW view7 AS SELECT view5.*,view6.LastVisited FROM view5 LEFT JOIN view6 ON view5.patientID=view6.patientID;";
  $querylast = "SELECT * FROM view7";
  $result5 = $mysqli->query($queryDisease);
  $result6 = $mysqli->query($queryLastVisited);
  $result7 = $mysqli->query($queryresult);
  $result8 = $mysqli->query($querylast);
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
      <form class="row" action="patientinformation.php" method="post">
        <div class="d-inline-flex mt-3 mr-3" style="max-width:12%;">
          <a class="btn btn-dark" href="">PID</a>
          <div class="input-group">
            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="patientid" placeholder="Search" <?php if (isset($_POST['searchpatient'])) {
                                                                                                                            echo 'value=' . $_POST['patientid'];
                                                                                                                          } ?>>
          </div>
        </div>
        <div class="d-inline-flex mt-3 mr-3" style="max-width:22%;">
          <a class="btn btn-dark" href="">Name</a>
          <div class="input-group">
            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="name" placeholder="Search" <?php if (isset($_POST['searchpatient'])) {
                                                                                                                      echo 'value=' . $_POST['name'];
                                                                                                                    } ?>>
          </div>
        </div>
        <div class="d-inline-flex mt-3 mr-3" style="max-width:15%;">
          <a class="btn btn-dark" href="">Gender</a>
          <div>
            <select class="form-select form-control" name="gender" style="height:100%; border-color: rgb(184, 184, 184); margin-left:10%;">
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["gender"] == "Any") {
                          echo "selected";
                        }
                      } ?>>Any</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["gender"] == "Male") {
                          echo "selected";
                        }
                      } ?>>Male</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["gender"] == "Female") {
                          echo "selected";
                        }
                      } ?>>Female</option>
            </select>
          </div>
        </div>
        <div class="d-inline-flex mt-3 mr-3" style="max-width:14%;">
          <a class="btn btn-dark" href="">Age</a>
          <div>
            <select class="form-select form-control" name="age" style="height:100%; border-color: rgb(184, 184, 184);margin-left:10%;">
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "Any") {
                          echo "selected";
                        }
                      } ?>>Any</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "1-20") {
                          echo "selected";
                        }
                      } ?>>1-20</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "21-40") {
                          echo "selected";
                        }
                      } ?>>21-40</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "41-60") {
                          echo "selected";
                        }
                      } ?>>41-60</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "61-80") {
                          echo "selected";
                        }
                      } ?>>61-80</option>
              <option <?php if (isset($_POST['searchpatient'])) {
                        if ($_POST["age"] == "Over 80") {
                          echo "selected";
                        }
                      } ?>>Over 80</option>
            </select>
          </div>
        </div>
        <div class="d-inline-flex mt-3 mr-2" style="max-width:19%;">
          <a class="btn btn-dark" href="">Disease</a>
          <div>
            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" name="disease" placeholder="Search" <?php if (isset($_POST['searchpatient'])) {
                                                                                                                          echo 'value=' . $_POST['disease'];
                                                                                                                        } ?>>
          </div>
        </div>

        <div class="col-1 d-inline-flex mt-3">
          <button type="submit" class="btn btn-primary" name="searchpatient">Search</button>
        </div>
      </form>
    </div>
    <div class="row" style="margin-left: 7%; margin-top: 2%;">
      <div class="col-md-12 d-inline-flex mt-1">
        <h7 class="" style="text-decoration: underline;">Result: <?php echo mysqli_num_rows($mysqli->query("SELECT * FROM view7")); ?> Row</h7>
        <h6 class="" style="margin-left: 69%;"><a href="Addnewpatient.php"> Add new Patient</a>&nbsp;<span class="badge badge-success rounded-circle">+</span></h6>
      </div>
    </div>
    <div class="row ml-3 mr-3">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="w-100 table table-striped table-borderless table-hover">
            <thead>
              <tr>
                <th scope="col">PatientID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Gender</th>
                <th scope="col">age</th>
                <th scope="col">Last Visited</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = $result8->fetch_array()) {
                echo "<tr>";
                echo "<td>" . $row["patientID"] . "</td>";
                echo "<td>" . $row["patientFN"] . "</td>";
                echo "<td>" . $row["patientLN"] . "</td>";
                echo "<td>" . $row["patientGender"] . "</td>";
                echo "<td>" . $row["patientAge"] . "</td>";
                echo "<td>" . $row["LastVisited"] . "</td>";
                echo '<td><a href="editpatientinfo.php?patientID=' . $row["patientID"] . '"><img src="pic/search.png"  height="20"></a></td>';
                echo '<td><a href="Delete.php?patientID=' . $row["patientID"] . '"><img src="pic/delete.png" height="20"></a></td>';
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