<?php

$versao = filter_input(INPUT_GET, 'versao', FILTER_DEFAULT);
$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

require_once('../control/BaseDadosCTR.class.php');

if (isset($info)):

    $baseDadosCTR = new BaseDadosCTR();
    echo $retorno = $baseDadosCTR->dados($versao, $info);

endif;
