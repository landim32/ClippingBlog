<?php

namespace ClippingBlog\Api;

use Exception;

require('common.inc.php');

header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json');

try {
    $classe = $_GET["classe"];
    $metodo = $_GET["metodo"];

    $pasta = "BLL";
    $classePath = dirname(__DIR__) . "/BLL/" . $classe . ".php";

    if (!file_exists($classePath)) {
        $pasta = "Api";
        $classePath = dirname(__DIR__) . "/api/" . $classe . ".php";
        if (!file_exists($classePath)) {
            throw new Exception(sprintf("A classe '%s' não existe!", $classePath));
        }
    }

    $args = null;
    if (($stream = fopen('php://input', "r")) !== FALSE) {
        $argsStr = stream_get_contents($stream);
        $args = json_decode($argsStr);
    }

    //var_dump($argsStr);

    require_once $classePath;


    $classeVar = "\\ClippingBlog\\" . $pasta . "\\" . $classe;
    $retorno = null;
    $bll = null;
    eval("\$bll = new " . $classeVar . "();");


    $cmd = "\$retorno = \$bll->" . $metodo . "(";
    if (is_array($args)) {
        $argsParam = array();
        for ($i = 0; $i < count($args); $i++) {
            $argsParam[] = "\$args[$i]";
        }
        $cmd .= implode(", ", $argsParam);
    } elseif (!is_null($args)) {
        $cmd .= "\$args";
    }
    $cmd .= ");";
    eval($cmd);

    echo json_encode($retorno);
}
catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}