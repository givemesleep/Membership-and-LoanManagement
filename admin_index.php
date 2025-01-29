<?php
  // require_once 'cruds/config.php';
  // session_start();

   require_once 'cruds/config.php';
   require_once 'cruds/current_user.php';
   require_once 'process/func_func.php';
 
   if(isset($_SESSION['owner']) || isset($_SESSION['admin'])){

   }else{
     header("Location: login.php");
   }

  $memToday = $memCount = '';
  $sqlToday = "SELECT COUNT(*) AS NUM FROM tbperinfo WHERE ApplyDate = CURDATE()";
  $stmtToday = $conn->prepare($sqlToday);
  $stmtToday->execute();
  $rowToday = $stmtToday->fetch(PDO::FETCH_ASSOC);
  $memToday = $rowToday["NUM"];

  $sqlCount = "SELECT COUNT(*) AS NUM FROM tbperinfo WHERE memstatID = 1";
  $stmtCount = $conn->prepare($sqlCount);
  $stmtCount->execute();
  $rowCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
  $memCount = $rowCount["NUM"];

  $lnpending = "SELECT COUNT(memlnID) AS pending FROM tbloaninfo WHERE lnstatID = 2";
  $stmtlnpending = $conn->prepare($lnpending);
  $stmtlnpending->execute();
  $rowlnpending = $stmtlnpending->fetch(PDO::FETCH_ASSOC);
  $lnpending = $rowlnpending["pending"]; 
  
  $lnactive = "SELECT COUNT(memlnID) AS pending FROM tbloaninfo WHERE lnstatID = 1";
  $stmtlnactive = $conn->prepare($lnactive);
  $stmtlnactive->execute();
  $rowlnactive = $stmtlnactive->fetch(PDO::FETCH_ASSOC);
  $lnactive = $rowlnactive["pending"]; 

  $lnInfo = "SELECT SUM(lnTotMos) AS OvBal, SUM(lnTotPay) AS OvPaid, SUM(lnTotPen) AS OvPen
            FROM tbloaninfo WHERE lnstatID = 1 AND isActivate = 1";
  $stmtlnInfo = $conn->prepare($lnInfo);
  $stmtlnInfo->execute();
  $rowlnInfo = $stmtlnInfo->fetch(mode: PDO::FETCH_ASSOC);
  $OvPen = $rowlnInfo["OvPen"];
  $OvBal = $rowlnInfo["OvBal"];
  $OvPaid = $rowlnInfo["OvPaid"];

  $newBal = $OvBal - $OvPaid;
  

  $today = new DateTime();
  $today = $today->format('F d, Y');

  $sqlPayee = "SELECT DATE(loanMonthPay) AS NextPay, NOW() AS TODAY, COUNT(*) AS payee, DATE(loanMaturity) AS ln FROM tbloaninfo";
  $stmtPayee = $conn->prepare($sqlPayee);
  $stmtPayee->execute();
  $rowPayee = $stmtPayee->fetch(PDO::FETCH_ASSOC);
  $payee = $rowPayee["payee"];
  $nexPay = $rowPayee["NextPay"];
  $todays = $rowPayee["TODAY"];
  $ln = $rowPayee["ln"];
  
  $my_date = date('Y-m-d',strtotime($nexPay));
  // echo $ln;
  
  if($todays > $my_date){
      // echo "Add penalty";
      $months = new DateTime($nexPay);
      $months->modify('+1 month');
      $newMonth = $months->format('Y-m-d');
      
      $sqlPen = "UPDATE tbloaninfo SET lnTotPen = lnMonInt + lnTotPen, lnTotMos = lnTotMos + lnMonInt, loanMonthPay = ? WHERE DATE(loanMonthPay) < DATE(NOW()) AND lnstatID = 1 AND remarks = 0";
      $dataPen = array($newMonth);
      $stmtPen = $conn->prepare($sqlPen);
      $stmtPen->execute($dataPen);

      
  }elseif($my_date > $ln){
      // echo "Update Status Overdue";
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
.body-cards{
  background-color: rgba(246, 249, 255, 1);
}
/* .card-title{  
  color: white;
  font-size: 20px;
} */
.card-footer{
  height: 10px;
}
.icons{
  font-size: 65px;
}
.pesos{
  color: green;
}
.num{
  font-size: 15px;
}
.nav{
  color: #000;
}
    /* From Uiverse.io by 3bdel3ziz-T */ 
.select {
  width: fit-content;
  cursor: pointer;
  position: relative;
  transition: 300ms;
  color: white;
  overflow: hidden;
}

.selected {
  background-color: #2a2f3b;
  padding: 5px;
  margin-bottom: 3px;
  border-radius: 5px;
  position: relative;
  z-index: 100000;
  font-size: 15px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.arrow {
  position: relative;
  right: 0px;
  height: 10px;
  transform: rotate(-90deg);
  width: 25px;
  fill: white;
  z-index: 100000;
  transition: 300ms;
}

.options {
  display: flex;
  flex-direction: column;
  border-radius: 5px;
  padding: 5px;
  background-color: #2a2f3b;
  position: relative;
  top: -100px;
  opacity: 0;
  transition: 300ms;
}

.select:hover > .options {
  opacity: 1;
  top: 0;
}

.select:hover > .selected .arrow {
  transform: rotate(0deg);
}

.option {
  border-radius: 5px;
  padding: 5px;
  transition: 300ms;
  background-color: #2a2f3b;
  width: 150px;
  font-size: 15px;
}
.option:hover {
  background-color: #323741;
}

.options input[type="radio"] {
  display: none;
}

.options label {
  display: inline-block;
}
.options label::before {
  content: attr(data-txt);
}

.options input[type="radio"]:checked + label {
  display: none;
}

.options input[type="radio"]#all:checked + label {
  display: none;
}

.select:has(.options input[type="radio"]#all:checked) .selected::before {
  content: attr(data-default);
}
.select:has(.options input[type="radio"]#option-1:checked) .selected::before {
  content: attr(data-one);
}
.select:has(.options input[type="radio"]#option-2:checked) .selected::before {
  content: attr(data-two);
}
.select:has(.options input[type="radio"]#option-3:checked) .selected::before {
  content: attr(data-three);
}
.fieldset{
  display: none;
}
.fieldset.active{
  display: block;
}


  </style>

  <!-- sidenav  -->
<?php 
    require_once 'sidenavs/headers.php';
    $pages = 'index'; $nav='indexes'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-md-10 text-start">
                <h5 class="card-title" style="font-size: 35px;"><b>Dashboard</b></h5>
              </div>

              <div class="col-md-2 mt-4 text-end">
                  <!-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                    </div> -->
                <select name="" id="options" class="form-select w-75" onchange="changeFieldset()" style="margin-left: 50px;">
                  <option selected value="today">Today</option>
                  <option value="month">This Month</option>
                  <option value="year">This Year</option>
                </select>
              </div>
            </div>

            <fieldset id="today" class="active fieldset">
              <div class="row">

                <hr>

                  <div class="col-md-8 text-start">
                    <h5 class="card-title" style="font-size: 25px; margin-top: -20px;"><b>Overview</b></h5>
                  </div>
                  
                  <div class="col-md-4 text-end">
                  <!-- <a href=""><button class="btn btn-dark">View Statistics</button></a> -->
                    <!-- <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#printRep">Report</button> -->
                    <!-- <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#printRep"><i class="bi bi-gear-fill"></i></button> -->
                    <a href="admin_backoffice.php?pages=Account"><button class="btn btn-outline-dark"><i class="bi bi-gear-fill"></i></button></a>
                  </div>

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                        <h6 class="card-title" style="font-size: 17px;"><b>Total of Unpaid Balance</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b>&#x20B1;&nbsp;<?php echo shortValue($newBal); ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                        <h6 class="card-title" style="font-size: 17px;"><b>Total of Paid Balance</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b>&#x20B1;&nbsp;<?php echo shortValue($OvPaid); ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>  

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                        <h6 class="card-title" style="font-size: 17px;"><b>Total of Loan Amount Penalty</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-start mt-3">
                            <h6 style="font-size: 30px;"><b>&#x20B1;&nbsp;<?php echo shortValue($OvPen); ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                        <h6 class="card-title" style="font-size: 17px;"><b>Total of Member Active Loan</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 style="font-size: 30px;"><span><i class="bi bi-patch-check-fill text-primary"></i></span>&nbsp;&nbsp;<b><?php echo $lnactive; ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                        <h6 class="card-title" style="font-size: 17px;"><b>Total of Member Pending Loan</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 style="font-size: 30px;"><span><i class="bi bi-calendar2-week-fill text-warning"></i></span>&nbsp;&nbsp;<b><?php echo $lnpending; ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 ">
                    <div class="card" style="height: 200px; border : 1px solid;">
                      <div class="card-body">
                      <h6 class="card-title" style="font-size: 17px;"><b>Total Number of Membership</b></h6>
                        <div class="row">
                          <div class="col-md-12 text-center mt-3">
                            <h6 style="font-size: 30px;"><span><i class="bi bi-people-fill" style="color: #70E000;"></i></span>&nbsp;&nbsp;<b><?php echo $memCount; ?></b></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-start">
                    <h5 class="card-title" style="font-size: 35px; margin-top: -20px;"><b>Activity</b></h5>
                  </div>

                  <ul class="nav" id="borderedTab" role="tablist" style="border: none; margin-top: -15px;">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Analytics</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Payment</button>
                    </li>
                  </ul>

                  <hr style="margin-top: 10px;">

                  <div class="tab-content pt-2" id="borderedTabContent">
                    <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                      <div class="row mt-3">

                        <div class="col-md-6 mb-3">
                          <div class="card" style="border: 1px solid; height:460px;">
                            <div class="card-body">
                              <h5 style="font-size: 25px;" class="card-title text-start"><b>No. of Membership</b></h5>
                              <hr style="margin-top: -15px;">
                              <div id="pieChart" style="min-height: 400px;" class="echart"></div>
                              
                                <?php 

                                $approved = $Pending = $Removed = '';

                                $sqlMember = "SELECT COUNT(memberID) AS Approved FROM tbperinfo WHERE memstatID = 1";
                                $stmtMember = $conn->prepare($sqlMember);
                                $stmtMember->execute();
                                $rowMember = $stmtMember->fetch(PDO::FETCH_ASSOC);
                                $approved = $rowMember["Approved"];

                                $sqlPending = "SELECT COUNT(memberID) AS Pending FROM tbperinfo WHERE memstatID = 2 OR memstatID = 3 ";
                                $stmtPending = $conn->prepare($sqlPending);
                                $stmtPending->execute();
                                $rowPending = $stmtPending->fetch(PDO::FETCH_ASSOC);
                                $Pending = $rowPending["Pending"];

                                $sqlRemoved = "SELECT COUNT(memberID) AS Removed FROM tbperinfo WHERE memstatID = 4";
                                $stmtRemoved = $conn->prepare($sqlRemoved);
                                $stmtRemoved->execute();
                                $rowRemoved = $stmtRemoved->fetch(PDO::FETCH_ASSOC);
                                $Removed = $rowRemoved["Removed"];

                                ?>

                                <script>
                                  document.addEventListener("DOMContentLoaded", () => {
                                    echarts.init(document.querySelector("#pieChart")).setOption({
                                      
                                      tooltip: {
                                        trigger: 'item'
                                      },
                                      legend: {
                                        orient: 'vertical',
                                        left: 'left'
                                      },
                                      series: [{
                                        name: 'Member Status',
                                        type: 'pie',
                                        radius: '60%',
                                        data: [{
                                            value: <?php echo $approved; ?>,
                                            name: 'Approved'
                                          },
                                          {
                                            value: <?php echo $Pending; ?>,
                                            name: 'Pending'
                                          },
                                          {
                                            value: <?php echo $Removed; ?>,
                                            name: 'Removed'
                                          }
                                        ],
                                        emphasis: {
                                          itemStyle: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                          }
                                        }
                                      }]
                                    });
                                  });
                              </script>
                              
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="card" style="border: 1px solid; height:460px;">
                            <div class="card-body">
                            <h5 style="font-size: 25px;" class="card-title text-start"><b>Column Chart</b></h5>
                            <div id="columnChart"></div>

                            <script>
                              document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#columnChart"), {
                                  series: [{
                                    name: 'Outstanding Balance',
                                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                                  }, {
                                    name: 'Amount Repaid',
                                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                                  }, {
                                    name: 'Amount Overdue',
                                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                                  }],
                                  chart: {
                                    type: 'bar',
                                    height: 350
                                  },
                                  plotOptions: {
                                    bar: {
                                      horizontal: false,
                                      columnWidth: '55%',
                                      endingShape: 'rounded'
                                    },
                                  },
                                  dataLabels: {
                                    enabled: false
                                  },
                                  stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ['transparent']
                                  },
                                  xaxis: {
                                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                                  },
                                  yaxis: {
                                    title: {
                                      text: '$ (thousands)'
                                    }
                                  },
                                  fill: {
                                    opacity: 1
                                  },
                                  tooltip: {
                                    y: {
                                      formatter: function(val) {
                                        return "$ " + val + " thousands"
                                      }
                                    }
                                  }
                                }).render();
                              });
                            </script>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                    
                      <h6 class="card-title" style="font-size: 20px; margin-top: -20px;">Amortization Payment</h6>
                      <div class="col-md-6">
                        <p>As of <b><?php echo $today; ?></b> there are <b><?php echo $payee; ?></b> expecting of payee today</p>
                      </div>
                      <table class="table datatable">
                        <thead>
                          <tr>
                            <th>Loan ID</th>
                            <th>Loan Status</th>
                            <th>Outstanding Balance</th>
                            <th>Compensate Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          
                              $sqlToday = "SELECT * FROM tbloaninfo WHERE DATE(loanMonthPay) = DATE(NOW()) AND lnstatID = 1 AND remarks = 0 AND isActivate = 1";
                              $stmtToday = $conn->prepare($sqlToday);
                              $stmtToday->execute();
                              $table = '';

                              while($rowToday = $stmtToday->fetch(PDO::FETCH_ASSOC)){
                                $loanID = $rowToday["lnunID"];
                                $loanStat = ($rowToday["lnstatID"] == 1) ? 'Active' : 'Pending' ;
                                $loanBal = number_format($rowToday["lnPrincipal"] + $rowToday["lnMonInt"], "2", ".", ",");
                                $loanPay = number_format($rowToday["lnMonInt"], "2", ".", ",");
                                $loanPen = $rowToday["lnTotPen"];
                                $loanComp = $loanBal + $loanPay + $loanPen;


                                $table .= '
                                <tr>
                                <td>'. $loanID .'</td>
                                <td>'. $loanStat .'</td>
                                <td>₱ '. $loanBal .'</td>
                                <td>₱ '. $loanPay .'</td>
                                </tr>
                                ';


                              }
                          
                              echo $table;
                          
                          ?>
                        </tbody>
                      </table>
                  
                    </div>
                  </div>

                  


                </div>
            </fieldset>

            <fieldset id="month" class="fieldset">
              <div class="row">
                <div class="col-md-12">
                  <h5>Sheeesh</h5>
                </div>
              </div>
            </fieldset>

            <fieldset id="year" class="fieldset">
              Badtrip
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
  <script src="jqueryto/ajaxmoto.js"></script>
  <script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
  <script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    function changeFieldset() {
        var selectedValue = document.getElementById('options').value;
        var fieldsets = document.querySelectorAll('.fieldset');
        fieldsets.forEach(function(fieldset) {
            fieldset.style.display = 'none';
        });
        if (selectedValue) {
            document.getElementById(selectedValue).style.display = 'block';
        }else{
          document.getElementById(selectedValue).style.display = 'none';
        }
    }
  </script>

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

</body>

</html>


<!-- Modal -->
<div class="modal fade" id="printRep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Settings</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> -->
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
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>