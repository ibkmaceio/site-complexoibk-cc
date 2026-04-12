<div class="col-sm-12 text-center">
    <?php
    /**
    * SEGUNDA PARTE DA PAGINAÇÃO
    */
    //SQL para saber o total
    $sqlTotal   = "SELECT id FROM _newsletter ORDER BY id DESC ";
    //Executa o SQL
    $qrTotal    = mysql_query($sqlTotal) or die(mysql_error());
    //Total de Registro na tabela
    $numTotal   = mysql_num_rows($qrTotal);
    //O calculo do Total de página ser exibido
    $totalPagina= ceil($numTotal/$quantidade);
    /**
    * Defini o valor máximo a ser exibida na página tanto para direita quando para esquerda
    */
    $exibir = 10;
    /**
    * Aqui montará o link que voltará uma pagina
    * Caso o valor seja zero, por padrão ficará o valor 1
    */
    $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
    /**
    * Aqui montará o link que ir para proxima pagina
    * Caso pagina +1 for maior ou igual ao total, ele terá o valor do total
    * caso contrario, ele pegar o valor da página + 1
    */
    $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
    /**
    * Agora monta o Link paar Primeira Página
    * Depois O link para voltar uma página
    */
    /**
    * Agora monta o Link para Próxima Página
    * Depois O link para Última Página
    */
    ?>
    <div id="navegacao">
        <?php
            echo '<a href="modulos/newsletter/index.php?pagina=1">Primeira Página</a> ';
            echo "<a class='btn btn-xs btn-warning' href=\"modulos/newsletter/index.php?pagina=$anterior\"><i class='fa fa-arrow-left'></i></a> ";
        ?>
        <?php
            /**
            * O loop para exibir os valores à esquerda
            */
            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                    echo '<a class="btn btn-xs btn-default marginTotal" href="modulos/newsletter/index.php?pagina='.$i.'"> '.$i.' </a>';
            }

            echo '<a class="btn btn-xs btn-success marginTotal" href="modulos/newsletter/index.php?pagina='.$pagina.'"><strong>'.$pagina.'</strong></a>';

            for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                    echo '<a class="btn btn-xs btn-default marginTotal" href="modulos/newsletter/index.php?pagina='.$i.'"> '.$i.' </a>';
            }

            /**
            * Depois o link da página atual
            */
            /**
            * O loop para exibir os valores à direita
            */

            ?>
            <?php echo " <a class='btn btn-xs btn-warning' href=\"modulos/newsletter/index.php?pagina=$posterior\"><i class='fa fa-arrow-right'></i></a> ";
            echo "  <a href=\"modulos/newsletter/index.php?pagina=$totalPagina\">Última Página</a>";
        ?>
    </div>
</div>