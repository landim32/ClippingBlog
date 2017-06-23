<?php

use ClippingBlog\BLL\UsuarioBLL;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="<?php echo get_tema_path(); ?>/favicon.ico" />
    <title>Starter Template for Bootstrap</title>
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
