<?php 
include("dataconnection.php"); 


session_start();
unset($_SESSION["email"]);
unset($_SESSION["password"]);

?>

<script type="text/javascript">
	alert("You have successfully logout!");
    window.location.href='index.php';
</script>


