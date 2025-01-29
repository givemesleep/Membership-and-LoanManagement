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

    if(isset($_POST['cheque'])){
        $checkRef = htmlspecialchars(strip_tags(trim($_POST['cheque'])));
    }else{
        $checkRef = 0;
    }

    $lnAcc = "SELECT 
                lnTotMos AS OutStanding, loanMonthPay AS monthPay, lnTotPay AS lnPay, lnPrincipal AS lnPrin
            FROM tbloaninfo
            WHERE memberID = ? AND lnstatID = 1 AND remarks = 0";
    $dataAcc = array($memID);
    $stmtAcc = $conn->prepare($lnAcc);
    $stmtAcc->execute($dataAcc);
    $rowAcc = $stmtAcc->fetch(PDO::FETCH_ASSOC);
    $outStanding = $rowAcc['OutStanding'];
    $monthPay = $rowAcc['monthPay'];
    $lnPay = $rowAcc['lnPay'];
    $lnPrin = $rowAcc['lnPrin'];

    $newAm = checkDecimal($Amount);

    $payment = $lnPay + $newAm;
    // $newBal = $outStanding - $newAm;
    // $payment = $lnPay + $newBal;
    $month = new DateTime($monthPay);
    
    if($newAm > 50 && $newAm <= $outStanding && $lnPay <= $outStanding){

    $month->modify('+1 month');
    $newMonth = $month->format('Y-m-d');

    $updateLn = "UPDATE tbloaninfo SET lnTotPay = ?, loanMonthPay = ? WHERE memberID = ? AND lnstatID = 1 AND remarks = 0";
    $dataLn = array($payment, $newMonth, $memID);
    $stmtLn = $conn->prepare($updateLn);
    $stmtLn->execute($dataLn);
    
    $lnHis = "INSERT INTO tblnhisinfo(memberID, loanID, lnunID, lnamount, lncurbal, lnnewbal, InvoiceNo, CheckRef, cvRef, lnDate, lnTime)
            VALUES(?,?,0,?,?,?,?,?,?,NOW(),NOW())";
    $dataHis = array($memID, $lnID, $newAm, $outStanding, $newBal, $invRef, $checkRef, $cvRef);
    $stmtHis = $conn->prepare($lnHis);
    $stmtHis->execute($dataHis);

    if($stmtLn && $stmtHis){
        //Return Success
        $_SESSION['lnSuc'] = 'Payment Successful!';
        header('Location: ../admin_lnpay.php');
    }

    }else{
        //Return Error
        $_SESSION['lnErr'] = 'Amount is invalid!';
        $flag = encrypt('lnPay', $key);
        $memsID = encrypt($AccID, $key);
        header('Location: ../admin_lnpay.php?mem='.$memsID.'&flag='.$flag);
    }

// admin_lnpay.php?mem='.encrypt($rowbg['ID'], $key).'&flag='.encrypt('lnPay', $key).'"



?>