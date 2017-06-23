<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 22/06/2017
 * Time: 08:26
 */

namespace ClippingBlog\BLL;

use Exception;
use ClippingBlog\Model\UsuarioInfo;

class UsuarioBLL
{
    const USUARIO_LISTA = "usuario_lista";
    const USUARIO_ATUAL = "usuario_atual";
    const SITE_COOKIE_PATH = "/";
    const SITE_COOKIE_AUTH = "CLIPPING_BLOG_SITE_AUTH";
    const SITE_SECRET_KEY = "dk;l1894!851éds-fghjg4lui:è3afàzgq_f4fá.";

    /**
     * @return UsuarioInfo[]
     */
    public function listarDoArquivo() {
        $arquivoJson = dirname(__DIR__) . "/Core/users.json";
        $arquivoContent = file_get_contents($arquivoJson);
        $usuarios = json_decode($arquivoContent);
        $retorno = array();
        foreach ($usuarios as $usuario) {
            $retorno[] = UsuarioInfo::fromJson($usuario);
        }
        return $retorno;
    }

    /**
     * @return UsuarioInfo[]
     */
    public function listar() {
        if (!isset($GLOBALS[UsuarioBLL::USUARIO_LISTA])) {
            $GLOBALS[UsuarioBLL::USUARIO_LISTA] = $this->listarDoArquivo();
        }
        return $GLOBALS[UsuarioBLL::USUARIO_LISTA];
    }

    /**
     * @param int $id_usuario
     * @return UsuarioInfo
     */
    public function pegar($id_usuario) {
        $retorno = null;
        $usuarios = $this->listar();
        foreach ($usuarios as $usuario) {
            if ($usuario->getId() == $id_usuario) {
                $retorno = $usuario;
                break;
            }
        }
        return $retorno;
    }

    /**
     * @param string $email
     * @return UsuarioInfo
     */
    public function pegarPorEmail($email) {
        $retorno = null;
        $usuarios = $this->listar();
        foreach ($usuarios as $usuario) {
            if (strcasecmp($usuario->getEmail(), $email) == 0) {
                $retorno = $usuario;
                break;
            }
        }
        return $retorno;
    }

    /**
     * @param string $email
     * @param string $senha
     * @return int
     * @throws Exception
     */
    public function logar($email, $senha) {
        $usuario = $this->pegarPorEmail($email);
        if (is_null($usuario)) {
            throw new Exception("Email ou senha inválida.");
        }
        if ($usuario->getSenha() != $senha) {
            throw new Exception("Email ou senha inválida.");
        }
        $this->gravarCookie( $usuario->getId(), true );
        return $usuario->getId();
    }

    /**
     * @param int $id_usuario
     * @param bool $lembrar
     * @throws Exception
     */
    public function gravarCookie( $id_usuario, $lembrar = false ) {
        if ( $lembrar )
            $expiration = time() + (86400 * 30);
        else
            $expiration = time() + (86400 * 2);

        $key = hash_hmac( 'md5', $id_usuario . $expiration, UsuarioBLL::SITE_SECRET_KEY );
        $hash = hash_hmac( 'md5', $id_usuario . $expiration, $key );

        $cookie = $id_usuario . '|' . $expiration . '|' . $hash;

        $cookiedomain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        if ( !setcookie( UsuarioBLL::SITE_COOKIE_AUTH, $cookie, $expiration, UsuarioBLL::SITE_COOKIE_PATH, $cookiedomain, false, true ) )
            throw new Exception( "Não foi possível gravar o Cookie." );

    }

    /**
     * Altera a data de expiração do cookie de login
     */
    public function logout() {
        $cookiedomain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie( UsuarioBLL::SITE_COOKIE_AUTH, "", time() - 1209600, UsuarioBLL::SITE_COOKIE_PATH, $cookiedomain, false, true );
    }

    /**
     * @return bool
     */
    public function estaLogado() {
        if (empty($_COOKIE[UsuarioBLL::SITE_COOKIE_AUTH]))
            return false;

        list( $id_usuario, $expiration, $hmac ) = explode( '|', $_COOKIE[UsuarioBLL::SITE_COOKIE_AUTH] );

        if ( $expiration < time() )
            return false;

        $key = hash_hmac( 'md5', $id_usuario . $expiration, UsuarioBLL::SITE_SECRET_KEY );
        $hash = hash_hmac( 'md5', $id_usuario . $expiration, $key );

        if ( $hmac != $hash ) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public static function pegarIdUsuarioAtual() {
        list( $id_usuario, $expiration, $hmac ) = explode( '|', $_COOKIE[UsuarioBLL::SITE_COOKIE_AUTH] );

        if ( $expiration < time() )
            return 0;

        $key = hash_hmac( 'md5', $id_usuario . $expiration, UsuarioBLL::SITE_SECRET_KEY );
        $hash = hash_hmac( 'md5', $id_usuario . $expiration, $key );

        if ( $hmac != $hash ) {
            return 0;
        }
        return $id_usuario;
    }

    /**
     * @return UsuarioInfo|null
     */
    public static function pegarUsuarioAtual() {
        if (!isset($GLOBALS[UsuarioBLL::USUARIO_ATUAL])) {
            $id_usuario = UsuarioBLL::pegarIdUsuarioAtual();
            if ($id_usuario > 0) {
                $regraUsuario = new UsuarioBLL();
                $usuario = $regraUsuario->pegar($id_usuario);
                if (!is_null($usuario)) {
                    $GLOBALS[UsuarioBLL::USUARIO_ATUAL] = $usuario;
                }
            }
        }
        return $GLOBALS[UsuarioBLL::USUARIO_ATUAL];
    }

    /**
     * @return UsuarioInfo|null
     */
    public static function getUsuarioAtual() {
        return UsuarioBLL::pegarUsuarioAtual();
    }
}