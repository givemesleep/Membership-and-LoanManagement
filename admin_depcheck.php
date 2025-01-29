<?php 
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';

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
  <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"> -->
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/app_headers.php';
  $pages = 'checkbal';  $nav = 'loantrans'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <section class="section">
    <div class="row">
        <div class="col-lg-2 mt-5">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>       
        </div>

        <div class="col-lg-7 mt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 25px;"><b>Check Deposit</b></h5>
                    <form action="process/proc_checkdep.php" method="post" class="needs-validation" novalidate>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <div class="input-group has-validation">
                                    <input type="text" name="idmoto" class="form-control" placeholder="Search Account ID" list="accountID" required>
                                    <div class="invalid-feedback">Please Enter Account ID</div>
                                    <datalist id="accountID">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <select class="form-select seltwo" name="deptype">
                                    <option value="">Select Deposit Type</option>
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

                        </div>

                    </form>
                </div>
            </div>
      </div>
    </div>
  </section>    
</main>

<?php
    require_once 'sidenavs/centered_footer.php';
?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
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

<script>
     $(document).ready(function(){
    $('.seltwo').select2({
        width: '100%',  
        placeholder: "Select an Option", 
        allowClear: true
    });
});
</script>
</body>
</html>


