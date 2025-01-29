<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

  $memID = "";
  $accID = "";
  $memName = "";
  $RS = ""; $Cap = ""; $TD = ""; $SV = ""; $SS = ""; $FS = "";
  $defaultName = "Deposit";
  if (isset($_GET['depID'])) {
    $fetID = $_GET['depID'];

    // $accID = $fetID;

    $sqlCD = "SELECT 
                p.memberID AS memID, ui.unID AS accID,  
                
                CONCAT(IF(p.gendID = 1, 'Mr. ', 'Ms. '), p.memSur, ', ', p.memGiven, ' ', p.memMiddle, ' ', IF(p.sufID = 0,' ', sf.suffixes)) AS Fullname,
                #dep
                df.regSav AS RS, df.shareCap AS Cap, df.timeDep AS TD, df.speVol AS SV, df.speSav AS SS, df.funSav AS FS
		
              FROM tbperinfo p


              JOIN tbuninfo ui
              ON p.memberID = ui.memberID

              LEFT JOIN tbsuffixes sf
              ON p.sufID = sf.sufID

              JOIN tbdepinfo df
              ON p.memberID = df.memberID

              WHERE p.memberID OR ui.unID = ?";
    
    $dataCD = array($fetID);

    $stmtCD = $conn->prepare($sqlCD);
    $stmtCD->execute($dataCD);
    $rowCD = $stmtCD->fetch();
    
    $memID = $rowCD['memID']; //ID
    $accID = $rowCD['accID']; //Unique ID
    $memName = $rowCD['Fullname']; //Fullname
    //Deposits
    $RS = $rowCD['RS']; $Cap = $rowCD['Cap']; $TD = $rowCD['TD']; $SV = $rowCD['SV']; $SS = $rowCD['SS']; $FS = $rowCD['FS'];
    
  }

$depType = "";
if(isset($_GET['depType'])){
  $depType = $_GET['depType'];
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
  require_once 'sidenavs/headers.php';
  $pages = 'checkdep';  $nav = 'deptrans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Members Transaction</li>
              <li class="breadcrumb-item active">Check Deposit</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 25px;"><b>Search Member</b></h5>
            <form action="process/proc_checkdep.php" method="post" class="row g-3 mt-3 needs-validation" novalidate>

                <div class="col-md-12">
                  <div class="input-group has-validation">
                    <input type="text" name="idmoto" class="form-control" placeholder="Search Account ID" list="accountID" required>
                    <div class="invalid-feedback">Please Enter Account ID</div>
                      <datalist id="accountID">
                      <?php 
                        // $sql = "SELECT * FROM tbmuni";
                        // $stmt = $conn->prepare($sql);
                        // $stmt->execute();

                        // while($row=$stmt->fetch()){
                        //   echo '<option value="'.$row['citymunDesc'].'">';
                        // }
                      
                      ?>
                    </datalist>
                  </div>
                </div>

                <div class="col-md-12">
                    <select class="form-select inpots" name="deptype" aria-label="State">
                        <option selected value="0">Type of Deposit</option>
                        <?php 
                            $sql = "SELECT * FROM tbdeptype";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            while($row=$stmt->fetch()){
                                echo '<option value="'.$row['deptypeID'].'">'.$row['depDesc'].'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <input type="submit" name="Search" value="Search" class="btn btn-success" style="width: 100%;">
                </div>

            </form>
              
            <div class="text-center mt-2">
              <a href="admin_checkdep.php"><button class="btn btn-dark" style="width: 100%;">Reload</button></a>
            </div>
            
          </div>
        </div>  
      </div>
      
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 25px;"><b>Deposit Information</b></h5>
              <div class="text-start">
                <h6><b>Name : <?php echo ($memName == ' ') ? ' ' : $memName ?></b></h6>
                <h6><b>Member ID : <?php echo ($accID == ' ') ? ' ' : $accID ?></b></h6>
              </div>
            <!-- <form action="process/proc_createdep.php" method="post" class="row g-3 mt-3 needs-validation" novalidate> -->

                <!-- <div class="col-md-4"> -->
                <!-- <label for="yourUsername" class="form-label">Account No.</label> -->
                <!-- <div class="input-group has-validation"> -->
                    <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                    <!-- <input type="text" name="idmoto" class="form-control" placeholder="Search Account ID" required> -->
                    <!-- <div class="invalid-feedback">Please Enter Account ID</div> -->
                <!-- </div> -->
                <!-- </div> -->

                <!-- <div class="col-md-4 text-start"> -->
                    <!-- <input type="submit" name="Search" value="Search" class="btn btn-primary"> -->
                <!-- </div> -->

            <!-- </form> -->
              
            <!-- <div class="row mt-4 g-3">

              <div class="col-md-12">
                <input type="text" class="form-control" value="<?php //echo $accName; ?>" disabled readonly style="background: transparent; border : 0px; font-size : 30px; ">
              </div>

            </div> -->
            <!-- add fieldset  -->

            <fieldset <?php echo ($depType == "Regular Saving") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                  <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
                <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlRS = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataRS = array($memID, 1);
                  $stmtRS = $conn->prepare($sqlRS);
                  $stmtRS->execute($dataRS);

                  $count = 1;
                  while($rowRS = $stmtRS->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowRS['amount'] . "</td>";
                    echo "<td>" . $rowRS['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowRS['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $RS ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous"> -->
                <!-- <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>


            </fieldset>

            <fieldset <?php echo ($depType == "Capital") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
              <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlCap = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataCap = array($memID, 2);
                  $stmtCap = $conn->prepare($sqlCap);
                  $stmtCap->execute($dataCap);

                  $count = 1;
                  while($rowCap = $stmtCap->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowCap['amount'] . "</td>";
                    echo "<td>" . $rowCap['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowCap['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $RS ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>


            </fieldset>
            
            <fieldset <?php echo ($depType == "Time Deposit") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                  <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
                <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlTD = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataTD = array($memID, 3);
                  $stmtTD = $conn->prepare($sqlTD);
                  $stmtTD->execute($dataTD);

                  $count = 1;
                  while($rowTD = $stmtTD->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowTD['amount'] . "</td>";
                    echo "<td>" . $rowTD['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowTD['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $TD ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>


            </fieldset>

            <fieldset <?php echo ($depType == "Special Voluntary") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                  <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
                <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlSV = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataSV = array($memID, 4);
                  $stmtSV = $conn->prepare($sqlSV);
                  $stmtSV->execute($dataSV);

                  $count = 1;
                  while($rowSV = $stmtSV->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowSV['amount'] . "</td>";
                    echo "<td>" . $rowSV['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowSV['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $SV ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>

            </fieldset>

            <fieldset <?php echo ($depType == "Special Savings") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                  <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
                <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlSS = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataSS = array($memID, 5);
                  $stmtSS = $conn->prepare($sqlSS);
                  $stmtSS->execute($dataSS);

                  $count = 1;
                  while($rowSS = $stmtSS->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowSS['amount'] . "</td>";
                    echo "<td>" . $rowSS['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowSS['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $SS ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <!-- <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>

            </fieldset>

            <fieldset <?php echo ($depType == "Fun Saver") ? 'class="active"' : ' ' ?>>
            <br>
            
            <table class="table table-hover table-bordered" style="padding : 20%;">
              <thead style="width:100%;">
                <tr>

                  <th style="width : 5%;">#</th>
                  <th style="width : 25%;">Deposit Type</th>
                  <th class="text-end"style="width : 20%">Amount</th>
                  <th style="width : 25%">Invoice Ref</th>
                  <th style="width : 25%">Time and Date</th>

                </tr>
              </thead>
              <tbody >
                <?php 
                
                if($accID == ""){
                  echo "<tr><td colspan='5' class='text-center'><b>No Data Found</b></td></tr>";
                } else{
                  $sqlFS = "SELECT * FROM tbdephisinfo WHERE memberID = ? AND depTypeID = ?";
                  $dataFS = array($memID, 6);
                  $stmtFS = $conn->prepare($sqlFS);
                  $stmtFS->execute($dataFS);

                  $count = 1;
                  while($rowFS = $stmtFS->fetch()){
                    echo "<tr>";
                    echo "<td style='vertical-align: top;'>" . $count . "</td>";
                    echo "<td style='vertical-align: top;'>Regular Savings</td>";
                    echo "<td class='text-end'>" . $rowFS['amount'] . "</td>";
                    echo "<td>" . $rowFS['InvoiceNo'] . "</td>";
                    echo "<td>" . $rowFS['datepay'] . "</td>";
                    echo "</tr>";
                    $count++;
                  }
                }

                ?>
              </tbody>
            </table>

            <div class="col-md-12">
              <input type="text" class="form-control" value="<?php echo ($memID == "") ? 'No outstanding amount' : 'Total Amount : ₱ ' . $FS ?>" disabled readonly style="background: transparent; border : 0px;">
            </div>

            <div class="text-end">
                <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                <!-- <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;"> -->
            </div>

            </fieldset>
            
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

<script src="jqueryto/jquerymoto.js"></script>
<script src="jqueryto/poppermoto.js"></script>
<script src="jqueryto/bootstrapmoto.js"></script>
<script src="jqueryto/sweetalertmoto.js"></script>

<script src="jqueryto/jquery.formwizard.js"></script>
<script src="jqueryto/jquery.min.js"></script>
<script src="jqueryto/jquery.validate.min.js"></script>
<script src="jqueryto/bootstrap.min.css"></script>
<script src="jqueryto/jquerytodiba.min.js"></script>
<script src="jqueryto/ajaxmoto.js"></script>

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
</script>

<script type="text/javascript">

$("#idmoto").change(function() {
    $("#pangalan").load("process/fetch_person.php?ngalan=" + $("#idmoto").val());
});

</script>

</body>
</html>
