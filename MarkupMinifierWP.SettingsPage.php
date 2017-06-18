<?php
/*
 * SettingsPage
 */

class MarkupMinifierWP_SettingsPage {

   public function __construct() {
      add_action('admin_menu', array($this, 'addPage'));
      add_action('admin_init', array( $this, 'initPage'));
   }

   public function addPage() {
      add_options_page(
         MARKUP_MINIFIER_WP_NAME,
         MARKUP_MINIFIER_WP_NAME,
         'manage_options',
         'markup-minifier-wp',
         array($this, 'createPage')
      );
   }

   public function createPage() {
      $this->options = get_option('markup_minifier_wp_options');

      ?>
         <div class="wrap">
            <h1><?php echo MARKUP_MINIFIER_WP_NAME; ?></h1>
            <p>
               <b><?php echo MARKUP_MINIFIER_WP_DESCRIPTION; ?></b><br>
               Find information, report issues and make contributions on <a href="<?php echo MARKUP_MINIFIER_WP_URL; ?>" title="<?php echo MARKUP_MINIFIER_WP_NAME; ?>" target="_blank">GitHub</a>.
            </p>
            <form method="post" action="options.php">
            <?php
               settings_fields('markup_minifier_wp');
               do_settings_sections( 'markup-minifier-wp' );
               submit_button();
            ?>
            </form>
         </div>
      <?php
   }

   public function initPage() {
      register_setting(
         'markup_minifier_wp',
         'markup_minifier_wp_options'
      );

      add_settings_section(
         'general-settings',
         'General Settings',
         array(
            $this,
            'printGeneralInfo'
         ),
         'markup-minifier-wp'
      );

      add_settings_field(
         'compress-css',
         'Compress CSS',
         array(
            $this,
            'printCheckbox'
         ),
         'markup-minifier-wp',
         'general-settings',
         array(
            $this,
            'field' => 'compress-css',
            'description' => 'Minify inline styles'
         )
      );

      add_settings_field(
         'compress-js',
         'Compress JS',
         array(
            $this,
            'printCheckbox'
         ),
         'markup-minifier-wp',
         'general-settings',
         array(
            $this,
            'field' => 'compress-js',
            'description' => 'Minify inline scripts'
         )
      );

      add_settings_field(
         'remove-comments',
         'Remove comments',
         array(
            $this,
            'printCheckbox'
         ),
         'markup-minifier-wp',
         'general-settings',
         array(
            $this,
            'field' => 'remove-comments',
            'description' => 'Remove HTML comments'
         )
      );

      add_settings_field(
         'info-comment',
         'Info comment',
         array(
            $this,
            'printCheckbox'
         ),
         'markup-minifier-wp',
         'general-settings',
         array(
            $this,
            'field' => 'info-comment',
            'description' => 'Add info comment about file size savings'
         )
      );

   }

   public function printGeneralInfo() {
      // print 'All HTML markup is minified by default. These settings are optional:';
   }

   public function printCheckbox($args) {
      $field = $args['field'];
      $checked = isset($this->options[$field]) ? ' checked' : '';

      echo '<input type="checkbox" id="' . $field . '" name="markup_minifier_wp_options[' . $field . ']"' . $checked . '><label for="' . $field . '">' . $args['description'] . '</label>';
   }

}
