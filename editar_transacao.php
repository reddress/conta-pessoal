<?php
include('boot_guest.php');
include('header.php');
include('constants.php');
include('dbhost.php');
include('transacoes_util.php');

$redir = $_GET['redir'] ?? "index.php";

$query_sql = $dbh->prepare("select data, nome, valor, dr, cr from transacoes where dono = :uid and id = :id");
$query_sql->execute([":uid" => $_SESSION['uid'],
                     ":id" => $_GET['id']]);

$tr_row = $query_sql->fetch();

$dr = "tudo";
$cr = "tudo";

$data_atual = $tr_row['data'];
$nome_atual = $tr_row['nome'];
$valor_atual = $tr_row['valor'];
$dr_atual = $tr_row['dr'];
$cr_atual = $tr_row['cr'];

$date_obj = date_create_from_format("Y-m-d", $data_atual);
$data_dmy = date_format($date_obj, "d/m/Y");

$tr_id = $_GET['id'];
?>

<h1>Editar transação <?= $nome_atual ?></h1>
<h3><a href="confirmar_excluir_transacao.php?id=<?= $tr_id ?>&redir=<?= urlencode($redir) ?>">Excluir transação</a></h3>

<form action="exec_editar_transacao.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="cr">De (conta)</label>
            </td>
            <td>
                <select name="cr" id="cr" class="form-control" autofocus>
                    <option value="-1"><?= $cr ?></option>
                    <?= select_contas_with_selected($dbh, $_SESSION['uid'], "tudo", $cr_atual) ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="dr">Para (conta)</label>
            </td>
            <td>
                <select name="dr" id="dr" class="form-control">
                    <option value="-1"><?= $dr ?></option>
                    <?= select_contas_with_selected($dbh, $_SESSION['uid'], "tudo", $dr_atual) ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="nome">Descrição</label>
            </td>
            <td>
                <input name="nome" id="nome" value="<?= $nome_atual ?>">
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="valor">Valor</label>
            </td>
            <td>
                <input name="valor" id="valor" type="number" step="0.01" value="<?= $valor_atual ?>">
            </td>
        </tr>

        <tr>
            <td>
                <label for="data">Data</label>
            </td>
            <td>
                <input name="data" id="data" value="<?= $data_dmy ?>">
                <input name="tr_id" value="<?= $_GET['id'] ?>" type="hidden">
                <input name="redir" value="<?= $_GET['redir'] ?>" type="hidden">
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
include('data_footer.php');
?>
