<?php
/*
 * MarkupMinifier
 */

class MarkupMinifierWP_MarkupMinifier {

   protected $html;
   protected $compress_css;
   protected $compress_js;
   protected $remove_comments;
   protected $info_comment;

   public function __construct($html) {
      $settings = get_option('markup_minifier_wp_options');
      $this->compress_css = array_key_exists('compress-css', $settings) ? true : false;
      $this->compress_js = array_key_exists('compress-js', $settings) ? true : false;
      $this->remove_comments = array_key_exists('remove-comments', $settings) ? true : false;
      $this->info_comment = array_key_exists('info-comment', $settings) ? true : false;

      if (!empty($html)) {
         $this->parseHTML($html);
      }
   }

   public function __toString() {
      return $this->html;
   }

   protected function bottomComment($raw, $compressed) {
      $raw = strlen($raw);
      $compressed = strlen($compressed);
      $savings = ($raw-$compressed) / $raw * 100;
      $savings = round($savings, 2);
      return '<!-- ' . MARKUP_MINIFIER_WP_NAME . ' | ' . MARKUP_MINIFIER_WP_URL . ' | Size reduced by '. $savings .'% (was ' . $raw . ' bytes, is ' . $compressed . ' bytes) -->';
   }

   protected function minifyHTML($html) {
      $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';

      preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);

      $overriding = false;
      $raw_tag = false;
      $html = '';

      foreach ($matches as $token) {
         $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
         $content = $token[0];

         if (is_null($tag)) {
            if (!empty($token['script'])) {
               $strip = $this->compress_js;
            } else if (!empty($token['style'])) {
               $strip = $this->compress_css;
            } else if ($content == '<!--wp-html-compression no compression-->') {
               $overriding = !$overriding;
               continue;
            } else if ($this->remove_comments) {
               if (!$overriding && $raw_tag != 'textarea') {
                  $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
               }
            }
         } else {
            if ($tag == 'pre' || $tag == 'textarea' || $tag == 'script') {
               $raw_tag = $tag;
            } else if ($tag == '/pre' || $tag == '/textarea' || $tag == '/script') {
               $raw_tag = false;
            } else {
               if ($raw_tag || $overriding) {
                  $strip = false;
               } else {
                  $strip = true;
                  $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
                  $content = str_replace(' />', '/>', $content);
               }
            }
         }

         if ($strip) {
            $content = $this->removeWhiteSpace($content);
         }

         $html .= $content;
      }

      return $html;
   }

   public function parseHTML($html) {
      $this->html = $this->minifyHTML($html);

      if ($this->info_comment) {
         $this->html .= $this->bottomComment($html, $this->html);
      }
   }

   protected function removeWhiteSpace($str) {
      $str = str_replace("\t", ' ', $str);
      $str = str_replace(array("\r\n", "\n", "\r"),  '', $str);

      while (stristr($str, '  ')) {
         $str = str_replace('  ', ' ', $str);
      }

      return $str;
   }

}
