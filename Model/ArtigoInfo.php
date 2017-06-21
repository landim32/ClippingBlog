<?php

namespace ClippingBlog\Model;

use ClippingBlog\BLL\ArtigoBLL;
use stdClass;
use JsonSerializable;
use ClippingBlog\DAL\CategoriaDAL;

/**
 * Class ArtigoInfo
 * @package ClippingBlog\Model
 */
class ArtigoInfo implements JsonSerializable
{
    const ATIVO = 1;
    const RASCUNHO = 2;
    const INATIVO = 3;

    private $id_artigo;
    private $data_inclusao;
    private $ultima_alteracao;
    private $data;
    private $slug;
    private $titulo;
    private $texto;
    private $autor;
    private $url_fonte;
    private $url_crawler;
    private $cod_situacao;
    private $tags;
    private $categorias = null;

    /**
     * @return int
     */
    public function getId() {
        return $this->id_artigo;
    }

    /**
     * @param int $value
     */
    public function setId($value) {
        $this->id_artigo = $value;
    }

    /**
     * @return string
     */
    public function getDataInclusao() {
        return $this->data_inclusao;
    }

    /**
     * @param string $value
     */
    public function setDataInclusao($value) {
        $this->data_inclusao = $value;
    }

    /**
     * @return string
     */
    public function getUltimaAlteracao() {
        return $this->ultima_alteracao;
    }

    /**
     * @param string $value
     */
    public function setUltimaAlteracao($value) {
        $this->ultima_alteracao = $value;
    }

    /**
     * @return string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getDataStr() {
        return utf8_encode( strftime("%A %d, %B %Y", strtotime($this->data)) );
    }

    /**
     * @return string
     */
    public function getDataMin() {
        return date("d/m/Y", strtotime($this->data) );
    }

    /**
     * @param string $value
     */
    public function setData($value) {
        $this->data = $value;
    }

    /**
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @param string $value
     */
    public function setSlug($value) {
        $this->slug = $value;
    }

    /**
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * @param string $value
     */
    public function setTitulo($value) {
        $this->titulo = $value;
    }

    /**
     * @return string
     */
    public function getTexto() {
        return $this->texto;
    }

    /**
     * @param string $value
     */
    public function setTexto($value) {
        $this->texto = $value;
    }

    /**
     * @return string
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * @param string $value
     */
    public function setAutor($value) {
        $this->autor = $value;
    }

    /**
     * @return string
     */
    public function getUrlFonte() {
        return $this->url_fonte;
    }

    /**
     * @param string $value
     */
    public function setUrlFonte($value) {
        $this->url_fonte = $value;
    }

    /**
     * @return string
     */
    public function getUrlCrawler() {
        return $this->url_crawler;
    }

    /**
     * @param string $value
     */
    public function setUrlCrawler($value) {
        $this->url_crawler = $value;
    }

    /**
     * @return int
     */
    public function getCodSituacao() {
        return $this->cod_situacao;
    }

    /**
     * @param int $value
     */
    public function setCodSituacao($value) {
        $this->cod_situacao = $value;
    }

    /**
     * @return string
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @param string $value
     */
    public function setTags($value) {
        $this->tags = $value;
    }

    /**
     * @return string[]
     */
    public function listarTags() {
        return explode(",", $this->getTags());
    }

    /**
     * @return CategoriaInfo[]
     */
    public function listarCategoria() {
        if (is_null($this->categorias)) {
            if ($this->getId() > 0) {
                $dalCategoria = new CategoriaDAL();
                $this->categorias = $dalCategoria->listarPorArtigo($this->getId());
            }
            else {
                $this->categorias = array();
            }
        }
        return $this->categorias;
    }

    /**
     * @param CategoriaInfo $value
     */
    public function adicionarCategoria($value) {
        if (is_null($this->categorias)) {
            if ($this->getId() > 0) {
                $dalCategoria = new CategoriaDAL();
                $this->categorias = $dalCategoria->listarPorArtigo($this->getId());
            }
            else {
                $this->categorias = array();
            }
        }
        $this->categorias[] = $value;
    }

    /**
     * @return string
     */
    public function getResumo() {
        $texto = trim(strip_tags($this->getTexto()));
        $texto = str_replace("\n", " ", $texto);
        while (mb_strpos("  ", $texto) !== false) {
            $texto = str_replace("  ", " ", $texto);
        }
        if (mb_strlen($texto) > 300) {
            $texto = mb_substr($texto, 0, 297) . "...";
        }
        return $texto;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return get_tema_path() . "/" . $this->getSlug();
    }

    /**
     * @return stdClass
     */
    public function jsonSerialize() {
        $artigo = new stdClass();
        $artigo->id_artigo = $this->getId();
        $artigo->data_inclusao = $this->getDataInclusao();
        $artigo->ultima_alteracao = $this->getUltimaAlteracao();
        $artigo->data = $this->getData();
        $artigo->data_str = $this->getDataStr();
        $artigo->data_min = $this->getDataMin();
        $artigo->slug = $this->getSlug();
        $artigo->titulo = $this->getTitulo();
        $artigo->texto = $this->getTexto();
        $artigo->autor = $this->getAutor();
        $artigo->url_fonte = $this->getUrlFonte();
        $artigo->url_crawler = $this->getUrlCrawler();
        $artigo->tags = $this->getTags();
        $artigo->tags_lista = $this->listarTags();
        $artigo->cod_situacao = $this->getCodSituacao();
        $artigo->categorias = array();
        foreach ($this->listarCategoria() as $categoria) {
            $artigo->categorias[] = $categoria->jsonSerialize();
        }
        return $artigo;
    }

    /**
     * @param stdClass $value
     * @return ArtigoInfo
     */
    public static function fromJson($value) {
        $artigo = new ArtigoInfo();
        $artigo->setId( $value->id_artigo );
        $artigo->setDataInclusao( $value->data_inclusao );
        $artigo->setUltimaAlteracao( $value->ultima_alteracao );
        $artigo->setData( $value->data );
        $artigo->setSlug( $value->slug );
        $artigo->setTitulo( $value->titulo );
        $artigo->setTexto( $value->texto );
        $artigo->setAutor( $value->autor );
        $artigo->setUrlFonte( $value->url_fonte );
        $artigo->setUrlCrawler( $value->url_crawler );
        $artigo->setTags( $value->tags );
        $artigo->setCodSituacao( $value->cod_situacao );
        return $artigo;
    }
}