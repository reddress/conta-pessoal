<?php
include('boot_guest.php');
include('header.php');
include('transacoes_util.php');
require('contas_util.php');

$id = $_GET['id'] ?? -1;

?>

<h1>Nova Receita</h1>
    
<form action="criar_transacao.php" method="POST">
    <table class="table-sm">
        
        <tr>
            <td>
                <label for="cr">De</label>
            </td>
            <td>
                <?= conta_nome($dbh, $_SESSION['uid'], $id) ?>
                <input name="cr" value="<?= $id ?>" type="hidden">
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="dr">Para</label>
            </td>
            <td>
                <select name="dr" id="dr" class="form-control" autofocus>
                    <option value="-1">Escolha uma conta</option>
                    <?= select_bens($dbh, $_SESSION['uid']) ?>
                </select>
            </td>
            <td>
                <a href="nova_conta.php?t=bens&redir=<?= urlencode("nova_receita.php?id=$id&redirect_nome=nova_transacao") ?>" tabindex="101">(nova)</a>
            </td>

        </tr>
        
        <tr>
            <td>
                <label for="nome">Descrição</label>
            </td>
            <td>
                <input name="nome" id="nome">
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="valor">Valor</label>
            </td>
            <td>
                <input name="valor" id="valor" type="number" step="0.01">
            </td>
        </tr>

        <tr>
            <td>
                <label for="data">Data</label>
            </td>
            <td>
                <input name="data" id="data" value="<?= date('d/m/Y') ?>">
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
include("data_footer.php");
?>
