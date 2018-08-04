<?php
include("header.php");
?>

<h1>Login</h1>

<form action="fazer_login.php" method="POST">
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
                <label for="senha">Senha</label>
            </td>
            <td>
                <input name="senha" id="senha" type="password">
            </td>
        </tr>
    </table>

    <input type="submit" value="Enviar">
</form>

<?php
include("footer.php");
?>
