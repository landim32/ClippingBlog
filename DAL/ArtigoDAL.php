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
    const ORDENAR_DATA = "artigo.data DESC";
    const ORDENAR_PAGEVIEW = "artigo.pageview DESC";

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
                artigo.cod_situacao,
                artigo.pageview
            FROM artigo
        ";
    }

    /**
     * @param int $codSituacao
     * @param string $orderby
     * @param int $limite
     * @return ArtigoInfo[]
     */
    public function listar($codSituacao = 0, $orderby = "", $limite = 0) {
        $query = $this->query();
        if ($codSituacao > 0) {
            $query .= " WHERE artigo.cod_situacao = :cod_situacao ";
        }
        if (!isNullOrEmpty($orderby)) {
            $query .= " ORDER BY " . $orderby . " ";
        }
        if ($limite > 0) {
            $query .= " LIMIT " . $limite . " ";
        }
        $db = DB::getDB()->prepare($query);
        if ($codSituacao > 0) {
            $db->bindValue(":cod_situacao", $codSituacao, PDO::PARAM_INT);
        }
        $db->execute();
        return DB::getResult($db, "\\ClippingBlog\\Model\\ArtigoInfo");
    }

    /**
     * @param int $cod_situacao
     * @param string $palavra_chave
     * @param string $tag_slug
     * @param int $pg Pagina atual
     * @param int $numpg Quantidade de itens visualizados
     * @return ArtigoRetornoInfo
     */
    public function listarPaginado($cod_situacao = 0, $palavra_chave = '', $tag_slug = '', $pg = 1, $numpg = 10) {
        $query = $this->query(true);
        $query .= " WHERE (1=1) ";
        if (!isNullOrEmpty($palavra_chave)) {
            $query .= " AND (
                artigo.titulo LIKE :titulo OR
                artigo.texto LIKE :texto OR
                artigo.autor LIKE :autor
            ) ";
        }
        if (!isNullOrEmpty($tag_slug)) {
            $query .= " AND artigo.id_artigo IN (
                SELECT artigo_tag.id_artigo
                FROM artigo_tag
                INNER JOIN tag ON tag.id_tag = artigo_tag.id_tag
                WHERE tag.slug = :slug
            ) ";
        }
        if ($cod_situacao > 0) {
            $query .= " AND artigo.cod_situacao = :cod_situacao ";
        }
        $query .= " ORDER BY artigo.data DESC ";
        $pgini = (($pg - 1) * $numpg);
        $query .= " LIMIT " . $pgini . ", " . $numpg;

        //var_dump($query);

        $db = DB::getDB()->prepare($query);
        if (!isNullOrEmpty($palavra_chave)) {
            $palavra = '%' . $palavra_chave . '%';
            $db->bindValue(":titulo", $palavra, PDO::PARAM_STR);
            $db->bindValue(":texto", $palavra, PDO::PARAM_STR);
            $db->bindValue(":autor", $palavra, PDO::PARAM_STR);
        }
        if (!isNullOrEmpty($tag_slug)) {
            $db->bindValue(":slug", $tag_slug);
        }
        if ($cod_situacao > 0) {
            $db->bindValue(":cod_situacao", $cod_situacao, PDO::PARAM_INT);
        }
        $db->execute();
        $artigos = DB::getResult($db, "\\ClippingBlog\\Model\\ArtigoInfo");
        $total = DB::getDB()->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
        return new ArtigoRetornoInfo($artigos, $total);
    }

    /**
     * @param int $id_tag
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listarPorTag($id_tag, $codSituacao = 0) {
        $query = $this->query() . "
            INNER JOIN artigo_tag ON artigo_tag.id_artigo = artigo.id_artigo
            WHERE artigo_tag.id_tag = :id_tag
        ";
        if ($codSituacao > 0) {
            $query .= " AND artigo.cod_situacao = :cod_situacao ";
        }
        $query .= " ORDER BY artigo.data DESC ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_tag", $id_tag, PDO::PARAM_INT);
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
     * @param string $url_fonte
     * @return ArtigoInfo
     */
    public function pegarPorUrl($url_fonte) {
        $query = $this->query() . " 
            WHERE artigo.url_fonte = :url_fonte 
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":url_fonte", $url_fonte);
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
    public function limparTags($id_artigo) {
        $query = "
            DELETE FROM artigo_tag
            WHERE id_artigo = :id_artigo
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
    }

    /**
     * @param int $id_artigo
     * @param int $id_tag
     * @return int
     */
    public function pegarQuantidadeTag($id_artigo, $id_tag) {
        $query = "
            SELECT COUNT(*) AS 'quantidade'
            FROM artigo_tag
            WHERE id_artigo = :id_artigo
            AND id_tag = :id_tag
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->bindValue(":id_tag", $id_tag, PDO::PARAM_INT);
        $db->execute();
        return DB::getValue($db, "quantidade");
    }

    /**
     * @param int $id_artigo
     * @param int $id_tag
     */
    public function inserirTag($id_artigo, $id_tag) {
        //var_dump($id_artigo, $id_tag);
        $query = "
            INSERT INTO artigo_tag (
                id_artigo,
                id_tag
            ) VALUES (
                :id_artigo,
                :id_tag
            )
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->bindValue(":id_tag", $id_tag, PDO::PARAM_INT);
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

    /**
     * @param int $id_artigo
     */
    public function adicionarPageview($id_artigo) {
        $query = "
            UPDATE artigo SET
                pageview = pageview + 1
            WHERE id_artigo = :id_artigo
        ";
        $db = DB::getDB()->prepare($query);
        $db->bindValue(":id_artigo", $id_artigo, PDO::PARAM_INT);
        $db->execute();
    }
}