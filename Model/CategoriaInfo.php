<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 19/06/2017
 * Time: 18:05
 */

namespace ClippingBlog\Model;

class CategoriaInfo
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

}