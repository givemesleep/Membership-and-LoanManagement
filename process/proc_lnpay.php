<?php 
    require_once '../cruds/config.php';
    require_once 'func_func.php';
    require_once '../cruds/current_user.php';
    
    $key="LLAMPCO";

    $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
    $lnID = htmlspecialchars(strip_tags(trim($_POST['lnID'])));
    $Amount = htmlspecialchars(strip_tags(trim($_POST['payAm'])));
    $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    $cvRef = htmlspecialchars(strip_tags(trim($_POST['cvRef'])));
    $AccID = htmlspecialchars(strip_tags(trim($_POST['AccID'])));
    $lnUnID = htmlspecialchars(strip_tags(trim($_POST['lnUnID'])));

    if(isset($_POST['cheque'])){
        $checkRef = htmlspecialchars(strip_tags(trim($_POST['cheque'])));
    }else{
        $checkRef = 0;
    }

    $lnAcc = "SELECT loanID, lnPrincipal, lnTotMos, lnMonInt, lnTotPay, loanMonthPay
            FROM tbloaninfo WHERE lnstatID = 1 AND memberID = ? AND isActivate = 1 AND remarks = 0";
    $dataAcc = array($memID);
    $stmtAcc = $conn->prepare($lnAcc);
    $stmtAcc->execute($dataAcc);
    $rowAcc = $stmtAcc->fetch(PDO::FETCH_ASSOC);
    
    $loanType = "SELECT intRate AS interest FROM tblntypeS WHERE loanID = ?";
    $dataType = array($lnID);
    $stmtType = $conn->prepare($loanType);
    $stmtType->execute($dataType);
    $rowType = $stmtType->fetch(PDO::FETCH_ASSOC);
    
    $lnID = $rowAcc['loanID'];
    $principal = $rowAcc['lnPrincipal'];
    $outStanding = $rowAcc['lnTotMos'];
    $montInt = $rowAcc['lnMonInt'];
    $lnPay = $rowAcc['lnTotPay'];
    $monthPay = $rowAcc['loanMonthPay'];
    $interest = $rowType['interest'];

    $newAm = checkDecimal($Amount);

    $newPrin = $principal + $montInt;
    //For the computation
    // $N = $newAm - $montInt;
    // $NP = $principal - $N; //New Principal
    // $NI = $NP * perTodec($interest); //New Monthly Interest
    // $newOS = $outStanding - $newAm;

    // $months = new DateTime($monthPay);
    // $months->modify('+1 month');
    // $newMonth = $months->format('Y-m-d');
    
    // echo $lnUnID . '<br>';
    // echo $montInt . '<br>';
    // echo $newAm . '<br>';
    // echo $NP . '<br>';
    // echo $NI . '<br>';
    // echo $newOS . '<br>';
    // echo $newMonth . '<br>';

    if($newAm < $montInt){
        //Return Error
        $_SESSION['lnErr'] = 'Amount is less than the minimum payment!';
        $flag = encrypt('lnPay', $key);
        $memsID = encrypt($AccID, $key);
        header('Location: ../admin_lnpay.php?mem='.$memsID.'&flag='.$flag);
    }elseif($newAm > $outStanding){
        //Return Error
        $_SESSION['lnErr'] = 'Amount is greater than the minimum payment!';
        $flag = encrypt('lnPay', $key);
        $memsID = encrypt($AccID, $key);
        header('Location: ../admin_lnpay.php?mem='.$memsID.'&flag='.$flag);
    }else{
        if($newAm < $newPrin){

            //For the computation
            $N = $newAm - $montInt;
            $NP = $principal - $N; //New Principal
            $NI = $NP * perTodec($interest); //New Monthly Interest
            $newOS = $outStanding - $newAm;

            $months = new DateTime($monthPay);
            $months->modify('+1 month');
            $newMonth = $months->format('Y-m-d');
            
            // echo 'ID '. $lnUnID . '<br>';
            // echo 'Monthly Interest ' .$montInt . '<br>';
            // echo 'Payee Amount ' . $newAm . '<br>';
            // echo 'New Principal ' . $NP . '<br>';
            // echo 'New Interest ' . $NI . '<br>';
            // echo 'New Outstanding ' . $newOS . '<br>';
            // echo 'Next Monthly ' . $newMonth . '<br>';

            //INSERT AND UPDATE
            /*UPDATE tbloaninfo SET lnPrincipal = ?, lnMonInt = ?, lnTotPay = ?
            WHERE memberID = ? AND lnunID = ?

            INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, Invoice, CheckRef, cvRef, lnDate, lnTime)
            VALUES(?,?,?,?,?,?,?,?,?,NOW(),NOW()) */

            // echo 'Hulog ka next month';
            $uplninfo = "UPDATE tbloaninfo SET lnPrincipal = ?, lnMonInt = ?, lnTotPay = ?, loanMonthPay = ?
                        WHERE memberID = ? AND lnunID = ?";
            $dataLn = array($NP, $NI, $newOS, $newMonth, $memID, $lnUnID);
            $stmtLn = $conn->prepare($uplninfo);
            $stmtLn->execute($dataLn);

            $lnhis = "INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, InvoiceNo, CheckRef, cvRef, lnDate, lnTime)
            VALUES(?,?,?,?,?,?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, $lnID, $lnUnID, $newAm, $outStanding, $newOS, $invRef, $checkRef, $cvRef);
            $stmtHis = $conn->prepare($lnhis);
            $stmtHis->execute($dataHis);

            if($stmtLn && $stmtHis){
                //Return Success
                $_SESSION['lnSuc'] = 'Payment Successful!';
                $flag = encrypt('lnPay', $key);
                $memsID = encrypt($AccID, $key);
                header('Location: ../admin_lnpay.php');
            }

        }elseif($newAm == $newPrin){
            
            $N = $newAm - $montInt;
            $NP = $principal - $N; //New Principal
            $NI = $NP * perTodec($interest); //New Monthly Interest
            $newOS = $outStanding - $newAm;

            // echo 'tapos kana mag hulog';
            /*
            INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, Invoice, CheckRef, cvRef, lnDate, lnTime)
            VALUES(?,?,?,?,?,?,?,?,?,NOW(),NOW())

            UPDATE tbloaninfo SET remarks = 1, lnstatID = 3, isActivate = 0
            WHERE lnunID = ? AND memberID = ?

            UPDATE tbperinfo SET rlCount = rlCount + 1, isLoan = 0
            WHERE memberID = ?
             
             */

            $uplninfo = "UPDATE tbloaninfo SET lnPrincipal = ?, lnMonInt = ?, lnTotPay = ?, loanMonthPay = ?, remarks = 1, lnstatID = 3, isActivate = 0
                        WHERE memberID = ? AND lnunID = ?";
            $dataLn = array($NP, $NI, $newOS, $newMonth, $memID, $lnUnID);
            $stmtLn = $conn->prepare($uplninfo);
            $stmtLn->execute($dataLn);

            $perinfo = "UPDATE tbperinfo SET rlCount = rlCount + 1, isLoan = 0
                        WHERE memberID = ?";
            $dataPer = array($memID);
            $stmtPer = $conn->prepare($perinfo);
            $stmtPer->execute($dataPer);

            $lnhis = "INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, InvoiceNo, CheckRef, cvRef, lnDate, lnTime)
                    VALUES(?,?,?,?,?,?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, $lnID, $lnUnID, $newAm, $outStanding, $newOS, $invRef, $checkRef, $cvRef);
            $stmtHis = $conn->prepare($lnhis);
            $stmtHis->execute($dataHis);

            if($stmtLn && $stmtHis && $stmtPer){
                //Return Success
                $_SESSION['lnSuc'] = 'Payment Successful!';
                $flag = encrypt('lnPay', $key);
                $memsID = encrypt($AccID, $key);
                header('Location: ../admin_lnpay.php');
            }
        }
    }


    // $payment = $lnPay + $newAm;
    // $newBal = $outStanding - $newAm;
    // $payment = $lnPay + $newBal;
    // $month = new DateTime($monthPay);
    
    // if($newAm > 50 && $newAm <= $outStanding && $lnPay <= $outStanding){

    // $month->modify('+1 month');
    // $newMonth = $month->format('Y-m-d');

    // $updateLn = "UPDATE tbloaninfo SET lnTotPay = ?, loanMonthPay = ? WHERE memberID = ? AND lnstatID = 1 AND remarks = 0";
    // $dataLn = array($payment, $newMonth, $memID);
    // $stmtLn = $conn->prepare($updateLn);
    // $stmtLn->execute($dataLn);
    
    // $lnHis = "INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, InvoiceNo, CheckRef, cvRef, lnDate, lnTime)
    //         VALUES(?,?,0,?,?,?,?,?,?,NOW(),NOW())";
    // $dataHis = array($memID, $lnID, $newAm, $outStanding, $newBal, $invRef, $checkRef, $cvRef);
    // $stmtHis = $conn->prepare($lnHis);
    // $stmtHis->execute($dataHis);

    // if($stmtLn && $stmtHis){
    //     //Return Success
    //     $_SESSION['lnSuc'] = 'Payment Successful!';
    //     header('Location: ../admin_lnpay.php');
    // }

    // }else{
    //     
    // }

// admin_lnpay.php?mem='.encrypt($rowbg['ID'], $key).'&flag='.encrypt('lnPay', $key).'"



?>