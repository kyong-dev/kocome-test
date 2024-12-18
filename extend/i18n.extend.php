<?php
// include G5_PATH.'/lang/I18n.php';
include_once G5_PATH . '/lang/i18n.php';
$i18n = new i18n();
function __($key, $params=[]) {
    global $i18n;
    return $i18n->__($key, $params);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$language = $_SESSION['language'] ?? 'ko';

$i18n->setLanguage($language);