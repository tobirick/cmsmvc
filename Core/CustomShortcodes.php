<?php

namespace Core;

class CustomShortcodes {
  public static function footerMenu($methodParams) {
    $array = explode(' ', $methodParams);
    for($i = 0; $i < sizeof($array); $i++) {
      $varArray = explode('=', $array[$i]);
      ${$varArray[0]} = $varArray[1];
    }

    $menuItems = \App\Models\Menu::getMenuItemsWithSlugByMenuID($id);
    $currentPublicLanguage = Router::getCurrentPublicLanguage();

    $html = '<ul>';

    foreach($menuItems as $menuItem) {
      $url = '';
      if($currentPublicLanguage['id'] === $menuItem['language_id']) {
        $html .= '<li><a href="/' . $currentPublicLanguage['iso'] . '/' . $menuItem['slug'] . '">' . $menuItem['name'] . '</a></li>';
      }
    }

    $html .= '</ul>';

    return $html;
  }
}