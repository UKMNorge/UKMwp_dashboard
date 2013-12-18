<?php
/// CONFIG
$ID_ARRANGOR = 881;
$TWIGdata['image_path'] = 'http://arrangor.ukm.no/';

require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

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
		
/*
		$wpoo->image->url = str_replace('/wp-content/uploads/', 
										'/wp-content/blogs.dir/'.$ID_ARRANGOR.'/files/',
										$wpoo->image->url
										);
		global $blog_id;
		$wpoo->image->url = str_replace('/blogs.dir/'.$blog_id.'/files/', 
										'/wp-content/blogs.dir/'.$ID_ARRANGOR.'/files/',
										$wpoo->image->url
										);
*/
		$TWIGdata['news'][] = $wpoo;
	}
}
restore_current_blog();