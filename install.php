<?php
require("dbhost.php");

try {
    $dbname = "cabra";
    
    // Create tables
    $dbh->exec("use $dbname");

    // Determine if user table exists, if not, create all tables
    $stmt = $dbh->prepare("show tables like 'usuarios'");
    $stmt->execute();
    if ($stmt->rowCount() === 0) {
        $dbh->exec("create table if not exists usuarios
(id int not null auto_increment,
nome varchar(31),
hash varchar(255),
constraint u_nome unique (nome),
constraint pk_usuario_id primary key (id)) engine=InnoDB");
        echo("Tabela de usuarios criada<br><br>");

        $dbh->exec("create table if not exists contas
(id int not null auto_increment,
dono int,
tipo varchar(15),
sinal int,
nome varchar(63),
orcamento decimal(13,2),
constraint pk_conta_id primary key (id),
constraint u_nome unique (nome),
constraint fk_conta_usuario foreign key (dono)
  references usuarios (id)) engine=InnoDB");
        echo("Tabela de contas criada<br><br>");

        $dbh->exec("create table if not exists transacoes
(id int not null auto_increment,
dono int,
data date not null,
nome varchar(99),
valor decimal(13,2),
dr int,
cr int,
constraint pk_transacao_id primary key (id),
constraint fk_transacao_usuario foreign key (dono)
  references usuarios (id),
constraint fk_transacao_dr foreign key (dr)
  references contas (id),
constraint fk_transacao_cr foreign key (cr)
  references contas (id)) engine=InnoDB");
        echo("Tabela de transações criada<br><br>");

        $dbh->exec("create table if not exists autologin
(id int not null auto_increment,
rand varchar(63),
dono int,
constraint pk_autologin_id primary key (id),
constraint fk_autologin_usuario foreign key (dono)
  references usuarios (id)) engine=InnoDB");
        echo("Tabela de autologin criada<br><br>");

        echo('<a href="index.php">Voltar a homepage</a>');
        

        
    } else {
        echo("Tabelas já existem");
    }
    
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
