create database Ecommerce;

use Ecommerce;

create table Usuario (
    id_usuario int auto_increment primary key,
    email varchar(255) unique not null,
    senha varchar(255) not null,
    tipo enum('cliente', 'administrador') not null
);

create table Cliente (
    id_cliente int auto_increment primary key,
    id_usuario int not null,
    cpf varchar(11) unique not null,
    nome varchar(255) not null,
    data_nasc date not null,
    sexo enum('masculino', 'feminino', 'outro') not null,
    foreign key (id_usuario) references Usuario (id_usuario)
);

create table Administrador (
    id_admin int auto_increment primary key,
    id_usuario int not null,
    nome varchar(255) not null,
    foreign key (id_usuario) references Usuario (id_usuario)
);

create table Telefone (
    id_telefone int auto_increment primary key,
    id_cliente int not null,
    numero VARCHAR(11) not null,
	foreign key (id_cliente) references Cliente (id_cliente)
);

create table Endereco (
    id_endereco int auto_increment primary key,
    id_cliente int not null,
    rua varchar(255) not null,
    numero varchar(6) not null,
    complemento varchar(100),
    bairro varchar(255) not null,
    cidade varchar(255) not null,
    estado char(2),
    cep VARCHAR(9),
    tipo enum('Principal', 'Secundário') not null,
    foreign key (id_cliente) references Cliente (id_cliente)
);

create table Categoria (
    id_categoria int auto_increment primary key,
    nome_categoria varchar(100) not null unique
);

create table Produto (
    id_produto int auto_increment primary key,
    nome_categoria varchar(100) not null,
    nome varchar(255) not null,
    descricao varchar(255) not null,
    preco decimal(10,2) not null,
    colecao boolean,
    qtd_em_estoque int not null,
    url varchar(255),
    foreign key (nome_categoria) references Categoria (nome_categoria)
);

create table Carrinho (
    id_carrinho int auto_increment primary key,
    id_cliente int not null,
    total decimal(10, 2) not null default 0.00,
    data_criacao datetime not null default current_timestamp,
    foreign key (id_cliente) references Cliente (id_cliente)
);

create table ItemCarrinho (
    id_item int auto_increment primary key,
    id_carrinho int not null,
    id_produto int not null,
    --endereco varchar(255) not null,--
    --nome varchar(255) not null,--
    quantidade int not null,
    subtotal decimal(10, 2) not null,
    foreign key (id_carrinho) references Carrinho (id_carrinho),
    foreign key (id_produto) references Produto (id_produto)
);

create table Pedido (
    id_pedido int auto_increment primary key,
    id_cliente int not null,
    id_endereco int not null,
    data_pedido timestamp default current_timestamp,
    status enum('aguardando pagamento', 'processando', 'em separação', 'a caminho', 'entregue', 'cancelado') default 'aguardando pagamento' not null,
    total decimal(10, 2) not null,
    foreign key (id_cliente) references Cliente (id_cliente),
    foreign key (id_endereco) references Endereco (id_endereco)
);

create table ItemPedido (
    id_item_pedido int auto_increment primary key,
    id_pedido int not null,
    id_produto int not null,
    preco_unitario decimal(10, 2) not null,
    quantidade int not null,
    subtotal decimal(10, 2) not null,
    foreign key (id_pedido) references Pedido (id_pedido),
    foreign key (id_produto) references Produto (id_produto)
);

create table Pagamento (
    id_pagamento int auto_increment primary key,
    id_pedido int not null,
    data_pagamento timestamp default current_timestamp,
    valor decimal(10, 2) not null,
    metodo enum('Cartão', 'Boleto', 'Pix'),
    foreign key (id_pedido) references Pedido (id_pedido)
);

-- Coleções
-- 1 = Moletons
-- 2 = Camisas
-- 3 = Calças

insert into Categoria (nome_categoria) values ('Moletom');
insert into Categoria (nome_categoria) values ('Camisa');
insert into Categoria (nome_categoria) values ('Calça');
insert into Categoria (nome_categoria) values ('Bicicleta');

insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Moletom', 'Moletom Blook', 'Blusa Moletom Blook 100% algodão', 199.99, 100, '/TCC/ecommerce/assets/images/produtos/Moletom-Blook.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, colecao, qtd_em_estoque, url) values ('Calça', 'Kit 3 Calças Moletom Blook', 'Kit com 3 Calças Moletom Blook', 159.99, 3, 100, '/TCC/ecommerce/assets/images/produtos/Kit-3-Calças-Moletom-Blook.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, colecao, qtd_em_estoque, url) values ('Camisa', 'Kit 3 Camisas Connect', 'Kit com 3 Camisas Connect 100% algodão', 199.99, 2, 100, '/TCC/ecommerce/assets/images/produtos/Kit-3-Camisas-Connect.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, colecao, qtd_em_estoque, url) values ('Camisa', 'Kit 3 Camisas Básicas Blook', 'Kit com 3 camisas básicas da Blook', 149.99, 2, 100, '/TCC/ecommerce/assets/images/produtos/Kit-3-Camisas-Básicas-Blook.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Moletom', 'Moletom Vermelho Feminino', 'Moletom Feminino Vermelho ', 109.99, 100, '/TCC/ecommerce/assets/images/produtos/Moletom-Vermelho-Feminino.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Camisa', 'Camisa TaySon Branca', 'Camisa Branca TaySon ', 99.99, 100, '/TCC/ecommerce/assets/images/produtos/Camisa-TaySon-Branca.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Camisa', 'Camisa TaySon Preta', 'Camisa Preta TaySon ', 99.99, 100, '/TCC/ecommerce/assets/images/produtos/Camisa-TaySon-Preta.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Camisa', 'Camisa OutCast Tiger Branca', 'Camisa Branca da OutCast modelo Tiger', 79.99, 100, '/TCC/ecommerce/assets/images/produtos/Camisa-OutCast-Tiger-Branca.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Camisa', 'Camisa OutCast Branca', 'Camisa Branca da OutCast', 79.99, 100, '/TCC/ecommerce/assets/images/produtos/Camisa-OutCast-Branca.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Camisa', 'Camisa listrada vermelha e preta', 'Camisa listrada vermelha e preta', 60.00, 100, '/TCC/ecommerce/assets/images/produtos/Camisa-listrada-vermelha-e-preta.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, colecao,  qtd_em_estoque, url) values ('Camisa', 'Kit 3 Camisas Polo Premium Blook', 'Kit com 3 Camisas Polo Premium 100% algodão da marca Blook', 249.99, 2, 100, '/TCC/ecommerce/assets/images/produtos/Kit-3-Camisas-Polo-Premium-Blook.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, colecao, qtd_em_estoque, url) values ('Camisa', 'Kit 3 Camisas Polo Simple', 'Camisas Polo Simple nas cores branco, preto e azul', 149.99, 2, 100, '/TCC/ecommerce/assets/images/produtos/Kit-3-Camisas-Polo-Simple.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Moletom', 'Moletom 705 Preto', 'Moletom Preto 705', 60.00, 100, '/TCC/ecommerce/assets/images/produtos/Moletom-705-Preto.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Moletom', 'Moletom 705 California', 'Moletom Preto 705 California', 60.00, 100, '/TCC/ecommerce/assets/images/produtos/Moletom-705-California.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Calça', 'Calça Jeans Blook Azul', 'Calça jeans azul Blook', 60.00, 100, '/TCC/ecommerce/assets/images/produtos/Calça-Jeans-Blook-Azul.jpg');
insert into Produto (nome_categoria, nome, descricao, preco, qtd_em_estoque, url) values ('Calça', 'Calça Jeans Preta', 'Calça Jeans Preta', 75.00, 100, '/TCC/ecommerce/assets/images/produtos/Calça-Jeans-Preta.jpg');

-- Conta de admin
-- senha admin123
INSERT INTO Usuario (email, senha, tipo) VALUES ('admin@gmail.com', '$2y$10$InhrliSk.KLO6YJqEM/poObGbhYQmyPAoLeefXVj4biMV1xr9.dqy', 'administrador');
INSERT INTO Administrador (id_usuario, nome) VALUES (1, 'Principal');

DELIMITER $$

CREATE TRIGGER atualiza_quantidade_produto 
AFTER INSERT ON ItemPedido
FOR EACH ROW 
BEGIN
    -- Atualiza a quantidade do produto com base no item inserido
    UPDATE produto
    SET qtd_em_estoque = qtd_em_estoque - NEW.quantidade
    WHERE id_produto = NEW.id_produto;
END$$

DELIMITER ;
