<!DOCTYPE html>
<?php
$mysqli = new mysqli("localhost","kmp","Max6112073","tourfirm");
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: /php-website/index.php?action=main");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["login"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["login"]);
    }

    if(empty(trim($_POST["loginPassword"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["loginPassword"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT user_id, user_login, user_password, admin FROM users WHERE user_login = ?";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);

            $param_username = $username;

            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $stmt->bind_result($id, $username, $hashed_password, $admin);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["login"] = $username;
                            $_SESSION["admin"] = $admin;

                            header("Location: /php-website/index.php?action=main");
                        } else{
                            $login_err = "Неправильний логін або пароль!";
                        }
                    }
                } else{
                    $login_err = "Неправильний логін або пароль!";
                }
            } else{
                echo "Щось пішло не так.";
            }

            $stmt->close();
        }
    }

    $mysqli->close();
}
?>

<head>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <a href="index.php?action=main"><div class="out">&#10005;</div></a>
            <img src="img/frontImg.jpg" alt="">
            <div class="text">
                <span class="text-1">Every new friend is a <br> new adventure</span>
                <span class="text-2">Let's get connected</span>
            </div>
        </div>
        <div class="back">
            <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
            <div class="text">
                <span class="text-1">Complete miles of journey <br> with one step</span>
                <span class="text-2">Let's get started</span>
            </div>
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Авторизація</div>
                <form action="index.php?action=login" method="post">
                    <div class="error"><?=$login_err?></div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="login" placeholder="Enter your login">
                        </div>
                        <div class="error"><?=$username_err?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="loginPassword" placeholder="Enter your password">
                        </div>
                        <div class="error"><?=$password_err?></div>
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