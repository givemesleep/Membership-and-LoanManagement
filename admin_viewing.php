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
        $resbasic = $stmtbasic->rowCount();
        if($resbasic > 0){
            $rowbasic = $stmtbasic->fetch(PDO::FETCH_ASSOC);

            $lname = $rowbasic['memSur']; $fname = $rowbasic['memGiven']; $mname = $rowbasic['memMiddle']; 
            $suffix = $rowbasic['suffixes']; $nickname = $rowbasic['memNick']; $bdate = $rowbasic['memDOB'];
            $age = bday($bdate); $sex = $rowbasic['gendID']; $maritalID = $rowbasic['maritID'];
            $jd = $rowbasic['ApplyDate'];
        }else{
            $lname = $fname = $mname = $suffix = $nickname = $bdate = $age = $sex = $marital = $maritalID = '&nbsp;';
        }
       

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
        $rescontact = $stmtcontact->rowCount();
        if($rescontact > 0){
            $rowcontact = $stmtcontact->fetch(PDO::FETCH_ASSOC);

            $house = $rowcontact['memaddr']; $reg = $rowcontact['region']; $prov = $rowcontact['province']; $mun = $rowcontact['city'];
            $brgy = $rowcontact['brgy']; $zip = $rowcontact['zipcode']; $email = $rowcontact['mememail']; $mobile1 = $rowcontact['memmob1'];
            $mobile2 = $rowcontact['memmob2']; $landline = $rowcontact['memlan']; $email = $rowcontact['mememail'];
        }else{
            $house = $reg = $prov = $mun = $brgy = $zip = $email = $mobile1 = $mobile2 = $landline = '&nbsp;';
        }
        

        $sqleduc = "SELECT highest, program, schlName FROM tbeducinfo WHERE memberID = ?";
        $dataeduc = array($memberID);
        $stmteduc = $conn->prepare($sqleduc);
        $stmteduc->execute($dataeduc);
        $reseduc = $stmteduc->rowCount();
        if($reseduc > 0){
            $roweduc = $stmteduc->fetch(PDO::FETCH_ASSOC);

            $high = $roweduc['highest']; $prog = $roweduc['program']; $schlName = $roweduc['schlName'];
        }else{
            $high = $prog = $schlName = '&nbsp;';
        }
        

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
        $resEmp = $stmtEmp->rowCount();
        if($resEmp > 0){
            $rowEmp = $stmtEmp->fetch(PDO::FETCH_ASSOC);

            $bus = $rowEmp['Business']; $busType = $rowEmp['BusinessType']; $occu = $rowEmp['Occupation'];
            $comp = $rowEmp['CompanyName']; $monthly = $rowEmp['MonthlyIncome'];
        }else{
            $bus = $busType = $occu = $comp = $monthly = '&nbsp;';
        }
        

        $sqlIDs = "SELECT
                    id.SSSno AS SSS, id.taxIdenNo AS TIN,
                    i.typeDesc AS OtherID, id.idTypeNo AS OtherNo
                FROM tbidinfo id
                LEFT JOIN tbids i ON id.idTypesID = i.idTypesID
                WHERE memberID = ?";
        $dataIDs = array($memberID);
        $stmtIDs = $conn->prepare($sqlIDs);
        $stmtIDs->execute($dataIDs);
        $resIDs = $stmtIDs->rowCount();
        if($resIDs > 0){
            $rowIDs = $stmtIDs->fetch(PDO::FETCH_ASSOC);

            $sss = $rowIDs['SSS']; $tin = $rowIDs['TIN']; 
            $otherID = $rowIDs['OtherID']; $otherIDNo = $rowIDs['OtherNo'];
        }else{
            $sss = $tin = $otherID = $otherIDNo = '&nbsp;';
        }
        
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
        
        $resOth = $stmtOth->rowCount();
        if($resOth > 0){
            $rowOth = $stmtOth->fetch();
            $resi = $rowOth['resiStats']; $resiID = $rowOth['infoStats']; $resyear = $rowOth['yearStay']; 
            $coop = $rowOth['cooperative']; $soc = $rowOth['social']; $hob = $rowOth['hobbies'];    
        }else{
            $resi = $resiID = $resyear = $coop = $soc = $hob = '&nbsp;';
        }

        
        $sqlPMES = "SELECT referName, trainedBy, approvedBy FROM tbpmesinfo WHERE memberID = ?";
        $dataPMES = array($memberID);
        $stmtPMES = $conn->prepare($sqlPMES);
        $stmtPMES->execute($dataPMES);
        $resPMES = $stmtPMES->rowCount();
        if($resPMES > 0){
            while($rowPMES = $stmtPMES->fetch(PDO::FETCH_ASSOC)){

                $ref = $rowPMES['referName']; 
                $train = $rowPMES['trainedBy']; 
                $app = $rowPMES['approvedBy'];

            }
        }else{
            $ref = $train = $app = '&nbsp;';
        }
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
    button.active{
        border: 2px green solid;
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
            <div class="card" style="height: 500px;">
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
                            <h6><b><?php echo ($sex == 1) ? 'Ms. '.$fname . ' ' . $lname  : 'Mr. '. $fname . ' ' . $lname; ?></b></h6>
                        </div>
                        
                        <div class="col-md-12 text-center">
                            <p>Full Name</p>
                        </div>

                        <!-- <div class="col-md-6 mt-3">
                            <button class="btn btn-success" style="width: 100%;" type="button" data-bs-toggle="modal" data-bs-target="#printRep"><i class="bi bi-speedometer2"></i> Scoring</button>
                        </div> -->

                        <div class="col-md-12 mt-3">
                            <a href="admin_viewtrans.php?res=<?php echo encrypt('deposit', $key) ?>&mem=<?php echo encrypt($memberID, $key) ?>"><button class="btn btn-dark" style="width: 100%;"><i class="bi bi-collection"></i> Deposit</button></a>
                        </div>
                    
                    </div>
                
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                <!-- <div class="container"> -->
                    <!-- <div class="row"> -->
                        <!-- <div class="col-md-8" style="margin-left: -12px;"> -->
                            <h5 class="card-title" style="font-size: 35px;"><b>Member Account</b></h5>
                        <!-- </div> -->
                        <!-- <div class="col-md-4 text-end mt-4 flex-column" style="margin-right: -10px;"> -->
                            <!-- <a href="process/.php?inp=5&lastID='.$row['Unique_ID'].'"><button class="btn btn-success" title="Edit"><i class="bi bi-pencil-square"></i></button></a> -->
                            <!-- <a href="process/proc_rmmem.php?memrem='.encrypt($row['memberID'], $key).'"><button class="btn btn-danger" title="Delete"><i class="bi bi-trash-fill"></i></button></a>     -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
                <hr style="margin-top: -10px;">
                    <div class="row">

                        <div class="col-md-12 mt-3">
                            <div class="card" style="height: 120px; border: 1px solid; margin-top: -10px;">
                            <div class="card-body">
                                <div class="row mt-3">

                                    <div class="col-md-9">
                                        <h6>Member Name</h6>
                                        <h3><b><?php echo $fname.' '. $lname; ?></b></h3>
                                        <h6>Member ID : <?php echo $viewmem; ?></h6>
                                    </div>

                                    <div class="col-md-3 text-center">
                                        <h6>Member Status</h6>
                                        <h3><b><span class="badge bg-success">Approved</span></b></h3>
                                        <!-- <h6 title="Loan Approved | Loan Rejected"><i class="bi bi-check-lg"><?php ?>123</i> | <i class="bi bi-x-lg"><?php ?>10</i></h6> -->
                                    </div>

                                </div>
                            </div>
                            </div>
                        </div>
                        

                        <div class="col-md-12">
                            <!-- Pills Tabs -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="margin-top: -10px;">
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link active text-dark" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#basic" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Basic</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#contact" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Contact</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#education" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Educational</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#employment" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Personal</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#identification" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Identification</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pmes" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">PMES</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button style="background: none;" class="nav-link text-dark" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#other" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Others</button>
                                </li>
                            </ul>
                        
                            <div class="tab-content pt-2" id="myTabContent">
                                
                                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Basic Information</b></h5>
                                    <div class="row">
                                    
                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>Last Name</h6>
                                                    <h6>Given Name</h6>
                                                    <h6>Middle Name</h6>
                                                    <h6>Suffix</h6>
                                                    <h6>Nickname</h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b><?php echo $lname; ?></b></h6>
                                                    <h6><b><?php echo $fname; ?></b></h6>
                                                    <h6><b><?php echo ($mname == '') ? '&nbsp;' : $mname; ?></b></h6>
                                                    <h6><b><?php echo ($suffix == '') ? '&nbsp;' : $suffix; ?></b></h6>
                                                    <h6><b><?php echo ($nickname == '') ? '&nbsp;' : $nickname; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>Marital</h6>
                                                    <h6>Citizenship</h6>
                                                    <h6>Gender</h6>
                                                    <h6>Birthdate</h6>
                                                    <h6>Age</h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b><?php echo $marital; ?></b></h6>
                                                    <h6><b>Filipino</b></h6>
                                                    <h6><b><?php echo ($sex == 1) ? 'Female' : 'Male' ?></b></h6>
                                                    <h6><b><?php echo $bdate; ?></b></h6>
                                                    <h6><b><?php echo $age . ' y/o'; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                        

                                       


                                    </div>
                                </div>
                                
                                <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="profile-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Contact Information</b></h5>
                                    <div class="row">

                                        <div class="col-md-7 text-start">
                                            <div class="row">
                                                <div class="col-md-3 text-start">
                                                    <h6>Region</h6>
                                                    <h6>Province</h6>
                                                    <h6>Municipality</h6>
                                                    <h6>Barangay</h6>
                                                    <h6>Zip</h6>
                                                    <h6>Address</h6>
                                                </div>
                                                <div class="col-md-9 text-start">
                                                    <h6><b><?php echo $reg; ?></b></h6>
                                                    <h6><b><?php echo $prov; ?></b></h6>
                                                    <h6><b><?php echo $mun; ?></b></h6>
                                                    <h6><b><?php echo $brgy; ?></b></h6>
                                                    <h6><b><?php echo ($zip == '') ? '&nbsp;' : $zip ?></b></h6>
                                                    <h6><b><?php echo $house; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5 text-start">
                                            <div class="row">
                                                <div class="col-md-4 text-start">
                                                    <h6>(1)Mobile # </h6>
                                                    <h6>(2)Mobile # </h6>
                                                    <h6>Landline </h6>
                                                    <h6>Email Address </h6>
                                                </div>
                                                <div class="col-md-8 text-start">
                                                    <h6><b>+63 <?php echo $mobile1; ?></b></h6>
                                                    <h6><b><?php echo ($mobile2 == '') ? '&nbsp;' : '+63 '. $mobile2; ?></b></h6>
                                                    <h6><b><?php echo ($landline == '')? '&nbsp;' : $landline; ?></b></h6>
                                                    <h6><b><?php echo $email ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="contact-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Educational Background</b></h5>
                                    <div class="row">
                                        <div class="col-md-12 text-start">
                                            <div class="row">
                                                <div class="col-md-3 text-start">
                                                    <h6>Last School</h6>
                                                    <h6>Highest Education Attainment</h6>
                                                    <h6>Course/Track</h6>
                                                </div>
                                                <div class="col-md-9 text-start">
                                                    <h6><b><?php echo $schlName ?></b></h6>
                                                    <h6><b><?php echo $high; ?></b></h6>
                                                    <h6><b><?php echo ($prog == 'N/A') ? ' ' : $prog  ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="employment" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Personal Background</b></h5>
                                    <div class="row">
                                        <div class="col-md-12 text-start">
                                            <div class="row">
                                                <div class="col-md-2 text-start">
                                                    <h6>Business Name</h6>
                                                    <h6>Business Type</h6>
                                                    <h6>Company Name</h6>
                                                    <h6>Occupation</h6>
                                                    <h6>Monthly Income</h6>
                                                </div>
                                                <div class="col-md-10 text-start">
                                                    <h6><b><?php echo ($bus == '') ? '&nbsp;': $bus ?></b></h6>
                                                    <h6><b><?php echo ($busType == '') ? '&nbsp;': $busType ?></b></h6>
                                                    <h6><b><?php echo ($comp == '') ? '&nbsp;': $comp ?></b></h6>
                                                    <h6><b><?php echo ($occu == '') ? '&nbsp;': $occu ?></b></h6>
                                                    <h6><b><?php echo ($monthly == 0 || $monthly == '') ? '&nbsp;' : $monthly ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="identification" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Identification Cards</b></h5>
                                    <div class="row">
                                        <div class="col-md-12 text-start">
                                            <div class="row">
                                                <div class="col-md-3 text-start">
                                                    <h6>Social Security System </h6>
                                                    <h6>Tax Identification Number </h6>
                                                    <h6>Other ID Type</h6>
                                                    <h6>Other ID Number </h6>
                                                </div>
                                                <div class="col-md-9 text-start">
                                                    <h6><b><?php echo $sss; ?></b></h6>
                                                    <h6><b><?php echo $tin; ?></b></h6>
                                                    <h6><b><?php echo ($otherID == '') ? '&nbsp;' : $otherID; ?></b></h6>
                                                    <h6><b><?php echo ($otherIDNo == '') ? '&nbsp;' : $otherIDNo; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pmes" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Pre-Membership Education Seminar</b></h5>
                                    <div class="row">
                                       
                                        <div class="col-md-12 text-start">
                                            <div class="row">
                                                <div class="col-md-2 text-start">
                                                    <h6>Trained By </h6>
                                                    <h6>Referred By </h6>
                                                    <h6>Added By </h6>
                                                    <h6>Joined Date </h6>
                                                    <h6>Death Care</h6>                          
                                                </div>
                                                <div class="col-md-10 text-start">
                                                    <h6><b><?php echo $train; ?></b></h6>
                                                    <h6><b><?php echo ($ref == '') ? '&nbsp;' : $ref; ?></b></h6>
                                                    <h6><b><?php echo $app; ?></b></h6>
                                                    <h6><b><?php echo formatDate($jd); ?></b></h6>
                                                    <h6><b>₱ <?php echo number_format(500, "2", ".", ",") ?></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="home-tab">
                                    <h5 class="card-title" style="font-size : 20px; margin-top: -30px;"><b>Other Information</b></h5>
                                    <div class="row">

                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-5 text-start">
                                                    <h6>Residential Status</h6>
                                                    <h6>Residential Ownership</h6>
                                                    <h6>Year Stay</h6>
                                                </div>
                                                <div class="col-md-7 text-start">
                                                    <h6><b><?php echo ($resiID == '') ? '&nbsp;' : $resiID; ?></b></h6>
                                                    <h6><b><?php echo ($resi == '') ? '&nbsp;' : $resi; ?></b></h6>
                                                    <h6><b><?php echo ($resyear == '') ? '&nbsp;' : $resyear ; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-start">
                                            <div class="row">
                                                <div class="col-md-5 text-start">
                                                    <h6>Social Interest </h6>
                                                    <h6>Hobbies</h6>
                                                    <h6>Other Cooperatives </h6>
                                                </div>
                                                <div class="col-md-7 text-start">
                                                    <h6><b><?php echo ($soc) ? '&nbsp;' : $soc; ?></b></h6>
                                                    <h6><b><?php echo ($hob) ? '&nbsp;' : $hob; ?></b></h6>
                                                    <h6><b><?php echo ($coop) ? '&nbsp;' : $coop; ?></b></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div><!-- End Pills Tabs -->

                        </div>


                        <div class="col-md-12 mt-3">
                            <hr>
                        </div>

                        <div class="col-md-12 text-center">
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

<div class="modal fade" id="printRep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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
