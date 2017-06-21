<?php

use ClippingBlog\BLL\ArtigoBLL;
$regraArtigo = new ArtigoBLL();

$pg = intval($_GET['pg']);
if ($pg < 1) $pg = 1;

$retorno = $regraArtigo->listarPaginado(0, $pg, MAX_PAGE_COUNT);
$paginacao = admin_pagination(ceil($retorno->getTotal() / MAX_PAGE_COUNT));

?>
<?php require( "header.php" ); ?>
<?php require( "menu-principal.php" ); ?>
    <div class="container" style="padding-top: 60px;">
        <div class="col-md-8">
            <?php foreach ($retorno->getArtigos() as $artigo) : ?>
                <h2><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></h2>
                <div>
                    <?php foreach ($artigo->listarTags() as $tag) : ?>
                        <a href="<?php echo get_tema_path() . "/tag/" . $tag; ?>">
                            <span class="badge badge-info"><?php echo $tag; ?></span>
                        </a>
                    <?php endforeach; ?>
                    &nbsp; <i class="fa fa-clock-o"></i> <?php echo $artigo->getDataStr(); ?>
                    <?php if (!isNullOrEmpty($artigo->getAutor())) : ?>
                        &nbsp; <i class="fa fa-user"></i> <?php echo $artigo->getAutor(); ?>
                    <?php endif; ?>
                </div>
                <p><?php echo $artigo->getResumo(); ?></p>
                <hr />
            <?php endforeach; ?>
            <div class="text-center">
                <?php echo $paginacao; ?>
            </div>
        </div>
        <?php require( "sidebar.php" ); ?>
    </div><!-- /.container -->
<?php require( "footer.php" ); ?>