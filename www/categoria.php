<?php

use ClippingBlog\BLL\ArtigoBLL;
$regraArtigo = new ArtigoBLL();

$artigos = $regraArtigo->listar();

?>
<?php require( "header.php" ); ?>
<?php require( "menu-principal.php" ); ?>
    <div class="container" style="padding-top: 60px;">
        <div class="col-md-8">
            <?php foreach ($artigos as $artigo) : ?>
                <h2><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></h2>
                <div>
                    <label class="label label-default">PHP</label>
                    <label class="label label-default">Bootstrap</label>
                    &nbsp; <i class="fa fa-clock-o"></i> <?php echo $artigo->getDataStr(); ?>
                    <?php if (!isNullOrEmpty($artigo->getAutor())) : ?>
                        &nbsp; <i class="fa fa-user"></i> <?php echo $artigo->getAutor(); ?>
                    <?php endif; ?>
                </div>
                <p><?php echo $artigo->getResumo(); ?></p>
                <hr />
            <?php endforeach; ?>
        </div>
        <?php require( "sidebar.php" ); ?>
    </div><!-- /.container -->
<?php require( "footer.php" ); ?>