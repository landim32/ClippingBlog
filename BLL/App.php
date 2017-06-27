<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 21/06/2017
 * Time: 09:14
 */

namespace ClippingBlog\BLL;

use ClippingBlog\Model\ArtigoInfo;

class App
{
    const HOME = "home";
    const ARTIGO = "artigo";
    const TAG = "tag";
    const NEWSLETTER = "news";

    const PAGINA_ATUAL = "pagina_atual";
    const SLUG_ATUAL = "slug_atual";
    const ARTIGOS = "artigos";
    const ARTIGO_ATUAL = "artigo_atual";
    const ERRO_ATUAL = "erro_atual";
    const SUCESSO_ATUAL = "sucesso_atual";

    /**
     * @return string
     */
    public static function getPagina() {
        return $GLOBALS[App::PAGINA_ATUAL];
    }

    /**
     * @param string $value
     */
    public static function setPagina($value) {
        $GLOBALS[App::PAGINA_ATUAL] = $value;
    }

    /**
     * @return string
     */
    public static function getSlug() {
        return $GLOBALS[App::SLUG_ATUAL];
    }

    /**
     * @param string $value
     */
    public static function setSlug($value) {
        $GLOBALS[App::SLUG_ATUAL] = $value;
    }

    /**
     * @return ArtigoInfo[]
     */
    public static function getArtigos() {
        return $GLOBALS[App::ARTIGOS];
    }

    /**
     * @param ArtigoInfo[] $value
     */
    public static function setArtigos($value) {
        $GLOBALS[App::ARTIGOS] = $value;
    }

    /**
     * @return ArtigoInfo
     */
    public static function getArtigo() {
        return $GLOBALS[App::ARTIGO_ATUAL];
    }

    /**
     * @param ArtigoInfo $value
     */
    public static function setArtigo($value) {
        $GLOBALS[App::ARTIGO_ATUAL] = $value;
    }

    /**
     * @param string $value
     */
    public static function setSucesso($value) {
        $GLOBALS[App::SUCESSO_ATUAL] = $value;
    }

    /**
     * @param string $value
     */
    public static function setErro($value) {
        $GLOBALS[App::ERRO_ATUAL] = $value;
    }

    /**
     * Exibe mensagem de sucesso
     */
    public static function exibirAviso() {
        if (isset($GLOBALS[App::SUCESSO_ATUAL])) {
            echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">\n";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n";
            echo "<i class='fa fa-info-circle'></i> " . $GLOBALS[App::SUCESSO_ATUAL] . "\n";
            echo "</div>\n";
        }
        if (isset($GLOBALS[App::ERRO_ATUAL])) {
            echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">\n";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n";
            echo "<i class='fa fa-warning'></i> " . $GLOBALS[App::ERRO_ATUAL] . "\n";
            echo "</div>\n";
        }
    }

    /**
     * @param string $url
     */
    public static function redirect($url) {
        header("location: " . $url);
        exit();
    }
}