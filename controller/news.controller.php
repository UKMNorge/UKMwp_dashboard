<?php
require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

if(isset($_GET['post'])) {
	$posts = query_posts( 'blogid=7&p='.$_GET['post'] );
	$post = $posts[0];
	the_post();
	$TWIGdata['post'] = new WPOO_Post( $post );	
} else {
	$page = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
	$limit = 18;
	$posts = query_posts( 'blogid=7&cat=-2&post_status=publish&posts_per_page='.$limit.'&paged='.$page );
	
	if(sizeof($posts) == $limit)
		$TWIGdata['pagination_next'] = $page+1;
	if($page > 1)
		$TWIGdata['pagination_prev'] = $page-1;
	
	global $post;
	foreach( $posts as $key => $post ) {
		the_post();
		$wpoo = new WPOO_Post( $post );
		$TWIGdata['news'][] = $wpoo;
	}
}