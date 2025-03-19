<?php
include_once "classes/db.class.php";
include_once "classes/gest-manutencao.class.php";

$query = isset($_GET['q']) ? $_GET['q'] : '';

$db = DB::connect();
$rs = $db->prepare("SELECT DISTINCT * FROM item WHERE nr_disponibilidade = 1 and ds_item LIKE :query OR cod_patrimonio LIKE :query");
$rs->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
$rs->execute();
$itens = $rs->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($itens);