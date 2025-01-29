<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

  if(isset($_GET['ongoing'])){
    $ogID = $_GET['ongoing'];

    $sqlOG="SELECT p.memberID AS memID, ms.memStats AS Statuses,
            CONCAT(p.memSur,', ' ,p.memGiven, ' ', p.memMiddle,' ',IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname,
            mdi.Regular AS Regular

            FROM tbperinfo p

            JOIN tbmemstats ms ON p.memStatus = ms.memStatus
            LEFT JOIN tbsuffixes sf ON p.sufID = sf.sufID
            LEFT JOIN tbmemdepinfo mdi ON p.memberID = mdi.memberID
            WHERE p.memStatus = 9 AND p.memberID = ?";

    $dataOG=array($ogID);
    $stmtOG=$conn->prepare($sqlOG);
    $stmtOG->execute($dataOG);

    //Fetching
    $rowOG=$stmtOG->fetch();

    $memID = $rowOG['memID'];
    $memFname = $rowOG['Fullname'];
    $memReg = $rowOG['Regular'];

    //Checking Balance
    $inam = 2400.00;
    $amount = $inam - $memReg;
    $Balance = number_format($amount, 2);
 
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
                <h5 class="card-title" style="font-size: 25px;"><b>Add Regular Savings</b></h5>
                <a href="membership_tables.php?sel=2" ><button type="btn" class="btn btn-dark" ><span class="bi bi-arrow-left"></span> Back</button></a>
                
                <form action="process/proc_payongoing.php" method="post"class="row g-3 mt-3 needs-validation" novalidate>

                  <header id=header-background>
                      <h6 class="mt-3"><b>Payment Details</b></h6>
                  </header>

                  <!-- FETCH -> Fullname | PMES SCHEDULE | Application DATE
                  INPUT -> Refer NAME(Combo) | Conduct NAME(Combo) | Approved NAME (Auto)
                  FIX -> Registration Fee (150.00) | Death Care (500.00)
                  INPUT -> Deposit TYPE(Combo) | Amount (number should LEFT) | Invoice No. (VARCHAR)  -->

                  <input type="hidden" name="txtID" value="<?php echo $memID; ?>">


                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Fullname</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="fname" class="form-control" disabled value="<?php echo $memFname; ?>">
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Payment Date</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="date" name="paydate" class="form-control" id="datePicker" disabled value="<?php  ?>" >
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="validationCustom04" class="form-label">Deposit Type</label>
                    <input type="text" name="deptype" class="form-control" disabled value="<?php echo "Regular Savings"; ?>">
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Remaining Balance</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="rembal" class="form-control text-end" id="yourUsername" disabled value="<?php echo "&#8369; ".$Balance; ?>">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="inv" class="form-control" id="yourUsername" required>
                      <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Deposit Amount <span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="amo" class="form-control amount" id="" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01" maxlength="8">
                      <div class="invalid-feedback">Please enter amount at least &#8369; 50.00 - 2,400.00</div>
                    </div>
                  </div>

                  <div class="col-md-12 text-end">
                    <input type="reset" class="btn btn-secondary" name="resdep" value="Reset">
                    <input type="submit" class="btn btn-primary" name="savedep" value="Save">
                  </div>
                  </form>
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
<script src="jqueryto/moneyregexmoto.js"></script>

<script src="jqueryto/select2ito.min.js"></script>
<!-- <script src="jqueryto/sweetalertmoto.js"></script> -->
<link rel="stylesheet" href="jqueryto/select2moto.min.css">

<!-- Alert  -->
<script>

<?php 
if(isset($_SESSION['AmountMin'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Amount Minimum!',
        text: '<?php echo $_SESSION['AmountMin'] ?>',
        timer: 5000
    });    

<?php unset($_SESSION['AmountMin']); } ?>

<?php 
if(isset($_SESSION['AmountMax'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Amount Exceeded!',
        text: '<?php echo $_SESSION['AmountMax'] ?>',
        timer: 5000
    });    

<?php unset($_SESSION['AmountMax']); } ?>

<?php 
if(isset($_SESSION['doubleInv'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Invoice No. Duplicated!',
        text: '<?php echo $_SESSION['doubleInv'] ?>',
        timer: 5000
    });    

<?php unset($_SESSION['doubleInv']); } ?>
</script>

</body>
</html>
<?php 
    require_once 'process/app_regex.php';
?>
<script>
  $('input.amount').keyup(function(event) {
  if (event.which >= 37 && event.which <= 40) return;
  $(this).val(function(index, value) {
    return value
      // Keep only digits, decimal points, and dashes at the start of the string:
      .replace(/[^\d.-]|(?!^)-/g, "")
      // Remove duplicated decimal points, if they exist:
      .replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
      // Keep only two digits past the decimal point:
      .replace(/\.(\d{2})\d+/, '.$1')
      // Add thousands separators:
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  });
});

document.getElementById('datePicker').valueAsDate = new Date();
</script>