<?php
use ClippingBlog\BLL\ArtigoBLL;
use ClippingBlog\BLL\App;

$regraArtigo = new ArtigoBLL();
$artigo = App::getArtigo();

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
        <h4><i class="fa fa-search"></i> Blog Search...</h4>
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
    <div class="well">
        <h4><i class="fa fa-tags"></i> Popular Tags:</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <li><a href=""><span class="badge badge-info">Windows 8</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">C#</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">Windows Forms</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">WPF</span></a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <li><a href=""><span class="badge badge-info">Bootstrap</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">Joomla!</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">CMS</span></a>
                    </li>
                    <li><a href=""><span class="badge badge-info">Java</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="well">
        <h4><i class="fa fa-thumbs-o-up"></i> Follow me!</h4>
        <ul>
            <p><a title="Facebook" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x"></i></span></a> <a title="Twitter" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a> <a title="Google+" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x"></i></span></a> <a title="Linkedin" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a> <a title="GitHub" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-github fa-stack-1x"></i></span></a> <a title="Bitbucket" href=""><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-bitbucket fa-stack-1x"></i></span></a></p>
        </ul>
    </div>
    <!-- /well -->
    <!-- /well -->
    <div class="well">
        <h4><i class="fa fa-fire"></i> Popular Posts:</h4>
        <ul>
            <li><a href="">WPF vs. Windows Forms-Which is better?</a></li>
            <li><a href="">How to create responsive website with Bootstrap?</a></li>
            <li><a href="">The best Joomla! templates 2014</a></li>
            <li><a href="">ASP .NET cms list</a></li>
            <li><a href="">C# Hello, World! program</a></li>
            <li><a href="">Java random generator</a></li>
        </ul>
    </div>
</div>