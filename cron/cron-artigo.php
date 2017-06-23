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

                echo "Executando crawler na url: " . $config->url . "\n";

                $artigoCrawler = new ArtigoCrawler();
                $artigoCrawler->setRegexUrlArtigo( $config->url_artigo );
                $artigoCrawler->setRegexTitulo( $config->titulo );
                $artigoCrawler->setRegexData( $config->data );
                $artigoCrawler->setRegexAutor( $config->autor );
                $artigoCrawler->setAutorPadrao( $config->autor_padrao );
                $artigoCrawler->setRegexTexto( $config->texto );
                $artigoCrawler->setRegexUrlFonte( $config->url_fonte );
                //$artigoCrawler->test($config->test_file);

                $artigoCrawler->setURL($config->url);
                //$artigoCrawler->setPort(443);
                $artigoCrawler->setUserAgentString("Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
                $artigoCrawler->addContentTypeReceiveRule("#text/html#");
                $artigoCrawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|js|css)$# i");
                $artigoCrawler->enableCookieHandling(true);
                $artigoCrawler->setTrafficLimit(1024 *1024 * 1024);
                $artigoCrawler->go();

                $report = $artigoCrawler->getProcessReport();

                echo "Resumo:\n";
                echo "Links seguindo: " . $report->links_followed . "\n";
                echo "Artigos recebidos: ".$report->files_received . "\n";
                echo "Bytes recebidos: ".$report->bytes_received." bytes\n";
                echo "Tempo de execução: ".$report->process_runtime." sec\n";
            }
        }
    }
    closedir($handle);
}