<?php 

    //FUCK ERROR
    require_once '../cruds/config.php';
    require_once 'func_func.php';

    //Checker
    $checkID = '';
    $ids = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    $sqlUnID = "SELECT * FROM tbuninfo WHERE memberID = ?";
    $dataUnID = array($ids);
    $stmtUnID = $conn->prepare($sqlUnID);
    $stmtUnID->execute($dataUnID);
    $rowUnID = $stmtUnID->fetch(PDO::FETCH_ASSOC);
    $checkID = $rowUnID["unID"];
    
    //Values
    $conduct = htmlspecialchars(strip_tags(trim($_POST['conducts'])));   
    $checkRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    $depType = htmlspecialchars(strip_tags(trim($_POST['depType'])));
    $depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));

    //IF values are empty
    // $ref = htmlspecialchars(strip_tags(trim($_POST['memName']))); 
    // $referral = '';
    // if($ref == ''){
    //     $ref = 0;
    // }else{
    //     $referral = $ref;
    // }

    //Return if Check and Invoice are both empty
    if($invRef == null && $checkRef == null){
        header("Location: ../admin_paypmes.php?pmes=$checkID");
    }

    //Amounts
    $Amount = checkDecimal($depAm);
    $regFee = 150.00;
    $deathCare = 500.00;

    // echo $Amount;

    //Validations
    if($depType == 1){
        if($Amount > 50.00 || $Amount >= 2400.00){
            //SQL Statement

            //SQL PMES 
            $sqlPMES = "INSERT INTO tbpmesinfo(memberID, referName, conductID, approvedBy, isPaid)
            VALUES(?,?,?,?,?)";
            $dataPMES = array($ids, 0, $conduct, 1, 1);
            $stmtPMES = $conn->prepare($sqlPMES);
            $stmtPMES->execute($dataPMES);

            //SQL DEPINFO
            $sqlDEP = "INSERT INTO tbdepinfo(memberID, regSav, regFee, dtCare)
                        VALUES(?,?,?,?)";
            $dataDEP = array($ids, $Amount, $regFee, $deathCare);
            $stmtDEP = $conn->prepare($sqlDEP);
            $stmtDEP->execute($dataDEP);

            if($invRef != ''){
                //SQL DEP HISTORY
            $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
                        VALUES(?,?,?,?,NOW())";
            $dataHIS = array($ids, 1, $Amount, $invRef);
            $stmtHIS = $conn->prepare($sqlHIS);
            $stmtHIS->execute($dataHIS);

            }else{
                //SQL DEP HISTORY
            $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, CheckRef, datePay)
                        VALUES(?,?,?,?,NOW())";
            $dataHIS = array($ids, 1, $Amount, $invRef);
            $stmtHIS = $conn->prepare($sqlHIS);
            $stmtHIS->execute($dataHIS);
            }

            //SQL TRAN
            $sqlTRAN = "INSERT INTO tbtransinfo(memberID, transID, trDesc, trAmount, trTD, isVoid)
                        VALUES(?,?,?,?,NOW(),?)";
            $dataTRAN = array($ids, 1, "Regular Savings", $Amount, 0);
            $stmtTRAN = $conn->prepare($sqlTRAN);
            $stmtTRAN->execute($dataTRAN);
            
            $sqlperInfo = "UPDATE tbperinfo SET memstatID = ? WHERE memberID = ?";
            $dataPerInfo = array(2, $ids);
            $stmtPerInfo = $conn->prepare($sqlperInfo);
            $stmtPerInfo->execute($dataPerInfo);

            if($stmtPMES && $stmtDEP && $stmtHIS && $stmtTRAN && $stmtPerInfo){
                //Return Page if True
                header("Location: ../admin_paypmes.php");
                //ALert (Success)
            }else{
                //Return Page if False
                header("Location: ../admin_paypmes.php?pmes=$checkID");
                //ALert (Failed)
            }                    
            }
    }else{
        if($depType == 2 && $Amount == 2400.00){
            //SQL Statement
        
            //SQL PMES 
            $sqlPMES = "INSERT INTO tbpmesinfo(memberID, referName, conductID, approvedBy, isPaid)
            VALUES(?,?,?,?,?)";
            $dataPMES = array($meidsmID, $ref, $conduct, 1, 1);
            $stmtPMES = $conn->prepare($sqlPMES);
            $stmtPMES->execute($dataPMES);
        
            //SQL DEPINFO
            $sqlDEP = "INSERT INTO tbdepinfo(memberID, shareCap, regFee, dtCare)
                        VALUES(?,?,?,?)";
            $dataDEP = array($ids, $Amount, $regFee, $deathCare);
            $stmtDEP = $conn->prepare($sqlDEP);
            $stmtDEP->execute($dataDEP);
        
            if($invRef != ''){
                //SQL DEP HISTORY
            $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
                        VALUES(?,?,?,?,NOW())";
            $dataHIS = array($ids, 2, $Amount, $invRef);
            $stmtHIS = $conn->prepare($sqlHIS);
            $stmtHIS->execute($dataHIS);

            }else{
                //SQL DEP HISTORY
            $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, CheckRef, datePay)
                        VALUES(?,?,?,?,NOW())";
            $dataHIS = array($ids, 2, $Amount, $invRef);
            $stmtHIS = $conn->prepare($sqlHIS);
            $stmtHIS->execute($dataHIS);
            }

            //SQL TRAN
            $sqlTRAN = "INSERT INTO tbtransinfo(memberID, transID, trDesc, trAmount, trTD, isVoid)
                        VALUES(?,?,?,?,NOW(),?)";
            $dataTRAN = array($ids, 2, "Share Capital", $Amount, 0);
            $stmtTRAN = $conn->prepare($sqlTRAN);
            $stmtTRAN->execute($dataTRAN);

            $sqlperInfo = "UPDATE tbperinfo SET memstatID = ?, isApproved = 1 WHERE memberID = ?";
            $dataPerInfo = array(1, $ids);
            $stmtPerInfo = $conn->prepare($sqlperInfo);
            $stmtPerInfo->execute($dataPerInfo);

            if($stmtPMES && $stmtDEP && $stmtHIS && $stmtTRAN && $stmtPerInfo){
                //Return Page if True
                header("Location: ../admin_paypmes.php");
                //ALert (Success)
            }else{
                //Return Page if False
                header("Location: ../admin_paypmes.php?pmes=$saveID");
                //ALert (Failed)
            }
            
        }else{
            //Return if False both Conditions
            header("Location: ../admin_paypmes.php?pmes=$checkID");
        }
    }



?>