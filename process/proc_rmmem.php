<?php 

require_once '../cruds/config.php';
require_once 'func_func.php';
session_start();

$rem = '';
$key = "LLAMPCO";
if(isset($_GET['memrem'])){
    $rem = decrypt($_GET['memrem'], $key);

    $sqlinfo = "SELECT memstatID AS statuses FROM tbperinfo WHERE memberID=?";
    $datainfo = array($rem);
    $stmtinfo = $conn->prepare($sqlinfo);
    $stmtinfo->execute($datainfo);
    $rowinfo = $stmtinfo->fetch(PDO::FETCH_ASSOC);
    $status = $rowinfo['statuses'];

    switch($status){
        case 1: //Approved 1
            $sql = "UPDATE tbperinfo SET memstatID=? WHERE memberID=?";
            $data = array(4, $rem);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
        break;
        case 2: //Pending 0 - 2
            $sql = "UPDATE tbperinfo SET memstatID=?, isActive = 2 WHERE memberID=?";
            $data = array(4, $rem);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
        break;
        case 3: //On-going 0 - 3
            $sql = "UPDATE tbperinfo SET memstatID=?, isActive = 3 WHERE memberID=?";
            $data = array(4, $rem);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
        break;
    }
    if($stmt){
        $_SESSION['removed'] = 'Member has been removed!';
        header('location: ../admin_removed.php');
    }
}

if(isset($_GET['res'])){
    $res = decrypt($_GET['res'], $key);

    $sqlinfo = "SELECT isActive AS Active FROM tbperinfo WHERE memberID=?";
    $datainfo = array($res);
    $stmtinfo = $conn->prepare($sqlinfo);
    $stmtinfo->execute($datainfo);
    $rowinfo = $stmtinfo->fetch(PDO::FETCH_ASSOC);
    $isActive = $rowinfo['Active'];

    switch($isActive){
        case 1:
            $sql = "UPDATE tbperinfo SET memstatID=? WHERE memberID=?";
            $data = array(1, $res);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            if($stmt){
                $_SESSION['resSucc'] = 'Member has been restored!';
                header('location: ../admin_masterlist.php');
            }
        break;
        case 2:
            $sql = "UPDATE tbperinfo SET memstatID=?, isActive = 0 WHERE memberID=?";
            $data = array(2, $res);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            if($stmt){
                $_SESSION['resSucc'] = 'Member has been restored!';
                header('location: ../admin_pendings.php');
            }
        break;
        case 3:
            $sql = "UPDATE tbperinfo SET memstatID=?, isActive = 0 WHERE memberID=?";
            $data = array(3, $res);
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            if($stmt){
                $_SESSION['resSucc'] = 'Member has been restored!';
                header('location: ../admin_pendings.php');
            }
        break;
    }
}

if(isset($_GET['lnreject'])){
    $lnreject = decrypt($_GET['lnreject'], $key);

    $sqlinfo = "UPDATE tbperinfo SET isLoan = 0 WHERE memberID = ?";
    $datainfo = array($lnreject);
    $stmtinfo = $conn->prepare($sqlinfo);
    $stmtinfo->execute($datainfo);
    
    $sqllninfo = "UPDATE tbloaninfo SET lnstatID = 5, isActivate = 0 WHERE memberID = ?";
    $datalninfo = array($lnreject);
    $stmtlninfo = $conn->prepare($sqllninfo);
    $stmtlninfo->execute($datalninfo);

    if($stmtinfo && $stmtlninfo){
        $_SESSION['lnreject'] = 'Loan request has been rejected!';
        header('location: ../admin_lnpending.php');
    }
    

}
?>