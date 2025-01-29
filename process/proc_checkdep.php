<?php 
    require_once '../cruds/config.php';
    session_start();

    $id = htmlspecialchars(trim($_POST['idmoto']));
    $deptype = htmlspecialchars(trim($_POST['deptype']));

    if($deptype == '0'){
        $_SESSION['invalidDep'] = 'Please pick deposit!';
        header("Location: ../admin_checkdep.php");
    }else{
    
    $sqldep = "SELECT * FROM tbdeptype WHERE deptypeID = ?";
    $datadep = array($deptype);
    $stmtdep = $conn->prepare($sqldep);
    $stmtdep->execute($datadep);
    $rowdep = $stmtdep->fetch();
    $dep = $rowdep['depDesc'];


    $sqlSr = "SELECT 
                p.memberID AS memID, ui.unID AS accID  		
            FROM tbperinfo p

            JOIN tbuninfo ui
            ON p.memberID = ui.memberID";
    $stmtSr = $conn->prepare($sqlSr);
    $stmtSr->execute();
    $resSr = $stmtSr->fetch();

    $memID = $resSr['memID'];
    $accID = $resSr['accID'];

    if($id != $memID || $id != $accID){
        $_SESSION['inValidID'] = 'Invalid ID!';
        header("Location: ../admin_checkdep.php");
    }else{
        $_SESSION['ValidID'] = 'ID Searched!';
        header("Location: ../admin_checkdep.php?depID=$id&depType=$dep");
    }
}

?>