<?php
require dirname(__DIR__) . "/Core/config.inc.php";
require dirname(__DIR__) . "/Core/function.inc.php";

use ClippingBlog\BLL\App;
use ClippingBlog\BLL\UsuarioBLL;

if (count($_GET) > 0) {
    if (array_key_exists("logout", $_GET) && $_GET["logout"] == "1") {
        $regraUsuario = new UsuarioBLL();
        $regraUsuario->logout();
        App::redirect(get_tema_path());
    }
}
if (count($_POST) > 0) {
    if (array_key_exists("ac", $_POST) && $_POST["ac"] == "logar") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        try {
            $regraUsuario = new UsuarioBLL();
            $regraUsuario->logar($email, $senha);
            App::redirect(get_tema_path());
            //App::setSucesso("Usuário logado com sucesso.");
        }
        catch (Exception $e) {
            App::setErro($e->getMessage());
        }
    }
}

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