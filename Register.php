<?php
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['register'])) {
    //รับค่า user & password
    $staffid = $_POST['staffid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    //query 
    $sql = "SELECT * FROM Staff WHERE staffID = '$staffid'";
    $result = $mysqli->query($sql);

    // หาจำนวนเรกคอร์ดข้อมูล
    if (mysqli_num_rows($result) > 0) {
        $query = "SELECT MAX(TRIM(LEADING 'A' FROM accountID)) as account_id FROM Account;";
        $result = $mysqli->query($query) or die('There was an error running the query [' . $mysqli->error . ']');
        $row = $result->fetch_assoc();
        $last_account_id = empty($row['account_id']) ? 0 : $row['account_id'];
        $lastnumid = ltrim($last_account_id, "0");
        $next_account_id = 'A' . str_pad($lastnumid + 1, 4, "0", STR_PAD_LEFT);


        $addaccount = "INSERT INTO Account (accountID,username,password,accountType) 
    VALUES ('$next_account_id','$username',SHA1('$password'),'$role')";
        $result2 = $mysqli->query($addaccount);
        $updatestaff = "UPDATE Staff SET accountID='$next_account_id' WHERE staffID='$staffid'";
        $result3 = $mysqli->query($updatestaff);
        //ไปไปตามหน้าที่คุณต้องการ

    } else {
        $code_error = "<BR><FONT COLOR=\"red\">Incorrect staffID</FONT>";
        echo ($code_error);
        header("location: Register.php");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body>
    <div class="container" style="max-width:100%;">
        <div class="row">
            <div class="mx-auto col-4 bg-white pt-3 pl-5 pr-5 pb-5 mt-4">
                <div class="row mx-auto w-75">
                    <img class="img-fluid d-block" src="pic/Hua-D logo.png">
                </div>

                <form id="c_form-h" class="border rounded pt-4 pb-2 mt-4 border-info shadow" action="register.php" method="post">
                    <div class="form-group row">
                        <label class="col-form-label col-2 ml-4">StaffID:</label>
                        <div class="col-7 ml-3">
                            <input type="text" class="form-control" id="staffid" name="staffid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label ml-4 col-2 mt-2">Username:</label>
                        <div class="col-7 ml-3">
                            <input type="text" class="form-control mt-2" id="inputuser" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-2 ml-4 mt-2">Password:</label>
                        <div class="col-7 ml-3">
                            <input type="password" class="form-control mt-2" id="inputpasswordh" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-2 ml-4 mt-2">Role:</label>
                        <div class="col-7 ml-3">
                            <select class="form-select form-control mt-2" name="role">
                                <option value="">Select Role</option>
                                <option>Doctor</option>
                                <option>HR</option>
                                <option>Pharmacist</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-5 mx-auto mt-3">
                            <button type="submit" class="btn btn-dark w-100" id="register" name="register">Register</button>
                        </div>

                    </div>


                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <a class="btn btn-dark mr-3" style="width:10%" href="Login.php">Back
                </a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>