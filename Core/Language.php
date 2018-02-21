<?php

namespace Core;

class Language {
    protected $currentLanguage;
    protected $languageArray = [];
    protected $allLanguagesArray = [];

    public function setLanguage($lang) {
        if(file_exists(__DIR__ . '/languages/' . $lang . '.json')) {
            $this->currentLanguage = $lang;
            var_dump($lang);
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

        $array = json_decode($file, true);

        $this->languageArray = array_merge((array)$array, $this->languageArray);
    }

    public function getAllLanguages() {
        // TODO: Get all Languages
    }
}