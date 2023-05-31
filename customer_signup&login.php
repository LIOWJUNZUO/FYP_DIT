<?php 
    include("dataconnection.php"); 
    session_start();

    if (isset($_POST['login'])) 
    {
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        // Escaping special characters in the user's email and password to prevent SQL injection attacks
        $user_email = mysqli_real_escape_string($connect,$user_email);
        $user_password = mysqli_real_escape_string($connect,$user_password);

        $result = mysqli_query($connect,"SELECT * from users where user_email= '$user_email' and user_password= '$user_password'" );
        $count = mysqli_num_rows($result);
            
        if ($count == 1)
        {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user_email;
            ?>
                <script>
                    window.location.href='customer_dashboard.php';
                </script>
            <?php
        }
        
        else
        {
        
            ?>
                <script type="text/javascript">
                    alert("Incorrect email or password!");
                    window.location.href='customer_signup&login.php';
                </script>
            <?php
        }
        mysqli_close($connect);

    }//end of login
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Account - Vanilla Cafe</title>
    <link rel = "icon" href="images/logo.jpg" type = "image/x-icon">
    <link rel="stylesheet" href="css/customer_signup&login.css">
    <meta name="viewreport" content="width=devive-width, initial-scale=1.0">
</head>

<body>

    <div class="wrapper">
            
        <div class="title-text">
            
            <div class="title login">
                Login
            </div>

            <div class="title signup">
                Register
            </div>
        </div>

        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>

<!--===========================================================================================================================================-->
<!-- Login form -->

            <div class="form-inner">
                <form id="login" action="" class="login" method="POST">
                    
                   <div class="field">
                        <input type="email" placeholder="Email" id="email" name="user_email" required>
                    </div>
                    
                    <div class="field">
                        <input type="password" class="lpassword" placeholder="Password" name="user_password" required>
                    </div>

                   <!-- <div class="pass-link">
                        <a href="customer_forgotpassword.html">Forgot password?</a>
                    </div>-->

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Login" name="login" class="btn-login"> 
                    </div>

                    <div class="signup-link">
                        Not a member? <a herf="">Create an account</a>
                    </div>
                </form>
<!--===========================================================================================================================================-->
<!-- Sign up form -->

                <form action="#" class="signup" method="POST">
                <div class="field">
                       <input type="username" placeholder="Username" id="username" name="user_name" required>
                    </div>
                    <div class="field">
                       <input type="email" placeholder="Email" id="email" name="user_email" required>
                    </div>
                    <div class="field">
                       <input type="password" placeholder="Password" name="user_password" id="password" required>
                    </div>
                    <div class="field">
                       <input type="password" placeholder="Confirm password" name="cpassword" required>
                    </div>
                    <div class="ps">
                        <div id="password-strength"></div>
                    </div>
                    <div class="field">
                       <input type="phone" placeholder="Phone Number" name="user_phonenumber" required>
                    </div>
                    
                    <div class="field btn">
                       <div class="btn-layer"></div>
                       <input type="submit" name="signup" value="Signup">
                    </div>
                 </form>

            </div>

        </div>

    </div>
   
    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");

        signupBtn.onclick = (()=>{
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        });

        loginBtn.onclick = (()=>{
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        });

        signupLink.onclick = (()=>{
            signupBtn.click();
            return false;
        });
    </script>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordStrengthIndicator = document.getElementById('password-strength');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const isStrong = checkPasswordStrength(password);

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

<!--===========================================================================================================================================-->
<!-- Sign up form -->

<?php 

    if(isset($_POST['signup']))
    {
        $user_name = $_POST["user_name"];
        $user_email = $_POST["user_email"];
        $user_password = $_POST["user_password"];
        $user_phonenumber = $_POST["user_phonenumber"];

        // Escaping special characters in the user's email and password to prevent SQL injection attacks
        $user_email = mysqli_real_escape_string($connect,$user_email);
        $user_password = mysqli_real_escape_string($connect,$user_password);
        
        //check if the email already exists in the table
        $result = mysqli_query($connect,"SELECT * from users where user_email= '$user_email'" );
        $count=mysqli_num_rows($result);
        

        // check if the password and confirm password fields match
        if ($_POST['user_password'] != $_POST['cpassword']) 
        {
?>

<script type="text/javascript">
    alert("Password and confirm password fields do not match.");
    window.location.href='customer_signup&login.php';
</script>

<?php
            exit(); //exit the script to prevent further execution    
        }
        
        if (!checkPasswordStrength($user_password)) 
        {

    
?>

<script type="text/javascript">
    alert("Password must be at least 8 characters long and contain at least one uppercase and one lowercase letter.");
    window.location.href='customer_signup&login.php';
</script>
 
<?php
            exit();
        } 

        //check if the phone number is in the correct format
        $phone_regex = "/^01\d{8}$|^01\d{9}$/";
        if (!preg_match($phone_regex, $user_phonenumber))
        {
?>

<script type="text/javascript">
    alert("Please enter a valid phone number in the format 01XXXXXXXX");
    window.location.href='customer_signup&login.php';
</script>

<?php
            exit();
        } 
        
        if($count == 0)               
        {
            //insert the user into the table
            mysqli_query($connect,"INSERT INTO users (user_name, user_email, user_password, user_phonenumber) 
                        VALUES('$user_name', '$user_email', '$user_password', '$user_phonenumber')");
		             
?>

<script>
    alert("<?php echo 'Register Successfully, Please Login Now!'; ?> ")
</script>
        
<?php
        } 
        else 
        {
?>

<script type="text/javascript">
    alert("This email is already registered. Please try another email.");
    window.location.href='customer_signup&login.php';
</script>

<?php
        }             
}//end of signup
?>

<!--===========================================================================================================================================-->

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
