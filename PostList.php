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
        add_shortcode('post_list', array($this, 'post_list_shortcode'));
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
        // query the posts
        $new_query = new WP_Query(
            array(
                'post_type'         => 'post',
                //'posts_per_page'    => $limit,
                'category_name'     => $category->slug;
            )
        );
        $output = '<div class="post_list">';
        if ($new_query->have_posts()) {
            $i = 0;
            while ($new_query->have_posts()) {
                $new_query->the_post();
                $postid = get_the_ID();
				$thumb_url = get_the_post_thumbnail_url();
                $row = <<<HTML
                    <div class="post_item">
                        {$thumb_url}
                    </div>
                HTML;
				$output .= $row;
            }
        }
		return $output."</div>";
    }
}

new PostList();
