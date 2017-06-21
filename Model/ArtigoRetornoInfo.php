<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 21/06/2017
 * Time: 08:39
 */

namespace ClippingBlog\Model;

class ArtigoRetornoInfo
{
    private $artigos;
    private $total;

    /**
     * ArtigoRetornoInfo constructor.
     * @param ArtigoInfo[] $artigos
     * @param int $total
     */
    public function __construct($artigos, $total)
    {
        $this->artigos = $artigos;
        $this->total = $total;
    }

    /**
     * @return ArtigoInfo[]
     */
    public function getArtigos() {
        return $this->artigos;
    }

    /**
     * @return int
     */
    public function getTotal() {
        return $this->total;
    }
}