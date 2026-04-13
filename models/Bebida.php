<?php 
class Bebida{
    private $conn;
    private $tabela ="bebidas";

    
    public $idBebida;
    public $nome;
    public $acoolica;
    public $valor;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    function read() {
        // Query SQL para selecionar todos os campos da tabela de pizzas
        $query = "SELECT * FROM " . $this->tabela . " ORDER BY valor";
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Executa a query
        $stmt->execute();
 
        return $stmt;
    }

        public function read_single() {
            // Cria a consulta
            $query = 'SELECT
                b.idBebida,
                b.nome,
                b.acoolica,
                b.valor
            FROM
                ' . $this->tabela . ' b
            WHERE
                b.idBebida = ?
            LIMIT 1';
    
            // Prepara a query
            $stmt = $this->conn->prepare($query);
    
            // Vincula o ID
            $stmt->bindParam(1, $this->idBebida);
    
            // Executa a query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Define as propriedades
            $this->nome = $row['nome'];
            $this->acoolica = $row['acoolica'];
            $this->valor = $row['valor'];
        }

        public function create() {
            // Cria a consulta
            $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, acoolica = :acoolica, valor = :valor';
    
            // Prepara a query
            $stmt = $this->conn->prepare($query);
            
            // Limpa os dados
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->acoolica = htmlspecialchars(strip_tags($this->acoolica));
            $this->valor = htmlspecialchars(strip_tags($this->valor));
    
            // Vincula os parâmetros
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':acoolica', $this->acoolica);
            $stmt->bindParam(':valor', $this->valor);
    
            // Executa a query
            if ($stmt->execute()) {
                return true;
            }
    
            // Se ocorrer um erro, exibe a mensagem de erro
            printf("Error: %s.\n", $stmt->error);
    
            return false;
        }

        public function update() {
            // Cria a consulta
            $query = 'UPDATE ' . $this->tabela . ' SET nome = :nome, acoolica = :acoolica, valor = :valor WHERE idBebida = :id';
    
            // Prepara a query
            $stmt = $this->conn->prepare($query);
    
            // Limpa os dados
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->acoolica = htmlspecialchars(strip_tags($this->acoolica));
            $this->valor = htmlspecialchars(strip_tags($this->valor));
            $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
    
            // Vincula os parâmetros
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':acoolica', $this->acoolica);
            $stmt->bindParam(':valor', $this->valor);
            $stmt->bindParam(':id', $this->idBebida);
    
            // Executa a query
            if ($stmt->execute()) {
                return true;
            }
    
            // Se ocorrer um erro, exibe a mensagem de erro
            printf("Error: %s.\n", $stmt->error);
    
            return false;
        }

        public function delete() {
            // Cria a consulta
            $query = 'DELETE FROM ' . $this->tabela . ' WHERE idBebida = :id';
    
            // Prepara a query
            $stmt = $this->conn->prepare($query);
    
            // Limpa o ID
            $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
    
            // Vincula o ID
            $stmt->bindParam(':id', $this->idBebida);
    
            // Executa a query
            if ($stmt->execute()) {
                return true;
            }
    
            // Se ocorrer um erro, exibe a mensagem de erro
            printf("Error: %s.\n", $stmt->error);
    
            return false;
        }


}
