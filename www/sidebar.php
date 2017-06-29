<?php
use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\BLL\TagBLL;
use ClippingBlog\BLL\App;
use ClippingBlog\Model\ArtigoInfo;

$regraArtigo = new ArtigoBLL();
$regraTag = new TagBLL();
$artigo = App::getArtigo();

$artigos = $regraArtigo->listarPopular(ArtigoInfo::ATIVO, 7);
$tags = $regraTag->listarPopular();

?>
<div class="col-md-4 form-vertical">
    <?php if (!is_null($artigo)) : ?>
    <div id="artigo-botao" class="panel panel-default" style="display: none;">
        <div class="panel-body">
            <div class="form-group">
                <label for="cod_situacao" class="control-label"> Situação:</label>
                <select id="cod_situacao" name="cod_situacao" class="form-control">
                    <?php foreach ($regraArtigo->listarSituacao() as $cod_situacao => $nome) : ?>
                        <option value="<?php echo $cod_situacao; ?>"><?php echo $nome; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button type="button" id="artigo-gravar" data-artigo="<?php echo $artigo->getId(); ?>" class="btn btn-primary"><i class="fa fa-check"></i> Gravar</button>
            <button type="button" id="artigo-cancelar" data-artigo="<?php echo $artigo->getId(); ?>" class="btn btn-default"><i class="fa fa-remove"></i> Cancelar</button>
        </div>
    </div>
    <?php endif; ?>
    <div class="well">
        <form method="GET" action="<?php echo get_tema_path(); ?>">
        <h4><i class="fa fa-search"></i> Busca no Blog</h4>
        <div class="input-group">
            <input type="text" name="p" class="form-control" placeholder="Preencha a palavra-chave" value="<?php echo $_GET['p']?>" />
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            </span>
        </div>
        <!-- /input-group -->
    </div>
    <?php $tagsArray = array_partition($tags, 2); ?>
    <div class="well">
        <h4><i class="fa fa-tags"></i> Tags Populares:</h4>
        <div class="row">
            <?php foreach ($tagsArray as $col) : ?>
            <div class="col-md-6">
                <ul class="list-unstyled">
                <?php foreach ($col as $tag) : ?>
                    <li>
                        <a href="<?php echo $tag->getUrl(); ?>">
                            <span class="badge"><?php echo $tag->getNome(); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
        <!-- Sidebar Banner 1 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:336px;height:280px"
             data-ad-client="ca-pub-5769680090282398"
             data-ad-slot="6319497441"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    <?php endif; ?>
    <div class="well">
        <h4><i class="fa fa-fire"></i> Artigos Populares:</h4>
        <ul>
            <?php foreach ($artigos as $artigo) : ?>
            <li><a href="<?php echo $artigo->getUrl(); ?>"><?php echo $artigo->getTitulo(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="well">
        <h4><i class="fa fa-thumbs-o-up"></i> Siga-nos!</h4>
        <ul>
            <p>
                <?php if (defined("FACEBOOK_URL")) : ?>
                <a title="Facebook" target="_blank" href="<?php echo FACEBOOK_URL; ?>">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-facebook fa-stack-1x"></i>
                    </span>
                </a>
                <?php endif; ?>
                <?php if (defined("TWITTER_URL")) : ?>
                <a title="Twitter" target="_blank" href="<?php echo TWITTER_URL; ?>">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x"></i>
                    </span>
                </a>
                <?php endif; ?>
                <!--a title="Google+" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-google-plus fa-stack-1x"></i>
                    </span>
                </a-->
                <?php if (defined("LINKEDIN_URL")) : ?>
                <a title="Linkedin" target="_blank" href="<?php echo LINKEDIN_URL; ?>">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-linkedin fa-stack-1x"></i>
                    </span>
                </a>
                <?php endif; ?>
                <?php if (defined("GITHUB_URL")) : ?>
                <a title="GitHub" target="_blank" href="<?php echo GITHUB_URL; ?>">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-github fa-stack-1x"></i>
                    </span>
                </a>
                <?php endif; ?>
            </p>
        </ul>
    </div>
    <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
        <!-- Sidebar Banner 3 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:336px;height:280px"
             data-ad-client="ca-pub-5769680090282398"
             data-ad-slot="7656629846"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    <?php endif; ?>
</div>