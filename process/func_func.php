<?php 

function readableDate($date) {
    $timestamp = strtotime($date);
    return date('M. d, Y', $timestamp);
}

function rsConvert($amount){
    $x = $amount / 300;
    $y = intval($x) * 300 ;
    
    if($amount > $y){
        $newRs = $amount - $y;
        return $newRs;
    }else{
        $newRs = $y - $amount;
        return $newRs;
    }

}

function shortValue($value) {
    if ($value >= 1000000000000) {
        return number_format($value / 1000000000000, 2) . 'T';
    } 
    elseif ($value >= 1000000000) {
        return number_format($value / 1000000, 2) . 'B';
    }
    elseif ($value >= 1000000) {
      return number_format($value / 1000000, 2) . 'M';
    }
    elseif ($value >= 1000) {
      return number_format($value / 1000, 2) . 'K';
    } 
    else {
        return number_format($value, 2);
    }
}

function encrypt($plaintext, $key) {
    $key = preg_replace('/[^A-Za-z0-9]/', '', $key); // Remove non-alphanumeric characters from key
    $text = preg_replace('/[^A-Za-z0-9]/', '', $plaintext); // Remove non-alphanumeric characters from text
    $iv = substr(hash('sha256', $key), 0, 16); // Generate IV from key
    $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted);
}

function decrypt($ciphertext, $key) {
    $key = preg_replace('/[^A-Za-z0-9]/', '', $key); // Remove non-alphanumeric characters from key
    $iv = substr(hash('sha256', $key), 0, 16); // Generate IV from key
    $encryptedText = base64_decode($ciphertext);
    return openssl_decrypt($encryptedText, 'aes-256-cbc', $key, 0, $iv);
}

function checkDecimal($param1){
    if(strpos($param1,".") !== false){    
        $num = (float)str_replace(',', '', $param1);
        $nums = $num;
        return $nums;
    }else{
        $num = (float)str_replace(',', '', $param1);
        $nums = number_format($num, 2, '.', '');
        return $nums;
    }
}

function onlyLetters($str) {
    return preg_match('/^[a-zA-Z]+$/', $str) === 1;
}

function transID($param1){
    $date = new DateTime(); 
    // Extract year 
    // $year = $date->format('Y'); 
    // $nwyr = substr($year, -2);
    $month = $date->format('m');
    $rpad = str_pad($month, 3, "0");
    $transID = $rpad.$param1;
    return $transID;

}

function bday($param1){
    $date = new DateTime($param1);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
}

function formatDate($param1){
    $date = date('F d, Y ', strtotime($param1));
    return $date;
}

function perTodec($num){
    $convert = $num / 100;
    return $convert;
}

function decimal($num){
  $convert = sprintf('%.2f', $num);
    return $convert;
}
function genAmortizationSched($loanAm, $interest, $terms, $starting_date ){
    $principal = $loanAm / $terms; // Loan Amount / Number of Terms = P
    $monthInt = perTodec($interest) ; // Principal * Interest Rate = I
    $remBal = $loanAm; // Original Loan Amount
    // $OrigAm = $loanAm; // Original Loan Amount
    $IntTotal = 0; // Total Interest
    $OvTotal = 0; // Total Overall Payment

    //Generate Date
    $Today = new DateTime($starting_date); //Today's date
    $Amortization = []; // Amortization Schedule

    for($i = 0; $i < $terms; $i++){
        //Computation that will loop until the number of months is over
        //Number of months = N * $i, it will loop $i until it reach the max number

        $intPay = checkDecimal($remBal * $monthInt); // Interest Payment 
        $MonthlyBal = checkDecimal($principal + $intPay); // Monthly Balance
        $remBal -= checkDecimal($principal); // Remaining Balance
        $loanBal = $remBal + $principal;
        $IntTotal += checkDecimal($intPay); // Total Interest
        $OvTotal += checkDecimal($MonthlyBal); // Total Overall Payment
        // $OrigAm = 0;
        
        $Amortization[] = [
            'due' => $Today->format('F d, Y'), // Due Date
            'interest' => round(decimal($intPay), 2), // Interest Payment
            'total' => round(decimal($MonthlyBal), 2), // int + principal
            'principal' => round(decimal($principal), 2), // Principal
            'balance' => round(decimal($loanBal), 2), // Remaining Balance
            'TotInt' => round(decimal($IntTotal), 2), // Total Interest
            'TotOv' => round(decimal($OvTotal), 2) // Total Overall Payment
        ];

        $Today->modify('+1 month'); // Add 1 month to the date
    }
    return $Amortization; //Return array of Amortization Schedule
}   

function getMaturity($terms, $starting_date){
    
    $Today = new DateTime($starting_date); //Today's date
    $Schedule = []; // Amortization Schedule

    for($i = 0; $i < $terms; $i++){
        $Schedule[] = [
            'due' => $Today->format('Y-m-d'), // Due Date
        ];
        $Today->modify('+1 month'); // Add 1 month to the date
    }
    return $Schedule; //Return array of Amortization Schedule
}

function getPayable($loanAm, $interest, $terms){
    $principal = $loanAm / $terms; // Loan Amount / Number of Terms = P
    $monthInt = perTodec($interest) ; // Principal * Interest Rate = I
    $remBal = $loanAm; // Original Loan Amount
    $IntTotal = 0; // Total Interest
    $OvTotal = 0; // Total Overall Payment

    //Generate Date
    $Amortization = []; // Amortization Schedule

    for($i = 0; $i < $terms; $i++){
        //Computation that will loop until the number of months is over
        //Number of months = N * $i, it will loop $i until it reach the max number

        $intPay = checkDecimal($remBal * $monthInt); // Interest Payment 
        $MonthlyBal = checkDecimal($principal + $intPay); // Monthly Balance
        $remBal -= checkDecimal($principal); // Remaining Balance
        $loanBal = $remBal + $principal;
        $IntTotal += checkDecimal($intPay); // Total Interest
        $OvTotal += checkDecimal($MonthlyBal); // Total Overall Payment
        // $OrigAm = 0;
        
        $Amortization[] = [
            // 'due' => $Today->format('F d, Y'), // Due Date
            'interest' => round(decimal($intPay), 2), // Interest Payment
            'total' => round(decimal($MonthlyBal), 2), // int + principal
            'principal' => round(decimal($principal), 2), // Principal
            'balance' => round(decimal($loanBal), 2), // Remaining Balance
            'TotInt' => round(decimal($IntTotal), 2), // Total Interest
            'TotOv' => round(decimal($OvTotal), 2) // Total Overall Payment
        ];

        
    }
    return $Amortization; //Return array of Amortization Schedule
}  

function LPPI($age, $term, $loan,$lppi){
    switch($lppi){
        case 1:
            if($age >= 18 && $age <= 64){
                $lppirate = 0.00975;
                $lppi = $lppirate * $term / 12;
            }else{
                return 0;
            }
        break;

        case 2:
            if($age >= 65 && $age <= 69){
                $lppirate = 3;
                $lppi = $lppirate / $loan;
            }else{
                return 0;
            }
        break;

        case 3:
            if($age >= 70){
                $lppirate = 4;
                $lppi = $lppirate / $loan;
            }else{
                return 0;
            }
        break;

        case 4:
            if($age >= 18 && $age <= 64){
                $lppirate = 0.00975;
                $lppi = $lppirate * $term / 12;
            }elseif($age >= 65 && $age <= 69){
                $lppirate = 3;
                $lppi = $lppirate / $loan;
            }elseif($age >= 70){
                $lppirate = 4;
                $lppi = $lppirate / $loan;
            }else{
                return 0;
            }
        break;
    }
    
    return $lppi;
}

function whichLow($loanAm){
    $first = $loanAm * 0.01;
    $second = $loanAm -  1500;

    if($first < $second){
        return $first;
    }else{
        return $second;
    }
}

?>