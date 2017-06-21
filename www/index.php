<?php
require dirname(__DIR__) . "/Core/config.inc.php";
require dirname(__DIR__) . "/Core/function.inc.php";

use ClippingBlog\BLL\App;

$param = trim( $_GET["slug"] );
if (strpos( $param, "/" ) === false) {
    if (isNullOrEmpty($param)) {
        App::setPagina(App::HOME);
        App::setSlug("");
    }
    else {
        App::setPagina(App::ARTIGO);
        App::setSlug($param);
    }
}
else {
    $params = explode("/", $param);
    App::setPagina($params[0]);
    App::setSlug($params[1]);
}
require dirname(__DIR__) . "/www/" . App::getPagina() . ".php";