<?php
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | New Loan Rates</title>
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
</style>

<?php
  require_once 'sidenavs/headers.php';
  $pages = "loanrates"; require_once 'sidenavs/ov_side.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Loan Rates</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="main_loanrates.php">Loan Rates</a></li>
        <li class="breadcrumb-item active">New Loan Rates</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 25px;"><b>Loan Rates</b></h5>
                <a href="main_loanrates.php"><button type="btn" class="btn btn-dark" ><span class="bi bi-arrow-left"></span> Back</button></a>
                
                <form action="process/proc_loanrates.php" method="post"class="row g-3 mt-3 needs-validation" novalidate>

                  <header id=header-background>
                      <h6 class="mt-3"><b>Loan Rate Details</b></h6>
                  </header>

                  <input type="hidden" name="lrID" value="<?php echo $ids; ?>">

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Loan Type<span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtloan" class="form-control" required placeholder="" maxlength="64">
                      <div class="invalid-feedback">Please enter your loan type.</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Amount Description<span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtamount" class="form-control" required placeholder="" maxlength="128">
                      <div class="invalid-feedback">Please enter your amount description.</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">Loan Approval<span class="required">*</span></label>
                      <select class="form-select" id="validationCustom04" name="cboapproval" required>
                        <option selected value="0">Select Role</option>
                        <?php
                            $choicea="General Manager";
                            $choiceb="Credit Committee";
                            $choicec="Board of Directors";
                            echo '<option value=" ' . $choicea . ' "> ' . $choicea . '</option>';
                            echo '<option value=" ' . $choiceb . ' "> ' . $choiceb . '</option>';
                            echo '<option value=" ' . $choicec . ' "> ' . $choicec . '</option>';
                        ?>
                      </select>
                    <div class="invalid-feedback">Please select person name.</div>
                  </div>

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Terms Description<span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtterms" class="form-control" id="yourUsername" required maxlength="40">
                      <div class="invalid-feedback">Please enter your term description.</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Interest Description<span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtint" class="form-control" id="yourUsername" required maxlength="40">
                      <div class="invalid-feedback">Please enter your interest description.</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">LPPI Computation</label>
                      <select class="form-select" id="validationCustom04" name="cbolppi">
                        <option selected value="0">Select LPPI</option>
                        <?php 
                            $all="age:18-64(0.00975 x term / 12mos) & age:66-70(3 pesos/thousand) & age:70+(4 pesos/thousand)";
                            $choicea="age:18-64(0.00975 x term / 12mos)";
                            $choiceb="age:66-70(3 pesos/thousand)";
                            $choicec="age:70+(4 pesos/thousand)";
                            echo '<option value=" ' . $choicea . ' "> ' . $choicea . '</option>';
                            echo '<option value=" ' . $choiceb . ' "> ' . $choiceb . '</option>';
                            echo '<option value=" ' . $choicec . ' "> ' . $choicec . '</option>';
                            echo '<option value=" ' . $all . ' ">All of the above</option>';
                        ?>
                      </select>
                    <div class="invalid-feedback">Please select person name.</div>
                  </div>

                  <div class="col-md-2">
                    <label for="yourUsername" class="form-label">No. of Co-Maker</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtcom" class="form-control" id="yourUsername" maxlength="20">
                      <div class="invalid-feedback">Please enter your cbu.</div>
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <label for="yourUsername" class="form-label">Service Fee(%)</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtservice" class="form-control" id="yourUsername" maxlength="20">
                      <div class="invalid-feedback">Please enter your service fee.</div>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <label for="yourUsername" class="form-label">CBU(%)</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtcbu" class="form-control" id="yourUsername" maxlength="20">
                      <div class="invalid-feedback">Please enter your cbu.</div>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <label for="yourUsername" class="form-label">Deferred Col Fee(%)</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtdef" class="form-control" id="yourUsername" maxlength="20">
                      <div class="invalid-feedback">Please enter your deferred col.</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Collateral Fee(%)</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtcol" class="form-control" id="yourUsername" maxlength="20">
                      <div class="invalid-feedback">Please enter your cbu.</div>
                    </div>
                  </div>

                  <!-- <input type="number" min="3" max="12"> -->
                    
                  <div class="text-end">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="jqueryto/select2ito.min.js"></script>
<!-- <script src="jqueryto/sweetalertmoto.js"></script> -->
<link rel="stylesheet" href="jqueryto/select2moto.min.css">

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
</script>
