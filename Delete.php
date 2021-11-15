<?php
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_GET["patientID"])) {
    $patientID = $_GET["patientID"];
    $delete_query = "DELETE FROM Patient WHERE booksinformationid = '$booksid'";
    $delete_result = $mysqli->query($delete_query);
    if (!$delete_result) {
        echo "Delete failed!<br/>";
        echo $mysqli->error;
    } else {
        header("location: home-Final-Adminmode.php");
    }
}
