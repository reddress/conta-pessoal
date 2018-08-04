<?php
include("header.php");
?>

<h1>Redefinir senha</h1>

<form action="redefinir_senha.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="senha_atual">Senha atual</label>
            </td>
            <td>
                <input name="senha_atual" id="senha_atual" type="password">
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
            </td>
        </tr>
        
    </table>

    <input type="submit" value="Enviar">
</form>

<?php
include("footer.php");
?>
