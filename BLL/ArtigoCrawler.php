<?php

namespace ClippingBlog\BLL;

use ClippingBlog\Model\ArtigoInfo;
use PHPCrawler;
use PHPCrawlerDocumentInfo;

class ArtigoCrawler extends PHPCrawler
{
    private $url_artigo;
    private $data;
    private $titulo;
    private $texto;
    private $url_fonte;
    private $autor;

    /**
     * @return string
     */
    public function getRegexUrlArtigo() {
        return $this->url_artigo;
    }

    /**
     * @param string $value
     */
    public function setRegexUrlArtigo($value) {
        $this->url_artigo = $value;
    }

    /**
     * @return string
     */
    public function getRegexData() {
        return $this->data;
    }

    /**
     * @param string $value
     */
    public function setRegexData($value) {
        $this->data = $value;
    }

    /**
     * @return string
     */
    public function getRegexTitulo() {
        return $this->titulo;
    }

    /**
     * @param string $value
     */
    public function setRegexTitulo($value) {
        $this->titulo = $value;
    }

    /**
     * @return string
     */
    public function getRegexAutor() {
        return $this->autor;
    }

    /**
     * @param string $value
     */
    public function setRegexAutor($value) {
        $this->autor = $value;
    }

    /**
     * @return string
     */
    public function getRegexUrlFonte() {
        return $this->url_fonte;
    }

    /**
     * @param string $value
     */
    public function setRegexUrlFonte($value) {
        $this->url_fonte = $value;
    }

    /**
     * @return string
     */
    public function getRegexTexto() {
        return $this->texto;
    }

    /**
     * @param string $value
     */
    public function setRegexTexto($value) {
        $this->texto = $value;
    }

    /**
     * @param string $content
     * @param string $regex
     * @return string
     */
    private function getRegex($content, $regex) {
        if ($regex != '') {
            $matches = array();
            preg_match_all($regex, $content, $matches);
            if (isset($matches[1]) && isset($matches[1][0]))
                return trim($matches[1][0]);
        }
        return '';
    }

    /**
     * @param ArtigoInfo $artigo
     */
    public function preview($artigo) {
        //print_r($artigo);
        if (!isNullOrEmpty($artigo->getTitulo())) {
            echo "Titulo: " . $artigo->getTitulo() . "\n";
        }
        if (!isNullOrEmpty($artigo->getData())) {
            echo "Data: " . $artigo->getData() . "\n";
        }
        if (!isNullOrEmpty($artigo->getAutor())) {
            echo "Autor: " . $artigo->getAutor() . "\n";
        }
        if (!isNullOrEmpty($artigo->getUrlFonte())) {
            echo "Url: " . $artigo->getUrlFonte() . "\n";
        }
        $texto = $artigo->getTexto();
        $texto = str_replace("\n", "", $texto);
        $texto = str_replace("  ", " ", $texto);
        $texto = substr($texto, 0, 30) . "..." . substr($texto, -30);
        echo "Texto: " . strlen( $artigo->getTexto() ) . " caracteres - " . $texto . "\n";
        echo "-----------------------\n";
    }

    /**
     * @param string $arquivo
     */
    public function test($arquivo) {
        $arquivo = dirname(__DIR__) . "/Test/" . $arquivo;
        $content = file_get_contents( $arquivo );
        $artigo = $this->gerarArtigo($content);
        $this->preview($artigo);
    }

    /**
     * @param string $content
     * @return ArtigoInfo
     */
    public function gerarArtigo($content) {
        $artigo = new ArtigoInfo();
        $artigo->setTitulo( $this->getRegex($content, $this->getRegexTitulo()) );
        $artigo->setData( $this->getRegex($content, $this->getRegexData()) );
        $artigo->setAutor( $this->getRegex($content, $this->getRegexAutor()) );
        $artigo->setTexto( $this->getRegex($content, $this->getRegexTexto()) );
        $artigo->setUrlFonte( $this->getRegex($content, $this->getRegexUrlFonte()) );
        return $artigo;
    }

    /**
     * @param PHPCrawlerDocumentInfo $DocInfo
     * @return int
     */
    public function handleDocumentInfo(PHPCrawlerDocumentInfo $DocInfo){
        if (preg_match($this->getRegexUrlArtigo(), $DocInfo->url)) {
            echo "> " . $DocInfo->url . " (" . $DocInfo->http_status_code . ")\n";

            $artigo = $this->gerarArtigo($DocInfo->content);
            if (isNullOrEmpty($artigo->getTitulo())) {
                return 0;
            }
            if (isNullOrEmpty($artigo->getData())) {
                return 0;
            }
            if (isNullOrEmpty($artigo->getTexto())) {
                return 0;
            }
            if (isNullOrEmpty($artigo->getUrlFonte())) {
                $artigo->setUrlFonte($DocInfo->url);
            }
            $artigo->setUrlCrawler($DocInfo->url);

            $regraArtigo = new ArtigoBLL();
            $regraArtigo->inserir($artigo);

            $this->preview($artigo);
        }
        else {
            echo "* " . $DocInfo->url . " (" . $DocInfo->http_status_code . ")\n";
        }
    }
}