DROP DATABASE IF EXISTS painel;
CREATE DATABASE painel;
USE painel;

CREATE TABLE nacoes_sistema(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
abreviatura VARCHAR(5) NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE clubes_sistema(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
abreviatura VARCHAR(5) NOT NULL,
nacao_sistema_id INT UNSIGNED NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(nacao_sistema_id) REFERENCES nacoes_sistema(id)
);

CREATE TABLE jogadores_sistema(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
apelido VARCHAR(100) NOT NULL,
dataNasc DATE NOT NULL,
clube_sistema_id INT UNSIGNED NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(clube_sistema_id) REFERENCES clubes_sistema(id)
);

CREATE TABLE ligas(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(200) NOT NULL,
dataInicio DATETIME NOT NULL,
dataFim DATETIME NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE tipos(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO tipos(id, nome) VALUES(NULL, 'Administrador'),(NULL, 'Usuário comum');

CREATE TABLE usuarios(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
nome VARCHAR(100) NOT NULL,
username VARCHAR(100) NOT NULL,
password TEXT NOT NULL,
email VARCHAR(200) NOT NULL,
dataCad DATETIME NOT NULL,
tipo_id INT UNSIGNED NOT NULL,
remember_token TEXT NULL,
updated_at DATETIME NULL,
img_fullpath VARCHAR(255),
PRIMARY KEY(id),
FOREIGN KEY(tipo_id) REFERENCES tipos(id)
);

INSERT INTO usuarios(id, nome, username, password, sexo, dataCad, tipo_id)
VALUES(NULL, 'Gustavo Carmo Costa Souza', 'Gubhweb', '$2a$08$7T3tEgdl91aNiobkZYgO6.hHZneEiBRfvoybEOHMf0HQ12gohHYBG', 'm', '2014-07-29 14:24:11', 1);

CREATE TABLE dados_classificacao(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
jogos TINYINT NOT NULL,
vitorias TINYINT NOT NULL,
empates TINYINT NOT NULL,
derrotas TINYINT NOT NULL,
gols_pro TINYINT NOT NULL,
gols_contra TINYINT NOT NULL,
saldo_gols TINYINT NOT NULL,
pontos TINYINT NOT NULL,
PRIMARY KEY(id)
);

CREATE TABLE liga_usuario_clube(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
liga_id INT UNSIGNED NOT NULL,
usuario_id INT UNSIGNED NOT NULL,
clube_sistema_id INT UNSIGNED NOT NULL,
dados_classificacao_id INT UNSIGNED NOT NULL,
relacao TINYINT(1) NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(liga_id) REFERENCES ligas(id),
FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
FOREIGN KEY(clube_sistema_id) REFERENCES clubes_sistema(id),
FOREIGN KEY(dados_classificacao_id) REFERENCES dados_classificacao(id)
);

CREATE TABLE contratos(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
jogador_sistema_id INT UNSIGNED NOT NULL,
liga_usuario_clube_id INT UNSIGNED NOT NULL,
dataInicio DATETIME NOT NULL,
dataFim DATETIME NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(jogador_sistema_id) REFERENCES jogadores_sistema(id),
FOREIGN KEY(liga_usuario_clube_id) REFERENCES liga_usuario_clube(id)
);

CREATE TABLE jogos(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
liga_usuario_clube_id_casa INT UNSIGNED NOT NULL,
liga_usuario_clube_id_fora INT UNSIGNED NOT NULL,
gols_casa TINYINT NOT NULL,
gols_fora TINYINT NOT NULL,
status TINYINT(1) NOT NULL,
dataHora DATETIME NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(liga_usuario_clube_id_casa) REFERENCES liga_usuario_clube(id),
FOREIGN KEY(liga_usuario_clube_id_fora) REFERENCES liga_usuario_clube(id)
);

CREATE TABLE ligas_jogadores_gols(
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
jogo_id INT UNSIGNED NOT NULL,
contrato_id INT UNSIGNED NOT NULL,
gols TINYINT NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(jogo_id) REFERENCES jogos(id),
FOREIGN KEY(contrato_id) REFERENCES contratos(id)
);
