<?php 
    require_once '../cruds/config.php';
    require_once 'func_func.php';
    require_once '../cruds/current_user.php';

    if(isset($_GET['review'])){
        $flag = $_GET['review'];
        
        if($flag == 1){
            $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
            $appBy = htmlspecialchars(strip_tags(trim($_POST['AddedBy'])));
            $invNo = htmlspecialchars(strip_tags(trim($_POST['invNo'])));
            $cvRef = htmlspecialchars(strip_tags(trim($_POST['cvRef'])));

            $sqlPer = "SELECT memDOB AS BDAY FROM tbperinfo WHERE memberID = ?";
        $dataPer = array($memID);
        $stmtPer = $conn->prepare($sqlPer);
        $stmtPer->execute($dataPer);
        $rowPer = $stmtPer->fetch(PDO::FETCH_ASSOC);
        $bday = bday($rowPer['BDAY']);

        $lninfo = "SELECT loanID AS lnID, loanAm AS Amount, lnTotMos AS totAm, loanTerm AS Term, lnPrincipal AS prin FROM tbloaninfo WHERE memberID = ? AND isActivate = 0";
        $dataLn = array($memID);
        $stmtLn = $conn->prepare($lninfo);
        $stmtLn->execute($dataLn);
        $rowLn = $stmtLn->fetch(PDO::FETCH_ASSOC);
        $principal = $rowLn['Amount'];
        $terms = $rowLn['Term'];
        $lnID = $rowLn['lnID'];
        $prin = $rowLn['prin'];
        $totAm = $rowLn['totAm'];

        $sqlDep = "SELECT regSav AS RL, shareCap AS PSC, timeDep AS TD, speVol AS SV, speSav AS SS, funSav AS FS
                FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($sqlDep);
        $stmtDep->execute($dataDep);
        $resDep = $stmtDep->rowCount();
        if($resDep > 0){
            $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
            $regL = $rowDep['RL'];
            $shareCap = $rowDep['PSC'];
            $timeDep = $rowDep['TD'];
            $speVol = $rowDep['SV'];
            $speSav = $rowDep['SS'];
            $funSav = $rowDep['FS'];
        }else{
            $regL = 0;
            $shareCap = 0;
            $timeDep = 0;
            $speVol = 0;
            $speSav = 0;
            $funSav = 0;
        }

        //Minus servcFee, cbu, defCollFee, colatFee
        $sqlHanded = "SELECT loanAcro AS lnAcro, servcFee AS service, cbu AS cbu, defCollFee AS def, lppiID AS LPPI, intRate AS interest FROM tblntypes WHERE loanID = ?";
        $dataHanded = array($lnID);
        $stmtHanded = $conn->prepare($sqlHanded);
        $stmtHanded->execute($dataHanded);
        $resHanded = $stmtHanded->rowCount();
        if($resHanded > 0){
            $rowHanded = $stmtHanded->fetch(PDO::FETCH_ASSOC);
            $service = perTodec($rowHanded['service']);
            $cbu = perTodec($rowHanded['cbu']);
            $def = perTodec($rowHanded['def']);
            $lppi = $rowHanded['LPPI'];
            $intRate = $rowHanded['interest'];
        }else{
            $service = 0;
            $cbu = 0;
            $def = 0;
        }

        $ServiceFee = $principal * $service;
        $Cbu = $principal * $cbu;
        $DefColl = $principal * $def;

        if($lnID == 1 || $lnID == 2){
            //Which lowest
            $collat = whichLow($principal);  
        }else{
            $collat = 0;
        }

        //Get LPPI
        $LPPI = LPPI($bday, $terms, $principal, $lppi);
        
        $benef = $principal * $LPPI;
        $lnOv = $principal - $ServiceFee - $Cbu - $DefColl - $collat - $benef;

        // echo 'Original Principal : ' . $principal . '<br>';
        
        // echo 'Service Fee  : ' . $ServiceFee . '<br>';
        // echo 'CBU  : ' . $Cbu . '<br>';
        // echo 'Deferred Coll. Fee  :  ' . $DefColl . '<br>';
        // echo 'Collateral Fee  :  ' . $collat . '<br>';
        // echo 'Handed Amount : ' . $lnOv . '<br>';
        // echo $due;

        //Generate Maturity
        $Today = date('Y-m-d');
        $payment = getMaturity($terms, $Today);
        foreach($payment as $values){
            $due = $values['due'];
        }

        //Create Loan Unique ID
        $sqlLn = "SELECT loanAcro AS lnA FROM tblntypes WHERE loanID = ?";
        $dataLn = array($lnID);
        $stmtLn = $conn->prepare($sqlLn);   
        $stmtLn->execute($dataLn);
        
        $rowLn = $stmtLn->fetch(PDO::FETCH_ASSOC);
        $acro = $rowLn['lnA'];
        
        $loanInfo = "SELECT COUNT(*) AS lnCount FROM tbloaninfo WHERE loanID = ? AND isActivate = 1";
        $dataInfo = array($lnID);
        $stmtInfo = $conn->prepare($loanInfo);
        $stmtInfo->execute($dataInfo);
        $rowInfo = $stmtInfo->fetch(PDO::FETCH_ASSOC);
        $lnCount = $rowInfo['lnCount'];

        $lnunID = $acro . '00' . $lnCount;

        //Update tbloaninfo
        $today = new DateTime();
        $today->modify('+1 month');
        $now = $today->format('Y-m-d');

        $newint = perTodec($intRate) * $principal;

        $sqlApp = "UPDATE tbloaninfo SET lnHanded = ?, lnunID = ?, lnMonInt = ?, loanAcquire = NOW(), loanMaturity = ?, loanMonthPay = ? ,isActivate = 1, lnstatID = 1, AppBy = ? WHERE memberID = ? AND isActivate = 0 AND lnstatID != 5";
        $dataApp = array($lnOv, $lnunID, $newint, $due, $now, $appBy, $memID);
        $stmtApp = $conn->prepare($sqlApp);
        $stmtApp->execute($dataApp);

        $sqlhisInfo = "INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, InvoiceNo, CheckRef, cvRef, lnDate, lnTime)
                    VALUES(?,?,?,?,?,?,?,NOW(),NOW())";
        $datahisInfo = array($memID, $lnID, $lnunID, $totAm, $invNo, 0, $cvRef);
        $stmthisInfo = $conn->prepare($sqlhisInfo);
        $stmthisInfo->execute($datahisInfo);

        //Update Deposit
        switch($lnID){
            case 1: //Regular Loan
                $rl = $prin - $shareCap;
                $newAm = $rl + $Cbu;

                $sqlDep = "UPDATE tbdepinfo SET shareCap = ? WHERE memberID = ?";
                $dataDep = array($newAm, $memID);
                $stmtDep = $conn->prepare($sqlDep);
                $stmtDep->execute($dataDep);

            break;

            case 2: //IGP Loan
                $newAm = $shareCap - $prin + $Cbu;

                $sqlDep = "UPDATE tbdepinfo SET shareCap = ? WHERE memberID = ?";
                $dataDep = array($newAm, $memID);
                $stmtDep = $conn->prepare($sqlDep);
                $stmtDep->execute($dataDep);
            break;

            case 3://PSC
                $newAm = $shareCap - $prin + $Cbu;

                $sqlDep = "UPDATE tbdepinfo SET shareCap = ? WHERE memberID = ?";
                $dataDep = array($newAm, $memID);
                $stmtDep = $conn->prepare($sqlDep);
                $stmtDep->execute($dataDep); 
            break;

            case 4://Time Deposit
                $newAm = $timeDep - $prin + $Cbu;

                $sqlDep = "UPDATE tbdepinfo SET timeDep = ? WHERE memberID = ?";
                $dataDep = array($newAm, $memID);
                $stmtDep = $conn->prepare($sqlDep);
                $stmtDep->execute($dataDep);
            break;

            case 11://Business Loan
                $newAm = $shareCap - $prin + $Cbu;

                $sqlDep = "UPDATE tbdepinfo SET shareCap = ? WHERE memberID = ?";
                $dataDep = array($newAm, $memID);
                $stmtDep = $conn->prepare($sqlDep);
                $stmtDep->execute($dataDep); 
            break;
        }

        // Update Deposit History

        $_SESSION['actVal'] = "Loan Approved";
        header("Location: ../admin_lnactive.php");
        }else{

        }

    }


?>