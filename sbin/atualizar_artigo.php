<?php
require dirname(__DIR__) . "/Core/config.inc.php";
require dirname(__DIR__) . "/Core/function.inc.php";

use ClippingBlog\BLL\ArtigoBLL;

$regraArtigo = new ArtigoBLL();
$artigos = $regraArtigo->listar();
foreach ($artigos as $artigo) {
    $regraArtigo->gerarTagAutomatico($artigo);
    $str = "* " . $artigo->getTitulo() . " = ";
    $tags = array();
    foreach ($artigo->getTags() as $tag) {
        $tags[] = $tag->getNome();
    }
    $str .= implode(", ", $tags);
    echo $str . "\n";
}