<?php
include("header.php");
?>

<h1>Superuser (redefinir senha de usuário)</h1>

<form action="redefinir_por_superuser.php" method="POST">
    <table class="table-sm">
        <tr>
            <td>
                <label for="nome">Nome de usuário</label>
            </td>
            <td>
                <input name="nome" id="nome" autofocus>
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
        
        <tr>
            <td>
                <label for="senha_superuser">Senha do Superuser</label>
            </td>
            <td>
                <input name="senha_superuser" id="senha_superuser" type="password">
            </td>
        </tr>
    </table>

    <input type="submit" value="Enviar">
</form>

<?php
include("footer.php");
?>
