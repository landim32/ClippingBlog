<?php

namespace ClippingBlog\BLL;

use Exception;
use ClippingBlog\DAL\CategoriaDAL;
use ClippingBlog\Model\CategoriaInfo;

class CategoriaBLL
{
    /**
     * @param int $cod_situacao
     * @return CategoriaInfo[]
     */
    public function listar($cod_situacao) {
        $dal = new CategoriaDAL();
        return $dal->listar($cod_situacao);
    }

    /**
     * @param int $id_categoria
     * @return CategoriaInfo
     */
    public function pegar($id_categoria) {
        $dal = new CategoriaDAL();
        return $dal->pegar($id_categoria);
    }

    /**
     * @param string $slug
     * @return CategoriaInfo
     */
    public function pegarPorSlug($slug) {
        $dal = new CategoriaDAL();
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
     * @param CategoriaInfo $categoria
     * @throws Exception
     */
    private function validar(&$categoria) {
        if (is_null($categoria)) {
            throw new Exception("Categoria não informada.");
        }
        if (isNullOrEmpty($categoria->getNome())) {
            throw new Exception("Preencha o nome da categoria.");
        }
        if (isNullOrEmpty($categoria->getSlug())) {
            $categoria->setSlug( sanitize_slug($categoria->getNome()) );
        }
        $slug = $this->slugValido($categoria->getId(), $categoria->getSlug());
        $categoria->setSlug( strtolower( $slug ) );
    }

    /**
     * @param CategoriaInfo $categoria
     * @return int
     */
    public function inserir($categoria) {
        $this->validar($categoria);

        $dal = new CategoriaDAL();
        return $dal->inserir($categoria);
    }

    /**
     * @param CategoriaInfo $categoria
     */
    public function alterar($categoria) {
        $this->validar($categoria);

        $dal = new CategoriaDAL();
        $dal->alterar($categoria);
    }

    /**
     * @param int $id_categoria
     */
    public function excluir($id_categoria) {
        $dal = new CategoriaDAL();
        $dal->excluir($id_categoria);
    }

}