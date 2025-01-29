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

        $sqlMem = "SELECT CONCAT(memGiven, ' ', memSur) AS Fullname, memGiven AS fname, memSur AS lname, memMiddle AS middle, suffixes AS suffix, memNick AS Nickname FROM tbperinfo WHERE memberID = ?";
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
                    lnHanded AS Handed, lnPrincipal AS principal, loanMonthPay AS NextPay, lnTotPay AS lnPay,
                    AddedBy AS lnAssist, lnunID  AS UnID, lnTotInt AS TotInt, loanAcquire AS Acquired, loanMaturity AS Maturity
                    FROM tbloaninfo
                    WHERE memberID = ? AND remarks = 0 AND lnstatID = 1";
        $dataLoan = array($memID);
        $stmtLoan = $conn->prepare($sqlLoan);
        $stmtLoan->execute($dataLoan);
        $rowLoan = $stmtLoan->fetch(PDO::FETCH_ASSOC);
        $lnID = $rowLoan['lnID'];
        $Amount = $rowLoan['Amount'];
        $Terms = $rowLoan['Terms'];
        $lnDate = $rowLoan['lnDate'];
        $assist = $rowLoan['lnAssist'];
        $lnHanded = $rowLoan['Handed'];
        $principal = $rowLoan['principal'];
        $NextPay = $rowLoan['NextPay'];
        $lnunID = $rowLoan['UnID'];
        $lnTotInt = $rowLoan['TotInt'];
        $lnTotPay = $rowLoan['lnPay'];
        $lnAcquired = $rowLoan['Acquired'];
        $lnMaturity = $rowLoan['Maturity'];

        $Out = $principal + $lnTotInt;
        $newOut = checkDecimal($Out - $lnTotPay);

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
$pages = 'lnactive'; $nav="trans"; require_once 'sidenavs/admin_side.php';
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

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-8">
                            <h5 class="card-title" style="font-size: 35px;"><b>Loan Payments</b>&nbsp;<span class="badge text-bg-primary align-middle" ><?php echo $lnunID; ?></span></h5>
                        </div>    
                        <div class="col-md-4 text-end" style="margin-top: 40px">
                            <a  href="admin_lnactview.php?mem=<?php echo encrypt($memID, $key) ?>"><button class="btn btn-dark" ><span class="bi bi-arrow-return-left"></span> Back</button></a>
                        </div>

                        <hr style="margin-top: -10px;">

                                    
                        <div class="col-md-12" style="margin-top: -30px;">
                            <h5 class="card-title mt-3" style="font-size: 20px;"><b><?php echo $lnType; ?></b>&nbsp;<span class="badge text-bg-primary align-middle" ><?php echo $lnunID; ?></span></h5>
                            
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Loan ID</th>
                                        <th class="text-end">Original Amount</th>
                                        <th class="text-end">Outstanding Balance</th>
                                        <th>Invoice No.</th>
                                        <th>Cheque Reference</th>
                                        <th>Cash Voucher Reference</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $payments = "SELECT lnunID AS lnunID, lnAmount AS OutStanding, lncurbal AS CurBal, lnnewbal AS NewBal, 
                                                    InvoiceNo AS invNo, CheckRef AS cheque, cvRef AS cvRef, DATE(lnDate) AS dayWhen
                                                    FROM tblnhisinfo WHERE memberID = ?";
                                        $datapay = array($memID);
                                        $stmtpay = $conn->prepare($payments);
                                        $stmtpay->execute($datapay);

                                        $respay = $stmtpay->rowCount();
                                        if($respay > 0){
                                            while($rowpay = $stmtpay->fetch(PDO::FETCH_ASSOC)){
                                                
                                                echo '<tr>';
                                                echo '<td>'.$rowpay['lnunID'].'</td>';
                                                echo '<td class="text-end">&#x20B1; '.number_format($rowpay['OutStanding'], "2", ".", ",").'</td>';
                                                echo '<td class="text-end">&#x20B1; '.number_format($rowpay['NewBal'], "2", ".", ",").'</td>';
                                                echo '<td>'.$rowpay['invNo'].'</td>';
                                                echo '<td>'.$rowpay['cheque'].'</td>';
                                                echo '<td>'.$rowpay['cvRef'].'</td>';
                                                echo '<td>'.$rowpay['dayWhen'].'</td>';
                                                echo '</tr>';

                                            }
                                        }
                                        
                                    
                                    ?>
                                </tbody>
                            </table>
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
