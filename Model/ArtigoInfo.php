<?php

namespace ClippingBlog\Model;

use ClippingBlog\DAL\CategoriaDAL;

/**
 * Class ArtigoInfo
 * @package ClippingBlog\Model
 */
class ArtigoInfo
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
}