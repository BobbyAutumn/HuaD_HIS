<?php
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_GET["patientID"])) {
    $patientID = $_GET["patientID"];
    $delete_case = "DELETE FROM PatientCase WHERE patientID = '$patientID'";
    $delete_patient = "DELETE FROM Patient WHERE patientID = '$patientID'";
    $delete_result = $mysqli->query($delete_case);
    $delete_result = $mysqli->query($delete_patient);
    if (!$delete_result) {
        echo "Delete failed!<br/>";
        echo $mysqli->error;
    } else {
        header("location: patientinformation.php");
    }
}
if (isset($_GET["staffID"])) {
    $staffID = $_GET["staffID"];
    $delete_case = "DELETE FROM PatientCase WHERE staffID = '$staffID'";
    $delete_staff = "DELETE FROM Staff WHERE staffID = '$staffID'";
    $delete_result = $mysqli->query($delete_case);
    $delete_result = $mysqli->query($delete_staff);
    if (!$delete_result) {
        echo "Delete failed!<br/>";
        echo $mysqli->error;
    } else {
        header("location: staffinformation.php");
    }
}
if (isset($_GET["medID"])) {
    $medID = $_GET["medID"];
    $delete_case = "DELETE FROM PatientCase WHERE patientID = '$patientID'";
    $delete_med = "DELETE FROM Medicine WHERE medID = '$medID'";
    $delete_result = $mysqli->query($delete_case);
    $delete_result = $mysqli->query($delete_med);
    if (!$delete_result) {
        echo "Delete failed!<br/>";
        echo $mysqli->error;
    } else {
        header("location: patientinformation.php");
    }
}
?>
