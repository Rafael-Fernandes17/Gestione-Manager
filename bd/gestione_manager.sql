DROP DATABASE IF EXISTS gestione_manager;
CREATE DATABASE gestione_manager;
USE gestione_manager;

CREATE TABLE produtosCardapio (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
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

CREATE TABLE itensEstoque (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nomeItem VARCHAR(50) NOT NULL,
    tipoMedida VARCHAR(20) NOT NULL, 
    categoria VARCHAR(50) NOT NULL,  
    fornecedor VARCHAR(100) DEFAULT NULL,
    valorItem DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estoqueMinimo DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    quantidadeUnitaria DECIMAL(10,2) DEFAULT 0.00,
    PRIMARY KEY (id)
);
CREATE TABLE funcionario (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(40) NOT NULL,
	senha VARCHAR(255) NOT NULL,
	eAdm BOOLEAN DEFAULT FALSE
);
