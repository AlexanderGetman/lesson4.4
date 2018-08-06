<?php
header('charset=utf-8');

$pdo = new PDO('mysql:host=localhost;dbname=mybd', 'root', '');

if(!empty($_POST['description']))
{
    $tableName = $_POST['description'];
    echo $tableName;

    $pdo->exec("CREATE TABLE $tableName (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NULL,
        `budget` tinyint(4) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

$rs = $pdo->query("SHOW TABLES");
$all = $rs->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<form action="index.php" method="POST">
    <input type="text" name="description" placeholder="Наименование таблицы" value="<?php if (!empty($_POST['description'])) echo $_POST['description']; ?>">
    <button type="submit" name="table" value="createTable" />Создать таблицу</button>
</form>
<p>
    <?php foreach($all as $item): ?>
    <li><?php echo '<a href="tableinfo.php?table='.$item[0].'">Таблица: '.$item[0].'</a>'.'</br>';?></li>
    <?php endforeach;?>
</p>

</body>
</html>