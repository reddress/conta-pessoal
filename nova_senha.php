<?php
include("header.php");
include("login_util.php");
?>

<?php
if ($username != "anônimo") {
?>
    
<h1>Redefinir senha para <?= $username ?></h1>

<form action="redefinir_senha.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="senha_atual">Senha atual</label>
            </td>
            <td>
                <input name="senha_atual" id="senha_atual" type="password" autofocus>
            </td>
        </tr>

        <tr>
            <td>
                <label for="senha">Nova Senha</label>
            </td>
            <td>
                <input name="senha" id="senha" type="password">
            </td>
        </tr>

        <tr>
            <td>
                <label for="senha_repetir">Nova Senha (repetir)</label>
            </td>
            <td>
                <input name="senha_repetir" id="senha_repetir" type="password">
                <input name="nome" value="<?= $username ?>" type="hidden">
            </td>
        </tr>
        
    </table>

    <input type="submit" value="Enviar">
</form>

<?php
} else {
    header("Location: index.php");
}
?>

<?php
include("footer.php");
?>
