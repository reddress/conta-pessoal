<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');
?>

<h1>Busca</h1>

<?php
if (isset($_GET['q'])) {
    $query = $_GET['q'];

    $trs_sql = $dbh->prepare(
        "select
t.id as id,
date_format(t.data, '%d/%m/%Y') as data,
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
t.nome like :q
order by data desc, id desc");
    $trs_sql->execute([":uid" => $_SESSION['uid'],
                       ":q" => '%' . $query . '%']);
?>

    <h3><?= $query ?></h3>

    <table>
        
        <?php
        foreach ($trs_sql as $row) {
        ?>

            <tr>
                <td><?= $row['data'] ?></td>
                <td><?= $row['nome'] ?></td>
                <td class="text-right"><?= $row['valor'] ?></td>
                <td><a href="conta.php?id=<?= $row['cr'] ?>"><?= $row['cr_nome'] ?></a></td>
                <td><a href="conta.php?id=<?= $row['dr'] ?>"><?= $row['dr_nome'] ?></a></td>
                <td><a href="editar_transacao.php?id=<?= $row['id'] ?>&redir=<?= urlencode("conta.php?id=" . $conta_id) ?>">editar/excluir</a></td>
            </tr>
            
<?php
    }
} else {
?>
        Digite uma palavra para buscar.<br><br>
        <a href="index.php">Voltar a homepage</a>
            
<?php
}
?>

    </table>

    <?php
include('footer.php');
?>
