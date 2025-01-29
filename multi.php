<!DOCTYPE html>
<html>
<head>
    <title>Multi-step Form</title>
    <style>
        fieldset {
            display: none;
        }
        fieldset.active {
            display: block;
        }
        .error {
            border: 2px solid red;
        }
        .success {
            border: 2px solid green;
        }
    </style>
    <script>
        function showFieldset(index) {
            var fieldsets = document.getElementsByTagName('fieldset');
            for (var i = 0; i < fieldsets.length; i++) {
                fieldsets[i].classList.remove('active');
            }
            fieldsets[index].classList.add('active');
        }

        function validateFieldset(index) {
            var fieldsets = document.getElementsByTagName('fieldset');
            var inputs = fieldsets[index].getElementsByTagName('input');
            var selects = fieldsets[index].getElementsByTagName('select');
            var isValid = true;

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value === '') {
                    inputs[i].classList.add('error');
                    isValid = false;
                } else {
                    inputs[i].classList.remove('error');
                }
            }

            for (var i = 0; i < selects.length; i++) {
                if (selects[i].value === '') {
                    selects[i].classList.add('error');
                    isValid = false;
                } else {
                    selects[i].classList.remove('error');
                }
            }

            return isValid;
        }

        function nextFieldset(currentIndex) {
            if (validateFieldset(currentIndex)) {
                showFieldset(currentIndex + 1);
            }
        }

        function addInputListeners() {
            var inputs = document.getElementsByTagName('input');
            var selects = document.getElementsByTagName('select');

            for (var i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value !== '') {
                        this.classList.remove('error');
                        this.classList.add('success');
                    } else {
                        this.classList.remove('success');
                    }
                });
            }

            for (var i = 0; i < selects.length; i++) {
                selects[i].addEventListener('change', function() {
                    if (this.value !== '') {
                        this.classList.remove('error');
                        this.classList.add('success');
                    } else {
                        this.classList.remove('success');
                    }
                });
            }
        }

        window.onload = function() {
            showFieldset(0);
            addInputListeners();
        }
    </script>
</head>
<body>
    <form method="post" action="submit.php">
        <fieldset class="active">
            <legend>Step 1</legend>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br>
            <button type="button" onclick="nextFieldset(0)">Next</button>
        </fieldset>
        <fieldset>
            <legend>Step 2</legend>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
            <label for="country">Country:</label>
            <select id="country" name="country">
                <option value="">Select your country</option>
                <option value="USA">USA</option>
                <option value="Canada">Canada</option>
                <option value="UK">UK</option>
            </select><br>
            <button type="button" onclick="showFieldset(0)">Back</button>
            <button type="button" onclick="nextFieldset(1)">Next</button>
        </fieldset>
        <fieldset>
            <legend>Step 3</legend>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone"><br>
            <button type="button" onclick="showFieldset(1)">Back</button>
            <button type="submit" class="btn" onclick="return validateFieldset(2);">Submit</button>
        </fieldset>
    </form>
</body>
</html>
