<?php
require("dbhost.php");

$TR_NOMES = [
    "geral" => "Geral",
    
    "pagto_a_vista" => "Pagamento à vista",
    "pagto_com_cartao" => "Pagamento com cartão de crédito",
    "outra_despesa" => "Outra despesa",

    "receitas" => "Receita",

    "pagamento_fatura" => "Pagamento de fatura",
    "emprestimo_do_cartao" => "Empréstimo do cartão",

    "tr_bens" => "Transferência entre bens",
    "tr_cartoes" => "Transferência entre cartões",

    "reemb_a_vista" => "Reembolso à vista",
    "reemb_no_cartao" => "Reembolso no cartão",

    "ajustar_bens" => "Ajustar saldo de bens",
    "ajustar_cartao" => "Ajustar saldo de cartão",
    "outro_ajuste" => "Outro ajuste",    
];

function select_contas($dbh, $uid, $tipo) {
    if ($tipo == "tudo") {
        $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid order by nome");
        $select_sql->execute([":uid" => $uid]);
    } else {
        $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = :tipo order by nome");
        $select_sql->execute([":uid" => $uid,
                               ":tipo" => $tipo]);
    }
    $options = "";
    foreach ($select_sql as $row) {
        $options .= "<option value=\"{$row['id']}\">{$row['nome']}</option>\n";
    }
    
    return $options;
}

function select_bens_credito($dbh, $uid) {
    $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid and (tipo = 'bens' or tipo = 'credito') order by nome");
    $select_sql->execute([":uid" => $uid]);

    $options = "";
    foreach ($select_sql as $row) {
        $options .= "<option value=\"{$row['id']}\">{$row['nome']}</option>\n";
    }
    
    return $options;
}

function select_receitas($dbh, $uid) {
    $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = 'receitas' order by nome");
    $select_sql->execute([":uid" => $uid]);

    $options = "";
    foreach ($select_sql as $row) {
        $options .= "<option value=\"{$row['id']}\">{$row['nome']}</option>\n";
    }
    
    return $options;
}

function select_bens($dbh, $uid) {
    $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = 'bens' order by nome");
    $select_sql->execute([":uid" => $uid]);

    $options = "";
    foreach ($select_sql as $row) {
        $options .= "<option value=\"{$row['id']}\">{$row['nome']}</option>\n";
    }
    
    return $options;
}


function select_contas_with_selected($dbh, $uid, $tipo, $selected_id) {
    // copy of select_contas
    
    if ($tipo == "tudo") {
        $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid order by nome");
        $select_sql->execute([":uid" => $uid]);
    } else {
        $select_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = :tipo order by nome");
        $select_sql->execute([":uid" => $uid,
                               ":tipo" => $tipo]);
    }
    $options = "";
    foreach ($select_sql as $row) {
        if ($row['id'] == $selected_id) {
            $selected = " selected";
        } else {
            $selected = "";
        }
        $options .= "<option value=\"{$row['id']}\"$selected>{$row['nome']}</option>\n";
    }
    
    return $options;
}


function insert_transacao($dbh, $uid, $data, $nome, $valor, $dr_id, $cr_id) {
    $insert_sql = $dbh->prepare("insert into transacoes (dono, data, nome, valor, dr, cr) values (:uid, :data, :nome, :valor, :dr, :cr)");
    
    $insert_sql->execute([":uid" => $uid,
                          ":data" => $data,
                          ":nome" => $nome,
                          ":valor" => $valor,
                          ":dr" => $dr_id,
                          ":cr" => $cr_id]);
}

function delete_transacao($dbh, $uid, $tr_id) {
    try {
        $delete_sql = $dbh->prepare("delete from transacoes where dono = :uid and id = :tr_id");
        $delete_sql->execute([":uid" => $uid,
                              ":tr_id" => $tr_id]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

?>
