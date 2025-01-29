<?php
  // require_once 'cruds/config.php';
  // session_start();

   require_once 'cruds/config.php';
   require_once 'cruds/current_user.php';
 
   if(isset($_SESSION['owner']) || isset($_SESSION['admin'])){

   }else{
     header("Location: login.php");
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

    .cards1{
      background-color: #BAA6FF;
      color: #ffff;
    }
    .cards2{
      background-color: #FFB9A6;
      color:  #ffff;
      font-weight: bolder;
    }
    .cards3{
      background-color: #A6BFFF;
      color: #ffff;
    }
    .cards4{
      background-color: #ADE3BA;
      color: #ffff;
    }
    .cards5{
      background-color: #BAA6FF;
      color: #ffff;
    }
    .cards6{
      background-color: #FFB9A6;
      color: #ffff;
    }
    .cards7{
      background-color: #A6BFFF;
      color: #ffff;
    }
    .cards8{
      background-color: #ADE3BA;
      color: #ffff;
    }
    .cards9{
      background-color: #BAA6FF;
      color: #ffff;
    }
    /* .rounded-circle{
      background-color: rgb(255, 255, 255, 0.5);
    } */

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
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
    
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row g-2">

            <!-- Profit Card -->
            <div class="col-md-4">
              <div class="card info-card member-card cards1">
                <div class="card-body" onclick="this.querySelector('a').click(); return true;">
                  <h5 class="card-title"></h5>
        
                    <a href="admin_profit.php"></a>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash-coin icons"></i>
                    </div>
                    <div class="ps-3" style="margin-left: 10px;">
                    <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Profit</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                  
                </div>
             
              </div>
            </div><!-- End Profit Card -->

            <!-- Deposit Card -->
            <div class="col-md-4">
              <div class="card info-card member-card cards2">

                <div class="card-body " onclick="this.querySelector('a').click(); return true;">
                  <h5 class="card-title"></h5>
                  <a href="admin_deposit.php"></a>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center icons" >
                    <i class="bi bi-wallet-fill icons"></i>
                      <!-- <b class="pesos">&#8369;</b> -->
                    </div>
                    <div class="ps-3" style="margin-left: 10px;">
                    <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Deposit</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                        
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Deposit Card -->

            
             <!-- Revenue Card -->
             <div class="col-md-4">
              <div class="card info-card member-card cards3">

                <div class="card-body" onclick="this.querySelector('a').click(); return true;">
                  <h5 class="card-title"></h5>
                  <a href="admin_revenue.php"></a>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <!-- <b class="pesos">&#8369;</b> -->
                      <i class="bi bi-cash-stack icons"></i>
                    </div>
                    <div class="ps-3" style="margin-left: 10px;">
                    <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Revenue</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Expenses -->
            <div class="col-md-4">
            <div class="card info-card member-card cards4">

              <div class="card-body"  onclick="this.querySelector('a').click(); return true;">
                <h5 class="card-title"><span></span></h5>
                <a href="admin_expenses.php"></a>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people icons"></i>
                  </div>
                  <div class="ps-3" style="margin-left: 10px;">
                  <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Expenses</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                  </div>
                </div>

              </div>

            </div>
            </div>
            <!-- End of Expenses -->

            <!-- MEMBERS -->
            <div class="col-md-4">
              <div class="card info-card member-card cards1">
                <div class="card-body" onclick="this.querySelector('a').click(); return true;">
                  <h5 class="card-title"></h5>
        
                    <a href="admin_profit.php"></a>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash-coin icons"></i>
                    </div>
                    <div class="ps-3" style="margin-left: 10px;">
                    <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Profit</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                  
                </div>
             
              </div>
            </div>
            <!-- END OF MEMBERS -->

            <!-- ANO -->
            <div class="col-md-4">
              <div class="card info-card member-card cards2">
                <div class="card-body" onclick="this.querySelector('a').click(); return true;">
                  <h5 class="card-title"></h5>
        
                    <a href="admin_profit.php"></a>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash-coin icons"></i>
                    </div>
                    <div class="ps-3" style="margin-left: 10px;">
                    <?php
                      // $sql="SELECT SUM(amount) FROM tbdepinfo";
                      // $stmtdep = $conn->prepare($sql);
                      // $stmtdep->execute();
                      // $rowsdep=$stmtdep->fetch();
                      // $deposit = $rowsdep['SUM(amount)'];
                      
                      // $thou = number_format($deposit, 2, '.', ',');
                      // echo'<h5 class="" style="font-weight:850;">Profit</h5>';
                      // echo'<h6 style="color:white; font-size:25px;">' . $thou . '</h6>';
                      ?>
                       <div class="progress" style="height: 3px; margin-top: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 5%; background-color:white;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                  
                </div>
             
              </div>
            </div>
            <!-- END OF ANO -->

            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div>

            <!-- <div class="card col-md-4" style="margin-left:12px;">

            <div class="card-body" style="padding: 50px;">
              <canvas id="pieChart" style="max-height: 300px;"></canvas>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#pieChart'), {
                    type: 'pie',
                    data: {
                      labels: [
                        'Active Members',
                        'Approved Members',
                        'On-Going Members',
                        'Pending Members',
                        'Removed Members'
                      ],
                      datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100, 90, 40],
                        backgroundColor: [
                          '#FFC6D6',
                          '#FEF8E6',
                          '#E3E9BE',
                          '#E1B8E7',
                          '#FFE1DC'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });
              </script>

            </div>
        </div> -->

        <!-- <div class="card col-md-6" style="margin-left:20px;">
          <div class="card-body">
            <div id="bubbleChart" style="min-height: 400px;" class="echart"></div>

              <script>
              document.addEventListener("DOMContentLoaded", () => {
                const data = [
                  [
                    [28604, 77, 17096869, 'Australia', 1990],
                    [31163, 77.4, 27662440, 'Canada', 1990],
                    [1516, 68, 1154605773, 'China', 1990],
                    [13670, 74.7, 10582082, 'Cuba', 1990],
                    [28599, 75, 4986705, 'Finland', 1990],
                    [29476, 77.1, 56943299, 'France', 1990],
                    [31476, 75.4, 78958237, 'Germany', 1990],
                    [28666, 78.1, 254830, 'Iceland', 1990],
                    [1777, 57.7, 870601776, 'India', 1990],
                    [29550, 79.1, 122249285, 'Japan', 1990],
                    [2076, 67.9, 20194354, 'North Korea', 1990],
                    [12087, 72, 42972254, 'South Korea', 1990],
                    [24021, 75.4, 3397534, 'New Zealand', 1990],
                    [43296, 76.8, 4240375, 'Norway', 1990],
                    [10088, 70.8, 38195258, 'Poland', 1990],
                    [19349, 69.6, 147568552, 'Russia', 1990],
                    [10670, 67.3, 53994605, 'Turkey', 1990],
                    [26424, 75.7, 57110117, 'United Kingdom', 1990],
                    [37062, 75.4, 252847810, 'United States', 1990]
                  ],
                  [
                    [44056, 81.8, 23968973, 'Australia', 2015],
                    [43294, 81.7, 35939927, 'Canada', 2015],
                    [13334, 76.9, 1376048943, 'China', 2015],
                    [21291, 78.5, 11389562, 'Cuba', 2015],
                    [38923, 80.8, 5503457, 'Finland', 2015],
                    [37599, 81.9, 64395345, 'France', 2015],
                    [44053, 81.1, 80688545, 'Germany', 2015],
                    [42182, 82.8, 329425, 'Iceland', 2015],
                    [5903, 66.8, 1311050527, 'India', 2015],
                    [36162, 83.5, 126573481, 'Japan', 2015],
                    [1390, 71.4, 25155317, 'North Korea', 2015],
                    [34644, 80.7, 50293439, 'South Korea', 2015],
                    [34186, 80.6, 4528526, 'New Zealand', 2015],
                    [64304, 81.6, 5210967, 'Norway', 2015],
                    [24787, 77.3, 38611794, 'Poland', 2015],
                    [23038, 73.13, 143456918, 'Russia', 2015],
                    [19360, 76.5, 78665830, 'Turkey', 2015],
                    [38225, 81.4, 64715810, 'United Kingdom', 2015],
                    [53354, 79.1, 321773631, 'United States', 2015]
                  ]
                ];
                echarts.init(document.querySelector("#bubbleChart")).setOption({
                  legend: {
                    right: '10%',
                    top: '3%',
                    data: ['1990', '2015']
                  },
                  grid: {
                    left: '8%',
                    top: '10%'
                  },
                  xAxis: {
                    splitLine: {
                      lineStyle: {
                        type: 'dashed'
                      }
                    }
                  },
                  yAxis: {
                    splitLine: {
                      lineStyle: {
                        type: 'dashed'
                      }
                    },
                    scale: true
                  },
                  series: [{
                      name: '1990',
                      data: data[0],
                      type: 'scatter',
                      symbolSize: function(data) {
                        return Math.sqrt(data[2]) / 5e2;
                      },
                      emphasis: {
                        focus: 'series',
                        label: {
                          show: true,
                          formatter: function(param) {
                            return param.data[3];
                          },
                          position: 'top'
                        }
                      },
                      itemStyle: {
                        color: 'rgb(251, 118, 123)'
                      }
                    },
                    {
                      name: '2015',
                      data: data[1],
                      type: 'scatter',
                      symbolSize: function(data) {
                        return Math.sqrt(data[2]) / 5e2;
                      },
                      emphasis: {
                        focus: 'series',
                        label: {
                          show: true,
                          formatter: function(param) {
                            return param.data[3];
                          },
                          position: 'top'
                        }
                      },
                      itemStyle: {
                        color: 'rgb(129, 227, 238)'
                      }
                    }
                  ]
                });
              });
              </script>
          </div>
        </div> -->


        </div>
      </div><!-- End Left side columns -->

      <!-- Right Side Columns -->
      <div class="col-lg-4">

        <div class="card">
          <div class="card-body" style="max-height: 313px;">
            
            <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div><!-- End activity item-->

              </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body" style="height: 460px;">
            <h1>INTERPRETATION OF REGRESSION</h1>
          </div>
        </div>

      </div>
      <!-- Right Side Columns -->

      
      <div class="col-lg-6">

        <!-- TABLE -->
        <div class="card">
          <div class="card-body" style="padding:30px;">
            <div class="card-title mt-4" style="text-align:center;">MEMBERS IN GOOD STANDING</div>
          <div class="col-md-12">
          
          <table class="table table-striped">

          <thead>
              <td>ID</td>
              <td>NAME</td>
              <td>REMARKS</td>
          </thead>

          <tbody>

          <tr>
            <td>20240001</td>
            <td>Pia MABUTIN</td>
            <td>GOLD</td>
          </tr>
          <tr>
            <td>20240002</td>
            <td>Justice Bellen</td>
            <td>GOLD</td>
          </tr>
          <tr>
            <td>20240003</td>
            <td>Arabela Gregorio</td>
            <td>GOLD</td>
          </tr>
          <tr>
            <td>20240004</td>
            <td>Den Mark Quibol</td>
            <td>GOLD</td>
          </tr>
          <tr>
            <td>20240005</td>
            <td>Dyno Olila</td>
            <td>GOLD</td>
          </tr>
          <tr>
            <td>20240006</td>
            <td>Dreb Arellano</td>
            <td>GOLD</td>
          </tr>

          </tbody>
          
          </table>

        </div>
          </div>
        </div>
        <!-- END OF TABLE -->

      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title mt-4" style="text-align:center; height: 408px;">PUT INSIGHTS HERE</div>

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



// $(document).ready(function(){
//   $('ul li a').click(function(){
//     $('li a').removeClass("collapsed");
//     $(this).addClass("active");
// });
// });

  </script>

</body>

</html>