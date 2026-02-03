CREATE DATABASE finorganizer;

USE finorganizer;

CREATE TABLE saldo (
    valor_saldo_final DOUBLE
);

CREATE TABLE receitas (
    id INT PRIMARY KEY AUTO_INCREMENT
    descricao_receita TEXT,
    valor_receita DOUBLE
);

CREATE TABLE despesas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao_despesa TEXT,
    valor_despesa DOUBLE
);

CREATE TABLE login (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario TEXT,
    senha TEXT
);