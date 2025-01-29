<?php
    require_once 'cruds/config.php';
    require_once 'cruds/current_user.php';

    if(isset($_GET['pathmem'])){
        
        $pathmem = $_GET['pathmem'];
        $sqlpath="SELECT CONCAT(IF(p.gendID = 2,'Mr. ', IF(p.maritID = 1,'Ms. ', 'Mrs. ')), p.memSur,', ', p.memGiven, ' ', p.memMiddle, ' ', IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname,
                    p.ApplicationDate AS appd, p.memberID AS IDS
                FROM tbperinfo p
                LEFT JOIN tbsuffixes sf ON p.sufID=sf.sufID 
                WHERE p.memberID=?";
        $datapath = array($pathmem);
        $stmtpath=$conn->prepare($sqlpath);
        $stmtpath->execute($datapath);

        $res = $stmtpath->fetch();
        $fullname = $res['Fullname'];
        $IDS = $res['IDS'];

    }
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
        padding-left: 200px;
        padding-right: 200px;
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

    .ParentWrapper{
        padding-top: 30px;
        display: flex;
    }

    .steps{
        display: flex;
        flex-direction: column;
        background-color: aquamarine;
        width: 350px;
        height: 600px;
        padding-top: 50px;
        padding-left: 50px;
        margin-bottom: 20px;
        border-radius: 20px;;
    }
    .step {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  align-items: center;
  display: flex;
  flex-direction: row;
  justify-content: center;
  border: 1px solid white;
  color: white;
}

.step.active {
  background-color: pink;
  border: 1.875px solid lightblue;
  color: aquamarine;
}

    .stepInfo{
        display: flex;
        flex-direction: row;
        margin: 20px;
    }
    p{
        margin: 0 20px;
    }
    
    .formHolder{
        display: flex;
        flex-direction: column;
    }
    /* .mainForm{
        display: none;
    } */

    .personal {
        font-size: 36px;
        font-weight: 700;
        font-variant: normal;
        margin-bottom: 8px;
        padding-left: 40px;
        color: var(--marineBlue);
        }

    .personalInfo {
        color: var(--coolGray);
        font-size: 14px;
        font-weight: 450;
        padding-left: 40px;
        margin-bottom: 20px;
        }

    .fieldParent{
        padding-left: 67px;
        margin: 15px;
    }
    /* input[type="text"] {
    height: 50px;
    font-size : 50px;
} */

input.invalid{
    border-color: red;
}

.hidden{
    display: none;
}
.hideBtn{
    display: none;
}

  </style>

<?php

  require_once 'sidenavs/app_headers.php';
  
?>

<main class="gosh">

  <div class="pagetitle">
    <br><br>
    <!-- <h1>Membership</h1> -->
    <!-- <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="applicant_pendings.php">Pending</a></li>
        <li class="breadcrumb-item active">Application Form</li>
      </ol>
    </nav> -->
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
        <div class="card">
            <div class="card-body">

               <div class="ParentWrapper" data-step="1">

                 <div class="steps">

                    <div class="stepInfo">
                        <div class="step active" data-step="1" style="font-size:20px; padding-left:3px;">1</div>
                         <div class="stepName">
                            <p class="label" style="font-weight:bold;">STEP 1</p>
                            <p class="info">YOUR INFO</p>
                         </div>
                        </div>

                        <div class="stepInfo">
                        <div class="step" data-step="2" style="font-size:20px; padding-left:3px;">2</div>
                         <div class="stepName">
                            <p class="label" style="font-weight:bold;">STEP 2</p>
                            <p class="info">YOUR INFO</p>
                         </div>
                        </div>

                        <div class="stepInfo">
                        <div class="step" data-step="3" style="font-size:20px; padding-left:3px;">3</div>
                         <div class="stepName">
                            <p class="label" style="font-weight:bold;">STEP 3</p>
                            <p class="info">YOUR INFO</p>
                         </div>
                        </div>

                        <div class="stepInfo">
                        <div class="step" data-step="4" style="font-size:20px; padding-left:3px;">4</div>
                         <div class="stepName">
                            <p class="label" style="font-weight:bold;">STEP 4</p>
                            <p class="info">YOUR INFO</p>
                         </div>
                        </div>
                </div>

                    <div class="rightParentForm">
                        <div class="rightWrapper">

                            <div class="formHolder" data-step="1">

                                <!-- main form  -->
                                <div class="mainForm">

                                    <div class="title">
                                        <p class="personal">Personal Info</p>
                                        <p class="personalInfo">Please provide your name, email address, and phone number.</p>
                                    </div>
                                    
                                    <div class="form row">
                                    
                                        <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                    <label for="name">Name</label>
                                                    <p class="error"></p>
                                                </div>
                                            <input placeholder="e.g. Stephen King" type="text" id="name" name="name" class="form-control name ">
                                        </div>

                                        <div class="fieldParent col-md-12">
                                            <div class="labelErrorParent">
                                                <label for="email">Email Address</label>
                                                <p class="showError"></p>
                                            </div>
                                            <input placeholder="e.g. stephenking@lorem.com" type="email" id="email" name="email" class="form-control email">
                                        </div>

                                        <div class="fieldParent col-md-12">
                                            <div class="labelErrorParent">
                                                <label for="number">Phone Number</label>
                                                <p class="showError"></p>
                                            </div>
                                            <input placeholder="e.g. +1 234 567 890" type="text" id="number" name="number" class="form-control number">
                                        </div>


                                    </div>
                                </div><!-- End main form  -->

                            </div>

                            <div class="formHolder hidden" data-step="2">
                                <div class="mainForm">

                                    <div class="title">
                                        <p class="personal">Educational Info</p>
                                        <p class="personalInfo">Please provide your name, email address, and phone number.</p>
                                    </div>
                                    <div class="form row">
                                        <div class="fieldParent col-md-12">
                                            <div class="labelErrorParent">
                                            <label for="name">Name</label>
                                            <p class="error"></p>
                                            </div>
                                            <input placeholder="e.g. Stephen King" type="text" id="name" name="name" class="form-control name">
                                        </div>

                                        <div class="fieldParent col-md-12">
                                            <div class="labelErrorParent">
                                            <label for="email">Email Address</label>
                                            <p class="error"></p>
                                            </div>
                                            <input placeholder="e.g. stephenking@lorem.com" type="email" id="email" name="email" class="form-control email">
                                        </div>

                                        <div class="fieldParent col-md-12">
                                            <div class="labelErrorParent">
                                            <label for="number">Phone Number</label>
                                            <p class="error"></p>
                                            </div>
                                            <input placeholder="e.g. +1 234 567 890" type="text" id="number" name="number" class="form-control number">
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="formHolder hidden" data-step="3">
                                <div class="mainForm">

                                    <div class="title">
                                        <p class="personal">Experiences Info</p>
                                        <p class="personalInfo">Please provide your name, email address, and phone number.</p>
                                    </div>
                                        <div class="form row">
                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="name">Name</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. Stephen King" type="text" id="name" name="name" class="form-control name">
                                            </div>

                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="email">Email rawr</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. stephenking@lorem.com" type="email" id="email" name="email" class="form-control email">
                                            </div>

                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="number">Phone Number</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. +1 234 567 890" type="text" id="number" name="number" class="form-control number">
                                        </div>


                                </div>
                            </div>

                            </div>

                            <div class="formHolder hidden" data-step="4">
                                <div class="mainForm">

                                    <div class="title">
                                        <p class="personal">Skills Info</p>
                                        <p class="personalInfo">Please provide your name, email address, and phone number.</p>
                                    </div>
                                        <div class="form row">
                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="name">Name</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. Stephen King" type="text" id="name" name="name" class="form-control name">
                                            </div>

                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="email">Email eyy</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. stephenking@lorem.com" type="email" id="email" name="email" class="form-control email">
                                            </div>

                                            <div class="fieldParent col-md-12">
                                                <div class="labelErrorParent">
                                                <label for="number">Phone Number</label>
                                                <p class="error"></p>
                                                </div>
                                                <input placeholder="e.g. +1 234 567 890" type="text" id="number" name="number" class="form-control number">
                                        </div>


                                </div>
                            </div>

                            </div>


                        </div>
                    </div>  

                    <div class="btnWrapper">
                        <a class="btn hideBtn" id="prev">Previous</>
                        <a class="btn" id="next" style="background-color:#3edeff">Next Step</a>
                    </div>



            </div>


        </div>
    </div>
</section>

</main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php
  require_once 'sidenavs/centered_footer.php';
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
const name = document.querySelector(".name")
const email = document.querySelector(".email")
const phone = document.querySelector(".number")

//Form next and prev button
const nextBtn = document.querySelector("#next")
const prevBtn = document.querySelector("#prev")

//All Errors
const allLabelErrors = document.querySelectorAll("p")

//All Inputs
const allInputErrors = document.querySelectorAll("p")

//Fields Values
let userName;
let userEmail;
let userPhone;

const forms = document.querySelectorAll(".formHolder")

//All steps
const allSteps = document.querySelectorAll(".step")
let currentStep = 1

const regex = {
    name: /^[A-Za-z\s'-]+$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    phone: /^[0-9]+$/,
}

function addErrorToLabel(element, errorMessage) {
    const errorParent = element.previousElementSibling.querySelector("p")
    errorParent.innerText = errorMessage
    errorParent.classList.add("showError")
}

function removeErrorFromLabel(element) {
    const errorParent = element.previousElementSibling.querySelector("p")
    errorParent.innerText = ""
    errorParent.classList.remove("showError")
}

function setFieldErrors(element, errorMessage) {
    element.classList.add("borderError")
    addErrorToLabel(element, errorMessage)
}

function removeFieldErrors(element) {
    element.classList.remove("borderError")
    removeErrorFromLabel(element)
}

function getNameError(name) {

    if (name.length === 0) {
        return "This Field is required"

    } else {

        if (!regex.name.test(name)) {
            return "Enter a Valid Name"
        }

        return

    }

}

function getEmailError(email) {

    if (email.length === 0) {
        return "This Field is required"

    } else {

        if (!regex.email.test(email)) {
            return "Enter a Valid Email"
        }

        return

    }

}

function getPhoneError(phone) {

    if (phone.length === 0) {
        return "This Field is required"

    } else {

        if (!regex.phone.test(phone)) {
            return "Enter a Valid Phone Number"
        }

        return

    }

}

function validateAllFields() {

    const nameError = getNameError(name.value)
    nameError === undefined ? removeFieldErrors(name) : setFieldErrors(name, nameError)

    const emailError = getEmailError(email.value)
    emailError === undefined ? removeFieldErrors(email) : setFieldErrors(email, emailError)

    const phoneError = getPhoneError(phone.value)
    phoneError === undefined ? removeFieldErrors(phone) : setFieldErrors(phone, phoneError)
}

function checkAllLabelErrors() {
    return Array.from(allLabelErrors).some((error) => error.className.includes("showError"))
}

function checkAllInputErrors() {
    return Array.from(allInputErrors).some((input) => input.className.includes("showError"))
}

function incrementStep() {
    currentStep = currentStep < allSteps.length ? currentStep + 1 : 1
}

function decrementStep() {
    currentStep = currentStep > 1 ? currentStep - 1 : 1
}

function changeStepNumber() {

    allSteps.forEach((step) => {

        if (step.className.includes("active")) {
            step.classList.remove("active")
        }

        if (parseInt(step.dataset.step) === currentStep) {
            step.classList.add("active")
        }

    })
}

function changeForBackBtns() {

    nextBtn.dataset.step = currentStep
    prevBtn.dataset.step = currentStep

    if (parseInt(prevBtn.dataset.step) === 1) {
        prevBtn.classList.add("hideBtn")

    } else {
        prevBtn.classList.remove("hideBtn")
    }

    if (parseFloat(nextBtn.dataset.step) === 5) {
        document.querySelector(".btnWrapper").style.display = "none"
    }

    if (parseFloat(nextBtn.dataset.step) === 4) {
        nextBtn.innerText = "Confirm"
        nextBtn.classList.add("confirm")

    } else {
        nextBtn.innerText = "Next Step"
        nextBtn.style.backgroundColor = "hsl(213, 96%, 18%)"
        nextBtn.classList.remove("confirm")
    }

}

function changeForm() {

  forms.forEach((form) => {

        if (parseInt(form.dataset.step) === currentStep) {
            form.classList.remove("hidden")

        } else {
            form.classList.add("hidden")
        }

    })

}

//Name Validation
name.addEventListener("input", (e) => {
    const nameError = getNameError(e.target.value)
    nameError === undefined ? removeFieldErrors(name) : setFieldErrors(name, nameError)
})

//Email Validation
email.addEventListener("input", (e) => {
    const emailError = getEmailError(e.target.value)
    emailError === undefined ? removeFieldErrors(email) : setFieldErrors(email, emailError)
})

//Phone Validation && Using Text input even for number instead of type number because type="number" is not supported in firefox
phone.addEventListener("input", (e) => {

    const phoneError = getPhoneError(e.target.value)
    phoneError === undefined ? removeFieldErrors(phone) : setFieldErrors(phone, phoneError)

})


// NEXT BUTTON
nextBtn.addEventListener("click", (e) => {

    validateAllFields()
    const allErrors = checkAllInputErrors() || checkAllLabelErrors()

    if (!allErrors) {

        //Normal steps if validations are clear
        incrementStep() //incrementing the active state
        changeStepNumber()
        changeForBackBtns()
        changeForm()

    }

})

// BACK BUTTON
prevBtn.addEventListener("click", (e) => {

    decrementStep()
    changeStepNumber()
    changeForBackBtns()
    changeForm()

})

changeLink.addEventListener("click", () => {

    currentStep = 1
    changeStepNumber()
    changeForBackBtns()
    changeForm()

})

function resetAllInputs() {

    // Get references to the form
    const name = document.querySelector(".form")
    const inputFields = name.querySelectorAll("input")

    //Reset values of inputs
    inputFields.forEach((input) => {
        input.value = ""
    })
    
    // all checkboxes and radios in all forms are false on load
    radio.checked = false
    innerCheckBoxesofAddons.forEach((cb) => cb.checked = false)
}

resetAllInputs()
</script>