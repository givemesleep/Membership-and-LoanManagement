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
        .error-message {
            color: red;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <form id="multiStepForm" action="process_form.php" method="post">
        <!-- Step 1 -->
        <div class="step active" id="step1">
            <h2>Step 1: Personal Information</h2>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <span class="error-message" id="usernameError"></span>
            </div>
            <button type="button" id="next1">Next</button>
        </div>

        <!-- Step 2 -->
        <div class="step" id="step2">
            <h2>Step 2: Contact Information</h2>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <span class="error-message" id="emailError"></span>
            </div>
            <button type="button" id="prev1">Previous</button>
            <button type="button" id="next2">Next</button>
        </div>

        <!-- Step 3 -->
        <div class="step" id="step3">
            <h2>Step 3: Review and Submit</h2>
            <p>Review your information before submitting.</p>
            <button type="button" id="prev2">Previous</button>
            <button type="submit" id="submitForm">Submit</button>
        </div>
    </form>

    <script src="script.js"></script>
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    const showStep = (index) => {
        steps.forEach((step, i) => {
            step.classList.toggle('active', i === index);
        });
        currentStep = index;
    };

    document.getElementById('next1').addEventListener('click', () => {
        if (validateStep1()) {
            showStep(1);
        }
    });

    document.getElementById('prev1').addEventListener('click', () => {
        showStep(0);
    });

    document.getElementById('next2').addEventListener('click', () => {
        if (validateStep2()) {
            showStep(2);
        }
    });

    document.getElementById('prev2').addEventListener('click', () => {
        showStep(1);
    });

    function validateStep1() {
        clearErrors();
        const username = document.getElementById('username').value.trim();
        let isValid = true;
        if (!username) {
            showError('usernameError', 'Username is required');
            isValid = false;
        }
        return isValid;
    }

    function validateStep2() {
        clearErrors();
        const email = document.getElementById('email').value.trim();
        let isValid = true;
        if (!email) {
            showError('emailError', 'Email is required');
            isValid = false;
        } else if (!isValidEmail(email)) {
            showError('emailError', 'Invalid email address');
            isValid = false;
        }
        return isValid;
    }

    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function showError(id, message) {
        const errorElement = document.getElementById(id);
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    }

    showStep(currentStep); // Initialize with the first step visible
});

</script>