<?php 
    require_once 'cruds/config.php';
    session_start();
    if(!empty($_SESSION['logged'])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO Login</title>
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
    .bg {
  width: 100%;
  height: 100%;
  background: linear-gradient(
      45deg,
      transparent 33.33%,
      rgba(57, 144, 179, 0.1) 33.33%,
      rgba(0, 0, 0, 0.1) 66.66%,
      transparent 66.66%
    ),
    lightblue;
  background-size: 20px 20px;
}

.load {
  width: 200px;
  height: 200px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
}

.loader {
  width: 20px;
  height: 40px;
  border-radius: 10px 50px;
  box-shadow: 0px 0px 5px black;
  animation: dominos 1s ease infinite;
}

.loader:nth-child(1) {
  --left: 80px;
  animation-delay: 0.325s;
  background-color: #5d9960;
}

.loader:nth-child(2) {
  --left: 70px;
  animation-delay: 0.5s;
  background-color: #82a587;
}

.loader:nth-child(3) {
  left: 60px;
  animation-delay: 0.625s;
  background-color: #8bac74;
}

.loader:nth-child(4) {
  animation-delay: 0.74s;
  left: 50px;
  background-color: #b9bf90;
}

.loader:nth-child(5) {
  animation-delay: 0.865s;
  left: 40px;
  background-color: #e7d2ab;
}

@keyframes dominos {
  50% {
    opacity: 0.7;
  }

  75% {
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
  }

  80% {
    opacity: 1;
  }
}
</style>
<body>

<main>
<div class="container">
<!-- 
<div class="load">
  <div class="loader"></div>
  <div class="loader"></div>
  <div class="loader"></div>
  <div class="loader"></div>
  <div class="loader"></div>
</div> -->


    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 d-flex flex-column align-items-center justify-content-center">

                    

                    <div class="card mb-3">

                        <div class="card-body">

                                <div class="pt-4 pb-2">
                                    
                                    <div class="row">
                                        <!-- <div class="col-md- text-center">
                                            </div> -->
                                        <div class="col-md-4">
                                            <div class="bg"></div>
                                        </div>
                                        
                                        <div class="col-md-8">
                                            <!-- <h6 class="card-title text-center" style="font-size: 25px">LLAMPCO</h6> -->
                                            <div class="d-flex justify-content-center py-4">
                                                <a href="users_login.php" class="logo d-flex align-items-center w-auto">
                                                    <img src="assets/img/llampcologo.png" alt="">
                                                    <span class="d-none d-lg-block" style="font-size: 30px"><b>LLAMPCO</b></span>
                                                </a>
                                            </div>
                                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                            <p class="text-center small">Enter your username & password to login</p>
                                            <br>
                                            <form action="cruds/processlogin.php" method="post" class="row g-3 needs-validation" novalidate>

                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="floatingName" placeholder="" name="txtusers" required>
                                                        <label for="floatingName">Username</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control" id="floatingName" placeholder="" name="txtpswd" required>
                                                        <label for="floatingName">Password</label>
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <input type="submit" class="btn btn-primary w-30" value="Login" name="txtlogin">
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            
                            

                            

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </section>
</div>
</main><!-- End #main -->

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

<script>

<?php 
if(isset($_SESSION['empty'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Please fill all up!',
        text: '<?php echo $_SESSION['empty'] ?>',
        timer: 1500
    });    

<?php unset($_SESSION['empty']); } ?>

<?php 
if(isset($_SESSION['invalid'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Invalid Credentials!',
        text: '<?php echo $_SESSION['invalid'] ?>',
        timer: 1500
    });    

<?php unset($_SESSION['invalid']); } ?>

</script>
</body>
</html>

