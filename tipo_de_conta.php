<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');

if (isset($_GET['t'])) {
    $tipo = $_GET['t'];
?>

<h1>Tipo de conta: <?= $tipo ?></h1>

<h3><a href="nova_conta.php?t=<?= $tipo ?>">Nova conta</h3>
    <br>
<?php
$query_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = :tipo");
$query_sql->execute([":uid" => $_SESSION['uid'], ":tipo" => $tipo]);

foreach($query_sql as $row) {
?>
    <a href="conta.php?id=<?= $row['id'] ?>"><?= $row['nome'] ?></a><br><br>
<?php
}
?>


<?php
} else {
?>
    <h1>Sumário de tipo de conta</h1>
    
    <a href="tipo_de_conta.php?t=bens">Bens</a><br><br>
    <a href="tipo_de_conta.php?t=despesas">Despesas</a><br><br>
    <a href="tipo_de_conta.php?t=receitas">Receitas</a><br><br>
    <a href="tipo_de_conta.php?t=credito">Crédito</a><br><br>
    <a href="tipo_de_conta.php?t=ajustes">Ajustes</a><br><br>
    
<?php
}

include('footer.php');
?>
