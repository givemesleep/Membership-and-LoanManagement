<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | On-going</title>
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
  $pages = 'ongoing'; $nav = 'membership'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Membership Accounts</li>
              <li class="breadcrumb-item active">Member On-going</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title" style="font-size: 25px;"><b>Member On-going</b></h5>
            <br>
                <table class="table datatable table-hover table-bordered" style="width : 100%;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 15%;">Member#</th>
                            <th scope="col" style="width: 40%;">Member Name</th>
                            <th scope="col" style="width: 15%;">Deposit Type</th>
                            <th scope="col" style="width: 15%;">Balance</th> 
                            <th scope="col" style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>                                    
                        <?php 
                        
                            // $sql=" ";

                            // $stmt=$conn->prepare($sql);
                            // $stmt->execute();
                            
                            // $approveID=1;              
                            // $tbl='';
                            // while($rows=$stmt->fetch()){

                                    
                            //     // $cvID = md5($rows['memID']);

                            //     $btn='
                            //     <a href="membership_ongoing.php?ongoing='.$rows['memID'].'"><button class="btn btn-success"><i class="bi bi-journal-plus"></i><span> Add Savings</span></button></a>
                            //     ';

                            //     $curam = $rows['reg'];
                            //     $newam = 2400.00 - $curam;
                            //     $nums = number_format($newam, 2, ".", ",");

                            //     $tbl.='
                            //     <tr>
                            //         <td>' . 'LLAMPCO - ' . ' ' . $approveID.'</td>
                            //         <td>'.$rows['Fullname'].'</td>
                            //         <td>' . "Regular Savings" . '</td>
                            //         <td>&#8369; ' . $nums . '</td>
                                    
                            //         <td>'.$btn.'</td>
                            //     </tr>
                            //     ';
                            //     $approveID++;
                            // }
                            // echo $tbl;

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
