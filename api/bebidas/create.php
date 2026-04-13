
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Bebida.php';

$database = new Database();
$db = $database->getConnection();

$bebida = new Bebida($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nome) &&
            isset($data->acoolica) &&
            !empty($data->valor)
        ) {
            $bebida->nome = $data->nome;
            $bebida->acoolica = $data->acoolica;
            $bebida->valor = $data->valor;

            if ($bebida->create()) {
                http_response_code(201);
                echo json_encode(
                    array('Mensagem' => 'Bebida Criada com Sucesso')
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel criar a Bebida')
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel criar a Bebida.')
            );
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(
        array('Mensagem' => 'Metodo nao permitido. Use POST.')
    );
    
}