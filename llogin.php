<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Pay PMES</title>
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
  </style>

<?php
//   require_once 'sidenavs/headers.php';
//   $pages = "og"; $nav = "payee"; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Payments</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="applicant_approved.php">Payment</a></li>
        <li class="breadcrumb-item active">On-going</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <!-- <h5 class="card-title" style="font-size: 25px;"><b>Pre-Membership Education Seminar</b></h5> -->
                <!-- <a href="applicant_pendings.php"><button type="btn" class="btn btn-dark" ><span class="bi bi-arrow-left"></span> Back</button></a> -->

                <form action="process/proc_checker.php?checker=2" method="post" class="row g-3 mt-2 needs-validation" novalidate>
                  <fieldset <?php echo ($accID != "") ? '' : 'class="active"' ?>>
                      <div class="row g-3">
                          <div class="col-md-12 text-start">
                              <h2><b>Search Member</b></h2>
                          </div>
                          
                          <div class="col-md-3">
                            <label for="yourUsername" class="form-label">Account No.</label>
                              <div class="input-group has-validation">
                                  <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                  <input type="text" name="idmoto" class="form-control" placeholder="Search Account ID" required>
                                  <div class="invalid-feedback">Please Enter Account ID</div>
                              </div>
                          </div>
                          
                          <div class="col-md-4 mt-5 text-start">
                              <input  <?php echo ($accID == "") ? 'type="submit" name="Search ID" class="btn btn-success"' : 'type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"' ?>>
                          </div>

                      </div> <!-- end of row -->
                    </fieldset>
                </form>
                
                <form action="process/proc_payongoing.php" method="post"class="row g-3 mt-2 needs-validation" novalidate>

                  <fieldset <?php echo ($accID != "") ? 'class="active"' : '' ?>>

                    <div class="row g-3">
                        <div class="col-md-12 text-start">
                            <h2><b>On-Going Payment</b></h2>
                        </div>
                        <div class="col-md-6">
                          <h6 class="mt-3"><b>Name : <?php echo $Pangalan; ?> </b></h6>
                          <h6 class="mt-3"><b>Member ID : <?php echo $accID; ?> </b></h6>
                          <h6 class="mt-3"><b>Total Amount : &#8369;<?php echo $Regular; ?> </b></h6>
                        </div>
                        <div class="col-md-6">
                          <h6 class="mt-3"><b>Email : <?php echo $Email; ?> </b></h6>
                          <h6 class="mt-3"><b>Deposit : Regular Savings </b></h6>
                          <h6 class="mt-3"><b>Remaining Balance : &#8369;<?php echo $newBal; ?> </b></h6>
                        </div>
                        <div class="col-md-12 text-center">

                        </div>

                        <div class="col-md-4">
                          <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="invRef" class="form-control" id="yourUsername" required>
                                <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                            </div>
                        </div>

                        <div class="col-md-2">
                          <input type="hidden" name="ongoingID" value="<?php echo $memID; ?>">
                          <input type="hidden" name="accID" value="<?php echo $accID; ?>">
                        </div>

                        <div class="col-md-4">
                          <label for="yourUsername" class="form-label">Deposit Amount <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="payAm" class="form-control amount" id="" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01" maxlength="8">
                                <div class="invalid-feedback">Please enter amount at least &#8369; 50.00 - 2,400.00</div>
                            </div>
                        </div>

                        <div class="col-md-2"></div>

                        <div class="col-md-12">
                            <label for="remTable" class="form-label ">Payments History</label>
                            <table class="table table-bordered" id="remTable" style="width : 100%;">
                                <thead>
                                    <tr>
                                        <th style="width : 10%;">#</th>
                                        <th class="text-end" style="width : 40%;">Amount</th>
                                        <th style="width : 50%;">Date and Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                     <td>awgduawd</td>
                                     <td>awgduawd</td>
                                     <td>awgduawd</td>
                                     </tr>
                                </tbody>
                            </table>
                            <div class="mt-3 text-start">
                                <h6><b>Total Amount : &#8369</b></h6>
                                <h6><b>Remaining Balance : &#8369</b></h6>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <input type="submit" class="btn btn-success" name="savedep" value="Save">
                        </div>
                    </div> <!-- end of row -->
                  </fieldset>
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
<script src="jqueryto/jikwerimoto.js"></script>
<script src="jqueryto/select2ito.min.js"></script>
<link rel="stylesheet" href="jqueryto/select2moto.min.css">

</body>
</html>