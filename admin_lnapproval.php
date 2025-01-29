<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  //LoanID = Type of Loan | flags = pages | accID = Account ID
  $key="LLAMPCO";
  $loanID = $accID = $flag = $memID = '';
  $lnType = $lnCol = $lnCom = $DepAm = '';
  


  if(isset($_GET['lntype'])){
    $loanID = decrypt($_GET['lntype'], $key);

    $lnType = "SELECT * FROM tblntypes WHERE loanID = ?";
    $lnData = array($loanID);
    $lnstmt = $conn->prepare($lnType);
    $lnstmt->execute($lnData);
    $lnRow = $lnstmt->fetch();
    $lnType = $lnRow['loanType'];
    $lnCol = $lnRow['colatFee'];
    $lnCom = $lnRow['comaker'];
  }

  if(isset($_GET['accrev'])){
    $accID = decrypt($_GET['accrev'], $key);

    $sqlUnik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    $dataUnik = array($accID);
    $stmtUnik = $conn->prepare($sqlUnik);
    $stmtUnik->execute($dataUnik);
    $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);

    //ID
    $memID = $rowUnik['unID'];

    //Member Details (Joined)
    $sqlMem = "SELECT CONCAT(IF(p.gendID = 1, 'Ms. ', 'Mr. '), p.memGiven, ' ', p.memSur) AS Fullname,
                ci.mememail AS EmailAddress, p.ApplyDate AS ApplicationDate
              FROM tbperinfo p

              JOIN tbconinfo ci
              ON p.memberID = ci.memberID
              WHERE p.memberID = ?";

    $dataMem = array($accID);
    $stmtMem = $conn->prepare($sqlMem);
    $stmtMem->execute($dataMem);
    $rowMem = $stmtMem->fetch(PDO::FETCH_ASSOC);

    $Pangalan = $rowMem['Fullname'];
    
    $sqlLoan = "SELECT loanAm AS Amount, loanTerm AS Terms, loanID AS lnID, lnApply AS lnDate,
                    AddedBy AS lnAssist FROM tbloaninfo
                    WHERE memberID = ? AND remarks = 0";
    $dataLoan = array($accID);
    $stmtLoan = $conn->prepare($sqlLoan);
    $stmtLoan->execute($dataLoan);
    $rowLoan = $stmtLoan->fetch(PDO::FETCH_ASSOC);
    $lnID = $rowLoan['lnID'];
    $Amount = $rowLoan['Amount'];
    $Terms = $rowLoan['Terms'];
    $lnDate = $rowLoan['lnDate'];
    $assist = $rowLoan['lnAssist'];

    $sqlTypes = "SELECT loanType AS lnType, intRate AS interest, servcFee AS service, cbu AS cbu, defCollFee AS def, colatFee AS colat, appID AS appID 
                FROM tblntypes WHERE loanID = ?";
    $dataTypes = array($lnID);
    $stmtTypes = $conn->prepare($sqlTypes);
    $stmtTypes->execute($dataTypes);
    $resTypes = $stmtTypes->rowCount();
    if($resTypes > 0){
        $rowTypes = $stmtTypes->fetch(PDO::FETCH_ASSOC);
            $lnType = $rowTypes['lnType'];
            $interest = $rowTypes['interest'];
            $service = $rowTypes['service'];
            $cbu = $rowTypes['cbu'];
            $def = $rowTypes['def'];
            $colat = $rowTypes['colat'];
            $appID = $rowTypes['appID'];
    }else{
        $lnType = $interest = $service = $cbu = $def = $colat = $appID = '';
    }

  }  
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Loan Application</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/llampcologo.png" rel="icon">
  <link href="assets/img/llampcologo.png" rel="apple-touch-icon">

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
<style>
  fieldset {
    display: none;
  }
  fieldset.active {
    display: block;
  }
  footer{
    text-align: center;
  }
  .required{
    color: red;
  }
  #itemList{
    display: none;
  }

</style>
<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
  $pages = 'cretloan';  $nav = 'trans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Transaction</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Members Transaction</li>
            <li class="breadcrumb-item active">Apply Loan</li>
        </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      
    <div class="col-lg-3">
        <div class="card" style="height: 500px;">
            <div class="card-body">

                <div class="row">
                    
                    <div class="col-md-12 mt-3">
                        <a href="admin_lnpenview.php?mem=<?php echo encrypt($accID, $key) ?>"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
                    </div>

                    <div class="col-md-12 mt-3 text-center">
                        <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                    </div>

                    <div class="col-md-6 mt-3 text-start">
                        <p>Member ID</p>
                    </div>

                    <div class="col-md-6 mt-3 text-end">
                        <h6><b><?php echo $memID; ?></b></h6>
                    </div>

                    <div class="col-md-12 text-center mt-3">
                        <h6><b><?php echo $Pangalan; ?></b></h6>
                    </div>

                    <div class="col-md-12 text-center">
                        <p>Name</p>
                    </div>

                    <div class="col-md-6 mt-5 text-end">
                        <!-- <a href="admin_lnapproval.php?approval?decision=<?php echo encrypt($memID, $key); ?>"><button class="btn btn-success" style="width: 100%;">Approved</button></a> -->
                    </div>

                    <div class="col-md-6 mt-5 text-start">
                        <!-- <a href="process/proc_rmmem.php?lnreject=<?php echo encrypt($memID, $key); ?>"><button class="btn btn-danger" style="width: 100%;">Decline</button></a> -->
                    </div>

                </div>
            
            </div>
        </div>
    </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">

            <!-- Add Your Loan Details  -->
            <fieldset class="active" >
              <h5 class="card-title" style="font-size: 35px;"><b>Loan Details</b></h5>
              <a <?php echo ($flag == 'lnDetails') ? '' : 'style="display: none;"' ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key) ?>&flag=<?php echo encrypt('loanType', $key) ?>"><button class="btn btn-dark" style="margin-left: 847px; margin-top: -120px"><span class="bi bi-arrow-return-left"></span> Back</button></a>
              <form action="process/proc_lnactive.php?review=1" method="post" class="needs-validation" novalidate>

                <div class="row g-3">

                <hr class="mt-2" >

                <div class="col-md-12"> 
                    <div class="card" style="border: 1px solid; height: 120px; margin-top: -10px;" >
                        <div class="card-body">
                            <div class="row mt-3">

                                <div class="col-md-4">
                                    <h6>Loan Type</h6>
                                    <h3><b><?php echo $lnType; ?></b></h3>
                                    <h6><?php echo $Pangalan; ?></h6>
                                </div>

                                <div class="col-md-4">
                                    <h6>Requested</h6>
                                    <h3><b>&#x20B1; <?php echo number_format($Amount, "2", ".", ","); ?></b></h3>
                                    <h6><?php echo $Terms; ?> Months Payment</h6>
                                </div>
                                
                                <?php 
                                
                                $amort = genAmortizationSched($Amount, $interest, $Terms, $lnDate);
                                
                                foreach($amort as $values){
                                    $totAmount = $values['TotOv'];
                                    $totInterest = $values['TotInt'];
                                }
                                
                                ?>

                                <div class="col-md-4">
                                    <h6>Monthly</h6>
                                    <h3><b>&#x20B1; <?php echo number_format($Amount / $Terms, "2", ".", ","); ?></b></h3>
                                    <h6><?php echo $interest;  ?> % Interest Rate</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                  <div class="col-md-12" style="margin-top: -30px;">
                    <h5 class="card-title" style="font-size: 20px;"><b><?php echo $lnType; ?></b></h5>
                  </div>
                  
                  <input type="hidden" name="memID" value="<?php echo $accID; ?>" >
                  <input type="hidden" name="loanID" value="<?php echo $loanID; ?>">
                  <input type="hidden" name="AddedBy" value="<?php echo $CurrUser; ?>">

                  <!-- <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Loan Type</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control" value="<?php echo $lnType; ?>" readonly disabled>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div> -->

                  <div class="col-md-6" style="margin-top: -5px;">
                    <label for="yourUsername" class="form-label">Requesting Amount</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control text-end" value="&#x20B1; <?php echo number_format($Amount, "2", ".", ","); ?>" readonly disabled>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-6" style="margin-top: -5px;">
                    <label for="yourUsername" class="form-label">Loan Terms</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control" value="<?php echo $Terms; ?> Months"  readonly disabled title="Loan Terms">
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <input type="text" name="invNo" class="form-control" id="loanAm" required maxlength="6">
                        <div class="invalid-feedback">Please enter Invoice No.</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Cash Voucher Reference <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <input type="text" name="cvRef" class="form-control number" id="loanTerm" required maxlength="6"> 
                        <div class="invalid-feedback">Please enter loan amount</div>
                    </div>
                  </div>

                  <div class="text-end">
                      <input type="submit" class="btn btn-success" value="Save" tabindex="5">
                  </div>

                </div>

              </form>
            </fieldset>

            <!-- Add Beneficiaries If needed -->
            <fieldset <?php echo ($flag == 'Ben') ? 'class="active"' : '' ?> style="height: 480px;">
              <h5 class="card-title" style="font-size: 25px;"><b>Add Beneficiaries</b></h5>
              <form action="process/proc_loanpend.php?ben=<?php echo $memID; ?>" method="post" class="needs-validation" novalidate>

                <div class="row g-3">

                  <div class="col-md-12">
                    <hr>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">(1) Full Name<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="fname1" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Date of Birth<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="date" name="dob1" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries birthday</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Occupation<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="occu1" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries occupation</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Relationship<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="res1" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter the relationship between beneficiaries </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">(2) Full Name<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="fname2" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Date of Birth<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="date" name="dob2" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries birthday</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Occupation<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="occu2" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries occupation</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Relationship<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="res2" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter the relationship between beneficiaries </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">(3) Full Name<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="fname3" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Date of Birth<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="date" name="dob3" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries birthday</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Occupation<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="occu3" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter beneficiaries occupation</div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Relationship<span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                        <input type="text" name="res3" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter the relationship between beneficiaries </div>
                    </div>
                  </div>

                  <div class="text-end">
                      <input type="submit" class="btn btn-success" value="Next" tabindex="5">
                  </div>

                </div>

              </form>
            </fieldset>

            <div class=" text-center">
              <hr>
              <p><?php echo (new \DateTime())->format('F j, Y'); ?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; <span id="clock4"></span></p>
            </div>
              
          </div>
        </div>
      </div>

    </div>
  </section>    
</main>

<?php 
require_once 'sidenavs/footer.php'; 
// require_once 'process/app_regex.php';
?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<script src="jqueryto/jquerymoto.js"></script>
<script src="jqueryto/poppermoto.js"></script>
<script src="jqueryto/bootstrapmoto.js"></script>
<script src="jqueryto/sweetalertmoto.js"></script>
<script src="jqueryto/jikwerimoto.js"></script>
<script src="jqueryto/select2ito.min.js"></script>
<!-- <link rel="stylesheet" href="jqueryto/select2moto.min.css"> -->

<!-- reGex -->
<script>
$('.number').on('input', function (event) { 
  this.value = this.value.replace(/[^0-9]/g, '');
});
</script>

<!-- Template Main JS File --> 
<script src="assets/js/main.js"></script>

<script>
const searchBox = document.getElementById('searchInput');
const list = document.getElementById('itemList');
const items = list.getElementsByTagName('li');

searchBox.addEventListener('input', function() {
  const filter = searchBox.value.toLowerCase().trim();
  let hasVisibleItems = false;

  for (let i = 0; i < items.length; i++) {
      const item = items[i];
      if (item.textContent.toLowerCase().includes(filter)) {
          item.style.display = '';
          hasVisibleItems = true;
      } else {
          item.style.display = 'none';
      }
  }

  if (filter === '') {
      list.style.display = 'none';
  } else {
      list.style.display = hasVisibleItems ? 'block' : 'none';
  }
});

function updateDropdowns() {
  const dropdown1 = document.getElementById('com1');
  const dropdown2 = document.getElementById('com2');
  const selectedValue1 = dropdown1.value;
  const selectedValue2 = dropdown2.value;

  for (let option of dropdown1.options) {
      option.style.display = option.value === selectedValue2 ? 'none' : 'block';
  }

  for (let option of dropdown2.options) {
      option.style.display = option.value === selectedValue1 ? 'none' : 'block';
  }
}
</script>

<!-- Switch -->
<script>
$('#insurance').on('change', function(){
  this.value = this.checked ? 1 : 0;
  // alert(this.value);
}).change();
</script>

<!-- sessions -->
<script>
//starting
<?php 
if(isset($_SESSION['lnSuc'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Success!',
        text: '<?php echo $_SESSION['lnSuc'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['lnSuc']); } ?>
//ending

<?php 
if(isset($_SESSION['lnErr'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Unable to Proceed!',
        text: '<?php echo $_SESSION['lnErr'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['lnErr']); } ?>

</script>

<!-- time date  -->
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

    $("#clock4").html(currentTimeString);
 }

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

</body>
</html>


