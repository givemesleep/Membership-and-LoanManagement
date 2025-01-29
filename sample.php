<?php 
// Your PHP code here (if needed)
// require_once 'cruds/config.php';
// require_once 'process/func_func.php';

// $depAm = 100;
// // $Amount = checkDecimal($depAm);


// echo $remBal;
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch Checkbox Example</title>
    <script>
        function toggleRequired() {
            const inputField = document.getElementById('inputField');
            const checkBox = document.getElementById('checkBox');
            if (checkBox.checked) {
                inputField.setAttribute('required', 'required');
                inputField.style.display = 'block';
            } else {
                inputField.removeAttribute('required');
                inputField.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <label for="checkBox">Require Input:</label>
    <input type="checkbox" id="checkBox" name="toggle" onclick="toggleRequired()">
    <br>
    <label for="inputField">Input Field:</label>
    <input type="text" id="inputField" style="display:none;">
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select2 Dropdown Example</title> -->
    <!-- Include jQuery -->
    
     
    <!-- Include Select2 CSS -->
    <!-- <script src="jqueryto/jquerytodiba.min.js"></script>
    <link rel="stylesheet" href="dist/css/select2.min.css">
    <script src="dist/js/select2.min.js"></script> -->
    <!-- Include Select2 JS -->
    
<!--      
</head>
<body>
    <h1>Select2 Dropdown Example</h1>
    <select id="mySelect" style="width: 200px;">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
    </select>

    <script>
        $(document).ready(function() {
            $('#mySelect').select2();
        });
    </script>
</body>
</html> -->


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search</title>
    <style>
        .result-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: {'q': query},
                    success: function(data) {
                        $('#results').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <input type="text" id="search" placeholder="Search...">
    <div id="results"></div>
</body>
</html> -->


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable List Group</title>
    <style>
        .list-group {
            list-style-type: none;
            padding: 0;
        }
        .list-group-item {
            padding: 10px;
            cursor: pointer;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
        .list-group-item:hover {
            background-color: #f0f0f0;
        }
        .form-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <ul class="list-group" id="listGroup">
        <li class="list-group-item" data-info="Item 1 Information"><div class="col-md-6 text-start">Item 1</div> <div class="col-md-6 text-end">Item 2</div></li>
        <li class="list-group-item" data-info="Item 2 Information">Item 2</li>
        <li class="list-group-item" data-info="Item 3 Information">Item 3</li>
    </ul>

    <div class="form-container">
        <form id="infoForm">
            <label for="info">Information:</label>
            <input type="text" id="info" name="info" readonly>
        </form>
    </div>

    <script>
        document.getElementById('listGroup').addEventListener('click', function(e) {
            if (e.target && e.target.matches('li.list-group-item')) {
                document.getElementById('info').value = e.target.getAttribute('data-info');
            }
        });
    </script>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable List Group with Search</title>
    <style>
        .list-group {
            list-style-type: none;
            padding: 0;
        }
        .list-group-item {
            padding: 10px;
            cursor: pointer;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
        .list-group-item:hover {
            background-color: #f0f0f0;
        }
        .form-container {
            margin-top: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search items...">
    </div>

    <ul class="list-group" id="listGroup">
        <li class="list-group-item" data-info="Item 1 Information">Item 1</li>
        <li class="list-group-item" data-info="Item 2 Information">Item 2</li>
        <li class="list-group-item" data-info="Item 3 Information">Item 3</li>
    </ul>

    <div class="form-container">
        <form id="infoForm">
            <label for="info">Information:</label>
            <input type="text" id="info" name="info" readonly>
        </form>
    </div>

    <script>
        document.getElementById('listGroup').addEventListener('click', function(e) {
            if (e.target && e.target.matches('li.list-group-item')) {
                document.getElementById('info').value = e.target.getAttribute('data-info');
            }
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('.list-group-item');
            items.forEach(function(item) {
                const text = item.textContent.toLowerCase();
                if (text.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable List Group</title>
    <style>
        .list-group {
            list-style-type: none;
            padding: 0;
            max-height: 200px;
            overflow-y: auto;
        }
        .list-group-item {
            padding: 10px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .list-group-item:hover {
            background-color: #f0f0f0;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <input type="text" id="search" placeholder="Search for an item...">
    <ul id="listGroup" class="list-group"></ul>
    <form id="itemForm" class="hidden">
        <label for="selectedItem">Selected Item:</label>
        <input type="text" id="selectedItem" readonly>
    </form>

    <script>
        const items = ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6', 'Item 7'];
        const listGroup = document.getElementById('listGroup');
        const search = document.getElementById('search');
        const itemForm = document.getElementById('itemForm');
        const selectedItem = document.getElementById('selectedItem');

        function renderList(filteredItems) {
            listGroup.innerHTML = '';
            filteredItems.slice(0, 5).forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                li.className = 'list-group-item';
                li.onclick = () => {
                    selectedItem.value = item;
                    itemForm.classList.remove('hidden');
                };
                listGroup.appendChild(li);
            });
        }

        search.addEventListener('input', () => {
            const searchTerm = search.value.toLowerCase();
            const filteredItems = items.filter(item => item.toLowerCase().includes(searchTerm));
            renderList(filteredItems);
        });

        renderList(items);
    </script>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable List Group with Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Search and Select Item</h2>
        <input type="text" id="searchInput" class="form-control" placeholder="Search for an item...">
        <ol class="list-group mt-3" id="itemList" >
               <?php 

            require_once 'cruds/config.php';

             $sqlbg = "SELECT * FROM tbbrgys LIMIT 1000";

              // $dataQuery = array($query);

               $stmtbg = $conn->prepare($sqlbg);

                $stmtbg->execute();

                 if($stmtbg->rowCount() > 0){

                      while($rowbg=$stmtbg->fetch()){

                       echo '<li class="list-group-item" data-info="'.$rowbg['brgyDesc'].'">'.$rowbg['brgyDesc'].'</li>';

                        }

                     }else {

                           
           echo '<li class="list-group-item">No Items</li>';
                }
             
             ?>
        </ol>
        <form id="itemForm" class="mt-3">
            <div class="form-group">
                <label for="itemName">Item Name:</label>
                <label for="info">Information:</label>
                <input type="text" class="form-control" id="itemName" readonly>
            </div>
        </form>
    </div>

    <script>
        // $(document).ready(function() {
        //     function fetchItems(query = '') {
        //         $.ajax({
        //             url: 'texting.php',
        //             method: 'POST',
        //             data: { query: query },
        //             success: function(data) {
        //                 $('#itemList').html(data);
        //             }
        //         });
        //     }

                

            // fetchItems();
            // document.getElementById('listGroup').addEventListener('click', function(e) {
            // if (e.target && e.target.matches('li.list-group-item')) {
            //     document.getElementById('info').value = e.target.getAttribute('data-info');
            // }
            // });

            // function renderList(filteredItems) {
            //     const listGroup = document.getElementById('itemList');
            //     listGroup.innerHTML = '';
            //     filteredItems.slice(0, 5).forEach(item => {
            //         const li = document.createElement('li');
            //         li.textContent = item;
            //         li.className = 'list-group-item';
            //         li.onclick = () => {
            //             document.getElementById('itemName').value = item;
            //         };
            //         listGroup.appendChild(li);
            //     });
            // }

            // document.getElementById('searchInput').addEventListener('input', function() {
            //     const searchTerm = this.value.toLowerCase();
            //     const items = Array.from(document.querySelectorAll('.list-group-item')).map(item => item.textContent);
            //     const filteredItems = items.filter(item => item.toLowerCase().includes(searchTerm));
            //     renderList(filteredItems);
            // });

            // const initialItems = Array.from(document.querySelectorAll('.list-group-item')).map(item => item.textContent);
            // renderList(initialItems);
            // $('#search').on('keyup', function() {
            //     let query = $(this).val();
            //     fetchItems(query);
            // });

            // $(document).on('click', '.list-group-item', function() {
            //     let itemName = $(this).text();
            //     $('#itemName').val(itemName);
            // });
            document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('.list-group-item');
            items.forEach(function(item) {
                const text = item.textContent.toLowerCase();
                if (text.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> -->

<?php
// Create an array
// $arrayList = array("Apple", "Banana", "Cherry", "Date", "Elderberry");

// // Display the array
// foreach ($arrayList as $item) {
//     echo $item . "<br>";
// }
?>

<!-- <!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Computation</title>
<?php 

$x=100;

?>
    <script>
        function computeVal() {
            const num1 = parseFloat(document.getElementById('num1').value) || 0;
            const num2 = <?php echo $x; ?>;
            const sum = num1 + num2;
            document.getElementById('result').textContent = 'Sum: ' + sum;
        }
    </script>
</head>
<body>
    <h1>Real-Time Computation</h1>
    <label for="num1">Number 1:</label>
    <input type="number" id="num1" oninput="computeVal()">
    <br>
    <br>
    <p id="result">Result: 0</p>
</body>
</html> -->


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amortization Schedule</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Amortization Schedule</h1>
    <form id="amortizationForm">
        <label for="principal">Principal Amount:</label>
        <input type="number" id="principal" required><br><br>
        <label for="rate">Annual Interest Rate (%):</label>
        <input type="number" id="rate" step="0.01" required><br><br>
        <label for="years">Number of Years:</label>
        <input type="number" id="years" required><br><br>
        <button type="submit">Calculate</button>
    </form>
    <br>
    <table id="schedule">
        <thead>
            <tr>
                <th>Month</th>
                <th>Payment</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#amortizationForm').on('submit', function(event) {
                event.preventDefault();
                let principal = parseFloat($('#principal').val());
                let rate = parseFloat($('#rate').val()) / 100 / 12;
                let years = parseInt($('#years').val());
                let months = years * 12;
                let payment = principal * rate / (1 - Math.pow(1 + rate, -months));
                let balance = principal;
                let schedule = '';

                for (let i = 1; i <= months; i++) {
                    let interest = balance * rate;
                    let principalPayment = payment - interest;
                    balance -= principalPayment;
                    schedule += `<tr>
                                    <td>${i}</td>
                                    <td>${payment.toFixed(2)}</td>
                                    <td>${principalPayment.toFixed(2)}</td>
                                    <td>${interest.toFixed(2)}</td>
                                    <td>${balance.toFixed(2)}</td>
                                </tr>`;
                }

                $('#schedule tbody').html(schedule);
            });
        });
    </script>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form id="myForm">
        <fieldset>
            <legend>Personal Information</legend>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <span class="error" id="nameError"></span><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <span class="error" id="emailError"></span><br><br>

            <button type="button" onclick="validateForm()">Next</button>
        </fieldset>
    </form>

    <script>
        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';

            // Validate name
            const name = document.getElementById('name').value;
            if (name === '') {
                // document.getElementById('nameError').textContent = 'Name is required';
                // document.getElementById('nameError').style.color = 'Name is required';
                inputField.style.outline = '1px solid red';
                isValid = false;
            }

            // Validate email
            const email = document.getElementById('email').value;
            if (email === '') {
                document.getElementById('emailError').textContent = 'Email is required';
                isValid = false;
            } else {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    document.getElementById('emailError').textContent = 'Invalid email format';
                    isValid = false;
                }
            }

            if (isValid) {
                alert('Form is valid. Proceeding to next step.');
                // You can add code here to proceed to the next step
            }
        }
    </script>
</body>
</html> -->

<?php

// class LinearRegression
// {
//     private $slope;
//     private $intercept;

//     public function train(array $x, array $y)
//     {
//         $n = count($x);
//         $x_mean = array_sum($x) / $n;
//         $y_mean = array_sum($y) / $n;

//         $numerator = 0;
//         $denominator = 0;

//         for ($i = 0; $i < $n; $i++) {
//             $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
//             $denominator += ($x[$i] - $x_mean) ** 2;
//         }

//         $this->slope = $numerator / $denominator;
//         $this->intercept = $y_mean - ($this->slope * $x_mean);
//     }

//     public function predict($x)
//     {
//         return $this->slope * $x + $this->intercept;
//     }

//     public function getSlope()
//     {
//         return $this->slope;
//     }

//     public function getIntercept()
//     {
//         return $this->intercept;
//     }
// }

// // Example usage
// $x = [1, 2, 3, 4, 5];
// $y = [2, 4, 5, 4, 5];

// $regression = new LinearRegression();
// $regression->train($x, $y);

// echo "Slope: " . $regression->getSlope() . "\n";
// echo "Intercept: " . $regression->getIntercept() . "\n";
// echo "Prediction for x=6: " . $regression->predict(6) . "\n";

?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Linear Regression</title>
</head>
<body>
    <h1>Linear Regression Prediction</h1>
    <form method="post">
        <label for="timeframe">Select Timeframe:</label>
        <select id="timeframe" name="timeframe">
            <option value="today">Today</option>
            <option value="this_month">This Month</option>
            <option value="this_year">This Year</option>
        </select>
        <input type="submit" value="Predict">
    </form>

    <?php
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $timeframe = $_POST['timeframe'];
        
    //     // Example data for linear regression
    //     $data = [
    //         'today' => [1, 2, 3, 4, 5],
    //         'this_month' => [10, 20, 30, 40, 50],
    //         'this_year' => [100, 200, 300, 400, 500]
    //     ];

    //     // Perform linear regression
    //     function linear_regression($x, $y) {
    //         $n = count($x);
    //         $x_sum = array_sum($x);
    //         $y_sum = array_sum($y);
    //         $xy_sum = 0;
    //         $xx_sum = 0;

    //         for ($i = 0; $i < $n; $i++) {
    //             $xy_sum += $x[$i] * $y[$i];
    //             $xx_sum += $x[$i] * $x[$i];
    //         }

    //         $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $xx_sum - $x_sum * $x_sum);
    //         $intercept = ($y_sum - $slope * $x_sum) / $n;

    //         return [$slope, $intercept];
    //     }

    //     $x = range(1, count($data[$timeframe]));
    //     $y = $data[$timeframe];
    //     list($slope, $intercept) = linear_regression($x, $y);

    //     echo "<p>Linear Regression Equation: y = " . round($slope, 2) . "x + " . round($intercept, 2) . "</p>";
    // }
    ?>
</body>
</html> -->



<!-- <!DOCTYPE html>
<html>
<head>
    <title>Linear Regression</title>
</head>
<body>
    <h1>Linear Regression Prediction</h1>
    <form method="post">
        <label for="timeframe">Select Timeframe:</label>
        <select id="timeframe" name="timeframe">
            <option value="today">Today</option>
            <option value="this_month">This Month</option>
            <option value="this_year">This Year</option>
        </select>
        <input type="submit" value="Predict">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $timeframe = $_POST['timeframe'];
        
        // Example data for linear regression
        $data = [
            'today' => [1, 2, 3, 4, 5],
            'this_month' => [10, 20, 30, 40, 50],
            'this_year' => [100, 200, 300, 400, 500]
        ];

        // Perform linear regression
        function linear_regression($x, $y) {
            $n = count($x);
            $x_sum = array_sum($x);
            $y_sum = array_sum($y);
            $xy_sum = 0;
            $xx_sum = 0;

            for ($i = 0; $i < $n; $i++) {
                $xy_sum += $x[$i] * $y[$i];
                $xx_sum += $x[$i] * $x[$i];
            }

            $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $xx_sum - $x_sum * $x_sum);
            $intercept = ($y_sum - $slope * $x_sum) / $n;

            return [$slope, $intercept];
        }

        $x = range(1, count($data[$timeframe]));
        $y = $data[$timeframe];
        list($slope, $intercept) = linear_regression($x, $y);

        echo "<p>Linear Regression Equation: y = " . round($slope, 2) . "x + " . round($intercept, 2) . "</p>";
    }
    ?>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $timeframe = $_POST['timeframe'];
//     $data = [
//         'today' => [1, 2, 3, 4, 5],
//         'this_month' => [10, 20, 30, 40, 50],
//         'this_year' => [100, 200, 300, 400, 500]
//     ];

//     $x = range(1, count($data[$timeframe]));
//     $y = $data[$timeframe];
//     list($slope, $intercept) = linear_regression($x, $y);

//     $predicted_y = [];
//     foreach ($x as $xi) {
//         $predicted_y[] = $slope * $xi + $intercept;
//     }
// }
?>

<canvas id="myChart" width="400" height="200"></canvas>
<script>
$(document).ready(function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($x); ?>,
            datasets: [{
                label: 'Actual Data',
                data: <?php echo json_encode($y); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'Predicted Data',
                data: <?php echo json_encode($predicted_y); ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select2 Multi-Search</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <h1>Select2 Multi-Search Example</h1>
    <select class="js-example-basic-multiple" name="states[]" multiple="multiple" style="width: 50%">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
        <option value="CA">California</option>
        <option value="NY">New York</option>
        <option value="TX">Texas</option>
    </select>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</body>
</html> -->


<!-- <!DOCTYPE html>
<html>
<head>
    <title>Linear Regression Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        // Sample data points
        const dataPoints = [
            { x: 1, y: 2 },
            { x: 2, y: 3 },
            { x: 3, y: 4 },
            { x: 4, y: 5 },
            { x: 5, y: 6 }
        ];

        // Calculate linear regression
        function linearRegression(data) {
            const n = data.length;
            let sumX = 0, sumY = 0, sumXY = 0, sumXX = 0;

            data.forEach(point => {
                sumX += point.x;
                sumY += point.y;
                sumXY += point.x * point.y;
                sumXX += point.x * point.x;
            });

            const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
            const intercept = (sumY - slope * sumX) / n;

            return { slope, intercept };
        }

        const { slope, intercept } = linearRegression(dataPoints);

        // Generate regression line data
        const regressionLine = dataPoints.map(point => ({
            x: point.x,
            y: slope * point.x + intercept
        }));

        // Create chart
        new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Data Points',
                    data: dataPoints,
                    backgroundColor: 'rgba(75, 192, 192, 1)'
                }, {
                    label: 'Regression Line',
                    data: regressionLine,
                    type: 'line',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Management System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Loan Management System</h1>
    <form id="loanForm">
        <label for="loanAmount">Loan Amount:</label>
        <input type="number" id="loanAmount" name="loanAmount" required><br><br>
        <label for="loanRepayment">Loan Repayment:</label>
        <input type="number" id="loanRepayment" name="loanRepayment" required><br><br>
        <button type="submit">Predict Profit</button>
    </form>
    <h2 id="result"></h2>

    <script>
        $(document).ready(function() {
            $('#loanForm').on('submit', function(event) {
                event.preventDefault();

                // Get input values
                var loanAmount = parseFloat($('#loanAmount').val());
                var loanRepayment = parseFloat($('#loanRepayment').val());

                // Simple linear regression coefficients (example values)
                var intercept = 5000; // Example intercept
                var coefficientLoanAmount = 0.8; // Example coefficient for loan amount
                var coefficientLoanRepayment = 0.5; // Example coefficient for loan repayment

                // Calculate predicted profit
                var predictedProfit = intercept + (coefficientLoanAmount * loanAmount) + (coefficientLoanRepayment * loanRepayment);

                // Display result
                $('#result').text('Predicted Profit: $' + predictedProfit.toFixed(2));
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Regression with Multiple Datasets</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        $(document).ready(function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [
                        {
                            label: 'Dataset 1',
                            data: [{x: 1, y: 2}, {x: 2, y: 3}, {x: 3, y: 4}],
                            borderColor: 'red',
                            fill: false
                        },
                        {
                            label: 'Dataset 2',
                            data: [{x: 1, y: 3}, {x: 2, y: 4}, {x: 3, y: 5}],
                            borderColor: 'blue',
                            fill: false
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom'
                        }
                    }
                }
            });

            function linearRegression(data) {
                var n = data.length;
                var sumX = data.reduce((sum, point) => sum + point.x, 0);
                var sumY = data.reduce((sum, point) => sum + point.y, 0);
                var sumXY = data.reduce((sum, point) => sum + point.x * point.y, 0);
                var sumXX = data.reduce((sum, point) => sum + point.x * point.x, 0);

                var slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
                var intercept = (sumY - slope * sumX) / n;

                return { slope: slope, intercept: intercept };
            }

            chart.data.datasets.forEach(dataset => {
                var regression = linearRegression(dataset.data);
                var regressionLine = dataset.data.map(point => ({
                    x: point.x,
                    y: regression.slope * point.x + regression.intercept
                }));

                chart.data.datasets.push({
                    label: dataset.label + ' Regression',
                    data: regressionLine,
                    borderColor: dataset.borderColor,
                    borderDash: [5, 5],
                    fill: false
                });
            });

            chart.update();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Management System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Loan Management System</h1>
    <form id="loanForm">
        <label for="amount">Loan Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <br>
        <label for="interest">Interest Rate (%):</label>
        <input type="number" id="interest" name="interest" required>
        <br>
        <label for="years">Years:</label>
        <input type="number" id="years" name="years" required>
        <br>
        <button type="submit">Calculate</button>
    </form>
    <h2>Monthly Payment: <span id="monthlyPayment"></span></h2>

    <script>
        $(document).ready(function() {
            $('#loanForm').on('submit', function(event) {
                event.preventDefault();
                var amount = parseFloat($('#amount').val());
                var interest = parseFloat($('#interest').val()) / 100 / 12;
                var years = parseFloat($('#years').val()) * 12;

                var monthlyPayment = (amount * interest) / (1 - Math.pow(1 + interest, -years));
                $('#monthlyPayment').text(monthlyPayment.toFixed(2));
            });
        });
    </script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Regression with Chart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        $(document).ready(function() {
            // Sample data points
            var dataPoints = [
                { x: 1, y: 2 },
                { x: 2, y: 3 },
                { x: 3, y: 5 },
                { x: 4, y: 4 },
                { x: 5, y: 6 }
            ];

            // Perform linear regression
            var n = dataPoints.length;
            var sumX = 0, sumY = 0, sumXY = 0, sumXX = 0;

            dataPoints.forEach(function(point) {
                sumX += point.x;
                sumY += point.y;
                sumXY += point.x * point.y;
                sumXX += point.x * point.x;
            });

            var slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
            var intercept = (sumY - slope * sumX) / n;

            // Generate regression line data
            var regressionLine = dataPoints.map(function(point) {
                return { x: point.x, y: slope * point.x + intercept };
            });

            // Create the chart
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Data Points',
                        data: dataPoints,
                        backgroundColor: 'rgba(75, 192, 192, 1)'
                    }, {
                        label: 'Regression Line',
                        data: regressionLine,
                        type: 'line',
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        showLine: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clickable Card</title>
    <style>
        .card {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .hidden-field {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card" onclick="showHiddenField()">
        Click me to show hidden field
    </div>
    <div class="hidden-field" id="hiddenField">
        This is a hidden field that is now visible!
    </div>

    <script>
        function showHiddenField() {
            var hiddenField = document.getElementById('hiddenField');
            hiddenField.style.display = 'block';
        }
    </script>
</body>
</html>
<script>
    function showHiddenField() {
        var hiddenField = document.getElementById('hiddenField');
        if (hiddenField.style.display === 'block') {
            hiddenField.style.display = 'none';
        } else {
            hiddenField.style.display = 'block';
        }
    }
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Min and Max Input</title>
</head>
<body>
<form method="post" action="">
    <label for="value">Value:</label>
    <input type="number" id="value" name="value" required>
    <button type="button" onclick="setMin()">Min</button>
    <button type="button" onclick="setMax()">Max</button>
    <br>
    <input type="submit" value="Submit">
</form>

<script>
function setMin() {
    document.getElementById('value').value = <?php echo isset($minValue) ? $minValue : 0; ?>;
}

function setMax() {
    document.getElementById('value').value = <?php echo isset($maxValue) ? $maxValue : 100; ?>;
}
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Fieldset</title>
    <style>
        .fieldset {
            display: none;
        }
    </style>
</head>
<body>
    <label for="options">Choose an option:</label>
    <select id="options" onchange="changeFieldset()">
        <option value="">Select...</option>
        <option value="fieldset1">Fieldset 1</option>
        <option value="fieldset2">Fieldset 2</option>
    </select>

    <fieldset id="fieldset1" class="fieldset">
        <legend>Fieldset 1</legend>
        <label for="input1">Input 1:</label>
        <input type="text" id="input1" name="input1">
    </fieldset>

    <fieldset id="fieldset2" class="fieldset">
        <legend>Fieldset 2</legend>
        <label for="input2">Input 2:</label>
        <input type="text" id="input2" name="input2">
    </fieldset>

    <script>
        function changeFieldset() {
            var selectedValue = document.getElementById('options').value;
            var fieldsets = document.querySelectorAll('.fieldset');
            fieldsets.forEach(function(fieldset) {
                fieldset.style.display = 'none';
            });
            if (selectedValue) {
                document.getElementById(selectedValue).style.display = 'block';
            }
        }
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form</title>
    <style>
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
    </style>
</head>
<body>
    <form id="multiStepForm">
        <div class="step active">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="button" onclick="nextStep(1)">Next</button>
        </div>
        <div class="step">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="button" onclick="nextStep(-1)">Previous</button>
            <button type="button" onclick="nextStep(1)">Next</button>
        </div>
        <div class="step">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
            <button type="button" onclick="nextStep(-1)">Previous</button>
            <button type="submit">Submit</button>
        </div>
    </form>

    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');

        function showStep(step) {
            steps.forEach((stepElement, index) => {
                stepElement.classList.toggle('active', index === step);
            });
        }

        function nextStep(stepChange) {
            const currentForm = steps[currentStep].querySelector('input');
            if (currentForm.checkValidity()) {
                currentStep += stepChange;
                showStep(currentStep);
            } else {
                currentForm.reportValidity();
            }
        }

        document.getElementById('multiStepForm').addEventListener('submit', function(event) {
            const currentForm = steps[currentStep].querySelector('input');
            if (!currentForm.checkValidity()) {
                event.preventDefault();
                currentForm.reportValidity();
            }
        });

        showStep(currentStep);
    </script>
</body>
</html>

