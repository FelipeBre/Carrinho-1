<?php
class Carrinho {
    private $itens = [];

    public function adicionar(Produto $produto, $quantidade = 1) {
        if (isset($this->itens[$produto->id])) {
            $this->itens[$produto->id]['quantidade'] += $quantidade;
        } else {
            $this->itens[$produto->id] = [
                'produto' => $produto,
                'quantidade' => $quantidade
            ];
        }
    }

    public function remover($id) {
        if (isset($this->itens[$id])) {
            unset($this->itens[$id]);
        }
    }

    public function listar() {
        return $this->itens;
    }

    public function total() {
        $total = 0;
        foreach ($this->itens as $item) {
            $total += $item['produto']->preco * $item['quantidade'];
        }
        return $total;
    }
}
?>
