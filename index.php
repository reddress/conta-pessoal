<?php
include("header.php");
require("login_util.php");
?>

<h1>Cabra</h1>

<hr>
<?php if ($username == "anônimo") { ?>
    <h3>Usuário novo? <a href="cadastro.php">Cadastre-se aqui</a></h3>
    <hr>

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

<?php } else { ?>
    Bem-vindo(a) <?= $username ?>
    SHOW SUMMARY
<?php } ?>
    
<?php
include("footer.php");
?>
