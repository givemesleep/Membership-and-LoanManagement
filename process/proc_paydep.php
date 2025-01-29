<?php 

require_once '../cruds/config.php';
require_once 'func_func.php';
session_start();

// $depType = '';
// if(isset($_GET['dep'])){
    // $depType = $_GET['dep'];

    

    // switch($depType){
    //     case 1 :
    //         //Pay Regular Savings
    //         $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //         $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //         $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //         $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
            
    //         //Convert into Decimal
    //         $decAm = checkDecimal($payAm);

    //         //Server Validation
    //         if($payAm != is_numeric($payAm)){
    //             //Throw Error Alert and Return to Homepage
    //             header("Location: ../admin_createdep.php");
    //         }

    //         if(strlen($chRef) != 10 || strlen($chRef) != 16){
                
    //         }else{
    //             //Throw Error Alert and Return to Homepage
    //             header("Location: ../admin_createdep.php");
    //         }

    //         if($decAm < 50.00){
    //             //Throw Error Alert and Return to Homepage
    //             header("Location: ../admin_createdep.php");

    //         }
            
    //         //SQL Rows
    //         $DepInfo = "SELECT regSav FROM tbdepinfo WHERE memberID = ?";
    //         $dataDep = array($memID);
    //         $stmtDep = $conn->prepare($DepInfo);
    //         $stmtDep->execute($dataDep);
    //         $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //         $depAm = $rowDep["regSav"];

    //         $TransHis = "SELECT * FROM tbtransinfo";
    //         $stmtHis = $conn->prepare($TransHis);
    //         $stmtHis->execute();
    //         $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //         $lastTrans = $conn->lastInsertId();

    //         //Transaction ID
    //         $transID = transID($lastTrans);

    //         $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //         $dataUnik = array($memID);
    //         $stmtUnik = $conn->prepare($unik);
    //         $stmtUnik->execute($dataUnik);
    //         $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //         $unID = $rowUnik['unID'];

    //         //Add the Amount
    //         $newAm = $depAm + $decAm;
    //         $Amount = checkDecimal($newAm);

    //         //SQL Insert
    //         $sqlDep = "UPDATE tbdepinfo SET regSav = ? WHERE memberID = ?";
    //         $dataDep = array($Amount, $memID);
    //         $stmtDep = $conn->prepare($sqlDep);
    //         $stmtDep->execute($dataDep);

    //         if($chRef != ''){
    //             $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //             VALUES(?,?,?,?,?,NOW())";
    //             $dataHis = array($memID, 1, $Amount, $invRef, $chRef);
    //             $stmtHis = $conn->prepare($depHis);
    //             $stmtHis->execute($dataHis);
    //         }else{
    //             $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //             VALUES(?,?,?,?,NOW())";
    //             $dataHis = array($memID, 1, $Amount, $invRef);
    //             $stmtHis = $conn->prepare($depHis);
    //             $stmtHis->execute($dataHis);
    //         }

    //         $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //         VALUES(?,?,?,?,NOW(), 0)";
    //         $dataTrans = array($transID, $memID, 'Regular Savings', $Amount);
    //         $stmtTrans = $conn->prepare($sqlTrans);
    //         $stmtTrans->execute($dataTrans);

    //         if($stmtDep && $stmtHis && $stmtTrans){
    //             //Throw Success Alert and Return to Homepage
    //             header("Location: ../admin_createdep.php");
    //         }else{
    //             header("Location: ../admin_createdep.php?cretdep=$unID&dep=1");
    //         }

    //     break;
    //     case 2 :
    //          //Pay Regular Savings
    //          $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //          $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //          $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //          $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
             
    //          //Convert into Decimal
    //          $decAm = checkDecimal($payAm);
 
    //          //Server Validation
    //          if($payAm != is_numeric($payAm)){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if(strlen($chRef) != 10 || strlen($chRef) != 16){
                 
    //          }else{
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if($decAm < 50.00){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
 
    //          }
             
    //          //SQL Rows
    //          $DepInfo = "SELECT shareCap FROM tbdepinfo WHERE memberID = ?";
    //          $dataDep = array($memID);
    //          $stmtDep = $conn->prepare($DepInfo);
    //          $stmtDep->execute($dataDep);
    //          $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //          $depAm = $rowDep["shareCap"];
 
    //          $TransHis = "SELECT * FROM tbtransinfo";
    //          $stmtHis = $conn->prepare($TransHis);
    //          $stmtHis->execute();
    //          $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //          $lastTrans = $conn->lastInsertId();
 
    //          //Transaction ID
    //          $transID = transID($lastTrans);
 
    //          $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //          $dataUnik = array($memID);
    //          $stmtUnik = $conn->prepare($unik);
    //          $stmtUnik->execute($dataUnik);
    //          $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //          $unID = $rowUnik['unID'];
 
    //          //Add the Amount
    //          $newAm = $depAm + $decAm;
    //          $Amount = checkDecimal($newAm);
 
    //          //SQL Insert
    //          $sqlDep = "UPDATE tbdepinfo SET shareCap = ? WHERE memberID = ?";
    //          $dataDep = array($Amount, $memID);
    //          $stmtDep = $conn->prepare($sqlDep);
    //          $stmtDep->execute($dataDep);
 
    //          if($chRef != ''){
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //              VALUES(?,?,?,?,?,NOW())";
    //              $dataHis = array($memID, 2, $Amount, $invRef, $chRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }else{
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //              VALUES(?,?,?,?,NOW())";
    //              $dataHis = array($memID, 2, $Amount, $invRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }
 
    //          $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //          VALUES(?,?,?,?,NOW(), 0)";
    //          $dataTrans = array($transID, $memID, 'Shared Capital', $Amount);
    //          $stmtTrans = $conn->prepare($sqlTrans);
    //          $stmtTrans->execute($dataTrans);
 
    //          if($stmtDep && $stmtHis && $stmtTrans){
    //              //Throw Success Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }else{
    //              header("Location: ../admin_createdep.php?cretdep=$unID&dep=2");
    //          }
        
    //     break;
    //     case 3 :
    //          //Pay Regular Savings
    //          $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //          $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //          $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //          $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
             
    //          //Convert into Decimal
    //          $decAm = checkDecimal($payAm);
 
    //          //Server Validation
    //          if($payAm != is_numeric($payAm)){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if(strlen($chRef) != 10 || strlen($chRef) != 16){
                 
    //          }else{
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if($decAm < 50.00){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
 
    //          }
             
    //          //SQL Rows
    //          $DepInfo = "SELECT timeDep FROM tbdepinfo WHERE memberID = ?";
    //          $dataDep = array($memID);
    //          $stmtDep = $conn->prepare($DepInfo);
    //          $stmtDep->execute($dataDep);
    //          $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //          $depAm = $rowDep["timeDep"];
 
    //          $TransHis = "SELECT * FROM tbtransinfo";
    //          $stmtHis = $conn->prepare($TransHis);
    //          $stmtHis->execute();
    //          $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //          $lastTrans = $conn->lastInsertId();
 
    //          //Transaction ID
    //          $transID = transID($lastTrans);
 
    //          $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //          $dataUnik = array($memID);
    //          $stmtUnik = $conn->prepare($unik);
    //          $stmtUnik->execute($dataUnik);
    //          $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //          $unID = $rowUnik['unID'];
 
    //          //Add the Amount
    //          $newAm = $depAm + $decAm;
    //          $Amount = checkDecimal($newAm);
 
    //          //SQL Insert
    //          $sqlDep = "UPDATE tbdepinfo SET timeDep = ? WHERE memberID = ?";
    //          $dataDep = array($Amount, $memID);
    //          $stmtDep = $conn->prepare($sqlDep);
    //          $stmtDep->execute($dataDep);
 
    //          if($chRef != ''){
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //              VALUES(?,?,?,?,?,NOW())";
    //              $dataHis = array($memID, 3, $Amount, $invRef, $chRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }else{
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //              VALUES(?,?,?,?,NOW())";
    //              $dataHis = array($memID, 3, $Amount, $invRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }
 
    //          $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //          VALUES(?,?,?,?,NOW(), 0)";
    //          $dataTrans = array($transID, $memID, 'Time Deposit', $Amount);
    //          $stmtTrans = $conn->prepare($sqlTrans);
    //          $stmtTrans->execute($dataTrans);
 
    //          if($stmtDep && $stmtHis && $stmtTrans){
    //              //Throw Success Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }else{
    //              header("Location: ../admin_createdep.php?cretdep=$unID&dep=3");
    //          }
        
    //     break;
    //     case 4 :
    //          //Pay Regular Savings
    //          $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //          $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //          $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //          $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
             
    //          //Convert into Decimal
    //          $decAm = checkDecimal($payAm);
 
    //          //Server Validation
    //          if($payAm != is_numeric($payAm)){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if(strlen($chRef) != 10 || strlen($chRef) != 16){
                 
    //          }else{
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if($decAm < 50.00){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
 
    //          }
             
    //          //SQL Rows
    //          $DepInfo = "SELECT speVol FROM tbdepinfo WHERE memberID = ?";
    //          $dataDep = array($memID);
    //          $stmtDep = $conn->prepare($DepInfo);
    //          $stmtDep->execute($dataDep);
    //          $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //          $depAm = $rowDep["speVol"];
 
    //          $TransHis = "SELECT * FROM tbtransinfo";
    //          $stmtHis = $conn->prepare($TransHis);
    //          $stmtHis->execute();
    //          $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //          $lastTrans = $conn->lastInsertId();
 
    //          //Transaction ID
    //          $transID = transID($lastTrans);
 
    //          $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //          $dataUnik = array($memID);
    //          $stmtUnik = $conn->prepare($unik);
    //          $stmtUnik->execute($dataUnik);
    //          $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //          $unID = $rowUnik['unID'];
 
    //          //Add the Amount
    //          $newAm = $depAm + $decAm;
    //          $Amount = checkDecimal($newAm);
 
    //          //SQL Insert
    //          $sqlDep = "UPDATE tbdepinfo SET speVol = ? WHERE memberID = ?";
    //          $dataDep = array($Amount, $memID);
    //          $stmtDep = $conn->prepare($sqlDep);
    //          $stmtDep->execute($dataDep);
 
    //          if($chRef != ''){
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //              VALUES(?,?,?,?,?,NOW())";
    //              $dataHis = array($memID, 4, $Amount, $invRef, $chRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }else{
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //              VALUES(?,?,?,?,NOW())";
    //              $dataHis = array($memID, 4, $Amount, $invRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }
 
    //          $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //          VALUES(?,?,?,?,NOW(), 0)";
    //          $dataTrans = array($transID, $memID, 'Special Voluntary', $Amount);
    //          $stmtTrans = $conn->prepare($sqlTrans);
    //          $stmtTrans->execute($dataTrans);
 
    //          if($stmtDep && $stmtHis && $stmtTrans){
    //              //Throw Success Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }else{
    //              header("Location: ../admin_createdep.php?cretdep=$unID&dep=4");
    //          }
        
    //     break;
    //     case 5 :
    //          //Pay Regular Savings
    //          $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //          $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //          $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //          $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
             
    //          //Convert into Decimal
    //          $decAm = checkDecimal($payAm);
 
    //          //Server Validation
    //          if($payAm != is_numeric($payAm)){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if(strlen($chRef) != 10 || strlen($chRef) != 16){
                 
    //          }else{
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if($decAm < 50.00){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
 
    //          }
             
    //          //SQL Rows
    //          $DepInfo = "SELECT speSav FROM tbdepinfo WHERE memberID = ?";
    //          $dataDep = array($memID);
    //          $stmtDep = $conn->prepare($DepInfo);
    //          $stmtDep->execute($dataDep);
    //          $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //          $depAm = $rowDep["speSav"];
 
    //          $TransHis = "SELECT * FROM tbtransinfo";
    //          $stmtHis = $conn->prepare($TransHis);
    //          $stmtHis->execute();
    //          $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //          $lastTrans = $conn->lastInsertId();
 
    //          //Transaction ID
    //          $transID = transID($lastTrans);
 
    //          $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //          $dataUnik = array($memID);
    //          $stmtUnik = $conn->prepare($unik);
    //          $stmtUnik->execute($dataUnik);
    //          $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //          $unID = $rowUnik['unID'];
 
    //          //Add the Amount
    //          $newAm = $depAm + $decAm;
    //          $Amount = checkDecimal($newAm);
 
    //          //SQL Insert
    //          $sqlDep = "UPDATE tbdepinfo SET speSav = ? WHERE memberID = ?";
    //          $dataDep = array($Amount, $memID);
    //          $stmtDep = $conn->prepare($sqlDep);
    //          $stmtDep->execute($dataDep);
 
    //          if($chRef != ''){
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //              VALUES(?,?,?,?,?,NOW())";
    //              $dataHis = array($memID, 5, $Amount, $invRef, $chRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }else{
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //              VALUES(?,?,?,?,NOW())";
    //              $dataHis = array($memID, 5, $Amount, $invRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }
 
    //          $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //          VALUES(?,?,?,?,NOW(), 0)";
    //          $dataTrans = array($transID, $memID, 'Special Savings', $Amount);
    //          $stmtTrans = $conn->prepare($sqlTrans);
    //          $stmtTrans->execute($dataTrans);
 
    //          if($stmtDep && $stmtHis && $stmtTrans){
    //              //Throw Success Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }else{
    //              header("Location: ../admin_createdep.php?cretdep=$unID&dep=5");
    //          }

    //     break;
    //     case 6 :
    //          //Pay Regular Savings
    //          $memID = htmlspecialchars(strip_tags(trim($_POST['memID'])));
    //          $chRef = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
    //          $invRef = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
    //          $payAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
             
    //          //Convert into Decimal
    //          $decAm = checkDecimal($payAm);
 
    //          //Server Validation
    //          if($payAm != is_numeric($payAm)){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if(strlen($chRef) != 10 || strlen($chRef) != 16){
                 
    //          }else{
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }
 
    //          if($decAm < 50.00){
    //              //Throw Error Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
 
    //          }
             
    //          //SQL Rows
    //          $DepInfo = "SELECT funSav FROM tbdepinfo WHERE memberID = ?";
    //          $dataDep = array($memID);
    //          $stmtDep = $conn->prepare($DepInfo);
    //          $stmtDep->execute($dataDep);
    //          $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
    //          $depAm = $rowDep["funSav"];
 
    //          $TransHis = "SELECT * FROM tbtransinfo";
    //          $stmtHis = $conn->prepare($TransHis);
    //          $stmtHis->execute();
    //          $rowHis = $stmtHis->fetch(PDO::FETCH_ASSOC);
    //          $lastTrans = $conn->lastInsertId();
 
    //          //Transaction ID
    //          $transID = transID($lastTrans);
 
    //          $unik = "SELECT * FROM tbuninfo WHERE memberID = ?";
    //          $dataUnik = array($memID);
    //          $stmtUnik = $conn->prepare($unik);
    //          $stmtUnik->execute($dataUnik);
    //          $rowUnik = $stmtUnik->fetch(PDO::FETCH_ASSOC);
    //          $unID = $rowUnik['unID'];
 
    //          //Add the Amount
    //          $newAm = $depAm + $decAm;
    //          $Amount = checkDecimal($newAm);
 
    //          //SQL Insert
    //          $sqlDep = "UPDATE tbdepinfo SET funSav = ? WHERE memberID = ?";
    //          $dataDep = array($Amount, $memID);
    //          $stmtDep = $conn->prepare($sqlDep);
    //          $stmtDep->execute($dataDep);
 
    //          if($chRef != ''){
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
    //              VALUES(?,?,?,?,?,NOW())";
    //              $dataHis = array($memID, 6, $Amount, $invRef, $chRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }else{
    //              $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
    //              VALUES(?,?,?,?,NOW())";
    //              $dataHis = array($memID, 6, $Amount, $invRef);
    //              $stmtHis = $conn->prepare($depHis);
    //              $stmtHis->execute($dataHis);
    //          }
 
    //          $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trTD, isVoid)
    //          VALUES(?,?,?,?,NOW(), 0)";
    //          $dataTrans = array($transID, $memID, 'Fun Saver', $Amount);
    //          $stmtTrans = $conn->prepare($sqlTrans);
    //          $stmtTrans->execute($dataTrans);
 
    //          if($stmtDep && $stmtHis && $stmtTrans){
    //              //Throw Success Alert and Return to Homepage
    //              header("Location: ../admin_createdep.php");
    //          }else{
    //              header("Location: ../admin_createdep.php?cretdep=$unID&dep=6");
    //          }

    //     break;
    // }
// }else{
//     header("Location: ../admin_createdep.php");
// }

$memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
$depType = htmlspecialchars(strip_tags(trim($_POST['deposit'])));
$appBy = htmlspecialchars(strip_tags(trim($_POST['appBy'])));
$cheque = htmlspecialchars(strip_tags(trim($_POST['cheque'])));
$invoice = htmlspecialchars(strip_tags(trim($_POST['invoice'])));
$depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));


$Amount = checkDecimal($depAm);

if($Amount < 50){
    //Return Back to the Page
    //Throw Error Alert
    $_SESSION['invAm'] = 'Deposit must start at 50.00 PHP ';
    header("Location: ../admin_createdep.php");
    // echo 'mali';
}

//Create Trans ID
$sqlTransID = "SELECT COUNT(trID) AS lastRow FROM tbtransinfo";
$stmtTransID = $conn->prepare($sqlTransID);
$stmtTransID->execute();
$rowLast = $stmtTransID->fetch(PDO::FETCH_ASSOC);
$lastRow = $rowLast['lastRow'];

//Unique ID
$date = new DateTime(); 
// Extract day, month, and year 
$month = $date->format('m'); 
$year = $date->format('Y'); 
$nwyr = substr($year, -2);
$dateID = $nwyr . $month;
//Left Pad
$lpad = str_pad($lastRow, 3, "0",STR_PAD_LEFT);
$transID = $lpad . $dateID;

switch($depType){
    case 1:
        /*
        #Deposit Info (Main Table) Update Deposit
        SELECT regSav FROM tbdepinfo WHERE memberID = ? //
        UPDATE tbdepinfo SET regSav = ? WHERE memberID = ?
        #Deposit History Insert History
        INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, depDate, depTime)
        VALUES(?,?,?,?,?,NOW(),NOW())
        #Transaction Info Insert Transaction Log
        INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,?,?,NOW(),NOW(),?,0)
        */

        //fetch the previous balance
        $selectDep = "SELECT regSav, shareCap FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $regular = $rowDep['regSav'];
        $psc = $rowDep['shareCap'];

        //Convert the amount into several parts
        $OrigAm = $Amount; //Temp Variable
        $oldRs = $OrigAm + $regular;
        $newRs = rsConvert($oldRs); //Convert the Amount by divided by 300 

        $newAm = $oldRs - $newRs; //Used for adding to PSC
        $newPSC = $psc + $newAm; //New PSC
        
        $RS = $newRs;
        $PSC = $newPSC;
        // $newRS = $addRS + $regular; //New Regular Savings

        //New Balance
        $newAm = checkDecimal($regular + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET regSav = ?, shareCap = ? WHERE memberID = ?";
        $dataUp = array($RS, $PSC, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Regular Savings
        $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
        $dataHis = array($memID, 1, $RS, $invoice, $cheque);
        $stmtHis = $conn->prepare($depHis);
        $stmtHis->execute($dataHis);

        
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $RS, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        //PSC
        $depHis1 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
        $dataHis1 = array($memID, 2, $PSC, $invoice, $cheque);
        $stmtHis1 = $conn->prepare($depHis1);
        $stmtHis1->execute($dataHis1);

        
        $transInfo1 = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Shared Capital',?,NOW(),NOW(),?,0)";
        $dataTrans1 = array($transID, $memID, $PSC, $appBy);
        $stmtTrans1 = $conn->prepare($transInfo1);
        $stmtTrans1->execute($dataTrans1);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    case 2:

        //fetch the previous balance
        $selectDep = "SELECT regSav, shareCap FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $regular = $rowDep['regSav'];
        $psc = $rowDep['shareCap'];

        //Convert the amount into several parts
        $OrigAm = $Amount; //Temp Variable
        $oldRs = $OrigAm + $regular;
        $newRs = rsConvert($oldRs); //Convert the Amount by divided by 300 

        $newAm = $oldRs - $newRs; //Used for adding to PSC
        $newPSC = $psc + $newAm; //New PSC
        
        $RS = $newRs;
        $PSC = $newPSC;
        // $newRS = $addRS + $regular; //New Regular Savings

        //New Balance
        $newAm = checkDecimal($regular + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET regSav = ?, shareCap = ? WHERE memberID = ?";
        $dataUp = array($RS, $PSC, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Regular Savings
        $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
        $dataHis = array($memID, 1, $RS, $invoice, $cheque);
        $stmtHis = $conn->prepare($depHis);
        $stmtHis->execute($dataHis);

        
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $RS, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        //PSC
        $depHis1 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
        $dataHis1 = array($memID, 2, $PSC, $invoice, $cheque);
        $stmtHis1 = $conn->prepare($depHis1);
        $stmtHis1->execute($dataHis1);

        
        $transInfo1 = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Shared Capital',?,NOW(),NOW(),?,0)";
        $dataTrans1 = array($transID, $memID, $PSC, $appBy);
        $stmtTrans1 = $conn->prepare($transInfo1);
        $stmtTrans1->execute($dataTrans1);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    case 3:

        //fetch the previous balance
        $selectDep = "SELECT timeDep FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $td = $rowDep['timeDep'];

        //New Balance
        $newAm = checkDecimal($td + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET timeDep = ? WHERE memberID = ?";
        $dataUp = array($newAm, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Deposit History
        if($cheque == 0 || $cheque == null){
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, depDate, depTime)
                    VALUES(?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 3, $Amount, $invoice);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }else{
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 3, $Amount, $invoice, $cheque);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }

        //Transaction Info
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Time Deposit',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $Amount, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    case 4:

        //fetch the previous balance
        $selectDep = "SELECT speVol FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $td = $rowDep['speVol'];

        //New Balance
        $newAm = checkDecimal($td + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET speVol = ? WHERE memberID = ?";
        $dataUp = array($newAm, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Transaction Info
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Special Voluntary',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $Amount, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    case 5:

        //fetch the previous balance
        $selectDep = "SELECT speSav FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $td = $rowDep['speSav'];

        //New Balance
        $newAm = checkDecimal($td + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET speSav = ? WHERE memberID = ?";
        $dataUp = array($newAm, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Deposit History
        if($cheque == 0 || $cheque == null){
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, depDate, depTime)
                    VALUES(?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 5, $Amount, $invoice);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }else{
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 5, $Amount, $invoice, $cheque);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }

        //Transaction Info
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Special Saving',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $Amount, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    case 6:

        //fetch the previous balance
        $selectDep = "SELECT funSav FROM tbdepinfo WHERE memberID = ?";
        $dataDep = array($memID);
        $stmtDep = $conn->prepare($selectDep);
        $stmtDep->execute($dataDep);
        $rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
        $td = $rowDep['funSav'];

        //New Balance
        $newAm = checkDecimal($td + $Amount);

        //Update the previous balance
        $updateDep = "UPDATE tbdepinfo SET funSav = ? WHERE memberID = ?";
        $dataUp = array($newAm, $memID);
        $stmtUp = $conn->prepare($updateDep);
        $stmtUp->execute($dataUp);

        //Deposit History
        if($cheque == 0 || $cheque == null){
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, depDate, depTime)
                    VALUES(?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 6, $Amount, $invoice);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }else{
            $depHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,?,?,?,?,NOW(),NOW())";
            $dataHis = array($memID, 6, $Amount, $invoice, $cheque);
            $stmtHis = $conn->prepare($depHis);
            $stmtHis->execute($dataHis);
        }

        //Transaction Info
        $transInfo = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
        VALUES(?,?,'Fun Saver',?,NOW(),NOW(),?,0)";
        $dataTrans = array($transID, $memID, $Amount, $appBy);
        $stmtTrans = $conn->prepare($transInfo);
        $stmtTrans->execute($dataTrans);

        if($stmtUp && $stmtHis && $stmtTrans){
            $_SESSION['appAm'] = 'Transaction #'.$transID;
            header("Location: ../admin_createdep.php");
            // echo 'Nag save';
        }

    break;
    default:
    $_SESSION['invAm'] = 'Invalid Deposit';
    header("Location: ../admin_createdep.php");
    // echo 'dito mali';
    // echo $depType;
    break;
}





?>