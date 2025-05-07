DROP DATABASE IF EXISTS cdsconsu_biblioteca;
CREATE DATABASE cdsconsu_biblioteca;
USE cdsconsu_biblioteca;

CREATE TABLE livros (
    id_livro INT(10) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(55) NOT NULL,
    autor INT(10),
    peso DECIMAL(10,2),
    PRIMARY KEY (id_livro)
);
