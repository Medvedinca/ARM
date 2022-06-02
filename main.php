<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <title>АРМ</title>
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
    ?>

    <div class="main">
        <p id="list">Список объектов:</p>

        <form class="form" method="POST">
            <select class="list" multiple="multiple" name="obj">
                <?php
                $query = mysqli_query($dblink, "SELECT name FROM objects WHERE user_id='" . $_SESSION['user_id'] . "'");

                while ($row = mysqli_fetch_assoc($query)) {
                    echo '<option name="' . $row['name'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>

            <button name="open">Открыть</button><br>
            <button name="add" onclick="window.location.href = '#dark'">Добавить</button><br>
            <button name="delete">Удалить</button>
        </form>
    </div>

    <div id="dark">
        <div id="modal">
            <p id="modal_text">Введите название объекта:</p>
            <form method="POST">
                <input type="text" id="modal_input" name="name">
                <button id="send" name="send" type="submit" onclick="window.location.href = '#'">Ввести</button>
            </form>
            <a href="#" class="close">Закрыть</a>
        </div>
    </div>

    <?php
    if (isset($_POST['send'])) {
        $query = mysqli_query($dblink, "INSERT INTO objects (user_id, name) VALUES ('" . $_SESSION["user_id"] . "', '" . $_POST["name"] . "')");
        echo '<script language="javascript">';
        echo 'alert("Запись успешно добавлена.")';
        echo '</script>';
        header("Refresh:0");
    }
    ?>

    <?php
    if (isset($_POST['delete'])) {
        $query = mysqli_query($dblink, "DELETE FROM objects WHERE name = '" . $_POST["obj"] . "'");
        $query = mysqli_query($dblink, "DELETE FROM info WHERE name = '" . $_POST["obj"] . "'");
        echo '<script language="javascript">';
        echo 'alert("Запись успешно удалена.")';
        echo '</script>';
        header("Refresh:0");
    }
    ?>

    <?php
    if (isset($_POST['open'])) {
        $_SESSION['obj'] = $_POST["obj"];
        header('Location: /arm.php');
    }
    ?>
</body>

</html>