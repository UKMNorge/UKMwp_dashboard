<?php
/// CONFIG
if( UKM_HOSTNAME == 'ukm.dev' ) {
	$ID_ARRANGOR = 13;
} else {
	$ID_ARRANGOR = 881;
}
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
	$limit = isset($_GET['limit']) ? $_GET['limit'] : 6;
	$posts = query_posts( (isset($POST_QUERY) ? $POST_QUERY.'&' : '' ). 'post_status=publish&posts_per_page='.$limit.'&paged='.$page );
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