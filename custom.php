<?php 
/**
 * Plugin Name:       Custom Post and Taxonomies
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       adds a custom post and taxonomies to your website
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pulkit Juneja
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-post-and-taxonomies
 */
function wporg_add_custom_box() {
    
        wp_add_dashboard_widget(
            'custom_post',                     // Unique ID
            'Custom Post Metabox',          // Box title
            'custom_post_html',            // Content callback, must be of type callable
            $screen                            // Post type
        );
  //  }
}
add_action( 'wp_dashboard_setup', 'wporg_add_custom_box');

function custom_post_html( ) {
 
    ?>
    <h3>Enter name of your custom post here</h3><br/>
    <input type="text" id="post" name="post"  /><br/><br/>
    <h3>Enter name of your custom taxonomy here</h3><br/>
    <input type="text" id="taxonomy" name="taxonomy" /><br/><br/>
    <h3>Enter name of your custom column here</h3><br/>
    <input type="text" id="column" name="column" /><br/><br/>
    <input type="submit" id="btn" value="Submit"/>
   
    <?php
}

function custom_script()
{
    wp_enqueue_script('custom_post_script', plugin_dir_url(__FILE__) . 'script.js', ['jquery']);       
    wp_localize_script(
                'custom_post_script',
                'custom_post_script_obj',
                [
                    'url' => admin_url('admin-ajax.php'),
                ]
            );
       
}
add_action('admin_enqueue_scripts', 'custom_script');

function save_data() {
    echo "hmm";
    update_option('my_cutm_post',$_POST['post']);
    update_option('my_cutm_taxonomy',$_POST['taxonomy']);
    update_option('my_cutm_column',$_POST['column']);
   // header('Location: custom.php');
    
    // add_filter( 'init', 'custom_post_types'); 
    // add_filter( 'init', 'register_post_taxonomy' );
 //$data = get_options('my_cutm_posts');
     // custom_post_types();
     // register_post_taxonomy();
    //  add_action( 'init', 'custom_post_types');    
    //  add_action( 'init', 'register_post_taxonomy' );
    
 
    }

// add_action( 'save_post', 'save_custom_post_taxonomy_data' );
add_action("wp_ajax_save_data", "save_data");
add_action("wp_ajax_nopriv_save_data", "save_data");

function custom_post_types() {
    
    $custom_post_name = get_option('my_cutm_post');
    $taxonomy_name = get_option('my_cutm_taxonomy');
    echo $custom_post_name;
   
        $labels = array(
            'name'                => _x( $custom_post_name, 'Post Type General Name', 'twentytwenty' ),
            'singular_name'       => _x( $custom_post_name, 'Post Type Singular Name', 'twentytwenty' ),
            'menu_name'           => __( $custom_post_name, 'twentytwenty' ),
            'parent_item_colon'   => __( 'Parent '.$custom_post_name, 'twentytwenty' ),
            'all_items'           => __( 'All '.$custom_post_name, 'twentytwenty' ),
            'view_item'           => __( 'View '.$custom_post_name, 'twentytwenty' ),
            'add_new_item'        => __( 'Add New '.$custom_post_name, 'twentytwenty' ),
            'add_new'             => __( 'Add New', 'twentytwenty' ),
            'edit_item'           => __( 'Edit '.$custom_post_name, 'twentytwenty' ),
            'update_item'         => __( 'Update '.$custom_post_name, 'twentytwenty' ),
            'search_items'        => __( 'Search '.$custom_post_name, 'twentytwenty' ),
            'not_found'           => __( 'Not Found', 'twentytwenty' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
        );
     
        $args = array(
            'label'               => __( $custom_post_name, 'twentytwenty' ),
           // 'description'         => __( 'Movie news and reviews', 'twentytwenty' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),            
            // 'taxonomies'          => array( $taxonomy_name ),           
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
            // 'taxonomies'          => array( 'post_tag','category','courses' ),
     
        );
         
        register_post_type( $custom_post_name, $args );
     
}

add_action( 'init', 'custom_post_types');    


function register_post_taxonomy() {
  
   $taxonomy_name = get_option('my_cutm_taxonomy');
   $custom_post_name = get_option('my_cutm_post');
    $labels = array(
        'name'              => _x( $taxonomy_name, 'taxonomy general name' ),
        'singular_name'     => _x( $taxonomy_name, 'taxonomy singular name' ),
        'search_items'      => __( 'Search '.$taxonomy_name ),
        'all_items'         => __( 'All '.$taxonomy_name ),
        'parent_item'       => __( 'Parent '.$taxonomy_name ),
        'parent_item_colon' => __( 'Parent '.$taxonomy_name ),
        'edit_item'         => __( 'Edit '.$taxonomy_name ),
        'update_item'       => __( 'Update '.$taxonomy_name ),
        'add_new_item'      => __( 'Add New '.$taxonomy_name ),
        'new_item_name'     => __( 'New '.$taxonomy_name.'Name' ),
        'menu_name'         => __( $taxonomy_name ),
    );
    $args   = array(
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'course' ],
    );
    register_taxonomy( $taxonomy_name, [lcfirst($custom_post_name),'post'], $args );
   
}

add_action( 'init', 'register_post_taxonomy' );

$str = get_option('my_cutm_post');  
$cutm_post = lcfirst($str);  

add_filter( 'manage_'.$cutm_post.'_posts_columns', 'set_custom_edit_book_columns' );

function set_custom_edit_book_columns($columns) {
    // print_r($columns);
    unset( $columns['comments'] );
    $cutm_column = get_option("my_cutm_column");
    //echo "m".$cutm_column;
    $columns['director'] = __( $cutm_column, 'your_text_domain' );
   
    return $columns;
}


// Add the data to the custom columns for the book post type:

add_action( 'manage_'.$cutm_post.'_posts_custom_column' , 'custom_book_column', 10, 2 );

function custom_book_column( $column, $post_id ) {
   // print_r("oo".$column);
    $cutm_column = get_option("column");
   // echo get_post_meta($post_id ,'meta_key',true);
     switch ( $column ) {

        case 'director' :
           echo get_post_meta( $post_id , 'meta_key' , true ); 
            break;
    }
}

function wporg_add_meta_box() {
    $my_cutm_post = get_option('my_cutm_post');
    $screens = [ $my_cutm_post ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 // Unique ID
            'New Metabox',      // Box title
            'wporg_meta_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
function wporg_meta_box_html( $post ) {
   $tem = get_post_meta($post->ID,"meta_key",true)
    ?>
    <h2><b>Enter the name of director here</h2><b><br/>
    <input type="text" id="wporg" name="inputbox" value="<?php echo $tem ? $tem : '' ; ?>" />
    <!-- <input type="submit" id="btn" value="click"/>
    -->
    <?php
}
add_action( 'add_meta_boxes', 'wporg_add_meta_box' );

function wporg_save_postdata( $post_id ) {

    if ( array_key_exists( 'inputbox', $_POST ) ) {
        update_post_meta(
            $post_id,
            'meta_key',
            $_POST['inputbox']
        );
    }
}
add_action( 'save_post', 'wporg_save_postdata' );


?>