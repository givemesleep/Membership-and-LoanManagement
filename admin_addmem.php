<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';

    //Empty Variables (Avoids Undefined Error)
    $memID = ''; $flags = ''; $editNo = $icons = '';
    $basic = ''; $addr = ''; $per =''; $oth = ''; $prev = '';

    //Basic Variables(Empty)
    $lastname = $firstname = $middlename = $extension = $nickname = $birthdate = $marital = $sex = '';
    
    //Contact Variables(Empty)
    $house = $region = $province = $municipality = $baranggay = $zip = $email = $mob1 = $mob2 = $land = '';

    //Personal Variables(Empty)
    $highschool = $prevSch = $course = $busname = $company = $busType = $occuType = $courID = '';

    //Other Variables(Empty)
    $monthly = $resi = $soc = $sss = $resiID = $hob = $tin = $resyear = $coop = $othID = $othIDno = '';

    //For Dropdowns
    $genders = $maritals = $regs = $provs = $cits = $bgys = $highs = $progs = $busi = $months = $govID = $resis = $infos = '';

    //Flags for Active Fieldset
    if(isset($_GET['flags'])){
        $flags = $_GET['flags'];
        // $icons = '';
        switch($flags){
            case 1:
                $basic = 'class="active"';
                break;
            case 2:
                $addr = 'class="active"';
            break;
            case 3:
                $per = 'class="active"';
            break;
            case 4:
                $oth = 'class="active"';
            break;
            case 5:
                $prev = 'class="active"';
            break;
            default:
            break;
        }
    }

    //Last ID (Current ID)
    if(isset($_GET['lastID'])){
        $memID = $_GET['lastID'];
    }

    //Fetching ID and Edit IT
    if(isset($_GET['editNo'])){
        $editNo = $_GET['editNo'];

        //Basic Information
        $sqlBasic = "SELECT * FROM tbperinfo WHERE memberID=?";
        $dataBasic = array($editNo);
        $stmtBasic = $conn->prepare($sqlBasic);
        $stmtBasic->execute($dataBasic);
        $rowBasic = $stmtBasic->fetch();   

        //Contact Information
        $sqlCon = "SELECT * FROM tbconinfo WHERE memberID=?";
        $dataCon = array($editNo);
        $stmtCon = $conn->prepare($sqlCon);
        $stmtCon->execute($dataCon);
        $rowCon = $stmtCon->fetch();

        //Personal Background
        $sqlPer = "SELECT * FROM tbeducinfo WHERE memberID=?";
        $dataPer = array($editNo);
        $stmtPer = $conn->prepare($sqlPer);
        $stmtPer->execute($dataPer);
        $rowPer = $stmtPer->fetch();

        $sqlWork = "SELECT * FROM tbworkinfo WHERE memberID=?";
        $dataWork = array($editNo);
        $stmtWork = $conn->prepare($sqlWork);
        $stmtWork->execute($dataWork);
        $rowWork = $stmtWork->fetch();

        //Other Information
        // $sqlID = "SELECT * FROM tbidinfo WHERE memberID=?";
        // $dataID = array($editNo);
        // $stmtID = $conn->prepare($sqlID);
        // $stmtID->execute($dataID);
        // $rowID = $stmtID->fetch();

        $sqlOth = "SELECT * FROM tbotherinfo WHERE memberID=?";
        $dataOth = array($editNo);
        $stmtOth = $conn->prepare($sqlOth);
        $stmtOth->execute($dataOth);
        $rowOth = $stmtOth->fetch();


        //Rows
        //Basic Row Fetch
        $lastname = $rowBasic['memSur']; $firstname = $rowBasic['memGiven']; $middlename = $rowBasic['memMiddle']; $nickname = $rowBasic['memNick'];
        $extension = $rowBasic['suffixes'];  $birthdate = $rowBasic['memDOB']; $marital = $rowBasic['maritID']; $sex = $rowBasic['gendID'];

        //Contact Row Count 
        $house = $rowCon['memaddr']; $region = $rowCon['region']; $province = $rowCon['province']; 
        $municipality = $rowCon['city']; $baranggay = $rowCon['brgy']; $zip = $rowCon['zipcode']; 
        $email = $rowCon['mememail']; $mob1 = $rowCon['memmob1']; $mob2 = $rowCon['memmob2']; $land = $rowCon['memlan'];
        
        //Personal Row Count
        $highschool = $rowPer['highest']; $prevSch = $rowPer['schlName']; $course = $rowPer['program'];
        $busname = $rowWork['memBusInfo']; $busType = $rowWork['memBusType']; 
        $company = $rowWork['memCompName']; $occuType = $rowWork['memOccuInfo'];

        //Other Row Count 
        $monthly = $rowWork['monthlyID']; 
        // $sss = $rowID['SSSno']; $tin = $rowID['taxIdenNo']; $othID = $rowID['idTypesID']; $othIDno = $rowID['idTypeNo'];
        $resi = $rowOth['othInfoID']; $resiID = $rowOth['resID']; 
        $soc = $rowOth['socint']; $hob = $rowOth['hobbies']; $coop = $rowOth['coop']; $resyear = $rowOth['yearStay'];



        $sqlmarit = "SELECT marDep FROM tbmaritals WHERE maritID = ?";
        $datamarit = array($rowBasic['maritID']);
        $stmtmarit = $conn->prepare($sqlmarit);
        $stmtmarit->execute($datamarit);
        $rowmarit = $stmtmarit->fetch();
        $maritals = $rowmarit['marDep'];

        $sqlmarit = "SELECT genders FROM tbgenders WHERE gendID = ?";
        $datamarit = array($rowBasic['gendID']);
        $stmtmarit = $conn->prepare($sqlmarit);
        $stmtmarit->execute($datamarit);
        $rowmarit = $stmtmarit->fetch();
        $genders = $rowmarit['genders'];

        $sqlregs = "SELECT regDesc FROM tbreg WHERE regDesc = ?";
        $dataregs = array($rowCon['region']);
        $stmtregs = $conn->prepare($sqlregs);
        $stmtregs->execute($dataregs);
        $rowregs = $stmtregs->fetch();
        $regs = $rowregs['regDesc'];

        $sqlprovs = "SELECT provDesc FROM tbprovince WHERE provDesc = ?";
        $dataprovs = array($rowCon['province']);
        $stmtprovs = $conn->prepare($sqlprovs);
        $stmtprovs->execute($dataprovs);
        $rowprovs = $stmtprovs->fetch();
        $provs = $rowprovs['provDesc'];

        $sqlcits = "SELECT citymunDesc FROM tbmuni WHERE citymunDesc = ? LIMIT 1000";
        $datacits = array($rowCon['city']);
        $stmtcits = $conn->prepare($sqlcits);
        $stmtcits->execute($datacits);
        $rowcits = $stmtcits->fetch();
        $cits = $rowcits['citymunDesc'];

        $sqlbgys = "SELECT brgyDesc FROM tbbrgys WHERE brgyDesc = ? LIMIT 1000";
        $databgys = array($rowCon['brgy']);
        $stmtbgys = $conn->prepare($sqlbgys);
        $stmtbgys->execute($databgys);
        $rowbgys = $stmtbgys->fetch();
        $bgys = $rowbgys['brgyDesc'];

        $sqlhighs = "SELECT edudescription FROM tbeduclvl WHERE edudescription = ?";
        $datahighs = array($rowPer['highest']);
        $stmthighs = $conn->prepare($sqlhighs);
        $stmthighs->execute($datahighs);
        $rowhighs = $stmthighs->fetch();
        $highs = $rowhighs['edudescription'];

        if($course == 'N/A'){
            $progs = "None";
        }else{
            $sqlprogs = "SELECT courseDesc FROM tbcourses WHERE courseDesc = ?";
            $dataprogs = array($rowPer['program']);
            $stmtprogs = $conn->prepare($sqlprogs);
            $stmtprogs->execute($dataprogs);
            $rowprogs = $stmtprogs->fetch();
            $progs = $rowprogs['courseDesc'];
        }

        $sqlmonths = "SELECT monthlySize FROM tbmonthly WHERE monthlyID = ?";
        $datamonths = array($rowWork['monthlyID']);
        $stmtmonths = $conn->prepare($sqlmonths);
        $stmtmonths->execute($datamonths);
        $rowmonths = $stmtmonths->fetch();
        $months = $rowmonths['monthlySize'];

        if($othID == 0){

        }else{
            $sqlgovID = "SELECT typeDesc FROM tbids WHERE idTypesID = ?";
            $datagovID = array($rowID['idTypesID']);
            $stmtgovID = $conn->prepare($sqlgovID);
            $stmtgovID->execute($datagovID);
            $rowgovID = $stmtgovID->fetch();
            $govID = $rowgovID['typeDesc'];
        }

        if($resiID == 0){
        
        }else{
            $sqlresis = "SELECT resiStatus FROM tbresistats WHERE resID = ?";
            $dataresis = array($rowOth['resID']);
            $stmtresis = $conn->prepare($sqlresis);
            $stmtresis->execute($dataresis);
            $rowresis = $stmtresis->fetch();
            $resis = $rowresis['resiStatus'];
        }

        $sqlinfos = "SELECT InfoStats FROM tbinfostats WHERE othInfoID = ?";
        $datainfos = array($rowOth['othInfoID']);
        $stmtinfos = $conn->prepare($sqlinfos);
        $stmtinfos->execute($datainfos);
        $rowinfos = $stmtinfos->fetch();
        $infos = $rowinfos['InfoStats'];
    }

?>  
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | New Membership</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/llampcologo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <style>
    
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
        margin-top: 70px;
        padding-left: 275px;
        padding-right: 275px;
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
    .icon{
        font-size: 1.5em;
    }

    .steps{
        display: flex;
        flex-direction: column;
        width: 350px;
        height: 600px;
        padding-top: 50px;
        padding-left: 10px;
        margin-bottom: 20px;
        border-radius: 20px;
    }

    .line{
        border-left: 4px solid #495156;
        translate: -24px 49px;
        height: 88%;
    }
     .activeln{
        border-left: 4px dashed #178852;
        translate: -24px 49px;
        height: 88%;
    }
   .steps .active{
        /* background-color: #2e83fa; */
        color: #178852;
    }

    .steps .bacactive{
        background-color:#178852;
        color: #fff;
    }

    .step {
        min-width: 45px;
        max-height: 50px;
        border-radius: 25%;
        font-weight: bolder;
        align-items: center;
        background-color: #495156;
        padding: 5px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        border: 1px solid white;
        color: #fff;
        }

    .icons{
            color: #495156;
        }

    

    p{
            margin: 0 20px;
        }
        .stepInfo{
        display: flex;
        flex-direction: row;
        margin: 20px;
    }
    .btn{
        margin-top: -30px;
    }
  </style>

<?php 
require_once 'sidenavs/headers.php'; 
$pages = 'applications'; $nav=''; require_once 'sidenavs/admin_side.php';;
?>

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Membership</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin_index.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Member</li>
              
          </ol>
      </nav>
  </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-3">
                <div class="" style="height: 81%; background:none;border:none;">
                    <div class="card-body" style="background:none;">
                        <div class="row" style="background:none;">

                            <div class="steps">

                                <div class="stepInfo">
                                    <div class="step <?php echo ($flags == '' || $flags == 1) ? 'bacactive' : '' ?>" data-step="1" style="font-size:20px; padding-left:3px;">1</div>
                                    <div <?php echo ($flags == '' || $flags == 1) ? 'class="activeln"' : 'class="line"' ?>></div>
                                    <span style="font-size:50px; margin-left:15px;margin-top:-10px;"><i class="bi bi-person-lines-fill <?php echo ($flags == '' || $flags == 1) ? 'active' : '' ?>"></i></span>
                                    <div class="stepName">
                                        <p class="label <?php echo ($flags == '' || $flags == 1) ? 'active' : '' ?>" style="font-weight:bold;">BASIC INFORMATION</p>
                                    </div>
                                    </div>

                                    <div class="stepInfo">
                                    <div class="step <?php echo ($flags == 2) ? 'bacactive' : '' ?>" data-step="2" style="font-size:20px; padding-left:3px;">2</div>
                                    <div class="line <?php echo ($flags == 2) ? 'activeln' : '' ?>"></div>
                                    <span style="font-size:50px; margin-left:15px;margin-top:-10px;"><i class="bi bi-geo-alt-fill icons <?php echo ($flags == 2) ? 'active' : '' ?>"></i></span>
                                    <div class="stepName">
                                        <p class="label <?php echo ($flags == 2) ? 'active' : '' ?>" style="font-weight:bold;">CONTACT INFORMATION</p>
                                    </div>
                                    </div>

                                    <div class="stepInfo">
                                    <div class="step <?php echo ($flags == 3) ? 'bacactive' : '' ?>" data-step="3" style="font-size:20px; padding-left:3px;">3</div>
                                    <div class="line <?php echo ($flags == 3) ? 'activeln' : '' ?>"></div>
                                    <span style="font-size:50px; margin-left:15px;margin-top:-10px;"><i class="bi bi-file-earmark-person icons <?php echo ($flags == 3) ? 'active' : '' ?>"></i></span>
                                    <div class="stepName">
                                        <p class="label <?php echo ($flags == 3) ? 'active' : '' ?>" style="font-weight:bold;">PERSONAL INFORMATION</p>
                                    </div>
                                    </div>

                                    <div class="stepInfo">
                                    <div class="step <?php echo ($flags == 4) ? 'bacactive' : '' ?>" data-step="4" style="font-size:20px; padding-left:3px;">4</div>
                                    <span style="font-size:50px; margin-left:15px;margin-top:-10px;"><i class="bi bi-house-add icons <?php echo ($flags == 4) ? 'active' : '' ?>"></i></span>
                                    <div class="stepName">
                                        <p class="label <?php echo ($flags == 4) ? 'active' : '' ?>" style="font-weight:bold;">OTHER INFORMATION</p>
                                    </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">

                    <fieldset  <?php //echo ($flags != '') ? $basic : 'class="active"' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Basic Information</b></h5>
                        <form action="process/proc_newmem.php?inp=1" method="post">
                            <!-- f1 Personal Details -->
                            <div class="row g-3">

                                <div class="col-md-3">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <!-- <header id=header-background>
                                        <h6 class="mt-3"><b>Personal Information</b></h6>
                                </header> -->
                                <input type="hidden" name="basicID" value="<?php echo $memID; ?>">
                                <input type="hidden" name="basicEdit" value="<?php echo $editNo; ?>">

                                <div class="col-md-6">
                                    <label for="lname" class="form-label">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control letter" name="surname" id="" value="<?php echo $lastname; ?>" required placeholder="Last Name" style="text-transform: capitalize;" tabindex="1">
                                </div>

                                <div class="col-md-6">
                                    <label for="floatingbday" class="form-label">Birthdate <span class="required">*</span></label>
                                    <input type="date" class="form-control eyy" name="DOB" id="" value="<?php echo $birthdate; ?>" required tabindex="6">
                                </div>

                                <div class="col-md-6">
                                    <label for="fname" class="form-label">First Name <span class="required">*</span></label>  
                                    <input type="text" class="form-control letter" name="givenname" id="" value="<?php echo $firstname; ?>" required placeholder="First Name" style="text-transform: capitalize;" tabindex="2">
                                </div>

                                <div class="col-md-6">
                                    <label for="floatingmarit" class="form-label">Marital Status<span class="required">*</span></label>
                                        <select class="form-select eyy" name="cboMarital" id="floatingmarit" aria-label="State" required tabindex="7">
                                            <option selected value="<?php echo $marital; ?>"><?php echo ($marital != '') ? $maritals : 'Select Maritals' ?></option>
                                                <?php                               
                                                    $sql = "SELECT * FROM tbmaritals";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();

                                                    while($row=$stmt->fetch()){
                                                        echo '<option value="'.$row['maritID'].'">'.$row['marDep'].'</option>';
                                                    }
                                                ?>
                                        </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="floatingmini" class="form-label">Middle Name </label>
                                    <input type="text" class="form-control letter" name="middle" id="" value="<?php echo $middlename; ?>" placeholder="Middle Name" style="text-transform: capitalize;" title="Ex. Santiago" tabindex="3">
                                </div>

                                <div class="col-md-6">
                                    <label for="floatinggen" class="form-label">Sex <span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboSex" id="floatinggen" required tabindex="8">
                                            <option selected value="<?php echo ($sex != '') ? $sex : '' ?>"><?php echo ($genders != '') ? $genders : 'Select Sex' ?></option>
                                                <?php                               
                                                    $sql = "SELECT * FROM tbgenders";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();

                                                    while($row=$stmt->fetch()){
                                                        echo '<option value="'.$row['gendID'].'">'.$row['genders'].'</option>';
                                                    } 
                                                ?>
                                        </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingnick" class="form-label">Nickname <span class="required">*</span></label>
                                    <input type="text" class="form-control letter" name="nickname" id="floatingnick" value="<?php echo $nickname; ?>" required placeholder="Nickname" maxlength="15" style="text-transform: capitalize;" title="Ex. Lito" tabindex="4">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingex" class="form-label">Extension</label>
                                        <input type="text" class="form-control letter" name="ext" id="floatingex" value="<?php echo $extension; ?>" placeholder="Ex. Jr." maxlength="5" style="text-transform: capitalize;" title="Ex. Jr." tabindex="5">
                                </div>
                                
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="text-end">
                                    <input type="submit" name="next" class="btn btn-primary" value="Next &raquo;" tabindex="9">
                                </div>

                            </div> <!-- end of row -->
                        </form> 
                    </fieldset>

                    <fieldset  <?php //echo ($flags != '') ? $addr : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Contact Information</b></h5>
                        <form action="process/proc_newmem.php?inp=2" method="post">    
                            <!-- f2 Contact Details -->
                            
                            <div class="row g-3">
                            
                            <div class="col-md-3">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <input type="hidden" name="conID" value="<?php echo $memID; ?>">
                            <input type="hidden" name="conEdit" value="<?php echo $editNo; ?>">

                            <div class="col-md-6">
                                <label for="floatingprov" class="form-label">House No. / Street / Subdivision <span class="required">*</span></label>
                                <input type="text" class="form-control" name="street" required tabindex="1" value="<?php echo $house; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="floatingemail" class="form-label">Email Address <span class="required">*</span></label>
                                <div class="input-group">
                                    <!-- <span class="input-group-text">@</span> -->
                                    <input type="text" class="form-control" name="email" id="floatingemail" value="<?php echo $email; ?>" required placeholder="llampco@email.com" maxlength="50" tabindex="7">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingprov" class="form-label">Region <span class="required">*</span></label>
                                <select class="form-select inpots" name="cboReg" id="reg" aria-label="State" required tabindex="2">
                                    <option selected value="<?php echo ($region != '') ? $region : '' ?>"><?php echo ($regs != '') ? $regs : 'Select Region' ?></option>
                                    <?php 
                                        $sql = "SELECT regsID AS ID, regDesc AS reg, regcode AS codes FROM tbreg";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        while($row=$stmt->fetch()){
                                            echo '<option value="'.$row['reg'].'">'.$row['reg'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingmob" class="form-label">Mobile #<span class="required">*</span></label>  
                                <div class="input-group">
                                    <!-- <span class="input-group-text">+63</span> -->
                                    <input type="text" class="form-control mobile number onlynine" name="mob1" id="floatingmob" value="<?php echo $mob1; ?>" required placeholder="(63) 000-0000-000" maxlength="12" tabindex="8">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingprov" class="form-label">Province <span class="required">*</span></label>
                                <select class="form-select inpots" name="cboProv" id="prov" aria-label="State" required tabindex="3">
                                    <option selected value="<?php echo ($province != '') ? $province : '' ?>"><?php echo ($provs != '') ? $provs : 'Select Province' ?></option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingmob" class="form-label">Mobile #</label>  
                                <div class="input-group">
                                    <!-- <span class="input-group-text">+63</span> -->
                                    <input type="text" class="form-control mobile number onlynine" name="mob2" id="floatingmob" value="<?php echo $mob2; ?>" placeholder="(63) 000-0000-000" maxlength="12" tabindex="9">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingcit" class="form-label">City <span class="required">*</span></label>  
                                <select class="form-select inpots" name="cboCity" id="cit" aria-label="State" required tabindex="4">
                                    <option selected value="<?php echo ($municipality != '') ? $municipality : '' ?>"><?php echo ($cits != '') ? $cits : 'Select Cities' ?></option> 
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="floatingland" class="form-label">Landline #</label>
                                <div class="input-group">
                                    <!-- <span class="input-group-text">+63 (2)</span> -->
                                    <input type="text" class="form-control landline number" name="land" id="floatingland" value="<?php echo $land; ?>" placeholder="12xx-xxxx" maxlength="9" tabindex="10">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="floatingcit" class="form-label">Baranggay <span class="required">*</span></label>  
                                <select class="form-select inpots" name="cboBrgy" id="bar" aria-label="State" required tabindex="5">
                                    <option selected value="<?php echo ($baranggay != '') ? $baranggay : '' ?>"><?php echo ($bgys != '') ? $bgys : 'Select Cities' ?></option> 
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="floatingbrgy" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" name="zip" id="floatingmob" value="<?php echo $zip; ?>" placeholder="ZIP Code" maxlength="20" tabindex="6">
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>
                            
                            <div class="text-end">
                                <input type="submit" class="btn btn-primary" value="Next &raquo;" tabindex="11">
                            </div>                     
                            
                        </div>
                            
                        </form>
                    </fieldset>

                    <fieldset  <?php //echo ($flags != '') ? $per : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Personal Background</b></h5>
                        <form  action="process/proc_newmem.php?inp=3" method="post">
                            <!-- f3 Personal Background  -->
                            
                                <div class="row g-3">

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="perID" value="<?php echo $memID; ?>">
                                    <input type="hidden" name="backEdit" value="<?php echo $editNo; ?>">
                                    <!-- Educational -->
                                    
                                    <div class="col-md-4">
                                        <label for="floatinghigh" class="form-label">Highest School Attainment<span class="required">*</span></label>  
                                            <select class="form-select inpots" name="cboHigh" id="highest" aria-label="State" required tabindex="1">
                                                <option selected value="<?php echo ($highschool != '') ? $highschool : '' ?>"><?php echo ($highs != '') ? $highs : 'Select Highest' ?></option>
                                                <?php 
                                                    $sql = "SELECT * FROM tbeduclvl";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();

                                                    while($row=$stmt->fetch()){
                                                        echo '<option value="'.$row['edudescription'].'">'.$row['edudescription'].'</option>';
                                                    }
                                                    ?>
                                            </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="floatingbname" class="form-label">Business Name</label>
                                        <input type="text" class="form-control letter " name="busname" id="floatingbname" value="<?php echo $busname; ?>" style="text-transform: capitalize;" tabindex="4">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingcompany" class="form-label">Company Name</label>
                                        <input type="text" class="form-control letter" name="company" id="floatingcompany" value="<?php echo $company; ?>" style="text-transform: capitalize;" tabindex="6">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingsch" class="form-label">School Name <span class="required">*</span></label>
                                        <input type="text" class="form-control letter" name="prevSch" id="floatingsch" value="<?php echo $prevSch; ?>" required style="text-transform: capitalize;" placeholder="Previous/ Last School" tabindex="2">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="floatinghigh" class="form-label">Business Type</label>  
                                            <select class="form-select inpots" name="busType" id="floatinghigh" aria-label="State" tabindex="5">
                                                <option selected value="<?php echo ($busType != '') ? $busType : '' ?>"><?php echo ($busType != '') ? $busType : 'Select Business' ?></option>
                                                <?php 
                                                    $Business = array('Sole Proprietorship', 'Partnership', 'Limited Liability Company', 'Corporation');
                                                    foreach($Business as $bus){
                                                        echo '<option value="'.$bus.'">'.$bus.'</option>';
                                                    }
                                                    
                                                    ?>
                                            </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatinghigh" class="form-label">Occupation Type</label>  
                                            <input type="text" class="form-control" name="occuType" value="<?php echo $occuType; ?>" tabindex="7">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingcour" class="form-label">Track/Program</label>
                                            <select class="form-select" name="cboPrograms" id="course" aria-label="State" tabindex="3">
                                                <option selected value="<?php echo ($courID != '') ? $courID : '' ?>"><?php echo ($progs != '') ? $progs : 'Select Track/Course' ?></option>
                                            </select>
                                    </div>

                                    <!-- <div class="col-md-4"></div> -->
                                    <div class="col-md-4">
                                        <label for="floatingincome" class="form-label">Monthly Income <span class="required">*</span></label>
                                        <select class="form-select inpots" name="monthly" id="floatingincome" aria-label="State" required tabindex="1">
                                            <option selected value="<?php echo ($monthly != '') ? $monthly : '' ?>"><?php echo ($months != '') ? $months : 'Select Business' ?></option>
                                            <?php
                                                $sql = "SELECT * FROM tbmonthly";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();

                                                while($row=$stmt->fetch()){
                                                    echo '<option value="'.$row['monthlyID'].'">'.$row['monthlySize'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 ">
                                        <hr>
                                    </div>

                                    <div class="text-end">
                                        <input type="submit"class="btn btn-primary" value="Next &raquo;" tabindex="10">
                                    </div>                            
                                </div>
                            
                        </form>
                    </fieldset>

                    <fieldset class="active" <?php //echo ($flags != '') ? $oth : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Pre-Membership Education Seminar</b></h5>
                        <form action="process/proc_newmem.php?inp=4" method="post">
                            <!-- f6 Other Information  -->
                              
                                <div class="row g-3">
                                    
                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="othersID" value="<?php echo $memID; ?>">
                                    <input type="hidden" name="othEdit" value="<?php echo $editNo; ?>">

                                    <div class="col-md-6">
                                        <label for="floatingsss" class="form-label">Social Security System No. <span class="required">*</span></label>
                                        <input type="text" class="form-control number SSS" name="sss" id="SSS" required placeholder="12-XXXXXXX-X" maxlength="12" tabindex="1">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="validationCustom04" class="form-label">Trainer In-charge <span class="required">*</span></label>
                                            <select class="form-select" id="validationCustom04" name="conducts" required tabindex="1">
                                                <option selected disabled value="">Select Trainer</option>
                                                <?php 
                                                    $sqlCon="SELECT * FROM tbconducts";
                                                    $stmtCon=$conn->prepare($sqlCon);
                                                    $stmtCon->execute();
                                                    while($rows=$stmtCon->fetch()){
                                                    echo '<option value="'.$rows['conName'].'">'.$rows['conName'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        <div class="invalid-feedback">Please select person name.</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="floatingtax" class="form-label">Tax Identification No. <span class="required">*</span></label>
                                        <input type="text" class="form-control number TIN" name="tin" id="TIN" required placeholder="123-XXX-XXX-XXX" maxlength="14" tabindex="2">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatingresi" class="form-label">Member Referral <span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" requiredtabindex="1">
                                            <option selected>Select PMES Trainer</option>
                                            <?php
                                                $sql = "SELECT conName FROM tbconducts";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();

                                                while($row=$stmt->fetch()){
                                                    echo '<option value="'.$row['conName'].'">'.$row['conName'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="otherId" class="form-label" >Other ID Type </label>
                                        <select class="form-select" name="cboID" id="otherId" aria-label="State" tabindex="3">
                                            <option selected value="<?php //echo ($othID != '') ? $othID : '' ?>"><?php //echo ($govID != '') ? $govID : 'Select Other ID' ?>Select Other ID</option>
                                                <?php
                                                    $sql = "SELECT * FROM tbids";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();

                                                    while($row=$stmt->fetch()){
                                                        echo '<option value="'.$row['idTypesID'].'">'.$row['typeDesc'].'</option>';
                                                    }      
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatingstay" class="form-label">Seminar Schedule</label>
                                        <input type="date" class="form-control inpots" name="coop" id="floatingstay" value="<?php  ?>" placeholder="Optional Cooperatives"  tabindex="11">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatingotherno" class="form-label">Other ID No. <span class="required" id="IDLabel" style="display: none;">*</span></label>
                                        <input type="text" class="form-control" name="othID" maxlength="19" id="otherIds" tabindex="4">
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <hr>
                                    </div>

                                    <div class="text-end">
                                        <input type="submit" class="btn btn-primary" value="Next &raquo;"  tabindex="12">
                                    </div>

                                </div> <!-- end of row -->
                            
                        </form>
                    </fieldset>

                    <fieldset  <?php //echo ($flags != '') ? $oth : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Beneficiaries</b></h5>
                        <form action="process/proc_newmem.php?inp=4" method="post">
                            <!-- f6 Other Information  -->
                              
                                <div class="row g-3">
                                                          
                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="othersID" value="<?php echo $memID; ?>">
                                    <input type="hidden" name="othEdit" value="<?php echo $editNo; ?>">

                                    <div class="col-md-4">
                                        <h6><b>Beneficiary (1)</b></h6>
                                        <label for="floatingsss" class="form-label">Last Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h6><b>Beneficiary (2)</b></h6>
                                        <label for="floatingsss" class="form-label">Last Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <h6><b>Beneficiary (3)</b></h6>
                                        <label for="floatingsss" class="form-label">Last Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Given Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Given Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Given Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Middle Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Middle Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingsss" class="form-label">Middle Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="" required  tabindex="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingtax" class="form-label">Mobile No. <span class="required">*</span></label>
                                        <input type="text" class="form-control " name="" required tabindex="2">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingtax" class="form-label">Mobile No. <span class="required">*</span></label>
                                        <input type="text" class="form-control " name="" required tabindex="2">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingtax" class="form-label">Mobile No. <span class="required">*</span></label>
                                        <input type="text" class="form-control " name="" required tabindex="2">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="floatingresi" class="form-label">Relationship <span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" requiredtabindex="1">
                                            <option selected>Select Relation</option>
                                            <?php
                                                // $sql = "SELECT conName FROM tbconducts";
                                                // $stmt = $conn->prepare($sql);
                                                // $stmt->execute();

                                                // while($row=$stmt->fetch()){
                                                //     echo '<option value="'.$row['conName'].'">'.$row['conName'].'</option>';
                                                // }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingresi" class="form-label">Relationship <span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" requiredtabindex="1">
                                            <option selected>Select Relation</option>
                                            <?php
                                                // $sql = "SELECT conName FROM tbconducts";
                                                // $stmt = $conn->prepare($sql);
                                                // $stmt->execute();

                                                // while($row=$stmt->fetch()){
                                                //     echo '<option value="'.$row['conName'].'">'.$row['conName'].'</option>';
                                                // }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="floatingresi" class="form-label">Relationship <span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" requiredtabindex="1">
                                            <option selected>Select Relation</option>
                                            <?php
                                                // $sql = "SELECT conName FROM tbconducts";
                                                // $stmt = $conn->prepare($sql);
                                                // $stmt->execute();

                                                // while($row=$stmt->fetch()){
                                                //     echo '<option value="'.$row['conName'].'">'.$row['conName'].'</option>';
                                                // }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <hr>
                                    </div>

                                    <div class="text-end">
                                        <input type="submit" class="btn btn-primary" value="Next &raquo;"  tabindex="12">
                                    </div>

                                </div> <!-- end of row -->
                            
                        </form>
                    </fieldset>
                    
                    <fieldset <?php //echo ($flags != '') ? $oth : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Other Information</b></h5>
                        <form action="process/proc_newmem.php?inp=4" method="post">
                            <!-- f6 Other Information  -->
                              
                                <div class="row g-3">
                                    
                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="othersID" value="<?php echo $memID; ?>">
                                    <input type="hidden" name="othEdit" value="<?php echo $editNo; ?>">

                                    <div class="col-md-6">
                                        <label for="floatingresi" class="form-label">Residential Type<span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" requiredtabindex="1">
                                            <option selected value="<?php echo ($resiID != '') ? $resiID : '' ?>"><?php echo ($resis != '') ? $resis : 'Select Residential Type' ?></option>
                                            <?php
                                                $sql = "SELECT * FROM tbresistats";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();

                                                while($row=$stmt->fetch()){
                                                    echo '<option value="'.$row['resID'].'">'.$row['resiStatus'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatingsoc" class="form-label">Social Interest</label>
                                        <textarea name="soc" class="form-control letter" id="" cols="0" rows="1" style="text-transform: capitalize;"  tabindex="9"><?php echo $soc;?></textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="floatingstatus" class="form-label">Residential Status<span class="required">*</span></label>
                                        <select class="form-select inpots" name="cboResiID" id="floatingstatus" aria-label="State" required tabindex="7">
                                        <option selected value="<?php echo ($resi != '') ? $resi : '' ?>"><?php echo ($infos != '') ? $infos : 'Select Residential Info' ?></option>
                                            <?php
                                                $sql = "SELECT * FROM tbinfostats";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();

                                                while($row=$stmt->fetch()){
                                                    echo '<option value="'.$row['othInfoID'].'">'.$row['InfoStats'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatinghob" class="form-label">Hobbies</label>
                                        <textarea name="hob" class="form-control letter" id="" cols="0" rows="1" style="text-transform: capitalize;" tabindex="10"><?php echo $hob; ?></textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="floatingstay" class="form-label">Residential Stay<span class="required">*</span></label>
                                        <input type="date" class="form-control inpots" name="resyear" id="floatingstay" value="<?php echo $resyear; ?>" required  tabindex="8">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="floatingstay" class="form-label">Other Cooperatives</label>
                                        <input type="text" class="form-control inpots" name="coop" id="floatingstay" value="<?php echo $coop; ?>" placeholder="Optional Cooperatives"  tabindex="11">
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <hr>
                                    </div>

                                    <div class="text-end">
                                        <input type="submit" class="btn btn-success" value="Save"  tabindex="12">
                                    </div>

                                </div> <!-- end of row -->
                            
                        </form>
                    </fieldset>

                    

                    <!-- f6 Preview Information  -->
                    <fieldset <?php //echo ($flags != '') ? $prev : '' ?>>
                        <h5 class="card-title" style="font-size: 35px;"><b>Preview</b></h5>
                        <div class="row g-3">
                        
                        <div class="col-md-12">
                            <hr>
                        </div>

                        <input type="hidden" name="prevID" value="<?php echo $memID; ?>">
                                
                        <div class="accordion accordion-flush" id="accordionFlushExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Basic Information
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">

                                            
                                            <?php 
                                                //Preview Basic

                                                //Empty
                                                $ln = $fn = $mn = $ext = $nk = $bday = $mr = $sx = '';

                                                $sqlpb = "SELECT 
                                                            p.memSur AS Surname, p.memGiven AS Firstname, p.memMiddle AS Middlename, p.suffixes AS suffix,
                                                            p.memNick AS Nickname, s.marDep AS Marital, g.genders AS Gender, p.memDOB AS Birthdate
                                                        FROM tbperinfo p
                                                        JOIN tbmaritals s ON p.maritID = s.maritID 
                                                        JOIN tbgenders g ON p.gendID = g.gendID 
                                                        WHERE p.memberID=?";
                                                $datapb = array($memID);
                                                $stmtpb = $conn->prepare($sqlpb);
                                                $stmtpb->execute($datapb);
                                                $rowpb = $stmtpb->fetch();

                                                $ln = $rowpb['Surname']; $fn = $rowpb['Firstname']; $mn = $rowpb['Middlename']; $ext = $rowpb['suffix']; 
                                                $nk = $rowpb['Nickname']; $bday = $rowpb['Birthdate']; $mr = $rowpb['Marital']; $sx = $rowpb['Gender'];

                                            ?>

                                            <div class="col-md-6">
                                                <h6>Last Name : <?php echo $ln; ?></h6>
                                                <h6>First Name : <?php echo $fn; ?></h6>
                                                <h6>Middle Name : <?php echo $mn; ?></h6>
                                                <h6>Extension : <?php echo $ext; ?></h6>
                                                <h6>Nickname : <?php echo $nk; ?></h6>
                                            </div>

                                            <div class="col-md-6">
                                            <h6>Birthdate : <?php echo $bday; ?></h6>
                                            <h6>Marital Status : <?php echo $mr; ?></h6>
                                            <h6>Sex : <?php echo $sx; ?></h6>
                                            </div>

                                            <div class="text-end">
                                                <a href="admin_addmem.php?flags=1&editNo=<?php echo $memID; ?>"><button class="btn btn-success">Edit</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Contact Information
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">

                                            <?php 

                                                //Empty Variables
                                                $hs = $rg = $pr = $mc = $br = $zp = $em = $mb1 = $mb2 = $ll = '';

                                                $sqladdr = "SELECT 
                                                                memaddr AS house, region, province, city, brgy, zipcode,
                                                                memmob1 AS Mobile1, memmob2 AS Mobile2, memlan AS Landlines,
                                                                mememail AS Email
                                                            FROM tbconinfo 
                                                            WHERE memberID=?";
                                                $dataaddr = array($memID);
                                                $stmtaddr = $conn->prepare($sqladdr);
                                                $stmtaddr->execute($dataaddr);
                                                $rowaddr = $stmtaddr->fetch();

                                                $hs = $rowaddr['house']; $rg = $rowaddr['region']; $pr = $rowaddr['province']; $mc = $rowaddr['city']; $br = $rowaddr['brgy']; 
                                                $zp = $rowaddr['zipcode']; $em = $rowaddr['Email']; $mb1 = $rowaddr['Mobile1']; $mb2 = $rowaddr['Mobile2']; $ll = $rowaddr['Landlines'];

                                            ?>

                                            <div class="col-md-6">
                                                <h6>House No. / Street / Subdivision : <?php echo $hs; ?></h6>
                                                <h6>Region : <?php echo $rg; ?></h6>
                                                <h6>Province : <?php echo $pr; ?></h6>
                                                <h6>Municipality : <?php echo $mc ?></h6>
                                                <h6>Baranggay : <?php echo $br; ?></h6>
                                                <h6>ZIP Code : <?php echo $zp; ?></h6>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h6>Email Address : <?php echo $em; ?></h6>
                                                <h6>(1) Mobile No. <?php echo $mb1; ?></h6>
                                                <h6>(2) Mobile No. <?php echo $mb2; ?></h6>
                                                <h6>Landline No. <?php echo $ll; ?></h6>
                                            </div>

                                            <div class="text-end">
                                                <a href="admin_addmem.php?flags=2&editNo=<?php echo $memID; ?>"><button class="btn btn-success">Edit</button></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Background Information
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">

                                            <?php 
                                            
                                            //Empty Variables
                                            $ha = $sn = $tp = $bn = $bt = $cn = $ot = $mth = '';

                                            $sqldi = "SELECT 
                                                        highest, program, schlName
                                                    FROM tbeducinfo
                                                    WHERE memberID=?";
                                            $datadi = array($memID);
                                            $stmtdi = $conn->prepare($sqldi);
                                            $stmtdi->execute($datadi);
                                            $rowdi = $stmtdi->fetch();

                                            $sqlwork = "SELECT 
                                                            w.memBusInfo AS businessInfo, w.memBusType AS businessType, 
                                                            w.memOccuInfo AS occupationInfo, w.memCompName AS companyName,
                                                            m.monthlySize AS monthlyIncome
                                                        FROM tbworkinfo w
                                                        JOIN tbmonthly m ON w.monthlyID = m.monthlyID 
                                                        WHERE w.memberID=?";
                                            $datawork = array($memID);
                                            $stmtwork = $conn->prepare($sqlwork);
                                            $stmtwork->execute($datawork);
                                            $rowwork = $stmtwork->fetch();

                                            $ha = $rowdi['highest']; $sn = $rowdi['schlName']; $tp = $rowdi['program'];
                                            $bn = $rowwork['businessInfo']; $bt = $rowwork['businessType']; 
                                            $cn = $rowwork['companyName']; $ot = $rowwork['occupationInfo'];
                                            $mth = $rowwork['monthlyIncome'];
                                            ?>

                                            <div class="col-md-4">
                                                <h6>Highest Attainment : <?php echo $ha; ?></h6>
                                                <h6>School Name : <?php echo $sn; ?></h6>
                                                <h6>Track / Program : <?php echo $tp; ?></h6>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <h6>Business Name : <?php echo $bn; ?></h6>
                                                <h6>Business Type : <?php echo $bt; ?></h6>
                                            </div>
                                            
                                            <div class="col-md-4">
                                            <h6>Company Name : <?php echo $cn; ?></h6>
                                            <h6>Occupation Type :  <?php echo $ot; ?></h6>
                                            <h6>Monthly Income :  <?php echo $mth; ?></h6>
                                            </div>
                                        
                                            <div class="text-end">
                                                <a href="admin_addmem.php?flags=3&editNo=<?php echo $memID; ?>"><button class="btn btn-success">Edit</button></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                    Other Information
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="row g-3">

                                            <?php 
                                                
                                                $sss = $tin = $othID = $othIDno = '';
                                                $resi = $resiID = $resyear = $coop = $soc = $hob = '';

                                                $sqlOth = "SELECT
                                                            res.resiStatus AS resiStats, inf.InfoStats AS infoStats, 
                                                            oth.yearStay AS yearStay, oth.socint AS social,
                                                            oth.hobbies AS hobbies, oth.coop AS cooperative
                                                        FROM tbotherinfo oth
                                                        LEFT JOIN tbresistats res ON oth.resID = res.resID
                                                        LEFT JOIN tbinfostats inf ON oth.othInfoID = inf.othInfoID 
                                                        WHERE oth.memberID = ?";
                                                $dataOth = array($memID);
                                                $stmtOth = $conn->prepare($sqlOth);
                                                $stmtOth->execute($dataOth);
                                                $rowOth = $stmtOth->fetch();

                                                $resi = $rowOth['resiStats']; $resiID = $rowOth['infoStats']; $resyear = $rowOth['yearStay']; 
                                                $coop = $rowOth['cooperative']; $soc = $rowOth['social']; $hob = $rowOth['hobbies'];

                                            ?>

                                            <div class="col-md-4">
                                                <h6>Residential Type : <?php echo $resi; ?></h6>
                                                <h6>Residential Status : <?php echo $resiID; ?></h6>
                                                <h6>Residential Stay : <?php echo $resyear; ?></h6>
                                            </div>

                                            <div class="col-md-4">
                                                <h6>Social Interest : <?php echo $soc; ?></h6>
                                                <h6>Hobbies : <?php echo $hob; ?></h6>
                                                <h6>Other Cooperatives : <?php echo $coop; ?></h6>
                                            </div>

                                            <div class="text-end">
                                                <a href="admin_addmem.php?flags=4&editNo=<?php echo $memID; ?>"><button class="btn btn-success">Edit</button></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-5">
                                <a href="admin_pendings.php"><button class="btn btn-success">Finish</button></a>
                            </div>
                        </div>

                        </div> <!-- end of row -->
                    </fieldset>

                    </div>
                </div>
            </div>
        </div>
    </section>    
</main>

<?php require_once 'sidenavs/footer.php';  ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendo//r/apexcharts/apexcharts.min.js"></script>
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
<script src="jqueryto/ajaxiru.js"></script>

</body>
</html>
<?php 
    require_once 'process/app_regex.php';
?>
<script>
    $(function() {
        var active = $('fieldset.active')
        $('.next, .previous').click(function(e) {
        e.preventDefault();
        var target = $(this).closest('fieldset')[this.name]();
        if (target.length) {
            active.removeClass('active');
            target.addClass('active');
            active = target;
            }
        });
    });
</script>

<script>
    $(document).ready(function(){

        $('#highest').on('change', function(){
            var highID = $(this).val();
                if(highID){
                    $.ajax({
                        type: 'POST',
                        url: 'process/fetch_region.php',
                        data: 'highID=' + highID,
                        success: function(html){
                            $('#course').html(html);
                        }
                    });
                }else{
                    $('#course').html('<option value="">For Senior High or College</option>');
                }
        });
    });
</script>

<script>
    //Province
    $(document).ready(function(){

$('#reg').on('change', function(){
var regID = $(this).val();
if(regID){
    $.ajax({
        type: 'POST',
        url: 'process/fetch_region.php',
        data: 'regID=' + regID,
        success: function(html){
            $('#prov').html(html);
            $('#cit').html('<option value="">Select Province First</option>');
            $('#bar').html('<option value="">Select City First</option>');
        }
    });
}else{
    $('#prov').html('<option value="">Select Region First</option>');
    $('#cit').html('<option value="">Select Province First</option>');
    $('#bar').html('<option value="">Select City First</option>');
}
});

//City
$('#prov').on('change', function(){
var provID = $(this).val();
if(provID){
    $.ajax({
        type: 'POST',
        url: 'process/fetch_region.php',
        data: 'provID=' + provID,
        success: function(html){
            $('#cit').html(html);
            $('#bar').html('<option value="">Select City First</option>');
        }
    });
}else{
    $('#cit').html('<option value="">Select Province First</option>');
    $('#bar').html('<option value="">Select City First</option>');
}
});

//Baranggay
$('#cit').on('change', function(){
var citID = $(this).val();
if(citID){
    $.ajax({
        type: 'POST',
        url: 'process/fetch_region.php',
        data: 'citID=' + citID,
        success: function(html){
            $('#bar').html(html);
        }
    });
}else{
    $('#bar').html('<option value="">Select Region First</option>');
}
});
});
</script>

<script>
document.getElementById('dateToday').valueAsDate = new Date();
const dateformat = document.querySelector('#dateformat');

function validateDate(dateString) {
    const [year, month, day] = dateString.split('-');
    if (parseInt(year) === 1900) {
    return false; // reject 1900 as a valid year
}
    return true; // allow other dates
}

validateDate(dateformat.value); // returns false
</script>