<?php

use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\BLL\App;
use ClippingBlog\Model\ArtigoInfo;
$regraArtigo = new ArtigoBLL();

$pg = intval($_GET['pg']);
if ($pg < 1) $pg = 1;

$usuario = UsuarioBLL::pegarUsuarioAtual();
$cod_situacao = (is_null($usuario)) ? ArtigoInfo::ATIVO : 0;
$retorno = $regraArtigo->listarPaginado($cod_situacao, "", $pg, MAX_PAGE_COUNT);
$paginacao = admin_pagination(ceil($retorno->getTotal() / MAX_PAGE_COUNT));

?>
<?php require( "header.php" ); ?>
<?php require( "menu-principal.php" ); ?>
    <div class="container" style="padding-top: 60px;">
        <div class="col-md-8">
            <?php App::exibirAviso(); ?>
            <?php foreach ($retorno->getArtigos() as $artigo) : ?>
                <div id="<?php echo "artigo-" . $artigo->getId(); ?>" class="artigo">
                    <h2><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></h2>
                    <div>
                        <?php if (!is_null($usuario)) : ?>
                            <a href="#" class="artigo-item-excluir" data-artigo="<?php echo $artigo->getId(); ?>">
                                <span class="badge badge-danger"><i class="fa fa-remove"></i> Excluir</span>
                            </a>
                        <?php endif; ?>
                        <?php foreach ($artigo->listarTag() as $tag) : ?>
                            <a href="<?php echo get_tema_path() . "/tag/" . $tag->getSlug(); ?>">
                                <span class="badge info"><?php echo $tag->getNome(); ?></span>
                            </a>
                        <?php endforeach; ?>
                        &nbsp; <i class="fa fa-clock-o"></i> <?php echo $artigo->getDataStr(); ?>
                        <?php if (!isNullOrEmpty($artigo->getAutor())) : ?>
                            &nbsp; <i class="fa fa-user"></i> <?php echo $artigo->getAutor(); ?>
                        <?php endif; ?>
                        <?php if (!is_null($usuario)) : ?>
                            <?php
                            switch ($artigo->getCodSituacao()) {
                                case ArtigoInfo::ATIVO:
                                    echo "<label class='label label-success'>Ativo</label>";
                                    break;
                                case ArtigoInfo::INATIVO:
                                    echo "<label class='label label-danger'>Inativo</label>";
                                    break;
                                case ArtigoInfo::RASCUNHO:
                                    echo "<label class='label label-warning'>Rascunho</label>";
                                    break;
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                    <p><?php echo $artigo->getResumo(); ?></p>
                    <hr />
                </div>
            <?php endforeach; ?>
            <div class="text-center">
                <?php echo $paginacao; ?>
            </div>
        </div>
        <?php require( "sidebar.php" ); ?>
    </div><!-- /.container -->
<?php require( "footer.php" ); ?>