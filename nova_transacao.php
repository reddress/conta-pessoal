<?php
include('boot_guest.php');
include('header.php');
include('transacoes_util.php');
require("dbhost.php");

if (isset($_GET['dr'])) {
    $dr = $_GET['dr'];
} else {
    $dr = "tudo";
}

if (isset($_GET['cr'])) {
    $cr = $_GET['cr'];
} else {
    $cr = "tudo";
}

if (isset($_GET['t'])) {
    $tipo = $_GET['t'];
} else {
    $tipo = "geral";
}

?>

<h1>Nova transação: <?= $TR_NOMES[$tipo] ?></h1>
<h3>De <?= $cr ?> para <?= $dr ?></h3>
    
<form action="criar_transacao.php" method="POST">
    <table class="table-sm">
        
        <tr>
            <td>
                <label for="cr">De (conta)</label>
            </td>
            <td>
                <select name="cr" id="cr" class="form-control" autofocus>
                    <option value="-1">Escolha uma conta</option>
                    <?= select_contas($dbh, $_SESSION['uid'], $cr) ?>
                </select>
            </td>
            <td>
                <a href="nova_conta.php?t=<?= $cr ?>&redir=<?= urlencode("nova_transacao.php?t=$tipo&cr=$cr&dr=$dr&redirect_nome=nova_transacao") ?>" tabindex="101">(nova)</a>
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="dr">Para (conta)</label>
            </td>
            <td>
                <select name="dr" id="dr" class="form-control">
                    <option value="-1">Escolha uma conta</option>
                    <?= select_contas($dbh, $_SESSION['uid'], $dr) ?>
                </select>
            </td>
            <td>
                <a href="nova_conta.php?t=<?= $dr ?>&redir=<?= urlencode("nova_transacao.php?t=$tipo&cr=$cr&dr=$dr&redirect_nome=nova_transacao") ?>" tabindex="102">(nova)</a>
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
                <input name="form_dr" value="<?= $_GET['dr'] ?>" type="hidden">
                <input name="form_cr" value="<?= $_GET['cr'] ?>" type="hidden">
                <input name="form_t" value="<?= $_GET['t'] ?>" type="hidden">
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
