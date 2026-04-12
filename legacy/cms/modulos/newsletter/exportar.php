<?php
ini_set('default_charset', 'UTF-8');

@session_start();
include ($_SERVER['DOCUMENT_ROOT']."/cms/config/config.php");
include ($_SERVER['DOCUMENT_ROOT']."/cms/config/classeSGBD.php");
include ($_SERVER['DOCUMENT_ROOT']."/cms/config/classeDb.php");
include ($_SERVER['DOCUMENT_ROOT']."/cms/config/data.php");

// CONECTAR NO BANCO DE DADOS DA ROTA
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

//Obtem a data atual, no formato dd/mm/aaaa
$dataAtual = date("d/m/Y");

//Define o nome do arquivo que serÃ¡ exportado
$arquivoRelatorio = 'Relatorio_Emails_'. $dataAtual . '.xls';

header("Content-type: application/ms-excel; charset=utf-8");
header("Content-Type: text/html; charset=UTF-8");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$arquivoRelatorio");
header("Pragma: no-cache");

$sql  = "SELECT * FROM _newsletter";
$bd->consulta($sql);
$linhas = $bd->getRows();
$bd->first();


?>

<table border="1" align="center">
    <tr>
        <td>
            Relat&oacute;rio de Emails
        </td>
    </tr>

    <tr>
        <td>
            Data de Cria&ccedil;&atilde;o
        </td>
        <td>
            <?php echo $dataAtual; ?>
        </td>
    </tr>

    <tr>
        <td>
            &nbsp;
        </td>
    </tr>

    <tr>
        <td align="center">
            <strong>Email</strong>
        </td>
    </tr>
    <?php
    for($contador = 1; $contador <= $linhas; $contador++) {
        //INICIO DA TABELA
        $dados = $bd->getDados();

        echo "<tr>";

        echo "<td align='center'>";
        echo utf8_decode($dados['email']);
        echo "</td>";

        //FINALZIA A LINHA
        echo "</tr>";

        //PROXIMO RESULTADO
        $bd->next();
    }
    ?>
</table>