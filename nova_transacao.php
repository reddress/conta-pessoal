<?php
include('boot_guest.php');
include('header.php');
include('transacoes_util.php');

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
    De <?= $cr ?> para <?= $dr ?>
    
<form action="criar_transacao.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="nome">Nome</label>
            </td>
            <td>
                <input name="nome" id="nome" autofocus>
                <input name="tipo" value="<?= $tipo ?>" type="hidden">
                <input name="redir" value="nova_conta" type="hidden">
                <input name="q" value="?t=<?= $tipo ?>" type="hidden">
            </td>
        </tr>

        <?php
        if ($tipo == "despesas") {
        ?>
            
        <tr>
            <td>
                <label for="orcamento">Orçamento</label>
            </td>
            <td>
                <input name="orcamento" id="orcamento" type="number" step="0.01">
            </td>
        </tr>

        <?php
        } else if ($tipo == "credito") {
        ?>
        
        <tr>
            <td>
                <label for="orcamento">Limite</label>
            </td>
            <td>
                <input name="orcamento" id="orcamento" type="number" step="0.01">
            </td>
        </tr>

        <?php
        }
        ?>
        
    </table>

    <input type="submit" value="Enviar">
</form>

<?php
    include('footer.php');
?>
