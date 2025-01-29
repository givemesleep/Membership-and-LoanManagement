<?php 
require_once 'cruds/config.php';
require_once 'process/func_func.php';

// $loanAm = 12000;
// $interest = 2;
// $terms = 1;
// $starting_date = '2024-10-11';
    
// $Amortization = genAmortizationSched($loanAm, $interest, $terms, $starting_date);

// echo '<pre>';
// print_r($Amortization);
// echo '</pre>';

// foreach($Amortization as $values){

//     $totAmount = $values['TotOv'];
//     $totInterest = $values['TotInt'];
// }
// echo 'Total Interest : ' . $totInterest . '<br>';
// echo 'Total Amount : ' . $totAmount . '<br>';

// $schedule = getMaturity($terms, $starting_date);
// foreach($schedule as $values){
//     echo 'Due Date : ' . $values['due'] . '<br>';
// }

// $x = 1680.75;
// $pay = rsConvert($x); //The Answer will be transfer in Regular Savings
// $newBal = $pay;

// $newAm = $x - $newBal; //The Answer will be the transfer in PSC
// echo 'RS '.$newBal.'<br>';
// echo 'PSC '.$newAm.'<br>'; 

$Amount = 2000;

//fetch the previous balance
$selectDep = "SELECT regSav, shareCap FROM tbdepinfo WHERE memberID = 1";
// $dataDep = array($);
$stmtDep = $conn->prepare($selectDep);
$stmtDep->execute();
$rowDep = $stmtDep->fetch(PDO::FETCH_ASSOC);
$regular = $rowDep['regSav'];
$psc = $rowDep['shareCap'];



//Convert the amount into several parts
$OrigAm = $Amount; //Temp Variable
$oldRs = $OrigAm + $regular;
$newRs = rsConvert($oldRs); //Convert the Amount by divided by 300 

$newAm = $oldRs - $newRs; //Used for adding to PSC
$newPSC = $psc + $newAm; //New PSC
// $newRS = $addRs + $regular; //New Regular Savings
echo 'New Regular Savings : ' . $newRs . '<br>';
echo 'New Balance : ' . $newPSC . '<br>';
echo '<br>' . $OrigAm . '<br>';
echo '<br>' . $oldRs . '<br>';
echo '<br>' . $newRs . '<br>';

$today = new DateTime();
        $today->modify('+1 month');
        $today = $today->format('Y-m-d');
echo $today;
?>