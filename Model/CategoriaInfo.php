<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 19/06/2017
 * Time: 18:05
 */

namespace ClippingBlog\Model;

use stdClass;
use JsonSerializable;

class CategoriaInfo implements JsonSerializable
{
    private $id_categoria;
    private $slug;
    private $nome;

    /**
     * @return int
     */
    public function getId() {
        return $this->id_categoria;
    }

    /**
     * @param int $value
     */
    public function setId($value) {
        $this->id_categoria = $value;
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
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param string $value
     */
    public function setNome($value) {
        $this->nome = $value;
    }

    /**
     * @return stdClass
     */
    public function jsonSerialize() {
        $categoria = new stdClass();
        $categoria->id_categoria = $this->getId();
        $categoria->slug = $this->getSlug();
        $categoria->nome = $this->getNome();
        return $categoria;
    }

}