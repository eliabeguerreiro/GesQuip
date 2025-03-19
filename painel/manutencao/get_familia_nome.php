<?php
include_once "../../classes/db.class.php";
include_once "../itens/classes/gest-item.class.php";

if (isset($_GET['id_familia'])) {
    $id_familia = (int)$_GET['id_familia'];
    $familiaNome = Item::getFamiliaNome($id_familia);
    echo json_encode(['ds_familia' => $familiaNome]);
} else {
    echo json_encode(['ds_familia' => null]);
}
?>