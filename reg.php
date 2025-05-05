<?php
session_start();
error_reporting(E_ALL); // Enable error reporting for debugging

// Include your database configuration file
include "config/db.php"; 

// Initialize variables and error messages
$errors = [];
$college = $email = $phone1 = $phone2 = $degree = $department = '';

// Validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $college = htmlspecialchars(trim($_POST['college']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone1 = htmlspecialchars(trim($_POST['phone1']));
    $phone2 = htmlspecialchars(trim($_POST['phone2']));
    $degree = htmlspecialchars(trim($_POST['degree']));
    $department = htmlspecialchars(trim($_POST['department']));
    
    // Validate college address
    if (empty($college)) {
        $errors['college'] = 'College address is required.';
    } elseif (strlen($college) > 50) {
        $errors['college'] = 'College address cannot exceed 50 characters.';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Validate phone numbers
    if (empty($phone1)) {
        $errors['phone1'] = 'Phone number is required.';
    } elseif (!preg_match('/^\d{10}$/', $phone1)) {
        $errors['phone1'] = 'Phone number must be 10 digits.';
    }

    if (empty($phone2)) {
        $errors['phone2'] = 'Phone number is required.';
    } elseif (!preg_match('/^\d{10}$/', $phone2)) {
        $errors['phone2'] = 'Phone number must be 10 digits.';
    }

    // Validate degree
    if (empty($degree) || $degree === 'Select Degree*') {
        $errors['degree'] = 'Please select a degree.';
    }

    // Validate department
    if (empty($department) || $department === 'Select Department*') {
        $errors['department'] = 'Please select a department.';
    }

    // If there are no errors, store data in session and redirect
    if (empty($errors)) {
        $_SESSION['college'] = $college;
        $_SESSION['email'] = $email;
        $_SESSION['phone1'] = $phone1;
        $_SESSION['phone2'] = $phone2;
        $_SESSION['degree'] = $degree;
        $_SESSION['department'] = $department;
    
        // Redirect to the next page
        header('Location: reg_page1.php'); 
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JOSHIANA | 13.0</title>
    <link rel="icon" type="image/x-icon" href="images/fav-icon.png">
    <link rel="stylesheet" href="assests/css/reg.css" />
</head>
<body>

<section class="container-reg">
    <h4>JOSHIANA <sup>13.0</sup></h4>
    <header>Registration Form</header>
    <p>[Registration is restricted to one team per college. Multiple team registrations from the same college will be disqualified, and no refunds will be provided. However, different departments within the same college (e.g., BSc and BCA, or MSc and MCA) are eligible to register separately ]</p>
    <form action="reg.php" method="post" class="form" id="myForm" onsubmit="return validateForm()">
        <div class="input-box">
            <input type="text" placeholder="Enter College Address *" id="college" name="college" />
            <span id="nameError" class="error"><?php echo isset($errors['college']) ? htmlspecialchars($errors['college']) : ''; ?></span>
        </div>
        <div class="input-box">
            <input type="email" placeholder="Enter Email Address *" id="email" name="email" />
            <span id="emailError" class="error"><?php echo isset($errors['email']) ? htmlspecialchars($errors['email']) : ''; ?></span>
        </div>
        <div class="input-box">
            <input type="phone" placeholder="Enter Phone Number *" id="phone" name="phone1" />
            <span id="phoneError" class="error"><?php echo isset($errors['phone1']) ? htmlspecialchars($errors['phone1']) : ''; ?></span>
        </div>
        <div class="input-box">
            <input type="phone" placeholder="Enter Phone Number *" id="phone" name="phone2" />
            <span id="phoneError" class="error"><?php echo isset($errors['phone2']) ? htmlspecialchars($errors['phone2']) : ''; ?></span>
        </div>
            <div class="input-box">
                    <select name="degree" id="degree">
                        <option hidden>Select Degree*</option>
                        <option value="ug">UG</option>
                        <option value="pg">PG</option>
                    </select>
                    <div class="error" id="degError"><?php echo isset($errors['degree']) ? htmlspecialchars($errors['degree']) : ''; ?></div>
            </div>
            <div class="input-box">
                <select name="department" id="department" hidden>
                    <option value="NA" selected>NA</option>
                </select>
                <div class="error" id="deptError"><?php echo isset($errors['department']) ? htmlspecialchars($errors['department']) : ''; ?></div>
            </div>
            </div
        </div>
        <div class="column">
            <div class="input-box">
                <div id="inputFields" aria-required="true"></div>
                
            </div>
        </div>
        <button class="button" >Next Page</button>
    </form>
    
</section>

</body>
</html>
