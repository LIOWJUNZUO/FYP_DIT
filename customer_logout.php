<?php 
session_start();
session_unset();
session_destroy();
?>

<script type="text/javascript">
	alert("You have successfully logged out!");
    window.location.href='customer_signup&login.php';
</script>
