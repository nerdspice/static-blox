<?php
/*
Plugin Name: Static Blox
Description: Content snippets that can be used via shortcode
Author: nerdsice
Version: 0.1
*/

class StaticBlox {
  private static $_instance;

  public function __construct() { }

  public function run() {
    $this->registerShortcodes();
    $this->initHooks();
    do_action('static_blox_init', $this);
  }

  public function registerShortcodes() {
    add_shortcode('static_bloc', array($this, 'staticBlocSC'));
  }

  public function registerPostTypes() {
    $this->registerStaticBloxPostType();
  }
  
  public function getLabels($singular, $plural = null, $lsingular = null, $lplural = null) {
    if(is_null($plural)) $plural = $singular.'s';
    if(is_null($lsingular)) $lsingular = strtolower($singular);
    if(is_null($lplural)) $lplural = strtolower($plural);

    $labels = array(
      'name'=>__($plural),
      'singular_name'=>__($singular),
      //'add_new'=>__('Add New '.$singular),
      'add_new_item'=>__('Add New '.$singular),
      'edit_item'=>__('Edit '.$singular),
      'new_item'=>__('New '.$singular),
      'view_item'=>__('View '.$singular),
      'view_items'=>__('View '.$plural),
      'search_items'=>__('Search '.$plural),
      'not_found'=>__('No '.$lplural.' found'),
      'not_found_in_trash'=>__('No '.$lplural.' found in Trash'),
      'all_items'=>__('All '.$plural),
      'archives'=>__($singular.' Archives'),
      'attributes'=>__($singular.' Attributes'),
      'insert_into_item'=>__('Insert into '.$lsingular),
      'uploaded_to_this_item'=>__('Uploaded to this '.$lsingular)
    );

    return $labels;
  }

  public function registerStaticBloxPostType() {
    $labels = $this->getLabels('Static Bloc', 'Static Blox');

    register_post_type('static_bloc', array(
      'labels' => $labels,
      'public'=>true,
      'exclude_from_search'=>true,
      'publicly_queryable'=>false,
      'show_in_nav_menus'=>false,
      'show_ui'=>true,
      'menu_icon'=>'dashicons-layout',
      'supports'=>array(
        'title',
        'editor',
        'revisions'
      )
    ));
  }

  public function initHooks() {
    add_action('init', array($this, 'wpInit'));
  }

  public function wpInit() {
    $this->registerPostTypes();
  }

  public function staticBlocSC($atts, $content) {
    $id = intval(@$atts['id']);
    $name = trim(@$atts['name']);

    $post = $id ? get_post($id) : $this->getPostByName($name, 'static_bloc');
    if(!$post || $post->post_status !== 'publish') return '';

    return do_shortcode($post->post_content);
  }

  public function getPostByName($name, $post_type = '', $publish = true) {
    $args = array(
      'posts_per_page' => -1,
      'name' => $name
    );

    if(!!$publish) $args['post_status'] = 'publish';
    if($post_type) $args['post_type'] = $post_type;

    $posts = get_posts($args);
    if(count($posts)) return $posts[0];
    return null;
  }

  public static function getInstance() {
    if(!self::$_instance) {
      self::$_instance = new static();
    }

    return self::$_instance;
  }

  public static function init() {
    static::getInstance()->run();
  }
}

StaticBlox::init();
