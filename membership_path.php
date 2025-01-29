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
        margin-top: 70px;
        padding-left: 475px;
        padding-right: 475px;
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
                
                <br>
                <div class="text-start">
                    <a href="membership_tables.php?sel=1" class="card-title"><button type="btn" class="btn btn-dark"> Back</button></a>
                </div>
            
                <br>

                <div class="col-md-8">
                    <h5>ID : <?php echo $IDS; ?></h5>
                    <h5>Name : <?php echo $fullname; ?></h5>
                </div>                

                <div class="mt-5 text-center">
                    <a href="membership_tables.php" class="card-title"><button type="btn" class="btn btn-light" style="padding : 15px 130px"> Create Loan</button></a>
                </div>
                <br>
                <!-- <div class="text-center">
                    <a href="membership_tables.php" class="card-title"><button type="btn" class="btn btn-light" style="padding : 15px 100px"> Create Loan</button></a>
                </div> -->

                <div class="text-center">
                    <h5>- or -</h5>
                </div>
                <br>
                <div class="text-center">
                    <a href="apply_application.php?depmem=<?php echo $IDS; ?>" class="card-title"><button type="btn" class="btn btn-light" style="padding : 15px 130px"> Add Deposit</button></a>
                </div>
                <br><br>
                <div class="mt-5 text-center">
                    <p><?php echo (new \DateTime())->format('Y-m-d'); ?>&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp <span id="clock"></span></p>
                </div>
            </div>
        </div>
    </div>
</section>

</main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php
  require_once 'sidenavs/footer.php';
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

// var d = new Date();

// var curr_day = d.getDate();
// var curr_month = d.getMonth();
// var curr_year = d.getFullYear();

// var curr_hour = d.getHours();
// var curr_min = d.getMinutes();
// var curr_sec = d.getSeconds();

// curr_month++ ; // In js, first month is 0, not 1
// year_2d = curr_year.toString().substring(2, 4)

// $("#txtDate").val(curr_day + " " + curr_month + " " + year_2d)

// var d = new Date();
// var options = { year: 'numeric', month: 'long', day: 'numeric' };
// // console.log( d.toLocaleDateString('en-US', options) );
// $(".date").val( d.toLocaleDateString('en-US', options));

// let objDate = new Date(),
//     date = objDate.toLocaleString('en-us', { year: 'numeric', month: 'long', day: 'numeric' })

//     $("#date").val(date)

// let objDate = new Date(),
//     month = objDate.toLocaleString('en-us', { month: 'long' }),
//     day = objDate.getDate(),
//     year = objDate.getFullYear()
    
// $("#date").val(`${month} ${day}, ${year}`)

// var date = new Date();
// document.getElementById("frmDate").value = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();

// document.getElementById('frmDate').valueAsDate = new Date();
// $(document).ready( function() {
//     $('#frmDate').val(new Date().toDateInputValue());
// });​
</script>