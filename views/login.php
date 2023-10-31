<!DOCTYPE html>
<?php
global $db;
$db->use_table("users");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: /php-website/index.php?action=main");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["login"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["login"]);
    }

    if (empty(trim($_POST["loginPassword"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["loginPassword"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $users = $db->find("user_login = '$username'");
        if (!empty($users) && password_verify($password, $users[0]['user_password'])) {
            session_start();

            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $users[0]['user_id'];
            $_SESSION["login"] = $users[0]['user_login'];
            $_SESSION["admin"] = $users[0]['admin'];
            $_SESSION["register_date"] = $users[0]['register_time'];

            header("Location: /php-website/index.php?action=main");
        } else {
            $login_err = "Неправильний логін або пароль!";
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <!-- ... (your HTML content) ... -->
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Авторизація</div>
                <form action="index.php?action=login" method="post">
                    <div class="error"><?= $login_err ?></div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="login" placeholder="Enter your login">
                        </div>
                        <div class="error"><?= $username_err ?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="loginPassword" placeholder="Enter your password">
                        </div>
                        <div class="error"><?= $password_err ?></div>
                        <div class="text"><a href="#">Забули пароль</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Авторизуватися">
                        </div>
                        <div class="text sign-up-text">Немає аккаунту? <a href="index.php?action=registration">Зареєструватися</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
