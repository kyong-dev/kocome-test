<?php
class i18n {
    private $language;       // 현재 언어 코드
    private $translations;   // 번역 데이터 배열
    private $langDirectory;  // 언어 파일이 위치한 디렉토리

    public function __construct($defaultLanguage = 'ko', $langDirectory = __DIR__) {
        $this->langDirectory = rtrim($langDirectory, '/');
        $this->translations = [];

        // 세션 시작
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 세션에서 언어 설정 로드
        $this->language = $_SESSION['language'] ?? $defaultLanguage;
        $this->loadLanguageFile();
    }

    // 언어 파일 로드
    private function loadLanguageFile() {
        $filePath = "{$this->langDirectory}/{$this->language}.php";
        if (file_exists($filePath)) {
            $this->translations = include($filePath);
        } else {
            throw new Exception("Language file '{$filePath}' not found.");
        }
    }

    // 현재 언어 설정
    public function setLanguage($language) {
        $this->language = $language;
        $_SESSION['language'] = $language; // 세션에 저장
        $this->loadLanguageFile();
    }

    // 현재 언어 가져오기
    public function getLanguage() {
        return $this->language;
    }

    // 번역 함수
    public function __($key, $params=[]) {
        if (isset($this->translations[$key])) {
            $message = $this->translations[$key];
            if (!empty($params)) {
                return vsprintf($message, $params);
            }
            return $message;
        }
        return $key; // 키가 없으면 키 자체 반환
    }
}

$i18n = new i18n();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $language = $_POST['language'];
    
    // 세션에 언어 저장
    $_SESSION['language'] = $language;

    // 저장된 세션 언어 출력 (디버깅 목적)
    echo "Session language set to: " . $_SESSION['language'];

    // 언어 설정 시도
    try {
        $i18n->setLanguage($_SESSION['language']);
        echo 'Success';
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
    exit; // exit는 echo 실행 후 더 이상의 처리를 중지시키기 위함
}