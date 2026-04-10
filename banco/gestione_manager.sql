DROP DATABASE IF EXISTS gestione_maganer;
CREATE DATABASE gestione_maganer;
USE gestione_maganer;

CREATE TABLE produtosCardapio (
id INT AUTO_INCREMENT PRIMARY KEY,
nomeProdutoCardapio char(40) NOT NULL,
descricao VARCHAR(100) NOT NULL,
tempoPreparo TIME NOT NULL,
preco INT NOT NULL,
tipoMedida ENUM ('GM','ML', 'L') NOT NULL,
statusProdutos ENUM ('Disponível', 'Indisponível')
);

CREATE TABLE itensEstoque (
id INT AUTO_INCREMENT PRIMARY KEY,
nomeItem VARCHAR(50) NOT NULL,
tipoMedida ENUM ('GM', 'KG','ML', 'L', 'UNI') NOT NULL,
quantidadeUnitaria INT NOT NULL,
categoria ENUM ('ingredientes', 'bebidas') NOT NULL
);

CREATE TABLE funcionario (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(50) NOT NULL,
email VARCHAR(40) NOT NULL UNIQUE,
senha CHAR(8) NOT NULL,
eAdministrador BOOLEAN NOT NULL DEFAULT FALSE
);
