<?php 
require_once '../cruds/config.php';
// require_once '../cruds/current_user.php';
require_once 'func_func.php';
session_start();

$key = "LLAMPCO";
$paypmes = '';
if(isset($_GET['paypmes'])){
    $paypmes = decrypt($_GET['paypmes'], $key);

    switch($paypmes){
        case 1:

            $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
            $conducted = htmlspecialchars(strip_tags(trim($_POST['conducts'])));
            $refer = htmlspecialchars(strip_tags(trim($_POST['refer'])));

            //validates input

            $sqlpmes = "INSERT INTO tbpmesinfo(memberID, referName, trainedBy)VALUES(?,?,?)";
            $datapmes = array($memID, $refer, $conducted);
            $stmtpmes = $conn->prepare($sqlpmes);
            $stmtpmes->execute($datapmes);

            if($stmtpmes){
                //Success
                $flag=encrypt(2, $key);
                $memID=encrypt($memID, $key);
                // $_SESSION['valRes'] = 'Success Adding!';
                header("Location: ../admin_pmes.php?flags=$flag&appmem=$memID");
                exit();
            }

            break;
        case 2 :

            $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
            $sss = htmlspecialchars(strip_tags(trim($_POST['sss'])));
            $tin = htmlspecialchars(strip_tags(trim($_POST['tin'])));
            $IDType = htmlspecialchars(strip_tags(trim($_POST['cboID'])));
            $IDNum = htmlspecialchars(strip_tags(trim($_POST['othID'])));

            $sqlIDs = "INSERT INTO tbidinfo(memberID, SSSno, taxIdenNo, idTypesID, idTypeNo)
                        VALUES(?, ?, ?, ?, ?)";
                $dataIDs = array($memID, $sss, $tin, $IDType, $IDNum);
                $stmtIDs=$conn->prepare($sqlIDs);
                $stmtIDs->execute($dataIDs);
                
                if($stmtIDs){
                //Success
                $flag=encrypt(3, $key);
                $memID=encrypt($memID, $key);
                // $_SESSION['valRes'] = 'Success Adding!';
                header("Location: ../admin_pmes.php?flags=$flag&appmem=$memID");
                exit();

            }

        break;

        case 3: 

            $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
            $appBy = htmlspecialchars(strip_tags(trim($_POST['appBy'])));
            $cheque = htmlspecialchars(strip_tags(trim($_POST['cheque'])));
            $invoice = htmlspecialchars(strip_tags(trim($_POST['cvRef'])));
            $depType = htmlspecialchars(strip_tags(trim($_POST['depType'])));
            $depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));

            // if($cheque == '' || $cheque == null){
            //     $cheque = '';
            // }

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

            $Amount = checkDecimal($depAm);
            $regFee = checkDecimal(150.00);
            $deathFee = checkDecimal(500.00); 

            // $depType = 2;
            switch($depType){
                case 1 :
                    if($Amount > 49.00 && $Amount < 2399.00){
                        //For On-going Status

                        //Deposit Info
                        $sqlDep = "INSERT INTO tbdepinfo(memberID, regSav, regFee, dtCare)
                                VALUE(?,?,?,?)";
                        $dataDep = array($memID, $Amount, $regFee, $deathFee);
                        $stmtDep = $conn->prepare($sqlDep);
                        $stmtDep->execute($dataDep);

                        //Deposit History
                        $sqlHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                                VALUES(?,1,?,?,?,NOW(),NOW())";
                        $dataHis = array($memID, $Amount, $invoice, $cheque);
                        $stmtHis = $conn->prepare($sqlHis);
                        $stmtHis->execute($dataHis);

                        //Transaction Info
                        $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy, isVoid)
                                    VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,?)";
                        $dataTrans = array($transID, $memID, $Amount, $appBy, 0);
                        $stmtTrans = $conn->prepare($sqlTrans);
                        $stmtTrans->execute($dataTrans);

                        //Member Status
                        $sqlPer = "UPDATE tbperinfo SET memstatID = 2 WHERE memberID = ?";
                        $dataPer = array($memID);
                        $stmtPer = $conn->prepare($sqlPer);
                        $stmtPer->execute($dataPer);

                        //PMES Status
                        
                        $sqlPMES = "UPDATE tbpmesinfo SET approvedBy = ?, isPaid = 1 WHERE memberID = ?"; 
                        $dataPMES = array($appBy, $memID);
                        $stmtPMES = $conn->prepare($sqlPMES);
                        $stmtPMES->execute($dataPMES);

                        if($stmtDep && $stmtHis && $stmtTrans && $stmtPer && $stmtPMES){
                            //Success
                            $_SESSION['valRes'] = 'Regular Saving Success!';
                            header("Location: ../admin_pendings.php");
                            exit();
                        }

                    }else{
                        //Return to previous page
                        //Throw Alert
                        $flag=encrypt(3, $key);
                        $memID=encrypt($memID, $key);
                        $_SESSION['invRes'] = 'Invalid Input!';
                        header("Location: ../admin_pmes.php?flags=$flag&appmem=$memID");
                    }

                break;

                case 2:
                    if($Amount == 2400.00){
                        //For Approved Status

                        //Deposit Info
                        $sqlDep = "INSERT INTO tbdepinfo(memberID, shareCap, regFee, dtCare)
                                VALUE(?,?,?,?)";
                        $dataDep = array($memID, $Amount, $regFee, $deathFee);
                        $stmtDep = $conn->prepare($sqlDep);
                        $stmtDep->execute($dataDep);

                        //Deposit History
                        $sqlHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                                VALUES(?,2,?,?,?,NOW(),NOW())";
                        $dataHis = array($memID, $Amount, $invoice, $cheque);
                        $stmtHis = $conn->prepare($sqlHis);
                        $stmtHis->execute($dataHis);

                        //Transaction Info
                        $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy ,isVoid)
                                    VALUES(?,?,'Shared Capital',?,NOW(),NOW(),?,?)";
                        $dataTrans = array($transID, $memID, $Amount, $appBy ,0);
                        $stmtTrans = $conn->prepare($sqlTrans);
                        $stmtTrans->execute($dataTrans);

                        //Member Status
                        $sqlPer = "UPDATE tbperinfo SET memstatID = 1 WHERE memberID = ?";
                        $dataPer = array($memID);
                        $stmtPer = $conn->prepare($sqlPer);
                        $stmtPer->execute($dataPer);

                        //PMES Status
                        $sqlPMES = "UPDATE tbpmesinfo SET approvedBy = ?, isPaid = 1, OnGoingPaid = 1 WHERE memberID=?";
                        $dataPMES = array($appBy, $memID);
                        $stmtPMES = $conn->prepare($sqlPMES);
                        $stmtPMES->execute($dataPMES);

                        //Give User a Unique ID
                        $sqlUn = "SELECT COUNT(*) AS countID FROM tbuninfo";
                        $stmtUn = $conn->prepare($sqlUn);
                        $stmtUn->execute();
                        $rowUn = $stmtUn->fetch();
                        $UnID=$rowUn['countID'];


                        //Unique ID
                        $date = new DateTime(); 
                        // Extract day, month, and year 
                        $day = $date->format('d'); 
                        $month = $date->format('m'); 
                        $year = $date->format('Y'); 

                        $nwyr = substr($year, -2);

                        $dateID = $nwyr . $month . $day;
                        $rpad = str_pad($dateID, 9, "0");
                        $unID = $rpad . $UnID;

                        $sqlunId = "INSERT INTO tbuninfo(unID, memberID) VALUES(?, ?)";
                        $dataunId = array($unID, $memID);
                        $stmtunID=$conn->prepare($sqlunId);
                        $stmtunID->execute($dataunId);

                        $isActive = "UPDATE tbperinfo SET memstatID = 1, isApproved = 1, rlCount = 1, igpCount = 1, isActive = 1, ApplyDate = NOW() WHERE memberID = ?";
                        $dataActive = array($memID);
                        $stmtActive = $conn->prepare($isActive);
                        $stmtActive->execute($dataActive);

                        if($stmtDep && $stmtHis && $stmtTrans && $stmtPer && $stmtPMES && $stmtunID){
                            //Success
                            $_SESSION['masVal'] = 'Member Approved!';
                            header("Location: ../admin_masterlist.php");
                            exit();
                        }

                    }else{
                        //Return to previous page
                        //Throw Alert
                        $flag=encrypt(3, $key);
                        $memID=encrypt($memID, $key);
                        $_SESSION['invRes'] = 'Invalid Input!';
                        header("Location: ../admin_pmes.php?flags=$flag&appmem=$memID");
                    }
            
                break;

                default:
                    header("Location: ../admin_pmes.php");
                    $_SESSION['valRes'] = 'Invalid Inputs!';
                break;
            }

        break;

        case 4 :
            $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
            $appBy = htmlspecialchars(strip_tags(trim($_POST['appBy'])));
            $cheque = htmlspecialchars(strip_tags(trim($_POST['cvRef'])));
            $invoice = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
            $depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));

            $Amount = checkDecimal($depAm);
            // if($cheque == '' || $cheque == null){
            //     $cheque = '';
            // }

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

            $sqlBal = "SELECT regSav FROM tbdepinfo WHERE memberID=?";
            $dataBal = array($memID);
            $stmtBal = $conn->prepare($sqlBal);
            $stmtBal->execute($dataBal);
            $rowBal = $stmtBal->fetch();
            $curBal = checkDecimal($rowBal['regSav']);

            $deposit = checkDecimal($depAm);
            $combinedAm =  checkDecimal($curBal + $deposit);
            $remBal = checkDecimal($combinedAm - 2400.00 );

            $Amount = checkDecimal($depAm);

            if($combinedAm > 2400.00){
                //Return Max Amount Reached!
                $memID=encrypt($memID, $key);
                $_SESSION['invRes'] = 'Max Amount Reached!';
                header("Location: ../admin_pmes.php?appmem=$memID");
                // echo "Mataas";
            }elseif($Amount < 50.00){
                //Return Deposit Amount Too Low!
                $memID=encrypt($memID, $key);
                $_SESSION['invRes'] = 'Deposit Amount Too Low!';
                header("Location: ../admin_pmes.php?appmem=$memID");
                // echo "Mababa"; 
            }else{
                if($combinedAm < 2400.00 && $combinedAm > 50.00){
                    // echo "Regular";
                    //For On-going 

                    //Transaction Info
                    $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime,  trAppBy ,isVoid)
                            VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,?)";
                    $dataTrans = array($transID, $memID, $Amount, $appBy, 0);
                    $stmtTrans = $conn->prepare($sqlTrans);
                    $stmtTrans->execute($dataTrans);

                    //Deposit History
                    $sqlHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                            VALUES(?,2,?,?,?,NOW(),NOW())";
                    $dataHis = array($memID, $Amount, $invoice, $cheque);
                    $stmtHis = $conn->prepare($sqlHis);
                    $stmtHis->execute($dataHis);
                    
                    //Deposit Info
                    $sqlDep = "UPDATE tbdepinfo SET regSav = ? WHERE memberID = ?";
                    $dataDep = array($combinedAm, $memID);
                    $stmtDep = $conn->prepare($sqlDep);
                    $stmtDep->execute($dataDep);

                    if($stmtTrans && $stmtHis && $stmtDep){
                        //Success
                        $_SESSION['valRes'] = 'Regular Saving Updated!';
                        header("Location: ../admin_pendings.php");
                        
                    }
                }elseif($combinedAm == 2400.00){
                    // echo "Member ka na";
                    //For Approved

                    //Member Status
                    $sqlPer = "UPDATE tbperinfo SET memstatID = 1, isApproved = 1, rlCount = 1, igpCount = 1, isActive = 1, ApplyDate = NOW() WHERE memberID = ?";
                    $dataPer = array($memID);
                    $stmtPer = $conn->prepare($sqlPer);
                    $stmtPer->execute($dataPer);

                    //Deposit Info
                    $sqlDep = "UPDATE tbdepinfo SET regSav = ?, shareCap = ? WHERE memberID = ?";
                    $dataDep = array(0.00, $combinedAm, $memID);
                    $stmtDep = $conn->prepare($sqlDep);
                    $stmtDep->execute($dataDep);

                    //Transaction Info (1)
                    $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy , isVoid)
                            VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,?)";
                    $dataTrans = array($transID, $memID, $Amount, $appBy, 0);
                    $stmtTrans = $conn->prepare($sqlTrans);
                    $stmtTrans->execute($dataTrans);

                    //Transaction Info (2)
                    $sqlTrans1 = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy , isVoid)
                            VALUES(?,?,'Transfer Regular to PSC',?,NOW(),NOW(),?,?)";
                    $dataTrans1 = array($transID, $memID, $combinedAm, $appBy, 0);
                    $stmtTrans1 = $conn->prepare($sqlTrans1);
                    $stmtTrans1->execute($dataTrans1);

                    //Deposit History (1)
                    $sqlDepHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                        VALUES(?,1,?,?,?,NOW(),NOW())";
                    $dataDepHis = array($memID, $Amount, $invoice, $cheque);
                    $stmtDepHis = $conn->prepare($sqlDepHis);
                    $stmtDepHis->execute($dataDepHis);

                    //Deposit History (2)
                    $sqlDepHis1 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,2,?,?,?,NOW(),NOW())";
                    $dataDepHis1 = array($memID, $combinedAm, $invoice, $cheque);
                    $stmtDepHis1 = $conn->prepare($sqlDepHis1);
                    $stmtDepHis1->execute($dataDepHis1);

                    //Deposit History (3)
                    $sqlDepHis2 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, cvRef, depDate, depTime)
                    VALUES(?,1,0.00,?,?,NOW(),NOW())";
                    $dataDepHis2 = array($memID, $invoice, $cheque);
                    $stmtDepHis2 = $conn->prepare($sqlDepHis2);
                    $stmtDepHis2->execute($dataDepHis2);

                    //PMES Status
                    $sqlPMES = "UPDATE tbpmesinfo SET OnGoingPaid = ? WHERE memberID = ?";
                    $dataPMES = array(1, $memID);
                    $stmtPMES = $conn->prepare($sqlPMES);
                    $stmtPMES->execute($dataPMES);

                    //Give User a Unique ID
                    $sqlUn = "SELECT COUNT(*) AS countID FROM tbuninfo";
                    $stmtUn = $conn->prepare($sqlUn);
                    $stmtUn->execute();
                    $rowUn = $stmtUn->fetch();
                    $UnID=$rowUn['countID'];


                    //Unique ID
                    $date = new DateTime(); 
                    // Extract day, month, and year 
                    $day = $date->format('d'); 
                    $month = $date->format('m'); 
                    $year = $date->format('Y'); 

                    $nwyr = substr($year, -2);

                    $dateID = $nwyr . $month . $day;
                    $rpad = str_pad($dateID, 9, "0");
                    $unID = $rpad . $UnID;

                    $sqlunId = "INSERT INTO tbuninfo(unID, memberID) VALUES(?, ?)";
                    $dataunId = array($unID, $memID);
                    $stmtunID=$conn->prepare($sqlunId);
                    $stmtunID->execute($dataunId);

                    
                    if($stmtPer && $stmtTrans && $stmtTrans1 && $stmtDepHis && $stmtDepHis1 && $stmtDepHis2 && $stmtPMES){
                        //Success
                        $_SESSION['masVal'] = 'Member Approved!';
                        header("Location: ../admin_masterlist.php");
                        exit();
                    }
                }
            }
                    
            
        break;
    }
    
}


// if($Amount > 49.00 && $Amount < $remBal){
//     // if($remBal > $combinedAm){
//         //For On-going 

//         //Transaction Info
//         $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime,  trAppBy ,isVoid)
//                 VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,?)";
//         $dataTrans = array($transID, $memID, $Amount, $appBy, 0);
//         $stmtTrans = $conn->prepare($sqlTrans);
//         $stmtTrans->execute($dataTrans);

//         //Deposit History
//         $sqlHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, depDate, depTime)
//                 VALUES(?,2,?,?,?,NOW(),NOW())";
//         $dataHis = array($memID, $Amount, $invoice, $cheque);
//         $stmtHis = $conn->prepare($sqlHis);
//         $stmtHis->execute($dataHis);
        
//         //Deposit Info
//         $sqlDep = "UPDATE tbdepinfo SET regSav = ? WHERE memberID = ?";
//         $dataDep = array($combinedAm, $memID);
//         $stmtDep = $conn->prepare($sqlDep);
//         $stmtDep->execute($dataDep);

//         if($stmtTrans && $stmtHis && $stmtDep){
//             //Success
//             $_SESSION['valRes'] = 'Regular Saving Updated!';
//             // header("Location: ../admin_pendings.php");
//             echo 'Mali';
//             // exit();
//         }  
        
        
//     }elseif($combinedAm == 2400.00){
//             //For Approved

//             //Member Status
//             $sqlPer = "UPDATE tbperinfo SET memstatID = 1, isApproved = 1 WHERE memberID = ?";
//             $dataPer = array($memID);
//             $stmtPer = $conn->prepare($sqlPer);
//             $stmtPer->execute($dataPer);

//             //Deposit Info
//             $sqlDep = "UPDATE tbdepinfo SET regSav = ?, shareCap = ? WHERE memberID = ?";
//             $dataDep = array(0.00, $combinedAm, $memID);
//             $stmtDep = $conn->prepare($sqlDep);
//             $stmtDep->execute($dataDep);

//             //Transaction Info (1)
//             $sqlTrans = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy , isVoid)
//                     VALUES(?,?,'Regular Saving',?,NOW(),NOW(),?,?)";
//             $dataTrans = array($transID, $memID, $Amount, $appBy, 0);
//             $stmtTrans = $conn->prepare($sqlTrans);
//             $stmtTrans->execute($dataTrans);

//             //Transaction Info (2)
//             $sqlTrans1 = "INSERT INTO tbtransinfo(transID, memberID, trDesc, trAmount, trDate, trTime, trAppBy , isVoid)
//                     VALUES(?,?,'Transfer Regular to PSC',?,NOW(),NOW(),?,?)";
//             $dataTrans1 = array($transID, $memID, $combinedAm, $appBy, 0);
//             $stmtTrans1 = $conn->prepare($sqlTrans1);
//             $stmtTrans1->execute($dataTrans1);

//             //Deposit History (1)
//             $sqlDepHis = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, depDate, depTime)
//                 VALUES(?,1,?,?,?,NOW(),NOW())";
//             $dataDepHis = array($memID, $Amount, $invoice, $cheque);
//             $stmtDepHis = $conn->prepare($sqlDepHis);
//             $stmtDepHis->execute($dataDepHis);

//             //Deposit History (2)
//             $sqlDepHis1 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, depDate, depTime)
//             VALUES(?,2,?,?,?,NOW(),NOW())";
//             $dataDepHis1 = array($memID, $combinedAm, $invoice, $cheque);
//             $stmtDepHis1 = $conn->prepare($sqlDepHis1);
//             $stmtDepHis1->execute($dataDepHis1);

//             //Deposit History (3)
//             $sqlDepHis2 = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, depDate, depTime)
//             VALUES(?,1,0.00,?,?,NOW(),NOW())";
//             $dataDepHis2 = array($memID, $invoice, $cheque);
//             $stmtDepHis2 = $conn->prepare($sqlDepHis2);
//             $stmtDepHis2->execute($dataDepHis2);

//             //PMES Status
//             $sqlPMES = "UPDATE tbpmesinfo SET OnGoingPaid = ?, rlCount = 1, igpCount = 1 WHERE memberID = ?";
//             $dataPMES = array(1, $memID);
//             $stmtPMES = $conn->prepare($sqlPMES);
//             $stmtPMES->execute($dataPMES);

            
//             if($stmtPer && $stmtTrans && $stmtTrans1 && $stmtDepHis && $stmtDepHis1 && $stmtDepHis2 && $stmtPMES){
//                 //Success
//                 $_SESSION['valRes'] = 'Regular Saving to PSC Success!';
//                 header("Location: ../admin_masterlist.php");
//                 exit();
//             }
//         }









// }else{
//     //Return to previous page
//     //Throw Alert
//     
// }
// if($combinedAm > $remBal){

      

// }elseif($Amount == $remBal){
//     
// }
// switch($paypmes){
//     case 1 : 
//         $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
//         $accID = htmlspecialchars(strip_tags(trim($_POST['accountID'])));
//         $conducted = htmlspecialchars(strip_tags(trim($_POST['conducts'])));
//         $refer = htmlspecialchars(strip_tags(trim($_POST['refer'])));

//         if($refer == 0){
//             $sqlPMES = "INSERT INTO tbpmesinfo(memberID, referName, conductID, approvedBy)
//                         VALUES(?,?,?,?)";
//             $dataPMES = array($memID, 0, $conducted,1);
//             $stmtPMES = $conn->prepare($sqlPMES);
//             $stmtPMES->execute($dataPMES);
//         }else{
//             $sqlPMES = "INSERT INTO tbpmesinfo(memberID, referName, conductID, approvedBy)
//                         VALUES(?,?,?,?)";
//             $dataPMES = array($memID, $refer, $conducted,1);
//             $stmtPMES = $conn->prepare($sqlPMES);
//             $stmtPMES->execute($dataPMES);
//         }

//         if($stmtPMES){
//             //Success
//             $flag=encrypt(2, $key);
//             $accID=encrypt($accID, $key);
//             header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//             exit();
//         }else{
//             //Failed
//             $flag=encrypt(1, $key);
//             $accID=encrypt($accID, $key);
//             header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//         }
//         break;

//     case 2 :
//         $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
//         $accID = htmlspecialchars(strip_tags(trim($_POST['accountID'])));
//         $sss = htmlspecialchars(strip_tags(trim($_POST['sss'])));
//         $tin = htmlspecialchars(strip_tags(trim($_POST['tin'])));
//         $IDType = htmlspecialchars(strip_tags(trim($_POST['cboID'])));
//         $IDNum = htmlspecialchars(strip_tags(trim($_POST['othID'])));

//         $sqlIden = "INSERT INTO tbidinfo(memberID, SSSno, taxIdenNo, idTypesID, idTypeNo)
//                         VALUES(?, ?, ?, ?, ?)";
//         $dataIden = array($memID, $sss, $tin, $IDType, $IDNum);
//         $stmtIden=$conn->prepare($sqlIden);
//         $stmtIden->execute($dataIden);

//         if($stmtIden){
//             //Success
//             $flag=encrypt(3, $key);
//             $accID=encrypt($accID, $key);
//             header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//             exit();
//         }else{
//             //Failed
//             $flag=encrypt(2, $key);
//             $accID=encrypt($accID, $key);
//             header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//         }

//         break;

//     case 3 :
//         $payment = '';
//         if(isset($_GET['payment'])){
//             $payment = decrypt($_GET['payment'], $key);
//         }

//         if($payment == 1){
//             $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
//             $accID = htmlspecialchars(strip_tags(trim($_POST['accountID'])));
//             $check = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
//             $invoice = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
//             $depType = htmlspecialchars(strip_tags(trim($_POST['depType'])));
//             $depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));
            
//             $Amount = checkDecimal($depAm);
//             $regFee = 150.00;
//             $deathCare = 500.00;

//             if($depType == 1){
//                 if($Amount > 50.00 || $Amount >= 2399.00){

//                     //Deposit Info
//                     $sqlDEP = "INSERT INTO tbdepinfo(memberID, regSav, regFee, dtCare)
//                     VALUES(?,?,?,?)";
//                     $dataDEP = array($memID, $Amount, $regFee, $deathCare);
//                     $stmtDEP = $conn->prepare($sqlDEP);
//                     $stmtDEP->execute($dataDEP);

//                     $sqlPMES = "UPDATE tbpmesinfo SET isPaid = ? WHERE memberID = ?";
//                     $dataPMES = array(1, $memID);
//                     $stmtPMES = $conn->prepare($sqlPMES);
//                     $stmtPMES->execute($dataPMES);
                

//                     //SQL DEP HISTORY
//                     $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
//                                 VALUES(?,?,?,?,?,NOW())";
//                     $dataHIS = array($memID, $depType, $Amount, $invoice, $check);
//                     $stmtHIS = $conn->prepare($sqlHIS);
//                     $stmtHIS->execute($dataHIS);

//                     //SQL TRAN
//                     $sqlTRAN = "INSERT INTO tbtransinfo(memberID, transID, trDesc, trAmount, trTD, isVoid)
//                                 VALUES(?,?,?,?,NOW(),?)";
//                     $dataTRAN = array($memID, 1, "Regular Savings", $Amount, 0);
//                     $stmtTRAN = $conn->prepare($sqlTRAN);
//                     $stmtTRAN->execute($dataTRAN);
                    
//                     $sqlperInfo = "UPDATE tbperinfo SET memstatID = ? WHERE memberID = ?";
//                     $dataPerInfo = array(2, $memID);
//                     $stmtPerInfo = $conn->prepare($sqlperInfo);
//                     $stmtPerInfo->execute($dataPerInfo);

//                     if($stmtDEP && $stmtHIS && $stmtTRAN && $stmtTRAN){
//                         //Success
//                         header("Location: ../admin_pendings.php");
//                         exit();
//                     }else{
//                         //Failed
//                         $flag=encrypt(4, $key);
//                         $accID=encrypt($accID, $key);
//                         header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//                     }
//                 }else{
//                     $flag=encrypt(4, $key);
//                     $accID=encrypt($accID, $key);
//                     header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//                 }
//             }elseif($depType == 2){
//                 if($Amount == 2400.00){
//                     //Deposit Info
//                     $sqlDEP = "INSERT INTO tbdepinfo(memberID, regSav, regFee, dtCare)
//                     VALUES(?,?,?,?)";
//                     $dataDEP = array($memID, $Amount, $regFee, $deathCare);
//                     $stmtDEP = $conn->prepare($sqlDEP);
//                     $stmtDEP->execute($dataDEP);

//                     //SQL DEP HISTORY
//                     $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, CheckRef, datePay)
//                                 VALUES(?,?,?,?,?,NOW())";
//                     $dataHIS = array($memID, $depType, $Amount, $invoice, $check);
//                     $stmtHIS = $conn->prepare($sqlHIS);
//                     $stmtHIS->execute($dataHIS);

//                     //SQL TRAN
//                     $sqlTRAN = "INSERT INTO tbtransinfo(memberID, transID, trDesc, trAmount, trTD, isVoid)
//                                 VALUES(?,?,?,?,NOW(),?)";
//                     $dataTRAN = array($memID, 2, "Shared Capital", $Amount, 0);
//                     $stmtTRAN = $conn->prepare($sqlTRAN);
//                     $stmtTRAN->execute($dataTRAN);
                    
//                     $sqlperInfo = "UPDATE tbperinfo SET memstatID = ? WHERE memberID = ?";
//                     $dataPerInfo = array(1, $memID);
//                     $stmtPerInfo = $conn->prepare($sqlperInfo);
//                     $stmtTRAN->execute($dataPerInfo);

//                     if($stmtDEP && $stmtHIS && $stmtTRAN && $stmtTRAN){
//                         //Success
//                         header("Location: ../admin_masterlist.php");
//                         exit();
//                     }else{
//                         //Failed
//                         $flag=encrypt(4, $key);
//                         $accID=encrypt($accID, $key);
//                         header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//                     }
//                 }else{
//                     $flag=encrypt(4, $key);
//                     $accID=encrypt($accID, $key);
//                     header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
                
//                 }
//             }
//         }elseif($payment == 2){
//             $memID = htmlspecialchars(strip_tags(trim($_POST['memberID'])));
//             $accID = htmlspecialchars(strip_tags(trim($_POST['accountID'])));
//             // $check = htmlspecialchars(strip_tags(trim($_POST['checkRef'])));
//             $invoice = htmlspecialchars(strip_tags(trim($_POST['invRef'])));
//             $depType = htmlspecialchars(strip_tags(trim($_POST['depType'])));
//             $depAm = htmlspecialchars(strip_tags(trim($_POST['depAm'])));

//             $Amount = checkDecimal($depAm);
//             $regFee = 150.00;
//             $deathCare = 500.00;

//             if($depType == 2){
//                 if($Amount == 2400.00){
//                     //Deposit Info
//                     $sqlDEP = "INSERT INTO tbdepinfo(memberID, regSav, regFee, dtCare)
//                                 VALUES(?,?,?,?)";
//                     $dataDEP = array($memID, $Amount, $regFee, $deathCare);
//                     $stmtDEP = $conn->prepare($sqlDEP);
//                     $stmtDEP->execute($dataDEP);

//                     //SQL DEP HISTORY
//                     $sqlHIS = "INSERT INTO tbdephisinfo(memberID, deptypeID, amount, InvoiceNo, datePay)
//                                 VALUES(?,?,?,?,?,NOW())";
//                     $dataHIS = array($memID, $depType, $Amount, $invoice);
//                     $stmtHIS = $conn->prepare($sqlHIS);
//                     $stmtHIS->execute($dataHIS);

//                     //SQL TRAN
//                     $sqlTRAN = "INSERT INTO tbtransinfo(memberID, transID, trDesc, trAmount, trTD, isVoid)
//                                 VALUES(?,?,?,?,NOW(),?)";
//                     $dataTRAN = array($memID, 2, "Shared Capital", $Amount, 0);
//                     $stmtTRAN = $conn->prepare($sqlTRAN);
//                     $stmtTRAN->execute($dataTRAN);
                    
//                     $sqlperInfo = "UPDATE tbperinfo SET memstatID = ? WHERE memberID = ?";
//                     $dataPerInfo = array(1, $memID);
//                     $stmtPerInfo = $conn->prepare($sqlperInfo);
//                     $stmtTRAN->execute($dataPerInfo);

//                     if($stmtDEP && $stmtHIS && $stmtTRAN && $stmtTRAN){
//                         //Success
//                         header("Location: ../admin_masterlist.php");
//                         exit();
//                     }else{
//                         //Failed
//                         $flag=encrypt(5, $key);
//                         $accID=encrypt($accID, $key);
//                         header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
//                     }
//                 }else{
//                     $flag=encrypt(5, $key);
//                     $accID=encrypt($accID, $key);
//                     header("Location: ../admin_paypmes.php?flag=$flag&pmes=$accID");
                
//                 }
//             }
//         }
//         break;
// }
?>