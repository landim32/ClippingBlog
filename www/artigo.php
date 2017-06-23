<?php

use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\BLL\UsuarioBLL;
use ClippingBlog\BLL\App;
use ClippingBlog\Model\ArtigoInfo;

$regraArtigo = new ArtigoBLL();
$artigo = $regraArtigo->pegarPorSlug( App::getSlug() );
App::setArtigo( $artigo );

//var_dump(SLUG, $artigo);

?>
<?php require( "header.php" ); ?>
    <div class="container" style="padding-top: 40px;">
        <form class="form-horizontal" method="POST">
        <div class="col-md-8">
            <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
                <!-- FullBanner -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-5769680090282398"
                     data-ad-slot="7796230641"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            <?php endif; ?>
            <h1 id="artigo-titulo"><?php echo $artigo->getTitulo(); ?></h1>
            <div class="form-group">
                <label class="col-md-2 control-label text-right">
                    <i class="fa fa-tags"></i> Tags:
                </label>
                <div id="artigo-tags" class="<?php echo is_null($usuario) ? "col-md-10" : "col-md-8"; ?>">
                    <div class="form-span">
                        <?php foreach ($artigo->listarTag() as $tag) : ?>
                            <a href="<?php echo get_tema_path() . "/tag/" . $tag->getSlug(); ?>">
                                <span class="badge"><?php echo $tag->getNome(); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if (!is_null($usuario)) : ?>
                <div id="artigo-situacao" class="col-md-2 text-right">
                    <?php
                    switch ($artigo->getCodSituacao()) {
                        case ArtigoInfo::ATIVO:
                            echo "<label class='label label-success'>Ativo</label>";
                            break;
                        case ArtigoInfo::INATIVO:
                            echo "<label class='label label-danger'>Inativo</label>";
                            break;
                        case ArtigoInfo::RASCUNHO:
                            echo "<label class='label label-warning'>Rascunho</label>";
                            break;
                    }
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label text-right">
                    <i class="fa fa-clock-o"></i> Publicado:
                </label>
                <div id="artigo-data" class="col-md-4">
                    <div class="form-span">
                        <?php echo $artigo->getDataStr(); ?>
                    </div>
                </div>
                <label class="col-md-2 control-label text-right">
                    &nbsp; <i class="fa fa-user"></i> Autor:
                </label>
                <div id="artigo-autor" class="col-md-4">
                    <div class="form-span">
                        <?php echo $artigo->getAutor(); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr />
            <div id="artigo-texto">
                <?php echo $artigo->getTexto(); ?>
            </div>
            <hr />
            <div>
                Fonte: <a href="<?php echo $artigo->getUrlFonte(); ?>"><?php echo $artigo->getUrlFonte(); ?></a>
            </div>
            <?php if (!(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
            <div id="disqus_thread"></div>
            <script>

                /**
                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                /*
                 var disqus_config = function () {
                 this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                 this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                 };
                 */
                (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document, s = d.createElement('script');
                    s.src = 'https://emagine-blog.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            <?php endif; ?>
        </div>
        </form>
        <?php require( "sidebar.php" ); ?>
    </div><!-- /.container -->
<?php $regraArtigo->adicionarPageview($artigo->getId()); ?>
<?php require( "footer.php" ); ?>