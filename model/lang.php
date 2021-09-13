<?php 
    namespace Model;

    include_once __DIR__ . '/config.php';

    class Lang extends Config{

        protected $language;
        protected $file;

        public function __construct(string $language = null) {
            $this->language = (is_null($language)) ? (Config::DEFAULT_LANGUAGE) : ((in_array($language, scandir(__DIR__ . '/../' . Config::LANGUAGE_FILE))) ? $language : Config::DEFAULT_LANGUAGE);
            $this->file = json_decode(file_get_contents(__DIR__ . '/../' . Config::LANGUAGE_FILE . $this->language . '.json'), true);
            $this->set($this->language);
        }

        public function getFile(){
            return $this->file;
        }

        public function getLanguage(){
            return $this->language;
        }

        public function set($language) {
            $_SESSION['l'] = $language;
        }
    }