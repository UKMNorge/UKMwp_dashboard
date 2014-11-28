<?php
require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');
	
function posts( $blog_id, $limit=3 ) {
	$blog_posts = [];
	
	switch_to_blog( $blog_id );
	if( $blog_id == 1 ) {
		$remove ='&cat=-12';
	} else {
		$remove = '';
	}
	$posts = query_posts( 'post_status=publish&posts_per_page='.$limit.$remove );
	global $post;
	foreach( $posts as $key => $post ) {
		the_post();
		$blog_post = new WPOO_Post( $post );
		
		$blog_post_data = new stdClass();
		$blog_post_data->title = $blog_post->title;
		$blog_post_data->date = $blog_post->date;
		
		$blog_posts[] = $blog_post_data;
	}
	restore_current_blog();
	return $blog_posts;
}