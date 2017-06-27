<?php

use ClippingBlog\BLL\App;
use ClippingBlog\Model\ArtigoInfo;

define('ARTIGO_QUANTIDADE', 1);
define('RESUMO_TAMANHO', 440);
$artigos = App::getArtigos();
/** @var ArtigoInfo[] $artigosPrincipal */
$artigosPrincipal = array_slice($artigos,0, ARTIGO_QUANTIDADE);
/** @var ArtigoInfo[] $artigosSecundario */
$artigosSecundario = array_slice($artigos,ARTIGO_QUANTIDADE);

?>
<table width="600" border="0" cellspacing="0" valign="center" style="background-color: #FFF;">
    <?php foreach ($artigosPrincipal as $artigo) : ?>
    <tr>
        <td style="padding: 10px 50px 10px 50px;">
            <h1><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></h1>
            <p>
                <i><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getDataStr(); ?></a></i><br />
                <a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getResumo(RESUMO_TAMANHO); ?></a>
            </p>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td style="padding: 10px 50px 10px 50px;">
            <h2>Artigos relacionados</h2>
            <ul>
                <?php foreach ($artigosSecundario as $artigo) : ?>
                    <li><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </td>
    </tr>
</table>