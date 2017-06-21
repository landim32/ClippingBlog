<?php

namespace ClippingBlog\DAL;

use PDO;
use PDOStatement;
use ClippingBlog\Model\CategoriaInfo;

class CategoriaDAL
{
    /**
     * @return string
     */
    private function query() {
        return "
            SELECT
                categoria.id_categoria,
                categoria.slug,
                categoria.nome
            FROM categoria
        ";
    }

    /**
     * @param int $codSituacao
     * @return CategoriaInfo[]
     */
    public function listar($codSituacao = 0) {
        $query = $this->query();
        if ($codSituacao > 0) {
            $query .= " WHERE categoria.cod_situacao = :cod_situacao ";
        }
        $db = DB::getDB()->prepare($query);
        if ($codSituacao > 0) {
            $db->bindValue(":cod_situacao", $codSituacao, PDO::PARAM_INT);
        }
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\CategoriaInfo");
    }

    /**
     * @param int $id_categoria
     * @return CategoriaInfo
     */
    public function pegar($id_categoria) {
        $query = $this->query() . " 
            WHERE categoria.id_categoria = :id_categoria 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\CategoriaInfo");
    }

    /**
     * @param string $slug
     * @return CategoriaInfo
     */
    public function pegarPorSlug($slug) {
        $query = $this->query() . " 
            WHERE categoria.slug = :slug 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":slug", $slug);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\CategoriaInfo");
    }

    /**
     * @param int $id_artigo
     * @return CategoriaInfo[]
     */
    public function listarPorArtigo($id_artigo) {
        $query = $this->query() . "
            INNER JOIN artigo_categoria on artigo_categoria.id_categoria = categoria.id_categoria
            WHERE artigo_categoria.id_artigo = :id_artigo
            ORDER BY categoria.nome
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\CategoriaInfo");
    }

    /**
     * @param PDOStatement $db
     * @param CategoriaInfo $categoria
     */
    private function preencharCampo($db, $categoria) {
        $db->bindValue(":slug", $categoria->getSlug());
        $db->bindValue(":nome", $categoria->getNome());
    }

    /**
     * @param CategoriaInfo $categoria
     * @return int
     */
    public function inserir($categoria) {
        $query = "
            INSERT INTO categoria (
                slug,
                nome
            ) VALUES (
                :slug,
                :nome
            )
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencharCampo($db, $categoria);
        $db->execute();
        return DB::lastInsertId();
    }

    /**
     * @param CategoriaInfo $categoria
     */
    public function alterar($categoria) {
        $query = "
            UPDATE categoria SET
                slug = :slug,
                nome = :nome
            WHERE id_categoria = :id_categoria
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencharCampo($db, $categoria);
        $db->bindValue(":id_categoria", $categoria->getId(), PDO::PARAM_INT);
        $db->execute();
    }

    /**
     * @param int $id_categoria
     */
    public function excluir($id_categoria) {
        $query = "
            DELETE FROM categoria 
            WHERE id_categoria = :id_categoria
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $db->execute();
    }
}