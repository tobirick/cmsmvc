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
        
        $html = $this->blade->view()->make($template, $args)->render();

        $buffer = $this->sanitaze($html);

        echo $buffer;
    }

    public function sanitaze($buffer) {
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
    
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
    
        $buffer = preg_replace($search, $replace, $buffer);
    
        return $buffer;
    } 

    public function share($share) {
        foreach($share as $shareItem) {
            $this->blade->view()->share($shareItem['key'], $shareItem['value']);
        }
    }
}