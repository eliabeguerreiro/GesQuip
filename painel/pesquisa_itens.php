<?php
include_once "classes/db.class.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chave = $_POST['chave'];
    $busca = $_POST['busca'];

    // Validate input
    if (empty($chave) || empty($busca)) {
        echo json_encode([]); // Return empty results if input is invalid
        exit;
    }

    // Connect to the database
    $db = DB::connect();

    try {
        // Prepare the base query
        if ($chave == 'ds_item') {
            $stmt = $db->prepare("SELECT * FROM item WHERE $chave LIKE :busca and desativado is NULL");
        } elseif ($chave == 'cod_patrimonio') {
            $stmt = $db->prepare("SELECT * FROM item WHERE $chave = :busca and desativado is NULL");
        } else {
            echo json_encode([]); // Invalid chave, return empty results
            exit;
        }

        // Bind parameters to prevent SQL injection
        if ($chave == 'ds_item') {
            $stmt->bindValue(':busca', '%' . $busca . '%', PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        }

        // Execute the query
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process additional data for each result
        foreach ($resultados as $key => $value) {
            // Fetch familia name
            $stmt = $db->prepare("SELECT ds_familia FROM familia WHERE id_familia = :id_familia");
            $stmt->bindValue(':id_familia', $value['id_familia'], PDO::PARAM_INT);
            $stmt->execute();
            $familiaResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $resultados[$key]['familia'] = $familiaResult['ds_familia'] ?? null;

            // Fetch movimentacao and usuario details if item is not available
            if ($value['nr_disponibilidade'] != 1) {
                $query = $db->prepare("
                    SELECT id_movimentacao 
                    FROM item_movimentacao 
                    WHERE id_item = :id_item 
                    ORDER BY id_item_movimentacao DESC LIMIT 1
                ");
                $query->bindValue(':id_item', $value['id_item'], PDO::PARAM_INT);
                $query->execute();
                $movimentResult = $query->fetch(PDO::FETCH_ASSOC);
                $moviment = $movimentResult['id_movimentacao'] ?? null;

                $resultados[$key]['movimentacao'] = $moviment;

                if ($moviment) {
                    $query = $db->prepare("SELECT id_responsavel FROM movimentacao WHERE id_movimentacao = :id_movimentacao");
                    $query->bindValue(':id_movimentacao', $moviment, PDO::PARAM_INT);
                    $query->execute();
                    $responsavelResult = $query->fetch(PDO::FETCH_ASSOC);
                    $id_user = $responsavelResult['id_responsavel'] ?? null;

                    if ($id_user) {
                        $query = $db->prepare("SELECT nm_usuario FROM usuarios WHERE id_usuario = :id_usuario");
                        $query->bindValue(':id_usuario', $id_user, PDO::PARAM_INT);
                        $query->execute();
                        $usuarioResult = $query->fetch(PDO::FETCH_ASSOC);
                        $user = $usuarioResult['nm_usuario'] ?? null;
                    } else {
                        $user = null;
                    }
                    $resultados[$key]['usuario'] = $user;
                }
            }
        }

        // Return results as JSON
        echo json_encode($resultados);
    } catch (PDOException $e) {
        // Handle database errors gracefully
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>