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

function contas_links($dbh, $uid) {
    $query_sql = $dbh->prepare("select id, nome from contas where dono = :uid");
    $query_sql->execute([":uid" => $_SESSION['uid']]);

    $out = "";
    foreach ($query_sql as $row) {
        $balance = sprintf("%0.2f", balance_all_time($dbh, $uid, $row['id']));
        $out .= "<a href=\"conta.php?id={$row['id']}\">{$row['nome']}</a> $balance<br><br>";
    }
    return $out;
}

function balance($conta_id, $sinal, $trs) {
    $bal = 0;
    $sign = (int) $sinal;
    foreach ($trs as $tr) {
        if ($tr['dr'] == $conta_id) {
            $bal += $sign * ((float) $tr['valor']);
        }

        if ($tr['cr'] == $conta_id) {
            $bal -= $sign * ((float) $tr['valor']);
        }
    }
    return sprintf('%0.2f', (float) $bal);
}

function sinal($dbh, $uid, $conta_id) {
    $sql = $dbh->prepare("select sinal from contas where dono = :uid and id = :conta_id");
    $sql->execute([":uid" => $uid,
                   ":conta_id" => $conta_id]);
    $row = $sql->fetch();
    return (int) $row['sinal'];
}

function conta_nome($dbh, $uid, $conta_id) {
    $sql = $dbh->prepare("select nome from contas where dono = :uid and id = :conta_id");
    $sql->execute([":uid" => $uid,
                   ":conta_id" => $conta_id]);
    $row = $sql->fetch();
    return $row['nome'];
}

function fetch_all_conta_transactions($dbh, $uid, $conta_id) {
    $trs_sql = $dbh->prepare(
        "select
t.id as id,
date_format(t.data, '%d/%m') as data,
t.nome as nome,
valor,
cr,
dr,
c.nome as cr_nome,
d.nome as dr_nome
from transacoes t
inner join contas c on c.id = t.cr
inner join contas d on d.id = t.dr
where t.dono = :uid and
(dr = :dr_id or cr = :cr_id)
order by data desc, id desc");
    $trs_sql->execute([":uid" => $uid,
                       ":cr_id" => $conta_id,
                       ":dr_id" => $conta_id]);
    return $trs_sql->fetchAll();
}

function balance_all_time($dbh, $uid, $conta_id) {
    $debits_sql = $dbh->prepare("select
sum(t.valor) * c.sinal as total from contas c
inner join transacoes t on c.id = t.dr
where t.dono = :uid and c.id = :conta_id
group by c.id, c.sinal");
    $debits_sql->execute([":uid" => $uid,
                         ":conta_id" => $conta_id]);
    $debits_row = $debits_sql->fetch();
    $debits_total = (float) $debits_row['total'];
    
    $credits_sql = $dbh->prepare("select
sum(t.valor) * c.sinal as total from contas c
inner join transacoes t on c.id = t.cr
where t.dono = :uid and c.id = :conta_id
group by c.id, c.sinal");
    $credits_sql->execute([":uid" => $uid,
                           ":conta_id" => $conta_id]);
    $credits_row = $credits_sql->fetch();
    $credits_total = (float) $credits_row['total'];

    return $debits_total - $credits_total;
}
?>
