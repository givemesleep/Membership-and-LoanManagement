<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';
  // session_start();

  $accID = $memID = $depType = $flag = '';
  // $reg = $sc = $td = $ss = $fs = $sv = $prev ='';
  $classIto = '';
  $dt = $did = '';
  $key= "LLAMPCO";

  if(isset($_GET['deptype'])){
    $depType = decrypt($_GET['deptype'], $key);
    //SQL For Dep Type
    $sqlDep = "SELECT deptypeID, depDesc FROM tbdepType WHERE deptypeID = ?";
    $dataDep = array($depType);
    $stmtDep = $conn->prepare($sqlDep);
    $stmtDep->execute($dataDep);
    $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    $dt = $rowDep['depDesc'];
    $did = $rowDep['deptypeID'];
  }

  if(isset($_GET['flag'])){
    $flag = decrypt($_GET['flag'], $key);

    switch($flag){
      case 'deposit':
        $flag = 'deposit';
      break;
      case 'paydep':
        $flag = 'paydep';
      break;
    }
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
    $sqlMem = "SELECT CONCAT(IF(p.gendID = 1, 'Mrs. ', 'Mr. '), p.memGiven, ' ', p.memSur) AS Fullname,
                ci.mememail AS EmailAddress, p.ApplyDate AS ApplicationDate
              FROM tbperinfo p

              JOIN tbconinfo ci
              ON p.memberID = ci.memberID
              WHERE p.memberID = ? AND p.isApproved = 1 AND p.isActive = 1";

    $dataMem = array($memID);
    $stmtMem = $conn->prepare($sqlMem);
    $stmtMem->execute($dataMem);
    $rowMem = $stmtMem->fetch(PDO::FETCH_ASSOC);

    $Pangalan = $rowMem['Fullname'];
    
    $sqlDeposit = "SELECT regSav AS RS, shareCap AS PSC, timeDep AS TD, speVol AS SV, speSav AS SS, funSav AS FS FROM tbdepinfo WHERE memberID = ?";
    $dataDep = array($memID);
    $stmtDep = $conn->prepare($sqlDeposit);
    $stmtDep->execute($dataDep);
    $resDep = $stmtDep->rowCount();
    if($resDep > 0){
      $rowDep = $stmtDep->fetch();
      $RS = number_format($rowDep['RS'], "2", ".", ",");
      $PSC = number_format($rowDep['PSC'], "2", ".", ",");
      $TD = number_format($rowDep['TD'], "2", ".", ",");
      $SV = number_format($rowDep['SV'], "2", ".", ",");
      $SS = number_format($rowDep['SS'], "2", ".", ",");
      $FS = number_format($rowDep['FS'], "2", ".", ",");

    }else{
      $RS = $PSC = $TD = $SV = $SS = $FS = '';
    }

    

    $depAm = '';
    switch($did){
    case 1:
      $depAm = $RS;
    break;
    case 2: 
      $depAm = $PSC;
    break;
    case 3: 
      $depAm = $TD;
    break;
    case 4: 
      $depAm = $SV;
    break;
    case 5: 
      $depAm = $SS;
    break;
    case 6: 
      $depAm = $FS;
    break;
    default:
    $depAm = 0.00;
    break;
  }

  }

  

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Deposit Application</title>
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
  form label{
    font-weight: 600;
    }
  .required{
    color: red;
    } 
  .disabled {
    pointer-events: none;
    cursor: not-allowed;
    opacity: 0.5; /* optional */
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
  $pages = 'cretdep';  $nav = 'trans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Transaction</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Members Transaction</li>
            <li class="breadcrumb-item active">Add Deposit</li>
        </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">

      <div class="col-lg-3">
        <div class="card" style="height: 500px;">
          <div class="card-body">
            
            <fieldset class="active">
              <h5 class="card-title" style="font-size: 30px;"><b>Search Members</b></h5>

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
                            WHERE p.memstatID = 1 ORDER BY p.memSur";
                  $stmtbg = $conn->prepare($sqlbg);
                  $stmtbg->execute();
                  $list = '';
                  if($stmtbg->rowCount() > 0){
                      while($rowbg=$stmtbg->fetch()){
                          $list.='
                          <a href="admin_createdep.php?mem='.encrypt($rowbg['ID'], $key).'&flag='.encrypt('deposit', $key).'">
                            <li class="list-group-item " style="font-size: 13px; border: none;" title="Click to view '.$rowbg['Nickname'].' Deposit/Loan.">Name : <b>'.$rowbg['Fullname'].'</b><br>ID : <b>'.$rowbg['ID'].'</b> </li>
                          </a>
                          ';
                      }
                  }else {
                      echo '<li class="list-group-item">Please Search</li>';
                  }
                  echo $list;
            
            ?>
              
              </ol><!-- End with custom content -->

                
                

            </fieldset>

            <fieldset <?php //echo ($flag != '') ? 'class="active"' : '' ?> style="height: 500px;">
              <div class="col-md-12 mt-3">
                <a href="admin_createdep.php"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
              </div>
              
              <div class="row mt-3">
                
                <div class="col-md-12 mt-3 text-center">
                    <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                </div>

                <div class="col-md-6 mt-3 text-start">
                    <p>Member ID</p>
                </div>

                <div class="col-md-6 mt-3 text-end">
                    <h6><b><?php echo $accID; ?></b></h6>
                </div>

                <div class="col-md-12 mt-3 text-center">
                    <h6><b><?php echo $Pangalan; ?></b></h6>
                </div>
                
                <div class="col-md-12 text-center ">
                    <p>Full Name</p>
                </div>

                <div class="col-md-12"> 
                  <a <?php echo ($flag != 'deposit') ? '' : 'style="display: none;"' ?> href="admin_createdep.php?mem=<?php echo encrypt($accID, $key) ?>&flag=<?php echo encrypt('deposit', $key) ?>"><button class="btn btn-dark" style="width: 100%;">Return Deposit Type</button></a>
                </div>

                </div>
            </fieldset>

          </div>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">

              <fieldset <?php echo ($flag != '') ? '' : 'class="active"' ?> style="height: 410px;">
                  
                <h5 class="card-title" style="font-size: 35px;"><b>Add Deposit</b></h5>
                  
                <div class="col-md-12 text-start">
                  <h6>Please search or select a member before continuing browsing. </h6>
                </div>

              </fieldset>

              <fieldset <?php echo ($flag == 'deposit') ? 'class="active"' : '' ?> >

                <h5 class="card-title" style="font-size: 35px;"><b>Select Deposit Type</b></h5>
                <div class="row g-3">

                  <div class="col-md-6">
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-4"> 
                    <div class="card" style="border: 1px solid; height: 120px;">
                      <div class="card-body">
                          <div class="row mt-3">  

                            <div class="col-md-9">
                                <h6>Member</h6>
                                <h3><b><?php echo $Pangalan; ?></b></h3>
                                <h6>ID : <?php echo $accID; ?></h6>
                            </div>

                            <div class="col-md-3 text-center">
                                <h6>Member Status</h6>
                                <h3><b><span class="badge bg-success">Approved</span></b></h3>
                            </div>
                            
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4" style="margin-top: -10px;">
                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(1,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Regular Savings</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(4,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid; margin-top: -10px;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Special Voluntary</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                  <div class="col-md-4" style="margin-top: -10px;">
                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(2,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Shared Capital</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(5,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid; margin-top: -10px;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Special Savings</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                  <div class="col-md-4" style="margin-top: -10px;" >
                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(3,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid; ">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Time Deposit</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createdep.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('paydep',$key); ?>&deptype=<?php echo encrypt(6,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid; margin-top: -10px;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Fun Saver</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text">Amount : </p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                </div>

              </fieldset>

              <fieldset <?php echo ($flag == 'paydep') ? 'class="active"' : '' ?>>
                <div class="container">
                  <div class="row">
                    <div class="col-md-8">
                      <h5 class="card-title" style="font-size: 35px;"><b>Add Deposit</b></h5>
                    </div>
                    <div class="col-md-4 text-end mt-4">
                    <a <?php echo ($flag == 'paydep') ? '' : 'style="display: none;"' ?> href="admin_createdep.php?mem=<?php echo encrypt($accID, $key ) ?>&flag=<?php echo encrypt('deposit', $key) ?>"><button class="btn btn-dark" ><span class="bi bi-arrow-return-left"></span> Back</button></a>
                    </div>
                  </div>
                </div>
                <form action="process/proc_paydep.php" method="post" class="needs-validation" novalidate>

                  <div class="row g-3">

                    <div class="col-md-6 mt-2">
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>

                    <div class="col-md-6 mt-2">
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>

                    <div class="col-md-12"> 
                      <div class="card" style="border: 1px solid; height: 120px;">
                        <div class="card-body">
                            <div class="row mt-3">  

                              <div class="col-md-9">
                                  <h6>Member</h6>
                                  <h3><b><?php echo $Pangalan; ?></b></h3>
                                  <h6>ID : <?php echo $accID; ?></h6>
                              </div>

                              <div class="col-md-3 text-center">
                                  <h6>Member Deposit</h6>
                                  <h3><b>&#x20B1; <?php echo $depAm; ?></b></h3>
                              </div>
                              
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12" style="margin-top: -30px;">
                      <h5 class="card-title" style="font-size: 20px;"><b><?php echo ($dt == "Capital") ? "Shared Capital" : $dt; ?></b></h5>
                    </div>

                    <input type="hidden" name="memberID" value="<?php echo $memID; ?>">
                    <input type="hidden" name="appBy" value="<?php echo $appBy; ?>">
                    <input type="hidden" name="deposit" value="<?php echo $depType; ?>">

                    <div class="col-md-6" style="margin-top: -5px;">
                        <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                        <div class="input-group has-validation">
                            <input type="text" name="invoice" class="form-control" id="yourUsername" required maxlength="6">
                            <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                        </div>
                    </div>

                    <div class="col-md-6" style="margin-top: -5px;">
                        <label for="cheque" class="form-label" id="upchequed">Cash Voucher Reference <span class="required">*</span></label>
                            <div class="input-group has-validation">
                            <input type="text" name="cheque" class="form-control" id="upcheque" placeholder="Type Check Reference" required maxlength="6">
                            <div class="invalid-feedback">Please enter your cheque reference"</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail3" class="form-label">Amount <span class="required">*</span></label>
                        <input type="text" name="depAm" class="form-control amount" id="" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01">
                    </div>
                    

                    <div class="text-end">
                        <input type="submit" class="btn btn-success" value="Save" tabindex="5">
                    </div>

                  </div>

                </form>
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

<?php require_once 'sidenavs/centered_footer.php'; ?>

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
if(isset($_SESSION['appAm'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Deposit Added Successfully!',
        text: '<?php echo $_SESSION['appAm'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['appAm']); } ?>
//ending

<?php 
if(isset($_SESSION['invAm'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Invalid Amount!',
        text: '<?php echo $_SESSION['invAm'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['invAm']); } ?>

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
</script>

<script>
function toggleRequired() {
    var inputField = document.getElementById('cheque');
    var checkbox = document.getElementById('switch');
    var label = document.getElementById('chequed');
    if (checkbox.checked) {
        inputField.style.display = 'block';
        label.style.display = 'block';
        inputField.setAttribute('required', 'required');
    } else {
        inputField.removeAttribute('required');
        inputField.style.display = 'none';
        label.style.display = 'none';
    }
}

function uptoggleRequired() {
    var inputField = document.getElementById('upcheque');
    var checkbox = document.getElementById('upswitch');
    var label = document.getElementById('upchequed');
    var div = document.getElementById('div');
    if (checkbox.checked) {
        inputField.style.display = 'block';
        label.style.display = 'block';
        div.style.display = 'block';
        inputField.setAttribute('required', 'required');
    } else {
        inputField.removeAttribute('required');
        inputField.style.display = 'none';
        label.style.display = 'none';
        div.style.display = 'none';
    }
}

</script>

</body>
</html>


