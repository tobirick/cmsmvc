<?php
namespace Core;

use Philo\Blade\Blade;
use \Illuminate\Support\Facades\Request;

class View {
    public function render($template, $args = [], $share = '') {
        $views = __DIR__ . '/../App/Views';
        $cache = __DIR__ . '/../cache';
        $this->blade = new Blade($views, $cache);

        if($share) {
            self::share($share);
        }

        echo $this->blade->view()->make($template, $args)->render();
    }

    public function share($share) {
        foreach($share as $shareItem) {
            $this->blade->view()->share($shareItem['key'], $shareItem['value']);
        }
    }
}