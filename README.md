# Markup Minifier WP

A plugin for WordPress that minifies HTML code by removing line breaks and spaces to reduce file size and improve performance.

## Description

The plugin minifies all HTML markup by default. Also all inline styles/scripts are compressed and HTML comments get removed. These can be switched on/off on the settings page. Optionaly a comment containing info about the file size savings can be added. The plugin is simple by design, because it's meant to be comfortable and fast.

If you need more options, like reorganising and/or merging `<link>`, `<style>` and `<script>` tags scattered across a HTML page, the new [HTML Minifier](http://www.terresquall.com/web/html-minifier/) plugin looks promising.

The minification code is [a fork from FastWP](https://fastwp.de/2044/).

## Installation

1. [Download the plugin](https://github.com/operat/markup-minifier-wp/archive/master.zip)
2. Upload `markup-minifier-wp` folder to `/wp-content/plugins/` directory
3. Activate the plugin in WordPress

To get automatic updates also install the [GitHub Updater](https://github.com/afragen/github-updater) plugin.

## License

The code is available under the [GNU GPLv3 license](LICENSE.md).
