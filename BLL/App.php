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
    const CATEGORIA = "categoria";
    const TAG = "tag";
    const PAGINA_ATUAL = "pagina_atual";
    const SLUG_ATUAL = "slug_atual";
    const ARTIGOS = "artigos";
    const ARTIGO_ATUAL = "artigo_atual";

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
}