<?php
/**
 * This file is for  creating admin menu
 * This file also, include admin callback function
 *
 * Summary of Custom_admin_menu
 * @author Junaid bin jaman
 * @copyright (c) 2023
 * 
 * This is for creating custom admin menu 
 */

 // Admin user capability
define('USER_CAPABILITY', 'manage_options');
class Custom_admin_menu {
  function __construct () {
    add_action( 'admin_menu', array($this, 'user_activity_list' ));
  }

  public function user_activity_list () {
    add_menu_page(
      __( 'User activity list' ),
      __( 'User activity' ),
      USER_CAPABILITY,
      'user-activity001',
      array($this, 'user_activity_list_function'),
      'dashicons-universal-access'
    );
  }

  public function user_activity_list_function () {
    echo '<div class="wrap"  id="user-activity-list-wrapper"></div>';
  }
}

new Custom_admin_menu();