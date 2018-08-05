<?php
require("dbhost.php");

function insert_conta($dbh, $uid, $tipo, $sinal, $nome, $orcamento) {
    $insert_sql = $dbh->prepare("insert into contas (dono, tipo, sinal, nome, orcamento) values (:uid, :tipo, :sinal, :nome, :orcamento)");
    $insert_sql->execute([":uid" => $_SESSION['uid'],
                          ":tipo" => $tipo,
                          ":sinal" => $sinal,
                          ":nome" => $nome,
                          ":orcamento" => $orcamento]);
}

function update_conta($dbh, $uid, $conta_id, $novo_tipo, $novo_nome) {
    if ($novo_tipo == 'bens' || $novo_tipo == 'despesas') {
        $novo_sinal = 1;
    } else {
        $novo_sinal = -1;
    }

    try {
        $update_sql = $dbh->prepare("update contas set tipo = :tipo, sinal = :sinal, nome = :nome where dono = :uid and id = :conta_id");
        $update_sql->execute([":tipo" => $novo_tipo,
                              ":sinal" => $novo_sinal,
                              ":nome" => $novo_nome,
                              ":uid" => $uid,
                              ":conta_id" => $conta_id]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function delete_conta($dbh, $uid, $conta_id) {
    try {
        // get Contas apagadas or create it
        $find_contas_apagadas_sql = $dbh->prepare('select count(*) as ct from contas where dono = :uid and nome = "Contas apagadas"');
        $find_contas_apagadas_sql->execute([":uid" => $_SESSION['uid']]);
        $find_contas_apagadas_row = $find_contas_apagadas_sql->fetch();
        $found_contas_apagadas = $find_contas_apagadas_row['ct'];

        if ($found_contas_apagadas == 0) {
            insert_conta($dbh, $uid, "ajustes", -1, "Contas apagadas", 0);
        }

        // get id of Contas apagadas
        $contas_apagadas_id_sql = $dbh->prepare('select id from contas where dono = :uid and nome = "Contas apagadas"');
        $contas_apagadas_id_sql->execute([":uid" => $_SESSION['uid']]);
        $contas_apagadas_id_row = $contas_apagadas_id_sql->fetch();
        $contas_apagadas_id = $contas_apagadas_id_row['id'];        
                                            
        // move debits to Contas apagadas
        $update_debits_sql = $dbh->prepare("update transacoes set dr = :contas_apagadas_id where dono = :uid and dr = :conta_id");
        $update_debits_sql->execute([":contas_apagadas_id" => $contas_apagadas_id,
                                     ":uid" => $_SESSION['uid'],
                                     ":conta_id" => $conta_id]);
        
        // move credits to Contas apagadas
        $update_credits_sql = $dbh->prepare("update transacoes set cr = :contas_apagadas_id where dono = :uid and cr = :conta_id");
        $update_credits_sql->execute([":contas_apagadas_id" => $contas_apagadas_id,
                                      ":uid" => $_SESSION['uid'],
                                      ":conta_id" => $conta_id]);
            
        $delete_sql = $dbh->prepare("delete from contas where dono = :uid and id = :conta_id");
        $delete_sql->execute([":uid" => $uid,
                              ":conta_id" => $conta_id]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>
