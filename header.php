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
        <title>Cabra</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Busca" aria-label="Busca">
            </form>

            <a class="navbar-brand" href="index.php">Cabra</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <!-- 
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Últimas transações</a>
                    </li>
                    -->
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownContas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerenciar contas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownContas">
                            <a class="dropdown-item" href="tipo_de_conta.php?t=bens" "Bens">Bens</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=despesas" "Despesas">Despesas</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=receitas" "Receitas">Receitas</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=credito" "Credito">Crédito</a>
                            <a class="dropdown-item" href="tipo_de_conta.php?t=ajustes" "Ajustes">Ajustes</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDespesas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Despesas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownDespesas">
                            <a class="dropdown-item" href="#">Pago à vista</a>
                            <a class="dropdown-item" href="#" "pagamento_a_credito" "Despesas" "Credito">Pago com cartão de crédito</a>
                            <a class="dropdown-item" href="#" "outra_despesa" "Despesas" "Todos">Outra despesa</a>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="#" "receita" "Bens" "Receitas">Receita</a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCartoes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cartões
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCartoes">
                            <a class="dropdown-item" href="#" "pagamento_de_fatura" "Credito" "Bens">Pagamento de fatura</a>
                            <a class="dropdown-item" href="#" "emprestimo_de_cartao" "Bens" "Credito">Empréstimo do cartão</a>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTransferencias" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transferências
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownTransferencias">
                            <a class="dropdown-item" href="#" "transferencia_entre_bens" "Bens" "Bens">Transferência entre bens</a>
                            <a class="dropdown-item" href="#" "transferencia_entre_cartoes" "Credito" "Credito">Transferência entre cartões</a>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownReembolsos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reembolsos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownReembolsos">
                            <a class="dropdown-item" href="#">Reembolso à vista</a>
                            <a class="dropdown-item" href="#">Reembolso no cartão</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAjustes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ajustes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownAjustes">
                            <a class="dropdown-item" href="#">Ajustar saldo de bens</a>
                            <a class="dropdown-item" href="#">Ajustar saldo de cartão</a>
                            <a class="dropdown-item" href="#">Outro ajuste</a>
                        </div>
                    </li>

                    <?php
                    if (isset($_SESSION['uid'])) {
                    ?>
                        
                    <li class="nav-item active">
                        <a class="nav-link" href="nova_senha.php">Mudar senha</a>
                    </li>
                    
                    <li class="nav-item active">
                        <a class="nav-link" href="fazer_logout.php">Logout</a>
                    </li>
                    
                    <?php
                    }
                    ?>

                </ul>
            </div>
        </nav>

        <div class="container">
