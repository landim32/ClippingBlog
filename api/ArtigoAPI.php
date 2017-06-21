<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 21/06/2017
 * Time: 15:38
 */

namespace ClippingBlog\Api;

use stdClass;
use DateTime;
use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\Model\ArtigoInfo;

class ArtigoAPI extends ArtigoBLL
{
    /**
     * @param stdClass $artigo
     */
    public function alterar($artigo)
    {
        $artigoNovo = ArtigoInfo::fromJson($artigo);
        $dataAntiga = $artigoNovo->getData();
        $dataNova = DateTime::createFromFormat('d/m/Y', $dataAntiga)->format('Y-m-d');
        $artigoNovo->setData($dataNova);
        $artigoLocal = $this->pegar( $artigoNovo->getId() );
        $artigoLocal->setTitulo( $artigoNovo->getTitulo() );
        $artigoLocal->setData( $artigoNovo->getData() );
        $artigoLocal->setTexto( $artigoNovo->getTexto() );
        $artigoLocal->setTags( $artigoNovo->getTags() );
        $artigoLocal->setAutor( $artigoNovo->getAutor() );
        $artigoLocal->setCodSituacao( $artigoNovo->getCodSituacao() );
        parent::alterar($artigoLocal);
    }
}