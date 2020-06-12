<?php
header('Content-Type: text/html; charset=utf-8');
$pdo = new PDO('mysql:host=localhost;dbname=mybd', 'root', '');

$table = $_GET["table"];

$q = $pdo->query("DESCRIBE $table");
$table_fields = $q->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);

if(isset($_POST['name']))
{
$newname = $_POST['name'];
}

if(isset($_POST['oldname']))
{
$oldname = $_POST['oldname'];
}

if(isset($_POST['newtype']))
{
$newtype = $_POST['newtype'];
}

if(isset($_POST['oldtype']))
{
$oldtype = $_POST['oldtype'];
}

if (isset($_POST['name'])) {
    $sql = "ALTER TABLE $table CHANGE $oldname $newname $oldtype";
    $statement = $pdo->prepare($sql);
    $statement->execute(["{$_POST['name']}"]);
    header('Location: ./tableinfo.php?table='.$table);
}

if (isset($_POST['newtype'])) {
    $sql = "ALTER TABLE $table MODIFY $oldname $newtype";
    $statement = $pdo->prepare($sql);
    $statement->execute(["{$_POST['newtype']}"]);
    header('Location: ./tableinfo.php?table='.$table);
}

if(isset($_POST['nameToDelete']))
{
$toDelete = $_POST['nameToDelete'];
}

if (isset($_POST['nameToDelete'])) {
    $sql = "ALTER TABLE $table DROP COLUMN $toDelete;";
    $statement = $pdo->prepare($sql);
    $statement->execute(["{$_POST['nameToDelete']}"]);
    header('Location: ./tableinfo.php?table='.$table);
}

?>
<html>
<body>
<table border="1">
    <tr>
        <th>Название поля</th>
        <th>Тип поля</th>
        <th colspan="3">Функции</th>
    </tr>
<?php  foreach($table_fields as $data => $fields): ?>
  <?php  foreach($fields as $rows => $names): ?>
        <tr>
            <td><?=$data;?></td>
            <td><?=$names;?></td>
            <td>
                <form action="" method="POST">
                    <input type="text" name="name" placeholder="Наименование" value="<?php if (!empty($_POST['name'])) echo $_POST['name']; ?>">
                    <button type="submit" value="<?php echo $data;?>" name="oldname" />Переименовать</button>
                    <input type="hidden" name="oldtype" id="hiddenField" value="<?php echo $names?>" />
                </form>
            </td>
            <td>
                <form action="" method="POST">
                    <select name="newtype">
                        <option selected disabled>Выберите тип поля:</option>
                        <option value="VARCHAR(50)">VARCHAR(50)</option>
                        <option value="VARCHAR(255)">VARCHAR(255)</option>
                        <option value="TINYINT(10)">TINYINT(10)</option>
                        <option value="INT(255)">INT(255)</option>
                        <option value="FLOAT NOT NULL">FLOAT NOT NULL</option>
                    </select>
                    <button type="submit" value="<?php echo $data;?>" name="oldname" />Изменить</button>
                </form>
            </td>
            <td>
                <form action="" method="POST">
                    <button type="submit" value="<?php echo $data;?>" name="nameToDelete" />Удалить</button>
                </form>
            </td>
        </tr>
  <?php endforeach;?>
<?php endforeach;?>
</table>
<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>
