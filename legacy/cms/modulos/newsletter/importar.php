<?php

include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/config.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeSGBD.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/classeDb.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/data.php");
include ($_SERVER['DOCUMENT_ROOT'].$baseURL."/cms/config/function.php");

// CONECTAR NO BANCO DE DADOS DA ROTA
$bco = new sgbd("$BANCO", "$HOST", "$BDUSER", "$BDPASS");
$bd = new db("$DB", $bco->value());

?>
<body>
    <div id="container">
        <div id="form">

            <?php
                if (isset($_POST['submit'])) {
                    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
                        echo "<h1>" . "File ". $_FILES['filename']['name'] ." transferido com sucesso ." . "</h1>";
                        echo "<h2>Exibindo o conteúdo:</h2>";
                        readfile($_FILES['filename']['tmp_name']);
                    }
                    $handle = fopen($_FILES['filename']['tmp_name'], "r");

                    while (($data = fgetcsv($handle, 2048, ",")) !== FALSE) {
                        $import="INSERT INTO import (
                            title,
                            firstname,
                            middlename,
                            lastname,
                            suffix,
                            email,
                            data
                            ) VALUES (
                            '$data[0]',
                            '".$data[1] = addslashes($data[1])."',
                            '$data[2]',
                            '".$data[3] = addslashes($data[3])."',
                            '$data[4]',
                            '$data[5]',
                            CURRENT_TIMESTAMP
                            )";
                        mysql_query($import) or die(mysql_error());
                    }
                    fclose($handle);
                    print "Importação Feita.";
                } else {
                    print "Transferir novos arquivos CSV selecionando o arquivo e clicando no botão Upload<br />\n";
                    print "<form enctype='multipart/form-data' action='#' method='post'>";
                    print "Nome do arquivo para importar:<br />\n";
                    print "<input size='50' type='file' name='filename'><br />\n";
                    print "<input type='submit' name='submit' value='Upload'></form>";
                }

            ?>
        </div>
    </div>
</body>