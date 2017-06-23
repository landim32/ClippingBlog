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
        <h4><i class="fa fa-search"></i> Busca no Blog</h4>
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        <!-- /input-group -->
    </div>
    <?php $tagsArray = array_partition($tags, 3); ?>
    <div class="well">
        <h4><i class="fa fa-tags"></i> Tags Populares:</h4>
        <div class="row">
            <?php foreach ($tagsArray as $col) : ?>
            <div class="col-md-4">
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
        <h4><i class="fa fa-thumbs-o-up"></i> Follow me!</h4>
        <ul>
            <p>
                <a title="Facebook" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-facebook fa-stack-1x"></i>
                    </span>
                </a>
                <a title="Twitter" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x"></i>
                    </span>
                </a>
                <a title="Google+" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-google-plus fa-stack-1x"></i>
                    </span>
                </a>
                <a title="Linkedin" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-linkedin fa-stack-1x"></i>
                    </span>
                </a>
                <a title="GitHub" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-github fa-stack-1x"></i>
                    </span>
                </a>
                <a title="Bitbucket" href="">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-bitbucket fa-stack-1x"></i>
                    </span>
                </a>
            </p>
        </ul>
    </div>
    <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
    <!-- Sidebar Banner 2 -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-5769680090282398"
         data-ad-slot="9272963841"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <?php endif; ?>
</div>