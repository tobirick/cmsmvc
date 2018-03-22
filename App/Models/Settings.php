<?php

namespace App\Models;

use \Core\Model;
use PDO;

class Settings extends Model {

    public static function getSettings() {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM config');

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $settings = [];
        
        foreach($result as $setting) {
            $settings[$setting['name']] = $setting['value'];
        }
        return $settings;
    }

    public static function updateSetting($setting) {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE config SET value = :value WHERE name = :name');

        $stmt->execute([
            ':value' => $setting['value'],
            ':name' => $setting['name']
        ]);
    }

}