<?php
include('boot_guest.php');
include('header.php');

if (isset($_GET['t'])) {
    $tipo = $_GET['t'];
?>

    <h1>Nova conta de <a href="tipo_de_conta.php?t=<?= $tipo ?>"><?= $tipo ?></a></h1>

<form action="criar_conta.php" method="POST">
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
} else {
?>
    <h1>Nova conta</h1>
    <br>
    
    <a href="nova_conta.php?t=bens">Bens</a><br><br>
    <a href="nova_conta.php?t=despesas">Despesas</a><br><br>
    <a href="nova_conta.php?t=receitas">Receitas</a><br><br>
    <a href="nova_conta.php?t=credito">Crédito</a><br><br>
    <a href="nova_conta.php?t=ajustes">Ajustes</a><br><br>
    
<?php
}

include('footer.php');
?>
