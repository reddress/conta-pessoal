<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');
require('contas_util.php');
require('transacoes_util.php');

$conta_id = $_POST['id'];
$valor = $_POST['valor'];
$motivo = $_POST['motivo'];

// get current balance
$conta_trs = fetch_all_conta_transactions($dbh, $_SESSION['uid'], $conta_id);
$conta_sinal = sinal($dbh, $_SESSION['uid'], $conta_id);
$saldo_atual = balance($conta_id, $conta_sinal, $conta_trs);

$adj_valor = (float) $_POST['valor'] - $saldo_atual;

// get Ajustes conta or create it
$find_ajustes_sql = $dbh->prepare('select count(*) as ct from contas where dono = :uid and nome = "Ajustes"');
$find_ajustes_sql->execute([":uid" => $_SESSION['uid']]);
$find_ajustes_row = $find_ajustes_sql->fetch();
$found_ajustes = $find_ajustes_row['ct'];

if ($found_ajustes == 0) {
    insert_conta($dbh, $uid, "ajustes", -1, "Ajustes", 0);
}

// get id of Contas apagadas
$ajustes_id_sql = $dbh->prepare('select id from contas where dono = :uid and nome = "Ajustes"');
$ajustes_id_sql->execute([":uid" => $_SESSION['uid']]);
$ajustes_id_row = $ajustes_id_sql->fetch();
$ajustes_id = $ajustes_id_row['id'];        

$ajuste_motivo = "[Ajuste] " . $motivo;

if ($conta_sinal == 1) {
    insert_transacao($dbh, $_SESSION['uid'], date("Y-m-d"), $ajuste_motivo, $conta_sinal * $adj_valor, $conta_id, $ajustes_id);
} else {
    insert_transacao($dbh, $_SESSION['uid'], date("Y-m-d"), $ajuste_motivo, -1 * $conta_sinal * $adj_valor, $ajustes_id, $conta_id);
}
?>

<?php
header('Location: conta.php?id=' . $conta_id);
?>

<?php
include('footer.php');
?>
