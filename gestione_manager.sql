DROP DATABASE IF EXISTS gestione_maganer;
CREATE DATABASE gestione_maganer;
USE gestione_maganer;

CREATE TABLE produtosCardapio (
id int AUTO_INCREMENT primary key NOT NULL,
nomeProdutoCardapio char(40) NOT NULL,
descricao VARCHAR(100) NOT NULL,
tempoPreparo TIME NOT NULL,
preco int NOT NULL,
tipoMedida ENUM ('GM','ML', 'L') NOT NULL,
statusProdutos ENUM ('Disponível', 'Indisponível')
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