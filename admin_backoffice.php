<?php
  // require_once 'cruds/config.php';
  // session_start();

  
  require_once 'cruds/config.php';
  require_once 'cruds/current_user.php';
  require_once 'process/func_func.php';

  if(isset($_GET['pages'])){
    $loc = $_GET['pages'];

  }

  $today = new DateTime();
  $today = $today->format('F d, Y');

  $flag = '';

  if(isset($_GET['flag'])){
    $flag = $_GET['flag'];

  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO Dashboard</title>
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
  <link rel="stylesheet/scss" href="assets/scss/_dashboard.scss" type="text/css">

</head>

<body class="d-flex flex-column min-vh-100">
  <style>
    fieldset {
    display: none;
  }
  fieldset.active {
    display: block;
  }
  .required{
    color : red;
  }

  </style>

  <!-- sidenav  -->
<?php 
    require_once 'sidenavs/headers.php';
    $pages = $loc ; $nav=''; require_once 'sidenavs/admin_backside.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Maintenance</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active">Maintenance</li>

      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            

            <fieldset <?php echo ($loc == 'Account') ? 'class="active"' : '' ?>>

            </fieldset>

            <fieldset <?php echo ($loc == 'Adduser') ? 'class="active"' : '' ?>>

            </fieldset>

            <fieldset <?php echo ($loc == 'EditUser') ? 'class="active"' : '' ?>>

            </fieldset>

            <fieldset <?php echo ($loc == 'BackUp') ? 'class="active"' : '' ?>>
              <div class="row">
                <div class="col-md-8">
                  <h5 class="card-title" style="font-size: 35px"><b>Database Back-up</b></h5>
                </div>
                <div class="col-md-4 text-end mt-4">
                  <a href="admin_index.php"><button class="btn btn-outline-dark"><i class="bi bi-x-lg"></i></button></a>
                </div>
                
                <hr>

                <div class="col-md-12 mb-2">
                  <a href="process/proc_dbbackup.php"><button class="btn btn-dark"><i class="bi bi-database-gear"></i> Generate Backup</button></a>
                </div>

                <div class="col-md-12 mt-3">
                  <table class="table table-hover datatable">
                    <thead>
                      <tr>
                        <th>Filename</th>
                        <th>Folder Path</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $backup="SELECT * FROM tbdatabaseinfo";
                      $stmt=$conn->prepare($backup);
                      $stmt->execute();

                     

                      if($stmt->rowCount() > 0){
                        while($row=$stmt->fetch()){
                          $status = $row['isCreated'];

                          if($status == 1){
                            $status = 'Success';
                          }else{
                            $status = 'Failed';
                          }
                          echo '<tr>';
                          echo '<td>' . $row['filename'] . '</td>';
                          echo '<td>' . $row['fdpath'] . '</td>';
                          echo '<td>' . $row['buDate'] . '</td>';
                          echo '<td><span class="badge bg-success">' . $status . '</span></td>';
                          echo '</tr>';
                        }
                      }else{
                        echo '<tr>';
                          echo '<td colspan="5" class="text-center"><b>No data to show</b></td>';
                          echo '</tr>';
                      }
                      
                      ?>
                    </tbody>
                  </table>
                </div>
                
              </div>      
            </fieldset>

            <fieldset <?php echo ($loc == 'LoanArchive') ? 'class="active"' : '' ?>>

            </fieldset>

            <fieldset <?php //echo ($flag == '') ? 'class="active"' : '' ?>>
            <div class="row">
              <div class="col-md-8">
                <h5 class="card-title" style="font-size: 35px;"><b>Maintenance</b></h5>
              </div>

              <div class="col-md-4 text-end mt-4">
                <!-- <a href=""><button class="btn btn-dark">View Statistics</button></a> -->
                <a href="admin_index.php"><button class="btn btn-outline-dark"><i class="bi bi-x-lg"></i></button></a>
              </div>

              <div class="col-md-12">
                <table class="table table-hover datatable">
                  <thead>
                    <tr>
                      <th>File Name</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      
                    </tr>
                  </tbody>
                </table>
              </div>

              <hr>

                <div class="col-md-3 mt-3" title="Create new user">
                  <a href="">
                    <div class="card" style="height: 100px; border : 1px solid;">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 class="card-title" style="font-size: 25px;"><b>Adjust Loan Rates</b></h6>
                          </div>
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 mt-3" title="Create new user">
                  <a href="">
                    <div class="card" style="height: 100px; border : 1px solid;">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 class="card-title" style="font-size: 25px;"><b>Config Member</b></h6>
                          </div>
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 mt-3" title="Create new user">
                  <a href="">
                    <div class="card" style="height: 100px; border : 1px solid;">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 class="card-title" style="font-size: 25px;"><b>Member Inactive</b></h6>
                          </div>
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 mt-3" title="Create new user">
                  <a href="">
                    <div class="card" style="height: 100px; border : 1px solid;">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 class="card-title" style="font-size: 25px;"><b>Loan Archive</b></h6>
                          </div>
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 mt-3" title="Create new user">
                  <a href="admin_backoffice.php?flag=AddUser">
                    <div class="card" style="height: 100px; border : 1px solid;">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 class="card-title" style="font-size: 25px;"><b>Add User</b></h6>
                          </div>
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>


              </div>
            </fieldset>

            <fieldset <?php //echo ($flag == 'AddUser') ? 'class="active"' : '  ' ?>>
              <h5 class="card-title" style="font-size: 35px;"><b>Add User</b></h5>
              <hr style="margin-top: -10px;">
              <form action="process/proc_newmem.php?inp=1" method="post">
                <div class="row g-3">

                  <div class="col-md-12">
                    <h5 class="card-title" style="font-size: 20px; margin-top: -20px;"><b>Create User</b></h5>
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Name <span class="required">*</span></label>
                    <input type="text" class="form-control letter" name="surname" id="" value="" required placeholder="Name" style="text-transform: capitalize;" tabindex="1">
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Email Address <span class="required">*</span></label>
                    <input type="email" class="form-control" name="surname" id="" value="" required placeholder="Email Address" style="text-transform: capitalize;" tabindex="2">
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Add Role <span class="required">*</span></label>
                    <select name="" id="" class="form-select" tabindex="3">
                      <option selected>Choose User Role</option>
                      <?php 
                        $sqltype = "SELECT * FROM tbaccstats";
                        $stmttype = $conn->prepare($sqltype);
                        $stmttype->execute();
  
                        while($rows = $stmttype->fetch()){
                          echo '<option value="' . $rows['accStatusID'] . '">' . $rows['StatusDesc'] . '</option>';

                        }
                        // echo $rows;

                      ?>

                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Username <span class="required">*</span></label>
                    <input type="email" class="form-control" name="surname" id="" value="" required placeholder="Username" style="text-transform: capitalize;" tabindex="4">
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Password <span class="required">*</span></label>
                    <input type="password" class="form-control" name="surname" id="" value="" required placeholder="Password" tabindex="4">
                  </div>

                  <div class="col-md-4">
                    <label for="lname" class="form-label">Re-type Password <span class="required">*</span></label>
                    <input type="password" class="form-control" name="surname" id="" value="" required placeholder="Password" tabindex="6">
                  </div>

                  <div class="text-end">
                    <input type="button" value="Save" class="btn btn-success" tabindex="7">
                  </div>
                
                </div>
                

              </form>
            </fieldset>

          </div>
        </div>
      </div>  
    </div>
  </section>

</main><!-- End #main -->

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
  <script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
  <script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="jqueryto/sweetalertmoto.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    $(document).on("click", ".card", function(event) {
    const $this = $(this);
    if ($this.find($(event.target).closest("a")[0]).length === 0) {
        event.preventDefault();
        $this.find("a")[0].click();
    }
});

document.addEventListener("DOMContentLoaded", () => {
  echarts.init(document.querySelector("#trafficChart")).setOption({
    tooltip: {
      trigger: 'item'
    },
    legend: {
      top: '5%',
      left: 'center'
    },
    series: [{
      name: 'Access From',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: '18',
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: [{
          value: 1048,
          name: 'Search Engine'
        },
        {
          value: 735,
          name: 'Direct'
        },
        {
          value: 580,
          name: 'Email'
        },
        {
          value: 484,
          name: 'Union Ads'
        },
        {
          value: 300,
          name: 'Video Ads'
        }
      ]
    }]
  });
});


  </script>

<script>
//starting
<?php 
if(isset($_SESSION['creSuc'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Success!',
        text: '<?php echo $_SESSION['creSuc'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['creSuc']); } ?>
//ending

<?php 
if(isset($_SESSION['creErr'])){
    ?>Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Failed!',
        text: '<?php echo $_SESSION['creErr'] ?>',
        timer: 5500
    });    

<?php unset($_SESSION['creErr']); } ?>

</script>

</body>

</html>




<!-- Modal -->
<div class="modal fade" id="printRep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>