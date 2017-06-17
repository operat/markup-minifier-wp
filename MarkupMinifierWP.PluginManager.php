<?php
/*
 * PluginManager
 */

class MarkupMinifierWP_PluginManager {

   public static function startMinifier() {
      if (!is_admin()) {
         ob_start(array('self', 'finishMinifier'));
      }
   }

   public static function finishMinifier($html) {
      return new MarkupMinifierWP_MarkupMinifier($html);
   }

   public static function setDefaultOptions() {
      $defaults = array(
         'compress-css' => 'on',
         'compress-js' => 'on',
         'remove-comments' => 'on'
      );

      if (get_option('markup_minifier_wp_options') === FALSE) {
         update_option('markup_minifier_wp_options', $defaults);
      }

      return;
   }

}
