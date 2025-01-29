<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';
    require_once 'process/func_func.php';

    $key = "LLAMPCO";
    $memID = $unID = "";
    $Name = $fname = $mob1 = $mob2 = $land = $email = $coms = '';
    $lnID = $Amount = $Terms = $lnDate = '';
    $lnType = $interest = $service = $cbu = $def = $colat = $appID = $appName = $assist = '';
    $assist = '';
    if(isset($_GET['mem'])){
        $memID = decrypt($_GET['mem'], $key);

        $sqlUn = "SELECT * FROM tbuninfo WHERE memberID = ?";
        $dataUn = array($memID);
        $stmtUn = $conn->prepare($sqlUn);
        $stmtUn->execute($dataUn);
        $rowUn = $stmtUn->fetch(PDO::FETCH_ASSOC);
        $unID = $rowUn['unID'];

        $sqlMem = "SELECT CONCAT(IF(gendID = 1, 'Ms. ', 'Mr. '), memGiven, ' ', memSur) AS Fullname, memGiven AS fname, memSur AS lname, memMiddle AS middle, suffixes AS suffix, memNick AS Nickname FROM tbperinfo WHERE memberID = ?";
        $dataMem = array($memID);
        $stmtMem = $conn->prepare($sqlMem);
        $stmtMem->execute($dataMem);
        $resMem = $stmtMem->rowCount();
        if($resMem > 0){
            $rowMem = $stmtMem->fetch(PDO::FETCH_ASSOC);
                $Name = $rowMem['Fullname'];
                $fname = $rowMem['fname'];
                $lname = $rowMem['lname'];
                $mname = $rowMem['middle'];
                $suffix = $rowMem['suffix'];
                $nickname = $rowMem['Nickname'];
        }else{
            $Name = $fname = $lname = $mname = $suffix = $nickname = '';
        }
        
        $sqlCon = "SELECT memmob1 AS Contact1, memmob2 AS Contact2, memlan AS Landline, mememail AS EmailAdd
                FROM tbconinfo WHERE memberID = ?";
        $dataCon = array($memID);
        $stmtCon = $conn->prepare($sqlCon);
        $stmtCon->execute($dataCon);
        $resCon = $stmtCon->rowCount();
        if($resCon > 0){
            $rowCon = $stmtCon->fetch(PDO::FETCH_ASSOC);
                $mob1 = $rowCon['Contact1'];
                $mob2 = $rowCon['Contact2'];
                $land = $rowCon['Landline'];
                $email = $rowCon['EmailAdd'];
                // $assist = $rowCon['Assist'];
        }else{
            $mob1 = $mob2 = $land = $email ='';
        }

        $sqlCom = "SELECT memberName AS comakers FROM tbcominfo WHERE memberID = ? ";
        $dataCom = array($memID);
        $stmtCom = $conn->prepare($sqlCom);
        $stmtCom->execute($dataCom);
        $resCom = $stmtCom->rowCount();
        if($resCom > 0){
            $coms = '';
            while($rowCom = $stmtCom->fetch(PDO::FETCH_ASSOC)){
                $coms .= $rowCom['comakers'].', ';
            }
        }else{
            $coms = '';
        }

        $sqlLoan = "SELECT loanAm AS Amount, loanTerm AS Terms, loanID AS lnID, lnApply AS lnDate,
                    AddedBy AS lnAssist FROM tbloaninfo
                    WHERE memberID = ? AND remarks = 0";
        $dataLoan = array($memID);
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

        $sqlApp = "SELECT appName FROM tbapp WHERE appID = ?";
        $dataApp = array($appID);
        $stmtApp = $conn->prepare($sqlApp);
        $stmtApp->execute($dataApp);
        $resApp = $stmtApp->rowCount();
        if($resApp > 0){
            $rowApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
            $appName = $rowApp['appName'];
        }else{
            $appName = '';
        }


    }

    

?>  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Loan Pending</title>
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
    #headline{
        background : #3c7dbc; 
        color:aliceblue; 
        border-radius:10px; 
        height: 35px; 
        padding-top:3px;
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
    .gosh{
        margin-top: 50px;
        padding-left: 250px;
        padding-right: 250px;
    }
    .centered-label{
        text-align: center;
    }
    .step1{
        text-align: center;
    }
    footer{
        text-align: center;
    }button.active{
        border: 2px green solid;
    }
</style>

<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
$pages = 'lnpending'; $nav="trans"; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Transaction</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Pending Loan</li>
              <li class="breadcrumb-item active">View Loan Application</li>
              
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
                        <a href="admin_lnpending.php"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
                    </div>

                    <div class="col-md-12 mt-3 text-center">
                        <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                    </div>

                    <div class="col-md-6 mt-3 text-start">
                        <p>Member ID</p>
                    </div>

                    <div class="col-md-6 mt-3 text-end">
                        <h6><b><?php echo $unID; ?></b></h6>
                    </div>

                    <div class="col-md-12 text-center">
                        <h6><b><?php echo $Name; ?></b></h6>
                    </div>

                    <div class="col-md-12 text-center">
                        <p>Name</p>
                    </div>

                    <div class="col-md-6 mt-3 text-end">
                        <a href="admin_lnapproval.php?accrev=<?php echo encrypt($memID, $key); ?>"><button class="btn btn-success" style="width: 100%;">Approved</button></a>
                    </div>

                    <div class="col-md-6 mt-3 text-start">
                        <a href="process/proc_rmmem.php?lnreject=<?php echo encrypt($memID, $key); ?>"><button class="btn btn-danger" style="width: 100%;">Decline</button></a>
                    </div>

                </div>
            
            </div>
        </div>
    </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-12">
                            <h5 class="card-title" style="font-size: 35px;"><b>Loan Application</b></h5>
                        </div>    

                        <hr style="margin-top: -10px;">

                        <div class="col-md-12"> 
                            <div class="card" style="border: 1px solid; height: 120px; margin-top: -10px;" >
                                <div class="card-body">
                                    <div class="row mt-3">

                                        <div class="col-md-4">
                                            <h6>Loan Type</h6>
                                            <h3><b><?php echo $lnType; ?></b></h3>
                                            <h6><?php echo $Name; ?></h6>
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

                        <div class="col-md-12">
                            <!-- Pills Tabs -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="margin-top: -10px;">
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link active text-dark" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#basic" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Member Details</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#contact" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Contact</button>
                                </li> -->
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#education" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Loan Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#employment" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Other Details</button>
                                </li>
                            </ul>
                        
                            <div class="tab-content pt-2" id="myTabContent">
                                
                                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Member Details</b></h5>
                                    <div class="row">
                                    
                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>Last Name</h6>
                                                    <h6>Given Name</h6>
                                                    <h6>Middle Name</h6>
                                                    <h6>Suffix</h6>
                                                    <h6>Nickname</h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b><?php echo $lname; ?></b></h6>
                                                    <h6><b><?php echo $fname; ?></b></h6>
                                                    <h6><b><?php echo $mname; ?></b></h6>
                                                    <h6><b><?php echo ($suffix == '') ? '&nbsp;' : $suffix ?></b></h6>
                                                    <h6><b><?php echo $nickname; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>Email Address</h6>
                                                    <h6>(I) Mobile #</h6>
                                                    <h6>(II) Mobile #</h6>
                                                    <h6>Landline</h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b><?php echo $email; ?></b></h6>
                                                    <h6><b><?php echo ($mob1 != null) ? '+63 '.$mob1 : '&nbsp;'; ?></b></h6>
                                                    <h6><b><?php echo ($mob2 != null) ? '+63 '. $mob2 : '&nbsp;'; ?></b></h6>
                                                    <h6><b><?php echo ($land != null)? $land : '&nbsp;' ; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <!-- <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="profile-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Loan Details</b></h5>
                                    <div class="row">

                                        <div class="col-md-7 text-start">
                                            <div class="row">
                                                <div class="col-md-3 text-start">
                                                    <h6>Region</h6>
                                                    <h6>Province</h6>
                                                    <h6>City</h6>
                                                    <h6>Brgy</h6>
                                                    <h6>Address</h6>
                                                    <h6>Zip</h6>
                                                </div>
                                                <div class="col-md-9 text-start">
                                                    <h6><b><?php echo $reg; ?></b></h6>
                                                    <h6><b><?php echo $prov; ?></b></h6>
                                                    <h6><b><?php echo $mun; ?></b></h6>
                                                    <h6><b><?php echo $brgy; ?></b></h6> 
                                                    <h6><b><?php echo $house; ?></b></h6>
                                                    <h6><b><?php echo ($zip == '') ? '&nbsp;' : $zip ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>(1)Mobile # </h6>
                                                    <h6>(2)Mobile # </h6>
                                                    <h6>Landline </h6>
                                                    <h6>Email Address </h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b><?php echo $mobile1; ?></b></h6>
                                                    <h6><b><?php echo $mobile2; ?></b></h6>
                                                    <h6><b><?php echo $landline; ?></b></h6>
                                                    <h6><b><?php echo $email ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> -->
                                
                                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="contact-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Loan Details</b></h5>
                                    <div class="row">
                                        
                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>Loan Amount</h6>
                                                    <h6>Interest Rate</h6>
                                                    <h6>Payment Terms</h6>
                                                    <h6>Collateral Fee</h6>
                                                    <h6>Approval</h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b>&#x20B1; <?php echo number_format($Amount, "2", ".", ",") ?></b></h6>
                                                    <h6><b><?php echo $interest; ?>% Diminishing Balance</b></h6>
                                                    <h6><b><?php echo $Terms;?> Months Payment</b></h6>
                                                    <h6><b><?php echo ($lnType == "Time Deposit Loan") ? 'Time Deposit' : $colat . ' which ever is lower' ?></b></h6>
                                                    <h6><b><?php echo ($appID != null) ? $appName : '&nbsp;' ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-5 text-start">
                                                    <h6>Service Fee (%)</h6>
                                                    <h6>CBU (%)</h6>
                                                    <h6>Deferred Coll. Fee (%)</h6>
                                                    <h6>Applied LPPI</h6>
                                                    <h6>Created By</h6>
                                                </div>
                                                <div class="col-md-7 text-start">
                                                    <h6><b><?php echo ($service != null) ? $service. '%' : '&nbsp;' ?></b></h6>
                                                    <h6><b><?php echo ($cbu != null) ? $cbu. '%' : '&nbsp;' ?></b></h6>
                                                    <h6><b><?php echo ($def != null) ? $def. '%' : '&nbsp;' ?></b></h6>
                                                    <h6><b><?php echo ($lnType == "Time Deposit Loan") ? 'Time Deposit' : '' ?></b></h6>
                                                    <h6><b><?php echo ($assist != null) ? $assist : '&nbsp;' ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="employment" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Other Details</b></h5>
                                    <div class="row">
                                        <div class="col-md-12 text-start">
                                            <div class="row">
                                                <div class="col-md-2 text-start">
                                                    <h6>Co-Makers Names</h6>
                                                    <!-- <h6>Benificiary Names</h6> -->
                                                    <!-- <h6>Company Name</h6>
                                                    <h6>Occupation</h6>
                                                    <h6>Monthly Income</h6> -->
                                                </div>
                                                <div class="col-md-10 text-start">
                                                    <!-- <h6><b><?php //echo ($coms != null) ? $coms : '&nbsp;' ?></b></h6> -->
                                                    <?php 
                                                    
                                                    $sqlCom = "SELECT memberName AS comakers FROM tbcominfo WHERE memberID = ? ";
                                                    $dataCom = array($memID);
                                                    $stmtCom = $conn->prepare($sqlCom);
                                                    $stmtCom->execute($dataCom);
                                                    $resCom = $stmtCom->rowCount();
                                                    if($resCom > 0){
                                                        $coms = '';
                                                        while($rowCom = $stmtCom->fetch(PDO::FETCH_ASSOC)){
                                                            
                                                            echo '<h6><b>'.$rowCom['comakers'].'</b></h6>';
                                                        }
                                                        
                                                    }else{
                                                        echo '<h6><b>&nbsp;</b></h6>';
                                                    }
                                                    // $sqlBen = "SELECT fname AS Fullname FROM tbbeninfo WHERE memberID = ?";
                                                    // $dataBen = array($memID);
                                                    // $stmtBen = $conn->prepare($sqlBen);
                                                    // $stmtBen->execute($dataBen);
                                                    // $resBen = $stmtBen->rowCount();
                                                    // if($resBen > 0){
                                                    //     while($rowBen = $stmtBen->fetch(PDO::FETCH_ASSOC)){
                                                    //         echo '<h6><b>'.$rowBen['Fullname'].'</b></h6>';

                                                    //     }
                                                    // }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Pills Tabs -->

                        </div>  

                        <div class="col-md-12 mt-5">
                            <hr>
                        </div>

                        <div class="col-md-12 mt-3 mb-3 text-center">
                            <h6><?php echo date('F j, Y');?> - <span id="clocking"></span></h6>
                        </div>

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

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
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
<script src="jqueryto/jquerytodiba.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

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
