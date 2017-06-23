<?php

use ClippingBlog\BLL\App;
use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\Model\ArtigoInfo;

$usuario = UsuarioBLL::pegarUsuarioAtual();
$artigo = App::getArtigo();

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo get_tema_path(); ?>">Emagine Blog</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo get_tema_path(); ?>"><i class="fa fa-home"></i> Home</a></li>
                <?php if (!is_null($usuario)) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-book"></i> Artigos <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo get_tema_path() . "/?situacao=" . ArtigoInfo::ATIVO; ?>"><i class="fa fa-dashcube"></i> Rascunho</a></li>
                        <li><a href="<?php echo get_tema_path() . "/?situacao=" . ArtigoInfo::INATIVO; ?>"><i class="fa fa-ban"></i> Inativo</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!--li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!is_null($usuario)) : ?>
                    <?php if (!is_null($artigo)) : ?>
                        <li><a href="#" data-artigo="<?php echo $artigo->getId(); ?>" class="artigo-excluir"><i class="fa fa-remove"></i> Excluir</a></li>
                        <li><a href="#" data-artigo="<?php echo $artigo->getId(); ?>" class="artigo-alterar"><i class="fa fa-pencil"></i> Alterar</a></li>
                    <?php endif; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo get_gravatar($usuario->getEmail(), 20); ?>" class="img-circle" />
                            <?php echo $usuario->getNome(); ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo get_tema_path(); ?>/?logout=1"><i class="fa fa-close"></i> Sair</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                <li><a href="#loginModal" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user-circle"></i> Logar</a></li>
                <?php endif; ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>