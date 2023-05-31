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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account | Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/customer_account.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
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

<h1>My Account</h1>

<div class="row">
  <form method="POST" action="">
    <table>
      <tr>
            <td class="left">
            <p>
                <label for="user_name">Name:</label>
                <br>
                <input type="text" id="user_name" name="user_name" value="<?php echo $row['user_name']; ?>" required>
            </p>

            <p>
                <label for="user_email">Email:</label>
                <br>
                <input type="email" id="user_email" name="user_email" value="<?php echo $row['user_email']; ?>" readonly>
            </p>

            <p>
                <label for="user_phonenumber">Phone Number:</label>
                <br>
                <input type="text" id="user_phonenumber" name="user_phonenumber" value="<?php echo $row['user_phonenumber']; ?>" required>
            </p>

            <p>
                <label for="user_address">Address:</label>
                <br>
                <textarea type="address" id="user_address" name="user_address" required><?php echo $row['user_address']; ?></textarea>
            </p>
            </td>
        
            <td class="right">
            <p>
                <label for="user_password">New Password:</label>
                <br>
                <input type="password" id="user_password" name="user_password" value="">
                <div class="ps">
                <div id="password-strength"></div>
                </div>
            </p>

            <p>
                <label for="confirm_password">Confirm Password:</label>
                <br>
                <input type="password" class="psw" id="confirm_password" name="confirm_password" value="">
            </p>
            </td>
      </tr>

      <tr>
        <td colspan="2" class="button-row">
          <input type="submit" name="update_profile" value="Update Profile" class="btn">
        </td>
      </tr>

    </table>
  </form>
</div>



<div>
    <p style="float: right;">
        <a class="history" href="customer_orderHistory.php">View Order History</a>
    </p>
</div>

</main>

<footer>
    <p>All Rights Reserved © 2023 by Vanilla Café</p>
</footer>


<script>
    const userEmailInput = document.getElementById('user_email');
    
    userEmailInput.addEventListener('click', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Contact Admin',
            text: 'If you want to change your email, please contact the administrator.',
            customClass: {
                container: 'custom-swal-font'
            }
        });
    });
</script>

<script>
    const passwordInput = document.getElementById('user_password');
    const passwordStrengthIndicator = document.getElementById('password-strength');

    passwordInput.addEventListener('input', function() {
        const user_password = passwordInput.value;
        const isStrong = checkPasswordStrength(user_password);

        // Update the strength indicator text and border color based on password strength
        if (isStrong) {
            passwordStrengthIndicator.textContent = 'Strong Password';
            passwordInput.classList.remove('weak');
            passwordInput.classList.add('strong');
        } else {
            passwordStrengthIndicator.textContent = 'Weak Password';
            passwordInput.classList.remove('strong');
            passwordInput.classList.add('weak');
        }
    });

    function checkPasswordStrength(password) {
        if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password)) {
            return false;
        }

        return true;
    }
</script>

</body>
</html>


<?php
// Update user profile and password
if (isset($_POST['update_profile'])) {
    $user_name = $_POST['user_name'];
    $user_phonenumber = $_POST['user_phonenumber'];
    $user_address = $_POST['user_address'];

    $phone_regex = "/^01\d{8}$|^01\d{9}$/";
    if (!preg_match($phone_regex, $user_phonenumber)) {
        ?>
        <script>
            Swal.fire({
                title: "Invalid Phone Number",
                text: "Please enter a valid phone number in the format 01XXXXXXXX",
                icon: "error",
                confirmButtonText: "OK",
                customClass: {
                    container: 'custom-swal-font'
                }
            }).then(function () {
                window.location.href = 'customer_account.php';
            });
        </script>
        <?php
        exit(); // Exit the script to prevent further execution
    }

    // Update the user profile in the database
    mysqli_query($connect, "UPDATE users SET user_name = '$user_name', user_phonenumber = '$user_phonenumber', user_address = '$user_address' WHERE user_email = '$user_email'");

    // Check if the password fields are not empty
    if (!empty($_POST['user_password']) && !empty($_POST['confirm_password'])) {
        $user_password = $_POST['user_password'];
        $confirm_password = $_POST['confirm_password'];

        $user_password = mysqli_real_escape_string($connect, $user_password);

        // Verify password
        if ($user_password !== $confirm_password) {
            ?>
            <script>
                Swal.fire({
                    title: "Password and confirm password do not match.",
                    icon: "error",
                    confirmButtonText: "OK",
                    customClass: {
                        container: 'custom-swal-font'
                    }
                }).then(function () {
                    window.location.href = 'customer_account.php';
                });
            </script>
            <?php
            exit(); // Exit the script to prevent further execution
        } elseif (!checkPasswordStrength($user_password)) {
            ?>
            <script>
                Swal.fire({
                    title: "Password does not meet the requirements.",
                    text: "Password must be at least 8 characters long and contain at least one uppercase and one lowercase letter.",
                    icon: "error",
                    confirmButtonText: "OK",
                    customClass: {
                        container: 'custom-swal-font'
                    }
                }).then(function () {
                    window.location.href = 'customer_account.php';
                });
            </script>
            <?php
            exit();
        } else {
            // Update the user password in the database
            mysqli_query($connect, "UPDATE users SET user_password = '$user_password' WHERE user_email = '$user_email'");
        }
    } elseif (!empty($_POST['user_password']) || !empty($_POST['confirm_password'])) {
        ?>
        <script>
            Swal.fire({
                title: "Password and confirm password do not match.",
                icon: "error",
                confirmButtonText: "OK",
                customClass: {
                    container: 'custom-swal-font'
                }
            }).then(function () {
                window.location.href = 'customer_account.php';
            });
        </script>
        <?php
        exit(); // Exit the script to prevent further execution
}

?>
<script>
    Swal.fire({
        title: "Success",
        text: "User profile has been updated successfully",
        icon: "success",
        confirmButtonText: "OK",
        customClass: {
            container: 'custom-swal-font'
        }
    }).then(function () {
        window.location.href = 'customer_account.php';
    });
</script>
<?php
exit();

}
?>

<?php
function checkPasswordStrength($user_password) {
    // Check if password is at least 8 characters long
    if (strlen($user_password) < 8) {
        return false;
    }

    // Check if password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $user_password)) {
        return false;
    }

    // Check if password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $user_password)) {
        return false;
    }

    // Password meets all requirements
    return true;
}
?>