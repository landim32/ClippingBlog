<?php

use ClippingBlog\BLL\App;
use ClippingBlog\BLL\UsuarioBLL;

$artigo = App::getArtigo();

?>
<script src="<?php echo get_tema_path(); ?>/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo get_tema_path(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_tema_path(); ?>/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo get_tema_path(); ?>/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo get_tema_path(); ?>/js/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="<?php echo get_tema_path(); ?>/js/ie10-viewport-bug-workaround.js"></script>

<script src="<?php echo get_tema_path(); ?>/codemirror/lib/codemirror.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/addon/hint/show-hint.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/addon/hint/xml-hint.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/addon/hint/html-hint.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/mode/css/css.js"></script>
<script src="<?php echo get_tema_path(); ?>/codemirror/mode/htmlmixed/htmlmixed.js"></script>

<script src="<?php echo get_tema_path(); ?>/js/app.js"></script>
<?php if (!is_null($artigo) && !(UsuarioBLL::pegarUsuarioAtual() > 0)) : ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ee2a98d1c6be136"></script>
<?php endif; ?>
</body>
</html>