<?php 

require_once '../cruds/config.php';

$flag = 0;

//fetch flag
if(isset($_GET['inp'])){
    $flag = $_GET['inp'];
    switch($flag){

        case 1:
            //Step 1 : Basic Information
            $basID = htmlspecialchars(trim(strip_tags($_POST['basicID'])));
            $basicEdit = htmlspecialchars(trim(strip_tags($_POST['basicEdit'])));
            $surname = htmlspecialchars(trim(strip_tags(strtoupper($_POST['surname']))));
            $givenname = htmlspecialchars(trim(strip_tags(strtoupper($_POST['givenname']))));
            $middle = htmlspecialchars(trim(strip_tags(strtoupper($_POST['middle']))));
            $nickname = htmlspecialchars(trim(strip_tags(strtoupper($_POST['nickname']))));
            $suffix = htmlspecialchars(trim(strip_tags(strtoupper($_POST['ext']))));
            $birthdate = htmlspecialchars(trim(strip_tags($_POST['DOB'])));
            $marital = htmlspecialchars(trim(strip_tags($_POST['cboMarital'])));
            $gender = htmlspecialchars(trim(strip_tags($_POST['cboSex'])));

            if($basicEdit != '' || $basicEdit != null){
                //SQL Update Existing Information
                $sqlBasic = "UPDATE tbperinfo SET memSur = ?, memGiven = ?, memMiddle = ?, suffixes = ?, memNick = ?, maritID = ?, gendID = ?, memDOB = ? WHERE memberID = ?";
                $dataBasic = array($surname, $givenname, $middle, $suffix, $nickname, $marital, $gender, $birthdate, $basicEdit);
                $stmtBasic=$conn->prepare($sqlBasic);
                $stmtBasic->execute($dataBasic);

                //Flag ID
                $flags = 5;
                
                //Fetching Last ID
                $lastID = $conn->lastInsertId();

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$basicEdit");


            }else{
                //SQL Insert
                $sqlBasic = "INSERT INTO tbperinfo(memstatID, memSur, memGiven, memMiddle, suffixes, memNick, maritID, gendID, memDOB, isApproved, Score)
                        VALUES(3, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0.0)";
                $dataBasic = array($surname, $givenname, $middle, $suffix, $nickname, $marital, $gender, $birthdate);
                $stmtBasic=$conn->prepare($sqlBasic);
                $stmtBasic->execute($dataBasic);

                //Flag ID
                $flags = 2;

                $lastID = $conn->lastInsertId();

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");
            }    
        break;

        case 2 :
            //Step 2 : Contact Information
            $conID = htmlspecialchars(trim(strip_tags($_POST['conID'])));
            $conEdit = htmlspecialchars(trim(strip_tags($_POST['conEdit'])));
            $house = htmlspecialchars(trim(strip_tags(strtoupper($_POST['street']))));
            $region = htmlspecialchars(trim(strip_tags($_POST['cboReg'])));
            $prov = htmlspecialchars(trim(strip_tags($_POST['cboProv'])));
            $city = htmlspecialchars(trim(strip_tags($_POST['cboCity'])));
            $brgy = htmlspecialchars(trim(strip_tags($_POST['cboBrgy'])));
            $zip = htmlspecialchars(trim(strip_tags($_POST['zip'])));
            $email = htmlspecialchars(trim(strip_tags($_POST['email'])));
            $mob1 = htmlspecialchars(trim(strip_tags($_POST['mob1'])));
            $mob2 = htmlspecialchars(trim(strip_tags($_POST['mob2'])));
            $landline = htmlspecialchars(trim(strip_tags($_POST['land'])));

            if($conEdit != '' || $conEdit != null){
                //SQL Update Existing Information
                $sqlContact = "UPDATE tbconinfo SET memaddr = ?, regsID = ?, provID = ?, citID = ?, brgyID = ?, zipcode = ?, memmob1 = ?, memmob2 = ?, memlan = ?, mememail = ? WHERE memberID = ?";
                $dataContact = array($house, $region, $prov, $city, $brgy, $zip, $mob1, $mob2, $landline, $email, $conEdit);
                $stmtCont=$conn->prepare($sqlContact);
                $stmtCont->execute($dataContact);

                //Flag ID
                $flags = 5;

                //Fetching Last ID
                $lastID = $conEdit;

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");

            }else{
                //SQL Insert
                $sqlContact = "INSERT INTO tbconinfo(memberID, memaddr, region, province, city, brgy, zipcode, memmob1, memmob2, memlan, mememail)
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $dataContact = array($conID, $house, $region, $prov, $city, $brgy, $zip, $mob1, $mob2, $landline, $email);
                $stmtCont=$conn->prepare($sqlContact);
                $stmtCont->execute($dataContact);

                //Flag ID
                $flags = 3;

                //Fetching Last ID
                $fetchLastID = "SELECT * FROM tbconinfo WHERE memberID = ?";
                $dataLastID = array($conID);
                $stmtLastID=$conn->prepare($fetchLastID);
                $stmtLastID->execute($dataLastID);
                $rowLastID = $stmtLastID->fetch(PDO::FETCH_ASSOC);
                $lastID = $conID;

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");
            }
        break;

        case 3: 
            //Step 4 : Background Information
            $perID = htmlspecialchars(trim(strip_tags($_POST['perID'])));
            $backEdit = htmlspecialchars(trim(strip_tags($_POST['backEdit'])));
            $highest = htmlspecialchars(trim(strip_tags($_POST['cboHigh'])));
            $prevSch = htmlspecialchars(trim(strip_tags(strtoupper($_POST['prevSch']))));
            $course = htmlspecialchars(trim(strip_tags($_POST['cboPrograms'])));
            $business = htmlspecialchars(trim(strip_tags(strtoupper($_POST['busname']))));
            $company = htmlspecialchars(trim(strip_tags(strtoupper($_POST['company']))));
            $occupation = htmlspecialchars(trim(strip_tags($_POST['occuType'])));
            $busTypes = htmlspecialchars(trim(strip_tags(strtoupper($_POST['busType']))));
            $monthly = htmlspecialchars(trim(strip_tags($_POST['monthly'])));

            if($backEdit != '' || $backEdit != null){
                //SQL Update Existing Information
                $sqlSchool = "UPDATE tbeducinfo SET highest = ?, program = ?, schlName = ? WHERE memberID = ?";
                $dataSchool = array($highest, $course, $prevSch, $backEdit);
                $stmtSchool=$conn->prepare($sqlSchool);
                $stmtSchool->execute($dataSchool);

                $sqlEmp = "UPDATE tbworkinfo SET memBusInfo = ?, memBusType = ?, memOccuInfo = ?, memCompName = ?, monthlyID = ? WHERE memberID = ?";
                $dataEmp = array($business, $busTypes, $occupation, $company, $monthly, $backEdit);
                $stmtEmp=$conn->prepare($sqlEmp);
                $stmtEmp->execute($dataEmp);

                //Flag ID
                $flags=5;

                //Fetching Last ID
                $lastID = $backEdit;

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");
            }else{
                //SQL Insert
                $sqlSchool = "INSERT INTO tbeducinfo(memberID, highest, program, schlName)
                            VALUES (?, ?, ?, ?)";
                $dataSchool = array($perID, $highest, $course, $prevSch);
                $stmtSchool=$conn->prepare($sqlSchool);
                $stmtSchool->execute($dataSchool);

                $sqlEmp = "INSERT INTO tbworkinfo(memberID, memBusInfo, memBusType, memOccuInfo, memCompName, monthlyID)
                            VALUES (?, ?, ?, ?, ?, ?)";
                $dataEmp = array($perID, $business, $busTypes, $occupation, $company, $monthly);
                $stmtEmp=$conn->prepare($sqlEmp);
                $stmtEmp->execute($dataEmp);

                //Flag ID
                $flags=4;

                //Fetching Last ID
                $lastID = $perID;

                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");
            }
        break;

        case 4:
            //Step 4 : Other Information
            $othID = htmlspecialchars(trim(strip_tags($_POST['othersID'])));
            $othEdit = htmlspecialchars(trim(strip_tags($_POST['othEdit'])));
            $resiType = htmlspecialchars(trim(strip_tags($_POST['cboResi'])));
            $resiStats = htmlspecialchars(trim(strip_tags($_POST['cboResiID'])));
            $resiStay = htmlspecialchars(trim(strip_tags($_POST['resyear'])));
            $socint = htmlspecialchars(trim(strip_tags($_POST['soc'])));//
            $hob = htmlspecialchars(trim(strip_tags($_POST['hob'])));
            $coop = htmlspecialchars(trim(strip_tags($_POST['coop'])));
            // $prevID = htmlspecialchars(trim(strip_tags($_POST['prevID'])));

            if($othEdit != '' || $othEdit != null){
                //SQL Update Existing Information
                $sqlMonthly = "UPDATE tbworkinfo SET monthlyID = ? WHERE memberID = ?";
                $dataMonthly = array($monthly, $othEdit);
                $stmtMonthly=$conn->prepare($sqlMonthly);
                $stmtMonthly->execute($dataMonthly);

                $sqlOth = "UPDATE tbotherinfo SET resID = ?, othInfoID = ?, yearStay = ?, socint = ?, hobbies = ?, coop = ? WHERE memberID = ?";
                $dataOth = array($resiType, $resiStats, $resiStay, $socint, $hob, $coop, $othEdit);
                $stmtOth=$conn->prepare($sqlOth);
                $stmtOth->execute($dataOth);

                $flags=5; //preview
                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$othEdit");
                
            }else{

                $sqlOth = "INSERT INTO tbotherinfo(memberID, resID, othInfoID, yearStay, socint, hobbies, coop)
                            VALUES(?,?,?,?,?,?,?)";
                $dataOth = array($othID, $resiType, $resiStats, $resiStay, $socint, $hob, $coop);
                $stmtOth=$conn->prepare($sqlOth);
                $stmtOth->execute($dataOth);

                $flags=5; //preview

                // $lastID = $othID;

                //Fetching Last ID
                $lastID = $othID;
                
                //Header
                header("Location: ../admin_addmem.php?flags=$flags&lastID=$lastID");
            }
        
        break;
        case 5:
            
        break;
            
    }
}

?>