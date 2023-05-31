<?php
include("dataconnection.php"); 

session_start();

//To remove the error message when user isn't logged in but try to access the page
//error_reporting(E_ERROR | E_PARSE);

$user_email = $_SESSION['user_email'];
$result = mysqli_query($connect,"SELECT * FROM users WHERE user_email = '$user_email'");
$row=mysqli_fetch_assoc($result);

if(!isset($_SESSION['user_email'] ))
{
	?>
        <script type="text/javascript">
            alert("Please log in!");
            window.location.href='customer_signup&login.php';
        </script>
        <?php
        exit;
}

// Retrieve the total price from the session
$totalPrice = $_SESSION['total_price'];

// Set default values for the billing address fields
$receiver_name = "";
$email = "";
$phone = "";
$receiver_address = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the checkbox is checked
  if (isset($_POST['sameadr'])) {
      // If checked, populate the billing address fields with user information
      $receiver_name = $row['user_name'];
      $email = $row['user_email'];
      $phone = $row['user_phonenumber'];
      $receiver_address = $row['user_address'];
  } else {
      // If not checked, retrieve the values from the form submission
      $receiver_name = $_POST['receivername'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $receiver_address = $_POST['address'];
  }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_payment.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewreport" content="width=devive-width, initial-scale=1.0">
</head>

<body>

<!-- Navbar -->
<nav>
    <ul>
         <li><a href="customer_dashboard.php">Home</a></li>
         <li><a href="customer_menu.php">Menu</a></li>
         <li><a href="customer_account.php">My Account</a></li>
         
         <li class="logo" style="position: absolute; left: 50%; transform: translateX(-50%);"><a href="customer_dashboard.php">Vanilla Café</a></li>
 
         <li style="float:right"><a href="customer_logout.php" span class="material-symbols-outlined" style="font-size: 35px; padding-right:60px;">Logout</span></a></li>
         <li style="float:right"><a href="customer_shoppingcart.php" span class="material-symbols-outlined" style="font-size: 35px;">shopping_cart</span></a></li>
           
    </ul>
 </nav>
<!-- end of Navbar -->

<main>
  <form method="POST" onsubmit="return validateForm()">

    <div class="row">
      <div class="col-75">
        
          <div class="row">
            <div class="col-50">

              <h3>Billing Address</h3>

              <label for="fname">Receiver Name</label>
              <input type="text" id="rname" name="receivername" value="<?php echo $receiver_name; ?>" required>

              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="<?php echo $email; ?>" required>

              <label for="phone">Phone Number</label>
              <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

              <label for="adr">Receiver Address</label>
              <textarea id="adr" name="address" required><?php echo $receiver_address; ?></textarea>

            </div><!--end of col-50-->

            <div class="col-50">

              <h3>Payment</h3>

              <label for="fname">Accepted Cards</label>          
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-mastercard" style="color:black;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>            
              </div>

              <label for="cname">Name on Card</label>
              <input type="text" id="cname" name="cardname" oninput="convertToUpperCase()" required>

              <label for="ccnum">Credit/Debit card number</label>
              <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" maxlength="19" oninput="formatCardNumber()" onkeypress="return isNumberKey(event)"required>

              <label for="cvv">CVV</label>
              <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3" onkeypress="return isNumberKey(event)" required> 

              <label for="exp">Expiration date (MM/YY)</label>
              <input type="text" id="exp" name="exp" placeholder="MM/YY" maxlength="5" oninput="formatExpirationDate()" required>

            </div><!--end of col-50-->

          </div><!--end of row-->
  
      <div class="col-65">
        
        <label>
          <input type="checkbox" id="sameadr" name="sameadr"> Information in billing address same as user profile
        </label>

        <!--Submit button-->
        <input type="submit" name="payment" value="SUBMIT PAYMENT" class="btn">

      </div><!--end of col-65-->
    
  </div><!--end of col-75-->


  <div class="col-25">
    <div class="container2">
        <div class="total-label">Grand Total</div>
        <div class="total-amount">RM <?php echo number_format($totalPrice, 2); ?></div>
    </div>
  </div><!--end of col-25-->

</div><!--end of row-->

</form>
</main>

<footer>
    <p class="footer-content">All Rights Reserved © 2023 by Vanilla Café</p>
</footer>


<script>
        $(document).ready(function () {
            // Function to handle checkbox change event
            $('#sameadr').change(function () {
                if ($(this).is(":checked")) {
                    // Populate the billing address fields with user information
                    $('#rname').val('<?php echo $row['user_name']; ?>');
                    $('#email').val('<?php echo $row['user_email']; ?>');
                    $('#phone').val('<?php echo $row['user_phonenumber']; ?>');
                    $('#adr').val('<?php echo $row['user_address']; ?>');
                } else {
                    // Clear the billing address fields
                    $('#rname').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#adr').val('');
                }
            });  
        });
</script>

<script>
    function convertToUpperCase() {
        var input = document.getElementById("cname");
        input.value = input.value.toUpperCase();
    }

    function formatCardNumber() {
        var input = document.getElementById("ccnum");
        var trimmed = input.value.replace(/\s+/g, '');
        var split = [];
        for (var i = 0; i < trimmed.length; i += 4) {
            split.push(trimmed.substr(i, 4));
        }
        input.value = split.join(' ');
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function formatExpirationDate() {
      document.getElementById('exp').addEventListener('input', function (event) {
        var input = event.target;
        var trimmedValue = input.value.replace(/\//g, ''); // Remove existing slashes
        var formattedValue = trimmedValue.replace(/(\d{2}(?=\d))/g, '$1/'); // Add slash after two digits
        input.value = formattedValue;
      });
    }

    function validateForm() {
        var cardNumberInput = document.getElementById("ccnum");
        var cardNumber = cardNumberInput.value.replace(/\s+/g, '');

        var cardType = '';
        if (cardNumber.match(/^4[0-9]{12}(?:[0-9]{3})?$/)) {
            cardType = 'Visa';
        } else if (cardNumber.match(/^5[1-5][0-9]{14}$/)) {
            cardType = 'Mastercard';
        } else if (cardNumber.match(/^3[47][0-9]{13}$/)) {
            cardType = 'American Express';
        }

        if (cardType === '') {
            Swal.fire({
              title: 'Invalid Card Number',
              text: 'Please enter a valid Visa, Mastercard, or American Express card number.',
              icon: 'error',
              customClass: {
                container: 'custom-swal-font'
              }
            });
            cardNumberInput.focus();
            return false;
        }

        var currentDate = new Date();
        var currentYear = currentDate.getFullYear() % 100;
        var currentMonth = currentDate.getMonth() + 1;

        var expirationDateInput = document.getElementById("exp");
        var expirationDate = expirationDateInput.value.split('/');
        var expMonth = parseInt(expirationDate[0]);
        var expYear = parseInt(expirationDate[1]);

        if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
            Swal.fire({
              title: 'Invalid Expiration Date',
              text: 'Please enter a valid expiration date.',
              icon: 'error',
              customClass: {
                container: 'custom-swal-font'
              }
            });
            expirationDateInput.focus();
            return false;
        }

        return true;
    }
</script>

</body>
</html>


<!--SUBMIT PAYMENT UPDATE DATABASE-->
<?php
// Retrieve the user details from the $row array
$receiverName = $_POST['receivername'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$receiverAddress = $_POST['address'] ?? '';

if (isset($_POST['payment'])) {
  // Retrieve the total price from the session
  $totalPrice = $_SESSION['total_price'];

  // Generate the order number, date/time format "YYYYMMDDHHMMSS"
  date_default_timezone_set('Asia/Kuala_Lumpur');
  $orderNumber = 'PO' . date('YmdHis') . $row['user_id'];

  // Insert data into the orders table
  $query = "INSERT INTO orders (order_number, user_id, order_totalprice, order_receiver_name, order_receiver_email, order_receiver_phone, order_receiver_address, order_date, order_status) 
                VALUES ('$orderNumber', {$row['user_id']}, $totalPrice, '{$receiverName}', '{$email}', '{$phone}', '{$receiverAddress}', NOW(), 1)";
  mysqli_query($connect, $query);

  // Retrieve the last inserted order ID
  $orderID = mysqli_insert_id($connect);

  // Update the cart status and order ID in the shopping_cart table if order_id is NULL
  $query = "UPDATE shopping_cart SET cart_status = 2, order_id = $orderID WHERE user_id = {$row['user_id']} AND order_id IS NULL";
  mysqli_query($connect, $query);

  // Check and update the user address
  if (empty($row['user_address'])) {
      $query = "UPDATE users SET user_address = '{$receiverAddress}' WHERE user_id = {$row['user_id']}";
      mysqli_query($connect, $query);
  }

  // Show an alert after successful submission
  ?>
  <script>
    Swal.fire({
        title: 'Processing...',
        icon: 'info',
        customClass: {
          container: 'custom-swal-font'
        },
        showConfirmButton: false, // Hide the default "OK" button
        allowOutsideClick: false, // Prevent clicking outside the dialog
        timer: 3000,
      }).then(function() {
        window.location.href = "customer_orderConfirm.php";
    });

  </script>

  <?php
}
?>