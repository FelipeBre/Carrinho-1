<?php
class Produto {
    public $id;
    public $nome;
    public $preco;
    public $imagem;

    public function __construct($id, $nome, $preco, $imagem) {
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }

    public static function listarProdutos($pdo) {
        $stmt = $pdo->query('SELECT * FROM produtos');
        $produtos = [];
        while ($row = $stmt->fetch()) {
            $produtos[] = new Produto($row['id'], $row['nome'], $row['preco'], $row['imagem']);
        }
        return $produtos;
    }

    public static function buscarProduto($pdo, $id) {
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            return new Produto($row['id'], $row['nome'], $row['preco'], $row['imagem']);
        }
        return null;
    }
}
?>