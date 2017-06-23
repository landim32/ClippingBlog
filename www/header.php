<?php

use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\BLL\App;

$artigo = App::getArtigo();

define("WEBSITE_TITULO", "Emagine Blog - Programação em PHP, C#.NET, Android, iOS e Xamarin");
define("WEBSITE_DESCRICAO", "Blog de programação e desenvolvimento com dicas em PHP, C#.NET, Android, iOS e Xamarin");
$urlAtual = "http://" . $_SERVER["HTTP_HOST"] . (!is_null($artigo) ? $artigo->getUrl() : get_tema_path());

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php if (!is_null($artigo)) :?>
        <title><?php echo $artigo->getTitulo(); ?></title>
        <meta name="description" content="<?php echo $artigo->getResumo(); ?>" />
    <?php else : ?>
        <title><?php echo WEBSITE_TITULO; ?></title>
        <meta name="description" content="<?php echo WEBSITE_DESCRICAO; ?>" />
    <?php endif; ?>
    <meta name="author" content="Rodrigo Landim" />
    <link rel="icon" href="<?php echo get_tema_path(); ?>/favicon.png" />
    <!--link rel="pingback" href="<?php echo get_tema_path(); ?>/xmlrpc.php"-->
    <meta name="robots" content="noodp"/>
    <link rel="canonical" href="<?php echo $urlAtual; ?>" />
    <!--link rel="publisher" href="https://plus.google.com/u/0/101111884478024912292/"/-->
    <meta property="og:locale" content="pt_BR" />
    <?php if (!is_null($artigo)) :?>
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $artigo->getTitulo(); ?>" />
        <meta property="og:description" content="<?php echo $artigo->getResumo(); ?>" />
    <?php else : ?>
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo WEBSITE_TITULO; ?>" />
        <meta property="og:description" content="<?php echo WEBSITE_DESCRICAO; ?>" />
    <?php endif; ?>
    <meta property="og:url" content="<?php echo $urlAtual; ?>" />
    <meta property="og:site_name" content="Emagine" />
    <meta property="article:publisher" content="https://www.facebook.com/landim32" />
    <meta property="article:section" content="Blog" />
    <meta property="article:published_time" content="<?php echo date("Y-m-d") . "T00:00:00-03:00"?>" />
    <?php if (!is_null($artigo)) :?>
        <meta name="twitter:title" content="<?php echo $artigo->getTitulo(); ?>" />
        <meta name="twitter:description" content="<?php echo $artigo->getResumo(); ?>" />
    <?php else : ?>
        <meta name="twitter:title" content="<?php echo WEBSITE_TITULO; ?>" />
        <meta name="twitter:description" content="<?php echo WEBSITE_DESCRICAO; ?>" />
    <?php endif; ?>
    <meta name="twitter:site" content="@landim32official" />
    <meta name="twitter:creator" content="@landim32official" />

    <link href="<?php echo get_tema_path(); ?>/css/blog.min.css" rel="stylesheet" />
    <link href="<?php echo get_tema_path(); ?>/css/ie10-viewport-bug-workaround.css" rel="stylesheet" />
    <link href="<?php echo get_tema_path(); ?>/css/bootstrap-datepicker3.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo get_tema_path(); ?>/codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="<?php echo get_tema_path(); ?>/codemirror/addon/hint/show-hint.css" />

    <!--[if lt IE 9]><script src="<?php echo get_tema_path(); ?>/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo get_tema_path(); ?>/js/ie-emulation-modes-warning.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <?php endif; ?>
</head>
<body>
<?php require "login-modal.inc.php"; ?>
<header>
    <div class="container">
        <div class="col-md-3">
            <a href="<?php echo get_tema_path(); ?>" class="logo"><img src="/blog/images/emagine-logo-branca.png" alt="Emagine" /></a>
        </div>
        <div class="col-md-9">
            <?php require( "menu-principal.php" ); ?>
        </div>
    </div>
</header>
<div class="clearfix"></div>
