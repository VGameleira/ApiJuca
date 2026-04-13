<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebida.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebida
$bebida = new Bebida($db);

try {
    // Chamar o método read() para buscar as bebidas
    $stmt = $bebida->read();
    $num = $stmt->rowCount();

    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de bebidas
        $bebidas_arr = array();

        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
            extract($row);

            $bebida_item = array(
                "idBebida" => $idBebida,
                "nome" => $nome,
                "valor" => $valor
            );

            array_push($bebidas_arr, $bebida_item);
        }

        // Definir o código de resposta como 200 OK
        http_response_code(200);

        // Mostrar os dados das bebidas em formato JSON
        echo json_encode($bebidas_arr);
    } else {
        // Definir o código de resposta como 404 Not Found
        http_response_code(404);

        // Informar ao usuário que nd foi encontrado
        echo json_encode(
            array("message" => "Nenhuma bebida encontrada.")
        );
    }
} catch (Exception $e) {
  echo json_encode(array("erro" => $e->getMessage()));
}

