<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

  $accID = $memID = $depType = '';
  $reg = $sc = $td = $ss = $fs = $sv = $prev ='';
  if(isset($_GET['deptype'])){
    $depType = $_GET['deptype'];
    switch($depType){
      case 1:
        $reg = 'class="active"';
        break;
      case 2:
        $sc = 'class="active"';
        break;
      case 3:
        $td = 'class="active"';
        break;
      case 4:
        $sv = 'class="active"';
        break;
      case 5:
        $ss = 'class="active"';
        break;
      case 6:
        $fs = 'class="active"';
        break;
      case 7:
        $fs = 'class="active"';
        break;
      default:
        $reg = $sc = $td = $ss = $fs = $sv = $prev ='';
        break;
    }
  }


  if(isset($_GET['cretdep'])){
    $accID = $_GET['cretdep'];

    $sqlUnik = "SELECT * FROM tbuninfo WHERE unID = ?";
    $dataUnik = array($accID);
    $stmtUnik = $conn->prepare($sqlUnik);
    $stmtUnik->execute($dataUnik);
    $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);

    //ID
    $memID = $rowUnik['memberID'];

    //Member Details (Joined)
    $sqlMem = "SELECT CONCAT(IF(p.gendID = 1, 'Mrs. ', 'Mr. '), p.memSur, ', ', p.memGiven, ' ', p.memMiddle, ' ', suffixes) AS Fullname,
                ci.mememail AS EmailAddress, p.ApplyDate AS ApplicationDate
              FROM tbperinfo p

              JOIN tbconinfo ci
              ON p.memberID = ci.memberID
              WHERE p.memberID = ?";

    $dataMem = array($memID);
    $stmtMem = $conn->prepare($sqlMem);
    $stmtMem->execute($dataMem);
    $rowMem = $stmtMem->fetch(PDO::FETCH_ASSOC);

    $Pangalan = $rowMem['Fullname'];
    $Email = $rowMem['EmailAddress'];
    $ApplyDate = $rowMem['ApplicationDate'];

    // $sqlDep = "SELECT regSav FROM tbdepinfo WHERE memberID = ?";
    // $dataDep = array($memID);
    // $stmtDep = $conn->prepare($sqlDep);
    // $stmtDep->execute($dataDep);
    // $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);

    // $Regular = $rowDep['regSav'];

    // $remBal = 2400.00 - $Regular;

    // $newBal = checkDecimal($remBal);
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Membership Accounts</title>
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
</style>
<body class="d-flex flex-column min-vh-100">

<?php 
  // require_once 'sidenavs/headers.php';
  //$pages = 'credep';  $nav = 'deptrans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <br>
            <a href="admin_index.php"><button class="btn btn-dark" <?php echo ($accID == "") ? '' : 'style="display:none;"' ?>><span class="bi bi-arrow-left"></span> Back</button></a>
            <h5 class="card-title" style="font-size: 25px;"><b><?php echo ($accID == "") ? 'Create Deposit' : 'Add Deposit' ?></b></h5>
            <br>
              <form action="process/proc_checker.php?checker=3" method="post" class="row g-3 needs-validation" novalidate>

                  <fieldset <?php echo ($accID != "") ? '' : 'class="active"' ?>>
                    <div class="row g-3">
                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                          <div class="input-group has-validation">
                            <input type="text" name="idmoto" class="form-control" placeholder="Search Account ID" list="accountID" required>
                            <div class="invalid-feedback">Please Enter Account ID</div>
                          </div>
                        </div>
                      <div class="col-md-3"></div>

                      <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="submit" name="Search" value="Search" class="btn btn-success" style="width: 100%;">
                        </div>
                      <div class="col-md-3"></div>

                      <div class="mt-5 text-center">
                        <p><?php echo (new \DateTime())->format('Y-m-d'); ?>&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp <span id="clock"></span></p>
                      </div>
                    </div>
                  </fieldset>

              </form>
            </div>
        </div>
      </div>
    </div>
  </section>    
</main>

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
<link rel="stylesheet" href="jqueryto/select2moto.min.css">

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
//starting
<?php 
if(isset($_SESSION['MessSent'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Email Sent!',
        text: '<?php echo $_SESSION['MessSent'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['MessSent']); } ?>
//ending

<?php 
if(isset($_SESSION['ErrMess'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'danger',
        title: 'Email Not Sent!',
        text: '<?php echo $_SESSION['ErrMess'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['ErrMess']); } ?>

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
  	
  	
   	$("#clock").html(currentTimeString);
    $("#clock2").html(currentTimeString);
    
    $("#clock3").html(currentTimeString);
    $("#clock4").html(currentTimeString);
    $("#clock5").html(currentTimeString);
    $("#clock6").html(currentTimeString);
    $("#clock7").html(currentTimeString);
    $("#clock8").html(currentTimeString);
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


