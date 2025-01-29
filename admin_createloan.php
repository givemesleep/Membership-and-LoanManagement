<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  //LoanID = Type of Loan | flags = pages | accID = Account ID
  $key="LLAMPCO";
  $loanID = $accID = $flag = $memID = '';
  $lnType = $lnCol = $lnCom = $DepAm = '';
  
  $disPSC = $disTD = $p = $red = '';
  $pscGood = $tdGood = false;
  $PSC = $TD = $maxAm = $minMos = $enLPPI ='';

  if(isset($_GET['flag'])){
    $flag = decrypt($_GET['flag'], $key);

    switch($flag){
      case 'loanType':
        $flag = 'lnType';
      break;
      case 'loanDetails':
        $flag = 'lnDetails';
      break;
      case 'Beneficiary':
        $flag = 'Ben';
      break;
      case 'Preview':
        $flag = 'Prev';
      break;
      default:
        $flag = '';
      break;
    }
  }

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
    $sqlMem = "SELECT CONCAT(p.memSur, ', ', p.memGiven, ' ', p.memMiddle, ' ', p.suffixes) AS Fullname,
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
    
    $AmCheck = "SELECT regSav AS Regular, shareCap AS PSC, timeDep AS TimeDep, 
    speVol AS Vol, speSav AS Sav, funSav AS Fun FROM tbdepinfo WHERE memberID = ?";
    $AmData = array($memID);
    $AmStmt = $conn->prepare($AmCheck);
    $AmStmt->execute($AmData);
    $AmRow = $AmStmt->fetch(PDO::FETCH_ASSOC);

    $PSC = checkDecimal($AmRow['PSC']);
    $TD = checkDecimal($AmRow['TimeDep']);

  }  
  //memID loanID 

  //Check Member Loan Count
  $sqlCounts = "SELECT migsID AS migs, rlCount AS RL, igpCount AS IGP, ApplyDate AS JoinedDate FROM tbperinfo WHERE memberID = ? AND isActive";
  $dataCounts = array($memID);
  $stmtCounts = $conn->prepare($sqlCounts);
  $stmtCounts->execute($dataCounts);
  $resCount = $stmtCounts->rowCount();
  if($resCount > 0){
    $rowCounts = $stmtCounts->fetch(PDO::FETCH_ASSOC);
    $rl = $rowCounts['RL'];
    $igp = $rowCounts['IGP'];
    $migs = $rowCounts['migs'];
    $jd = $rowCounts['JoinedDate'];

  }else{
    $rl = '';
    $igp = '';
    $migs = '';
    $jd = '';
  }

  $sqlDeposit = "SELECT shareCap AS PSC, timeDep AS TD FROM tbdepinfo WHERE memberID = ?";
  $dataDeposit = array($memID);
  $stmtDeposit = $conn->prepare($sqlDeposit);
  $stmtDeposit->execute($dataDeposit);
  $resDeposit = $stmtDeposit->rowCount();
  if($resDeposit > 0){
    $rowDeposit = $stmtDeposit->fetch(PDO::FETCH_ASSOC);
    $PSC = $rowDeposit['PSC'];
    $TD = $rowDeposit['TD'];
  }else{
    $PSC = '';
    $TD = '';
  }

  switch($loanID){
    case 1: //Regular Loan
      if($rl == 1){

        $DepAm = number_format($PSC, "2", ".", ",");
        if($PSC * 2 >= 20000){
          $maxAm = "&#8369; 20,000.00 (2x of PSC)";
        }else{
          $maxAm = "&#8369; ". number_format($PSC * 2 , "2", ".", ",") . " (2x of PSC)";
        }
        $minMos = "3 Months";
        $enLPPI = 1;
      }elseif($rl == 2){

        $DepAm = number_format($PSC, "2", ".", ",");
        if($PSC * 2 >= 30000){
          $maxAm = "&#8369; 30,000.00 (2x of PSC)";
        }else{
          $maxAm = "&#8369; ". number_format($PSC * 2 , "2", ".", ",") . " (2x of PSC)";
        }

        // $maxAm = "&#8369; 30,000.00 (2x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }elseif($rl == 3){
        $DepAm = number_format($PSC, "2", ".", ",");
        if($PSC * 2 >= 50000){
          $maxAm = "&#8369; 50,000.00 (2x of PSC)";
        }else{
          $maxAm = "&#8369; ". number_format($PSC * 2 , "2", ".", ",") . " (2x of PSC)";
        }

        // $maxAm = "&#8369; 50,000.00 (2x of PSC)";
        $minMos = "3";
        $enLPPI = 1;
      }else{
        $maxAm = "is more than &#8369; 50,000.00 (3x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }
    break;
    case 2: //IGP Loan
      if($igp == 1){
        $DepAm = number_format($PSC, "2", ".", ",");
        $maxAm = "&#8369; 150,000.00 (6x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }elseif($igp == 2){
        $maxAm = "&#8369; 200,000.00 (6x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }elseif($igp == 3){
        $maxAm = "&#8369; 300,000.00 (6x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }else{
        $maxAm = "&#8369; 300,000.00 (3x of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }
    break;
    case 3: //PSC Loan
      $maxPSC = $PSC * 0.9;
      $DepAm = number_format($PSC, "2", ".", ",");
      if($migs == '' || $migs == 0){
        $maxAm = "&#8369; ". number_format($maxPSC, "2", ".", ",") ." (90% of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }elseif($migs == 1 || $migs == 2){
        $maxAm = "&#8369; ". number_format($PSC, "2", ".", ",") ." (100% of PSC)";
        $minMos = "3 Months";
        $enLPPI = 1;
      }
    break;
    case 4: 
      $maxTD = $TD;
      $DepAm = number_format($TD, "2", ".", ",");
      $maxAm = "&#8369; ". number_format($maxTD, "2", ".", ",") ." (100% of TD)";
      $minMos = "3 Months";
      $enLPPI = 1;
    break;
    case 5:
      $maxAm = "&#8369; 1,500.00";
      $minMos = "1 Month";
    break;
    case 6:
      $maxAm = "&#8369; 3,000.00 - 5,000.00";
      $minMos = "2 Months";
    break;
    case 7:
      $maxAm = "&#8369; 20,000.00";
      $minMos = "3-6 Months";
    break;
    case 8:
      $maxAm = "&#8369; 50,000.00";
      $minMos = "3-6 Months";
    break;
    case 9:
      if($migs == 0 || $migs == ''){
        $maxAm = "&#8369; 20,000.00";
        $minMos = "6 Months";
        $enLPPI = 1;
      }elseif($migs == 1 || $migs == 2){
        $maxAm = "&#8369; 50,000.00";
        $minMos = "12 Months";
        $enLPPI = 1;
      }
    break;
    case 10:
      $maxAm = "Equivalent to Tuition Fee";
      $minMos = "ELEM & HS 10 Months, COLL 5 Months";
      $enLPPI = 1;
    break;
    case 11:
      $maxPSC = $PSC * 6;
      $DepAm = number_format($PSC, "2", ".", ",");
      $maxAm = "&#8369; ". number_format($maxPSC, "2", ".", ",") ." (6x of PSC)";
      $minMos = "3 Months";
      $enLPPI = 1;
    break;
    case 12:
      $maxAm = "&#8369; 20,000.00";
      $minMos = "12 Months";
      $enLPPI = 1;
    break;
    default:
      $maxAm = '';
      $minMos = '';
      $DepAm = '';
    break;
  }

//Set 30 Dayss
// $sql30 = "SELECT ApplyDate FROM tbperinfo WHERE memberID = ? ";

  if($PSC < 2400.00 || $PSC < 2400){
    $pscGood = true;
    $p = 'Not Eligible';
    $disPSC = 'style=" pointer-events: none;"';
    $red = 'color: red;';
  }else{
    $disPSC = "";
  }

  if($TD < 50000.00 || $TD < 50000){
    $tdGood = true;
    $p = 'Not Eligible';
    $disTD = 'style=" pointer-events: none;"';
    $red = 'color: red;';
  }else{
    $disTD = "";
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
            
            <fieldset class="active" style="height: 500px;">
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
                            WHERE p.memstatID = 1 AND p.isLoan = 0 ORDER BY p.memSur";
                  $stmtbg = $conn->prepare($sqlbg);
                  $stmtbg->execute();
                  $list = '';
                  if($stmtbg->rowCount() > 0){
                      while($rowbg=$stmtbg->fetch()){
                          $list.='
                          <a href="admin_createloan.php?mem='.encrypt($rowbg['ID'], $key).'&flag='.encrypt('loanType', $key).'">
                            <li class="list-group-item " style="font-size: 13px; border: none;" title="Click to view '.$rowbg['Nickname'].' Deposit/Loan.">Name : <b>'.$rowbg['Fullname'].'</b><br>ID : <b>'.$rowbg['ID'].'</b> </li>
                          </a>
                          ';
                      }
                  }else {
                      echo '';
                  }
                  echo $list;
            
            ?>
              
              </ol><!-- End with custom content -->

              <a <?php echo ($flag == 'paydep') ? '' : 'style="display: none;"' ?> href="admin_createdep.php?mem=<?php echo encrypt($accID, $key ) ?>&flag=<?php echo encrypt('deposit', $key) ?>"><button class="btn btn-dark mt-3" style="width: 100%;"><span class="bi bi-arrow-return-left"></span> Back</button></a>  
                

            </fieldset>

            <fieldset <?php //echo ($flag != '') ? 'class="active"' : '' ?> style="height: 500px;">
              <div class="col-md-12 mt-3">
                <a href="admin_createloan.php"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
              </div>
              <div class="row">
                
                <div class="col-md-12 text-center">
                    <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                </div>

                <div class="col-md-6 text-start">
                    <p>Member ID</p>
                </div>

                <div class="col-md-6 text-end">
                    <h6><b><?php echo $accID; ?></b></h6>
                </div>

                <div class="col-md-12 mt-3 text-center">
                    <h6><b><?php echo $Pangalan; ?></b></h6>
                </div>
                
                <div class="col-md-12 text-center">
                    <p>Full Name</p>
                </div>

                    
                </div>
            </fieldset>

          </div>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
              
            <fieldset <?php echo ($flag == '') ? 'class="active"' : '' ?> style="height: 410px;">
              
              <h5 class="card-title" style="font-size: 35px;"><b>Apply Loan</b></h5>
                  
              <div class="col-md-12 text-start">
                <h6>Please search or select a member before continuing browsing. </h6>
              </div>
            
            </fieldset>

            <!-- Choose Loan Type -->
            <fieldset  <?php echo ($flag == 'lnType') ? 'class="active"' : '' ?> >

                <h5 class="card-title" style="font-size: 35px;"><b>Loan Type</b></h5>

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

                  

                  <div class="col-md-3" style="margin-top: -5px;">
                    <a <?php echo $disPSC; ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(1,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Regular Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px; <?php echo ($pscGood == true) ? $red : '' ?>"><?php echo ($pscGood == true) ? $p : '3 Months Minimum' ?></p>
                        </div>
                      </div>
                    </a>

                    <a <?php echo $disPSC; ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(2,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>IGP Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px; <?php echo ($pscGood == true) ? $red : '' ?> "><?php echo ($pscGood == true) ? $p : '3 Months Minimum' ?></p>
                        </div>
                      </div>
                    </a>

                    <a <?php echo $disPSC; ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(3,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>PSC Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px; <?php echo ($pscGood == true) ? $red : '' ?>"><?php echo ($pscGood == true) ? $p : '3 Months Minimum' ?></p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                  <div class="col-md-3" style="margin-top: -5px;">
                    <a <?php echo $disTD; ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(4,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Time Deposit</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px; <?php echo ($tdGood == true) ? $red : '' ?> "><?php echo ($tdGood == true) ? $p : '3 Months Minimum' ?></p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(5,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 20px;"><b>Emergency Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">1 Month Minimum</p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(6,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 18px;"><b>Grocery/Rice Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">2 Months Minimum</p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                  <div class="col-md-3" style="margin-top: -5px;">
                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(7,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Pension Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">3-6 Months Minimum</p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(8,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Salary Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">3-6 Months Minimum</p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(9,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 25px;"><b>Holiday Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">6/12 Months Minimum</p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                  <div class="col-md-3" style="margin-top: -5px;">
                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(10,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 20px;"><b>Education Loan</b> <i title="ELEM/HS 10 | COLL 5 Months Minimum" class="bi bi-info-circle-fill"  style="font-size: 15px;"></i></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">Check the <span class="bi bi-info-circle-fill"></span> icon.</p>
                        </div>
                      </div>
                    </a>

                    <a <?php echo $disPSC; ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(11,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 23px;"><b>Business Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px; <?php echo ($pscGood == true) ? $red : '' ?>"><?php echo ($pscGood == true) ? $p : '3 Months Minimum' ?></p>
                        </div>
                      </div>
                    </a>

                    <a href="admin_createloan.php?mem=<?php echo encrypt($accID, $key); ?>&flag=<?php echo encrypt('loanDetails',$key); ?>&lntype=<?php echo encrypt(12,$key); ?>">
                      <div class="card" style="height: 120px; border: 1px solid;">
                        <div class="card-body">
                          <h5 class="card-title" style="font-size: 21px;"><b>Bayanihan Loan</b></h5>
                          <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                          <p class="card-text" style="font-size: 13px;">12 Months Minimum</p>
                        </div>
                      </div>
                    </a>

                  </div> <!-- col-md-4 -->

                </div>

            </fieldset>

            <!-- Add Your Loan Details  -->
            <fieldset <?php echo ($flag == 'lnDetails') ? 'class="active"' : '' ?> >
              <div class="container">
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="card-title" style="font-size: 35px;"><b>Loan Details</b></h5>
                  </div>
                  <div class="col-md-4 mt-3 text-end">
                  <a <?php echo ($flag == 'lnDetails') ? '' : 'style="display: none;"' ?> href="admin_createloan.php?mem=<?php echo encrypt($accID, $key) ?>&flag=<?php echo encrypt('loanType', $key) ?>"><button class="btn btn-dark"><span class="bi bi-arrow-return-left"></span> Back</button></a>
                  </div>
                </div>
              </div>
              <form action="process/proc_loanpend.php" method="post" class="needs-validation" novalidate>

                <div class="row g-3">

                  <div class="col-md-6">
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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

                  <div class="col-md-12" style="margin-top: -30px;">
                    <h5 class="card-title" style="font-size: 20px;"><b><?php echo $lnType; ?></b></h5>
                  </div>
                  
                  <input type="hidden" name="memID" value="<?php echo $memID; ?>" >
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
                    <label for="yourUsername" class="form-label">Deposit Amount</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control text-end" value=" <?php echo ($DepAm != '') ? '&#x20B1; '.$DepAm : '' ; ?>" readonly disabled>
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-6" style="margin-top: -5px;">
                    <label for="yourUsername" class="form-label">Collateral Fee</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control" value="<?php echo ($lnCol == '' ) ? 'None' : $lnCol ?>"  readonly disabled title="Will deduct based on lower">
                        <div class="invalid-feedback">Please enter beneficiaries name</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="com1" class="form-label" <?php echo ($lnCom == '') ? 'style="display:none;"' : '' ?>>(I) Co Maker <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <select name="com1" id="com1" class="form-select" <?php echo ($lnCom == '') ? 'style="display:none;"' : 'required' ?> onchange="updateDropdowns()">
                          <option value="">Please Select Name</option>
                          <?php 
                            $sqlCom1 = "SELECT memberID AS ID, CONCAT(memSur,', ', memGiven,' ',memMiddle,' ',suffixes) AS Fullname, CONCAT(memGiven,' ', memSur) AS Coms, memNick AS NickName
                            FROM tbperinfo WHERE isActive = 1 AND memstatID = 1";
                            $stmtCom1 = $conn->prepare($sqlCom1);
                            $stmtCom1->execute();
                            if($stmtCom1->rowCount() > 0){
                              while($rowCom1 = $stmtCom1->fetch()){
                                echo '<option value="'.$rowCom1['Coms'].'">'.$rowCom1['Fullname'].'</option>';
                              }
                            }else{
                              echo '<option value="">No Data</option>';
                            }
                          ?>
                        </select>

                        <div class="invalid-feedback">Please enter co-maker name</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="com2" class="form-label" <?php echo ($lnCom == '') ? 'style="display:none;"' : '' ?>>(II) Co Maker <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <select name="com2" id="com2" class="form-select" <?php echo ($lnCom == '') ? 'style="display:none;"' : 'required' ?> onchange="updateDropdowns()">
                          <option value="">Please Select Name</option>
                          <?php 
                            $sqlCom2 = "SELECT memberID AS ID, CONCAT(memSur,', ', memGiven,' ',memMiddle,' ',suffixes) AS Fullname,  CONCAT(memGiven,' ', memSur) AS Coms FROM tbperinfo WHERE isActive = 1 AND memstatID = 1 ";
                            // $dataCom2 = array($memID);
                            $stmtCom2 = $conn->prepare($sqlCom1);
                            $stmtCom2->execute();
                            if($stmtCom2->rowCount() > 0){
                              while($rowCom2 = $stmtCom2->fetch()){
                                echo '<option value="'.$rowCom2['Coms'].'">'.$rowCom2['Fullname'].'</option>';
                              }
                            }else{
                              echo '<option value="">No Data</option>';
                            }
                          ?>
                        </select>
                        <div class="invalid-feedback">Please enter co-maker name</div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="yourUsername" class="form-label">Loan Amount <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <input type="text" name="lnAm" class="form-control amount text-end" id="loanAm" required oninput="computeVal()">
                        <div class="invalid-feedback">Please enter loan amount</div>
                    </div>
                    <p class="mt-1" style="font-size: 13px"><i>Maximum Loan <?php echo $maxAm; ?> </i></p>
                  </div>

                  <div class="col-md-3">
                    <label for="yourUsername" class="form-label">Loan Term/Month <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <input type="text" name="lnTerm" class="form-control number" id="loanTerm" required> 
                        <div class="invalid-feedback">Please enter loan amount</div>
                    </div>
                    <p class="mt-1" style="font-size: 13px"><i>Minimum <?php echo $minMos; ?> </i></p>
                  </div>

                  <div class="col-md-3" <?php echo ($enLPPI == 1) ? 'style="display: block;"' : 'style="display: none;' ?>>
                    <label for="yourUsername" class="form-label">CISP Reference <span class="required">*</span></label>
                    <div class="input-group has-validation">
                        <input type="text" name="cisp" class="form-control" id="loanTerm" <?php echo ($enLPPI == 1) ? 'required' : '' ?> maxlength="6"> 
                        <div class="invalid-feedback">Please enter CISP Reference</div>
                    </div>
                    <!-- <p class="mt-1" style="font-size: 13px"><i>Minimum <?php //echo $minMos; ?> </i></p> -->
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


