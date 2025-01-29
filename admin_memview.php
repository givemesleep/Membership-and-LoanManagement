<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';

    if(isset($_GET['pathmem'])){
        
        $pathmem = $_GET['pathmem'];
        $sqlpath="SELECT CONCAT(IF(p.gendID = 2,'Mr. ', IF(p.maritID = 1,'Ms. ', 'Mrs. ')), p.memSur,', ', p.memGiven, ' ', p.memMiddle, ' ', IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname,
                    p.ApplicationDate AS appd, p.memberID AS IDS
                FROM tbperinfo p
                LEFT JOIN tbsuffixes sf ON p.sufID=sf.sufID 
                WHERE p.memberID=?";
        $datapath = array($pathmem);
        $stmtpath=$conn->prepare($sqlpath);
        $stmtpath->execute($datapath);

        $res = $stmtpath->fetch();
        $fullname = $res['Fullname'];
        $IDS = $res['IDS'];

    }
?>  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | New Applicant</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/llampcologo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
  <style>
    #header-background{
      background-color: #3260ab;
      padding:1px;
      padding-left: 10px;
      color: white;
      margin-top: 10px;
      border-radius: 5px;
    }
    .required{
      color:red;
    }
    form label{
      font-weight: 600;
    }
    fieldset {
    display: none;
    }
    fieldset.active {
    display: block;
    }
    .gosh{
        margin-top: 50px;
        padding-left: 250px;
        padding-right: 250px;
    }
    .centered-label{
        text-align: center;
    }
    .step1{
        text-align: center;
    }
    footer{
        text-align: center;
    }
  </style>

<?php

  require_once 'sidenavs/app_headers.php';
  
?>

<main class="gosh">

  <div class="pagetitle">
    <br><br>
    <!-- <h1>Membership</h1> -->
    <!-- <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="applicant_pendings.php">Pending</a></li>
        <li class="breadcrumb-item active">Application Form</li>
      </ol>
    </nav> -->
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 mt-2">

                    <div class="text-start">
                        <a href="admin_masterlist.php?sel=1" class="card-title"><button type="btn" class="btn btn-dark"> Back</button></a>
                    </div>
                
                    <!-- table to  -->
                        <table style="width:100%;">
                            <thead>
                                <th style="width : 30%"></th>
                                <th style="width : 70%"></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- for importants  -->
                                    <td>
                                        <!-- insert image -->
                                        <div class="mt-3 text-center">
                                            <img src="assets/img/default.png" alt="Profile" class="rounded-circle">
                                        </div>
                                        <!-- end image  -->
                                         <!-- details div  -->
                                        <div class="details" >
                                            <!-- row  -->
                                            <div class="mt-3 row g-3">
                                                <!-- details  -->
                                                <div class="col-md-12" style=" vertical-align: bottom;">
                                                    <!-- <p><b>Member ID : 1096</b></p>
                                                    <p><b>Name : Malupiton, Joel</b></p>
                                                    <p><b>Email : bosskupalkaba@gmail.com</b></p>
                                                    <p><b>Contact No. : 0922nogto</b></p> -->

                                                    <table style="width : 350px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 10px; width: 100px; vertical-align: top; font-weight: normal;">ID : </th>
                                                                <th style="padding: 10px; max-width: 350px;">202409060001</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 10px; width: 100px; vertical-align: top; font-weight: normal;">Name : </th>
                                                                <th style="padding: 10px; max-width: 350px;">Malupiton, Joel S. Jr.</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 10px; width: 100px; vertical-align: top; font-weight: normal;">Email : </th>
                                                                <th style="padding: 10px; max-width: 350px;">bosskupal@gmail.com</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 10px; width: 150px; vertical-align: top; font-weight: normal;">Contact No. : </th>
                                                                <th style="padding: 10px; max-width: 350px;">09123456789</th>
                                                            </tr>
                                                
                                                        </thead>
                                                    </table>
                                                </div>
                                                <!-- end details-->
                                            </div>
                                            <!-- end row  -->
                                        </div>
                                        <!-- end details  -->
                                    </td>
                                    <!-- for other info  -->
                                    <td>
                    
                                        <!-- f1 -->
                                        <fieldset class="active">
                                            <div class="row g-3">
                                                <!-- header  -->
                                                <div class="text-center">
                                                    <header style="background-color: #D3D3D3;">
                                                        <h4><b>Personal Information</b></h4>
                                                    </header>   
                                                </div>
                                                <!-- end head  -->
                                                
                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Surname : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Malupiton</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Given Name : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Joel</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Middle Name : </th>
                                                                <th style="padding: 20px; max-width: 350px;">K.</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Nickname : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Bossing</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Suffix : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Jr.</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="col-md-6">
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Birthdate : </th>
                                                                <th style="padding: 20px; max-width: 350px;">11-01-2000</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Marital Status : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Single</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Sex : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Male</th>
                                                                
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Age : </th>
                                                                <th style="padding: 20px; max-width: 350px;">24</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                </div>

                                                <div class="text-end">
                                                    <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous"> -->
                                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                                </div>
                                            </div>    
                                        </fieldset>
                                        <!-- end f2 -->
                
                                        <!-- f2 Contact Details -->
                                        <fieldset>
                                            <div class="row g-3">
                                                <div class="text-center">
                                                    <header style="background-color: #D3D3D3;">
                                                        <h4><b>Contact Information</b></h4>
                                                    </header>   
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">House No. : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Blk 1 Lot 1 Bossing Road</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Province : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Metro Manila</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">City : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Cavite City</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Barrangay : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Brgy Matatapang</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Zip Code : </th>
                                                                <th style="padding: 20px; max-width: 350px;">2400</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Email Address: </th>
                                                                <th style="padding: 20px; max-width: 350px;">bossingkupal@gmail.com</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">(Main) Mobile No. : </th>
                                                                <th style="padding: 20px; max-width: 350px;">09123456789</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">(Extra) Mobile No. : </th>
                                                                <th style="padding: 20px; max-width: 350px;">09123456789</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Landline : </th>
                                                                <th style="padding: 20px; max-width: 350px;">01-01234567</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="text-end">
                                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                                </div>

                                            </div>
                                            <!-- end row -->
 
                                        </fieldset>
                                        <!-- end f2  -->

                                        <!-- f3 Contact Details -->
                                        <fieldset>
                                            <div class="row g-3">
                                                <div class="text-center">
                                                    <header style="background-color: #D3D3D3;">
                                                        <h4><b>Personal Background</b></h4>
                                                    </header>   
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">School Name : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Cavite State University</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">High Attainment : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Metro Manila</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Course/Strand : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Bachelor of Science in Kakupalan sa lahat ng bagay</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Business Name: </th>
                                                                <th style="padding: 20px; max-width: 350px;">Malupiton Clo.</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Business Address : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Tarima Etivac</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Business City : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Cavite City</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Company Name : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Kakupalan Co.</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Occupation Type : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Taga Kupal</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="text-end">
                                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                                </div>

                                            </div>
                                            <!-- end row -->
 
                                        </fieldset>
                                        <!-- end f3  -->

                                        <!-- f4 Contact Details -->
                                        <fieldset>
                                            <div class="row g-3">
                                                <div class="text-center">
                                                    <header style="background-color: #D3D3D3;">
                                                        <h4><b>Identification Information</b></h4>
                                                    </header>   
                                                </div>

                                                <div class="col-md-12">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">SSS No. : </th>
                                                                <th style="padding: 20px; max-width: 350px;">6912369</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Tax Identification : </th>
                                                                <th style="padding: 20px; max-width: 350px;">9632196</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Other ID : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Kupal Card</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">ID No. :</th>
                                                                <th style="padding: 20px; max-width: 350px;">123456780</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="col-md-12"></div>
                                                <div class="col-md-12"></div>
                                                <div class="col-md-12"></div>
                                                <div class="col-md-12"></div>

                                                <div class="text-end" style=" vertical-align: bottom;">
                                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                                </div>

                                            </div>
                                            <!-- end row -->
 
                                        </fieldset>
                                        <!-- end f4  -->

                                        <!-- f5 Contact Details -->
                                        <fieldset>
                                            <div class="row g-3">
                                                <div class="text-center">
                                                    <header style="background-color: #D3D3D3;">
                                                        <h4><b>Other Information</b></h4>
                                                    </header>   
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Residential Status : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Own</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Residential Info : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Reachable</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Year of Stay : </th>
                                                                <th style="padding: 20px; max-width: 350px;">100 yrs</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="col-md-6">
                                                    
                                                    <table style="width : 475px;">
                                                        <thead>
                                                            
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Social Interest : </th>
                                                                <th style="padding: 20px; max-width: 350px;">wala kupal e</th>
                                                            </tr>
                                                
                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Hobbies : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Playing Basketball</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Monthly Income : </th>
                                                                <th style="padding: 20px; max-width: 350px;">80k</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Other Cooperative : </th>
                                                                <th style="padding: 20px; max-width: 350px;">None</th>
                                                            </tr>

                                                            <tr>
                                                                <th style="padding: 20px; width: 200px; vertical-align: top; font-weight: normal;">Joined Date : </th>
                                                                <th style="padding: 20px; max-width: 350px;">Last Year</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    
                                                </div>

                                                <div class="text-end">
                                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                                </div>

                                            </div>
                                            <!-- end row -->
 
                                        </fieldset>
                                        <!-- end f5  -->
                    
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <!-- end of table to  -->

                </div>
            </div>
        </div>
    </div>
</section>

</main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php
  require_once 'sidenavs/centered_footer.php';
?> 
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendo//r/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="jqueryto/jquerymoto.js"></script>
<script src="jqueryto/poppermoto.js"></script>
<script src="jqueryto/bootstrapmoto.js"></script>
<script src="jqueryto/sweetalertmoto.js"></script>
<script src="jqueryto/jquerytodiba.min.js"></script>

</body>
</html>
<?php 
    require_once 'process/app_regex.php';
?>

<script>
    $(document).ready(function(){
   setInterval('updateClock()', 1000);
});

function updateClock (){
 	var currentTime = new Date ( );
  	var currentHours = currentTime.getHours ( );
  	var currentMinutes = currentTime.getMinutes ( );
  	var currentSeconds = currentTime.getSeconds ( );

  	// Pad the minutes and seconds with leading zeros, if required
  	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  	// Choose either "AM" or "PM" as appropriate
  	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  	// Convert the hours component to 12-hour format if needed
  	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  	// Convert an hours component of "0" to "12"
  	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  	// Compose the string for display
  	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
  	
  	
   	$("#clock").html(currentTimeString);	  	
 }

$(function() {
    var active = $('fieldset.active')
    $('.next, .previous').click(function(e) {
    e.preventDefault();
    var target = $(this).closest('fieldset')[this.name]();
    if (target.length) {
        active.removeClass('active');
        target.addClass('active');
        active = target;
        }
    });
});
</script>