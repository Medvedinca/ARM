<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="armi.css">
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
        <form method="post">
            <?php
            echo '<p id="label">';
            echo $_SESSION['obj'];
            echo '</p><br>';

            $sql = "SELECT * FROM info WHERE name = '{$_SESSION["obj"]}'";
            $query = mysqli_query($dblink, $sql);

            if (mysqli_num_rows($query) > 0) {
                $sql = "SELECT * FROM info WHERE name = '{$_SESSION["obj"]}'";
                $query = mysqli_query($dblink, $sql);
                $row = mysqli_fetch_assoc($query);

                echo '<p>X1:</p>';
                echo '<input type="text" name="x1" value="' . $row['x1'] . '"<br>';

                echo '<p>Y1:</p>';
                echo '<input type="text" name="y1" value="' . $row['y1'] . '"<br>';

                echo '<p>X2:</p>';
                echo '<input type="text" name="x2" value="' . $row['x2'] . '"<br>';

                echo '<p>Y2:</p>';
                echo '<input type="text" name="y2" value="' . $row['y2'] . '"<br>';

                echo '<p>Наивысшая точка:</p>';
                echo '<input type="text" name="max" value="' . $row['max'] . '"<br>';

                echo '<p>Самая низкая точка:</p>';
                echo '<input type="text" name="min" value="' . $row['min'] . '"<br>';

                echo '<p>Глубина:</p>';
                echo '<input type="text" name="deep" value="' . $row['deep'] . '"<br>';

                $value = ($row['x2'] - $row['x1']) * ($row['y2'] - $row['y1']) * $row['deep'];
                echo '<p>Объём:</p>';
                echo '<input type="text" name="value" readonly value="' . $value . '"<br>';
            } else {

                echo '<p>X1:</p>';
                echo '<input type="text" name="x1" value="' . $row['x1'] . '"<br>';

                echo '<p>Y1:</p>';
                echo '<input type="text" name="y1" value="' . $row['y1'] . '"<br>';

                echo '<p>X2:</p>';
                echo '<input type="text" name="x2" value="' . $row['x2'] . '"<br>';

                echo '<p>Y2:</p>';
                echo '<input type="text" name="y2" value="' . $row['y2'] . '"<br>';

                echo '<p>Наивысшая точка:</p>';
                echo '<input type="text" name="max" value="' . $row['max'] . '"<br>';

                echo '<p>Самая низкая точка:</p>';
                echo '<input type="text" name="min" value="' . $row['min'] . '"<br>';

                echo '<p>Глубина:</p>';
                echo '<input type="text" name="deep" value="' . $row['deep'] . '"<br>';

                $value = ($row['x2'] - $row['x1']) * ($row['y2'] - $row['y1']) * $row['deep'];
                echo '<p>Объём:</p>';
                echo '<input type="text" name="value" readonly value="' . $value . '"<br>';
            }
            ?>

            <button name="save">Сохранить</button>
            <button name="back">Назад</button>

            <?php
            if (isset($_POST['save'])) {
                $query = mysqli_query($dblink, "DELETE FROM info WHERE name = '" . $_SESSION["obj"] . "'");
                $query = mysqli_query($dblink, "INSERT INTO info (name, x1, y1, x2, y2, max, min, deep) VALUES ('" . $_SESSION["obj"] . "','" . $_POST["x1"] . "','" . $_POST["y1"] . "','" . $_POST["x2"] . "','" . $_POST["y2"] . "','" . $_POST["max"] . "','" . $_POST["min"] . "','" . $_POST["deep"] . "')");
                echo '<script language="javascript">';
                echo 'alert("Запись успешно сохранена.")';
                echo '</script>';
                header("Refresh:0");
            }

            if (isset($_POST['back'])){
                header('Location: /main.php');
            }
            ?>
        </form>
    </div>

</body>

</html>