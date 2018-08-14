<?php
include('boot_guest.php');
include('header.php');
require("transacoes_util.php");
require("contas_util.php");
require("formatters.php");

$conta_id = $_GET['id'];
?>

<h1>Ajuste de <?= conta_nome($dbh, $_SESSION['uid'], $conta_id) ?></h1>
<h3>Saldo atual: <?= red_black(balance_all_time($dbh, $_SESSION['uid'], $conta_id)) ?></h3>

<form action="ajustar.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="valor">Novo valor</label>
            </td>
            <td>
                <input name="valor" id="valor" type="number" step="0.01" autofocus>
                <input name="id" value="<?= $conta_id ?>" type="hidden">
            </td>
        </tr>

        <tr>
            <td>
                <label for="motivo">Motivo de ajuste</label>
            </td>
            <td>
                <input name="motivo" id="motivo">
            </td>
        </tr>

        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <input type="submit" value="Enviar">
            </td>
        </tr>
        
    </table>


</form>
    
<?php
include('footer.php');
?>
