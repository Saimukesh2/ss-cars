<?php  
session_start();
include_once("common/config.php");
include_once("common/dbconn.php");
require_once('common/common_functions.php');
require_once('data/daManageSession.php');
require_once('data/daManageLogin.php');

$msg="";

$login="";
$pwd="";
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
if($msg != '')
{
    $message = getMessage($msg); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SS-Cars</title>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Sweet Alert for validations -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <script type="text/javascript">  
        (function () {  
            'use strict';  
            window.addEventListener('load', function () {  
                var form = document.getElementById('frmLogin');  
                form.addEventListener('submit', function (event) {  
                    if (form.checkValidity() === false) {  
                        event.preventDefault();  
                        event.stopPropagation();  
                    }  
                    form.classList.add('was-validated');  
                }, false);  
            }, false);  
        })();  
    </script> 
</head>
<body class="hold-transition ss-login-page">
    <main class="ss-login-shell">
        <section class="ss-login-visual" aria-label="SS-Cars premium automotive services">
            <div class="ss-brand-mark">SS<span>-CARS</span></div>
            <div class="ss-hero-car"></div>
            <div class="ss-photo-stack" aria-hidden="true">
                <div class="ss-stack-photo ss-stack-photo-top"></div>
                <div class="ss-stack-photo ss-stack-photo-middle"></div>
                <div class="ss-stack-photo ss-stack-photo-bottom"></div>
            </div>
        </section>

        <section class="ss-login-panel">
            <div class="ss-login-box">
                <?php if($msg != '') { ?>
                    <div class="alert alert-warning alert-dismissible ss-login-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fas fa-info"></i><?php echo $message; ?>
                    </div>
                <?php } ?>

                <div class="ss-login-card">
                    <div class="ss-login-heading">
                        <h1>Welcome <span>Back</span></h1>
                        <p>Sign in to your account</p>
                    </div>
                    <form id="frmLogin" name="frmLogin" method="post" action="checkLogin.php" novalidate>
                        <div class="ss-input-wrap">
                            <i class="far fa-user"></i>
                            <input type="text" name="txtUserID" id="txtUserID" placeholder="Login ID" required>
                        </div>
                        <div class="ss-input-wrap">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="txtPassword" id="txtPassword" autocomplete="off" placeholder="Password" required>
                            <button type="button" class="ss-password-toggle" aria-label="Show password"><i class="far fa-eye-slash"></i></button>
                        </div>
                        <button type="submit" id="btnSignin" class="ss-signin-button">Sign In <i class="fas fa-arrow-right"></i></button>
                    </form>
                    <a class="ss-forgot-link" href="forgot_password.php">Forgot your password?</a>
                </div>
            </div>
        </section>
    </main>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.ss-password-toggle').on('click', function() {
                var password = $('#txtPassword');
                var isPassword = password.attr('type') === 'password';
                password.attr('type', isPassword ? 'text' : 'password');
                $(this).attr('aria-label', isPassword ? 'Hide password' : 'Show password');
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            // Validate the login form
            $('#frmLogin').validate({
                rules: {
                    txtUserID: {
                        required: true,
                        minlength: 5,
                        maxlength: 15,
                        alphanumeric: true //
                    },
                    txtPassword: {
                        required: true,
                        minlength: 6 // Example minimum length requirement
                    },

                },
                messages: {
                    txtUserID: {
                        required: "Please enter your username",
                        minlength: "Your username must be at least 5 characters long",
                        maxlength: "Username cannot exceed 15 characters long",
                        alphanumeric: "Please enter only alphanumeric characters"
                    },
                    txtPassword: {
                        required: "Please enter your password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9_]+$/.test(value);
            }, "User ID can only contain letters, numbers, and underscores.");

        });
    </script>
</body>
</html>
