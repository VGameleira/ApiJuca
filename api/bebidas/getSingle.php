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

$bebida->idBebida = isset($_GET['idBebida']) ? $_GET['idBebida'] : null;

// Verificar se um ID de bebida foi fornecido
if ($bebida->idBebida) {

    // Busca a bebida
    $bebida->read_single();

    // Verificar se a bebida foi encontrada
    if ($bebida->nome != null) {
        // Criar array associativo para a bebida
        $bebida_arr = array(
            "idBebida" => $bebida->idBebida,
            "nome" => $bebida->nome,
            "acoolica" => $bebida->acoolica,
            "valor" => $bebida->valor
        );

        // Retornar a bebida em formato JSON
        echo json_encode($bebida_arr);
    } else {
        // Retornar mensagem de erro se a bebida não for encontrada
        echo json_encode(array("message" => "Bebida não encontrada."));
    }
} else {
    // Retornar mensagem de erro se o ID da bebida não for fornecido
    echo json_encode(array("message" => "ID da bebida não fornecido."));
}