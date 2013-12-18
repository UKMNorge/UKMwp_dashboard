<?php
/// CONFIG
$ID_ARRANGOR = 881;
$TWIGdata['image_path'] = 'http://arrangor.ukm.no/';

require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

/*
add_action( 'pre_get_posts', 'blogid_query_set_blog_id' );
add_action( 'loop_start', 'blogid_query_set_blog_id' );
add_action( 'loop_end', 'blogid_query_restore_blog_id' );
add_filter( 'posts_results', 'blogid_query_posts_results', 10, 2 );


function blogid_query_set_blog_id( $query ) {
	global $wpdb;
	if ( isset($query->query_vars['blogid']) && $query->query_vars['blogid'] != $wpdb->blogid ){
		$query->original_blog_id = $wpdb->blogid;
		$wpdb->set_blog_id( $query->query_vars['blogid'] );
	}
}
function blogid_query_restore_blog_id( $query ) {
	global $wpdb;	
	if ( isset($query->query_vars['blogid']) && isset($query->original_blog_id) )
		$wpdb->set_blog_id( $query->original_blog_id );
}

function blogid_query_posts_results( $posts, $query ) {
	blogid_query_restore_blog_id( $query );
	return $posts;
}

*/


switch_to_blog($ID_ARRANGOR);
if(isset($_GET['post'])) {
	$posts = query_posts( 'p='.$_GET['post'] );
	$post = $posts[0];
	the_post();
	$TWIGdata['post'] = new WPOO_Post( $post );
} else {
	$page = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
	$limit = 12;
	$posts = query_posts( 'cat=-2&post_status=publish&posts_per_page='.$limit.'&paged='.$page );
	
	if(sizeof($posts) == $limit)
		$TWIGdata['pagination_next'] = $page+1;
	if($page > 1)
		$TWIGdata['pagination_prev'] = $page-1;
	
	global $post;
	foreach( $posts as $key => $post ) {
		the_post();
		$wpoo = new WPOO_Post( $post );
		
		$wpoo->image->url = str_replace('/wp-content/uploads/', 
										'/wp-content/blogs.dir/'.$ID_ARRANGOR.'/files/',
										$wpoo->image->url
										);
		global $blog_id;
		$wpoo->image->url = str_replace('/blogs.dir/'.$blog_id.'/files/', 
										'/wp-content/blogs.dir/'.$ID_ARRANGOR.'/files/',
										$wpoo->image->url
										);
		$TWIGdata['news'][] = $wpoo;
	}
}
restore_current_blog();