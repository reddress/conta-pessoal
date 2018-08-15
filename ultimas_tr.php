<?php
include('boot_guest.php');
include('header.php');
include('dbhost.php');

$limit = 30;
?>

<h1>Últimas <?= $limit ?> Transações</h1>

<?php
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
where t.dono = :uid
order by data desc, id desc");
$trs_sql->execute([":uid" => $_SESSION['uid']]);
?>

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
            <td><a href="editar_transacao.php?id=<?= $row['id'] ?>&redir=ultimas_tr.php">(editar)</a></td>
        </tr>
        
    <?php
    }
    ?>
</table>

<?php
include('footer.php');
?>
