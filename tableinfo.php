<?php
header('Content-Type: text/html; charset=utf-8');
$pdo = new PDO('mysql:host=localhost;dbname=mybd', 'root', '');

$table = $_GET["table"];
//var_dump($table);

$q = $pdo->query("DESCRIBE $table");
$table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
//var_dump($table_fields);

//$select = $pdo->query('SELECT COUNT(*) FROM $table');
//$table_fields = $select->getColumnMeta(0);
//var_dump($table_fields);


foreach ($table_fields as $fields)
{
    echo $fields, '<br>';
}
