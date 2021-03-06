<?php
include('boot_guest.php');
include('header.php');

if (isset($_GET['t'])) {
    $tipo = $_GET['t'];
} else {
    $tipo = "tudo";
}

// prioritize GET variable, else set to go back to this page
if (isset($_GET['redir'])) {
    $redir = $_GET['redir'];
} else {
    $redir = urlencode("nova_conta.php?t=$tipo");
}

if ($tipo != "tudo") {
    
?>

    <h1><a href="nova_conta.php">Nova conta</a> de <a href="tipo_de_conta.php?t=<?= $tipo ?>"><?= $tipo ?></a></h1>

<form action="criar_conta.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="nome">Nome</label>
            </td>
            <td>
                <input name="nome" id="nome" autofocus>
                <input name="tipo" value="<?= $tipo ?>" type="hidden">
                <input name="redir" value="<?= $redir ?>" type="hidden">
                <input name="redirect_nome" value="<?= $_GET['redirect_nome'] ?? "página anterior" ?>" type="hidden">
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
} else {

    if (isset($_GET['redir'])) {
        $redir = urlencode($_GET['redir']);
    } else {
        $redir = "nova_conta.php";
    }

?>
    <h1>Nova conta</h1>
    <br>
    
    <a href="nova_conta.php?t=bens&redir=<?= $redir ?>">Bens</a><br><br>
    <a href="nova_conta.php?t=despesas&redir=<?= $redir ?>">Despesas</a><br><br>
    <a href="nova_conta.php?t=receitas&redir=<?= $redir ?>">Receitas</a><br><br>
    <a href="nova_conta.php?t=credito&redir=<?= $redir ?>">Crédito</a><br><br>
    <a href="nova_conta.php?t=ajustes&redir=<?= $redir ?>">Ajustes</a><br><br>
    
<?php
}

include('footer.php');
?>
