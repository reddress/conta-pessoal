<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');
require('contas_util.php');
require('formatters.php');

if (isset($_GET['t'])) {
    $tipo = $_GET['t'];
?>

    <h1><a href="tipo_de_conta.php">Tipo de conta</a>: <?= $tipo ?></h1>

<h3><a href="nova_conta.php?t=<?= $tipo ?>">Nova conta</h3>
    <br>
<?php
$query_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = :tipo order by nome");
$query_sql->execute([":uid" => $_SESSION['uid'], ":tipo" => $tipo]);

foreach($query_sql as $row) {
?>
    <a href="conta.php?id=<?= $row['id'] ?>"><?= $row['nome'] ?></a>
    <?= red_black(balance_all_time($dbh, $_SESSION['uid'], $row['id'])) ?>
    <?php
    if ($tipo == "despesas") {
    ?>

        <a class="btn btn-primary" href="nova_despesa.php?id=<?= $row['id'] ?>">Nova transação</a>
        
    <?php
    }
    ?>
    <br><br>
<?php
}
?>


<?php
} else {
?>
    <h1>Tipos de conta</h1>
    
    <a href="tipo_de_conta.php?t=bens">Bens</a><br><br>
    <a href="tipo_de_conta.php?t=despesas">Despesas</a><br><br>
    <a href="tipo_de_conta.php?t=receitas">Receitas</a><br><br>
    <a href="tipo_de_conta.php?t=credito">Crédito</a><br><br>
    <a href="tipo_de_conta.php?t=ajustes">Ajustes</a><br><br>
    
<?php
}

include('footer.php');
?>
