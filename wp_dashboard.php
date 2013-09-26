<?php
/* ****************************************************************
Omkring linje 12 i wp-admin/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMNorge/wp_dashboard.php');
-------------
*******************************************************************
*/
require_once('UKM/inc/twig-admin.inc.php');
require_once('UKM/monstring.class.php');

require(ABSPATH . 'wp-admin/admin-header.php');

$TWIGdata = array('site_type' => get_option('site_type'),
				  'kontakter' => UKMWP_kontakter());

echo 'HEEEEI';
var_dump($TWIGdata);
echo 'strange';
//echo TWIG('dashboard.twig.html', $TWIGdata, dirname(__FILE__));

require(ABSPATH . 'wp-admin/admin-footer.php');
die();



/*
function ukmTema(){
	switch(date('m')) {
		case 1:
		case 2: 
			return 'Lokalmønstringer';
		case 3:
			return 'Lokal- og fylkesmønstringer';
		case 4:
			return 'Fylkesmønstringer';
		case 5:
			return 'Klargjøring festival';
		case 6:
			return 'UKM-Festivalen!';
		case 7:
		case 8:
			return 'Sommerferie og evaluering';
		case 9:
			return 'UKM-konferansen';
		case 10:
			return 'UKM-materiell';
		case 11: 
			return 'Registrering mønstring';
		case 12:
			return 'Påmelding!';
	}
}
UKM_loader('private');
global $current_user;
$user_roles = $current_user->roles;
$user_role = array_shift($user_roles);
if($user_role == 'ukm_jurymedlem'){ ?>
	<div class="wrap about-wrap">
		<h1>Velkommen til UKMs arrangørsystem</h1>
		<div class="ukm-badge">TEMA: <br /><?= ukmTema()?></div>
		<div class="about-text">Velg juryskjema i menyen til venstre for å starte juryering.</div>
	</div>
	
<?php
} else {
	
	?>
	
	<div class="wrap about-wrap">
		<h1>Velkommen til UKMs arrangørsystem</h1>
		<div class="ukm-badge">TEMA: <br /><?= ukmTema()?></div>
		<div class="about-text">Vi har samlet redigering av nettside, administrering av mønstring og designgenerator i ett og samme verktøy.</div>
			
		<!-- TABS -->
		<h2 class="nav-tab-wrapper">
			<a href="?tab=nytt" class="nav-tab <?= !isset($_GET['tab'])||$_GET['tab']=='nytt'?'nav-tab-active':'' ?> ukm">Hva er nytt?</a>
			<a href="?tab=ambassadorer" class="nav-tab <?= $_GET['tab']=='ambassadorer'?'nav-tab-active':'' ?> ukm">Dine ambassadører</a>
			<a href="?tab=papermill" class="nav-tab <?= $_GET['tab']=='papermill'?'nav-tab-active':'' ?> ukm">Designgenerator</a>
			<?= get_option('site_type')=='fylke' && UKM_private() ? '
			<a href="?tab=lokalmonstringer" class="nav-tab '.($_GET['tab']=='lokalmonstringer'?'nav-tab-active':'') .' ukm">Dine lokalmønstringer</a>' : '' ?>
			<a href="?tab=kontakt" class="nav-tab <?= $_GET['tab']=='kontakt'?'nav-tab-active':'' ?> ukm">Kontakt</a>
		</h2>	
	
	<?php
		##############################################################################
		## HVA ER NYTT
		if(!isset($_GET['tab'])||$_GET['tab']=='nytt'){ ?>

		<!-- VIDEOOPPLASTING -->
		<div class="changelog">
			<h3>Ny videoopplasting <span class="description">(menyvalg video)</span></h3>
			<div class="feature-section col two-col">	
				<div class="last-feature">
					<h4>Video av innslag</h4>
					<p>Velger du fanen <em>"sortert etter program"</em> 
					kan du lett klikke deg gjennom forestillingen 
					og laste opp video fra start til slutt.
					<br />
					Skal du ajourføre velger du <em>"sortert alfabetisk"</em>,
					så går det raskere å finne igjen innslaget.</p>
	
					<h4>Videoreportasjer</h4>
					<p>Ikke alle videoer fra mønstringen handler om ett spesielt innslag.
						Videoreportasje-funksjonen gir deg mulighet til å laste opp disse.
					</p>
	
					<h4>UKM-TV (<a href="http://tv.ukm.no/">http://tv.ukm.no</a>)</h4>
					<p>UKMs digitale skattkammer har nå begynt å ta form!
					Alt av video fra de siste årene ligger nå på UKM-TV,
					og alt som lastes opp med den nye videomodulen kommer automatisk inn her.
					</p>
	
				</div>
				<img alt="" src="wp-content/plugins/UKMvideo/screenshots/ny_video.png" width="500" />
			</div>
		</div>
		
		<!-- BILDER I INNLEGG -->
		<div class="changelog">
			<h3>Bilder i innlegg</h3>
			<div class="feature-section col two-col">
				<img alt="" src="wp-content/plugins/UKMvideo/screenshots/media.png" width="500" />
				<div class="last-feature">
					<h4>Biblioteket</h4>
					<p>Etter vi fikk det nye mediebiblioteket i innlegg har vi fjernet det fra menyen.
					Skal du sette inn ett eller flere bilder i et innlegg gjør du dette fra innlegget.
					<br />
					<strong>OBS:</strong> skal du lage bildealbum av forestillingen gjør du dette via menyvalget bilder
					</p>
				</div>
			</div>
		</div>
		
		<!-- BILDEOPPLASTING FRA FORESTILLING -->
		<div class="changelog">
			<h3>Bilder fra forestilling <span class="description">(menyvalg bilder)</span></h3>
			<div class="feature-section col two-col">
				<img alt="" src="wp-content/plugins/UKMvideo/screenshots/bildeopplasting.png" width="500" />
				<div class="last-feature">
					<h4>Last opp og merk</h4>
					<p>En av de største verdiene UKM har på nett er bilder og video.
						Laster du opp video gjennom bilde-modulen blir de automatisk synlig på nettsiden din, 
						i tillegg til at de knyttes opp mot innslaget.
						<br />
						<br />
						Last opp alle bildene på én gang, og merk de på neste side, når de er lastet opp.
						Prosessen går fort, og bildene blir arkivert på skikkelig måte.
					</p>
					<h4>Tilpassede visninger</h4>
					<p>Alle bilder vises på en egen bildeside, i programmet og på deltakersiden 
					- hver visning tilpasset sitt formål!</p>
				</div>
			</div>
		</div>


		<!-- BILDEOPPLASTING FRA FORESTILLING -->
		<div class="changelog">
			<h3>Ny "pausekanin"</h3>
			<div class="feature-section col two-col">
				<img alt="" src="wp-content/plugins/UKMvideo/screenshots/ny_kanin.png" width="500" />
				<div class="last-feature">
					<h4>Illustrasjonsbilde mangler</h4>
					<p>Tidligere har det dukket opp en kanin hvis innlegget mangler illustrasjonsbilde.
					   Fra og med 6. februar er kaninen byttet ut med et nytt bilde.
					</p>
					<h4>Hvordan velge illustrasjonsbilde?</h4>
					<p>For å kunne velge illustrasjonsbilde må du huske å velge 
					"Fremhevet bilde" i høyrekolonnen når du redigerer innlegget</p>
				</div>
			</div>
		</div>


		<!-- DELTAKERE -->
		<div class="changelog">
			<h3>Deltakere</h3>
			<div class="feature-section images-stagger-right">
				<img src="http://ukm.no/wp-content/uploads/2012/10/deltakerescreenshot.png" class="image-50" />
				<h4>All info i ett bilde!</h4>
				<p>Vi har ryddet opp og samlet all informasjon og redigering av innslag og personer i ett skjermbilde. Det er slutt på å navigere frem og tilbake, her gjør du alle endringer direkte fra listen!</p>
	
				<h4>Søkefelt</h4>
				<p>Leter du etter et innslag eller en person? Oppe til høyre i deltakermodulen finner du et søkefelt som filtrerer listen. Begynn å skrive navnet du leter etter, så filtreres listen underveis</p>
			</div>
		</div>
	
		<!-- PROGRAM -->
		<div class="changelog">
			<h3>Program</h3>
			<div class="feature-section images-stagger-right">
				<img src="http://ukm.no/wp-content/uploads/2012/10/programscreenshot.png" class="image-50" />
				<h4>Enkel veiviser</h4>
				<p>Hvis du setter opp ditt program når mønstringen nærmer seg (og de fleste er påmeldt) kan systemet beregne mye om hvilke hendelser du trenger osv. Veiviseren forklarer deg valgene, og gir deg store muligheter til å automatisere programoppsettet!</p>
	
				<h4>Revolusjonert grovsortering</h4>
				<p>Nå grovsorterer du når du vil med dra-og-slipp i programoversikten. Med noe basisinfo tilgjengelig ligger alt til rette for kjapp grovsortering.</p>
	
				<h4>All info (og redigering) tilgjengelig!</h4>
				<p>Har du irritert deg over en skrivefeil når du setter programmet og tenkt at "denne må jeg trykke frem og tilbake for å rette etterpå"? <br />Nå gjør du alle endringer direkte i programmodulen! Uten å komme bort fra det du holdt på med.</p>
			</div>
		</div>
		
		<!-- RAPPORTER -->
		<div class="changelog">
			<h3>Rapporter</h3>
			<div class="feature-section images-stagger-right">
				<img src="http://ukm.no/wp-content/uploads/2012/10/rapportscreenshot.png" class="image-50" />
				<h4>Alt på ett sted</h4>
				<p>Med en ny oversikt har vi samlet alle rapportene på ett sted, sammen med en kort og konsis forklaring. Nå skal det være lett å finne akkurat rapporten du trenger!</p>
	
				<h4>Tilpass rapporten før den genereres</h4>
				<p>Det er slutt på all ventetid for å kunne skreddersy rapporten! Nå setter du først alle detaljer for hva rapporten skal ha med, før du trykker "generer rapport". Mye mer effektivt, like fleksibelt!</p>
			</div>
		</div>
	<?php
		##############################################################################
		## DESIGNGENERATOR - PAPERMILL
		 } elseif($_GET['tab']=='papermill') {
		 	$current_user = wp_get_current_user();
		 	$cuid = $current_user->ID;
		 	
			global $marius_db;
			require('/home/ukmno/public_html/UKM/api/conf_wpdb.php');
			global $marius_db;
			$res = mysql_query("SELECT `b_id`
								FROM `ukmno_wp2012`.`ukm_brukere` 
								WHERE `wp_bid` = '".$cuid."'", $marius_db);
			$rad = mysql_fetch_assoc($res);
			$cuid = $rad['b_id'];
		 	
		 	
		 ?>
		<div class="changelog">
			<h3>Designgenerator</h3>
			<div class="feature-section images-stagger-right">
				<img src="http://ukm.no/wp-content/uploads/2012/10/papermillscreenshot.png" class="image-50" />
				<h4>Tilpass ditt UKM-materiell!</h4>
				<p>Her får du mulighet for å skreddersy ditt eget promoteringsmateriell på en enkel og oversiktlig måte, og få ut filer klare for trykk, print eller skjermbruk.</p>
				<a href="http://instrato.no/start/ukm-login.php?uId=<?= $cuid?>" target="_blank">Logg inn til designgeneratoren</a>
			</div>
		</div>
	<?php
		##############################################################################
		## AMBASSADØRER
		 } elseif($_GET['tab']=='ambassadorer') { ?>
	
		<div class="changelog">
		<?php
		if(isset($_GET['ambassadorinvite'])) {
			UKM_loader('ambassadorer/gui');
			$invites = explode(',', $_GET['ambassadorinvite']);

			if(isset($_GET['pl_invite_id']))
				$plid = $_GET['pl_invite_id'];
			else
				$plid = get_option('pl_id');
			
			for($i=0; $i<sizeof($invites); $i++) {
				$res .= sendInvite($invites[$i], $plid);
			}
			$res = 'Status ambassad&oslash;rinvitasjoner: <br />'
				.  $res;
		} else {
			if(get_option('site_type')=='fylke') {
				$monstringer = new SQL("SELECT `pl`.`pl_id`, `pl_name` FROM `smartukm_place` AS `pl`
										JOIN `smartukm_rel_pl_k` AS `rel` ON (`rel`.`pl_id` = `pl`.`pl_id`)
										JOIN `smartukm_kommune` AS `k` ON (`k`.`id` = `rel`.`k_id`)
										WHERE `k`.`idfylke` = '#fylke'
										AND `pl`.`season` = '#season'
										GROUP BY `pl`.`pl_id`
										ORDER BY `pl`.`pl_name`",
										array('fylke'=>get_option('fylke'),
											  'season'=>get_option('season')));
				$monstringer = $monstringer->run();
				$options = '<select name="pl_invite_id">';
				if($monstringer)
					while($r = mysql_fetch_assoc($monstringer)) {
						$options .= '<option value="'.$r['pl_id'].'">'.utf8_encode($r['pl_name']).'</option>';
					}
				$options .= '</select>';
			} else {
				$options = '<input type="hidden" value="'.get_option('pl_id').'" name="pl_invite_id" />';
			}
			$res = 'Skriv inn ett mobilnummer, eller en liste kommaseparerte mobilnummer for å invitere ambassadør(er). '
				.  '<form action="" method="GET">'
				.  '<input type="hidden" name="tab" value="ambassadorer" /> '
				.  '<input type="text" name="ambassadorinvite" id="ambassadorinvite" /> '
				.  $options
				.  '<input type="submit" value="Invitér" />'
				.  '</form>';
		}
		echo '<div style="width: 417px; float:right; padding: 20px 0 0 18px; border-left: 1px solid #f0f0f0; min-height: 200px;">'
			.'<h4>Send SMS-invitasjon til ambassadør(er)</h4>'
			. $res
			. '<hr />'
			. '<h4>Når du inviterer ambassadører vil de motta følgende SMS:</h4>'
			.'Hei! Vi håper at du vil bli ambassadør for UKM. Du gjør så mye eller lite du vil :) Svar UKM AMB for å motta mer informasjon! Hilsen UKM'
			. '<hr />'
			. '<h4>De som svarer UKM AMB vil motta følgende SMS:</h4>'
			.'En UKM-ambassadør forteller andre om UKM, og bidrar til at flere melder seg på. Du får en gratis T-skjorte og noen tips fra oss, men det viktigste verktøyet er deg selv og dine erfaringer! Det er ingen forpliktelser, men om du gjør en god jobb kan du vinne både 1000 kr og en gratistur til UKM-festivalen. 
	Registrer deg på: http://ukm.no/ambassador så er du i gang!'
	
			.'</div>';
	
	?>	<h3>Ambassadører knyttet til <?= get_option('site_type')=='kommune'?'din lokalmønstring':'lokalmønstringer i ditt fylke' ?></h3>	
	<?php	
		if(get_option('site_type')=='kommune') {
			$kommuner = new SQL("SELECT `k_id`
								FROM `smartukm_rel_pl_k`
								WHERE `pl_id` = '#plid'
								AND `season` = '#season'",
								array('plid'=>get_option('pl_id'),
									  'season'=>get_option('season')));
			$kommuner = $kommuner->run();
			while($r = mysql_fetch_assoc($kommuner)) {
				$kommunearray[] = $r['k_id'];
			}
			
			$kommuner = new SQL("SELECT `pl_id`
								 FROM `smartukm_rel_pl_k`
								 WHERE `k_id` IN ('".implode("','",$kommunearray)."')");
			$kommuner = $kommuner->run();
			while($r = mysql_fetch_assoc($kommuner)) {
				$plarray[] = $r['pl_id'];
			}
			
			$pl_ids = "'".implode("','",$plarray)."'";
		} else {
			$kommuner = new SQL("SELECT `id` FROM `smartukm_kommune`
								 WHERE `idfylke`='#fylke'",
								 array('fylke'=>get_option('fylke')));
			$kommuner = $kommuner->run();
			$kommunearray = array();
			while($r = mysql_fetch_assoc($kommuner)) {
				$kommunearray[] = $r['id'];
			}
			$kommuner = new SQL("SELECT `pl_id`
								 FROM `smartukm_rel_pl_k`
								 WHERE `k_id` IN ('".implode("','",$kommunearray)."')");
			$kommuner = $kommuner->run();
			$plarray = array();
			while($r = mysql_fetch_assoc($kommuner)) {
				$plarray[] = $r['pl_id'];
			}
			$plarray[] = get_option('pl_id');
			$pl_ids = "'".implode("','",$plarray)."'";
		}
		$qry = new SQL("SELECT * FROM `ukm_ambassador`
					    WHERE `pl_id` IN (".$pl_ids.")
					    ORDER BY `amb_firstname`,
						`amb_lastname` ASC"
						);
		$res = $qry->run();
		if(mysql_num_rows($res)==0) {
			echo 'Du har ingen registrerte ambassadører';
		} else {
		?>
		<table border="0" cellpadding="2" cellspacing="0">
		<?php
		while($r = mysql_fetch_assoc($res)) {
			$link = '<a href="http://facebook.com/profile.php?id='.$r['amb_faceID'].'" target="_blank">';
			$image = $link
					.'<img src="http://graph.facebook.com/'.$r['amb_faceID']
					. '/picture" style="margin:0px;padding:0px;" />'
					.'</a>';
			$pl = new monstring($r['pl_id']);
			?>
			<tr>
				<td><?=$image?></td>
				<td width="200"><?= $link . utf8_encode($r['amb_firstname'])?> <?=utf8_encode($r['amb_lastname']).'</a>' ?></td>
				<td width="100"><?=$r['amb_phone']?></td>
				<td width="250"><?=$pl->g('pl_name')?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php } ?>	
		</div>
	<?php
		##############################################################################
		## LOKALMØNSTRINGER
		} elseif($_GET['tab']=='lokalmonstringer') {
		
		$lokalmonstringer = new SQL("SELECT `id` FROM `smartukm_kommune`
									 WHERE `idfylke` = '#fylke'",
									 array('fylke'=>get_option('fylke')));
		$lokalmonstringer = $lokalmonstringer->run();
		
		while($l = mysql_fetch_assoc($lokalmonstringer)){
			$m = new kommune_monstring($l['id'], get_option('season'));
			$m = $m->monstring_get();
			$monstringer[$m->g('pl_name')] = $m;
		}
	?>
		<div class="changelog">
			<div class="feature-section images-stagger-right">
				<h4>Lokalmønstringer i ditt fylke</h4>
				<table border="0" cellpadding="2" cellspacing="2" class="ukm_odd_even">
				<?php
				foreach($monstringer as $m) {
					$kontakter = $m->kontakter();
					$c_n = $c_t = '';
	#				var_dump($kontakter);
					foreach($kontakter as $k) {
						$c_n .= '<a href="mailto:'.$k->g('email').'">'.$k->g('name').'</a><br />';
						$c_t .= $k->g('tlf').'<br />';
					}
					echo '<tr>'
						.'<th width="200" valign="top" align="left">'
							.'<a href="/pl'.$m->g('pl_id').'/wp-admin/" target="_blank">'.$m->g('pl_name').'</a>'
						.'</th>'
						.'<td width="200" valign="top">'.$m->starter().'</td>'
						.'<td width="250" valign="top">'.$c_n.'</td>'
						.'<td width="120" valign="top">'.$c_t.'</td>'
						.'</tr>';
				}
				?>
				</table>
			</div>
		</div>
	
	<?php } ?>
	</div>
	<?php
	}
require(ABSPATH . 'wp-admin/admin-footer.php');
die();
?>
*/