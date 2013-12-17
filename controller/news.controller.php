<?php
/// CONFIG
$ID_ARRANGOR = 881;
$TWIGdata['image_path'] = 'http://arrangor.ukm.no/';

require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

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



if(isset($_GET['post'])) {
	$posts = query_posts( 'blogid='.$ID_ARRANGOR.'&p='.$_GET['post'] );
	$post = $posts[0];
	the_post();
	$TWIGdata['post'] = new WPOO_Post( $post );	
} else {
	$page = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
	$limit = 18;
	$posts = query_posts( 'blogid='.$ID_ARRANGOR.'&cat=-2&post_status=publish&posts_per_page='.$limit.'&paged='.$page );
	
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
		$TWIGdata['news'][] = $wpoo;
	}
}