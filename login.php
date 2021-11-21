<?php
$mysqli = new mysqli("localhost", "root", null, "HuaD_HIS");
if (isset($_POST['login'])) {
    //รับค่า user & password
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query 
    $sql = "SELECT * FROM Account WHERE username = '$username' AND password = SHA1('$password')";
    $result = $mysqli->query($sql);

    // หาจำนวนเรกคอร์ดข้อมูล
    if (mysqli_num_rows($result) > 0) {
        session_start();
        $uid_sql = "SELECT accountID,accountType FROM Account WHERE username = '$username' AND password = SHA1('$password')";
        $result2 = $mysqli->query($uid_sql);
        $item = $result2->fetch_array();
        $accountID = $item['accountID'];
        $accountType = $item['accountType'];

        $sidquery = "SELECT * FROM Staff WHERE accountID='$accountID'";
        $result3 = $mysqli->query($sidquery);
        $sitem = $result3->fetch_array();
        $staffID = $sitem['staffID'];
        $staffTitle = $sitem['staffTitle'];
        $staffFN = $sitem['staffFN'];
        $staffLN = $sitem['staffLN'];

        $_SESSION['staffID'] = $staffID;
        $_SESSION['staffTitle'] = $staffTitle;
        $_SESSION['staffFN'] = $staffFN;
        $_SESSION['staffLN'] = $staffLN;
        $_SESSION['accountID'] = $accountID;
        $_SESSION['accountType'] = $accountType;
        if ($accountType == 'Doctor') {
            header("location: patientinformation.php");
        } elseif ($accountType == 'HR') {
            header("location: staffinformation.php");
        } elseif ($accountType == 'Pharmacist') {
            header("location: medicinestock.php");
        } else {
            header("location: patientinformation.php");
        }
        //ไปไปตามหน้าที่คุณต้องการ

    } else {
        $code_error = "<BR><FONT COLOR=\"red\">Incorrect Username or Password</FONT>";
        echo ($code_error);
        header("location: Login.php"); //ไม่ถูกต้องให้กับไปหน้าเดิม
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
            <div class="mx-auto col-4 bg-white p-5 mt-4">
                <div class="row mx-auto w-75">
                    <img class="img-fluid d-block" src="pic/Hua-D logo.png">
                </div>

                <form id="c_form-h" class="border rounded pt-4 pb-2 mt-4 border-info shadow" action="login.php" method="post">
                    <div class="form-group row">
                        <label for="inputmailh" class="col-form-label ml-4 col-2">Username:</label>
                        <div class="col-7 ml-3">
                            <input type="text" class="form-control" id="inputuser" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputpasswordh" class="col-form-label col-2 ml-4 mt-3">Password:</label>
                        <div class="col-7 ml-3">
                            <input type="password" class="form-control mt-3" id="inputpasswordh" name="password">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-5 mx-auto mt-3">
                            <button type="submit" class="btn btn-dark w-100" id="login" name="login">Login</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <a class="btn btn-dark mr-3 mt-5" style="width:10%" href="Register.php">Register
                </a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>