<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searchable Hidden List</title>
    <style>
        #list {
            display: none;
        }
    </style>
</head>
<body>
    <input type="text" id="searchBox" placeholder="Search...">
    <ul id="list">
        <li>Apple</li>
        <li>Banana</li>
        <li>Cherry</li>
        <li>Date</li>
        <li>Elderberry</li>
    </ul>

    <script>
        const searchBox = document.getElementById('searchBox');
        const list = document.getElementById('list');
        const items = list.getElementsByTagName('li');

        searchBox.addEventListener('input', function() {
            const filter = searchBox.value.toLowerCase().trim();
            let hasVisibleItems = false;

            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                if (item.textContent.toLowerCase().includes(filter)) {
                    item.style.display = '';
                    hasVisibleItems = true;
                } else {
                    item.style.display = 'none';
                }
            }

            if (filter === '') {
                list.style.display = 'none';
            } else {
                list.style.display = hasVisibleItems ? 'block' : 'none';
            }
        });
    </script>
</body>
</html>



<?php
// function shortValue($value) {

//     if ($value >= 1000000000000) {
//         return number_format($value / 1000000000000, 2) . 't';
//     } 
//     elseif ($value >= 1000000000) {
//         return number_format($value / 1000000, 2) . 'b';
//     }
//     elseif ($value >= 1000000) {
//       return number_format($value / 1000000, 2) . 'm';
//     }
//     elseif ($value >= 1000) {
//       return number_format($value / 1000, 2) . 'k';
//     } 
//     else {
//         return number_format($value, 2);
//     }
// }

// // Example usage
// echo shortenMoneyValue(1500); // Output: 1.50k
// echo shortenMoneyValue(2500000); // Output: 2.50m
// echo shortenMoneyValue(500); // Output: 500.00
// echo shortenMoneyValue(2000713570257.63); // Output: 100.00k
?> -->


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Row Validation</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <table id="myTable">
        <tr>
            <td>Row 1</td>
            <td><button onclick="deleteRow(this)">Delete</button></td>
        </tr>
        <tr>
            <td>Row 2</td>
            <td><button onclick="deleteRow(this)">Delete</button></td>
        </tr>
    </table>

    <script>
        function deleteRow(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let row = button.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                    Swal.fire(
                        'Deleted!',
                        'Your row has been deleted.',
                        'success'
                    );
                }
            });
        }
    </script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Example</title>
    <script>
        function updateDropdowns() {
            const dropdown1 = document.getElementById('dropdown1');
            const dropdown2 = document.getElementById('dropdown2');
            const selectedValue1 = dropdown1.value;
            const selectedValue2 = dropdown2.value;

            for (let option of dropdown1.options) {
                option.style.display = option.value === selectedValue2 ? 'none' : 'block';
            }

            for (let option of dropdown2.options) {
                option.style.display = option.value === selectedValue1 ? 'none' : 'block';
            }
        }
    </script>
</head>
<body>
    <select id="dropdown1" onchange="updateDropdowns()">
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>

    <select id="dropdown2" onchange="updateDropdowns()">
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>
</body>
</html>