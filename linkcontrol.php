<?php
/*
Plugin Name: Link Control
Plugin URI: http://www.oxymoronical.com/
Description: Adds additional control over urls.
Author: Dave Townsend
Version: 1.0
Author URI: http://www.oxymoronical.com/
*/

function lnkctrl_add_options() {
  add_options_page('Link Control', 'Link Control', 8, 'linkcontrol/options.php');
}

function lnkctrl_init() {
  global $wp_rewrite;

  $structure = get_option('lnkctrl_page_structure');
  if ( '' != $structure )
    $wp_rewrite->page_structure = substr($structure, 1);

  $base = get_option('lnkctrl_feed_base');
  if ( '' != $base )
    $wp_rewrite->feed_structure = $wp_rewrite->root . substr($base, 1) . '/%feed%';

  $base = get_option('lnkctrl_search_base');
  if ( '' != $base )
    $wp_rewrite->search_base = substr($base, 1);

  $base = get_option('lnkctrl_comment_base');
  if ( '' != $base )
    $wp_rewrite->comments_base = substr($base, 1);
}

// These modify the internal rewrite rules
function lnkctrl_root_rewrite_rules($rules) {
  $feedbase = get_option('lnkctrl_feed_base');

	if ( '' != $feedbase && count($rules) > 0 ) {
    $feedbase = substr($feedbase, 1);
    $newrules = array();
    $url = 'blog/feed/(feed|rdf|rss|rss2|atom)/?$';
    $newrules[$url] = 'index.php?&feed=$matches[1]';
    $url = 'blog/feed/?$';
    $newrules[$url] = 'index.php?&feed=rss2';
    foreach ($rules as $url => $rule) {
      if (preg_match('|feed|', $url) == 1) {
        // Feed rules, ignore the presets
      }
      else {
        // Something unhandled, passthrough
        $newrules[$url] = $rule;
      }
    }
    return $newrules;
  }

  return $rules;
}

function lnkctrl_sanitize_title($title) {
  $title = strip_tags($title);
  // Preserve escaped octets.
  $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
  // Remove percent signs that are not part of an octet.
  $title = str_replace('%', '', $title);
  // Restore octets.
  $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

  $title = remove_accents($title);
  if (seems_utf8($title))
    $title = utf8_uri_encode($title, 200);

  $title = preg_replace('/&.+?;/', '', $title); // kill entities
  $title = preg_replace('/[^%a-zA-Z0-9 _-]/', '', $title);
  $title = preg_replace('/\s+/', '-', $title);
  $title = preg_replace('|-+|', '-', $title);
  $title = trim($title, '-');

  return $title;
}

add_option('lnkctrl_page_structure', '/%pagename%', 'The linking structure for pages');
add_option('lnkctrl_feed_base', '/feed', 'The base url for feeds');
add_option('lnkctrl_comment_base', '/comments', 'The base url for comments');
add_option('lnkctrl_search_base', '/search', 'The base url for searches');
add_option('lnkctrl_paged_base', '/page', 'The base url for different pages of the blog');
add_action('admin_menu', 'lnkctrl_add_options');
add_action('init', 'lnkctrl_init');
add_filter('root_rewrite_rules', 'lnkctrl_root_rewrite_rules');
remove_filter('sanitize_title', 'sanitize_title_with_dashes');
add_filter('sanitize_title', 'lnkctrl_sanitize_title');

?>