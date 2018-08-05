<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');

if (isset($_GET['id'])) {
    $conta_id = $_GET['id'];

    $query_sql = $dbh->prepare("select nome from contas where id = :id");
    $query_sql->execute([":id" => $conta_id]);
    $query_row = $query_sql->fetch();

    $conta_nome = $query_row['nome'];
?>

<?php
$query_sql = $dbh->prepare("select id, tipo, nome, orcamento from contas where dono = :uid and id = :conta_id");
$query_sql->execute([":uid" => $_SESSION['uid'], ":conta_id" => $conta_id]);
$query_row = $query_sql->fetch();
$tipo = $query_row['tipo'];
$orcamento = $query_row['orcamento'];
?>

    <h1>
        <a href="tipo_de_conta.php?t=<?= $tipo ?>"><?= $tipo ?></a><br>
        Conta: <?= $conta_nome ?>
        <br>
    </h1>

    <h3><a href="editar_conta.php?id=<?= $conta_id ?>">Editar tipo e nome</a></h3>

    <h3><a href="confirmar_excluir_conta.php?id=<?= $conta_id ?>">Excluir conta</a></h3>

<?php
if ($tipo == "despesas") {
    echo("Orçamento: $orcamento");
} else if ($tipo == "credito") {
    echo("Limite: $orcamento");
}
?>

LIST/TABLE PAGINATE TRANSACTIONS

<?php
} else {
?>
    
    <h1>Contas</h1>

    LIST EVERY CONTA WITH SALDO OR MONTHLY TOTAL
    <br><br>
    
    <a href="tipo_de_conta.php?t=bens">Bens</a>
    <br><br>
    
    <a href="tipo_de_conta.php?t=despesas">Despesas</a>
    <br><br>
    
    <a href="tipo_de_conta.php?t=receitas">Receitas</a>
    <br><br>
    
    <a href="tipo_de_conta.php?t=credito">Crédito</a>
    <br><br>
    
    <a href="tipo_de_conta.php?t=ajustes">Ajustes</a>
    <br><br>
    
<?php
}

include('footer.php');
?>
