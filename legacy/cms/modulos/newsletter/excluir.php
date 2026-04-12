<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php");

$sql = "SELECT * FROM newsletter WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($sql);
$bd->first();
$row = $bd->getRows();

for($i=1; $i<=$row; $i++){
	$dados = $bd->getDados();

	if(@$_POST['escolha'] == 'excluir'){

		$sql = "DELETE FROM newsletter WHERE id = '".$_REQUEST['id']."' ";
		if($bd->consulta($sql)){
			echo "<script type='text/javascript'>alert('Excluido com sucesso!'); window.location.href='javascript:history.go(-2);';</script>";
		}else{
			echo "<script type='text/javascript'>alert('Erro na exclusao.');</script>";
		}
	}
?>

<div class="overlay">
	<div class="interno text-center">
		<form action="" method="post">
			<h3 class="dosis bold700">CONFIRMAÇÃO</h3>
			<p>Deseja realmente excluir esse registro?</p>
			<input type="hidden" name="id" value="<?php echo $dados['id'];?>">
			<button class="btn btn-danger btn-sm" name="escolha" value="excluir">Sim</button>
			<a href="javascript:history.back();" class="btn btn-success btn-sm">Não</a>
		</form>
	</div>
</div>

<?php $bd->next(); } ?>

<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>
