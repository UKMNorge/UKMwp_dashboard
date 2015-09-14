<?php
if( UKM_HOSTNAME == 'ukm.dev' ) {
	$ID_ARRANGOR = 13;
} else {
	$ID_ARRANGOR = 881;
}
$TWIGdata['image_path'] = 'http://arrangor.ukm.no/';

require_once('WPOO/WPOO/Post.php');
require_once('WPOO/WPOO/Author.php');

switch_to_blog($ID_ARRANGOR);
if( isset( $PAGE_SLUG )  ) {
	$PAGE_ID = get_page_by_path( $PAGE_SLUG );
}
$post = get_page( $PAGE_ID );
the_post();
$TWIGdata['post'] = new WPOO_Post( $post );
restore_current_blog();