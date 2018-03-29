<?php

namespace Core;

abstract class Permission {
  const add_page = 1;
  const edit_page = 4;
  const delete_page = 5;

  const upload_media = 6;
  const edit_media = 7;
  const delete_media = 8;

  const add_menu = 9;
  const edit_menu = 10;
  const delete_menu = 11;

  const add_theme = 15;
  const edit_theme = 16;
  const delete_theme = 17;

  const change_settings = 18;

  const add_pagebuilder_item = 19;
  const edit_pagebuilder_item = 20;
  const delete_pagebuilder_item = 21;

  const view_user_roles = 22;
  const add_user_roles = 23; // Unused
  const edit_user_roles = 24; // Unused
  const delete_user_roles = 25; // Unused

  const add_user = 26;
  const edit_user = 27;
  const delete_user = 28;
  const view_users = 29;

  public static function getPerm($perm) {
    return constant('self::'. $perm);
  }
}