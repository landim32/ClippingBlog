<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 20/06/2017
 * Time: 08:51
 */

namespace ClippingBlog\BLL;

use ClippingBlog\Model\ArtigoRetornoInfo;
use ClippingBlog\Model\TagInfo;
use Exception;
use ClippingBlog\DAL\DB;
use ClippingBlog\DAL\ArtigoDAL;
use ClippingBlog\DAL\TagDAL;
use ClippingBlog\Model\ArtigoInfo;

class ArtigoBLL
{
    /**
     * @return array<int, string>
     */
    public function listarSituacao() {
        return array(
            ArtigoInfo::ATIVO => "Ativo",
            ArtigoInfo::RASCUNHO => "Rascunho",
            ArtigoInfo::INATIVO => "Inativo"
        );
    }

    /**
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listar($codSituacao = 0) {
        $dal = new ArtigoDAL();
        return $dal->listar($codSituacao, ArtigoDAL::ORDENAR_DATA);
    }

    /**
     * @param int $codSituacao
     * @param int $limite
     * @return ArtigoInfo[]
     */
    public function listarPopular($codSituacao = 0, $limite = 0) {
        $dal = new ArtigoDAL();
        return $dal->listar($codSituacao, ArtigoDAL::ORDENAR_PAGEVIEW, $limite);
    }

    /**
     * @param int $cod_situacao
     * @param string $tag_slug
     * @param int $pg Pagina atual
     * @param int $numpg Quantidade de itens visualizados
     * @return ArtigoRetornoInfo
     */
    public function listarPaginado($cod_situacao = 0, $tag_slug = "", $pg = 1, $numpg = 10) {
        $dal = new ArtigoDAL();
        return $dal->listarPaginado($cod_situacao, '', $tag_slug, $pg, $numpg);
    }

    /**
     * @param string $palavra_chave
     * @param int $cod_situacao
     * @param int $pg
     * @param int $numpg
     * @return ArtigoRetornoInfo
     */
    public function buscaPaginado($palavra_chave, $cod_situacao = 0, $pg = 1, $numpg = 10) {
        $dal = new ArtigoDAL();
        return $dal->listarPaginado($cod_situacao, $palavra_chave, '', $pg, $numpg);
    }

    /**
     * @param int $id_tag
     * @param int $codSituacao
     * @return ArtigoInfo[]
     */
    public function listarPorTag($id_tag, $codSituacao = 0) {
        $dal = new ArtigoDAL();
        return $dal->listarPorTag($id_tag, $codSituacao);
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
     * @param string $url_fonte
     * @return ArtigoInfo
     */
    public function pegarPorUrl($url_fonte) {
        $dal = new ArtigoDAL();
        return $dal->pegarPorUrl($url_fonte);
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
     * @param int $id_tag
     * @param string $slug
     * @return string
     */
    private function slugValido($id_tag, $slug)
    {
        $artigo = $this->pegarPorSlug($slug);
        if (!is_null($artigo) && $artigo->getId() != $id_tag) {
            $out = array();
            preg_match_all("#(.*?)-(\d{1,2})#i", $slug, $out, PREG_PATTERN_ORDER);
            if (!isNullOrEmpty($out[1][0]) && is_numeric($out[2][0])) {
                $slug = $this->slugValido($id_tag, $out[1][0] . "-" . (intval($out[2][0]) + 1));
            } else
                $slug = $this->slugValido($id_tag, $slug . '-2');
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
        $titulo = trim( strip_tags( trim( $artigo->getTitulo() ) ) );
        $artigo->setTitulo( $titulo );

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
     * @param int $id_artigo
     * @param int $id_tag
     */
    private function inserirTag($id_artigo, $id_tag) {
        $dal = new ArtigoDAL();
        if (!($dal->pegarQuantidadeTag($id_artigo, $id_tag) > 0)) {
            $dal->inserirTag($id_artigo, $id_tag);
        }
    }

    /**
     * @param ArtigoInfo $artigo
     */
    private function atualizarTag($artigo) {
        $dal = new ArtigoDAL();
        $regraTag = new TagBLL();
        $dal->limparTags($artigo->getId());
        foreach ($artigo->listarTag() as $tag) {
            if ($tag->getId() > 0) {
                $id_tag = $tag->getId();
            }
            else {
                $id_tag = $regraTag->inserirOuAlterar($tag);
            }
            $this->inserirTag($artigo->getId(), $id_tag);
        }
    }

    /**
     * @param ArtigoInfo $artigo
     * @throws Exception
     * @return int
     */
    public function inserir($artigo) {
        $this->validar($artigo);
        $id_artigo = null;
        $dal = new ArtigoDAL();
        try {
            DB::beginTransaction();
            $id_artigo = $dal->inserir($artigo);
            $artigo->setId($id_artigo);
            $this->atualizarTag($artigo);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return $id_artigo;
    }

    /**
     * @param ArtigoInfo $artigo
     * @throws Exception
     */
    public function alterar($artigo) {
        $this->validar($artigo);
        $dal = new ArtigoDAL();
        try {
            DB::beginTransaction();
            $dal->alterar($artigo);
            $this->atualizarTag($artigo);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $id_artigo
     */
    public function excluir($id_artigo) {
        $dal = new ArtigoDAL();
        try {
            DB::beginTransaction();
            $dal->limparTags($id_artigo);
            $dal->excluir($id_artigo);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * @param int $id_artigo
     */
    public function adicionarPageview($id_artigo) {
        $dal = new ArtigoDAL();
        $dal->adicionarPageview($id_artigo);
    }

    /**
     * @param ArtigoInfo $artigo
     * @return bool
     */
    public function gerarTagAutomatico($artigo) {
        $regraTag = new TagBLL();
        $tags = $regraTag->listarTagPrincipal();

        foreach ($tags as $slug => $nome) {
            $titulo = $artigo->getTitulo();
            $texto = $artigo->getTexto();
            if (!(stripos($titulo, $slug) === false)) {
                $tag = new TagInfo();
                $tag->setId( 0 );
                $tag->setNome( $nome );
                $artigo->adicionarTag($tag);
            }
            else {
                if (!(stripos($texto, $slug) === false)) {
                    $tag = new TagInfo();
                    $tag->setId( 0 );
                    $tag->setNome( $nome );
                    $artigo->adicionarTag($tag);
                }
            }
            $this->alterar($artigo);
        }
    }

    /**
     * @param ArtigoInfo[] $artigos
     * @return string
     */
    public function gerarEmailMarketing($artigos) {
        App::setArtigos($artigos);
        ob_start();
        include dirname(__DIR__) . "/Template/email-header.inc.php";
        include dirname(__DIR__) . "/Template/email-body.inc.php";
        include dirname(__DIR__) . "/Template/email-footer.inc.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}