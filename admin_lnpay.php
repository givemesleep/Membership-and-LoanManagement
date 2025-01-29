<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  //LoanID = Type of Loan | flags = pages | accID = Account ID
  $key="LLAMPCO";
  $loanID = $accID = $flag = $memID = '';
  $lnType = $lnCol = $lnCom = '';
  
  $disPSC = $disTD = $p = $red = '';
  $pscGood = $tdGood = false;
  $PSC = $TD = $maxAm = $minMos = $enLPPI ='';

$lnID = '';
$origAm = '';
$ovMos = '';
$ovInt = '';
$terms = '';
$issued = '';
$lnName = '';
$int = '';

  if(isset($_GET['flag'])){
    $flag = decrypt($_GET['flag'], $key);

  }

  if(isset($_GET['mem'])){
    $accID = decrypt($_GET['mem'], $key);

    $sqlUnik = "SELECT * FROM tbuninfo WHERE unID = ?";
    $dataUnik = array($accID);
    $stmtUnik = $conn->prepare($sqlUnik);
    $stmtUnik->execute($dataUnik);
    $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);

    //ID
    $memID = $rowUnik['memberID'];

    //Member Details (Joined)
    $sqlMem = "SELECT CONCAT(memGiven, ' ', memSur) AS fullname FROM tbperinfo WHERE memberID = ? AND isLoan = 1";

    $dataMem = array($memID);
    $stmtMem = $conn->prepare($sqlMem);
    $stmtMem->execute($dataMem);
    $rowMem = $stmtMem->fetch(PDO::FETCH_ASSOC);

    $Pangalan = $rowMem['fullname'];

    $lnInfo = "SELECT loanID AS lnID, lnunID AS lnunID , loanAm AS OrigAm, lnTotMos AS OvMos, lnTotInt AS OvInt, loanTerm AS Terms, loanAcquire AS Issued, lnMonInt, lnPrincipal
              FROM tbloaninfo WHERE memberID = ? AND lnstatID = 1 AND remarks = 0";
    $datalnInfo = array($memID);
    $stmtlnInfo = $conn->prepare($lnInfo);
    $stmtlnInfo->execute($datalnInfo);
    $reslnInfo = $stmtlnInfo->rowCount();
    if($reslnInfo > 0){
      $rowlninfo = $stmtlnInfo->fetch();
      $lnUnID = $rowlninfo['lnunID'];
      $lnID = $rowlninfo['lnID'];
      $origAm = $rowlninfo['OrigAm'];
      $ovMos = $rowlninfo['OvMos'];
      $ovInt = $rowlninfo['OvInt'];
      $terms = $rowlninfo['Terms'];
      $issued = $rowlninfo['Issued'];
      $principal = $rowlninfo['lnPrincipal'];
      $monInt = $rowlninfo['lnMonInt'];
    }else{
      $lnUnID = '';
      $lnID = 0;
      $origAm = 0;
      $ovMos = 0;
      $ovInt = 0;
      $terms = 0;
      $issued = 0;
    }

    $out = $principal + $monInt;

    $lnType = "SELECT loanType AS lnName, intRate AS interest FROM tblntypes WHERE loanID = ?";
    $datalnType = array($lnID);
    $stmtlnType = $conn->prepare($lnType);
    $stmtlnType->execute($datalnType);
    $reslnType = $stmtlnType->rowCount();
    if($reslnType > 0){
      $rowlnType = $stmtlnType->fetch();
      $lnName = $rowlnType['lnName'];
      $int = $rowlnType['interest'];
    }else{
      $lnName = '';
      $int = '';
    }
    
    // $amort = genAmortizationSched($origAm, $int, $terms, $issued);
                                    
    // foreach($amort as $values){
    //     $totAmount = $values['TotOv'];
    //     $totInterest = $values['TotInt'];
    // }
    $intMos = $origAm * perTodec($int); //Interest 
    $MosPay = $origAm / $terms; // Monthly
    $NextPay = number_format($MosPay + $intMos, "2", ".", ","); // Monthly + Interest

    $OutPay = number_format($ovMos, "2", ".", ",");
    $OutInt = number_format($ovInt, "2", ".", ",");
    $MosInt =  number_format($origAm * perTodec($int), "2", ".", ",");
  }  
  //memID loanID 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Loan Payment</title>
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
  #itemList {
    display: none;
    overflow-y: scroll;
    max-height: 350px;
    transition: background-color 0.3s ease;
  }
  ol li:hover {
    background-color: #f0f0f0;
    cursor: pointer;
  }
</style>
<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
  $pages = 'payloan';  $nav = 'trans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Transaction</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Members Transaction</li>
            <li class="breadcrumb-item active">Loan Payment</li>
        </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      
      <div class="col-lg-3">
        <div class="card" style="height: 500px;">
          <div class="card-body">
            
            <fieldset class="active" style="height: 500px;">
              <h5 class="card-title" style="font-size: 30px;"><b>Search Members</b></h5>

              <!-- <div class="row"> -->
              <div class="search-bar mb-3" style="margin-top: -15px">
                  <input type="text" id="searchInput" class="form-control" placeholder="Search Members">
              </div>

              <!-- List group with custom content -->
              <ol class="list-group list-group-numbered " id="itemList">

                <?php 
                  $sqlbg = "SELECT 
                            un.unID AS ID, p.memberID AS memID, p.memNick AS Nickname,
                            CONCAT(p.memGiven, ' ', p.memSur) AS Fullname,
                            p.memSur AS lname, p.memGiven AS fname, p.memMiddle AS mname, p.suffixes AS suffix
                            FROM tbuninfo un
                            JOIN tbperinfo p ON un.memberID = p.memberID
                            JOIN tbloaninfo lnp ON lnp.memberID = p.memberID
                            WHERE p.memstatID = 1 AND p.isLoan = 1 AND lnp.lnstatID = 1 ORDER BY p.memSur";
                  $stmtbg = $conn->prepare($sqlbg);
                  $stmtbg->execute();
                  $list = '';
                  if($stmtbg->rowCount() > 0){
                      while($rowbg=$stmtbg->fetch()){
                          $list.='
                          <a href="admin_lnpay.php?mem='.encrypt($rowbg['ID'], $key).'&flag='.encrypt('lnPay', $key).'">
                            <li class="list-group-item " style="font-size: 13px; border: none;" title="'.$rowbg['Fullname'].' Account">Name : <b>'.$rowbg['Fullname'].'</b><br>ID : <b>'.$rowbg['ID'].'</b> </li>
                          </a>
                          ';
                      }
                  }else {
                      echo '';
                  }
                  echo $list;
            
                ?>
              
              </ol>
              <!-- </div> -->

            </fieldset>

          </div>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
              
            <fieldset <?php echo ($flag == '') ? 'class="active"' : '' ?> style="height: 410px;">
              
              <h5 class="card-title" style="font-size: 35px;"><b>Pay Loan</b></h5>
                  
              <div class="col-md-12 text-start">
                <h6>Please search or select a member before continuing browsing. </h6>
              </div>
            
            </fieldset>

            <fieldset  <?php echo ($flag == 'lnPay') ? 'class="active"' : '' ?> >
                <h5 class="card-title" style="font-size: 35px;"><b>Loan Payment</b></h5>
                <div class="row g-3">
                <hr>

                <div class="col-md-12"> 
                    <div class="card" style="border: 1px solid; height: 120px; margin-top: -10px;">
                        <div class="card-body">
                            <div class="row mt-3">  

                                    <div class="col-md-6">
                                        <h6>Member</h6>
                                        <h3><b><?php echo $Pangalan; ?></b></h3>
                                        <h6><?php echo $accID; ?></h6>
                                    </div>

                                    <div class="col-md-3">
                                        <h6>Outstanding Balance</h6>
                                        <h3><b>&#x20B1; <?php echo number_format($out, "2",".", ","); ?></b></h3>
                                        <!-- <h6>&#x20B1; <?php echo $OutInt;//echo number_format($ovInt, "2", ".", ",")  ?> Total Interest</h6> -->
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <h6>Next Payment</h6>
                                        <h3><b>&#x20B1; <?php echo $NextPay; ?></b></h3>
                                        <h6>&#x20B1; <?php echo $MosInt;  ?> Monthly Interest</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>

                <form action="process/proc_lnpay.php" method="post" class="needs-validation" novalidate>
                    <div class="row g-3">

                        <input type="hidden" name="memberID" value="<?php echo $memID; ?>">
                        <input type="hidden" name="lnID" value="<?php echo $lnID; ?>">
                        <input type="hidden" name="AccID" value="<?php echo $accID; ?>">
                        <input type="hidden" name="lnUnID" value="<?php echo $lnUnID; ?>">

                        <div class="col-md-12"  style="margin-top: -30px; ">
                            <h5 class="card-title" style="font-size: 20px;"><b><?php echo $lnName; ?> Payment</b></h5>
                        </div>

                        <div class="col-md-6" style="margin-top: -10px; ">
                            <label for="yourUsername" class="form-label">Invoice Number <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">PHP</span> -->
                                <input type="text" class="form-control" name="invRef" required maxlength="6">
                                <div class="invalid-feedback">Please enter beneficiaries name</div>
                            </div>
                        </div>

                        <div class="col-md-6" style="margin-top: -10px; ">
                            <label for="yourUsername" class="form-label">Cash Voucher Reference <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">PHP</span> -->
                                <input type="text" class="form-control" name="cvRef" required maxlength="6">
                                <div class="invalid-feedback">Please enter beneficiaries name</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" id="upswitch" onclick="toggleRequired()">
                                <label class="form-check-label" for="switch">With Cheque Payment</label>
                            </div>
                        </div>  

                        <div class="col-md-6" id="check" style="display: none;">
                            <label for="yourUsername" class="form-label" id="labeled" style="display : none;">Cheque Reference <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">PHP</span> -->
                                <input type="text" class="form-control" id="cheque" style="display : none;" maxlength="8  ">
                                <div class="invalid-feedback">Please enter beneficiaries name</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="yourUsername" class="form-label">Payable Amount <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">PHP</span> -->
                                <input type="text" class="form-control amount text-end" name="payAm" required >
                                <div class="invalid-feedback">Please enter beneficiaries name</div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <input type="submit" value="Save" class="btn btn-success">
                        </div>
                    </div> 
                </form>
                

                


                </div>
            </fieldset>

            <div class="text-center">
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

<script>
function toggleRequired() {
var inputField = document.getElementById('cheque');
var checkbox = document.getElementById('upswitch');
var label = document.getElementById('labeled');
var div = document.getElementById('check');
if (checkbox.checked) {
    inputField.style.display = 'block';
    div.style.display = 'block';
    label.style.display = 'block';
    inputField.setAttribute('required', 'required');
} else {
    inputField.removeAttribute('required');
    inputField.style.display = 'none';
    label.style.display = 'none';
    div.style.display = 'none';
}
}
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


