<?php
/// CONFIG
if( UKM_HOSTNAME == 'ukm.dev' ) {
	$ID_ARRANGOR = 13;
} else {
	$ID_ARRANGOR = 881;
}
$TWIGdata['image_path'] = '//arrangor.ukm.no/';

require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

$num_on_frontpage = 8;
switch_to_blog($ID_ARRANGOR);
if(isset($_GET['post'])) {
	$posts = query_posts( 'p='.$_GET['post'] );
	$post = $posts[0];
	the_post();
	$TWIGdata['post'] = new WPOO_Post( $post );
} else {
	$page = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
	$limit = isset($_GET['limit']) ? $_GET['limit'] : $num_on_frontpage;
	if ($page > 1) {
		$limit = 12;
		$offset = $limit*($page-1)-$num_on_frontpage; // 6 stk på forsiden
	    $post_query = (isset($POST_QUERY) ? $POST_QUERY.'&' : '' ). 'post_status=publish&posts_per_page='.$limit.'&&offset='.$offset.'&paged='.$page;
	}
	else {	 
	    $post_query = (isset($POST_QUERY) ? $POST_QUERY.'&' : '' ). 'post_status=publish&posts_per_page='.$limit.'&paged='.$page;
	}

	#$posts = query_posts( (isset($POST_QUERY) ? $POST_QUERY.'&' : '' ). 'post_status=publish&posts_per_page='.$limit.'&paged='.$page );
	$posts = query_posts($post_query);
	$TWIGdata['page'] = $page;
	
	if(sizeof($posts) == $limit)
		$TWIGdata['pagination_next'] = $page+1;
	if($page > 1)
		$TWIGdata['pagination_prev'] = $page-1;
	
	global $post;
	foreach( $posts as $key => $post ) {
		the_post();
		$TWIGdata['news'][] = new WPOO_Post( $post );
	}
}
restore_current_blog();