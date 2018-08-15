<?php
include('boot_guest.php');
include('header.php');
include('constants.php');
include('dbhost.php');

$query_sql = $dbh->prepare("select nome, tipo from contas where dono = :uid and id = :id");
$query_sql->execute([":uid" => $_SESSION['uid'],
                     ":id" => $_GET['id']]);
$conta_nome_row = $query_sql->fetch();

$nome_atual = $conta_nome_row['nome'];
$tipo_atual = $conta_nome_row['tipo'];

?>

<h1>Editar conta <?= $nome_atual ?></h1>

<form action="exec_editar_conta.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="tipo">Tipo</label>
            </td>
            <td>
                <select name="tipo" id="tipo">
                <?php
                    foreach ($TIPOS as $t) {
                ?>
                    <option value="<?= $t ?>" <?php if ($t == $tipo_atual) { ?>selected<?php } ?>><?= $t ?></option>
                <?php
                }
                ?>
                </select>
                <input name="conta_id" value="<?= $_GET['id'] ?>" type="hidden">
        <tr>
            <td>
                <label for="nome">Novo nome</label>
            </td>
            <td>
                <input name="nome" id="nome" value="<?= $nome_atual ?>" autofocus>
            </td>
        </tr>

        <?php
        if ($tipo_atual == "despesas") {
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
        } else if ($tipo_atual == "credito") {
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
include('footer.php');
?>
