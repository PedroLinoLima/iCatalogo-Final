create database icatalogo;
use icatalogo;

create table tbl_produto(
    id int primary key auto_increment,
    descricao varchar(255) not null,
    peso decimal not null,
    quantidade int not null,
    cor varchar(100) not null,
    tamanho varchar(100),
    valor decimal not null,
    desconto int,
    imagem varchar(500)
);

INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto) VALUES ('descricao do produto', 1.2, 100, "Preto", "G", 10.5, 15);

SELECT * FROM tbl_produto

USE icatalogo

create table tbl_administrador(
   id int primary key auto_increment,
   nome varchar(255) not null,
   usuario varchar(100) not null,
   senha varchar (15) not null
);

insert into tbl_administrador (nome, usuario, senha) values ("Fulano de Tal","fulano","123456");
insert into tbl_administrador (nome, usuario, senha) values ("Ciclano da Silva","ciclano","654321");

SELECT * FROM tbl_administrador

DELETE FROM tbl_administrador
WHERE id BETWEEN 1 AND 4

select * from tbl_administrador where usuario = 'fulano' and senha = '12356'



Create table usuarios (
ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
login Varchar(30),
senha Varchar(40),
Primary Key (ID)) ENGINE = MyISAM;

insert into usuarios (login, senha) values ("fulano","123456");