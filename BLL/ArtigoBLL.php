<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 20/06/2017
 * Time: 08:51
 */

namespace ClippingBlog\BLL;

use Exception;
use ClippingBlog\DAL\DB;
use ClippingBlog\DAL\ArtigoDAL;
use ClippingBlog\DAL\CategoriaDAL;
use ClippingBlog\Model\ArtigoInfo;

class ArtigoBLL
{
    /**
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listar($codSituacao = 0) {
        $dal = new ArtigoDAL();
        return $dal->listar($codSituacao);
    }

    /**
     * @param int $idCategoria
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listarPorCategoria($idCategoria, $codSituacao = 0) {
        $dal = new ArtigoDAL();
        return $dal->listarPorCategoria($idCategoria, $codSituacao);
    }

    /**
     * @param int $idArtigo
     * @return ArtigoInfo
     */
    public function pegar($idArtigo) {
        $dal = new ArtigoDAL();
        return $dal->pegar($idArtigo);
    }

    /**
     * @param string $slug
     * @return ArtigoInfo
     */
    public function pegarPorSlug($slug) {
        $dal = new ArtigoDAL();
        return $dal->pegarPorSlug($slug);
    }

    /**
     * @param int $id_categoria
     * @param string $slug
     * @return string
     */
    private function slugValido($id_categoria, $slug)
    {
        $categoria = $this->pegarPorSlug($slug);
        if (!is_null($categoria) && $categoria->getId() != $id_categoria) {
            $out = array();
            preg_match_all("#(.*?)-(\d{1,2})#i", $slug, $out, PREG_PATTERN_ORDER);
            if (!isNullOrEmpty($out[1][0]) && is_numeric($out[2][0])) {
                $slug = $this->slugValido($id_categoria, $out[1][0] . "-" . (intval($out[2][0]) + 1));
            } else
                $slug = $this->slugValido($id_categoria, $slug . '-2');
        }
        return $slug;
    }

    /**
     * @param ArtigoInfo $artigo
     * @throws Exception
     */
    private function validar(&$artigo) {
        if (is_null($artigo)) {
            throw new Exception("Artigo não informada.");
        }
        if (isNullOrEmpty($artigo->getTitulo())) {
            throw new Exception("Preencha o título do artigo.");
        }
        if (isNullOrEmpty($artigo->getSlug())) {
            $artigo->setSlug( sanitize_slug($artigo->getTitulo()) );
        }
        $slug = $this->slugValido($artigo->getId(), $artigo->getSlug());
        $artigo->setSlug( strtolower( $slug ) );

        if (!($artigo->getCodSituacao() > 0)) {
            $artigo->setCodSituacao(ArtigoInfo::RASCUNHO);
        }
    }

    /**
     * @param ArtigoInfo $artigo
     * @return int
     */
    public function inserir($artigo) {
        $this->validar($artigo);
        $id_artigo = null;
        $dal = new ArtigoDAL();
        $dalCategoria = new CategoriaDAL();
        try {
            DB::beginTransaction();
            $id_artigo = $dal->inserir($artigo);
            $dal->limparCategoria($id_artigo);
            foreach ($artigo->listarCategoria() as $categoria) {
                if (!($categoria->getId() > 0)) {
                    $id_categoria = $dalCategoria->inserir($categoria);
                }
                else {
                    $id_categoria = $categoria->getId();
                }
                $dal->inserirCategoria($id_artigo, $id_categoria);
            }
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
        }
        return $id_artigo;
    }

    /**
     * @param ArtigoInfo $artigo
     * @return int
     */
    public function alterar($artigo) {
        $this->validar($artigo);
        $dal = new ArtigoDAL();
        $dalCategoria = new CategoriaDAL();
        try {
            DB::beginTransaction();
            $dal->alterar($artigo);
            $dal->limparCategoria($artigo->getId());
            foreach ($artigo->listarCategoria() as $categoria) {
                if (!($categoria->getId() > 0)) {
                    $id_categoria = $dalCategoria->inserir($categoria);
                }
                else {
                    $id_categoria = $categoria->getId();
                }
                $dal->inserirCategoria($artigo->getId(), $id_categoria);
            }
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * @param int $id_artigo
     */
    public function excluir($id_artigo) {
        $dal = new ArtigoDAL();
        try {
            DB::beginTransaction();
            $dal->limparCategoria($id_artigo);
            $dal->excluir($id_artigo);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
        }
    }
}