<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Loan Rates</title>
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
    .wrap { max-width: 980px; margin: 10px auto 0; }
    #steps { margin: 80px 0 0 0 }
    .commands { overflow: hidden; margin-top: 30px; }
    .prev {float:left}
    .next, .submit {float:right}
    .error { color: #b33; }
    #progress { position: relative; height: 5px; background-color: #eee; margin-bottom: 20px; }
    #progress-complete { border: 0; position: absolute; height: 5px; min-width: 10px; background-color: #337ab7; transition: width .2s ease-in-out; }

</style>

<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
  $pages = "loanrates"; require_once 'sidenavs/ov_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Loan Rates</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Loan Rates</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 25px;"><b>Loan Rates</b></h5>
            <a href="main_addlr.php"><button class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i><span> New Loan</span></button></a>
            <!-- <a href="process/pdf_mempending.php"><button class="btn btn-dark"><i class="bi bi-printer-fill"></i><span> Print</span></button></a> -->
            <br><br>
              <table class="table datatable table-hover ">
                  <thead>
                      <tr>
                          <th scope="col" style="width: 50px;">#</th>
                          <th scope="col" style="width: 200px;">Loan Type</th>
                          <th scope="col" style="width: 250px;">Amount Description</th>
                          <th scope="col" style="width: 250px;">Terms Description</th> 
                          <th scope="col" style="width: 250px;">Interest Description</th> 
                          <th scope="col" style="width: 200px;">Action</th>
                      </tr>
                  </thead>
                  <tbody>                                    
                  <?php
                    $sql = "SELECT * FROM tbratesinfo WHERE isActive=1";

                    $stmt=$conn->prepare($sql);
                    $stmt->execute();

                    $td='';
                    $appID=1;
                    while($rows=$stmt->fetch()){
                      
                      $btn='
                        <a href=".php"><button class="btn btn-dark" title="View"><i class="ri-eye-fill"></i></button></a>
                        <a href="mem_procpmes.php?pmesID=' . $rows['lrID'] . '"><button class="btn btn-success" title="Edit"><i class="bi bi-pencil-square"></i></button></a>
                        <a href=".php"><button class="btn btn-danger" title="Remove"><i class="bi bi-trash-fill"></i></button></a>
                        ';

                      $td.='
                        <tr>
                          <td>' . $appID . '</td>
                          <td>' . $rows['ToL'] . '</td>
                          <td>' . $rows['amdesc'] . '</td>
                          <td>' . $rows['termdesc'] . '</td>
                          <td>' . $rows['intdesc'] . '</td>
                          <td>' . $btn . '</td>
                        </tr>
                      ';
                      $appID++;
                    }
                    echo $td;
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
<!-- <link rel="stylesheet" href="jqueryto/bootstrap.min.css"> -->


<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>

<?php 
if(isset($_SESSION['memAdded'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Member Added!',
        text: '<?php echo $_SESSION['memAdded'] ?>',
        timer: 1500
    });    

<?php unset($_SESSION['memAdded']); } ?>

<?php 
if(isset($_SESSION['memExist'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Member Name Existed!',
        text: '<?php echo $_SESSION['memExist'] ?>',
        timer: 1500
    });    

<?php unset($_SESSION['memExist']); } ?>

<?php 
if(isset($_SESSION['memFailed'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Member Error Adding!',
        text: '<?php echo $_SESSION['memFailed'] ?>',
        timer: 1500
    });    

<?php unset($_SESSION['memFailed']); } ?>

</script>

<div class="modal fade" id="PMES" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disabled Backdrop</h5>
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
</div>

</body>
</html>




