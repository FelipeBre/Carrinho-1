<?php
session_start();
require_once 'conexao.php';
require_once 'Produto.php';
require_once 'Carrinho.php';

// Inicializa o carrinho na sessão
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = new Carrinho();
}
$carrinho = $_SESSION['carrinho'];

// Lista de produtos disponíveis
$produtos = Produto::listarProdutos($pdo);

// Adiciona produto ao carrinho
if (isset($_GET['adicionar'])) {
    $id = (int) $_GET['adicionar'];
    $produto = Produto::buscarProduto($pdo, $id);
    if ($produto) {
        $carrinho->adicionar($produto);
        $_SESSION['carrinho'] = $carrinho;
    }
    header('Location: index.php');
    exit;
}

// Remove produto do carrinho
if (isset($_GET['remover'])) {
    $id = (int) $_GET['remover'];
    $carrinho->remover($id);
    $_SESSION['carrinho'] = $carrinho;
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Produtos</h1>
    <div class="produtos">
        <?php foreach ($produtos as $produto): ?>
            <div class="produto">
                <img src="<?= $produto->imagem ?>" alt="<?= $produto->nome ?>">
                <h2><?= $produto->nome ?></h2>
                <p>R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                <a href="?adicionar=<?= $produto->id ?>">Adicionar ao Carrinho</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h1>Carrinho</h1>
    <div class="carrinho">
        <?php foreach ($carrinho->listar() as $item): ?>
            <div class="item">
                <h2><?= $item['produto']->nome ?></h2>
                <p>Quantidade: <?= $item['quantidade'] ?></p>
                <p>Subtotal: R$ <?= number_format($item['produto']->preco * $item['quantidade'], 2, ',', '.') ?></p>
                <a href="?remover=<?= $item['produto']->id ?>">Remover</a>
            </div>
        <?php endforeach; ?>
        <h2>Total: R$ <?= number_format($carrinho->total(), 2, ',', '.') ?></h2>
    </div>
</body>
</html>
