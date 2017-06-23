<?php

namespace ClippingBlog\BLL;

use Exception;
use ClippingBlog\DAL\TagDAL;
use ClippingBlog\Model\TagInfo;

class TagBLL
{
    /**
     * Lista de tags
     * @return array<string,string>
     */
    public function listarTagPrincipal() {
        return array(
            "php" => "PHP",
            "pearl" => "Pearl",
            "sql" => "SQL",
            "regex" => "Regex",
            "expressoes regulares" => "Regex",
            "xamarin" => "Xamarin",
            "c#" => "C#",
            "htaccess" => "htaccess",
            "css" => "CSS",
            "less" => "Less",
            "bootstrap" => "Bootstrap",
            "javascript" => "Javascript",
            "jquery" => "jQuery",
            "ajax" => "Ajax",
            "qrcode" => "QRCode",
            ".net" => ".NET",
            "angular" => "Angular",
            "angularjs" => "AngularJs",
            "visual studio" => "Visual Studio",
            "emprego" => "Emprego",
            "segurança" => "Segurança",
            "wordpress" => "Wordpress",
            "magento" => "Magento",
            "android" => "Android",
            "ios" => "iOS",
            "apple" => "iOS",
        );
    }

    /**
     * @return TagInfo[]
     */
    public function listar() {
        $dal = new TagDAL();
        return $dal->listar();
    }

    /**
     * @return TagInfo[]
     */
    public function listarPopular() {
        $dal = new TagDAL();
        return $dal->listarPopular();
    }

    /**
     * @param int $id_tag
     * @return TagInfo
     */
    public function pegar($id_tag) {
        $dal = new TagDAL();
        return $dal->pegar($id_tag);
    }

    /**
     * @param string $slug
     * @return TagInfo
     */
    public function pegarPorSlug($slug) {
        $dal = new TagDAL();
        return $dal->pegarPorSlug($slug);
    }

    /**
     * @param string $nome
     * @return TagInfo
     */
    public function pegarPorNome($nome) {
        $dal = new TagDAL();
        return $dal->pegarPorNome($nome);
    }

    /**
     * @param int $id_tag
     * @param string $slug
     * @return string
     */
    private function slugValido($id_tag, $slug)
    {
        $tag = $this->pegarPorSlug($slug);
        if (!is_null($tag) && $tag->getId() != $id_tag) {
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
     * @param TagInfo $tag
     * @throws Exception
     */
    private function validar(&$tag) {
        if (is_null($tag)) {
            throw new Exception("Tag não informada.");
        }
        if (isNullOrEmpty($tag->getNome())) {
            throw new Exception("Preencha a Tag.");
        }
        if (isNullOrEmpty($tag->getSlug())) {
            $tag->setSlug( sanitize_slug($tag->getNome()) );
        }
        //$slug = $this->slugValido($tag->getId(), $tag->getSlug());
        $tag->setSlug( strtolower( $tag->getSlug() ) );
    }

    /**
     * @param TagInfo $tag
     * @return int
     */
    public function inserir($tag) {
        $this->validar($tag);

        $dal = new TagDAL();
        return $dal->inserir($tag);
    }

    /**
     * @param TagInfo $tag
     * @return int
     */
    public function inserirOuAlterar($tag) {
        $this->validar($tag);
        $tagOld = $this->pegarPorSlug($tag->getSlug());
        if (!is_null($tagOld)) {
            return $tagOld->getId();
        }
        else {
            $tagOld = $this->pegarPorNome($tag->getNome());
            if (!is_null($tagOld)) {
                return $tagOld->getId();
            }
            else {
                $dal = new TagDAL();
                return $dal->inserir($tag);
            }
        }
    }

    /**
     * @param TagInfo $tag
     */
    public function alterar($tag) {
        $this->validar($tag);

        $dal = new TagDAL();
        $dal->alterar($tag);
    }

    /**
     * @param int $id_tag
     */
    public function excluir($id_tag) {
        $dal = new TagDAL();
        $dal->excluir($id_tag);
    }

}