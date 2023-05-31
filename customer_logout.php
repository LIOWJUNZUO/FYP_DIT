<!DOCTYPE html>
<html>
<head>
    <title>Logout | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .custom-swal-font {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>
<body>

<?php
session_start();
session_unset();
session_destroy();
?>

<script>
    const timerInterval = 1000; // Set the interval for the countdown timer (in milliseconds)
    let countdown = 3; // Set the initial countdown value

    Swal.fire({
        title: "You have successfully logged out!",
        html: "Redirecting in <strong id='countdown-timer'>3</strong> seconds...",
        icon: "success",
        customClass: {
            container: 'custom-swal-font'
        },
        timer: countdown * 1000, // Set the total timer duration in milliseconds
        timerProgressBar: true,
        showConfirmButton: false,
        willClose: () => {
            window.location.href = 'customer_signup&login.php';
        }
    });

    const countdownTimer = setInterval(() => {
        countdown--;
        document.getElementById('countdown-timer').textContent = countdown;

        if (countdown === 0) {
            clearInterval(countdownTimer);
        }
    }, timerInterval);
</script>


</body>
</html>
