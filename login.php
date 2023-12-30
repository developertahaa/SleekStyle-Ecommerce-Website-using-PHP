<?php
session_start(); // Start the session

include 'dbcon.php';
$alertClass = isset($_GET['alertClass']) ? $_GET['alertClass'] : "";
$alertMessage = isset($_GET['alertMessage']) ? $_GET['alertMessage'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Handle login form submission
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("location: shop.php");
            exit();
        } else {
            $alertClass = "alert-danger";
            $alertMessage = "Invalid Login and Password.";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup </title>
    <link rel="stylesheet" href="css/login-style.css">
    
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<style>
    .alert-danger{
        margin-left: 3px;
        margin-top: 5px;
        background-color: red;
        padding: 12px;
        border-radius: 2px;
        color: white;  
        font-size: 16px;
        opacity: 1; /* Initial opacity */
        transition: opacity 0.5s ease; /* Transition for smooth fade */
    }

    /* Animation to fade out the alert */
    @keyframes fadeOut {
        to {
            opacity: 0;
        }
    }
    .container {
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 30px;
    background-color: #f5f5f5 !important; /* Change to dull white */
}

.form {
    position: absolute;
    max-width: 430px;
    width: 100%;
    padding: 30px;
    border-radius: 6px;
    background: #f5f5f5; /* Change to dull white */
}
    .alert-success{
        margin-left: 3px;
        margin-top: 5px;
        background-color: #2ABD2A;
        padding: 12px;
        border-radius: 2px;
        color: white;  
        font-size: 16px;
        opacity: 1; /* Initial opacity */
        transition: opacity 0.5s ease; 
    }

        .signup {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }

        .form-control {
            margin-bottom: 15px;
        }

        #emailStatus, #passwordStrength {
            font-size: 14px;
            margin-top: 5px;
        }

        #submitBtn {
            background-color: #007bff;
            color: #ffffff;
        }

        #submitBtn:disabled {
            background-color: #ced4da;
        }
</style>
</head>
<body>



<section class="container forms">
    <!-- Login Form -->
    <div class="form login">
    
        <div class="form-content">
            <header>Login</header>
            <?php if (!empty($alertClass) && !empty($alertMessage)): ?>
    <div class="alert <?php echo $alertClass; ?> mt-3" role="alert">
        <?php echo $alertMessage; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically remove the alert after 5 seconds
            setTimeout(function () {
                var alertElement = document.querySelector('.alert');
                if (alertElement) {
                    alertElement.style.animation = 'fadeOut 0.5s ease';
                    setTimeout(function () {
                        alertElement.remove();
                    }, 500);
                }
            }, 2000);
        });
    </script>
<?php endif; ?>


            <form action="" method="post">
                <div class="field input-field">
                    <input type="email" name="email" placeholder="Email" class="input">
                </div>
                <div class="field input-field">
                    <input type="password" name="password" placeholder="Password" class="password">
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                <div class="form-link">
                    <a href="#" class="forgot-pass">Forgot password?</a>
                </div>
                <div class="field button-field">
                    <button type="submit" name="login">Login</button>
                </div>
            </form>
            <div class="form-link">
                <span>Don't have an account? <a href="#" class="link signup-link">Register</a></span>
            </div>
        </div>
        <!-- Additional login code here -->
    </div>

    <!-- Signup Form -->
    <div class="container mt-5">
    <div class="form signup">
        <div class="form-content">
            <header>Register</header>
            <form id="registrationForm" action="register.php" method="post" onsubmit="return validateForm()">
                <div class="field input-field">
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control">
                </div>
                <div class="field input-field">
                    <input type="email" name="email" id="email" placeholder="Email" class="form-control" onblur="checkEmail()">
                    <span id="emailStatus"></span>
                </div>
                <div class="field input-field">
                    <input type="number" name="number" placeholder="Phone Number" class="form-control">
                </div>
                <div class="field input-field">
                    <input type="password" name="password" id="password" placeholder="Create password" class="form-control" oninput="checkPassword()">
                    <span id="passwordStrength"></span>
                </div>
                <div class="field input-field">
                    <input type="password" name="confirm_password" placeholder="Confirm password" class="form-control">
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                <div class="field button-field">
                    <button type="submit" name="signup" id="submitBtn" disabled>Register</button>
                </div>
            </form>
            <div class="form-link">
                <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
            </div>
        </div>
    </div>
</div>

        <!-- Additional signup code here -->
    </div>
</section>

<script src="js/login-script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

<script>
    $(document).ready(function () {
        $('#password').on('input', function () {
            var password = $(this).val();
            var result = zxcvbn(password);

            // Show password strength
            $('#passwordStrength').html('<i class="fas fa-lock"></i> Password Strength: ' + result.score + '/4');

            // Enable the submit button if password is strong and meets the criteria
            $('#submitBtn').prop('disabled', !(result.score >= 3 && password.length >= 8));
        });

        $('#email').on('blur', function () {
            var email = $(this).val();

            // Check if email exists (replace this with your actual logic)
            var emailExists = true; // Set to true for testing purposes

            if (emailExists) {
                $('#emailStatus').html('<i class="text-danger fas fa-times-circle"></i> Email already exists');
            } else {
                $('#emailStatus').html('<i class="text-success fas fa-check-circle"></i> Email is available');
            }
        });

        $('.eye-icon').on('click', function () {
            var passwordInput = $('#password');
            var icon = $(this);

            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });
</script>
</body>
</html>
