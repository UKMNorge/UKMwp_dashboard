<?php

$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Informasjon og pressearbeid',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/INFORMASJON-OG-PRESSEARBEID.docx',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/INFORMASJON-OG-PRESSEARBEID.pdf'
												 );
$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Eksempel på pressemelding lokalmønstring',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Eksempel-pressemelding-1-lokal-UKM-2011.docx',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Eksempel-pressemelding-1-lokal-UKM-2011.pdf'
												 );
$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Mal for pressemelding',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-for-pressemelding.docx',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-for-pressemelding.pdf'
												 );
$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Eksempel på PR-plan',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/PR-plan.docx',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-PR-plan.pdf'
												 );
$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Mal for PR-plan',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-PR-plan.docx',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-PR-plan.pdf'
												 );
$TWIGdata['dokumenter']['info_presse'][] = array('navn' => 'Eksempel på pressemelding Stovner live',
												 'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Eksempel-pressemelding-2-stovner-live.doc',
												 'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Eksempel-pressemelding-2-stovner-live.pdf'
												 );
												 
												 
												 
$TWIGdata['dokumenter']['nettredaksjon'][] = array('navn' => 'Rekrutteringstekst ungdomsredaksjon',
												   'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/rekrutteringstekst-ungdomsredaksjon.docx',
												   'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/rekrutteringstekst-ungdomsredaksjon.pdf'
												 );
$TWIGdata['dokumenter']['nettredaksjon'][] = array('navn' => 'Eksempel på rekrutteringsplan',
												   'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Rekrutteringsplan-UKM.docx',
												   'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Rekrutteringsplan-UKM.pdf'
												 );
$TWIGdata['dokumenter']['nettredaksjon'][] = array('navn' => 'Mal rekrutteringsplan ungdomsredaksjon',
												   'dok'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-Rekrutteringsplan-UKM.docx',
												   'pdf'	=> '//ukm.no/wp-content/blogs.dir/881/files/2011/07/Mal-Rekrutteringsplan-UKM.pdf'
												 );
												 
												 
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Bakgrunn til fagkurs på seminar',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/01/Arrangorskolen-bakgrunn-til_fagkurs_pa_seminar.pdf',
													 );
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Kræsjtest for unge arrangører',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/01/Krasjtest_for_unge_arrangorer.pdf',
													 );
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Kræsjtest: retningslinjer forlokalsamfunnet',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/01/Krasjtest_Lokalsamfunnet_retningslinjer.pdf',
													 );
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Program arrangørweekend lør-søn',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/01/Program_arrangorweekend_lor_son.doc',
													 );
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Kræsjtest: kopibehov',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/11/kopibehov.xlsx',
													 );
$TWIGdata['dokumenter']['arrangorweekend'][] = array('navn' => 'Kræsjtest: vedlegg',
													 'fil'	=> '//ukm.no/wp-content/blogs.dir/881/files/2013/01/Krasjtest_vedlegg.zip',
													 );
													 
$TWIGdata['dokumenter']['konferansierer'][] = array('navn' => 'Konferansierens rolle på UKM',
													 'fil'	=> '//ukm.no/arrangor/files/2015/02/Konfransierhefte.pdf',
													 );
													 
$ID_ARRANGOR = 881;
$ID_PARENT_POST = 2653;
$keysort_array = array();
switch_to_blog($ID_ARRANGOR);
	$args = array(
		'orderby'		 => 'post_title',
		'order'          => 'ASC',
		'post_type'      => 'attachment',
		'post_parent'    => $ID_PARENT_POST,
		'post_mime_type' => 'application/pdf',
		'numberposts'	 => -1,
	);
	$attachments = get_posts($args);
	foreach ($attachments as $attachment) {
		$attachment->url = wp_get_attachment_url($attachment->ID);
		$keysort_array[$attachment->post_title] = $attachment;
	}
	krsort($keysort_array);
	$TWIGdata['dokumenter']['styreprotokoller'] = $keysort_array;
restore_current_blog();							 

#var_dump($TWIGdata['dokumenter']['styreprotokoller']);

/*
$TWIGdata['dokumenter']['tema'][] = array('navn' => 'NAVN',
												 'fil'	=> 'WORD',
												 );
*/
