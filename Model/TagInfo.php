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

class TagInfo implements JsonSerializable
{
    private $id_tag;
    private $slug;
    private $nome;

    /**
     * @return int
     */
    public function getId() {
        return $this->id_tag;
    }

    /**
     * @param int $value
     */
    public function setId($value) {
        $this->id_tag = $value;
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
     * @return string
     */
    public function getUrl() {
        return get_tema_path() . "/tag/" . $this->getSlug();
    }

    /**
     * @return stdClass
     */
    public function jsonSerialize() {
        $tag = new stdClass();
        $tag->id_tag = $this->getId();
        $tag->slug = $this->getSlug();
        $tag->nome = $this->getNome();
        return $tag;
    }

    /**
     * @param stdClass $value
     * @return TagInfo
     */
    public static function fromJson($value) {
        $tag = new TagInfo();
        $tag->setId($value->id_tag);
        $tag->setSlug($value->slug);
        $tag->setNome($value->nome);
        return $tag;
    }

}