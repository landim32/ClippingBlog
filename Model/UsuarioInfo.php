<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 22/06/2017
 * Time: 08:09
 */

namespace ClippingBlog\Model;

use stdClass;

class UsuarioInfo
{
    private $id_usuario;
    private $email;
    private $nome;
    private $senha;
    private $url;

    /**
     * @return int
     */
    public function getId() {
        return $this->id_usuario;
    }

    /**
     * @param int $value
     */
    public function setId($value) {
        $this->id_usuario = $value;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $value
     */
    public function setEmail($value) {
        $this->email = $value;
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
    public function getSenha() {
        return $this->senha;
    }

    /**
     * @param string $value
     */
    public function setSenha($value) {
        $this->senha = $value;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $value
     */
    public function setUrl($value) {
        $this->url = $value;
    }

    /**
     * @param stdClass $value
     * @return UsuarioInfo
     */
    public static function fromJson($value) {
        $usuario = new UsuarioInfo();
        $usuario->setId($value->id_usuario);
        $usuario->setEmail($value->email);
        $usuario->setNome($value->nome);
        $usuario->setSenha($value->senha);
        $usuario->setUrl($value->url);
        return $usuario;
    }
}