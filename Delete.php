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
