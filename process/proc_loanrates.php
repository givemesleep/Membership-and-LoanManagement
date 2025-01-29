<?php 
    require_once '../cruds/config.php';
    require_once '../cruds/current_user.php';
    
    //Basic CRUDS for Loan Rates 5 steps

    //1 First fetch all inputs and validitate
        $lrID = htmlspecialchars(strip_tags(trim($_POST['lrID'])));
        $loan = htmlspecialchars(strip_tags(trim($_POST['txtloan'])));
        $amount = htmlspecialchars(strip_tags(trim($_POST['txtamount'])));
        $terms = htmlspecialchars(strip_tags(trim($_POST['txtterms'])));
        $int = htmlspecialchars(strip_tags(trim($_POST['txtint'])));
        $ser = htmlspecialchars(strip_tags(trim($_POST['txtservice'])));
        $cbu = htmlspecialchars(strip_tags(trim($_POST['txtcbu'])));
        $def = htmlspecialchars(strip_tags(trim($_POST['txtdef'])));
        $col = htmlspecialchars(strip_tags(trim($_POST['txtcol'])));
        $lppi = htmlspecialchars(strip_tags(trim($_POST['cbolppi'])));
        $com = htmlspecialchars(strip_tags(trim($_POST['txtcom'])));
        $appr = htmlspecialchars(strip_tags(trim($_POST['cboapproval'])));
    //2 Insert into database

    if($lrID != 0){
        $sqllr="UPDATE tbratesinfo SET ToL=?, amdesc=?, intdesc=?, servdesc=?, cbudesc=?, defcoldesc=?, colfeedesc=?, lppi=?, comdesc=?, approval=?, isActive=1 WHERE lrID=?";
        $datalr=array(
            $loan, $amount, $terms, $int, $ser, $cbu, $def, $col, $lppi, $com, $appr, $lrID     
        );
        }else{
        $sqllr="INSERT INTO tbratesinfo(ToL, amdesc, termdesc, intdesc, servdesc, cbudesc, defcoldesc, colfeedesc, lppi, comdesc, approval, isActive)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $datalr=array(
            $loan, $amount, $terms, $int, $ser, $cbu, $def, $col, $lppi, $com, $appr
        );
        }

        $stmtlr=$conn->prepare($sqllr);
        $stmtlr->execute($datalr);
    //3 Update into database

    //4 Soft-delete from database

    //5 testing
    // echo $loan;
    // echo $amount;
    // echo $terms;
    // echo $int;
    // echo $ser;
    // echo $cbu;
    // echo $def;
    // echo $col;
    // echo $lppi;
    // echo $com;
    // echo $appr;
    


?>