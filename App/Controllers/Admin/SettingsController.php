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
        if(!self::checkPermission('change_settings')) {         
            self::addFlash('error', self::getTrans('You have not the permission to do that!'));
            self::redirect('/admin/dashboard');
        }
        CSRF::checkToken();
        if(isset($_POST)) {
           if(!isset($_POST['settings']['maintenance_mode'])) {
               Settings::updateSetting([
                  'name' => 'maintenance_mode',
                  'value' => 0
            ]);
           }
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