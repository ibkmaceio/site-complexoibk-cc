<?php

require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php");

$id = isset($_POST['id']) ? $_POST['id'] : '';
mysql_query("DELETE FROM _midia WHERE id ='".$id."'");

require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php");

?>