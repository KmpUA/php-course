<!DOCTYPE html>
<?php
$nameErr = $emailErr = $mobilenoErr = $passwordErr = $passwordcErr = "";
$name = $email = $mobileno = $signupEmail = $signupPsw = $signupPswc = "";
$validated = true;

function input_data(mixed $signupLogin): string
{
    $signupLogin = trim($signupLogin);
    $signupLogin = stripcslashes($signupLogin);
    return htmlspecialchars($signupLogin);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["signupLogin"])){
        $nameErr = "Ви повинні ввести логін!";
        $validated = false;
    } else{
        $name = input_data($_POST["signupLogin"]);
        if(!preg_match("/^[а-яА-Яa-zA-Z0-9_-]{4,}$/", $name)){
            $nameErr = "Не менше 4 кириличних або латинських літер!";
            $validated = false;
        }
    }
    if(empty($_POST["signupEmail"])){
        $emailErr = "Ви повинні ввести email!";
        $validated = false;
    } else{
        $signupEmail = input_data($_POST["signupEmail"]);
        if(!filter_var($signupEmail, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Неправильно введений email!";
            $validated = false;
        }
    }
    if (empty($_POST["phoneNumber"])) {
        $mobilenoErr = "Не введений номер телефону!";
        $validated = false;
    } else {
        $mobileno = input_data($_POST["phoneNumber"]);
        if (!preg_match ("/^[0-9]*$/", $mobileno) ) {
            $mobilenoErr = "Можуть бути тільки числа!";
            $validated = false;
        }
        if (strlen ($mobileno) != 10) {
            $mobilenoErr = "Номер телефону повинен містити 10 цифр";
            $validated = false;
        }
    }
    if(empty($_POST["signupPsw"])){
        $passwordErr = "Ви повинні вести пароль!";
        $validated = false;
    } else{
        $signupPsw = input_data($_POST["signupPsw"]);
        if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9]{7,}$/", $signupPsw)){
            $passwordErr = "Пароль повинен містити не менше 7 літер, великі та малі літери, а також цифри!";
            $validated = false;
        }
    }
    if(empty($_POST["signupPswc"])){
        $passwordcErr = "Введіть пароль для підтвердження!";
        $validated = false;
    } else{
        $signupPswc = input_data($_POST["signupPswc"]);
        if($signupPswc != $signupPsw){
            $passwordcErr = "Паролі не співпадають!";
            $validated = false;
        }
    }
    if($validated){
        header("Location:/php-website/index.php?action=registration_succesful");
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
                <form action="index.php?action=registration">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" placeholder="Enter your email">
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Enter your password">
                        </div>
                        <div class="text"><a href="#">Забули пароль</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Sumbit">
                        </div>
                        <div class="text sign-up-text">Немає аккаунту? <label for="flip">Зареєструватися</label></div>
                    </div>
                </form>
            </div>
            <div class="signup-form">
                <div class="title">Реєстрація</div>
                <form action="index.php?action=registration" method="post">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="signupLogin" placeholder="Enter your name">
                        </div>
                        <div class="error"><?=$nameErr?></div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="signupEmail" placeholder="Enter your email">
                        </div>
                        <div class="error"><?=$emailErr?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="signupPsw" placeholder="Enter your password">
                        </div>
                        <div class="error"><?=$passwordErr?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="signupPswc" placeholder="Enter password confirmation">
                        </div>
                        <div class="error"><?=$passwordcErr?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="tel" name="phoneNumber" placeholder="Enter your phonenumber">
                        </div>
                        <div class="error"><?=$mobilenoErr?></div>
                        <div class="button input-box">
                            <input type="submit" value="Зареєструватися">
                        </div>
                        <div class="text sign-up-text">Вже є аккаунт? <label for="flip">Авторизуватися</label></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>