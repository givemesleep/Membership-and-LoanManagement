<header id="header" class="header fixed-top d-flex align-items-center">
  <?php 
    $logID = $_SESSION['logged'];
    $sqlUser="SELECT * FROM tbaccinfo WHERE loginID=?";
    $dataUser=array($ID);
    $stmt=$conn->prepare($sqlUser);
    $stmt->execute($dataUser);
    $rowUser=$stmt->fetch();
    $CurrUser=$rowUser['acc_name'];
    $CurrRole=$rowUser['accStatusID'];
    $roles='';
    if($CurrRole == 1){
      $roles='Owner';
    }else {
      if($CurrRole == 2){
        $roles='Admin';
      }else{
        if($CurrRole == 5){
          $roles='Cashier';
        }
      }
    }
  
  ?>
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="assets/img/llampcologo.png" alt="">
        <span class="d-none d-lg-block">LLAMPCO</span>
      </a>
      <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- End Notification Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/default.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $CurrUser; ?></span>
            <!-- user name  -->
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $CurrUser; ?></h6>
              <!-- user name -->
              <span><?php echo $roles; ?></span>
              <!-- user role -->
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            
            

            <li>
              <a class="dropdown-item d-flex align-items-center" href="cruds/out_process.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>