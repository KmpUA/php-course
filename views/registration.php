<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $db;
class User
{
    private string $name;
    private string $email;
    private string $phoneNumber;
    private string $password;

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    function set_name(string $value): void
    {
        $this->name = $value;
    }

    function set_email(string $value): void
    {
        $this->email = $value;
    }

    function set_password(string $value): void
    {
        $this->password = $value;
    }

    function set_phoneNumber(string $value): void
    {
        $this->phoneNumber = $value;
    }
}

$registerUser = new User();
$nameErr = $emailErr = $mobilenoErr = $passwordErr = $passwordcErr = "";
$registerPswc = "";
$validated = true;

function input_data(string $signupLogin): string
{
    $signupLogin = trim($signupLogin);
    $signupLogin = stripslashes($signupLogin);
    return htmlspecialchars($signupLogin);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["signupLogin"])) {
        $nameErr = "Ви повинні ввести логін!";
        $validated = false;
    } else {
        $registerUser->set_name(input_data($_POST["signupLogin"]));
        if (!preg_match("/^[а-яА-Яa-zA-Z0-9_-]{4,}$/", $registerUser->getName())) {
            $nameErr = "Не менше 4 кириличних або латинських літер!";
            $validated = false;
        }
    }
    if (empty($_POST["signupEmail"])) {
        $emailErr = "Ви повинні ввести email!";
        $validated = false;
    } else {
        $registerUser->set_email(input_data($_POST["signupEmail"]));
        if (!filter_var($registerUser->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Неправильно введений email!";
            $validated = false;
        }
    }
    if (empty($_POST["phoneNumber"])) {
        $mobilenoErr = "Не введений номер телефону!";
        $validated = false;
    } else {
        $registerUser->set_phoneNumber(input_data($_POST["phoneNumber"]));
        $phoneNumber = $registerUser->getPhoneNumber();
        if (!preg_match("/^\(\d{3}\) \d{7}$/", $phoneNumber) &&
            !preg_match("/^\+380\d{9}$/", $phoneNumber) &&
            !preg_match("/^\(\d{3}\) \d{2}-\d{2}-\d{3}$/", $phoneNumber) &&
            !preg_match("/^\+38 \(\d{3}\) \d{2} \d{2} \d{3}$/", $phoneNumber)) {
            $mobilenoErr = "Неправильний формат номеру телефона!";
            $validated = false;
        }
    }
    if (empty($_POST["signupPsw"])) {
        $passwordErr = "Ви повинні вести пароль!";
        $validated = false;
    } else {
        $registerUser->set_password(input_data($_POST["signupPsw"]));
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9]{7,}$/", $registerUser->getPassword())) {
            $passwordErr = "Пароль повинен містити не менше 7 літер, великі та малі літери, а також цифри!";
            $validated = false;
        }
    }
    if (empty($_POST["signupPswc"])) {
        $passwordcErr = "Введіть пароль для підтвердження!";
        $validated = false;
    } else {
        $signupPswc = input_data($_POST["signupPswc"]);
        if ($signupPswc != $registerUser->getPassword()) {
            $passwordcErr = "Паролі не співпадають!";
            $validated = false;
        }
    }
    $name = $registerUser->getName();
    $email = $registerUser->getEmail();
    $phoneNumber = $registerUser->getPhoneNumber();
    $existingUserQuery = "SELECT user_login, user_email, user_phonenumber FROM users 
                          WHERE user_login = '$name' OR user_email = '$email' OR user_phonenumber = '$phoneNumber'";
    $mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
    $result = $mysqli->query($existingUserQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["user_login"] == $name) {
                $nameErr = "Такий логін вже існує!";
            }
            if ($row["user_email"] == $email) {
                $emailErr = "Такий email вже використовується!";
            }
            if ($row["user_phonenumber"] == $phoneNumber) {
                $mobilenoErr = "Такий номер телефону вже використовується!";
            }
        }
        $validated = false;
    }

    if ($validated) {
        $date = date('Y-m-d H:i:s');
        $name = $mysqli->escape_string($registerUser->getName());
        $email = $mysqli->escape_string($registerUser->getEmail());
        $phoneNumber = $mysqli->escape_string($registerUser->getPhoneNumber());
        $signupPsw = password_hash($mysqli->escape_string($registerUser->getPassword()), PASSWORD_DEFAULT);
        $data = [
            "user_login" => $name,
            "user_email" => $email,
            "user_password" => $signupPsw,
            "user_phonenumber" => $phoneNumber,
            "admin" => 0,
            "register_time" => $date
        ];

        $db->create($data, 'users');

        header("Location: /php-website/index.php?action=registration_succesful");
    }
}
?>

<!DOCTYPE html>
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
            <div class="signup-form">
                <div class="title">Реєстрація</div>
                <form action="index.php?action=registration" method="post">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="signupLogin" placeholder="Enter your name">
                        </div>
                        <div class="error"><?= $nameErr ?></div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="signupEmail" placeholder="Enter your email">
                        </div>
                        <div class="error"><?= $emailErr ?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="signupPsw" placeholder="Enter your password">
                        </div>
                        <div class="error"><?= $passwordErr ?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="signupPswc" placeholder="Enter password confirmation">
                        </div>
                        <div class="error"><?= $passwordcErr ?></div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="tel" name="phoneNumber" placeholder="Enter your phonenumber">
                        </div>
                        <div class="error"><?= $mobilenoErr ?></div>
                        <div class="button input-box">
                            <input type="submit" value="Зареєструватися">
                        </div>
                        <div class="text sign-up-text">Вже є аккаунт? <a href="index.php?action=login" for="flip">Авторизуватися</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
