<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';
    require_once 'process/func_func.php';

    $key = "LLAMPCO";
    $viewmem = $memberID = "";
    //Basic
    $lname = $fname = $mname = $suffix = $nickname = $bdate = $age = $sex = $marital = $maritalID = '';
    //Contact
    $house = $reg = $prov = $mun = $brgy = $zip = $email = $mobile1 = $mobile2 = $landline = '';
    //Personal
    $high = $prog = $schlName = $bus = $busType = $occu = $comp = $monthly = '';
    //ID
    $sss = $tin = $otherID = $otherIDNo = '';
    //PMES
    $ref = $train = $app = $join = '';
    //Others
    $resi = $resiID = $resyear = $coop = $soc = $hob = '';
    if(isset($_GET['viewmem'])){
        $viewmem = decrypt($_GET['viewmem'], $key);

        $sqlID = "SELECT * FROM tbuninfo WHERE unID = ?";
        $dataID = array($viewmem);
        $stmtID = $conn->prepare($sqlID);
        $stmtID->execute($dataID);
        $rowID = $stmtID->fetch(PDO::FETCH_ASSOC);
        $memberID = $rowID['memberID'];

        $sqlbasic = "SELECT * FROM tbperinfo WHERE memberID = ?";
        $databasic = array($memberID);
        $stmtbasic = $conn->prepare($sqlbasic);
        $stmtbasic->execute($databasic);
        $rowbasic = $stmtbasic->fetch(PDO::FETCH_ASSOC);

        $lname = $rowbasic['memSur']; $fname = $rowbasic['memGiven']; $mname = $rowbasic['memMiddle']; 
        $suffix = $rowbasic['suffixes']; $nickname = $rowbasic['memNick']; $bdate = $rowbasic['memDOB'];
        $age = bday($bdate); $sex = $rowbasic['gendID']; $maritalID = $rowbasic['maritID'];

        $sqlMarit = "SELECT * FROM tbmaritals WHERE maritID = ?";
        $dataMarit = array($maritalID);
        $stmtMarit = $conn->prepare($sqlMarit);
        $stmtMarit->execute($dataMarit);
        $rowMarit = $stmtMarit->fetch(PDO::FETCH_ASSOC);
        $marital = $rowMarit['marDep'];

        $sqlcontact = "SELECT * FROM tbconinfo WHERE memberID = ?";
        $datacontact = array($memberID);
        $stmtcontact = $conn->prepare($sqlcontact);
        $stmtcontact->execute($datacontact);
        $rowcontact = $stmtcontact->fetch(PDO::FETCH_ASSOC);
        //memaddr region province city brgy zipcode memmob1 memmob2 landline mememail
        $house = $rowcontact['memaddr']; $reg = $rowcontact['region']; $prov = $rowcontact['province']; $mun = $rowcontact['city'];
        $brgy = $rowcontact['brgy']; $zip = $rowcontact['zipcode']; $email = $rowcontact['mememail']; $mobile1 = $rowcontact['memmob1'];
        $mobile2 = $rowcontact['memmob2']; $landline = $rowcontact['memlan']; $email = $rowcontact['mememail'];

        $sqleduc = "SELECT highest, program, schlName FROM tbeducinfo WHERE memberID = ?";
        $dataeduc = array($memberID);
        $stmteduc = $conn->prepare($sqleduc);
        $stmteduc->execute($dataeduc);
        $roweduc = $stmteduc->fetch(PDO::FETCH_ASSOC);
        $high = $roweduc['highest']; $prog = $roweduc['program']; $schlName = $roweduc['schlName'];

        $sqlEmp = "SELECT 
                    wi.memBusInfo AS Business, wi.memBusType AS BusinessType, 
                    wi.memOccuInfo AS Occupation, wi.memCompName AS CompanyName, 
                    mon.monthlySize AS MonthlyIncome
                FROM tbworkinfo wi
                JOIN tbmonthly mon ON wi.monthlyID = mon.monthlyID  
                WHERE wi.memberID = ?";
        $dataEmp = array($memberID);
        $stmtEmp = $conn->prepare($sqlEmp);
        $stmtEmp->execute($dataEmp);
        $rowEmp = $stmtEmp->fetch(PDO::FETCH_ASSOC);
        $bus = $rowEmp['Business']; $busType = $rowEmp['BusinessType']; $occu = $rowEmp['Occupation'];
        $comp = $rowEmp['CompanyName']; $monthly = $rowEmp['MonthlyIncome'];

        $sqlIDs = "SELECT
                    id.SSSno AS SSS, id.taxIdenNo AS TIN,
                    i.typeDesc AS OtherID, id.idTypeNo AS OtherNo
                FROM tbidinfo id
                LEFT JOIN tbids i ON id.idTypesID = i.idTypesID
                WHERE memberID = ?";
        $dataIDs = array($memberID);
        $stmtIDs = $conn->prepare($sqlIDs);
        $stmtIDs->execute($dataIDs);
        $rowIDs = $stmtIDs->fetch(PDO::FETCH_ASSOC);
        $sss = $rowIDs['SSS']; $tin = $rowIDs['TIN']; 
        $otherID = $rowIDs['OtherID']; $otherIDNo = $rowIDs['OtherNo'];

        //PMES


        $sqlOth = "SELECT
                    res.resiStatus AS resiStats, inf.InfoStats AS infoStats, 
                    oth.yearStay AS yearStay, oth.socint AS social,
                    oth.hobbies AS hobbies, oth.coop AS cooperative
                FROM tbotherinfo oth
                LEFT JOIN tbresistats res ON oth.resID = res.resID
                LEFT JOIN tbinfostats inf ON oth.othInfoID = inf.othInfoID 
                WHERE oth.memberID = ?";
        $dataOth = array($memberID);
        $stmtOth = $conn->prepare($sqlOth);
        $stmtOth->execute($dataOth);
        $rowOth = $stmtOth->fetch();

        $resi = $rowOth['resiStats']; $resiID = $rowOth['infoStats']; $resyear = $rowOth['yearStay']; 
        $coop = $rowOth['cooperative']; $soc = $rowOth['social']; $hob = $rowOth['hobbies'];

    }
?>  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | Masterlist</title>
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
    #headline{
        background : #3c7dbc; 
        color:aliceblue; 
        border-radius:10px; 
        height: 35px; 
        padding-top:3px;
    }
    .required{
      color:red;
    }
    form label{
      font-weight: 600;
    }
    fieldset {
    display: none;
    }
    fieldset.active {
    display: block;
    }
    .gosh{
        margin-top: 50px;
        padding-left: 250px;
        padding-right: 250px;
    }
    .centered-label{
        text-align: center;
    }
    .step1{
        text-align: center;
    }
    footer{
        text-align: center;
    }
</style>

<body class="d-flex flex-column min-vh-100">

<?php 
  require_once 'sidenavs/headers.php';
  $pages = 'app';  $nav = 'membership'; require_once 'sidenavs/admin_side.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item">Membership Accounts</li>
              <li class="breadcrumb-item active">View Member</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">

    <div class="col-lg-3">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        
                        <div class="col-md-12 mt-3">
                            <a href="admin_masterlist.php"><button class="btn btn-dark" style="opacity : 0.6;"><span class="bi bi-arrow-return-left"></span></button></a>  
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <img src="assets/img/default.png" alt="Profile" class="rounded-circle">  
                        </div>

                        <div class="col-md-6 mt-3 text-start">
                            <p>Member ID</p>
                        </div>

                        <div class="col-md-6 mt-3 text-end">
                            <h6><b><?php echo $viewmem; ?></b></h6>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <h6><b><?php echo $lname.', '. $fname.' '.$mname.' '.$suffix?></b></h6>
                        </div>
                        
                        <div class="col-md-12 text-center">
                            <p>Full Name</p>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <h6><b><?php  ?></b></h6>
                        </div>

                        <div class="col-md-12 mt-2 text-center">
                            <p>Status</p>
                        </div>
                    
                    </div>
                
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">

                    <div class="row mt-3">

                        <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="member" data-bs-toggle="tab" data-bs-target="#meminfo" type="button" role="tab" aria-controls="home" aria-selected="true">Member Details</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="trans" data-bs-toggle="tab" data-bs-target="#translog" type="button" role="tab" aria-controls="profile" aria-selected="false">Transaction Logs</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2" id="borderedTabContent">
                            
                            <div class="tab-pane fade show active" id="meminfo" role="tabpanel" aria-labelledby="member">

                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100 active" id="basic" data-bs-toggle="tab" data-bs-target="#basicinfo" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="contact" data-bs-toggle="tab" data-bs-target="#contactinfo" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="personal" data-bs-toggle="tab" data-bs-target="#personalinfo" type="button" role="tab" aria-controls="personal" aria-selected="false">Personal</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="ids" data-bs-toggle="tab" data-bs-target="#idsinfo" type="button" role="tab" aria-controls="ids" aria-selected="false">Identification</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="pmes" data-bs-toggle="tab" data-bs-target="#pmesinfo" type="button" role="tab" aria-controls="pmes" aria-selected="false">PMES</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="others" data-bs-toggle="tab" data-bs-target="#othersinfo" type="button" role="tab" aria-controls="others" aria-selected="false">Others</button>
                                    </li>
                                </ul>

                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                            
                                    <div class="tab-pane fade show active" id="basicinfo" role="tabpanel" aria-labelledby="basic">
                                        
                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Basic Information</b></h4>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Last Name</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $lname; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Birthdate</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $bdate; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>First Name</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $fname; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Age</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $age; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Middle Name</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $mname; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Marital Status</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $marital; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Suffix</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $suffix; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Sex</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo ($sex == 1) ? 'Female' : 'Male' ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Nickname</h6>
                                            </div>   
                                            
                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $nickname; ?></b></h6>
                                            </div>
                                            

                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="contactinfo" role="tabpanel" aria-labelledby="contact">
                                    
                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Contact Information</b></h4>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>House Address</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $house; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Email Address</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $email ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Region</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $reg; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>(1)Mobile #</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $mobile1; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Province</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $prov; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>(2)Mobile #</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $mobile2; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Municipality</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $mun; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Landline</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $landline; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Baranggay</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $brgy; ?></b></h6>
                                            </div>

                                            <div class="col-md-6"></div>

                                            <div class="col-md-3 text-start">
                                                <h6>ZIP Code</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $zip; ?></b></h6>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="personalinfo" role="tabpanel" aria-labelledby="personal">
                                        
                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Personal Information</b></h4>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>Highest Level</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo $high; ?></b></h6>
                                            </div>
                                            <!-- $bus = $busType = $occu = $comp = $monthly =  -->
                                            <div class="col-md-2 text-start">
                                                <h6>Business</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo ($bus == '') ? ' ': $bus ?></b></h6>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>Company</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo ($comp == '') ? ' ': $comp ?></b></h6>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>School Name</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo $schlName; ?></b></h6>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>Business Type</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo ($busType == '') ? ' ': $busType ?></b></h6>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>Occupation</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo ($occu == '') ? ' ': $occu ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Program</h6>
                                            </div>   

                                            <div class="col-md-5 text-end">
                                                <h6><b><?php echo ($prog == 'N/A') ? ' ' : $prog  ?></b></h6>
                                            </div>

                                            <div class="col-md-2 text-start">
                                                <h6>Monthly Income</h6>
                                            </div>   

                                            <div class="col-md-2 text-end">
                                                <h6><b><?php echo ($monthly == 0) ? ' ' : $monthly ?></b></h6>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="idsinfo" role="tabpanel" aria-labelledby="ids">
                                        
                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Identification(ID)</b></h4>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>(SSS)Social Security No.</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php echo $sss;?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>(TIN)Tax Identification No.</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php echo $tin; ?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Other ID</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php echo $otherID; ?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Other ID No</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php echo $otherIDNo; ?></b></h6>
                                            </div>

                                        </div>

                                    </div>
<!-- //  -->
                                    <div class="tab-pane fade" id="pmesinfo" role="tabpanel" aria-labelledby="pmes">
                                        
                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Pre-Membership Seminar Education</b></h4>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Trained By</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php ?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Referred By</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php ?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Approved By</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php ?></b></h6>
                                            </div>

                                            <div class="col-md-4 text-start">
                                                <h6>Joined Date</h6>
                                            </div>   

                                            <div class="col-md-8 text-start">
                                                <h6><b><?php ?></b></h6>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="othersinfo" role="tabpanel" aria-labelledby="others">

                                        <div class="row">

                                            <div class="col-md-12 mt-4 mb-4 text-center">
                                                <h4 id="headline"><b>Other Information</b></h4>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Residential Status</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $resiID; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Social Interest</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $soc; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Residential Ownership</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $resi; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 text-start">
                                                <h6>Hobbies</h6>
                                            </div>   

                                            <div class="col-md-3 text-end">
                                                <h6><b><?php echo $hob; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 mb-5 text-start">
                                                <h6>Residing Year</h6>
                                            </div>   

                                            <div class="col-md-3 mb-5 text-end">
                                                <h6><b><?php echo $resyear; ?></b></h6>
                                            </div>

                                            <div class="col-md-3 mb-5 text-start">
                                                <h6>Other Coop</h6>
                                            </div>   

                                            <div class="col-md-3 mb-5 text-end">
                                                <h6><b><?php echo $coop; ?></b></h6>
                                            </div>

                                            

                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="translog" role="tabpanel" aria-labelledby="trans">
                                <!-- Bordered Tabs Justified -->
                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                
                                    <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 active" id="deplog" data-bs-toggle="tab" data-bs-target="#depositlogs" type="button" role="tab" aria-controls="home" aria-selected="true">Deposit Logs</button>
                                    </li>

                                    <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="loanlog" data-bs-toggle="tab" data-bs-target="#loanlogs" type="button" role="tab" aria-controls="profile" aria-selected="false">Loan Logs</button>
                                    </li>
                                
                                </ul>
                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">

                                    <div class="tab-pane fade show active" id="depositlogs" role="tabpanel" aria-labelledby="deplog">

                                        <table class="table table-hover mt-3">
                                            <thead style="width : 100%;">
                                                <th scope="col" style="width: 5%;">#</th>
                                                <th scope="col" style="width: 15%;">Deposit</th>
                                                <th scope="col"  style="width: 15%;">Amount</th>
                                                <th scope="col"  style="width: 15%;">Invoice #</th>
                                                <th scope="col"  style="width: 15%;">Cheque #</th>
                                                <th scope="col"  style="width: 15%;">Date</th>
                                                <th scope="col"  style="width: 15%;">Time</th>
                                            </thead>
                                            <tbody style="width : 100%;">
                                                <?php 
                                                
                                                    $sqlDephis = "SELECT
                                                                    d.depDesc AS DepType, di.amount AS DepAm, 
                                                                    di.InvoiceNo AS inv, di.CheckRef AS chq,
                                                                    di.depDate AS DayPay, di.depTime AS DayTime
                                                                FROM tbdephisinfo di
                                                                JOIN tbdeptype d ON di.deptypeID = d.deptypeID
                                                                WHERE memberID = ? ORDER BY di.depTime DESC 
                                                                LIMIT 5";
                                                    $dataDephis = array($memberID);
                                                    $stmtDephis = $conn->prepare($sqlDephis);
                                                    $stmtDephis->execute($dataDephis);
                                                    $i = 1;
                                                    $table = '';
                                                    while($rowDephis = $stmtDephis->fetch()){
                                                        // $depType = $rowDephis['DepType']; $depAm = $rowDephis['DepAm'];
                                                        // $inv = $rowDephis['inv']; $chq = $rowDephis['chq']; $TD = $rowDephis['TD'];
                                                        $table .= '<tr>
                                                                    <td>'.$i.'</td>
                                                                    <td>'.$rowDephis['DepType'].'</td>
                                                                    <td>'.$rowDephis['DepAm'].'</td>
                                                                    <td>'.$rowDephis['inv'].'</td>
                                                                    <td>'.$rowDephis['chq'].'</td>
                                                                    <td>'.$rowDephis['DayPay'].'</td>
                                                                    <td>'.$rowDephis['DayTime'].'</td>
                                                                </tr>';
                                                        $i++;
                                                    }
                                                    echo $table;
                                                ?>
                                            </tbody>
                                        </table>
                                    
                                    </div>
                                    
                                    <div class="tab-pane fade" id="loanlogs" role="tabpanel" aria-labelledby="loanlog">
                                    </div>

                                </div><!-- End Bordered Tabs Justified -->
                            </div>

                        </div><!-- End Bordered Tabs -->

                        <div class="col-md-12 mt-5">
                            <hr>
                        </div>

                        <div class="col-md-12 mt-3 mb-3 text-center">
                            <h6><?php echo date('F j, Y');?> - <span id="clocking"></span></h6>
                        </div>

                    </div>

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
<script src="jqueryto/jquerymoto.js"></script>
<script src="jqueryto/poppermoto.js"></script>
<script src="jqueryto/bootstrapmoto.js"></script>
<script src="jqueryto/sweetalertmoto.js"></script>
<script src="jqueryto/jquerytodiba.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

<script>
    $(document).ready(function(){
   setInterval('updateClock()', 1000);
});

function updateClock (){
 	var currentTime = new Date ( );
  	var currentHours = currentTime.getHours ( );
  	var currentMinutes = currentTime.getMinutes ( );
  	var currentSeconds = currentTime.getSeconds ( );

  	// Pad the minutes and seconds with leading zeros, if required
  	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  	// Choose either "AM" or "PM" as appropriate
  	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  	// Convert the hours component to 12-hour format if needed
  	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  	// Convert an hours component of "0" to "12"
  	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  	// Compose the string for display
  	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
  	
  	
   	$("#clocking").html(currentTimeString);	  	
 }

</script>
