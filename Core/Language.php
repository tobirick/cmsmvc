<?php

namespace Core;

class Language {
    protected $currentLanguage = '';
    protected $languageArray = [];
    protected $allLanguagesArray = [];

    public function __construct() {
        $this->setLanguage('en');
    }

    public function setLanguage($lang) {
        if(file_exists(__DIR__ . '/languages/' . $lang . '.json')) {
            $this->currentLanguage = $lang;
            $this->loadLanguage($lang);
        }
    }

    public function getLanguagesArray() {
        return $this->languageArray;
    }

    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }

    public function loadLanguage($lang) {
        $file = file_get_contents(__DIR__ . '/languages/' . $lang . '.json');

        $this->languageArray = json_decode($file, true);
    }

    public function getAllLanguages() {
        // TODO: Get all Languages
    }
}