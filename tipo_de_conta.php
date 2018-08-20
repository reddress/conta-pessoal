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

    <h3><a href="nova_conta.php?t=<?= $tipo ?>">Nova conta</a></h3>

    <?php
    if ($tipo == "despesas" || $tipo == "receitas") {
        // display date endpoints
        $endpts = period_endpts(date('Y-m-d'));
        
        $left_date = $endpts[0];
        $right_date = $endpts[1];

        echo "Período de $left_date a $right_date<br>";
    }
    ?>
    
    <table class="table-sm">
        <?php
        $query_sql = $dbh->prepare("select id, nome from contas where dono = :uid and tipo = :tipo order by nome");
        $query_sql->execute([":uid" => $_SESSION['uid'], ":tipo" => $tipo]);

        $total = 0;
        
        foreach($query_sql as $row) {
            // monthly balance if despesas or receitas, else all-time
            if ($tipo == "despesas" || $tipo == "receitas") {
                $row_bal = balance_monthly($dbh, $_SESSION['uid'], $row['id']);
            } else {
                $row_bal = balance_all_time($dbh, $_SESSION['uid'], $row['id']);
            }
            $total += $row_bal;
        ?>
            <tr>
                <td><a href="conta.php?id=<?= $row['id'] ?>"><?= $row['nome'] ?></a></td>
                <td style="text-align: right;"><?= red_black($row_bal) ?></td>
                
                <?php
                    if ($tipo == "despesas") {
                ?>

                    <td><a class="btn btn-primary" href="nova_despesa.php?id=<?= $row['id'] ?>">+</a></td>
                    
                <?php
    } else if ($tipo == "receitas") {
                    
    ?>
                        
                    <td><a class="btn btn-primary" href="nova_receita.php?id=<?= $row['id'] ?>">+</a></td>

                <?php
                } else if ($tipo == "credito") {
                ?>
                    
                    <td><a class="btn btn-primary" href="novo_pagto_cartao.php?id=<?= $row['id'] ?>">+</a></td>
                    
                    <?php
                            }
                    ?>
            </tr>

<?php
}
?>
<tr>
    <td>Total</td>
    <td style="text-align: right; font-weight: bold;"><?= red_black($total) ?></td>
</tr>
    </table>

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
