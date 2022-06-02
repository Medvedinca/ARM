<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <title>Авторизация</title>
</head>

<body>
    <?php
    session_start();
    $server = 'eu-cdbr-west-02.cleardb.net';
    $user = 'ba8b500d530810';
    $password = '820a4839';

    $dblink = mysqli_connect($server, $user, $password);

    if ($dblink)
        echo 'Соединение установлено.';
    else
        die('Ошибка подключения к серверу баз данных.');

    echo '<br>';
    $database = 'heroku_86dca5468e333fc';
    $selected = mysqli_select_db($dblink, $database);
    if ($selected)
        echo ' Подключение к базе данных прошло успешно.';
    else
        die(' База данных не найдена или отсутствует доступ.');


    if (isset($_POST['send'])) {
        $query = mysqli_query($dblink, "SELECT id, login, password FROM users WHERE login='" . mysqli_real_escape_string($dblink, $_POST['login']) . "' LIMIT 1");
        $data = mysqli_fetch_assoc($query);

        if ($data['password'] === $_POST['password']) {
            $_SESSION['user_id'] = $data['id'];
            header('Location: /main.php');
            exit();
        } else {
            echo '<script language="javascript">';
            echo 'alert("Неправильный логин или пароль.")';
            echo '</script>';
        }
    }
    ?>

    <div class="login">
        <form method="post">
            <b id="logintxt">Авторизация</b>
            <p id="pl">Введите ваш логин:</p>
            <input id="il" type="login" name="login" placeholder="Логин" required>
            <p id="pl" style="margin-top: 10px;">Введите ваш логин:</p>
            <input id="il" type="password" name="password" placeholder="Пароль" required>
            <button id="send" name="send" type="submit">Войти</button>
        </form>
    </div>
</body>

</html>