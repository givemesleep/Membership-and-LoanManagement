<?php 
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Create Loan</title>
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
?>
<?php $pages = 'ln_create';  require_once 'sidenavs/ov_side.php'; ?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Loan Application</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Create Loan</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <secti class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 25px;"><b>Create Loan</b></h5>
              <table class="table datatable table-hover ">
                  <thead>
                      <tr>
                          <th scope="col">Member#</th>
                          <th scope="col">Member Name</th>
                          <th scope="col">Standing</th>
                          <th scope="col">Credit Scoring</th> 
                          <th scope="col">Action</th>
                      </tr>
                  </thead>
                  <tbody>                                    
                  <?php 
                    $sql="";
                    
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

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>