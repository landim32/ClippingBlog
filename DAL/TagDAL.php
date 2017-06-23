<?php

namespace ClippingBlog\DAL;

use ClippingBlog\Model\ArtigoInfo;
use PDO;
use PDOStatement;
use ClippingBlog\Model\TagInfo;

class TagDAL
{
    /**
     * @param bool $distinct
     * @return string
     */
    private function query($distinct = false) {
        return "
            SELECT " . (($distinct) ? "DISTINCT" : "") . "
                tag.id_tag,
                tag.slug,
                tag.nome
            FROM tag
        ";
    }

    /**
     * @return TagInfo[]
     */
    public function listar() {
        $query = $this->query() . "
            ORDER BY tag.nome
        ";
        $db = DB::getDB()->prepare($query);
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @return TagInfo[]
     */
    public function listarPopular() {
        $query = $this->query() . "
            INNER JOIN artigo_tag ON artigo_tag.id_tag = tag.id_tag
            INNER JOIN artigo ON artigo.id_artigo = artigo_tag.id_artigo
            WHERE artigo.cod_situacao = :cod_situacao
            GROUP BY
                tag.id_tag,
                tag.slug,
                tag.nome
            HAVING COUNT(artigo.id_artigo) > 0 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":cod_situacao", ArtigoInfo::ATIVO, PDO::PARAM_INT);
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @param int $id_tag
     * @return TagInfo
     */
    public function pegar($id_tag) {
        $query = $this->query() . " 
            WHERE tag.id_tag = :id_tag
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_tag", $id_tag, PDO::PARAM_INT);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @param string $slug
     * @return TagInfo
     */
    public function pegarPorSlug($slug) {
        $query = $this->query() . " 
            WHERE tag.slug = :slug 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":slug", $slug);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @param string $nome
     * @return TagInfo
     */
    public function pegarPorNome($nome) {
        $query = $this->query() . " 
            WHERE tag.nome = :nome 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":nome", $nome);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @param int $id_artigo
     * @return TagInfo[]
     */
    public function listarPorArtigo($id_artigo) {
        $query = $this->query() . "
            INNER JOIN artigo_tag on artigo_tag.id_tag = tag.id_tag
            WHERE artigo_tag.id_artigo = :id_artigo
            ORDER BY tag.nome
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\TagInfo");
    }

    /**
     * @param PDOStatement $db
     * @param TagInfo $tag
     */
    private function preencharCampo($db, $tag) {
        $db->bindValue(":slug", $tag->getSlug());
        $db->bindValue(":nome", $tag->getNome());
    }

    /**
     * @param TagInfo $tag
     * @return int
     */
    public function inserir($tag) {
        $query = "
            INSERT INTO tag (
                slug,
                nome
            ) VALUES (
                :slug,
                :nome
            )
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencharCampo($db, $tag);
        $db->execute();
        return DB::lastInsertId();
    }

    /**
     * @param TagInfo $tag
     */
    public function alterar($tag) {
        $query = "
            UPDATE tag SET
                slug = :slug,
                nome = :nome
            WHERE id_tag = :id_tag
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencharCampo($db, $tag);
        $db->bindValue(":id_tag", $tag->getId(), PDO::PARAM_INT);
        $db->execute();
    }

    /**
     * @param int $id_tag
     */
    public function excluir($id_tag) {
        $query = "
            DELETE FROM tag 
            WHERE id_tag = :id_tag
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_tag", $id_tag, PDO::PARAM_INT);
        $db->execute();
    }
}