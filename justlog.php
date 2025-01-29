<?php

$admin=$cashier='';
$login = '';

if(isset($_GET['login'])){
  $login = $_GET['login'];
  
  if ($login == 1) {
    $admin = 'class="active"';
  }
  else{
    $cashier = 'class="active"';
  }
}
?>


<style>  
    /* From Uiverse.io by MikeAndrewDesigner */ 
.e-card {
  /* margin: 100px auto; */
  background: linear-gradient(75.7deg, rgb(34, 126, 34) 3.8%, rgb(99, 162, 17) 87.1%);
  box-shadow: 0px 8px 28px -9px rgba(0,0,0,0.45);
  position:fixed;
  width: 100%;
  height: 100%;
  /* border-radius: 16px; */
  overflow: hidden;
  display: flex;
  flex-flow: column;
}

.wave {
  position: absolute;
  width: 100%;
  height: 100%;
  opacity: 0.6;
  /* left: 0;
  top: 0; */
  /* margin-left: -50%;
  margin-top: -70%; */
  background: linear-gradient(744deg,#559e2c,#95b734 60%,#ffb800);
}

.icon {
  width: 3em;
  margin-top: -1em;
  padding-bottom: 1em;
}

.infotop {
  text-align: center;
  font-size: 20px;
  position: fixed;
  top: 5.6em;
  left: 0;
  right: 0;
  color: rgb(255, 255, 255);
  font-weight: 600;
}

.name {
  font-size: 14px;
  font-weight: 100;
  position: relative;
  top: 1em;
  text-transform: lowercase;
}

.wave:nth-child(2),
.wave:nth-child(3) {
  top: 210px;
}

.playing .wave {
  border-radius: 40%;
  animation: wave 3000ms infinite linear;
}

.wave {
  border-radius: 40%;
  animation: wave 55s infinite linear;
}

.playing .wave:nth-child(2) {
  animation-duration: 4000ms;
}

.wave:nth-child(2) {
  animation-duration: 50s;
}

.playing .wave:nth-child(3) {
  animation-duration: 5000ms;
}

.wave:nth-child(3) {
  animation-duration: 45s;
}

.art{
  display: flex;
}

.box {
  width: 50px;
  height: 60px;
  display: flex;
  margin-bottom: 10px;
  box-shadow: none;
  border: none;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  font-weight: 700;
  color: #fff;
  font-family: 'Verdana';
  transition: all 0.8s;
  cursor: pointer;
  position: relative;
  background: rgba(173, 255, 101, 0.1);
  overflow: hidden;
}

.box:before {
  content: "D";
  position: absolute;
  top: 0;
  background: #0f0f0f;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: translateY(100%);
  transition: 0.4s ease-in-out;
}

.box:nth-child(2)::before {
  transform: translateY(-100%);
  content: 'A';
}

.box:nth-child(3)::before {
  content: 'Y';
}

.box:nth-child(4)::before {
  transform: translateY(-100%);
  content: 'O';
}

.box:nth-child(5)::before {
  content: 'N';
}

.box:nth-child(6)::before {
  transform: translateY(-100%);
  content: 'M';
}

.box:nth-child(7)::before {
  content: 'O';
}

.art:hover .box::before {
  transform: translateY(0 );
}

.intro{
    text-align: center;
    font-weight: bolder;
    font-size: 50px;
    color: black;
}
.admin {
    width: 600px;
    height: 200;
    background: rgba( 155, 134, 15, 0.2 );
    box-shadow: 0 8px 32px 0 rgba(57, 83, 24, 0.8);
    backdrop-filter: blur( 30.5px );
    -webkit-backdrop-filter: blur( 30.5px );
    border-radius: 10px;
    border: 1px solid rgba( 255, 255, 255, 0.18 );
    outline: none;
    overflow: hidden;
    color: rgb(40, 144, 241);
    transition: color 0.3s 0.1s ease-out;
    text-align: center;
    }

  .admin::before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  content: '';
  border-radius: 100%;
  display: block;
  width: 990px;
  height: 300px;
  left: -15em;
  text-align: center;
  transition: box-shadow 0.5s ease-out;
  z-index: -1;
}

.admin:hover {
  color: #fff;
}

.admin:hover::before {
  box-shadow: inset 0 0 0 10em rgba( 100, 134, 15, 0.7);
}
 
.cashier {
    width: 600px;
    height: 200px;
    background: rgba( 155, 134, 15, 0.2 );
    box-shadow: 0 8px 32px 0 rgba(57, 83, 24, 0.8);
    backdrop-filter: blur( 30.5px );
    -webkit-backdrop-filter: blur( 30.5px );
    border-radius: 10px;
    border: 1px solid rgba( 255, 255, 255, 0.18 );
    outline: none;
    overflow: hidden;
    color: rgb(40, 144, 241);
    transition: color 0.3s 0.1s ease-out;
    text-align: center;
}

.cashier::before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  content: '';
  border-radius: 100%;
  display: block;
  width: 990px;
  height: 300px;
  left: -15em;
  text-align: center;
  transition: box-shadow 0.5s ease-out;
  z-index: -1;
}

.cashier:hover {
  color: #fff;
}

.cashier:hover::before {
  box-shadow: inset 0 0 0 10em rgba( 100, 134, 15, 0.7);
}

.base{
background-color: rgba(147, 193, 90, 0.6);
box-shadow: 0 8px 32px 0 rgba(57, 83, 24, 0.8);
backdrop-filter: blur( 30.5px );
-webkit-backdrop-filter: blur( 30.5px );
border-radius: 20px;
width: 50%;
margin-top: 250px;
margin-left: 200px;
}

.title{
  text-align: center;
  padding-top: 20px;
  padding-bottom: 40PX;
}


.base input{
  width: 100%;
  font-size: 20px; 
  padding: 10px;
  border-radius: 10px;
  outline: none;
  border: 1px solid white;
  color: white;
  margin: -1px;
  box-sizing: border-box;
  /* opacity: 0; */
  background: transparent;
}

.peeker-icon {
            position: absolute;
            right: 10px;
            top: 53%;
            transform: translateX(-20px) translateY(25px);
            cursor: pointer;
        }

.base input:focus{
  border: 1.5px solid yellow;
  background: transparent;
}

.labeled{
  position: absolute;
  left: 37px;
  top: 174px;
  pointer-events: none;
  font-size: 16px;
  color: white;
  transition:all 0.15s ease;
}

.labeled2{
  position: absolute;
  left: 37;
  top: 255px;
  pointer-events: none;
  font-size: 16px;
  color: white;
  transition: 0.15s ease;
}

.base input:valid + .labeled,
.base input:focus :not(:placeholder-shown) + .labeled {
  line-height: 30px;
  padding: 0;
  transform: translateX(3px) translateY(-37px);
  z-index: 2111;
  font-size: 13px;
  font-weight: bolder;
  border-radius: 50%;
  background-color: rgba(147, 193, 90, 1);
  backdrop-filter: blur( 17.5px );
-webkit-backdrop-filter: blur( 17.5px );
  padding: 2px;
}

.base :nth-child(2) :valid + .labeled2,
.base :nth-child(2) :focus :not(:placeholder-shown) + .labeled2{
  line-height: 20px;
  padding: 0;
  transform: translateX(3px) translateY(-27px);
  z-index: 2111;
  font-weight: bolder;
  font-size: 13px;
  border-radius: 50%;
  background-color: rgba(147, 193, 90, 1);
  backdrop-filter: blur( 17.5px );
-webkit-backdrop-filter: blur( 17.5px );
  padding: 2px;
}

.login{
  padding-top: 60px;
}

.base button{
  background-color: #f3f7fe;
  color: rgba(122, 66, 7, 0.8);
  border: none;
  font-weight: bold;
  cursor: pointer;
  outline: none;
  border-radius: 10px;
  width: 100%;
  height: 45px;
  transition: 0.3s;
}

button:hover{
  background-color: rgba(122, 66, 7, 0.6);
  box-shadow: 0 0 0 5px #3b83f65f;
  color: #fff;
}


.loader
{
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  display: none;
  margin: auto;
  margin-top: 7%;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

fieldset {
  display: none;
}
fieldset.active {
  display: block;
}

</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Removed</title>
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

<body class="e-card playing">
  <div class="image"></div>  
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
 
<main>  
<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    
            <div class="card" style="background: transparent; box-shadow:none; align-items:center;">
                <div class="art">
                  <div class="box">W</div>
                  <div class="box">E</div>
                  <div class="box">L</div>
                  <div class="box">C</div>
                  <div class="box">O</div>
                  <div class="box">M</div>
                  <div class="box">E</div>
                </div>
                
            </div>

              <a id="admin" >
                <div class="card next" name="next" style="background:transparent;">
                    <div class="admin">

                      <div class="row">
                        <div class="col-md-3">
                        <img src="assets/img/businessman.png" alt="" style="height: 100px;margin-top:50px; margin-left:35px; border-right: 1px solid white; display:block; padding-right: 50px;">
                        </div>

                        <div class="col-md-6">
                          <h1 style="margin-top:75px; margin-left: 90px; font-family:'Verdana'; font-weight:900; color:rgba(150, 230, 140, 0.8)">ADMIN</h1>
                        </div>

                      </div>

                    </div>
                </div>
              </a>

              <a id="cashier">
                <div class="card" style="background:transparent;">
                    <div class="cashier">
                    
                    <div class="row">
                        <div class="col-md-3">
                        <img src="assets/img/cashier-machine.png" alt="" style="height: 100px;margin-top:50px; margin-left:35px; border-right: 1px solid white; display:block; padding-right: 50px;">
                        </div>

                        <div class="col-md-6">
                          <h1 style="margin-left:80px; margin-top:75px; font-weight:900; font-family:'Verdana'; color:rgba(150, 230, 140, 0.8)">CASHIER</h1>
                        </div>

                      </div>
                    </div>
                </div>
              </a>
              
              <div class="card" style="background: transparent; box-shadow:none; align-items:center;">
                <a href="justlog.php" class="d-flex align-items-center">
                    <img src="assets/img/llampcologo.png" alt="" style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-block" style="font-size:23px; font-weight: 600px; color:black; text-align:center; letter-spacing: 20px; opacity:50%; margin-left: 10px;">LLAMPCO</span>
                  </a>
                  <h3 style="font-size:15px; font-weight: 600px; color:black; letter-spacing:2px; text-align:center; opacity:50%; margin-left: 10px; margin-top:10px;">[Llano Multi-Purpose Cooperative]</h3>
              </div>

            <fieldset id="adminset">
            
                <div class="card-body base">
                <div class="title">
                  <h3 style="font-weight:bolder; font-size: 50px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:aliceblue">LOGGING IN</h3>
                  <h3 style="font-weight:300px; letter-spacing:5px; font-size: 20px; opacity:85%; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:#7c6c27">as an ADMIN</h3>
                </div>
                  
                  <form action="" class="row g-3">
                    <div class="col-md-12">
                      <input type="text" class="" autocomplete="off" required="required">
                      <label class="labeled">Enter your Name</label>
                    
                      <input type="password" id="password"  required="required" class="" style="margin-top:30px;" autocomplete="off">
                      <label class="labeled2">Password</label>
                      <span class="peeker-icon" onclick="togglePassword()">🙊</span>
                    </div>
                  </form>

                  <div class="text-center login">
                  <button>LOGIN </button>
                  </div>
                </div>

                <div class="card" style="box-shadow:none; border-radius:0%; opacity:50%; border-top:1px solid white; margin-top: 300px; background:transparent;">
                  <div class="card-body row" style="font-size:12px; font-weight: 600px; color:black; text-align:center; letter-spacing: 2px; opacity:80%; width: 100%; box-shadow:none; border-radius:0%; background:transparent; margin-top: 30px;">
                  
                  <div class="col-md-3">
                  <p>Forgot Password</p>
                  </div>

                  <div class="col-md-3">
                  <p>Privacy Policy</p>
                  </div>

                  <div class="col-md-3">
                  <p>Terms</p>
                  </div>
                  
                  <div class="col-md-3">
                  <p>Cookies Policy</p>
                  </div>

                </div>
                </div>

            </fieldset>

            <fieldset id="cashierset">
              
            <div class="card-body base">
                <div class="title">
                <h3 style="font-weight:bolder; font-size: 50px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:aliceblue">LOGGING IN</h3>
                <h3 style="font-weight:300px; letter-spacing:5px; font-size: 20px; opacity:85%; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:#7c6c27">as an CASHIER</h3>
                </div>
                  
                  <form action="" class="row g-3">
                    <div class="col-md-12">
                      <input type="text" class="" autocomplete="off" required="required">
                      <label class="labeled">Enter your Name</label>
                    
                      <input type="password" id="password"  required="required" class="" style="margin-top:30px;" autocomplete="off">
                      <label class="labeled2">Password</label>
                      <span class="peeker-icon" onclick="togglePassword()">🙊</span>
                    </div>
                  </form>

                  <div class="text-center login">
                  <button>LOGIN </button>
                  </div>
                </div>

                <div class="card" style="box-shadow:none; border-radius:0%; opacity:50%; border-top:1px solid white; margin-top: 300px; background:transparent;">
                  <div class="card-body row" style="font-size:12px; font-weight: 600px; color:black; text-align:center; letter-spacing: 2px; opacity:80%; width: 100%; box-shadow:none; border-radius:0%; background:transparent; margin-top: 30px;">
                  
                  <div class="col-md-3">
                  <p>Forgot Password</p>
                  </div>

                  <div class="col-md-3">
                  <p>Privacy Policy</p>
                  </div>

                  <div class="col-md-3">
                  <p>Terms</p>
                  </div>
                  
                  <div class="col-md-3">
                  <p>Cookies Policy</p>
                  </div>

                </div>
                </div>
            </fieldset>
          
            <div class="loader" id="loader"></div>
    </section>
</div>
</main>

        
</body>
<script src="jqueryto/jquerytodiba.min.js"></script>
<script>
    function togglePassword() {
            const passwordInput = document.getElementById('password');
            const peekerIcon = document.querySelector('.peeker-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                peekerIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                peekerIcon.textContent = '🙊';
            }
        }

        $(document).ready(function() {
            $("#admin").click(function() {
                $("#loader").show();
                $('#admin').hide();
                $('#cashier').hide();
                setTimeout(function() {
                    $("#loader").hide();
                    $("#adminset").show();
                }, 2000); // Simulate loading time
            });
        });

        $(document).ready(function() {
            $("#cashier").click(function() {
                $("#loader").show();
                $('#cashier').hide();
                $('#admin').hide();
                setTimeout(function() {
                    $("#loader").hide();
                    $("#cashierset").show();
                }, 2000); // Simulate loading time
            });
        });
</script>