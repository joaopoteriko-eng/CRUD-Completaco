-- Execute no phpMyAdmin. Banco único com tabelas relacionadas.
CREATE DATABASE IF NOT EXISTS estoque_didatico CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE estoque_didatico;

CREATE TABLE IF NOT EXISTS usuarios (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 senha_hash VARCHAR(255) NOT NULL,
 perfil ENUM('admin','operador') NOT NULL DEFAULT 'operador',
 ativo TINYINT(1) NOT NULL DEFAULT 1,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produtos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(120) NOT NULL,
 categoria VARCHAR(80) NOT NULL,
 preco DECIMAL(10,2) NOT NULL DEFAULT 0,
 quantidade INT UNSIGNED NOT NULL DEFAULT 0,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT chk_preco CHECK (preco >= 0)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS movimentacoes (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 produto_id INT UNSIGNED NOT NULL,
 usuario_id INT UNSIGNED NOT NULL,
 tipo ENUM('entrada','saida') NOT NULL,
 quantidade INT UNSIGNED NOT NULL,
 observacao VARCHAR(255) DEFAULT NULL,
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

 CONSTRAINT chk_quantidade CHECK (quantidade > 0),
 FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
 FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
 INDEX idx_mov_data (criado_em),
 INDEX idx_mov_produto (produto_id)
) ENGINE=InnoDB;

-- Hash bcrypt de Admin@12345!, gerado por password_hash; troque a senha após entrar.
INSERT INTO usuarios (nome,email,senha_hash,perfil,ativo)
VALUES ('Administrador','admin@escola.local','$2y$12$L3ZePBMBEybYavL1hBJTzeGBOrXsdrHH7rtIdLslPQW3RphUDhpoq','admin',1)
ON DUPLICATE KEY UPDATE id=id;

-- Dados para iniciar as atividades: ajuste as quantidades por movimentações.
INSERT INTO produtos (nome,categoria,preco,quantidade) VALUES
('Caderno universitário','Papelaria',24.90,0),
('Caneta azul','Papelaria',2.50,0),
('Mouse USB','Informática',45.00,0);
