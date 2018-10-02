<?php

/**
 * Conecta com o MySQL usando PDO
 */
function db_connect() {
    $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    return $PDO;
}

/**
 * Converte datas entre os padrões ISO e brasileiro
 * Fonte: <a class="vglnk" href="http://rberaldo.com.br/php-conversao-de-datas-formato-brasileiro-e-formato-iso/" rel="nofollow"><span>http</span><span>://</span><span>rberaldo</span><span>.</span><span>com</span><span>.</span><span>br</span><span>/</span><span>php</span><span>-</span><span>conversao</span><span>-</span><span>de</span><span>-</span><span>datas</span><span>-</span><span>formato</span><span>-</span><span>brasileiro</span><span>-</span><span>e</span><span>-</span><span>formato</span><span>-</span><span>iso</span><span>/</span></a>
 */
function dateConvert($date) {
    if (!strstr($date, '/')) {
        // $date está no formato ISO (yyyy-mm-dd) e deve ser convertida
        // para dd/mm/yyyy
        sscanf($date, '%d-%d-%d', $y, $m, $d);
        return sprintf('%02d/%02d/%04d', $d, $m, $y);
    } else {
        // $date está no formato brasileiro e deve ser convertida para ISO
        sscanf($date, '%d/%d/%d', $d, $m, $y);
        return sprintf('%04d-%02d-%02d', $y, $m, $d);
    }

    return false;
}

/**
 * Calcula a idade a partir da data de nascimento
 *
 * Sobre a classe DateTime: <a class="vglnk" href="http://rberaldo.com.br/php-usando-a-classe-nativa-datetime/" rel="nofollow"><span>http</span><span>://</span><span>rberaldo</span><span>.</span><span>com</span><span>.</span><span>br</span><span>/</span><span>php</span><span>-</span><span>usando</span><span>-</span><span>a</span><span>-</span><span>classe</span><span>-</span><span>nativa</span><span>-</span><span>datetime</span><span>/</span></a>
 */
function calculateAge($birthdate) {
    $now = new DateTime();
    $diff = $now->diff(new DateTime($birthdate));

    return $diff->y;
}
