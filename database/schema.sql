-- create database techmobile;
-- use techmobile;

-- Criando as tabelas bases sistema web
-- Tabela Clientes
create table clientes (
id_cliente int auto_increment primary key,
nome varchar(120) not null,
email varchar(120) not null unique,
senha_hash varchar(255) not null,
cpf varchar(14),
telefone varchar(30),
data_cadastro datetime not null,
ativo boolean not null
);

-- Tabela Adminstradores
create table admin (
id_admin int auto_increment primary key,
nome varchar(120) not null,
email varchar(120) not null unique,
senha_hash varchar(255) not null,
ativo boolean not null
);

-- Tabela Produtos
create table produtos (
id_produto int auto_increment primary key,
nome varchar(160) not null,
marca varchar(80) not null,
descricao text,
preco decimal(10,2) not null,
imagem_url varchar(255),
ativo boolean not null,
data_cadastro datetime not null
);

-- use techmobile;
-- select * from produtos;
-- drop table if exists produtos;

-- Tabela Estoque
create table estoque (
id_estoque int auto_increment primary key,
id_produto int not null,
quantidade_atual int not null,
atualizado_em datetime not null,
foreign key (id_produto) references produtos(id_produto)
);

-- Tabela Status Pedidos
create table status_pedido (
id_status int auto_increment primary key,
nome_status varchar(40) not null unique
);
-- Boa prática inserção de status na tabela
insert into status_pedido (nome_status) values 
('Pendente'), 
('Pago'), 
('Enviado'), 
('Entregue'), 
('Cancelado');

-- Tabela Pedidos
create table pedidos (
id_pedido int auto_increment primary key,
id_status int not null,
id_cliente int not null,
data_pedido datetime not null,
valor_total decimal(10,2) not null,
observacao varchar(255),
atualizado_em datetime not null,
id_admin_ultimo_update int,
constraint fk_cliente_pedido foreign key (id_cliente) references clientes (id_cliente),
constraint fk_status_pedido foreign key (id_status) references status_pedido (id_status),
constraint fk_admin_pedido foreign key (id_admin_ultimo_update) references admin (id_admin)
);

-- drop table if exists pedidos;
-- desc clientes;
-- select * from techmobile.clientes;

-- Tabela Itens Pedidos
create table itens_pedidos(
id_item int auto_increment primary key,
id_pedido int not null,
id_produto int not null,
quantidade int not null,
preco_unitario decimal(10,2) not null,
subtotal decimal(10,2) not null,
constraint fk_pedido foreign key (id_pedido) references pedidos (id_pedido),
constraint fk_produto foreign key (id_produto) references produtos (id_produto),
unique (id_pedido,id_produto)
);

-- Teste de Listagem dos Produtos
INSERT INTO produtos (nome, marca, preco, ativo, data_cadastro) VALUES 
('iPhone 15 Pro', 'Apple', 7499.00, 1, NOW()),
('Galaxy S24 Ultra', 'Samsung', 6800.00, 1, NOW()),
('Redmi Note 13', 'Xiaomi', 1500.00, 1, NOW());

-- Inserindo uma variedade de produtos conforme o wireframe
INSERT INTO produtos (nome, marca, preco, descricao, imagem_url, ativo, data_cadastro) VALUES 
('Apple iPhone 17', 'Apple', 8476.00, 'Lançamento com tecnologia de ponta.', 'iphone17.jpg', 1, NOW()),
('Galaxy Z Fold7', 'Samsung', 7784.00, 'O melhor da tecnologia dobrável.', 'fold7.jpg', 1, NOW()),
('Motorola Signature', 'Motorola', 8899.00, 'Design premium e acabamento exclusivo.', 'signature.jpg', 1, NOW()),
('Xiaomi 17 Pro Max', 'Xiaomi', 4822.00, 'Performance extrema com câmeras Leica.', 'xiaomi17.jpg', 1, NOW()),
('Poco X7', 'Xiaomi', 2299.00, 'O rei do custo-benefício para gamers.', 'pocox7.jpg', 1, NOW()),
('Galaxy S25 FE', 'Samsung', 3899.00, 'A experiência fan edition definitiva.', 's25fe.jpg', 1, NOW());

-- Importante: Conforme o DER, precisamos de estoque para esses itens (RN-01)
INSERT INTO estoque (id_produto, quantidade_atual, atualizado_em)
SELECT id_produto, 50, NOW() FROM produtos;

USE techmobile;

-- Inserindo os produtos do Wireframe (RF-W01)
INSERT INTO produtos (nome, marca, preco, descricao, imagem_url, ativo, data_cadastro) VALUES 
('Apple iPhone 17', 'Apple', 8476.00, 'Tecnologia a um clique de distância.', 'iphone17.jpg', 1, NOW()),
('Apple iPhone 16e', 'Apple', 3499.00, 'O equilíbrio perfeito entre potência e valor.', 'iphone16e.jpg', 1, NOW()),
('Xiaomi 17 Pro Max', 'Xiaomi', 4822.00, 'Performance extrema com design inovador.', 'xiaomi17.jpg', 1, NOW()),
('Motorola Signature', 'Motorola', 8899.00, 'Edição limitada com acabamento premium.', 'moto_sig.jpg', 1, NOW()),
('Galaxy Z Fold7', 'Samsung', 7784.00, 'A revolução das telas dobráveis.', 'fold7.jpg', 1, NOW()),
('Poco X7', 'Xiaomi', 2299.00, 'Poder gamer ao alcance de todos.', 'pocox7.jpg', 1, NOW());

USE techmobile;

-- Inserindo os produtos do Wireframe (RF-W01)
INSERT INTO produtos (nome, marca, preco, descricao, imagem_url, ativo, data_cadastro) VALUES 
('Apple iPhone 17', 'Apple', 8476.00, 'Tecnologia a um clique de distância.', 'iphone17.jpg', 1, NOW()),
('Apple iPhone 16e', 'Apple', 3499.00, 'O equilíbrio perfeito entre potência e valor.', 'iphone16e.jpg', 1, NOW()),
('Xiaomi 17 Pro Max', 'Xiaomi', 4822.00, 'Performance extrema com design inovador.', 'xiaomi17.jpg', 1, NOW()),
('Motorola Signature', 'Motorola', 8899.00, 'Edição limitada com acabamento premium.', 'moto_sig.jpg', 1, NOW()),
('Galaxy Z Fold7', 'Samsung', 7784.00, 'A revolução das telas dobráveis.', 'fold7.jpg', 1, NOW()),
('Poco X7', 'Xiaomi', 2299.00, 'Poder gamer ao alcance de todos.', 'pocox7.jpg', 1, NOW());

-- Estoque inicial (RN-08)
-- Vincula cada produto novo a uma entrada na tabela estoque
INSERT INTO estoque (id_produto, quantidade_atual, atualizado_em)
SELECT id_produto, 50, NOW() FROM produtos 
WHERE id_produto NOT IN (SELECT id_produto FROM estoque);




