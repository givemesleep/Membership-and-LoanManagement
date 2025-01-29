<?php 
// require_once "cruds/config.php";
// session_start();

// function encrypt($plaintext, $key) {
//     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//     $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv);
//     return base64_encode($iv . $ciphertext);
// }

// function decrypt($ciphertext, $key) {
//     $ciphertext = base64_decode($ciphertext);
//     $iv_length = openssl_cipher_iv_length('aes-256-cbc');
//     $iv = substr($ciphertext, 0, $iv_length);
//     $ciphertext = substr($ciphertext, $iv_length);
//     return openssl_decrypt($ciphertext, 'aes-256-cbc', $key, 0, $iv);
// }

// function generateHashKey() {
//     return bin2hex(random_bytes(16)); // 32 characters
// }

// // // Example usage:
// // $key = generateHashKey();
// $key = "LLAMPCO";
// $plaintext = 5;
// $encrypted = encrypt($plaintext, $key);
// $decrypted = decrypt($encrypted, $key);

// echo "Key: $key\n";
// echo "Encrypted: $encrypted\n";
// echo "Decrypted: $decrypted\n";





// $a = 0001;
// $key = "LLAMPCO";

// $encrypted = encrypt($a, $key);
// $decrypted = decrypt($encrypted, $key);
// echo "Encrypted: " .  $encrypted;
// echo "Decrypted: " . $decrypted;








// if(isset($_GET['textme'])){
//   try{
//     $idmoto = $_GET['textme'];
//     $sqltext = "SELECT memEmail FROM tbperinfo WHERE memberID = ?";
//     $datatext = array($idmoto);
//     $stmt=$conn->prepare($sqltext);
//     $stmt->execute($datatext);

//     $row=$stmt->fetch();
//     $userEmail=$row['memEmail']; //[1]

//     $message = "Ikaw ay tila sining sa museong d nalulumaaaaaaaaa"; //[2]
//     $outmess = escapeshellarg($message);
//     //throw shit in py
//     echo shell_exec("python ./test.py $userEmail $outmess");
    
//     if($stmt){
//       $_SESSION['MessSent'] = "Email has been sent!";
//       header("Location: admin_masterlist.php?sel=1");
//     }else{
//       $_SESSION['ErrMess'] = "Email not sent!";
//     }
    

//   }catch(PDOException $e){
//       echo $e->getMessage();
//   }
// }



// $emai1 = "msdevpia@gmail.com";
// $emai2 = "devhusto@gmail.com";
// $emai3 = "devjhusto@gmail.com";

//echo shell_exec(" c:\xampp\htdocs\llampco\test.py .$emai1 .$emai2 .$emai3");
//$result = escapeshellcmd("python test.py .$emai1 .$emai2 .$emai3");

//$output = shell_exec($result);
// .$email1 .$email2 .$email3

//echo "<pre>" . $output . "</pre>";
// echo shell_exec("python test.py $emai1 $emai2 $emai3");

// echo shell_exec("python test.py $emai2");

// $factor = random_int(100000, 999999);
// $code = $factor;

// echo $factor;

// if($code == $factor){
//   echo "Equally";
// }else{
//   echo "nope";
// }



// $date = new DateTime(); 
  
// // Extract day, month, and year 
// $day = $date->format('d'); 
// $month = $date->format('m'); 
// $year = $date->format('Y'); 

// $nwyr = substr($year, -2);

// $dateID = $nwyr . $month . $day;
// $rpad =  str_pad($dateID, 9, "0");
// $unID = $rpad . 1;
// echo $unID;

// require_once 'cruds/config.php';

// $sqlreg = "SELECT * FROM tbreg WHERE regsID = ?";
// $datareg = array(14);
// $stmtreg = $conn->prepare($sqlreg);
// $stmtreg->execute($datareg);
// $rowreg = $stmt->fetch();
// $regCode = $rowreg['regCode'];

// echo $regCode;

// $Sample = 1;
// $dapatmatch = 10;
// while (1 > 100){
    
//     $Sample++;
//     if ($Sample == $dapatmatch){
//         echo $Sample ;
//     }
// }
// function calculate_amortization_schedule($loan_amount, $interest_rate, $loan_term) {
//   // Calculate monthly payment
//   $n = 12; // 12 payments per year
//   $T = $loan_term * 12; // total number of payments
//   $payment = $loan_amount * $interest_rate * pow((1 + $interest_rate / $n), $T) / (pow((1 + $interest_rate / $n), $T) - 1);

//   // Initialize variables
//   $remaining_principal = $loan_amount;
//   $schedule = array();

//   // Loop through each payment period
//   for ($i = 1; $i <= $T; $i++) {
//     $interest = $remaining_principal * $interest_rate / $n;
//     $principal = $payment - $interest;
//     $remaining_principal -= $principal;

//     $schedule[] = array(
//       'period' => $i,
//       'payment' => $payment,
//       'interest' => $interest,
//       'principal' => $principal,
//       'remaining_principal' => $remaining_principal
//     );
//   }

//   return $schedule;
// }

// // Example usage:
// $loan_amount = 25000; // initial loan amount
// $interest_rate = 0.04; // annual interest rate
// $loan_term = 15; // years

// $schedule = calculate_amortization_schedule($loan_amount, $interest_rate, $loan_term);

// // Output the amortization schedule
// echo "<table>";
// echo "<tr><th>Period</th><th>Payment</th><th>Interest</th><th>Principal</th><th>Remaining Principal</th></tr>";
// foreach ($schedule as $row) {
//   echo "<tr>";
//   echo "<td>" . $row['period'] . "</td>";
//   echo "<td>" . number_format($row['payment'], 2) . "</td>";
//   echo "<td>" . number_format($row['interest'], 2) . "</td>";
//   echo "<td>" . number_format($row['principal'], 2) . "</td>";
//   echo "<td>" . number_format($row['remaining_principal'], 2) . "</td>";
//   echo "</tr>";
// }
// echo "</table>";

// function generate_amortization_schedule($loan_amount, $interest_rate, $term_years, $payment_interval) {
//   // Calculate monthly interest rate
//   $monthly_interest_rate = $interest_rate / 12;

//   // Calculate number of payments
//   $num_payments = $term_years * 12;

//   // Initialize amortization schedule array
//   $amortization_schedule = array();

//   // Loop through each payment period
//   for ($i = 0; $i < $num_payments; $i++) {
//     // Calculate payment amount
//     $payment = (pow((1 + $monthly_interest_rate), $num_payments) * $loan_amount) / pow((1 + $monthly_interest_rate), $i);

//     // Split payment into interest and principal
//     $interest = $payment * $monthly_interest_rate;
//     $principal = $payment - $interest;

//     // Update loan balance
//     $loan_amount -= $principal;

//     // Store amortization schedule data
//     $amortization_schedule[] = array('payment' => $payment, 'interest' => $interest, 'principal' => $principal, 'balance' => $loan_amount);
//   }

//   return $amortization_schedule;
// }

// // Example usage:
// $loan_amount = 20000;
// $interest_rate = 0.075; // 7.5%
// $term_years = 5;
// $payment_interval = 'monthly';

// $amortization_schedule = generate_amortization_schedule($loan_amount, $interest_rate, $term_years, $payment_interval);

// // Print the amortization schedule
// foreach ($amortization_schedule as $row) {
//   echo "Payment: " . number_format($row['payment']) . "\n";
//   echo "Interest: " . number_format($row['interest']) . "\n";
//   echo "Principal: " . number_format($row['principal']) . "\n";
//   echo "Balance: " . number_format($row['balance']) . "\n\n";
// }


// class Amortization
// 	{
// 		private $loan_amount;
// 		private $term_years;
// 		private $interest;
// 		private $terms;
// 		private $period;
// 		private $currency = "XXX";
// 		private $principal;
// 		private $balance;
// 		private $term_pay;

// 		public function __construct($data)
// 		{
// 			if($this->validate($data)) {

				
// 				$this->loan_amount 	= (float) $data['loan_amount'];
// 				$this->term_years 	= (int) $data['term_years'];
// 				$this->interest 	= (float) $data['interest'];
// 				$this->terms 		= (int) $data['terms'];
				
// 				$this->terms = ($this->terms == 0) ? 1 : $this->terms;

// 				$this->period = $this->terms * $this->term_years;
// 				$this->interest = ($this->interest/100) / $this->terms;

// 				$results = array(
// 					'inputs' => $data,
// 					'summary' => $this->getSummary(),
// 					'schedule' => $this->getSchedule(),
// 					);

// 				$this->getJSON($results);
// 			}
// 		}

// 		private function validate($data) {
// 			$data_format = array(
// 				'loan_amount' 	=> 0,
// 				'term_years' 	=> 0,
// 				'interest' 		=> 0,
// 				'terms' 		=> 0
// 				);

// 			$validate_data = array_diff_key($data_format,$data);
			
// 			if(empty($validate_data)) {
// 				return true;
// 			}else{
// 				echo "<div style='background-color:#ccc;padding:0.5em;'>";
// 				echo '<p style="color:red;margin:0.5em 0em;font-weight:bold;background-color:#fff;padding:0.2em;">Missing Values</p>';
// 				foreach ($validate_data as $key => $value) {
// 					echo ":: Value <b>$key</b> is missing.<br>";
// 				}
// 				echo "</div>";
// 				return false;
// 			}
// 		}

// 		private function calculate()
// 		{
// 			$deno = 1 - 1 / pow((1+ $this->interest),$this->period);

// 			$this->term_pay = ($this->loan_amount * $this->interest) / $deno;
// 			$interest = $this->loan_amount * $this->interest;

// 			$this->principal = $this->term_pay - $interest;
// 			$this->balance = $this->loan_amount - $this->principal;

// 			return array (
// 				'payment' 	=> $this->term_pay,
// 				'interest' 	=> $interest,
// 				'principal' => $this->principal,
// 				'balance' 	=> $this->balance
// 				);
// 		}

// 		public function getSummary()
// 		{
// 			$this->calculate();
// 			$total_pay = $this->term_pay *  $this->period;
// 			$total_interest = $total_pay - $this->loan_amount;

// 			return array (
// 				'total_pay' => $total_pay,
// 				'total_interest' => $total_interest,
// 				);
// 		}

// 		public function getSchedule ()
// 		{
// 			$schedule = array();
			
// 			while  ($this->balance >= 0) { 
// 				array_push($schedule, $this->calculate());
// 				$this->loan_amount = $this->balance;
// 				$this->period--;
// 			}

// 			return $schedule;

// 		}

// 		private function getJSON($data)
// 		{
// 			header('Content-Type: application/json');
// 			echo json_encode($data);
// 		}
// 	}

// 	$data = array(
// 		'loan_amount' 	=> 20000,
// 		'term_years' 	=> 1,
// 		'interest' 		=> 10,
// 		'terms' 		=> 12
// 		);

// 	$amortization = new Amortization($data);


//Working Code
// function generateAmortizationSchedule($principal, $annualInterestRate, $years) {
//     $monthlyInterestRate = $annualInterestRate / 12 / 100;
//     $numberOfPayments = $years * 12;
//     $monthlyPayment = $principal * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));

//     $schedule = [];
//     $remainingBalance = $principal;

//     for ($i = 1; $i <= $numberOfPayments; $i++) {
//         $interestPayment = $remainingBalance * $monthlyInterestRate;
//         $principalPayment = $monthlyPayment - $interestPayment;
//         $remainingBalance -= $principalPayment;

//         $schedule[] = [
//             'payment_number' => $i,
//             'payment' => round($monthlyPayment, 2),
//             'principal_payment' => round($principalPayment, 2),
//             'interest_payment' => round($interestPayment, 2),
//             'remaining_balance' => round($remainingBalance, 2)
//         ];
//     }

//     return $schedule;
// }

// // Example usage
// $principal = 100000; // Loan amount
// $annualInterestRate = 5; // Annual interest rate in percent
// $years = 1; // Loan term in years

// $schedule = generateAmortizationSchedule($principal, $annualInterestRate, $years);

// foreach ($schedule as $payment) {
//     echo "Payment Number: {$payment['payment_number']}\n";
//     echo "Payment: {$payment['payment']}\n";
//     echo "Principal Payment: {$payment['principal_payment']}\n";
//     echo "Interest Payment: {$payment['interest_payment']}\n";
//     echo "Remaining Balance: {$payment['remaining_balance']}\n";
//     echo "-----------------------------\n";
// }

//Successful Working
// function generateAmortizationSchedule($principal, $annualInterestRate, $years, $startDate) {
//     $monthlyInterestRate = $annualInterestRate / 12 / 100;
//     $numberOfPayments = $years * 12;
//     $monthlyPayment = $principal * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
    
//     $schedule = [];
//     $currentDate = new DateTime($startDate);
//     $remainingBalance = $principal;

//     for ($i = 0; $i < $numberOfPayments; $i++) {
//         $interestPayment = $remainingBalance * $monthlyInterestRate;
//         $principalPayment = $monthlyPayment - $interestPayment;
//         $remainingBalance -= $principalPayment;

//         $schedule[] = [
//             'date' => $currentDate->format('Y-m-d'),
//             'interest' => round($interestPayment, 2),
//             'principal' => round($principalPayment, 2),
//             'monthly_payment' => round($monthlyPayment, 2),
//             'remaining_balance' => round($remainingBalance, 2)
//         ];

//         $currentDate->modify('+1 month');
//     }

//     return $schedule;
// }

// // Example usage
// $principal = 100000; // Loan amount
// $annualInterestRate = 5; // Annual interest rate in percent
// $years = 1; // Loan term in years
// $startDate = '2023-01-01'; // Start date of the loan

// $schedule = generateAmortizationSchedule($principal, $annualInterestRate, $years, $startDate);

// foreach ($schedule as $payment) {
//     echo "Date: {$payment['date']},\n Interest: {$payment['interest']}, \nPrincipal: {$payment['principal']}, \nMonthly Payment: {$payment['monthly_payment']}, \nRemaining Balance: {$payment['remaining_balance']}\n";
// }


// function genAmortizationSched($principal, $annualInterestRate, $years, $startDate) {
//     $monthlyInterestRate = $annualInterestRate / 12 / 100;
//     $numberOfPayments = $years * 12;
//     $monthlyPayment = $principal * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
    
//     $schedule = [];
//     $currentDate = new DateTime($startDate);
//     $remainingBalance = $principal;

//     for ($i = 0; $i < $numberOfPayments; $i++) {
//         $interestPayment = $remainingBalance * $monthlyInterestRate;
//         $principalPayment = $monthlyPayment - $interestPayment;
//         $remainingBalance -= $principalPayment;
//         //$overall += $principalPayment ;

//         $schedule[] = [
//             'date' => $currentDate->format('Y-m-d'),
//             'interest' => round($interestPayment, 2),
//             'principal' => round($principalPayment, 2),
//             'monthly_payment' => round($monthlyPayment, 2),
//             'remaining_balance' => round($remainingBalance, 2)
//             // 'overall' => round($overall, 2)
//         ];

//         $currentDate->modify('+1 month');
//     }

//     return $schedule;
// }



// require_once 'process/func_func.php';
// $loanAm = 5000; // Loan amount
// $Interest = 2; // Annual interest rate in percent
// $terms = 3; // Loan term in years
// $startDate = '2024-03-10'; // Start date of the loan

// $LoanAmort =  genAmortizationSched($loanAm, $Interest, $terms, $startDate);



// Adjust the last payment to avoid negative remaining balance
// $lastPayment = &$LoanAmort[count($LoanAmort) - 1];
// $lastPayment['principal'] += $lastPayment['balance'];
// $lastPayment['balance'] = 0;
// $lastPayment['total'] = $lastPayment['interest'] + $lastPayment['principal'];


?>

<!-- <table class="table datatable table-hover">
    <thead style="width : 100%">
        <tr>
            <th scope="col" style="width: 20%;">Due Date</th>
            <th scope="col"  style="width: 20%;">Amount of Loan</th>
            <th scope="col"  style="width: 20%;">Principal</th>
            <th scope="col"  style="width: 20%;">Interest</th>
            <th scope="col"  style="width: 20%;">Total</th>
        </tr>
    </thead>
    <tbody>      
        <?php 
        
        $disp = '';
        $totInt= '';
        $totOv = '';
        foreach ($LoanAmort as $payment) {

            $disp .= '<tr>
                        <td>'.$payment['due'].'</td>
                        <td style="text-align : right;">'.checkDecimal($payment['balance']).'</td>
                        <td style="text-align : right;">'.checkDecimal($payment['principal']).'</td>
                        <td style="text-align : right;">'. decimal($payment['interest']) .'</td>
                        <td style="text-align : right;">'.decimal($payment['total']).'</td>
                        
                    </tr>';
             $totInt = decimal($payment['TotInt']);
            $totOv = decimal($payment['TotOv']);
                }
        echo $disp;
        echo "Total Interest = ". $totInt . "<br>";
        echo "Total Amount = ". $totOv . "<br>";
        echo "Total = " . $totInt + $totOv . "<br>";
        

        ?>
    </tbody>
</table> -->
<?php 
require_once 'cruds/config.php';

// $search = '';
// if(isset($_GET['q'])){
//     $search = $_GET['q'];

//     $sqlMem = "SELECT 
//             un.unID AS ID,
//             CONCAT(IF(p.gendID = 2, 'Ms. ', 'Mr. '), p.memSur, ', ', p.memGiven, ' ', p.memMiddle, ' ', p.suffixes) AS Fullname
//         FROM tbuninfo un
//         JOIN tbperinfo p ON un.memberID = p.memberID
//         WHERE p.memstatID = 1 AND un.unID = ?";
//     $dataQuery = array($search);
//     $stmtMem = $conn->prepare($sqlMem);
//     $stmtMem->execute($dataQuery);
//     if($stmtMem->rowCount() > 0){
//         while($rows = $stmtMem->fetchAll()){
//             echo '<div class="result">' . $row['Fullname'] . '</div>';
//         }
//     }else{
//         echo '<div class="result">No-Data Found</div>';
//     }
// }
$query='';
if(isset($_POST['query'])){
    $query=$_POST['query'];

}


?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reveal</title>
    <style>
        .password-container {
            position: relative;
            width: 300px;
        }
        .password-container input {
            width: 100%;
            padding-right: 40px;
        }
        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <input type="password" id="password" placeholder="Enter your password">
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</body>
</html>
 -->

 


