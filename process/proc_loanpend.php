<?php 
require_once '../cruds/config.php';
require_once 'func_func.php';
$key="LLAMPCO";
session_start();


//Values
$memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
$loanID = htmlspecialchars(strip_tags(trim($_POST['loanID'])));
$loanAm = checkDecimal(htmlspecialchars(strip_tags(trim($_POST['lnAm']))));
$loanTerm = htmlspecialchars(strip_tags(trim($_POST['lnTerm'])));
$com1 = htmlspecialchars(strip_tags(trim($_POST['com1'])));
$com2 = htmlspecialchars(strip_tags(trim($_POST['com2'])));
$addedBy = htmlspecialchars(strip_tags(trim($_POST['AddedBy'])));
$cisp = htmlspecialchars(strip_tags(trim($_POST['cisp'])));

$term = $loanTerm;

//Insurance
if(!empty($_POST['insurance'])){
    $insurance = (int)htmlspecialchars(strip_tags(trim($_POST['insurance'])));
}else{
    $insurance = 0;
}   

//Member Unique ID

$sqlUn = "SELECT * FROM tbuninfo WHERE memberID = ?";
$dataUn = array($memID);
$stmtUn = $conn->prepare($sqlUn);
$stmtUn->execute($dataUn);
$rowUn = $stmtUn->fetch(PDO::FETCH_ASSOC);
$memUn = $rowUn['unID'];

$sqlrlc = "SELECT * FROM tbperinfo WHERE memberID = ?";
$datarlc = array($memID);
$stmtrlc = $conn->prepare($sqlrlc);
$stmtrlc->execute($datarlc);
$rowrlc = $stmtrlc->fetch(PDO::FETCH_ASSOC);
$rlcount = $rowrlc['rlCount'];
$igpcount = $rowrlc['igpCount'];

$depInfo = "SELECT shareCap AS PSC FROM tbdepinfo WHERE memberID = ?";
$dataDep = array($memID);
$stmtDep = $conn->prepare($depInfo);
$stmtDep->execute($dataDep);
$rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
$psc = $rowDep['PSC'];

$lnType = "SELECT intRate AS interest FROM tblntypes WHERE loanID = ?";
$dataType = array($loanID);
$stmtType = $conn->prepare($lnType);
$stmtType->execute($dataType);
$rowType = $stmtType->fetch(PDO::FETCH_ASSOC);
$interest = $rowType['interest'];

// getPayable($loanID, $loanAm, $term);


//Validation For Loan Max Amount Based on Loan Type

switch($loanID){
    case 1:
        $lnAm = $loanAm * 2; 
        $pscBal = $psc;

            if($rlcount == 1 && $lnAm > 20000 || $term < 3 || $loanAm > 10000 || $loanAm > $pscBal){ 
                
                if($insurance == 1){
                    $insurance = "invalidated";
                }
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }elseif($rlcount == 2 && $lnAm > 30000 || $term < 3 || $loanAm > 15000){

                if($insurance == 1){
                    $insurance = "invalidated";
                }
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
                
            }elseif($rlcount == 3 && $lnAm > 50000 || $term < 3 || $loanAm > 25000){

                if($insurance == 1){
                    $insurance = "invalidated";
                }
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");

            }else{

                $payable = getPayable($lnAm, $interest, $term);
                    foreach($payable as $pay){
                        $totInt = $pay['TotInt'];
                        $totOv = $pay['TotOv'];
                    }
                $int = $totInt;
                $ov = $totOv;
                // $insurance = "validated";
                // echo "Goodshit!";
                $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
                VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
                $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
                $stmtln = $conn->prepare($memln);
                $stmtln->execute($dataln);

                //SQL FOR COMAKER
                $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
                $datacoms1 = array($memID, $com1);
                $stmtcoms1 = $conn->prepare($coms1);
                $stmtcoms1->execute($datacoms1);

                $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
                $datacoms2 = array($memID, $com2);
                $stmtcoms2 = $conn->prepare($coms2);
                $stmtcoms2->execute($datacoms2);

                $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
                $dataperInfo = array($memID);
                $stmtper = $conn->prepare($perinfo);
                $stmtper->execute($dataperInfo);

                if($stmtln && $stmtcoms1 && $stmtcoms2){
                    // echo "Loan Application Successful!";
                    $_SESSION['lnSuc'] = 'Loan Application Successful!';
                    header("location: ../admin_lnpending.php");
                    // echo "Nag Submit na!"; 
                }else{
                    $enmem = encrypt($memUn, $key);
                    $enflag = encrypt('loanDetails', $key);
                    $enlnID = encrypt($loanID, $key);

                    $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                    header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
                }
            }

    break;

    case 2:
        $lnAm = $loanAm * 6; 
        if($igpcount == 1 && $loanAm > 150000 || $term < 3){

            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
        
        }elseif($igpcount == 2 && $loanAm > 200000 || $term < 3){

            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }elseif($igpcount == 3 && $loanID == 2 || $loanAm > 300000 && $term < 3){

            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 3:
        $PSC = "SELECT shareCap AS PSC FROM tbdepinfo WHERE memberID = ?";
        $dataPSC = array($memID);
        $stmtPSC = $conn->prepare($PSC);
        $stmtPSC->execute($dataPSC);    
        $rowPSC = $stmtPSC->fetch(PDO::FETCH_ASSOC);
        $psc = $rowPSC['PSC'];
        $newPSC = 0.9 * $psc;
        $lnAm = $loanAm;

        if($lnAm > $newPSC || $term < 3){
            
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");

        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;

            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }


    break;

    case 4:
        $depInfo = "SELECT timeDep AS TD FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($depInfo);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $timeDep = $rowDep['TD'];
        // $newTD = 0.9 * $timeDep;

        $lnAm = $loanAm;
        if($lnAm != $timeDep || $term < 3){
            
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
        }else{

            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;

            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 5:
        $lnAm = $loanAm;
        if($lnAm > 1500 || $term != 1){

            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;

            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnprincipal,loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm,$loanTerm, $int, $ov, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 6:
        $lnAm = $loanAm;
        if($lnAm > 3000 || $lnAm < 5000 || $term != 2){
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnprincipal,loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm,$loanTerm, $int, $ov, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 7:
        $lnAm = $loanAm;
        if($lnAm > 20000 || $term < 3 && $term > 6){
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnprincipal,loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm,$loanTerm, $int, $ov, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 8:
        $lnAm = $loanAm;
        if($lnAm > 50000 || $term < 3 && $term > 6){
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnprincipal,loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm,$loanTerm, $int, $ov, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;
    
    case 9:
        $lnAm = $loanAm;
        if($lnAm > 20000 || $lnAm > 50000 || $term != 3 || $term != 12){
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;

            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }
        
    break;

    case 10:
        if($loanTerm != 10 || $term != 5){
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }
        
    break;
    
    case 11:
        $lnAm = $loanAm;
        $maxPSC = 6 * $psc;
        if($maxPSC < $lnAm || $term < 3 ){
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
        }else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }

    break;

    case 12:
        $lnAm = $loanAm;
        if($lnAm > 20000 || $term != 12){
            if($insurance == 1){
                $insurance = "invalidated";
            }
            $enmem = encrypt($memUn, $key);
            $enflag = encrypt('loanDetails', $key);
            $enlnID = encrypt($loanID, $key);
        
            $_SESSION['lnErr'] = 'Invalid Loan Amount or Term!';
            header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            
        }
        else{
            $payable = getPayable($lnAm, $interest, $term);
                foreach($payable as $pay){
                    $totInt = $pay['TotInt'];
                    $totOv = $pay['TotOv'];
                }
            $int = $totInt;
            $ov = $totOv;
            $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, lnPrincipal, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, cispRef, isInsurance, AddedBy, remarks)
            VALUES(?,?,?,?,?,?,?,2,NOW(),0,?,1,?,0)";
            $dataln = array($memID, $loanID, $lnAm, $lnAm, $loanTerm, $int, $ov, $cisp, $addedBy);
            $stmtln = $conn->prepare($memln);
            $stmtln->execute($dataln);

            //SQL FOR COMAKER
            $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms1 = array($memID, $com1);
            $stmtcoms1 = $conn->prepare($coms1);
            $stmtcoms1->execute($datacoms1);

            $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
            $datacoms2 = array($memID, $com2);
            $stmtcoms2 = $conn->prepare($coms2);
            $stmtcoms2->execute($datacoms2);

            $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
            $dataperInfo = array($memID);
            $stmtper = $conn->prepare($perinfo);
            $stmtper->execute($dataperInfo);

            if($stmtln && $stmtcoms1 && $stmtcoms2){
                // echo "Loan Application Successful!";
                $_SESSION['lnSuc'] = 'Loan Application Successful!';
                header("location: ../admin_lnpending.php");
                // echo "Nag Submit na!"; 
            }else{
                $enmem = encrypt($memUn, $key);
                $enflag = encrypt('loanDetails', $key);
                $enlnID = encrypt($loanID, $key);

                $_SESSION['lnErr'] = 'Loan Application Unsuccessful!';    
                header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
            }
        }
    break;
}

    // header("location: ../admin_createloan.php");

// if($insurance == "validated"){
// $ins = 1;

//Has Ensurance
// $memln = "INSERT INTO tbloaninfo(memberID, loanID, loanAm, loanTerm, lnTotInt, lnTotMos, lnstatID, lnApply, isActivate, isInsurance, AddedBy, remarks)
// VALUES(?,?,?,?,?,?,2,NOW(),0,1,?,0)";
// $dataln = array($memID, $loanID, $loanAm, $term, $totInt, $totOv, $addedBy);
// $stmtln = $conn->prepare($memln);
// $stmtln->execute($dataln);

// //SQL FOR COMAKER
// $coms1 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
// $datacoms1 = array($memID, $com1);
// $stmtcoms1 = $conn->prepare($coms1);
// $stmtcoms1->execute($datacoms1);

// $coms2 = "INSERT INTO tbcominfo(memberID, memberName, isActive)VALUES(?,?,1)";
// $datacoms2 = array($memID, $com2);
// $stmtcoms2 = $conn->prepare($coms2);
// $stmtcoms2->execute($datacoms2);

// $perinfo = "UPDATE tbperinfo SET isLoan = 1 WHERE memberID=? ";
// $dataperInfo = array($memID);
// $stmtper = $conn->prepare($perinfo);
// $stmtper->execute($dataperInfo);

// $_SESSION['lnSuc'] = 'Loan Application Successful!';
// header("location: ../admin_lnpending.php");
// $enmem = encrypt($memUn, $key);
// $enflag = encrypt('Beneficiary', $key);
// header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag");

// }

// elseif($insurance == 0 || $ins == 0){

//No Insurance

// }








?>