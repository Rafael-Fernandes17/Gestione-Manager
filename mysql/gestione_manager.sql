DROP DATABASE IF EXISTS gestione_maganer;
CREATE DATABASE gestione_maganer;
USE gestione_maganer;

CREATE TABLE produtosCardapio (
id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
nomeProdutoCardapio VARCHAR(40) NOT NULL,
descricao VARCHAR(100) NOT NULL,
tempoPreparo TIME NOT NULL,
preco DECIMAL(10,2) NOT NULL,
imagem LONGBLOB NOT NULL,
quantidadeMedida INT NOT NULL,
tipoMedida ENUM ('GM','ML', 'L') NOT NULL,
statusProdutos ENUM ('Disponível', 'Indisponível') NOT NULL
);

CREATE TABLE itensEstoque (
id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
nomeItem VARCHAR(50) NOT NULL,
tipoMedida ENUM ('GM', 'KG','ML', 'L', 'UNI') NOT NULL,
quantidadeUnitaria INT NOT NULL,
categoria ENUM ('ingredientes', 'bebidas') NOT NULL
);

CREATE TABLE funcionario (
id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
nome VARCHAR(50) NOT NULL,
email VARCHAR(40) NOT NULL,
senha CHAR(8) NOT NULL
);

CREATE TABLE comanda (
);