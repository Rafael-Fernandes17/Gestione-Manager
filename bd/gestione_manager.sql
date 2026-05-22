DROP DATABASE IF EXISTS gestione_manager;
CREATE DATABASE gestione_manager;
USE gestione_manager;

CREATE TABLE itensEstoque (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomeItem VARCHAR(50) NOT NULL,
    tipoMedida VARCHAR(20) NOT NULL, 
    categoria VARCHAR(50) NOT NULL,  
    fornecedor VARCHAR(100) DEFAULT NULL,
    valorItem DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estoqueMinimo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    quantidadeUnitaria DECIMAL(10,2) DEFAULT 0.00
);

CREATE TABLE fluxoEstoque (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_item INT(11) NOT NULL,
    tipo_operacao VARCHAR(10) NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    data_operacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    motivo VARCHAR(255) DEFAULT NULL,
    documento_nf LONGBLOB DEFAULT NULL,
    documento_nf_tipo VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (id_item) REFERENCES itensEstoque(id)
);

CREATE TABLE produtoCardapio (
	idProdutosCardapio INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	nomeProdutoCardapio VARCHAR(40) NOT NULL,
	descricao VARCHAR(100) NOT NULL,
	categoria ENUM ('Entradas', 'Pratos Principais', 'Bebidas', 'Sobremesas') NOT NULL,
	tempoPreparo TIME NOT NULL,
	preco DECIMAL(10,2) NOT NULL,
	imagem LONGBLOB NOT NULL,
	quantidadeMedida INT NOT NULL,
	tipoMedida ENUM ('GM','ML', 'L') NOT NULL,
	statusProdutos ENUM ('Disponível', 'Indisponível') NOT NULL
);

CREATE TABLE produto_ingrediente (
    idProdutoIngrediente INT AUTO_INCREMENT PRIMARY KEY,
    idProduto INT NOT NULL,
    idItemEstoque INT NOT NULL,
    FOREIGN KEY (idProduto) REFERENCES produtoCardapio(idProdutosCardapio),
    FOREIGN KEY (idItemEstoque) REFERENCES itensEstoque(id)
);

CREATE TABLE pedido(
idPedido int auto_increment primary key not null,
idProdutosCardapioSelecionados int not null,
quantidade int not null,
precoTotal double not null,
dataPedido datetime,
statusPedido enum ('cancelado','em preparo','finalizado'),
foreign key (idProdutosCardapioSelecionados) references produtosCardapio(idProdutosCardapio)
);

CREATE TABLE comanda(
	idComanda int auto_increment primary key not null,
    idPedidoReferente int not null,
    valorTotal double not null,
    foreign key (idPedidoReferente) references pedido(idPedido)
);
CREATE TABLE funcionario (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(40) NOT NULL,
	senha VARCHAR(255) NOT NULL,
	eAdm BOOLEAN DEFAULT FALSE,
    primeiroAcesso BOOLEAN DEFAULT TRUE
);

INSERT INTO funcionario (nome, email, senha, eAdm, primeiroAcesso) 
VALUES ('Gerente Mario', 'Mario@gestione.com', '$2y$10$2A4Dv.nOIIVY0On0NkCZeO4H1GPgxdZr99FuNyae9jM1dhr/PqhX.', TRUE, TRUE);