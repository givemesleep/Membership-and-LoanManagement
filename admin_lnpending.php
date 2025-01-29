<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  $key="LLAMPCO";
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

<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
  $pages = 'lnpending'; $nav="trans"; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Application</li>
              <li class="breadcrumb-item active">Pending Loan</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 35px;"><b>Pending Loan</b></h5>
              <table class="table datatable table-hover">
                <thead style="width : 100%">
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 30%;">Member Name</th>
                        <th scope="col"  style="width: 15%;">Loan Type</th>
                        <th scope="col"  style="width: 20%;" class="text-end">Loan Amount</th>
                        <th scope="col"  style="width: 10%;">Loan Terms</th>
                        <th scope="col"  style="width: 15%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>                                    
                    <!-- <tr>
                      <td>tyu</td>
                      <td>tyu</td>
                      <td>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">Extra Large Modal</button>
                    </td>
                    </tr> -->

                    <?php 

                      $sql = "SELECT p.memberID AS memID,
                                CONCAT(IF(p.gendID = 1, 'Ms. ', 'Mr. '), p.memGiven,' ',p.memSur) AS Fullname, 
                                lnt.loanType AS Loan_Type, 
                                loan.loanAm AS Amount, loan.loanTerm AS Terms 

                            FROM tbloaninfo loan

                            JOIN tbperinfo p ON loan.memberID = p.memberID 
                            JOIN tblntypes lnt ON loan.loanID = lnt.loanID
                            WHERE loan.lnstatID = 2 AND p.isLoan = 1";
                      $stmt = $conn->prepare($sql);
                      $stmt->execute();
                      $disp = '';
                      $count = 1;
                      
                      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $btn = '
                        <a href="admin_lnpenview.php?mem='.encrypt($row['memID'], $key).'"><button class="btn btn-dark" title="View"><i class="ri-eye-fill"></i></button></a>
                        ';

                        $disp .= '<tr>
                                    <td>'.$count.'</td>
                                    <td>'.$row['Fullname'].'</td>
                                    <td>'.$row['Loan_Type'].'</td>
                                    <td class="text-end">PHP '.number_format($row['Amount'], "2", ".", ",").'</td>
                                    <td class="text-end">'.$row['Terms'].' Months</td>
                                    <td class="text-center">'.$btn.'</td>
                                  </tr>';
                        $count++;
                      }
                      echo $disp;
                    ?>
                </tbody>
              </table>
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

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>

//starting
<?php 
if(isset($_SESSION['lnSuc'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Loan Application',
        text: '<?php echo $_SESSION['lnSuc'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['lnSuc']); } ?>
//ending

<?php 
if(isset($_SESSION['lnreject'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Loan Application',
        text: '<?php echo $_SESSION['lnreject'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['lnreject']); } ?>

</script>
</body>
</html>

<div class="modal fade" id="ExtralargeModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title"></h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div><!-- End Extra Large Modal-->