<?php

use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\BLL\App;

$regraArtigo = new ArtigoBLL();
$artigo = $regraArtigo->pegarPorSlug( App::getSlug() );
App::setArtigo( $artigo );

//var_dump(SLUG, $artigo);

?>
<?php require( "header.php" ); ?>
<?php require( "menu-principal.php" ); ?>
    <div class="container" style="padding-top: 60px;">
        <form class="form-horizontal" method="POST">
        <div class="col-md-8">
            <h1 id="artigo-titulo"><?php echo $artigo->getTitulo(); ?></h1>
            <div class="form-group">
                <label class="col-md-2 control-label text-right">
                    <i class="fa fa-tags"></i> Tags:
                </label>
                <div id="artigo-tags" class="col-md-10">
                    <div class="form-span">
                        <?php foreach ($artigo->listarTags() as $tag) : ?>
                            <a href="<?php echo get_tema_path() . "/tag/" . $tag; ?>">
                                <span class="badge badge-info"><?php echo $tag; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-right">
                    <i class="fa fa-clock-o"></i> Publicado:
                </label>
                <div id="artigo-data" class="col-md-4">
                    <div class="form-span">
                        <?php echo $artigo->getDataStr(); ?>
                    </div>
                </div>
                <label class="col-md-2 control-label text-right">
                    &nbsp; <i class="fa fa-user"></i> Autor:
                </label>
                <div id="artigo-autor" class="col-md-4">
                    <div class="form-span">
                        <?php echo $artigo->getAutor(); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr />
            <div id="artigo-texto">
                <?php echo $artigo->getTexto(); ?>
            </div>
            <hr />
        </div>
        </form>
        <?php require( "sidebar.php" ); ?>
    </div><!-- /.container -->
<?php require( "footer.php" ); ?>