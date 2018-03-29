<?php

namespace Core;

use DirectoryIterator;

class Language {
    protected $currentLanguage = '';
    protected $languageArray = [];
    protected $allLanguagesArray = [];

    public function getTrans($string) {
      return $this->languageArray['translations'][$string];
    }

    public function __construct($lang = 'en') {
        $this->setLanguage($lang);
    }

    public function setLanguage($lang) {
        if(file_exists(__DIR__ . '/languages/' . $lang . '.json')) {
            $this->currentLanguage = $lang;
            $this->loadLanguage($lang);
        }
    }

    public function getLanguagesArray() {
        return $this->languageArray['translations'];
    }

    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }

    public function loadLanguage($lang) {
        $file = file_get_contents(__DIR__ . '/languages/' . $lang . '.json');

        $this->languageArray = json_decode($file, true);
    }

    public function getAllLanguages() {
        foreach (new DirectoryIterator(__DIR__ . '/languages') as $lang) {
            if($lang->isDot()) continue;
            $fileContent = json_decode(file_get_contents(__DIR__ . '/languages/' . $lang->getBasename('.json') . '.json'), true);

            $this->allLanguagesArray[] = [
                'shortName' => $lang->getBasename('.json'),
                'longName' => $fileContent['settings']['name']
            ];
        }

        return $this->allLanguagesArray;
    }
}