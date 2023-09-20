<?php
function isLatinOrCyrillic($char) {
    return (preg_match('/^\p{L}/u', $char) || preg_match('/^[\p{Cyrillic}]+$/u', $char) || preg_match('/^\p{N}/u', $char) || $char === '_' || $char === '-');
}
if(!empty($_POST)){
    $login = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if(!isset($login) || isset($email) || isset($password) || isset($confirmPassword)){
        header("Location: http://localhost/php-website/views/index.php?action=registration_unsuccesful");
    }
}

?>

<head>
    <link href="../css/login.css" type="text/css" rel="stylesheet">
</head>
<div class="cont">
    <form action="index.php?action=registration" method="POST" class="form sign-in">
        <h2>Welcome</h2>
        <label>
            <span>Email</span>
            <input type="email" />
        </label>
        <label>
            <span>Password</span>
            <input type="password" />
        </label>
        <p class="forgot-pass">Forgot password?</p>
        <button type="submit" class="submit">Sign In</button>

    </form>
    <div class="sub-cont">
        <div class="img">
            <div class="img__text m--up">

                <h3>Don't have an account? Please Sign up!<h3>
            </div>
            <div class="img__text m--in">
                <h3>If you already has an account, just sign in.<h3>
            </div>
            <div class="img__btn">
                <span class="m--up">Sign Up</span>
                <span class="m--in">Sign In</span>
            </div>
        </div>
        <form action="index.php?action=registration" method="POST" class="form sign-up">
            <h2>Create your Account</h2>
            <label>
                <span>Name</span>
                <input name="login" type="text" />
            </label>
            <label>
                <span>Email</span>
                <input name="email" type="email" />
            </label>
            <label>
                <span>Phone number</span>
                <input name="phone" type="text" />
            </label>
            <label>
                <span>Password</span>
                <input name="password" type="password" />
            </label>
            <label>
                <span>Confirm Password</span>
                <input name="confirmPassword" type="password" />
            </label>
            <button type="submit" class="submit">Sign Up</button>

        </form>
    </div>
</div>

<script>
    document.querySelector('.img__btn').addEventListener('click', function() {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>