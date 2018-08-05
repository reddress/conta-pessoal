<?php
include("boot_guest.php");
include("header.php");
?>

<?php
require("dbhost.php");
require("transacoes_util.php");

try {
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $dr_id = $_POST['dr'];
    $cr_id = $_POST['cr'];
    $data = $_POST['data'];
    
    $errors = "";

    if (trim($nome) == "") {
        $errors .= 'Descrição não deve estar em branco.<br>';
    }

    if (trim($valor) == "") {
        $errors .= 'Valor não deve estar em branco.<br>';
    }

    if (trim($data) == "") {
        $errors .= 'Data não deve estar em branco.<br>';
    }

    if ($errors != "") {
        exit('<a href="javascript: history.back()">Tente novamente.</a>');
    }
    
    $insert_sql = $dbh->prepare("insert into contas (dono, tipo, sinal, nome, orcamento) values (:uid, :tipo, :sinal, :nome, :orcamento)");

    /*
    $insert_sql->execute([":uid" => $_SESSION['uid'],
                          ":tipo" => $tipo,
                          ":sinal" => $sinal,
                          ":nome" => $nome,
                          ":orcamento" => $orcamento]);
    */

    // redirect to same type of form
    $redirect = "nova_transacao";
    
    if (isset($_POST['form_dr'])) {
        $form_dr = $_POST['form_dr'];
    } else {
        $form_dr = "tudo";
    }

    if (isset($_POST['form_cr'])) {
        $form_cr = $_POST['form_cr'];
    } else {
        $form_cr = "tudo";
    }

    if (isset($_POST['form_t'])) {
        $form_t = $_POST['form_t'];
    } else {
        $form_t = "geral";
    }
?>

<h3>Transação <?= $nome ?> criada.</h3>
<h3><a href="<?= $redirect ?>.php?dr=<?= $form_dr ?>&cr=<?= $form_cr ?>&t=<?= $form_t ?>">Nova transação <?= $TR_NOMES[$form_t] ?></a></h3>
<h3><a href="index.php">Voltar a homepage</a>
<?php
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
