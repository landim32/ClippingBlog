<?php

use ClippingBlog\BLL\App;
use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\BLL\TagBLL;
use ClippingBlog\Model\ArtigoInfo;

$usuario = UsuarioBLL::pegarUsuarioAtual();
$artigo = App::getArtigo();

$regraTag = new TagBLL();
$tags = $regraTag->listarPopular(10);

?>
<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Mudar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo get_tema_path(); ?>"><i class="fa fa-home"></i> Home</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <?php if (count($tags) > 0) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo (!is_null($usuario)) ? "<i class=\"fa fa-book\"></i> Artigos" : "<i class=\"fa fa-tags\"></i> Tags"; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!is_null($usuario)) : ?>
                        <li><a href="<?php echo get_tema_path() . "/?situacao=" . ArtigoInfo::RASCUNHO; ?>"><i class="fa fa-dashcube"></i> Apenas rascunho</a></li>
                        <li><a href="<?php echo get_tema_path() . "/?situacao=" . ArtigoInfo::INATIVO; ?>"><i class="fa fa-ban"></i> Apenas inativo</a></li>
                        <li role="separator" class="divider"></li>
                        <?php endif; ?>
                        <?php foreach ($tags as $tag) : ?>
                            <li><a href="<?php echo $tag->getUrl(); ?>"><i class="fa fa-tag"></i> <?php echo $tag->getNome(); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-comment"></i> Contato <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="http://emagine.com.br"><i class="fa fa-fw fa-cogs"></i> Preciso de um Dev</a></li>
                    <li><a href="http://emagine.com.br"><i class="fa fa-fw fa-dollar"></i> Orçamento</a></li>
                </ul>
            </li>
            <!--li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li-->
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (!is_null($usuario)) : ?>
                <?php if (!is_null($artigo)) : ?>
                    <li><a href="#" data-artigo="<?php echo $artigo->getId(); ?>" class="artigo-alterar"><i class="fa fa-pencil"></i> Alterar</a></li>
                <?php endif; ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo get_gravatar($usuario->getEmail(), 20); ?>" class="img-circle" />
                        <?php echo $usuario->getNome(); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!is_null($artigo)) : ?>
                            <li><a href="#" data-artigo="<?php echo $artigo->getId(); ?>" class="artigo-excluir"><i class="fa fa-remove"></i> Excluir Artigo</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo get_tema_path(); ?>/?logout=1"><i class="fa fa-ban"></i> Sair</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="#loginModal" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user-circle"></i> Logar</a></li>
            <?php endif; ?>
        </ul>
    </div><!--/.nav-collapse -->
</nav>