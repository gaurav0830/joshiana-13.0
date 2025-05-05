<?php
session_start();
include "config/db.php"; // Include database connection settings

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api_key = 'rzp_test_lxMG7yWdmE65oc'; // Your Razorpay API key
$api_secret = 'N9eDF85LigyRWIOOU2AwHJbr'; // Your Razorpay API secret




if (isset($_GET['payment_id']) && isset($_GET['order_id']) && isset($_GET['signature'])) {
    $payment_id = $_GET['payment_id'];
    $order_id = $_GET['order_id'];
    $signature = $_GET['signature'];

    $api = new Api($api_key, $api_secret);

    try {
        // Verify the payment signature
        $attributes = [
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ];
        $api->utility->verifyPaymentSignature($attributes);

        // Insert main event registration data
        $stmt = $mysqli->prepare("
            INSERT INTO events (college, email, phone1, phone2,degree, department, order_id, payment_id, total_amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'ssssssssi',
            $_SESSION['college'],
            $_SESSION['email'],
            $_SESSION['phone1'],
            $_SESSION['phone2'],
            $_SESSION['degree'],
            $_SESSION['department'],
            $order_id,
            $payment_id,
            $_SESSION['total_amount']
        );
        $stmt->execute();

        // Insert event details
        $stmt = $mysqli->prepare("
            INSERT INTO event_details (order_id, event_name, participants) 
            VALUES (?, ?, ?)
        ");
        foreach ($_SESSION['events'] as $event) {
            $participants = implode(',', $event['participants']); // Convert array to comma-separated string
            $stmt->bind_param('sss', $order_id, $event['event'], $participants);
            $stmt->execute();
        }

        // Clear session data
        unset($_SESSION['events']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['order_id']);
    } catch (\Exception $e) {
        // Log or handle the error appropriately
        echo "Payment verification failed: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        .icon {
            color: #4caf50;
            font-size: 60px;
            margin-bottom: 20px;
        }
        h1 {
            color: #4caf50;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
        .button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction was successful.</p>
        <a href="index.html" class="button">Back to Home</a>
    </div>
</body>
</html>
