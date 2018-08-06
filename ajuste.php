<?php
include('boot_guest.php');
include('header.php');

$tipo = $_GET['t'];
?>

<h1>Ajuste de <?= $tipo ?></h1>

<form action="ajustar.php" method="POST">
    <table class="table-sm">

        <tr>
            <td>
                <label for="conta">Conta</label>
            </td>
            <td>
                <select name="conta" id="conta">
                    
                </select>
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
