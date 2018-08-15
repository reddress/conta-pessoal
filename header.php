<?php
if (!isset($_SESSION['uid'])) {
    session_start();
}
ob_start();  // needed for header('Location: ...') to work
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Contabilidade Pessoal</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/picka/default.css">
        <link rel="stylesheet" href="css/picka/default.date.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="index.php">ContaPessoal</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item active">
                        <form action="busca.php" method="GET" class="form-inline my-2 my-lg-0">
                            <input name="q" class="form-control input-sm" type="search" placeholder="Busca" aria-label="Busca">
                        </form>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="tipo_de_conta.php?t=bens">Bens</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tipo_de_conta.php?t=despesas">Nova despesa</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tipo_de_conta.php?t=receitas">Nova receita</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tipo_de_conta.php?t=credito">Novo pagto. de cartão</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownContas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Saldos e Contas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownContas">
                            <a class="dropdown-item" href="nova_conta.php">Nova conta</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=bens">Bens</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=despesas">Despesas</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=receitas">Receitas</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=credito">Crédito</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=ajustes">Ajustes</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTransferencias" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transferências
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownTransferencias">
                            <a class="dropdown-item" href="nova_transacao.php?dr=bens&cr=bens&t=tr_bens">Transferência entre bens</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=credito&cr=credito&t=tr_cartoes">Transferência entre cartões</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=tudo&cr=tudo&t=geral">Nova transação (geral)</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCartoes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cartões
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCartoes">
                            <a class="dropdown-item" href="nova_transacao.php?dr=credito&cr=bens&t=pagamento_fatura">Pagamento de fatura</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=bens&cr=credito&t=emprestimo_do_cartao">Empréstimo do cartão</a>
                        </div>
                    </li>

                    <?php
                    if (isset($_SESSION['uid'])) {
                    ?>
                        
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDespesas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Despesas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownDespesas">
                            <a class="dropdown-item" href="nova_transacao.php?dr=despesas&cr=bens&t=pagto_a_vista">Pagamento à vista</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=despesas&cr=credito&t=pagto_com_cartao">Pagamento com cartão de crédito</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=despesas&cr=tudo&t=outra_despesa">Outra despesa</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=bens&cr=despesas&t=reemb_a_vista">Reembolso à vista</a>
                            <a class="dropdown-item" href="nova_transacao.php?dr=credito&cr=despesas&t=reemb_no_cartao">Reembolso no cartão</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="nova_senha.php">Mudar senha</a>
                    </li>

                    <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="fazer_logout.php">Logout</a>
                    </li>

                </ul>
            </div>
        </nav>

        <div class="container ml-3 pl-0">
