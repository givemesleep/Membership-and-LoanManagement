<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  $key = "LLAMPCO";
  //Flag use to change the fieldset / div's
  $flag = $memID = '';
  $Name = $UniqueID = $Status = '';

  if(isset($_GET['res']) && isset($_GET['mem'])){
    $flag = decrypt($_GET['res'], $key);
    $memID = decrypt($_GET['mem'], $key);

    $sqlMem = "SELECT 
                un.unID AS ID, p.memberID AS memID,
                CONCAT(IF(p.gendID = 1, 'Ms. ', 'Mr. '), p.memSur, ', ', p.memGiven, ' ', p.memMiddle, ' ', p.suffixes) AS Fullname,
                p.memSur AS lname, p.memGiven AS fname, p.memMiddle AS mname, p.suffixes AS suffix
            FROM tbuninfo un
            JOIN tbperinfo p ON un.memberID = p.memberID
            WHERE p.memstatID = 1 AND p.memberID = ?";
    $dataMem = array($memID);
    $stmtMem = $conn->prepare($sqlMem);
    $stmtMem->execute($dataMem);
    $rowMem = $stmtMem->fetch();
    $UniqueID = $rowMem['ID'];
    $Name = $rowMem['Fullname'];

    

    switch($flag){
      case 'deposit':
        $flag = 'deposit';
      break;
      case 'loan':
        $flag = 'loan';
      break;
      case 'dephis':
        $flag = 'dephis';
      default:
      break;

    }

  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Transaction Viewing</title>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>


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
  .card-scrollable {
    display: grid;
    grid-template-columns: 1fr; 
    overflow-y: scroll;
    height: 600px; 
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
  $pages = 'viewpay';  $nav = 'trans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Members Transaction</li>
              <li class="breadcrumb-item active">View Transactions</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">

      <div class="col-lg-3">
        <div class="card" style="height: 500px;">
          <div class="card-body">

            <!-- Currently Best?  -->
            <fieldset class="active">
              <h5 class="card-title" style="font-size: 30px;"><b>Search Members</b></h5>

              <div class="search-bar mb-3">
                  <input type="text" id="searchInput" class="form-control" placeholder="Search Members" style="margin-top: -15px">
              </div>
              <!-- List group with custom content -->
              <ol class="list-group list-group-numbered mb-3" id="itemList">

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
                          <a href="admin_viewtrans.php?res='.encrypt('deposit', $key).'&mem='.encrypt($rowbg['memID'], $key).'">
                            <li class="list-group-item" style="font-size: 13px; border: none;" title="Click to view '.$rowbg['Nickname'].' Deposit/Loan.">Name : <b>'.$rowbg['Fullname'].'</b><br>ID : <b>'.$rowbg['ID'].'</b> </li>
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
          
          </div>
        </div>  
      </div>
      
      <div class="col-lg-9">
          <div class="card">
            <div class="card-body">
              
              <fieldset <?php echo ($flag != '') ? '' : 'class="active"' ?> style="height: 410px;">
                <h5 class="card-title" style="font-size: 35px;"><b>Transaction Viewing</b></h5>
                  <div class="row">
                      <div class="col-md-12 text-start">
                        <h6>Please search or select a member before continuing browsing. </h6>
                      </div>
                  </div>
              </fieldset>

              <fieldset <?php echo ($flag == 'deposit') ? 'class="active"' : '' ?>>
                
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="card-title" style="font-size: 35px;"><b>Deposit Viewing </b></h5>
                  </div>
                  <div class="col-md-4 mt-3 text-end">
                    <a href="admin_viewtrans.php?res=<?php echo encrypt('dephis', $key) ?>&mem=<?php echo encrypt($memID, $key)?>"><button class="btn btn-dark" title="View Transaction"><span class="bi bi-receipt-cutoff text-light"></span></button></a>
                  </div>
                </div>
                
                <div class="row">

                <hr style="margin-top: -10px">
                  <div class="col-md-12">
                    <div class="card" style="height: 120px; border: 1px solid;">
                      <div class="card-body">
                        <div class="row mt-3">

                          <div class="col-md-9">
                            <h6>Member Name</h6>
                            <h3><b><?php echo $Name; ?></b></h3>
                            <h6>Member ID : <?php echo $UniqueID; ?></h6>
                          </div>

                          <div class="col-md-3 text-center">
                            <h6>Member Status</h6>
                            <h3><b><span class="badge bg-success">Approved  </span></b></h3>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <?php 
                    $sqlDep = "SELECT regSav AS Regular, shareCap AS PSC, timeDep AS TD, speVol AS speVol, speSav AS speSav, funSav AS funSav 
                              FROM tbdepinfo WHERE memberID = ?";
                    $dataDep = array($memID);
                    $stmtDep = $conn->prepare($sqlDep);
                    $stmtDep->execute($dataDep);
                    $rowDep = $stmtDep->fetch();
                    $reg = $rowDep['Regular']; $psc = $rowDep['PSC']; $td = $rowDep['TD'];
                    $sv = $rowDep['speVol']; $ss = $rowDep['speSav']; $fs = $rowDep['funSav'];

                    $Deposit = array($reg, $psc, $td, $sv, $ss, $fs);
                    $i = 0;
                    $sqlDepType = "SELECT depDesc FROM tbdepType";
                    $stmtDepType = $conn->prepare($sqlDepType);
                    $stmtDepType->execute();
                    $list = '';

                  while($i < count($Deposit)){
                    while($res=$stmtDepType->fetch()){
                      // $btn='<a href=""><button class="btn btn-dark"><i class="ri-eye-fill"></i></button></a>';
                      $list.='

                        <div class="col-md-4">
                          <div class="card" style="height: 130px; border: 1px solid;">
                            <div class="card-body">
                              <div class="row mt-3">

                                <div class="col-md-8 mt-2">
                                  <h6>Deposit Type</h6>
                                </div>
                                
                                <div class="col-md-12">
                                  <h4><b>'.$res['depDesc'].'</b></h4>
                                </div>

                                <div class="col-md-5">
                                  <h6><b>Amount :</b></h6>
                                </div>

                                <div class="col-md-7 text-end">
                                  <h6><b>&#8369; '.number_format($Deposit[$i], 2).'</b></h6>
                                </div>
                               
                              </div>
                            </div>
                          </div>
                        </div>
                      ';
                      $i++;
                    }
                  }
                    
                    echo $list;


                          /*
                          <div class="col-md-5">
                                  <h6><b>Amount : </h6>
                                </div>
                                
                                <div class="col-md-7 text-end">
                                  <h6><b>&#8369; '.number_format($Deposit[$i], 2).'</b></h6>
                                </div>
                          
                          */
                        ?>
                              
                        
                </div>
              </fieldset>

              <fieldset <?php echo ($flag == 'dephis') ? 'class="active"' : '' ?>>
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="card-title" style="font-size: 35px;"><b>Deposit History </b></h5>
                  </div>
                  <div class="col-md-4 mt-3 text-end">
                    <a href="admin_viewtrans.php?res=<?php echo encrypt('deposit', $key) ?>&mem=<?php echo encrypt($memID, $key)?>"><button class="btn btn-dark" title="Return"><span class="bi bi-arrow-return-right text-light"></span></button></a>
                  </div>
                </div>

                <div class="row">

                  <hr style="margin-top: -10px">
                  <div class="col-md-12">
                    <div class="card" style="height: 120px; border: 1px solid;">
                      <div class="card-body">
                        <div class="row mt-3">

                          <div class="col-md-9">
                            <h6>Member Name</h6>
                            <h3><b><?php echo $Name; ?></b></h3>
                            <h6>Member ID : <?php echo $UniqueID; ?></h6>
                          </div>

                          <div class="col-md-3 text-center">
                            <h6>  </h6>
                            <h3><b><span class="badge bg-success">Approved  </span></b></h3>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 text-start">
                    <select class="form-select" id="contentDropdown" onchange="changeContent()">
                      <option value="">Select an option</option>
                      <?php 
                        $sqlDep = "SELECT deptypeID, depDesc FROM tbdeptype";
                        $stmtDep = $conn->prepare($sqlDep);
                        $stmtDep->execute();
                        $list = '';
                        while($res=$stmtDep->fetch()){
                          $list.='
                            <option value="'.$res['deptypeID'].'">'.$res['depDesc'].'</option>
                          ';
                        }
                        echo $list;
                      
                      ?>
                    </select>
                  </div>

                  

                  <div class="col-md-9 text-end">
                    <div id="contentDiv"><b>Please select an option</b></div>
                  </div>

                  <div class="col-md-12 mt-3" id="rs" style="display: none;">
                    <table class="table table-bordered">
                        <thead style="max-width: 100%">
                          <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Invoice</th>
                            <th style="width: 10%;">Cash V.</th>
                            <th style="width: 10%;">Cheque</th>
                            <th style="width: 30%;" class="text-end">Amount</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 1 ORDER BY depDate DESC LIMIT 10";
                            $dataDepHis = array($memID);
                            $stmtDepHis = $conn->prepare($DepHis);
                            $stmtDepHis->execute($dataDepHis);
                            $i = 1;
                            $table = '';
                            while($rowDepHis = $stmtDepHis->fetch()){
                              $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                              $table.='
                                <tr>
                                  <td>'.$i.'</td>
                                  <td>'.$rowDepHis['Invoice'].'</td>
                                  <td>'.$rowDepHis['CashV'].'</td>
                                  <td>'.$rowDepHis['Cheq'].'</td>
                                  <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                  <td>'.readableDate($rowDepHis['Dates']).'</td>
                                  <td>'.$formatTime.'</td>
                                </tr>
                              ';
                              $i++;
                            }
                            echo $table;
                          ?>
                        </tbody>
                    </table>
                  </div>

                  <div class="col-md-12 mt-3" id="psc" style="display: none;">
                    <table class="table table-bordered">
                      <thead style="max-width: 100%">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 10%;">Invoice</th>
                          <th style="width: 10%;">Cash V.</th>
                          <th style="width: 10%;">Cheque</th>
                          <th style="width: 30%;" class="text-end">Amount</th>
                          <th style="width: 15%;">Date</th>
                          <th style="width: 15%;">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 2 ORDER BY depDate DESC LIMIT 10";
                          $dataDepHis = array($memID);
                          $stmtDepHis = $conn->prepare($DepHis);
                          $stmtDepHis->execute($dataDepHis);
                          $i = 1;
                          $table = '';
                          while($rowDepHis = $stmtDepHis->fetch()){
                            $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                            $table.='
                              <tr>
                                <td>'.$i.'</td>
                                <td>'.$rowDepHis['Invoice'].'</td>
                                <td>'.$rowDepHis['CashV'].'</td>
                                <td>'.$rowDepHis['Cheq'].'</td>
                                <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                <td>'.readableDate($rowDepHis['Dates']).'</td>
                                <td>'.$formatTime.'</td>
                              </tr>
                            ';
                            $i++;
                          }
                          echo $table;
                        ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-md-12 mt-3" id="td" style="display: none;">
                  <table class="table table-bordered">
                      <thead style="max-width: 100%">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 10%;">Invoice</th>
                          <th style="width: 10%;">Cash V.</th>
                          <th style="width: 10%;">Cheque</th>
                          <th style="width: 30%;" class="text-end">Amount</th>
                          <th style="width: 15%;">Date</th>
                          <th style="width: 15%;">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 3 ORDER BY depDate DESC LIMIT 10";
                          $dataDepHis = array($memID);
                          $stmtDepHis = $conn->prepare($DepHis);
                          $stmtDepHis->execute($dataDepHis);
                          $i = 1;
                          $table = '';
                          while($rowDepHis = $stmtDepHis->fetch()){
                            $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                            $table.='
                              <tr>
                                <td>'.$i.'</td>
                                <td>'.$rowDepHis['Invoice'].'</td>
                                <td>'.$rowDepHis['CashV'].'</td>
                                <td>'.$rowDepHis['Cheq'].'</td>
                                <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                <td>'.readableDate($rowDepHis['Dates']).'</td>
                                <td>'.$formatTime.'</td>
                              </tr>
                            ';
                            $i++;
                          }
                          echo $table;
                        ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-md-12 mt-3" id="sv" style="display: none;">
                    <table class="table table-bordered">
                      <thead style="max-width: 100%">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 10%;">Invoice</th>
                          <th style="width: 10%;">Cash V.</th>
                          <th style="width: 10%;">Cheque</th>
                          <th style="width: 30%;" class="text-end">Amount</th>
                          <th style="width: 15%;">Date</th>
                          <th style="width: 15%;">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 4 ORDER BY depDate DESC LIMIT 10";
                          $dataDepHis = array($memID);
                          $stmtDepHis = $conn->prepare($DepHis);
                          $stmtDepHis->execute($dataDepHis);
                          $i = 1;
                          $table = '';
                          while($rowDepHis = $stmtDepHis->fetch()){
                            $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                            $table.='
                              <tr>
                                <td>'.$i.'</td>
                                <td>'.$rowDepHis['Invoice'].'</td>
                                <td>'.$rowDepHis['CashV'].'</td>
                                <td>'.$rowDepHis['Cheq'].'</td>
                                <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                <td>'.readableDate($rowDepHis['Dates']).'</td>
                                <td>'.$formatTime.'</td>
                              </tr>
                            ';
                            $i++;
                          }
                          echo $table;
                        ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-md-12 mt-3" id="ss" style="display: none;">
                    <table class="table table-bordered">
                      <thead style="max-width: 100%">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 10%;">Invoice</th>
                          <th style="width: 10%;">Cash V.</th>
                          <th style="width: 10%;">Cheque</th>
                          <th style="width: 30%;" class="text-end">Amount</th>
                          <th style="width: 15%;">Date</th>
                          <th style="width: 15%;">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 5 ORDER BY depDate DESC LIMIT 10";
                          $dataDepHis = array($memID);
                          $stmtDepHis = $conn->prepare($DepHis);
                          $stmtDepHis->execute($dataDepHis);
                          $i = 1;
                          $table = '';
                          while($rowDepHis = $stmtDepHis->fetch()){
                            $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                            $table.='
                              <tr>
                                <td>'.$i.'</td>
                                <td>'.$rowDepHis['Invoice'].'</td>
                                <td>'.$rowDepHis['CashV'].'</td>
                                <td>'.$rowDepHis['Cheq'].'</td>
                                <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                <td>'.readableDate($rowDepHis['Dates']).'</td>
                                <td>'.$formatTime.'</td>
                              </tr>
                            ';
                            $i++;
                          }
                          echo $table;
                        ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="col-md-12 mt-3" id="fs" style="display: none;">
                    <table class="table table-bordered">
                      <thead style="max-width: 100%">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 10%;">Invoice</th>
                          <th style="width: 10%;">Cash V.</th>
                          <th style="width: 10%;">Cheque</th>
                          <th style="width: 30%;" class="text-end">Amount</th>
                          <th style="width: 15%;">Date</th>
                          <th style="width: 15%;">Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $DepHis = "SELECT InvoiceNo AS Invoice, cvRef AS CashV, cheqRef AS Cheq, amount AS depAm, depDate AS Dates, depTime AS Times FROM tbdephisinfo WHERE memberID = ? AND deptypeID = 6 ORDER BY depDate DESC LIMIT 10";
                          $dataDepHis = array($memID);
                          $stmtDepHis = $conn->prepare($DepHis);
                          $stmtDepHis->execute($dataDepHis);
                          $i = 1;
                          $table = '';
                          while($rowDepHis = $stmtDepHis->fetch()){
                            $formatTime = date("h:i A", strtotime($rowDepHis['Times']));
                            $table.='
                              <tr>
                                <td>'.$i.'</td>
                                <td>'.$rowDepHis['Invoice'].'</td>
                                <td>'.$rowDepHis['CashV'].'</td>
                                <td>'.$rowDepHis['Cheq'].'</td>
                                <td class="text-end">&#8369; '.number_format($rowDepHis['depAm'], 2).'</td>
                                <td>'.readableDate($rowDepHis['Dates']).'</td>
                                <td>'.$formatTime.'</td>
                              </tr>
                            ';
                            $i++;
                          }
                          echo $table;
                        ?>
                      </tbody>
                    </table>
                  </div>

                </div>
              </fieldset>

              <fieldset <?php echo ($flag == 'loan') ? 'class="active"' : '' ?>>
                
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="card-title" style="font-size: 35px;"><b>Loan Transaction <a href="admin_viewtrans.php?res=<?php echo encrypt('deposit', $key) ?>&mem=<?php echo encrypt($memID, $key) ?>"><span class="badge text-bg-primary align-middle"><i class="bi bi-arrow-left-right" style="font-size: 15px;" title="Change to Loan/Deposit"></i> View Deposit</span></a></b></h5>                
                  </div>
                  <div class="col-md-4 mt-3 text-end">
                    <a href=""><button class="btn btn-dark" title="View Transaction"><span class="bi bi-receipt-cutoff text-light"></span></button></a>
                  </div>
                </div>
                <div class="row g-3">
                  <hr style="margin-top: -2px">

                  <div class="col-md-12">
                    <div class="card" style="height: 120px; border: 1px solid;">
                      <div class="card-body">
                        <div class="row mt-3">

                          <div class="col-md-10">
                            <h6>Member Name</h6>
                            <h3><b><?php echo $Name; ?></b></h3>
                            <h6>Member ID : <?php echo $UniqueID; ?></h6>
                          </div>

                          <div class="col-md-2 text-center">
                            <h6>Member Status</h6>
                            <h3><b><span class="badge bg-success">Approved</span></b></h3>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <h5 class="card-title" style="margin-top: -30px;"><b>On-Going Loan</b></h5>
                    <?php 
                    // $table = '';
                    // $span = '';
                    // $tab = '';
                    // $sqlLoan = "SELECT 
                    //             lnt.loanType AS LoanType, lns.lnstat AS lnStats, lni.lnstatID AS lnID,
                    //             lni.lnTotMos AS OutStanding, lni.lnTotPay AS PaidAmount, lni.lnMosInt AS MosInt, lni.lnunID AS lnunID
                    //           FROM tbloaninfo lni
                    //           JOIN tblntypes lnt ON lni.loanID = lnt.loanID
                    //           JOIN tblnstat lns ON lni.lnstatID = lns.lnstatID
                    //           WHERE isActivate = 1 AND remarks = 0 AND memberID = ?";
                    // $dataLn = array($memID);
                    // $stmtLn = $conn->prepare($sqlLoan);
                    // $stmtLn->execute($dataLn);
                    // $resLn = $stmtLn->rowCount();
                    // if($resLn > 0){
                    //   $rowLn = $stmtLn->fetch();
                    //   $type = $rowLn['LoanType'];
                    //   $Out = number_format($rowLn['OutStanding'], "2", ".", ",");
                    //   $Paid = number_format($rowLn['PaidAmount'], "2", ".", ",");
                    //   $lnstats = $rowLn['lnStats'];
                    //   $lnID = $rowLn['lnID'];

                    //   switch($lnID){
                    //     case 1:
                    //       $span = '<span class="badge text-bg-primary align-middle">'.$lnstats.'</span>';
                    //     break;
                    //   }
                      
                    //   $table .=' 
                    //           <div class="col-md-12" style="margin-top: -10px;">
                    //             <div class="card" style="height: 50px; border: 1px solid;">
                    //               <div class="card-body">
                    //                 <div class="row mt-3">

                    //                   <div class="col-md-4">
                    //                     <h6><b>'.$type.'</b> '.$span.'</h6>
                    //                   </div>

                    //                   <div class="col-md-4">
                    //                     <h6>Balance &#x20B1; <span style="color: red;">'.$Out.'</span></h6>
                    //                   </div>

                    //                   <div class="col-md-4">
                    //                     <h6>Repaid &#x20B1; <span style="color: green;">'.$Paid.'</span></h6>
                    //                   </div>

                    //                 </div>
                    //               </div>
                    //             </div>
                    //           </div>
                    //         ';
                    //     $tab .= '

                        
                        
                        
                    //     ';
                      
                    // }else{
                    //   $type = $Out = $Paid = '';
                    // }


                    

                    // echo $table;
                    
                    
                    
                    ?>

                  <h5 class="card-title" style="margin-top: -30px;"><b>Finished Loan</b></h5>
                    <?php 
                    $table = '';
                    $span = '';
                    $sqlLoan = "SELECT 
                                lnt.loanType AS LoanType, lns.lnstat AS lnStats, lni.lnstatID AS lnID,
                                lni.lnTotMos AS OutStanding, lni.lnTotPay AS PaidAmount
                              FROM tbloaninfo lni
                              JOIN tblntypes lnt ON lni.loanID = lnt.loanID
                              JOIN tblnstat lns ON lni.lnstatID = lns.lnstatID
                              WHERE isActivate = 1 AND remarks = 0 AND memberID = ?";
                    $dataLn = array($memID);
                    $stmtLn = $conn->prepare($sqlLoan);
                    $stmtLn->execute($dataLn);
                    $resLn = $stmtLn->rowCount();
                    if($resLn > 0){
                      $rowLn = $stmtLn->fetch();
                      $type = $rowLn['LoanType'];
                      $Out = number_format($rowLn['OutStanding'], "2", ".", ",");
                      $Paid = number_format($rowLn['PaidAmount'], "2", ".", ",");
                      $lnstats = $rowLn['lnStats'];
                      $lnID = $rowLn['lnID'];

                      switch($lnID){
                        case 1:
                          $span = '<span class="badge text-bg-primary align-middle">'.$lnstats.'</span>';
                        break;
                      }
                      
                      $table .=' 
                              <div class="col-md-12" style="margin-top: -10px;">
                                <div class="card" style="height: 50px; border: 1px solid;">
                                  <div class="card-body">
                                    <div class="row mt-3">

                                      <div class="col-md-4">
                                        <h6><b>'.$type.'</b> '.$span.'</h6>
                                      </div>

                                      <div class="col-md-4">
                                        <h6>Balance &#x20B1; <span style="color: red;">'.$Out.'</span></h6>
                                      </div>

                                      <div class="col-md-4">
                                        <h6>Repaid &#x20B1; <span style="color: green;">'.$Paid.'</span></h6>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>
                            ';
                    }else{
                      $type = $Out = $Paid = '';
                    }


                    

                    echo $table;
                    
                    
                    
                    ?>

                  <h5 class="card-title" style="margin-top: -30px;"><b>Rejected Loan</b></h5>
                    <?php 
                    $table = '';
                    $span = '';
                    $sqlLoan = "SELECT 
                                lnt.loanType AS LoanType, lns.lnstat AS lnStats, lni.lnstatID AS lnID,
                                lni.lnTotMos AS OutStanding, lni.lnTotPay AS PaidAmount
                              FROM tbloaninfo lni
                              JOIN tblntypes lnt ON lni.loanID = lnt.loanID
                              JOIN tblnstat lns ON lni.lnstatID = lns.lnstatID
                              WHERE isActivate = 1 AND remarks = 0 AND memberID = ?";
                    $dataLn = array($memID);
                    $stmtLn = $conn->prepare($sqlLoan);
                    $stmtLn->execute($dataLn);
                    $resLn = $stmtLn->rowCount();
                    if($resLn > 0){
                      $rowLn = $stmtLn->fetch();
                      $type = $rowLn['LoanType'];
                      $Out = number_format($rowLn['OutStanding'], "2", ".", ",");
                      $Paid = number_format($rowLn['PaidAmount'], "2", ".", ",");
                      $lnstats = $rowLn['lnStats'];
                      $lnID = $rowLn['lnID'];

                      switch($lnID){
                        case 1:
                          $span = '<span class="badge text-bg-primary align-middle">'.$lnstats.'</span>';
                        break;
                      }
                      
                      $table .=' 
                              <div class="col-md-12" style="margin-top: -10px;">
                                <div class="card" style="height: 50px; border: 1px solid;">
                                  <div class="card-body">
                                    <div class="row mt-3">

                                      <div class="col-md-4">
                                        <h6><b>'.$type.'</b> '.$span.'</h6>
                                      </div>

                                      <div class="col-md-4">
                                        <h6>Balance &#x20B1; <span style="color: red;">'.$Out.'</span></h6>
                                      </div>

                                      <div class="col-md-4">
                                        <h6>Repaid &#x20B1; <span style="color: green;">'.$Paid.'</span></h6>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>
                            ';
                    }else{
                      $type = $Out = $Paid = '';
                    }


                    

                    echo $table;
                    
                    
                    
                    ?>
   
                </div>
              </fieldset>

                <div class="col-md-12 mt-3 mb-3 text-center">
                  <hr>
                    <h6><?php echo date('F j, Y');?> - <span id="clocking"></span></h6>
                </div>
            </div>
          </div>
      </div>  
    </div>
  </section>    
</main>

<?php
    require_once 'sidenavs/footer.php';
?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

<script src="jqueryto/jquerymoto.js"></script>
<script src="jqueryto/poppermoto.js"></script>
<script src="jqueryto/bootstrapmoto.js"></script>
<script src="jqueryto/sweetalertmoto.js"></script>

<script src="jqueryto/jquery.formwizard.js"></script>
<script src="jqueryto/jquery.min.js"></script>
<script src="jqueryto/jquery.validate.min.js"></script>
<script src="jqueryto/bootstrap.min.css"></script>

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

</body>
</html>

<script>
function changeContent() {
    var dropdown = document.getElementById("contentDropdown");
    var selectedValue = dropdown.options[dropdown.selectedIndex].value;
    var contentDiv = document.getElementById("contentDiv");

    // document.getElementById("form2").style.display = "block";

    if (selectedValue === "1") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("rs").style.display = "block";
        document.getElementById("psc").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("ss").style.display = "none";
        document.getElementById("sf").style.display = "none";
    } else if (selectedValue === "2") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("psc").style.display = "block";
        document.getElementById("rs").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("ss").style.display = "none";
        document.getElementById("sf").style.display = "none";
    } else if (selectedValue === "3") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("td").style.display = "block";
        document.getElementById("rs").style.display = "none";
        document.getElementById("psc").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("ss").style.display = "none";
        document.getElementById("sf").style.display = "none";
    } else if (selectedValue === "4") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("sv").style.display = "block";
        document.getElementById("rs").style.display = "none";
        document.getElementById("psc").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("ss").style.display = "none";
        document.getElementById("sf").style.display = "none";
    } else if (selectedValue === "5") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("ss").style.display = "block";
        document.getElementById("rs").style.display = "none";
        document.getElementById("psc").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("sf").style.display = "none";
    } else if (selectedValue === "6") {
        contentDiv.innerHTML = "<b>Total : </b>";
        document.getElementById("sf").style.display = "block";
        document.getElementById("rs").style.display = "none";
        document.getElementById("psc").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("ss").style.display = "none";
    } else {
        contentDiv.innerHTML = "Please select an option";
        document.getElementById("rs").style.display = "none";
        document.getElementById("psc").style.display = "none";
        document.getElementById("td").style.display = "none";
        document.getElementById("sv").style.display = "none";
        document.getElementById("ss").style.display = "none";
        document.getElementById("sf").style.display = "none";

    }
}
</script>

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
  	
  	
   	$("#clocking").html(currentTimeString);	  	
 }
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

<!--  -->