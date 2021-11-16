<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        type="text/css">
    <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body style="overflow-x:hidden;">
    <div class="h-100 border-right" style="float: left; width: 18%; position: fixed;">
        <div class="container">
            <div class="row border-bottom h-25 ml-0">
                <div class="col-md-12 mx-auto my-3"><img class="img-fluid d-block w-75"
                        src="pic/Hua-D logo.png"></div>
            </div>
            <a href="patientinformation.html">
                <div class="row border-bottom">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-2" src="pic/patientinfo.png">
                    </div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Patient Information</h6>
                    </div>
                </div>
            </a>
            <a href="staffinformation.html">
                <div class="row border-bottom">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-2" src="pic/staffinfo.png">
                    </div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Staff Information</h6>
                    </div>
                </div>
            </a>
            <a href="medicinestock.html">
                <div class="row border-bottom bg-info">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-3" src="pic/medstock.png">
                    </div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Medicine Stocking</h6>
                    </div>
                </div>
            </a>
            <a href="">
                <div class="row border-bottom">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-3" src="pic/insight.png"></div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">Insight Data</h6>
                    </div>
                </div>
            </a>
            <a href="myprofile.html">
                <div class="row border-bottom">
                    <div class="col-md-4"><img class="img-fluid d-block w-75 mt-3" src="pic/profile.png"></div>
                    <div class="col-md-8 my-3">
                        <h6 class="mt-2" style="font-weight: 700;color: rgba(0, 0, 0, 0.521);">My Profile</h6>
                    </div>
                </div>
            </a>

            <div class="row h-50">
                <div class="col-md-12 mt-5 h-50"><a class="btn btn-outline-dark mt-0 ml-4" href="#">Logout <i
                            class="fa fa-sign-out fa-fw"></i> </a></div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-left: 18%;">
        <div class="container" style="margin-left: 3%;">
            <div class="row ">
                <h2 class="mt-3 text-primary" style="font-weight: 400;">Medicine Stock</h2>
            </div>
            <div class="row">
                <div class="col-md-12 d-inline-flex mt-3"><a class="btn btn-dark" href="#">Medicine&nbsp;ID</a>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" placeholder="Search">
                            <div class="input-group-append"></div>
                        </div>
                    </form>
                    <a class="btn btn-dark ml-2" href="#">Name</a>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" placeholder="Search">
                            <div class="input-group-append"></div>
                        </div>
                    </form>
                    <a class="btn btn-dark ml-2" href="#">Type</a>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" placeholder="Search">
                            <div class="input-group-append"></div>
                        </div>
                    </form>
                    <a class="btn btn-dark ml-2" href="#">Cabinet&nbsp;ID</a>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control ml-1" id="inlineFormInputGroup" placeholder="Search">
                            <div class="input-group-append"></div>
                        </div>
                    </form>
                    <div class="row" style=" margin-left: 1%;">
                        <div class="col-md-12"><a class="btn btn-primary" href="#">Search</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-left: 10%; margin-top: 2%;">
            <div class="col-md-12 d-inline-flex mt-3">
                <h7 class="" style="text-decoration: underline;">Result: 3 Row</h7>
                <h6 class="" style="margin-left: 76%;"><a href="Addmedicine.html"> Add Medicine</a>&nbsp;<span
                        class="badge badge-success rounded-circle">+</span></h6>
            </div>
        </div>
        <div class="">
            <div class="container" style="margin-left: 5%;">
                <div class="row ml-0">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">MedicineID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Cabinet ID</th>
                                        <th scope="col">Amount Left</th>
                                        <th scope="col">Amount/Dose</th>
                                        <th scope="col">Price/Dose</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>Otto</td>
                                        <td>Otto</td>
                                        <td>Otto</td>
                                        <td>21</td>
                                        <td><a href="Editmedicine.html"><img src="pic/search.png" alt="" height="20"></a></td>
                                        <td><a href=""><img src="pic/delete.png" alt="" height="20"></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>Thornton</td>
                                        <td>Thornton</td>
                                        <td>Thornton</td>
                                        <td>39</td>
                                        <td><a href=""><img src="pic/search.png" alt="" height="20"></a></td>
                                        <td><a href=""><img src="pic/delete.png" alt="" height="20"></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>the Bird</td>
                                        <td>the Bird</td>
                                        <td>the Bird</td>
                                        <td>45</td>
                                        <td><a href=""><img src="pic/search.png" alt="" height="20"></a></td>
                                        <td><a href=""><img src="pic/delete.png" alt="" height="20"></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"
        ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"
        ></script>
</body>

</html>