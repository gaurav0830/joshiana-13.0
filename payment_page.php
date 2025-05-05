<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_amount'])) {
    header("Location: reg_page1.php"); // Redirect if no order ID or amount is set
    exit();
}

// $api_key = 'rzp_test_lxMG7yWdmE65oc';
$order_id = $_SESSION['order_id'];
$total_amount = $_SESSION['total_amount'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment</title>
</head>
<body>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "<?php echo $api_key; ?>", 
            "amount": "<?php echo $total_amount * 100; ?>", 
            "currency": "INR",
            "name": "Event Registration",
            "description": "Payment for event registration",
            "order_id": "<?php echo $order_id; ?>",
            "handler": function (response) {
                window.location.href = "verify.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id + "&signature=" + response.razorpay_signature;
            },
            "prefill": {
                "name": "<?php echo htmlspecialchars($_SESSION['college']); ?>",
                "email": "<?php echo htmlspecialchars($_SESSION['email']); ?>",
                "contact": "<?php echo htmlspecialchars($_SESSION['phone1']); ?>"
            },
            "modal": {
                    "ondismiss": function() {
                        window.location.href = "reg_page1.php";
                    }
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    </script>
</body>
</html>
