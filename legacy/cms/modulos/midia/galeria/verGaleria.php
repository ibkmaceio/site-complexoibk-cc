<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



MIDIA > GALERIA



-->

<?php

$sql = "SELECT * FROM _midia WHERE id = '".$_GET['id']."'";
$bd->consulta($sql);
$bd->first();
$row = $bd->getRows();

for($i=1; $i<=$row; $i++){
$dados = $bd->getDados();

?>

<h3 class="uk-heading-line"><span>Galeria</span></h3>
<a href="modulos/midia/galeria/add.php?id=<?php echo $dados['id'];?>" title="Adicionar" class="uk-button uk-button-primary pull-right" uk-tooltip uk-icon="icon: plus"></a>
<a href="javascript:history.go(-1)" title="Voltar" class="uk-button uk-button-danger pull-right" uk-tooltip uk-icon="icon: chevron-left"></a>

<div class="clearfix"></div>

<div class="uk-background-muted uk-padding">
    <div class="row">

        <?php
        $sql = "SELECT * FROM _midia as ga INNER JOIN _midia_galeria
        as gi ON ga.id = gi.id_galeria_album
        WHERE ga.ativo = 'S' AND ga.id = '$_REQUEST[id]' ORDER BY gi.id DESC";
        $bd->consulta($sql);
        $bd->first();
        $row = $bd->getRows();

        for($i=1; $i<=$row; $i++){
        $dados = $bd->getDados();
        ?>
        <div class="col-sm-3 list_galeria" id="tr_<?php echo $dados['id'];?>">
            <div class="uk-text-center">
                <div class="uk-inline-clip uk-transition-toggle uk-light">
                    <?php echo "<img src='./timthumb.php?src=".$dados['caminho']."&w=224&h=200' class='img-responsive' />"; ?>
                    <div class="uk-position-center">
                        <a href="javascript:void();" data-id="<?php echo $dados['id'];?>" class="deletar uk-transition-fade" title="Excluir" uk-tooltip uk-icon="icon: trash; ratio: 2"></a>

                        <a class="uk-transition-fade" href="#modal-img-gallery-<?php echo $dados['id'];?>" uk-toggle title="Ampliar" uk-tooltip uk-icon="icon: plus; ratio: 2"></a>
                    </div>
                </div>
                <p class="uk-margin-small-top"></p>
            </div>
        </div>

        <div id="modal-img-gallery-<?php echo $dados['id'];?>" uk-modal="center: true">
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <?php echo "<img src='./timthumb.php?src=".$dados['caminho']."&w=1224&h=920' class='img-responsive' />"; ?>
            </div>
        </div>
        <?php $bd->next(); } ?>

    </div>
</div>

<?php } require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>

<script>

    function deletar(id){
        $.confirm({
            icon: 'fa fa-cog fa-spin',
            title: 'Excluir',
            content: 'Tem certeza que deseja excluir?',
            autoClose: 'cancelAction|6000',
            animation: 'zoom',
            closeAnimation: 'scale',
            type: 'red',
            typeAnimated: true,
            buttons: {
                deleteUser: {
                    text: 'Sim',
                    btnClass: 'btn-red',
                    action: function () {
                        $.ajax({
                            url: 'modulos/midia/galeria/excluir.php',
                            type: 'POST',
                            data:{
                                id: id
                            },
                            success: function(response)
                            {
                                if(!response.error){
                                    $('#tr_'+id).fadeOut('slow');
                                    UIkit.notification({
                                        message: '<span uk-icon="icon: check"></span> Excluído com sucesso!',
                                        status: 'success',
                                        pos: 'top-center',
                                        timeout: 5000
                                    });
                                }else{
                                    UIkit.notification({
                                        message: '<span uk-icon="icon: close"></span> Erro ao excluir. Tente novamente!',
                                        status: 'danger',
                                        pos: 'top-center',
                                        timeout: 5000
                                    });
                                }
                            },
                            error: function(xhr)
                            {
                                alert(xhr.responseText);
                            }
                        });
                    }
                },
                cancelAction: function () {
                    UIkit.notification({
                        message: '<span uk-icon="icon: warning"></span> Ação cancelada!',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }
            }
        });

    }

    $(function(){
        $(document).on('click','.deletar',function(){
            deletar($(this).data('id'));
            return false;
        });
    });

</script>