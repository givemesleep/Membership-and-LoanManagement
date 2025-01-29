<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>LLAMPCO | New Applicant</title>
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
    #header-background{
      background-color: #3260ab;
      padding:1px;
      padding-left: 10px;
      color: white;
      margin-top: 10px;
      border-radius: 5px;
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
  </style>

<?php

  require_once 'sidenavs/headers.php';
  $pages = 'app';  require_once 'sidenavs/ov_side.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Membership</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="applicant_pendings.php">Pending</a></li>
        <li class="breadcrumb-item active">Application Form</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 25px;"><b>Applicant Detail</b></h5>
                <a href="applicant_approved.php"><button type="btn" class="btn btn-dark" ><span class="bi bi-arrow-left"></span> Back</button></a>
                <br>
                <form id="frmpmes" action="process/proc_mempending.php" method="post">
                    
                    <fieldset class="active">
                        <div class="row g-3 mt-2">
                            <nav style="--bs-breadcrumb-divider: '>';">
                                <ol class="breadcrumb" style="font-size: 25px;">
                                    <li class="breadcrumb-item">Personal Information</li>
                                </ol>
                            </nav>

                        <header id=header-background>
                            <h6 class="mt-3"><b>Personal Information</b></h6>
                        </header>
                                
                        <input type="hidden" name="memid">
                                
                        <div class="col-md-3">
                            <label for="lname" class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-control letter" name="surname" id="" value="" required placeholder="Ex. Dela Cruz" style="text-transform: capitalize;">
                        </div>

                        <div class="col-md-3">
                            <label for="fname" class="form-label">Given Name <span class="required">*</span></label>  
                            <input type="text" class="form-control letter" name="givenname" id="" value="" required placeholder="Ex. Joselito" style="text-transform: capitalize;">
                        </div>

                        <div class="col-md-2">
                            <label for="floatingmini" class="form-label">Middle Name </label>
                            <input type="text" class="form-control letter" name="middle" id="" value="" placeholder="Ex. Santiago" style="text-transform: capitalize;">
                        </div>

                        <div class="col-md-2">
                            <label for="floatingex" class="form-label">Extension</label>
                                <select class="form-select" name="suffix" id="floatingex" aria-label="State" value="" placeholder="Select Suffix">
                                    <option value=" " selected>Select Suffix</option>
                                        <?php                               
                                            $sql = "SELECT * FROM tbsuffixes";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                
                                                echo '<option value="'.$row['sufID'].'">'.$row['suffixes'].'</option>';
                                            }
                                        ?>
                                </select>
                        </div>

                        <div class="col-md-2">
                            <label for="floatingnick" class="form-label">Nickname <span class="required">*</span></label>
                            <input type="text" class="form-control letter" name="nickname" id="floatingnick" value="" required placeholder="Ex. Lito" maxlength="15" style="text-transform: capitalize;">
                        </div>
                        
                        <div class="col-md-3">
                            <label for="floatingbday" class="form-label">Birthdate <span class="required">*</span></label>
                            <input type="date" class="form-control eyy" name="DOB" id="floatingbday" value="" required>
                        </div>

                        <div class="col-md-3">
                            <label for="floatingmarit" class="form-label">Marital Status<span class="required">*</span></label>
                                <select class="form-select eyy" name="cboMarital" id="floatingmarit" aria-label="State" value="" required placeholder="Select Marital Status">
                                    <option selected disabled>Select Marital</option>
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
                                
                        <div class="col-md-2">
                            <label for="floatinggen" class="form-label">Sex <span class="required">*</span></label>
                                <select class="form-select inpots" name="cboSex" id="floatinggen" value="" required placeholder="Select Sex">
                                    <option selected disabled>Select Sex</option>
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

                        <header class="mt-3" id=header-background>
                            <h6 class="mt-3"><b>Educational Information</b></h6>
                        </header>

                        <div class="col-md-4">
                            <label for="floatinghigh" class="form-label">Highest School Attainment<span class="required">*</span></label>  
                                <select class="form-select inpots" name="cboHighest" id="floatinghigh" aria-label="State" value="" required>
                                    <option selected disabled>Select Attainment</option>
                                        <?php 
                                            $sql = "SELECT * FROM tbeduclvl";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['edulvlID'].'">'.$row['edudescription'].'</option>';
                                            }
                                        ?>
                                </select>
                        </div>

                        <div class="col-md-4">
                            <label for="floatingsch" class="form-label">School Name <span class="required">*</span></label>
                            <input type="text" class="form-control letter" name="cboSchool" id="floatingsch" value="" required style="text-transform: capitalize;">
                        </div>
                
                        <div class="col-md-4">
                            <label for="floatingcour" class="form-label">Course/Program</label>
                                <select class="form-select" name="cboCourse" id="floatingcour" aria-label="State" value="">
                                    <option selected>Select Course</option>
                                        <?php 
                                            $sql = "SELECT * FROM tbcourses";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['eduCourID'].'">'.$row['courseDesc'].'</option>';
                                            }
                                        ?>
                                </select>
                        </div>
                            
                        <div class="text-end">
                            <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                        </div>
                        </div> <!-- end of row -->
                        
                    </fieldset>
                    <!-- f1  -->
                    <fieldset>
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <nav style="--bs-breadcrumb-divider: '>';">
                                    <ol class="breadcrumb" style="font-size: 25px;">
                                        <li class="breadcrumb-item">Personal Information</li>
                                        <li class="breadcrumb-item">Contact Information</li>
                                    </ol>
                                </nav>
                            </div>
                                <header id=header-background>
                                    <h6 class="mt-3"><b>Contact Information</b></h6>
                                </header>
              
                                <div class="col-md-4">
                                    <label for="floatingaddr" class="form-label">House No./Street/Subdivision <span class="required">*</span></label>
                                    <textarea name="addr" class="form-control" id="" cols="0" rows="1"  style="text-transform: capitalize;"></textarea>
                                    
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingprov" class="form-label">Province <span class="required">*</span></label>
                                    <select class="form-select inpots" name="cboProv" id="floatingprov" aria-label="State" value="" required>
                                        <option selected disabled>Select Province</option>
                                        <?php 
                                            $sql = "SELECT * FROM tbprov";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['provID'].'">'.$row['provname'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingcit" class="form-label">City <span class="required">*</span></label>  
                                    <select class="form-select inpots" name="cboCity" id="floatingcit" aria-label="State" value="" required>
                                        <option selected disabled>Select City</option>
                                        <?php 
                                            $sql = "SELECT * FROM tbcities";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['cityID'].'">'.$row['cityname'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="floatingbrgy" class="form-label">Barangay <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="brgy" id="floatingmob" value="" required placeholder="Ex. Llano" maxlength="20">
                                </div>

                                <div class="col-md-2">
                                    <label for="floatingmob" class="form-label">Mobile #<span class="required">*</span></label>  
                                    <div class="input-group">
                                        <span class="input-group-text">+63</span>
                                        <input type="text" class="form-control mobile number" name="mob1" id="floatingmob" value="" required placeholder="9xx-xxxx-xxx" maxlength="12">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="floatingmob" class="form-label">Mobile #</label>  
                                    <div class="input-group">
                                        <span class="input-group-text">+63</span>
                                        <input type="text" class="form-control mobile number" name="mob2" id="floatingmob" value=""  placeholder="9xx-xxxx-xxx" maxlength="12">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingland" class="form-label">Landline #</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+63 (2)</span>
                                        <input type="text" class="form-control landline number" name="landline" id="floatingland" value=""placeholder="12xx-xxxx" maxlength="9">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label for="floatingemail" class="form-label">Email Address <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="emailaddress" id="floatingemail" value="" required placeholder="Ex. juandelacruz@email.com" maxlength="50">
                                    </div>
                                </div>

                                <header class="mt-3" id="header-background">
                                    <h6 class="mt-3"><b>Business / Company Information</b></h6>
                                </header>
                        
                                <div class="col-md-4">
                                    <label for="floatingbname" class="form-label">Business Name</label>
                                    <input type="text" class="form-control letter " name="busname" id="floatingbname" value="" style="text-transform: capitalize;">
                                </div>

                                <div class="col-md-4">
                                    <label for="floatingbaddr" class="form-label">Business Address</label>
                                    <textarea name="busaddr" class="form-control letter" id="" cols="0" rows="1" style="text-transform: capitalize;"></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label for="floatingcity" class="form-label">Business City</label>
                                    <select class="form-select" name="buscity" id="floatingbcity" aria-label="State" placeholder="City" value="" placeholder="Select Business City">
                                    <option selected disabled>Select City</option>
                                        <?php
                                            $sql = "SELECT * FROM tbcities";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['cityID'].'">'.$row['cityname'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!-- <div class="col-md-4">
                                </div> -->

                                <div class="col-md-4">
                                    <label for="floatingcompany" class="form-label">Company Name</label>
                                    <input type="text" class="form-control letter" name="company" id="floatingcompany" value="" style="text-transform: capitalize;">
                                </div>

                                <div class="col-md-4">
                                    <label for="floatingoccup" class="form-label">Occupation</label>
                                    <input type="text" class="form-control letter" name="occupation" id="floatingoccup" value="" style="text-transform: capitalize;">
                                </div>

                                <div class="text-end">
                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                </div>                            
                        </div>
                    </fieldset>
                    <!-- f2  -->
                    <fieldset>
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <nav style="--bs-breadcrumb-divider: '>';">
                                    <ol class="breadcrumb" style="font-size: 25px;">
                                        <li class="breadcrumb-item">Personal Information</li>
                                        <li class="breadcrumb-item">Contact Information</li>
                                        <li class="breadcrumb-item">Beneficiary Information</li>
                                    </ol>
                                </nav>
                            </div>
                                <header id="header-background">
                                    <h6 class="mt-3"><b>Beneficiary Information</b></h6>
                                </header>
                
                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">(I) Beneficiary Fullname <span class="required">*</span></label>
                                    <input type="text" class="form-control letter" name="ben1"  value="" required placeholder="" maxlength="50">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Birthdate <span class="required">*</span></label>
                                    <input type="date" class="form-control" name="dob1" value="" required placeholder="">
                                </div>
                        
                                <div class="col-md-3">
                                    <label for="otherId" class="form-label" >Relationship <span class="required">*</span></label>
                                    <select class="form-select" name="rels1" id="" aria-label="State" value="" placeholder="Select Other ID">
                                    <option selected disabled>Select Relationship</option>
                                        <?php
                                        $sql = "SELECT * FROM tbrels";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        while($row=$stmt->fetch()){
                                            echo '<option value="'.$row['RelsID'].'">'.$row['relationship'].'</option>';
                                        }      
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Mobile # <span class="required">*</span></label>
                                    <div class="input-group">
                                    <span class="input-group-text">+63</span>
                                    <input type="text" class="form-control number mobile" name="benmob1" id="mobile"  value="" required maxlength="10">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">(II) Beneficiary Fullname </label>
                                    <input type="text" class="form-control  letter" name="ben2"  value=""   maxlength="50">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Birthdate </label>
                                    <input type="date" class="form-control" name="dob2" value=""  placeholder="">
                                </div>
                        
                                <div class="col-md-3">
                                    <label for="otherId" class="form-label" >Relationship </label>
                                    <select class="form-select" name="rels2" id="" aria-label="State" value="" placeholder="Select Other ID">
                                    <option selected disabled>Select Relationship</option>
                                        <?php
                                        $sql = "SELECT * FROM tbrels";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        while($row=$stmt->fetch()){
                                            echo '<option value="'.$row['RelsID'].'">'.$row['relationship'].'</option>';
                                        }       
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Mobile # </label>
                                    <div class="input-group">
                                    <span class="input-group-text">+63</span>
                                    <input type="text" class="form-control number mobile" name="benmob2" id=""  value=""  maxlength="10">    
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">(III) Beneficiary Fullname </label>
                                    <input type="text" class="form-control  letter" name="ben3"  value=""   maxlength="50">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Birthdate </label>
                                    <input type="date" class="form-control" name="dob3" value=""  placeholder="">
                                </div>
                        
                                <div class="col-md-3">
                                    <label for="otherId" class="form-label" >Relationship </label>
                                    <select class="form-select" name="rels3" id="" aria-label="State" value="" placeholder="Select Other ID">
                                    <option selected disabled>Select Relationship</option>
                                        <?php
                                        $sql = "SELECT * FROM tbrels";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        while($row=$stmt->fetch()){
                                            echo '<option value="'.$row['RelsID'].'">'.$row['relationship'].'</option>';
                                        }       
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">Mobile # </label>
                                    <div class="input-group">
                                    <span class="input-group-text">+63</span>
                                    <input type="text" class="form-control number mobile" name="benmob3" id=""  value=""  maxlength="10">    
                                    </div>
                                </div>
                            
                                <div class="text-end">
                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                    <input type="button" name="next" class="btn btn-primary next action-button" value="Next &raquo;">
                                </div> 

                            </div> <!-- end of row -->
                        
                    </fieldset>
                    <!-- f3  -->
                    <fieldset>  
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <nav style="--bs-breadcrumb-divider: '>';">
                                    <ol class="breadcrumb" style="font-size: 25px;">
                                        <li class="breadcrumb-item">Personal Information</li>
                                        <li class="breadcrumb-item">Contact Information</li>
                                        <li class="breadcrumb-item">Beneficiary Information</li>
                                        <li class="breadcrumb-item">Other Information</li>
                                    </ol>
                                </nav>
                            </div>
                                <header id="header-background">
                                    <h6 class="mt-3"><b>Identification(ID) Information</b></h6>
                                </header>
                
                                <div class="col-md-3">
                                    <label for="floatingsss" class="form-label">SSS No. <span class="required">*</span></label>
                                    <input type="text" class="form-control number SSS" name="sss" id="SSS"  value="" required placeholder="12-XXXXXXX-X" maxlength="12">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingtax" class="form-label">Tax Identification No. <span class="required">*</span></label>
                                    <input type="text" class="form-control number TIN" name="tin" id="TIN" value="" required placeholder="123-XXX-XXX-XXX" maxlength="15">
                                </div>
                        
                                <div class="col-md-3">
                                    <label for="otherId" class="form-label" >Other ID type </label>
                                    <select class="form-select" name="cboID" id="otherId" aria-label="State" value="" placeholder="Select Other ID">
                                    <option selected disabled>Select Other ID</option>
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

                                <div class="col-md-3">
                                    <label for="floatingotherno" class="form-label">Other ID No.</label>
                                    <input type="text" class="form-control" name="othID" id="otherIds" value="" maxlength="19">
                                </div>

                                <header class="mt-3" id="header-background">
                                    <h6 class="mt-3"><b>Other Information</b></h6>
                                </header> 
                  
                                <div class="col-md-3">
                                    <label for="floatingresi" class="form-label">Residential Status<span class="required">*</span></label>
                                    <select class="form-select inpots" name="cboResi" id="floatingresi" aria-label="State" placeholder="" value="" required placeholder="Select Residential Status">
                                    <option selected disabled>Select Residential Status</option>
                                        <?php
                                            $sql = "SELECT * FROM tbresistats";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            while($row=$stmt->fetch()){
                                                echo '<option value="'.$row['resiStatusID'].'">'.$row['resiStatus'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingstatus" class="form-label">Residential Info<span class="required">*</span></label>
                                    <select class="form-select inpots" name="cboResiID" id="floatingstatus" aria-label="State" placeholder="" value="" required placeholder="Select Residential Info">
                                    <option selected disabled>Select Residential Info</option>
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

                                <div class="col-md-3">
                                    <label for="floatingstay" class="form-label">Resident Year Stay<span class="required">*</span></label>
                                    <input type="date" class="form-control inpots" name="resyear" id="floatingstay" value="" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingincome" class="form-label">Monthly Income <span class="required">*</span></label>
                                    <select class="form-select inpots" name="monthly" id="floatingincome" aria-label="State" value="" required placeholder="Select Monthly Income">
                                    <option selected disabled>Select Monthly</option>
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

                                <div class="col-md-3">
                                    <label for="floatingsoc" class="form-label">Social Interest</label>
                                    <textarea name="soc" class="form-control letter" id="" cols="0" rows="1" style="text-transform: capitalize;"></textarea>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatinghob" class="form-label">Hobbies</label>
                                    <textarea name="hob" class="form-control letter" id="" cols="0" rows="1" style="text-transform: capitalize;"></textarea>
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingstay" class="form-label">Other Cooperatives</label>
                                    <input type="text" class="form-control inpots" name="coop" id="floatingstay" value="">
                                </div>

                                <div class="col-md-3">
                                    <label for="floatingstay" class="form-label">PMES Schedule<span class="required">*</span></label>
                                    <input type="date" class="form-control inpots" name="schedPMES" id="dateToday" value="" required>
                                </div>
                                
                                <div class="text-end">
                                    <input type="button" name="prev" class="btn btn-secondary previous action-button" value="&laquo; Previous">
                                    <input type="reset" class="btn btn-dark" value="Clear">
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                                
                            </div> <!-- end of row -->
                        
                    </fieldset>
                    <!-- f4  -->

                </form>
            </div>
        </div>
    </div>
</section>

</main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php
  require_once 'sidenavs/footer.php';
?> 
<!-- End Footer -->

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
    document.getElementById('dateToday').valueAsDate = new Date();

    // document.getElementById('dataToday').value = new Date().toDateInputValue();
    //  $("#penext").click(function(e){
    //     $('#borderedTabJustified li:nth-child(2) button').tab('show')
    // });
    // $("#penext1").click(function(e){
    //     $('#borderedTabJustified li:nth-child(3) button').tab('show')
    // });
    // $("#panext2").click(function(e){
    //     $('#borderedTabJustified li:nth-child(4) button').tab('show')
    // });
    
    // $("#ibalikmo1").click(function(e){
    //     $('#borderedTabJustified li:nth-child(1) button').tab('show')
    // });
    // $("#ibalikmo2").click(function(e){
    //     $('#borderedTabJustified li:nth-child(2) button').tab('show')
    // });
    // $("#ibalikmo3").click(function(e){
    //     $('#borderedTabJustified li:nth-child(3) button').tab('show')
    // });
    // $("#ibalikmo4").click(function(e){
    //     $('#borderedTabJustified li:nth-child(4) button').tab('show')
    // });
    // $("#ibalikmo5").click(function(e){
    //     $('#borderedTabJustified li:nth-child(4) button').tab('show')
    // });
</script>