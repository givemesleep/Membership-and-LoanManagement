<?php 

$term = 4;
$rlcount = 1;
$loanAm = 20000;
// if($lnTerms < 3){
//     echo "Pota";
// }

if($rlcount == 1 && $loanAm >= 20001 || $term < 3){
    // $enmem = encrypt($memUn, $key);
    // $enflag = encrypt('loanDetails', $key);
    // $enlnID = encrypt($loanID, $key);
    // echo "nabasa";
    // $_SESSION['lnErr'] = 'Member reached the maximum loan limit!';
    // header("location: ../admin_createloan.php?mem=$enmem&flag=$enflag&lntype=$enlnID");
    echo "false";
}else{
    echo "true";
}

?>