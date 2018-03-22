<?php

namespace App\Controllers\Admin;

use \Core\BaseController;
use \App\Models\Settings;
use \Core\CSRF;

class SettingsController extends BaseController {
    public function index() {
        $settings = Settings::getSettings();
    
        self::render('admin/settings/index', [
            'settings' => $settings
        ]);
    }

    public function update() {
        CSRF::checkToken();
        if(isset($_POST)) {
            foreach($_POST['settings'] as $index => $setting) {
                Settings::updateSetting([
                    'name' => $index,
                    'value' => $setting
                ]);
            }
            self::redirect('/admin/settings');
        }
    }
}