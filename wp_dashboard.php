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
require_once(dirname(__FILE__).'/wp_dashboard_functions.php');

require(ABSPATH . 'wp-admin/admin-header.php');

$TWIGdata = array('site_type' => get_option('site_type'),
				  'kontakter' => UKMWP_kontakter(),
				  'statusliste' => UKMWP_statusliste());

echo TWIG('dashboard.twig.html', $TWIGdata, dirname(__FILE__));

require(ABSPATH . 'wp-admin/admin-footer.php');
die();



/*
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