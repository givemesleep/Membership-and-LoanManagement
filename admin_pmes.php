<?php
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';
  
//Empty Variables
$memberID = ''; $icons = '';
$key = "LLAMPCO"; $flags='';
$appBy = $CurrUser;
// $PMESdecrypt = $flagdecrypt = '';
$fullname = $memstatus = $class = '';
$prevDay = $remBal = '';
if(isset($_GET['appmem'])){
    $memberID = decrypt($_GET['appmem'], $key);

    $sqlname = "SELECT 
                    CONCAT(IF(p.gendID = 1, 'Ms. ', 'Mr. '), p.memGiven, ' ' ,p.memSur ) AS Fullnames,
                    s.memstats AS Remarks, p.ApplyDate AS DateApply
                FROM tbperinfo p
                JOIN tbmemstats s ON p.memstatID = s.memstatID  
                WHERE memberID=?";
    $dataname = array($memberID);
    $stmtname = $conn->prepare($sqlname);
    $stmtname->execute($dataname);
    $rowname = $stmtname->fetch();
    $fullname = $rowname['Fullnames'];
    $memstatus = $rowname['Remarks'];
    $applyDate = $rowname['DateApply'];
    // $dateFormated = date('F d, Y', strtotime($applyDate));

    $today = new DateTime();
    $today = $today->format('Y-m-d');
    $dateFormated = date('F d, Y', strtotime($today));

    switch($memstatus){
        case 'Pending':
            $class = 'class="active"';
            $flags = 1;
        break;
        case 'On-going':
            $class = 'class="active"';
            $flags = 4;

            //Fetch Previous Day
            $sqlDay = "SELECT depDate AS PrevDay FROM tbdephisinfo WHERE memberID = ?";
            $dataDay = array($memberID);
            $stmtDay = $conn->prepare($sqlDay);
            $stmtDay->execute($dataDay);
            $rowDay = $stmtDay->fetch();
            $prevDay = date('F d, Y', strtotime($rowDay['PrevDay']));
            
            //Fetch Remaining Balance
            $sqlBal = "SELECT regSav FROM tbdepinfo WHERE memberID=?";
            $dataBal = array($memberID);
            $stmtBal = $conn->prepare($sqlBal);
            $stmtBal->execute($dataBal);
            $rowBal = $stmtBal->fetch();
            $remBal = 2400.00 - $rowBal['regSav'];
        break;
    }
}

if(isset($_GET['flags'])){
    $flags = decrypt($_GET['flags'], $key);
}

switch($flags){
case 1:
    $icons .= '      
    <div class="col-md-12 mt-5">
        <div class="progress" style="height: 1px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="col-md-12 mb-3 text-center">
        <i class="bi bi-person-fill text-dark icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-2-front-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-fill text-secondary icons"></i>
    </div>
    ';
break;

case 2:
    $icons .= '      
    <div class="col-md-12 mt-5">
        <div class="progress" style="height: 1px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="col-md-12 mb-3 text-center">
        <i class="bi bi-person-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-2-front-fill text-dark icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-fill text-secondary icons"></i>
    </div>
    ';
break;

case 3:
    $icons .= '      
    <div class="col-md-12 mt-5">
        <div class="progress" style="height: 1px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="col-md-12 mb-3 text-center">
        <i class="bi bi-person-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-2-front-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-fill text-dark icons"></i>
    </div>
    ';
break;

case 4:
    $icons .= '      

    ';
break;

default:
    $icons .= '      
    <div class="col-md-12 mt-5">
        <div class="progress" style="height: 1px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="col-md-12 mb-3 text-center">
        <i class="bi bi-person-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-2-front-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-wallet-fill text-secondary icons"></i> &nbsp; <i class="bi bi-dash-lg text-secondary icons"></i>
        &nbsp; <i class="bi bi-credit-card-fill text-secondary icons"></i>
    </div>
    ';
break;

}
  
?>
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
    .icons{
      font-size: 1.5rem;
    }
  </style>

<?php
  require_once 'sidenavs/headers.php';
  $pages = "pending"; $nav = "membership"; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Membership</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
                <li class="breadcrumb-item">Membership Accounts</li>
                <li class="breadcrumb-item active">PMES Training</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            
                            <div class="col-md-12 mt-3">
                                <a href="admin_pendings.php"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
                            </div>

                            <div class="col-md-12 mt-3 text-center">
                                <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                            </div>

                            <div class="col-md-12 mt-3 text-center">
                                <h6><b><?php echo $fullname; ?></b></h6>
                            </div>
                            
                            <div class="col-md-12 text-center">
                                <p>Full Name</p>
                            </div>

                            <div class="col-md-12 mt-3 text-center">
                                <h4><b><span <?php echo ($memstatus != 'Pending') ? 'class="badge bg-info"' : 'class="badge bg-warning"' ?>><?php  echo $memstatus; ?></span></b></h4>
                            </div>

                            <div class="col-md-12 text-center">
                                <p>Status</p>
                            </div>
                        
                        </div>
                    
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                    
                    <fieldset <?php echo ($memstatus == 'Pending') ? $class : '' ?>>

                    <fieldset <?php echo ($flags == 1) ? 'class="active"' : '' ?>>
                        <div class="col-md-12">
                            <h5 class="card-title" style="font-size: 35px;"><b>Member Assessment</b></h5>
                        </div>
                        <form action="process/proc_paypmes.php?paypmes=<?php echo encrypt(1, $key); ?>" method="post" class=" needs-validation" novalidate>
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            
                                <input type="hidden" name="memberID"  value="<?php echo $memberID; ?>">

                                <div class="col-md-6">
                                    <label for="fname" class="form-label">Name</label>
                                    <input type="text" id="fnmae" class="form-control" value="<?php echo $fullname; ?>" disabled readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="fname" class="form-label">Apply Date</label>
                                    <input type="text" id="fnmae" class="form-control text-end" value="<?php echo $dateFormated; ?>" disabled readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom04" class="form-label">Trained By <span class="required">*</span></label>
                                        <select class="form-select" id="validationCustom04" name="conducts" required tabindex="1">
                                            <option selected disabled value="">Select Accompany</option>
                                            <?php 
                                                $sqlCon="SELECT * FROM tbconducts";
                                                $stmtCon=$conn->prepare($sqlCon);
                                                $stmtCon->execute();
                                                while($rows=$stmtCon->fetch()){
                                                echo '<option value="'.$rows['conName'].'">'.$rows['conName'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    <div class="invalid-feedback">Please select person name.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="referral" class="form-label">Referred By</label>
                                        <select class="form-select" id="referral" name="refer" tabindex="2">
                                            <option selected disabled value="">Select Referral</option>
                                            <?php 
                                                $sqlName = "SELECT memberID, CONCAT(IF(gendID = 1, 'Mrs. ', 'Mr. '), memSur, ' ', memGiven, ' ', memMiddle, ' ', suffixes) AS Fullname 
                                                        FROM tbperinfo WHERE memstatID = 1";
                                                $stmtName = $conn->prepare($sqlName);
                                                $stmtName->execute();
                                                while($rowName = $stmtName->fetch()){
                                                echo '<option value="'.$rowName['Fullname'].'">'.$rowName['Fullname'].'</option>';
                                                }
                                            
                                            ?>
                                        </select>
                                    <div class="invalid-feedback">Please select person name.</div>
                                </div>

                                <div class="text-end mt-5">
                                <input type="submit" name="next" class="btn btn-primary" value="Next &raquo;" tabindex="3">
                                </div>
                                
                            </div>
                        </form>
                    </fieldset>
                    
                    <!-- end of form info  -->

                    <fieldset <?php echo ($flags == 2) ? 'class="active"' : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Identification Information</b></h5>
                        <form action="process/proc_paypmes.php?paypmes=<?php echo encrypt(2, $key); ?>" method="post" class=" needs-validation" novalidate>
                        
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <input type="hidden" name="memberID"  value="<?php echo $memberID; ?>">

                                <div class="col-md-6">
                                <label for="floatingsss" class="form-label">SSS No. <span class="required">*</span></label>
                                <input type="text" class="form-control number SSS" name="sss" id="SSS" required placeholder="12-XXXXXXX-X" maxlength="12" tabindex="1">
                                </div>

                                <div class="col-md-6">
                                <label for="floatingtax" class="form-label">Tax Identification No. <span class="required">*</span></label>
                                <input type="text" class="form-control number TIN" name="tin" id="TIN" required placeholder="123-XXX-XXX-XXX" maxlength="14" tabindex="2">
                                </div>

                                <div class="col-md-6">
                                <label for="otherId" class="form-label" >Other ID type </label>
                                    <select class="form-select" name="cboID" id="otherId" aria-label="State" tabindex="3">
                                    <option selected value="<?php //echo ($othID != '') ? $othID : '' ?>"><?php //echo ($govID != '') ? $govID : 'Select Other ID' ?>Select Other ID</option>
                                        <?php
                                            $sql = "SELECT * FROM tbids";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['idTypesID'].'">'.$row['typeDesc'].'</option>';
                                            }      
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                <label for="floatingotherno" class="form-label">Other ID No. <span class="required" id="IDLabel" style="display: none;">*</span></label>
                                <input type="text" class="form-control" name="othID" maxlength="19" id="otherIds" tabindex="4">
                                </div>

                                <div class="text-end mt-4">
                                <input type="submit" name="next" class="btn btn-primary" value="Next &raquo;" tabindex="5">
                                </div>

                            </div>
                        </form>
                    </fieldset>
                    
                    <!-- end of form IDs  -->

                    <fieldset  <?php echo ($flags == 3) ? 'class="active"' : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Initial Deposit</b></h5>
                        <form action="process/proc_paypmes.php?paypmes=<?php echo encrypt(3, $key); ?>" method="post" class=" needs-validation" novalidate>
                        
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                
                            <input type="hidden" name="memberID" value="<?php echo $memberID; ?>">
                            <input type="hidden" name="appBy" value="<?php echo $appBy; ?>">

                            <div class="col-md-6">
                            <label for="yourUsername" class="form-label">Registration Fee</label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="regAm" class="form-control" disabled placeholder="₱ 150.00" style="text-align: right;">
                                <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                            </div>
                            </div>

                            <div class="col-md-6">
                            <label for="yourUsername" class="form-label">Death Care</label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="deathAm" class="form-control" disabled placeholder="₱ 500.00" style="text-align: right;">
                                <!-- <div class="invalid-feedback">Please enter your username.</div> -->
                            </div>
                            </div>

                            <div class="col-md-6">
                            <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="invRef" class="form-control" id="yourUsername" required maxlength="6">
                                <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <label for="cheque" class="form-label" id="chequed">Cash Voucher Reference <span class="required">*</span></label>
                                <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="cvRef" class="form-control" id="cheque" placeholder="Type Check Reference" maxlength="6" required>
                                <div class="invalid-feedback">Please enter your CV Reference"</div>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <label for="validationCustom04" class="form-label">Deposit Type <span class="required">*</span></label>
                               <!-- <input type="text" class="form-control" value="Regular Savings" readonly disabled> -->
                                <select class="form-select" id="validationCustom04" name="depType" required>
                                    <option selected value="">Select Type of Deposit</option>
                                    <option value="1">Regular Savings</option>
                                    <option value="2">Shared Capital</option>
                                </select>
                            <div class="invalid-feedback">Please select deposit type.</div>
                            </div>

                            <div class="col-md-6">
                            
                            <label for="yourUsername" class="form-label">Deposit Amount <span class="required">*</span></label>
                            <div class="input-group has-validation">
                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                <input type="text" name="depAm" class="form-control amount" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01">
                                <div class="invalid-feedback">Please enter amount.</div>
                            </div>
                            </div>

                            <div class="text-end mt-4">
                            <input type="submit" class="btn btn-success" value="Save" tabindex="5">
                            </div>
                                    
                        </div>
                        </form>
                    </fieldset>
    
                    <!-- end of form payment -->
    
                </fieldset>

                    <fieldset <?php echo ($memstatus == 'On-going') ? $class : '' ?>>

                        <fieldset  <?php echo ($flags == 4) ? 'class="active"' : '' ?>>
                            <h5 class="card-title" style="font-size: 35px;"><b>Regular Savings</b></h5>
                            <form action="process/proc_paypmes.php?paypmes=<?php echo encrypt(4, $key); ?>" method="post" class=" needs-validation" novalidate>
                                
                                <div class="row g-3">
                                    
                                <hr>

                                <input type="hidden" name="memberID" value="<?php echo $memberID; ?>">
                                <input type="hidden" name="appBy" value="<?php echo $appBy; ?>">

                                <div class="col-md-6">
                                    <label for="inputEmail3" class="form-label">Previous Payment</label>
                                    <input type="text" placeholder="<?php echo $prevDay; ?>" class="form-control text-end" id="inputText" disabled readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="inputEmail3" class="form-label">Remaining Balance</label>
                                    <input type="text" placeholder="&#8369; <?php echo checkDecimal($remBal); ?>" class="form-control text-end" id="inputText" disabled readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="yourUsername" class="form-label">Invoice No. <span class="required">*</span></label>
                                    <div class="input-group has-validation">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                        <input type="text" name="invRef" class="form-control" id="yourUsername" required maxlength="6">
                                        <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <label for="yourUsername" class="form-label">Cash Voucher Reference <span class="required">*</span></label>
                                    <div class="input-group has-validation">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                        <input type="text" name="cvRef" class="form-control" id="yourUsername" required maxlength="6">
                                        <div class="invalid-feedback">Please enter CV Reference eg. "INV-24-01-001"</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="yourUsername" class="form-label">Amount<span class="required">*</span></label>
                                    <div class="input-group has-validation">
                                        <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                        <input type="text" name="depAm" class="form-control amount" id="" required style="text-align: right;" min="0.01" max="9,999,999,999.99" step="0.01">
                                        <div class="invalid-feedback">Please enter Invoice # eg. "INV-24-01-001"</div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <input type="submit" class="btn btn-success" value="Save" tabindex="5">
                                </div>
                                
                                </div>
                            </form>
                        </fieldset>
                        <!-- end of form regular savings -->
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

</script>

<script>
    $(function() {
        var active = $('fieldset.active')
        $('.next, .previous').click(function(e) {
        e.preventDefault();
        var target = $(this).closest('fieldset')[this.name]();
        if (target.length) {
            active.removeClass('active');
            target.addClass('active');
            active = target;
            }
        });
    });

    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
           document.getElementById('ifCheck').style.display = 'block';
        } else {
           document.getElementById('ifCheck').style.display = 'none';
        }
    }
</script>

<script>

//starting
<?php 
if(isset($_SESSION['valRes'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Transaction Success',
        text: '<?php echo $_SESSION['valRes'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['valRes']); } ?>
//ending

<?php 
if(isset($_SESSION['invRes'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Invalid Transaction',
        text: '<?php echo $_SESSION['invRes'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['invRes']); } ?>

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