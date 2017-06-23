<?php

require dirname(__DIR__) . "/Core/config.inc.php";
require dirname(__DIR__) . "/Core/function.inc.php";
require dirname(__DIR__) . "/PHPCrawl/libs/PHPCrawler.class.php";

use ClippingBlog\BLL\ArtigoCrawler;

$pathJson = dirname(__DIR__) . "/Json";
$types = array( 'json' );
if ( $handle = opendir($pathJson) ) {
    while ( $entry = readdir( $handle ) ) {
        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
        if( in_array( $ext, $types ) ) {

            $configs = json_decode( file_get_contents( $pathJson . "/" . $entry ) );
            //var_dump($configs);
            foreach ($configs as $config) {
                if (!isset($config->url)) {
                    throw new Exception("URL não informada.");
                }
                if (!isset($config->test_file)) {
                    throw new Exception("Arquivo de test não informado.");
                }

                echo "Executando test: " . $config->url . " (" . $config->test_file . ")\n";

                $artigoCrawler = new ArtigoCrawler();
                $artigoCrawler->setRegexUrlArtigo( $config->url_artigo );
                $artigoCrawler->setRegexTitulo( $config->titulo );
                $artigoCrawler->setRegexData( $config->data );
                $artigoCrawler->setRegexAutor( $config->autor );
                $artigoCrawler->setAutorPadrao( $config->autor_padrao );
                $artigoCrawler->setRegexTexto( $config->texto );
                $artigoCrawler->setRegexUrlFonte( $config->url_fonte );
                $artigoCrawler->test($config->test_file);
            }
        }
    }
    closedir($handle);
}