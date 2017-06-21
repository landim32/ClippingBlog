<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 20/06/2017
 * Time: 08:06
 */

namespace ClippingBlog\DAL;

use ClippingBlog\Model\ArtigoRetornoInfo;
use PDO;
use PDOStatement;
use ClippingBlog\Model\ArtigoInfo;

class ArtigoDAL
{
    /**
     * @param bool $paginado
     * @return string
     */
    private function query($paginado = false) {
        return "
            SELECT " . (($paginado) ? "SQL_CALC_FOUND_ROWS" : "") . " 
                artigo.id_artigo,
                artigo.data_inclusao,
                artigo.ultima_alteracao,
                artigo.data,
                artigo.slug,
                artigo.titulo,
                artigo.texto,
                artigo.autor,
                artigo.url_fonte,
                artigo.tags,
                artigo.cod_situacao
            FROM artigo
        ";
    }

    /**
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listar($codSituacao = 0) {
        $query = $this->query();
        if ($codSituacao > 0) {
            $query .= " WHERE artigo.cod_situacao = :cod_situacao ";
        }
        $query .= " ORDER BY artigo.data DESC ";
        $db = DB::getDB()->prepare($query);
        if ($codSituacao > 0) {
            $db->bindValue(":cod_situacao", $codSituacao, PDO::PARAM_INT);
        }
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\ArtigoInfo");
    }

    /**
     * @param int $codSituacao
     * @param int $pg Pagina atual
     * @param int $numpg Quantidade de itens visualizados
     * @return ArtigoRetornoInfo
     */
    public function listarPaginado($codSituacao = 0, $pg = 1, $numpg = 10) {
        $query = $this->query(true);
        if ($codSituacao > 0) {
            $query .= " WHERE artigo.cod_situacao = :cod_situacao ";
        }
        $query .= " ORDER BY artigo.data DESC ";
        $pgini = (($pg - 1) * $numpg);
        $query .= " LIMIT " . $pgini . ", " . $numpg;
        $db = DB::getDB()->prepare($query);
        if ($codSituacao > 0) {
            $db->bindValue(":cod_situacao", $codSituacao, PDO::PARAM_INT);
        }
        $db->execute();
        $artigos = DB::getResult($db, "\\ClippingBlog\\Model\\ArtigoInfo");
        $total = DB::getDB()->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
        return new ArtigoRetornoInfo($artigos, $total);
    }

    /**
     * @param int $idCategoria
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listarPorCategoria($idCategoria, $codSituacao = 0) {
        $query = $this->query() . "
            INNER JOIN artigo_categoria ON artigo_categoria.id_artigo = artigo.id_artigo
            WHERE artigo_categoria.id_categoria = :id_categoria
        ";
        if ($codSituacao > 0) {
            $query .= " AND artigo.cod_situacao = :cod_situacao ";
        }
        $query .= " ORDER BY artigo.data DESC ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_categoria", $idCategoria, PDO::PARAM_INT);
        if ($codSituacao > 0) {
            $db->bindValue(":cod_situacao", $codSituacao, PDO::PARAM_INT);
        }
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\ArtigoInfo");
    }

    /**
     * @param int $idArtigo
     * @return ArtigoInfo
     */
    public function pegar($idArtigo) {
        $query = $this->query() . " 
            WHERE artigo.id_artigo = :id_artigo 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $idArtigo, PDO::PARAM_INT);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\ArtigoInfo");
    }

    /**
     * @param string $slug
     * @return ArtigoInfo
     */
    public function pegarPorSlug($slug) {
        $query = $this->query() . " 
            WHERE artigo.slug = :slug 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":slug", $slug);
        $db->execute();
        return DB::getValueClass($db, "\\ClippingBlog\\Model\\ArtigoInfo");
    }

    /**
     * @param PDOStatement $db
     * @param ArtigoInfo $artigo
     */
    private function preencherCampo($db, $artigo) {
        $db->bindValue(":data", $artigo->getData());
        $db->bindValue(":slug", $artigo->getSlug());
        $db->bindValue(":titulo", $artigo->getTitulo());
        $db->bindValue(":texto", $artigo->getTexto());
        $db->bindValue(":autor", $artigo->getAutor());
        $db->bindValue(":url_fonte", $artigo->getUrlFonte());
        $db->bindValue(":tags", trim($artigo->getTags()));
        $db->bindValue(":cod_situacao", $artigo->getCodSituacao(), PDO::PARAM_INT);
    }

    /**
     * @param ArtigoInfo $artigo
     * @return int
     */
    public function inserir($artigo) {
        $query = "
            INSERT INTO artigo (
                data_inclusao,
                ultima_alteracao,
                data,
                slug,
                titulo,
                texto,
                autor,
                url_fonte,
                tags,
                cod_situacao
            ) VALUES (
                NOW(),
                NOW(),
                :data,
                :slug,
                :titulo,
                :texto,
                :autor,
                :url_fonte,
                :tags,
                :cod_situacao
            )
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencherCampo($db, $artigo);
        $db->execute();
        return DB::lastInsertId();
    }

    /**
     * @param ArtigoInfo $artigo
     * @return int
     */
    public function alterar($artigo) {
        $query = "
            UPDATE artigo SET
                ultima_alteracao = NOW(),
                data = :data,
                slug = :slug,
                titulo = :titulo,
                texto = :texto,
                autor = :autor,
                url_fonte = :url_fonte,
                tags = :tags,
                cod_situacao = :cod_situacao
            WHERE id_artigo = :id_artigo
        ";
        $db = DB::getDB()->prepare($query);
        $this->preencherCampo($db, $artigo);
        $db->bindValue(":id_artigo", $artigo->getId(), PDO::PARAM_INT);
        $db->execute();
        return DB::lastInsertId();
    }

    /**
     * @param int $id_artigo
     */
    public function limparCategoria($id_artigo) {
        $query = "
            DELETE FROM artigo_categoria
            WHERE id_artigo = :id_artigo
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
    }

    /**
     * @param int $id_artigo
     * @param int $id_categoria
     */
    public function inserirCategoria($id_artigo, $id_categoria) {
        $query = "
            INSERT INTO artigo_categoria (
                id_artigo,
                id_categoria
            ) VALUES (
                :id_artigo,
                :id_categoria
            )
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->bindValue(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $db->execute();
    }

    /**
     * @param int $id_artigo
     */
    public function excluir($id_artigo) {
        $query = "
            DELETE FROM artigo 
            WHERE id_artigo = :id_artigo
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
    }
}