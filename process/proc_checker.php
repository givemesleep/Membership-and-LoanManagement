<?php 

require_once '../cruds/config.php';
require_once 'func_func.php';

$flag = $enc = $dec = '';
$key = "LLAMPCO";

if(isset($_GET['s'])){
    $flag = decrypt($_GET['s'], $key);

    switch($flag){
        case 'transview';
        //View Transaction
        $member = htmlspecialchars(strip_tags(trim($_POST['member'])));
        $trans = htmlspecialchars(strip_tags(trim($_POST['transtype'])));    

        if($member == null && $trans == null || $member == 0 && $trans == 0){
            //Return back
            header('Location: ../admin_viewtrans.php');
        }

        switch($trans){
            case 1;
            //Deposit flag
            $flag = encrypt('deposit', $key);
            $enc = encrypt($member, $key);
            header("Location: ../admin_viewtrans.php?res=$flag&mem=$enc");
            break;
            
            case 2;
            //Loan flag
            $flag = encrypt('loan', $key);
            $enc = encrypt($member, $key);
            header("Location: ../admin_viewtrans.php?res=$flag&mem=$enc");
            break;

            default;
            //Return back
            header('Location: ../admin_viewtrans.php');
            break;
        }
        break;

        case '';
        break;
    }
}



?>

