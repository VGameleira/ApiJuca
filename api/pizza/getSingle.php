<?php
// api/pizza/read.php


// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Pizza
$pizza = new Pizza($db);

$pizza->idPizza = isset($_GET['idPizza']) ? $_GET['idPizza'] : null;

// Verificar se um ID de pizza foi fornecido
if ($pizza->idPizza) {
    // Busca a pizza
    $pizza->read_single();

    // Cria o array de resposta
    $pizza_arr = array(
        "idPizza" => $pizza->idPizza,
        "nome" => $pizza->nome,
        "ingredientes" => $pizza->ingredientes,
        "valor" => $pizza->valor
    );

    // Retornar a pizza em formato JSON
    echo json_encode($pizza_arr);

} else {
    // Retornar mensagem de erro se o ID da pizza não for fornecido
    echo json_encode(array("message" => "ID da pizza não fornecido."));
}