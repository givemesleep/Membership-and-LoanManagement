<?php
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

  if(isset($_GET['pmesID'])){
    try{

        $mid=$_GET['pmesID'];
        $sqlFetch="SELECT CONCAT(IF(p.gendID = 2,'Mr. ', IF(p.maritID = 1,'Ms. ', 'Mrs. ')), p.memSur,', ', p.memGiven, ' ', p.memMiddle, ' ', IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname,
                    p.ApplicationDate AS appd, p.memberID AS IDS
                FROM tbperinfo p
                LEFT JOIN tbsuffixes sf ON p.sufID=sf.sufID 
                WHERE p.memberID=?";
        $dataF=array($mid);
        $stmtf=$conn->prepare($sqlFetch);
        $stmtf->execute($dataF);

        $rowF=$stmtf->fetch();
        $full=$rowF['Fullname'];
        $ids=$rowF['IDS'];

        // $dob = new DateTime($rowF['appd']);
        // $formatted = $dob->format('Y-m-d');
        $dob = (new DateTime($rowF['appd']))->format('Y-m-d');
        // $dates = strtotime('%Y-%m-%d',strtotime($rowF['appd']));

    }catch(PDOException $e){
        echo $e->getMessage();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Apply PMES</title>
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
  $pages = "pendings"; require_once 'sidenavs/ov_side.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Membership</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="applicant_approved.php">Approved</a></li>
        <li class="breadcrumb-item active">PMES Application</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 25px;"><b>Pre-Membership Education Seminar</b></h5>
                <a href="applicant_pendings.php"><button type="btn" class="btn btn-dark" ><span class="bi bi-arrow-left"></span> Back</button></a>
                
                <form action="process/proc_approve.php" method="post"class="row g-3 mt-3 needs-validation" novalidate>

                  <header id=header-background>
                      <h6 class="mt-3"><b>Application Details</b></h6>
                  </header>

                  <!-- FETCH -> Fullname | PMES SCHEDULE | Application DATE
                  INPUT -> Refer NAME(Combo) | Conduct NAME(Combo) | Approved NAME (Auto)
                  FIX -> Registration Fee (150.00) | Death Care (500.00)
                  INPUT -> Deposit TYPE(Combo) | Amount (number should LEFT) | Invoice No. (VARCHAR)  -->

                  <input type="hidden" name="txtID" value="<?php echo $ids; ?>">

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Fullname</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="username" class="form-control" disabled placeholder="<?php echo $full; ?>">
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">PMES Schedule</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="date" name="username" class="form-control" disabled value="<?php echo $dob; ?>" >
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtinv" class="form-control" id="yourUsername" required>
                      <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">Referred By</label>
                      <select class="form-select" id="validationCustom04" name="cboRef">
                        <option selected disabled value="">Select Referral</option>
                        <?php 
                          $sqlRef="SELECT CONCAT(IF(p.gendID = 2,'Mr. ', IF(p.maritID = 1,'Ms. ', 'Mrs. ')), p.memSur,', ', p.memGiven, ' ', p.memMiddle, ' ', IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname, 
                          ms.memstats AS Statuses, p.memberID AS IDS
                          FROM tbperinfo p
                          LEFT JOIN tbsuffixes sf ON p.sufID=sf.sufID
                          LEFT JOIN tbmemstats ms ON p.memStatus=ms.memStatus
                          WHERE p.memStatus=1 OR p.memStatus=2                          
                          ";
                          $stmtRef=$conn->prepare($sqlRef);
                          $stmtRef->execute();
                          while($rows=$stmtRef->fetch()){
                            echo '<option value="'.$rows['IDS'].'">'.$rows['Fullname'].'</option>';
                          }

                        ?>
                      </select>
                  </div>

                  <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">Accompanied By <span class="required">*</span></label>
                      <select class="form-select" id="validationCustom04" name="cboAcc" required>
                        <option selected disabled value="">Select Accompany</option>
                        <?php 
                          $sqlCon="SELECT * FROM tbconducts";
                          $stmtCon=$conn->prepare($sqlCon);
                          $stmtCon->execute();
                          while($rows=$stmtCon->fetch()){
                            echo '<option value="'.$rows['conductID'].'">'.$rows['conName'].'</option>';
                          }

                        ?>
                      </select>
                    <div class="invalid-feedback">Please select person name.</div>
                  </div>
                  
                  <div class="col-md-4">
                    <label for="yourUsername" class="form-label">Approved By</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtCurUser" class="form-control" id="yourUsername" disabled placeholder="<?php echo $CurrUser; ?>">
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <header id=header-background>
                      <h6 class="mt-3"><b>Payment Details</b></h6>
                  </header>
                    
                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Registration Fee</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtReg" class="form-control" disabled placeholder="₱ 150.00" style="text-align: right;">
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Death Care</label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtDC" class="form-control" disabled placeholder="₱ 500.00" style="text-align: right;">
                      <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">Deposit Type <span class="required">*</span></label>
                      <select class="form-select" id="validationCustom04" name="cboDepType" required>
                        <option selected disabled value="">Select Type of Deposit</option>
                        <option value="1">Regular Savings</option>
                        <option value="2">Shared Capital</option>
                      </select>
                    <div class="invalid-feedback">Please select deposit type.</div>
                  </div>
                   
                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Deposit Amount <span class="required">*</span></label>
                    <div class="input-group has-validation">
                      <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                      <input type="text" name="txtamount" class="form-control amount" id="" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01">
                      <div class="invalid-feedback">Please enter amount.</div>
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
<script src="jqueryto/jikwerimoto.js"></script>

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
