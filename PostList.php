<?php
/**
Plugin Name: Post list renderer
Version: 1.0
*/

class PostList{
    public function __construct() {
        add_action('init', array($this, 'register_shortcode'));
    }

    public function register_shortcode(){
        add_shortcode('posts', array($this, 'post_list_shortcode'));
    }

    private function get_error_msg($msg){
         return '<p style="color: red;">'.$msg.'</p>';
    }

    public function post_list_shortcode($atts, $content, $tag){
        if(!is_array($atts)) $this->get_error_msg("Kérlek listaként add meg a paramétereit!");
        if(!isset($atts["category"])) return $this->get_error_msg("Hiányzik a kategória!");
        $category = get_category_by_slug($atts["category"]);
        if(!$category) return $this->get_error_msg("Hibás kategória slug!");
        $limit = (isset($atts["limit"])) ? intval($atts["limit"]) : 3;
        var_dump($category);
    }
}

new PostList();
