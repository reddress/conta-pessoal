<?php
include('header.php');
?>

<h1>Cadastro</h1>

<form action="criar_cadastro.php" method="POST">
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
                <label for="senha_repetir">Senha (repetir)</label>
            </td>
            <td>
                <input name="senha_repetir" id="senha_repetir" type="password">
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
include('footer.php');
?>
