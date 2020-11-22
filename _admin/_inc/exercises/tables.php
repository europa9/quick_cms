<?php
/**
*
* File: _admin/_inc/exercises/tables.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions ------------------------------------------------------------------------ */
function fix_utf($value){
	$value = str_replace("Ã¸", "�", $value);
	$value = str_replace("Ã¥", "�", $value);

        return $value;
}
function fix_local($value){
	$value = htmlentities($value);

        return $value;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_exercise_index 				= $mysqlPrefixSav . "exercise_index";
$t_exercise_index_images			= $mysqlPrefixSav . "exercise_index_images";
$t_exercise_index_videos			= $mysqlPrefixSav . "exercise_index_videos";
$t_exercise_index_muscles			= $mysqlPrefixSav . "exercise_index_muscles";
$t_exercise_index_muscles_images		= $mysqlPrefixSav . "exercise_index_muscles_images";
$t_exercise_index_tags				= $mysqlPrefixSav . "exercise_index_tags";
$t_exercise_tags_cloud				= $mysqlPrefixSav . "exercise_tags_cloud";
$t_exercise_index_comments			= $mysqlPrefixSav . "exercise_index_comments";
$t_exercise_index_translations_relations	= $mysqlPrefixSav . "exercise_index_translations_relations";
$t_exercise_equipments 				= $mysqlPrefixSav . "exercise_equipments";
$t_exercise_types				= $mysqlPrefixSav . "exercise_types";
$t_exercise_types_translations 			= $mysqlPrefixSav . "exercise_types_translations";
$t_exercise_levels				= $mysqlPrefixSav . "exercise_levels";
$t_exercise_levels_translations 		= $mysqlPrefixSav . "exercise_levels_translations";
echo"
<h1>Tables</h1>


	<!-- exercises -->
	";
	$query = "SELECT * FROM $t_exercise_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index: $row_cnt</p>
		";
	}
	else{

		mysqli_query($link, "CREATE TABLE $t_exercise_index(
	  	 exercise_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(exercise_id), 
	  	   exercise_title VARCHAR(250),
	  	   exercise_title_clean VARCHAR(250),
	  	   exercise_title_alternative VARCHAR(250),
	  	   exercise_user_id INT,
	  	   exercise_language VARCHAR(20),
	  	   exercise_muscle_group_id_main INT,
	  	   exercise_muscle_group_id_sub INT,
	  	   exercise_muscle_part_of_id INT,
	  	   exercise_equipment_id  INT,
	  	   exercise_type_id INT,
	  	   exercise_level_id INT,
	  	   exercise_preparation TEXT,
	  	   exercise_guide TEXT,
	  	   exercise_important TEXT,
	  	   exercise_created_datetime DATETIME,
	  	   exercise_updated_datetime DATETIME,
	  	   exercise_user_ip VARCHAR(250),
	  	   exercise_uniqe_hits INT,
	  	   exercise_uniqe_hits_ip_block TEXT,
	  	   exercise_likes INT,
	  	   exercise_dislikes INT,
	  	   exercise_rating INT,
	  	   exercise_rating_ip_block TEXT,
	  	   exercise_number_of_comments INT,
	  	   exercise_reported INT,
	  	   exercise_reported_checked INT,
	  	   exercise_reported_reason TEXT,
	  	   exercise_last_viewed DATETIME)")
		   or die(mysqli_error());
$stram_exercise_index = array(
  array('exercise_id' => '1','exercise_title' => 'Bulgarsk utfall','exercise_title_clean' => 'bulgarsk_utfall','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '3','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn frem et par manualer. Hold de med håndflatene mot hverandre. Stå i en forskjøvet holdning med den venstre foten foran din høyre side. Føttene skal være 0,5-1 meter fra hverandre. Kun vristen foten skal plasseres på benken. Kneet foran skal ha en liten bøy.</p>','exercise_guide' => '<p>Senk kroppen din så langt du kan. Det bakre kneet skal nesten berøre gulvet. Hold overkroppen så oppreist som mulig og korsryggen naturlig buet. Pause, og skyv deg tilbake til startposisjon så raskt som mulig. Fullfør repitisjoner med venstre fot, også med høyre fot.</p>','exercise_important' => '<ul><li>Hvis foten din er på en høyere benk vil treningen være hardere.</li>
</ul>','exercise_created_datetime' => '2018-02-18 12:42:22','exercise_updated_datetime' => '2018-02-19 16:38:45','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '2','exercise_title' => 'Triceps nedtrekk tau i kabel','exercise_title_clean' => 'triceps_nedtrekk_tau_i_kabel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '3','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => NULL,'exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Ta tak i tauet og dra den ned til forsiden av kroppen.</p>','exercise_guide' => '<p>Hold overarmene festet til siden av overkroppen din, utvide armene til å skyve tauet ned. Stopp når albuene er i maks posisjon og reverser så bevegelsen sakte tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Øvelsen skal gi kontinuerlig motstand og triceps skal ha stimulans gjennom hele bevegelsen.</li>
</ul>','exercise_created_datetime' => '2018-02-18 12:43:25','exercise_updated_datetime' => '2018-03-21 18:34:27','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '3','exercise_title' => 'Biceps curl med EZ stang','exercise_title_clean' => 'biceps_curl_med_ez_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '2','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '1','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Last vektstangen med vekter og plasser på sikkerhetskrager. Ta tak i vektstangen med et grep som er skulderbredde. Stå oppreist med flate overarmer og albuer.</p>','exercise_guide' => '<p>Bøy albuen for å løfte vekten oppover med biceps. Overarmer og albuer bør ligge intill siden på kroppen. Ved topposisjon reverseres bevegelsen langsomt tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<p>Mange idrettsutøvere velger å benytte vekstangen EZ, noe som er bedre for håndleddet. Vekstangen EZ er litt bøyd så håndleddene slipper så mye rotasjon under øvelsen. </p>','exercise_created_datetime' => '2018-02-18 12:43:29','exercise_updated_datetime' => '2018-02-19 17:56:44','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '4','exercise_title' => 'Bicepscurl med hantler','exercise_title_clean' => 'bicepscurl_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '2','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Hold hantlene i armene.</p>','exercise_guide' => '<p>La armene henge ned på sidene. Tomlene skal peke bort fra kroppen. Du vil holde dette håndstilling gjennom hele bevegelsen som det ikke bør være noen vridning av hendene når de kommer opp. Dette vil være utgangspunktet.</p>
<p>Trekk opp begge hantlene samtidig. Ikke svinge armene eller bruke momentum. Hold en kontrollert bevegelse hele tiden. Gå tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Ikke utvid armene helt ettersom du kan skade albuene.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Sørg for at bevegelsene er langsomme slik at du unngår skade.</p>
</li>
</ul>','exercise_created_datetime' => '2018-02-18 12:56:53','exercise_updated_datetime' => '2018-02-19 17:56:49','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '5','exercise_title' => 'Benkpress','exercise_title_clean' => 'benkpress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '11','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '4','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Last vekter på vektstang og legg på sikkerhetskrager. Ligg flatt på benken med hælene i bakken. Grip vektstangen med en litt bredere grep enn skulderne. Løft av vektstangen fra stativet.</p>','exercise_guide' => '<p>Styr vektstang ned til brystet, slik at armene går ut nitti grader fra overkroppen. Trykk vektstangen opp igjen slik at armene utvides helt.</p>','exercise_important' => '<ul><li>Hvis du trener alene er det greiest og ikke bruke sikkerhetskragene, da man enklere kan få av vektene hvis man har lastet på for mye. Det anbefales at noen står bak og kan hjelpe til hvis du ikke klarer å ta opp stangen.</li>
</ul>','exercise_created_datetime' => '2018-02-19 16:41:21','exercise_updated_datetime' => '2018-02-19 17:53:48','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '7','exercise_title' => 'Pull ups','exercise_title_clean' => 'pull_ups','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '9','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '5','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '','exercise_guide' => '<p>Ta et grep på stangen som er litt bredere en skuldrene. Håndflatene skal være vendt bort fra deg. Heng fritt, med armene full utstrukket. Trekk kroppen opp slik at halsen når nivået av stangen, og gå sakte ned til startposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Haken skal over stangen når man er øverst i bevegelsen.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Senker man seg sakte ned, 20-30 sekunder vil man kunne øke repitisjoner over tid.</p>
</li>
</ul>','exercise_created_datetime' => '2018-02-21 17:20:42','exercise_updated_datetime' => '2018-02-21 17:20:42','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '1','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '8','exercise_title' => 'Armhevninger','exercise_title_clean' => 'armhevninger','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => NULL,'exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Sett hendene med en litt bredere avstand enn skulderbredde. Kroppen skal være rett, fra hodet og til hælene. Baken skal ikke stikke opp eller være senket ned.</p>','exercise_guide' => '<p>Før deg selv ned slik at albuene får en 90 graders vinkel. Når brystet berører gulvet holder du litt og går tilbake til utgangspunkt.</p>','exercise_important' => '<ul><li>Ikke juks på de siste push-upsene i settet ditt. Når man er sliten er det lett å gjøre feil på de siste repitisjonene. Stopp opp, skriv opp hvor mange du klarte og slå antallet neste gang.</li>
</ul>','exercise_created_datetime' => '2018-02-21 17:44:04','exercise_updated_datetime' => '2018-02-21 17:44:04','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '9','exercise_title' => 'Supermann','exercise_title_clean' => 'supermann','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '9','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => NULL,'exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p><span lang="no" xml:lang="no"><span>Ligg flatt på magen med armene strakt ut foran deg.</span><br /></span></p>','exercise_guide' => '<p><span lang="no" xml:lang="no"><span>Løft armene og beina av gulvet og hold denne posisjonen i 2 sekunder.</span><br /><span>Gå tilbake til startposisjonen på gulvet.</span><br /></span></p>','exercise_important' => '','exercise_created_datetime' => '2018-03-10 17:16:04','exercise_updated_datetime' => '2018-03-10 17:16:04','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '10','exercise_title' => 'Skr&aring; hantlepress','exercise_title_clean' => 'skra_hantlepress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '11','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '6','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p><span lang="no" xml:lang="no">Finn en skråbenk på 30 grader. <br /></span></p>
<p><span lang="no" xml:lang="no">Ha ett sett manualer med passende vekt. Sitt på enden av en skråbenk og la manualene hvile på lårene. Len deg tilbake på benken, og bringer lårene opp slik at du får manualene over deg. Ligg på bneken med føttene på gulvet, med manualer utvidet over brystet. </span></p>','exercise_guide' => '<p>Senk manualene sakte til siden av brystet, slik at overarmene er parallelt med bakken og er vinkelrett på overkroppen. Press brystet og strekk armene slik at manualene går oppover. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Øvelsen skal også trene koordinasjon og stabilisering.</li>
</ul>','exercise_created_datetime' => '2018-03-10 17:29:56','exercise_updated_datetime' => '2018-03-10 17:29:56','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '11','exercise_title' => 'Hantlepress','exercise_title_clean' => 'hantlepress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '3','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Ha ett sett manualer med passende vekt. Sitt på enden av en benk og la manualene hvile på lårene. Len deg tilbake på benken, og bringer lårene opp slik at du får manualene over deg. Ligg på bneken med føttene på gulvet, med manualer utvidet over brystet.</p>','exercise_guide' => '<p>Senk manualene sakte til siden av brystet, slik at overarmene er parallelt med bakken og er vinkelrett på overkroppen. Press brystet og strekk armene slik at manualene går oppover. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Øvelsen skal også trene koordinasjon og stabilisering.</li>
</ul>','exercise_created_datetime' => '2018-03-10 18:19:18','exercise_updated_datetime' => '2018-03-10 18:19:18','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '12','exercise_title' => 'Skulderpress med hantler','exercise_title_clean' => 'skulderpress_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '20','exercise_muscle_group_id_sub' => '21','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Løft en manualer på hver side av skuldrene. Overarmene skal være på linje med hverandre.</p>','exercise_guide' => '<p>Fra startposisjonen trykkes manualer oppover til armene er utvidet. Etter full forlengelse er oppnådd reversere bevegelsen sakte til manualer er tilbake på startposisjon (rundt ørehøyde). Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Øvelsen kan utføres stående eller sittende. Nybegynner bør starte sittende da stående øvelse krever mye kjerne og stabilisering.</li>
</ul>','exercise_created_datetime' => '2018-03-10 18:27:22','exercise_updated_datetime' => '2018-03-10 18:27:22','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '13','exercise_title' => 'Kabel flyes h&oslash;ye','exercise_title_clean' => 'kabel_flyes_hoye','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '8','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Juster stativet slik at kablene er rett over skulderhøyden din.</p>','exercise_guide' => '<p><span lang="no" xml:lang="no"><span title="To get yourself into the starting position, place the pulleys on a high position (above your head), select the resistance to be used and hold the pulleys in each hand.     ">Hold kablene i hånden og bøy deg fremover. </span></span></p>
<p><span lang="no" xml:lang="no"><span title="This will be your starting position.     ">Strekk ut begge armene i en bred bue. Du skal føle en strekk i brystet. Det er kun skulderen som skal arbeide med bevegelsen. Armene og brystet skal være i ro.</span></span></p>
<p><span lang="no" xml:lang="no"><span title="the movement should only occur at the shoulder joint.     ">Pust ut og før armene fremover. </span></span></p>','exercise_important' => '<p>Du kan også utføre lave kabel flyes.</p>','exercise_created_datetime' => '2018-03-10 18:32:22','exercise_updated_datetime' => '2018-03-10 18:32:22','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '14','exercise_title' => 'Kneb&oslash;y med stang','exercise_title_clean' => 'kneboy_med_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '9','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Last på vekter på en vektstang, hvis det er første gang kan du starte uten vekter. Sett føttene rett under vekstangen. Skyt brystet ut. Den øvre delen av ryggen skal være stram.</p>
<p>Løft deg opp og ta ett skritt tilbake. Stå rett med knærne. Lås hoftene for maksimal stabilitet.</p>','exercise_guide' => '<p>Pust inn og skyv knærne til siden og hoftene tilbake og ned. Hold pusten i bunnen. Ikke stopp, men raskt reverser bevegelsen ved å kjøre hoftene rett opp. Hold knærne ut, brystet opp og øvre rygg stramt. På toppen skal hoften og knær være låst. Pust ut på topen ta et sekund pause.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Få inn god teknikk mens fra starten av og med lette vekter. Ved store vekter kan små feil gjøre stor skade på kroppen.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Skal du bruke belte eller knebeskytter? Førstnevnte hjelper til med å stabilisere ryggraden ved å øke trykket på den. Den sistnevnte er bare en måte å løfte mer vekt. Hvis du er nybegynner bør du ikke bruke noen av disse, men heller fokusere på teknikk.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-10 18:40:45','exercise_updated_datetime' => '2018-03-10 18:40:45','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '15','exercise_title' => 'Markl&oslash;ft med hantler','exercise_title_clean' => 'markloft_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p><br /> Finn et sett med manualer. Stå oppreist og hold manualene foran hoftene.</p>','exercise_guide' => '<p>Ha en bøy i kneet. Senk manualene mot bakken ved å bøye hoften. Hold ryggen rett og brystet opp. Når manualer er halvveis ved leggen skal øvelsen reverseres. Gjenta øvelsen for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Hold ryggen rett og brystet opp mens du utfører markløft.</li>
</ul>','exercise_created_datetime' => '2018-03-10 21:43:13','exercise_updated_datetime' => '2018-03-10 21:43:13','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '16','exercise_title' => 'Fronthev','exercise_title_clean' => 'fronthev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '20','exercise_muscle_group_id_sub' => '21','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Velg en ønskede hantler og hold de med skulderbredde. Ha en liten bøy i knærne. Hold overkroppen oppreist og brystet ut og ta et dypt åndedrag. Dette vil være utgangsstillingen.</p>','exercise_guide' => '<p>Holde armene rett og hev en og en hantel opp til øyehøyde (pust ut på vei opp). Hold skriven i et sekund på toppen og senk vekten ned samtidig som du puster inn. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Mange kaller øvelsen bortkastet tid, da den fremre delen av skulderen allerede blir trent i andre press-øvelser, slik som f.eks. benkpress.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-10 21:49:05','exercise_updated_datetime' => '2018-03-10 21:49:05','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '17','exercise_title' => 'Intervaller 400 m x 12, 1 min pause','exercise_title_clean' => 'intervaller_400_m_x_12__1_min_pause','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '10','exercise_type_id' => '5','exercise_level_id' => '2','exercise_preparation' => '<p>Tenk ut en fart du skal klare å holde i 400 meter.</p>','exercise_guide' => '<p>Løp i rask hastighet i 400 meter.</p>
<p>Ta et minutt pause ved at du går på 6 -7 km/h.</p>
<p>Gjenta 12 ganger.</p>','exercise_important' => '<p>Du skal ligge høyt på laktatgrensen. Denne ligger på topp på grensen, over 1,6 km intervallene.</p>','exercise_created_datetime' => '2018-03-10 22:50:29','exercise_updated_datetime' => '2018-03-10 22:50:29','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '18','exercise_title' => 'Lett joggetur','exercise_title_clean' => 'lett_joggetur','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '11','exercise_type_id' => '5','exercise_level_id' => '1','exercise_preparation' => '<p>Pulsklokke og headset.</p>','exercise_guide' => '<p>En lett joggetur splittes opp i tre ulike økter slik at kroppen ikke venner seg til den. </p>
<p>Første turen/uken jogger du 8 km.<br />Andre turen/uken jogger du 9,6 km.<br />Tredje turen/uken jogger du 11,2 km.</p>
<p>Deretter starter du på første uken igjen.</p>','exercise_important' => '<ul><li>En lett løpeøkt løpes for restutisjon. Man skal holde et lavt tempo.</li>
<li>Pulsen skal ligge på rundt 60 %.</li>
</ul>','exercise_created_datetime' => '2018-03-10 23:08:29','exercise_updated_datetime' => '2018-03-10 23:16:38','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '19','exercise_title' => 'Intervaller 800 m x 6, 2 min pause','exercise_title_clean' => 'intervaller_800_m_x_6__2_min_pause','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '10','exercise_type_id' => '5','exercise_level_id' => '2','exercise_preparation' => '<p>Tenk deg en fart du skal klare i 800 m 6 ganger.</p>
<p>Sett møllen på 1 i incline, skru på pulsklokken og favorittmusikken din.</p>','exercise_guide' => '<p>Løp 800 m. <br />Rask gange i 2 minutter. <br />Gjenta 6 ganger.</p>','exercise_important' => '<ul><li>Du skal klare alle intervallene. Hvis du ikke klarer alle har du for rask hastighet.</li>
<li>Du skal ligge høyt på laktatgrensen. Denne ligger på topp på grensen, over 1,6 km intervallene.</li>
</ul>','exercise_created_datetime' => '2018-03-11 09:00:10','exercise_updated_datetime' => '2018-03-11 09:00:10','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '20','exercise_title' => 'Intervaller 1,6 km x 3, 3 min pause','exercise_title_clean' => 'intervaller_1_6_km_x_3__3_min_pause','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '10','exercise_type_id' => '5','exercise_level_id' => '2','exercise_preparation' => '<p>I disse lange intervallene skal du ligge over laktalgrensen i forhold til tempo kjøringene. Du skal samtidig ligge lavere enn 400 meter og 800 meter intervallene.</p>
<p>Møllen skal stå på incline 1 - 1,5.</p>','exercise_guide' => '<p>Løp 1,6 km.<br />Rask gange i 3 min.<br />Gjenta 3 ganger.</p>','exercise_important' => '<p>Ligg over laktalgrensen for melkesyredannelse på 1,6 km intervallene, men lavere enn 400 og 800 meters intrevallene.</p>','exercise_created_datetime' => '2018-03-11 09:04:56','exercise_updated_datetime' => '2018-03-11 09:04:56','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '21','exercise_title' => 'Tempo joggetur','exercise_title_clean' => 'tempo_joggetur','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '11','exercise_type_id' => '5','exercise_level_id' => '2','exercise_preparation' => '<p>Pulsklokke og headset.</p>','exercise_guide' => '<p>Tempo betyr at du skal ligge rett over grensen hvor kroppen produserer melkesyre. Denne joggetur splittes opp i tre ulike økter slik at kroppen ikke venner seg til den.</p>
<p>Første turen/uken jogger du 9,6 km.<br />Andre turen/uken jogger du 11,2 km.<br />Tredje turen/uken jogger du 12,8 km.</p>
<p>Deretter starter du på første uken igjen.</p>','exercise_important' => '<ul><li>Du skal kunne holde samme farten i hele tempoøkten.</li>
</ul>','exercise_created_datetime' => '2018-03-11 09:09:43','exercise_updated_datetime' => '2018-03-11 09:09:43','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '22','exercise_title' => 'Langkj&oslash;ring joggetur','exercise_title_clean' => 'langkjoring_joggetur','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '11','exercise_type_id' => '5','exercise_level_id' => '2','exercise_preparation' => '<p>Forebered din pulsklokke og favorittmusikk.</p>','exercise_guide' => '<p>Denne er den lengste joggeturen du trenger hvis du forbereder deg for 5 km. Langkjøring splittes i tre ulike økter:</p>
<p>Første uken 12,8 km.<br />Andre uken 14,5 km.<br />Tredje uken 16 km.<br />Deretter start på første uken.</p>','exercise_important' => '<ul><li>
<p> Disse øktene skal løpes raskere en lett joggetur, men ikke raskere enn tempo joggetur.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-11 09:25:49','exercise_updated_datetime' => '2018-03-11 09:25:49','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '23','exercise_title' => 'Hammercurl med hantler','exercise_title_clean' => 'hammercurl_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '2','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Hold hantlene i armene.</p>','exercise_guide' => '<p>La armene henge ned på sidene. Tomlene skal peke bort fra kroppen. Du vil holde dette håndstilling gjennom hele bevegelsen som det ikke bør være noen vridning av hendene når de kommer opp. Dette vil være utgangspunktet.</p>
<p>Trekk opp en og en hantel. Ikke svinge armene eller bruke momentum. Hold en kontrollert bevegelse hele tiden. Gå tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li style="margin:4px 0px 6px 0px;padding:0;"> Ikke utvid armene helt ettersom du kan skade albuene.</li>
<li style="margin:4px 0px 6px 0px;padding:0;">Sørg for at bevegelsene er langsomme slik at du unngår skade.</li>
</ul>','exercise_created_datetime' => '2018-03-12 16:51:08','exercise_updated_datetime' => '2018-03-12 16:51:08','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '24','exercise_title' => 'Markl&oslash;ft med stang','exercise_title_clean' => 'markloft_med_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '12','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p>Sett opp en vektstang med ønsket vekt på gulvet foran deg. Føttene skal ca ha en skulders avstand. Sitt på huk ved å bøye knærne til du er langt nok nede til å få et grep på vektstang. Ta tak i vektstang med overhandsgrep som er litt bredere enn skulderbredde.</p>','exercise_guide' => '<p>Ta et dyp innpust. Bruk beina til å løfte vekten oppover til du står oppreist. Når stangen når knærne retter du deg opp. Ta en kort pause på toppen av bevegelsen for å sikre at optimal sammentrekning er oppnådd. Knærne skal ikke være låst. Senk vekten tilbake til startposisjon. Pust og gjør deg klar for en ny repitisjon.</p>','exercise_important' => '<p>Hvis du ikke opprettholder riktig teknikk under markløft vil du til slutt skade deg. Forhør deg med en personlig trener.</p>','exercise_created_datetime' => '2018-03-17 22:17:01','exercise_updated_datetime' => '2018-03-17 22:17:01','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '25','exercise_title' => 'Utfall med stang','exercise_title_clean' => 'utfall_med_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '12','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Stå med overkroppen oppreist med en vektstang over skuldrene. Denne stillingen vil være utgangspunktet for øvelsen.</p>','exercise_guide' => '<p>Gå ett skritt frem med høyre bein på ca 0,5 meter og senk overkroppen ned. Brystet skal skytes ut og samtidig må balansen opprettholdes. Bruk hovedsakelig hælen av foten, skyv opp og gå tilbake til startposisjon som du puster ut. Repeter bevegelsen og utfør deretter med venstre ben.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Du kan veksle fot hver gang. For eksempel kan du først ta en reptisjon med høyre fot, også en med venstre fot og så videre</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Hvis du har problemer med balansen kan du gjøre øvelsen uten vektstang. </p>
</li>
</ul>','exercise_created_datetime' => '2018-03-18 08:23:49','exercise_updated_datetime' => '2018-03-18 08:23:49','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '26','exercise_title' => 'Omvendt roing i smithmaskin','exercise_title_clean' => 'omvendt_roing_i_smithmaskin','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '7','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '13','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p><span lang="no" xml:lang="no"><span>Sett en stang i midjehøyde. <br />La føttene hvile på bakken og grip tak i stangen. </span><br />Klem skulderbladene sammen og trekk brystet opp til stangen.</span></p>','exercise_guide' => '<p>Press deg opp til stangen slik at brystet er borti den.</p>
<p>Senk deg så ned igjen og repeter.</p>','exercise_important' => '<ul><li>Hold kroppen rett under øvelsen.</li>
</ul>','exercise_created_datetime' => '2018-03-18 08:41:52','exercise_updated_datetime' => '2018-03-18 08:50:09','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '27','exercise_title' => 'Dips','exercise_title_clean' => 'dips','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '14','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Ta tak i sidene på dips-stativet. Press deg oppover til startposisjonen. Føttene kan være krysset over bak deg, med knærne bøyd.</p>','exercise_guide' => '<p>Senk kroppen din ned kontrollert helt til triceps er parallellt med gulvet. Kroppen skal være fremoverbøyd med omentrent ca 45 grader. Brystet og skuldrene skal være strekt. Fortsett å len deg litt fremover samtidig som du skyver deg opp til startposisjonen.</p>','exercise_important' => '<ul><li>Når du utfører dips kan beina være bøyd, krysset eller rett, avhengig av hvor høyt opep fra gulvet du er.</li>
</ul>','exercise_created_datetime' => '2018-03-18 09:00:54','exercise_updated_datetime' => '2018-03-18 09:00:54','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '28','exercise_title' => 'Kabel flyes lave','exercise_title_clean' => 'kabel_flyes_lave','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '8','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Juster stativet slik at kablene er på det laveste nivået.</p>','exercise_guide' => '<p><span lang="no" xml:lang="no"><span title="To get yourself into the starting position, place the pulleys on a high position (above your head), select the resistance to be used and hold the pulleys in each hand.     ">Hold kablene i hånden og bøy deg fremover. </span></span></p>
<p><span lang="no" xml:lang="no"><span title="This will be your starting position.     ">Strekk ut begge armene i en bred bue. Du skal føle en strekk i brystet. Det er kun skulderen som skal arbeide med bevegelsen. Armene og brystet skal være i ro.</span></span></p>
<p><span lang="no" xml:lang="no"><span title="the movement should only occur at the shoulder joint.     ">Pust ut og før armene fremover. </span></span></p>','exercise_important' => '<ul><li>Du kan også utføre lave kabel høye.</li>
</ul>','exercise_created_datetime' => '2018-03-18 09:11:29','exercise_updated_datetime' => '2018-03-18 09:11:29','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '29','exercise_title' => 'Crunches','exercise_title_clean' => 'crunches','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '3','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Plasser en matte på gulvet. Du kan bruke en benk til å ha beinene på. En annen variant er bøyde knær og føttene flatt på gulvet. Bøy armene ved albuen og plassere hendene nær ørene. Hold en avstand mellom haken og brystet hele tiden. Halsen skal forbli i en nøytral posisjon.</p>','exercise_guide' => '<p>Hev skuldrene opp fra gulvet, bøye den øvre delen av ryggen din mens den nedre del av ryggen forblir stasjonær. Når sammentrekning er nådd skal du ha en pause på et sekund, og deretter sakte reversere tilbake til startposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Ikke bøy ryggen. Denne øvelsen skal trene magen, ikke ryggen.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Denne øvelse utvikler magemusklene, men fører ikke til spesifikk fettreduksjon fra magen. For fettreduksjon er det viktig at man følger et sundt kosthold.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-18 09:28:53','exercise_updated_datetime' => '2018-03-18 09:28:53','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '30','exercise_title' => 'Omvendt skr&aring; hantlepress','exercise_title_clean' => 'omvendt_skra_hantlepress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '6','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Ha ett sett manualer med passende vekt. Sitt på enden av en benk og la manualene hvile på lårene. Len deg tilbake på benken. Ha en manual i hver hånd. Ligg på bneken med føttene sikret i benken.</p>','exercise_guide' => '<p>Senk manualene sakte til siden av brystet, slik at overarmene er parallelt med bakken og er vinkelrett på overkroppen. Press brystet og strekk armene slik at manualene går oppover. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Øvelsen skal også trene koordinasjon og stabilisering.</li>
</ul>','exercise_created_datetime' => '2018-03-18 09:38:23','exercise_updated_datetime' => '2018-03-18 09:38:23','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '31','exercise_title' => 'Liggende tricepspress','exercise_title_clean' => 'liggende_tricepspress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '3','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn en passende vekt på en manual. Legg deg på en benk med manualen i hånden.</p>','exercise_guide' => '<p>Senk manualen ned over hodet.</p>
<p>Løft manualen så opp igjen. Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Ikke overgå deg selv. Denne øvelsen er lett å skade triceps på, så ikke bruk for tunge vekter.</li>
</ul>','exercise_created_datetime' => '2018-03-18 15:03:59','exercise_updated_datetime' => '2018-03-18 15:03:59','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '32','exercise_title' => 'Flyes med hantler','exercise_title_clean' => 'flyes_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '12','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn to manualer og plasser de på lårne dine.</p>
<p>Legg deg ned på en flatbenk.</p>','exercise_guide' => '<p>Beveg armene ut til siden, og så inn og opp igjen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-18 15:56:29','exercise_updated_datetime' => '2018-03-18 15:56:29','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '33','exercise_title' => 'Utfall med hantler','exercise_title_clean' => 'utfall_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '16','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Stå med overkroppen oppreist med en manual i hver hånd. Denne stillingen vil være utgangspunktet for øvelsen.</p>','exercise_guide' => '<p>Gå ett skritt frem med høyre bein på ca 0,5 meter og senk overkroppen ned. Brystet skal skytes ut og samtidig må balansen opprettholdes. Bruk hovedsakelig hælen av foten, skyv opp og gå tilbake til startposisjon som du puster ut. Repeter bevegelsen og utfør deretter med venstre ben.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Du kan veksle fot hver gang. For eksempel kan du først ta en reptisjon med høyre fot, også en med venstre fot og så videre</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Hvis du har problemer med balansen kan du gjøre øvelsen uten manualer.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-18 16:05:59','exercise_updated_datetime' => '2018-03-18 16:05:59','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '34','exercise_title' => 'Sidehev','exercise_title_clean' => 'sidehev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '20','exercise_muscle_group_id_sub' => '21','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Velg lette manualer og stå med rett rygg. Hold manualer i armene med håndflatene mot deg.</p>','exercise_guide' => '<p>Løft manualene til din side med en liten bøy på albuen. Fortsett å gå opp til du armene er parallelt med gulvet. Ta et sekund pause på toppen og senk manualene tilbake langsomt ned til startposisjon. Gjenta etter treningsprogrammets antall repetisjoner.</p>','exercise_important' => '<p style="padding-bottom:0;margin-bottom:0;"> </p>
<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Hold overkroppen i ro (ikke sving med kroppen).</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-18 16:13:35','exercise_updated_datetime' => '2018-03-18 16:13:35','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '35','exercise_title' => 'Beinspark (Leg extension)','exercise_title_clean' => 'beinspark_leg_extension','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '15','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Juster benstrekk/benekstensjon apparatet slik at det er tilpasset din høyde.</p>','exercise_guide' => '<p>Press opp med beina, samtidig som du holder ryggen din rett.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-19 21:47:17','exercise_updated_datetime' => '2018-03-20 16:28:44','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '36','exercise_title' => 'Beinpress (Leg press)','exercise_title_clean' => 'beinpress_leg_press','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '15','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg på eventuelle vekter på beinpressmaskinen. Sett deg ned i maskinen.</p>','exercise_guide' => '<p><span lang="no" xml:lang="no">Ta bort sikkerhetsbøylene og press platen til den er helt oppe. Knærne skal ikke låse seg. Kroppen og beina dine skal danne nesten 90 graders vinkel.<br /></span></p>
<p><span lang="no" xml:lang="no">La platen gli nedover samtidig som du bøyer knærne.</span></p>
<p><span lang="no" xml:lang="no">Skyv så platen opp igjen.</span></p>
<p><span lang="no" xml:lang="no">Gjenta for ønskede antall repitisjoner. </span></p>','exercise_important' => '<p>Ikke strekk beina dine ut slik at knærne låser seg. Dette kan føre til veldig farlige skader.</p>','exercise_created_datetime' => '2018-03-20 16:30:19','exercise_updated_datetime' => '2018-03-20 16:30:19','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '37','exercise_title' => 'Franskpress','exercise_title_clean' => 'franskpress','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '3','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '1','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p>Bruk en Ez-stang. Last på ønsket vekter på stangen.</p>
<p>Legg deg på rygg på en flat benk. La Ez-stangen ligge på magen din.</p>
<p>Løft opp stangen til over hodet.</p>','exercise_guide' => '<p>Senk stangen ned bak hodet ditt, og press så opp.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>På engelsk heter denne øvelsen Skull Crushers.</li>
<li>Du kan starte med triceps nedpress før denne øvelsen da denne er teknisk krevende.</li>
</ul>','exercise_created_datetime' => '2018-03-20 16:41:07','exercise_updated_datetime' => '2018-03-20 16:48:30','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '38','exercise_title' => 'L&aring;rcurl (Leg curl)','exercise_title_clean' => 'larcurl_leg_curl','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '16','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '16','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still inn leg curl maskinen til ønsket vekt. Legg deg ned på maskinen på magen.</p>','exercise_guide' => '<p>Hev leggene dine. Repeter for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-20 16:51:07','exercise_updated_datetime' => '2018-03-20 16:51:07','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '39','exercise_title' => 'Benkpress i maskin','exercise_title_clean' => 'benkpress_i_maskin','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '11','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '17','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still inn maskinen til ønsket vekt. Ha føttene plantet på gulvet. Ta et godt grep litt bredere en skuldrene. Løft opp brystet.</p>','exercise_guide' => '<p>Press håntakene ut fra kroppen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-20 16:59:33','exercise_updated_datetime' => '2018-03-20 16:59:33','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '40','exercise_title' => 'En arms bicepscurl med hantel','exercise_title_clean' => 'en_arms_bicepscurl_med_hantel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '2','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '6','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn en passende vekt. Sett opp en benk slik at du får en god skråning.</p>','exercise_guide' => '<p>Ha armen hvile over benken og hold i en hantel.</p>
<p>Trekk hantelen mot deg. Strekk så ut armen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Denne øvelsen skal trene biceps.</li>
</ul>','exercise_created_datetime' => '2018-03-20 17:33:54','exercise_updated_datetime' => '2018-03-20 17:33:54','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '41','exercise_title' => 'En arms tricepspress med hantel','exercise_title_clean' => 'en_arms_tricepspress_med_hantel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '3','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn en passende vekt på en manual. Denne øvelsen kan enten gjøres sittende eller stående.</p>','exercise_guide' => '<p>Trekk hantelen over og bak hodet ditt. Press så armen opp i været.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Denne øvelsen kan være veldig tung, så du bør starte med en lav vekt.</li>
</ul>','exercise_created_datetime' => '2018-03-20 17:45:36','exercise_updated_datetime' => '2018-03-20 17:45:36','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '42','exercise_title' => 'Goblet squats','exercise_title_clean' => 'goblet_squats','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn ønsket vekt i hantel eller kettlebell.</p>','exercise_guide' => '<p>Når du holder manualen i hendene kan du lage en "sette deg ned"-bevegelse. Rett deg så opp igjen.</p>
<p>Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Hold ryggen rett under øvelsen.</li>
<li>På engelsk heter denne øvelsen plie squat with dumbbell.</li>
</ul>','exercise_created_datetime' => '2018-03-20 18:10:02','exercise_updated_datetime' => '2018-03-20 18:10:02','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '43','exercise_title' => 'Biceps curl med EZ stang over benk','exercise_title_clean' => 'biceps_curl_med_ez_stang_over_benk','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '2','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '1','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Last vektstangen med vekter og plasser på sikkerhetskrager. Ta tak i vektstangen med et grep som er skulderbredde. Ha flate overarmer og albuer.</p>','exercise_guide' => '<p>Bøy albuen for å løfte vekten oppover med biceps. Overarmer og albuer bør ligge intill siden på kroppen. Ved topposisjon reverseres bevegelsen langsomt tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Denne øvelsen kan også gjøres stående.</li>
</ul>','exercise_created_datetime' => '2018-03-20 18:21:51','exercise_updated_datetime' => '2018-03-20 18:21:51','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '44','exercise_title' => 'St&aring;ende roing med stang','exercise_title_clean' => 'staende_roing_med_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '8','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '12','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p>Finn en olympisk stang. Legg på ønskete vekter.</p>
<p>Still deg foran vektstangen og ha en rett rygg.</p>','exercise_guide' => '<p>Bøy deg litt fremover og trekk stangen mot deg. Senk den så ned igjen.</p>
<p>Gjenta for ønskete antall repitisjoner.</p>','exercise_important' => '<ul><li>På engelsk heter denne øvelsen rear deltoid row with barbell.</li>
</ul>','exercise_created_datetime' => '2018-03-20 18:26:32','exercise_updated_datetime' => '2018-03-20 18:26:32','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '45','exercise_title' => 'En arms roing med hantler','exercise_title_clean' => 'en_arms_roing_med_hantler','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '7','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn en passende manual og en flat benk. <br />Putt det ene kneet oppå benken og støtt opp kroppen med en ene hånden. <br />Ha hantlen i den andre hånden.</p>','exercise_guide' => '<p>Løft opp hantlen til siden av kroppen. <br />Senk hantlen ned igjen i en kontrollert tempo.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Hold en rett rygg under denne øvelsen.</li>
<li>Husk at du skal trene ryggen, så ikke svai med kroppen under opptrekket av hantelen.</li>
</ul>','exercise_created_datetime' => '2018-03-20 21:26:30','exercise_updated_datetime' => '2018-03-20 21:26:30','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '46','exercise_title' => 'Sittende ab crunches i kabel','exercise_title_clean' => 'sittende_ab_crunches_i_kabel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '18','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still inn ønsket vekt i maskinen. Fest på et tau. Still deg med ryggen til maskinen og ta tak i tauet.</p>','exercise_guide' => '<p>Gå ned i sitte-stilling og trekk ned vekten. <br />Slipp så vekten opp i en kontrollert bevegelse. </p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Hendene skal være i ørehøyde hele tiden.</li>
<li>Hvis du har ryggproblemer bør du kontakte en personlig trener for veiledning.</li>
</ul>','exercise_created_datetime' => '2018-03-20 21:36:34','exercise_updated_datetime' => '2018-03-20 21:36:34','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '47','exercise_title' => 'Roing','exercise_title_clean' => 'roing','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '7','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '19','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Sitt på setet med en oppreist kropp. Ryggen skal være rett og knærne skal være bøyd. Ta tak i håndtakene med armene utstrakt foran deg.</p>','exercise_guide' => '<p>Trekk håndtaket mot magen og oppretthold en god holdning (rett rygg, ikke bøy deg fremover). Når håndtaket når magen reverseres bevegelsen langsomt tilbake til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<p style="padding-bottom:0;margin-bottom:0;"> </p>
<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Ikke sving eller rykk i vektene i løpet av øvelsen.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Ikke hent moment, det vil si bøy deg fremover i øvelsen.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-21 17:05:43','exercise_updated_datetime' => '2018-03-21 17:05:43','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '48','exercise_title' => 'Sittende leggcurl','exercise_title_clean' => 'sittende_leggcurl','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '13','exercise_muscle_group_id_sub' => '15','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '20','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still inn vektene til ønsket styrkegrad. Still inn apparatet slik at den passer din høyde.</p>','exercise_guide' => '<p>Press legge ned og mot deg. Slipp så løs i et kontrollert tempo.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Ikke lås kneet på hvilestilling.</li>
</ul>','exercise_created_datetime' => '2018-03-21 17:18:10','exercise_updated_datetime' => '2018-03-21 17:18:10','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '49','exercise_title' => 'Shrugs','exercise_title_clean' => 'shrugs','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '20','exercise_muscle_group_id_sub' => '21','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn to manualer i passende vekt. Hold dem i hendene.</p>','exercise_guide' => '<p>Trekk skuldrene opp. Slipp så opp i et kontrollert tempo.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-21 17:25:06','exercise_updated_datetime' => '2018-03-21 17:25:06','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '50','exercise_title' => 'Sideb&oslash;y med hantel','exercise_title_clean' => 'sideboy_med_hantel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '2','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Hold en manual i hver hånd. </p>','exercise_guide' => '<p>Bøy deg ned til den ene siden. Rett deg så opp igjen, og bøy deg til andre siden.</p>
<p>Repeter for antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-21 17:38:42','exercise_updated_datetime' => '2018-03-21 17:38:42','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '51','exercise_title' => 'Sideplanke','exercise_title_clean' => 'sideplanke','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => NULL,'exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg deg på siden. Ha begge føttene oppå hverandre. Støtt deg opp med den ene armen, rett under skulderen.</p>','exercise_guide' => '<p>Løft deg opp og hold posisjonen. Ikke la hoftene falle til gulvet.</p>
<p>Gjør det samme for andre siden.</p>
<p>Repter for antall ønsket repitisjoner.</p>','exercise_important' => '<ul><li>H<span lang="no" xml:lang="no"><span>old hodet og nakken rett.</span> <br /></span></li>
</ul>','exercise_created_datetime' => '2018-03-21 17:46:08','exercise_updated_datetime' => '2018-03-21 17:46:08','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '52','exercise_title' => 'Benkpress i smithmaskin','exercise_title_clean' => 'benkpress_i_smithmaskin','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '10','exercise_muscle_group_id_sub' => '11','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '13','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Sett på ønskete vekter i smith maskinen.</p>
<p>Grip vektstangen med en litt bredere grep enn skulderne.</p>','exercise_guide' => '<p>Styr vektstang ned til brystet, slik at armene går ut nitti grader fra overkroppen. Trykk vektstangen opp igjen slik at armene utvides helt.</p>','exercise_important' => '<ul><li>Det anbefales at noen står bak og kan hjelpe til hvis du ikke klarer å ta opp stangen.</li>
</ul>','exercise_created_datetime' => '2018-03-21 18:07:16','exercise_updated_datetime' => '2018-03-21 18:07:16','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '53','exercise_title' => 'St&aring;ende bicepscurl med stang i kabel','exercise_title_clean' => 'staende_bicepscurl_med_stang_i_kabel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '0','exercise_muscle_group_id_sub' => '0','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => NULL,'exercise_type_id' => '6','exercise_level_id' => '1','exercise_preparation' => '<p>Hekt på en flat stang på en kabel. Den skal være på det laveste nivået. Still inn ønsket vekt.</p>
<p>Stå med beina i vanlig skulderavstand.</p>','exercise_guide' => '<p>Trekk stangen mot deg slik at biceps sammentrekker seg. Slipp så kontrollert opp igjen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => NULL,'exercise_created_datetime' => '2018-03-21 18:12:37','exercise_updated_datetime' => '2018-03-21 18:16:07','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '54','exercise_title' => 'St&aring;ende pushdown med b&oslash;yd stang','exercise_title_clean' => 'staende_pushdown_med_boyd_stang','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '7','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '21','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Finn en bøyd stang som du hekter på en kabel. Still kabelen slik at den er høyere en deg.</p>','exercise_guide' => '<p>Ta tak i stangen og trekk den ned. Slipp så kontrollert opp igjen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Denne øvelsen trener lats og armer.</li>
</ul>','exercise_created_datetime' => '2018-03-21 18:21:03','exercise_updated_datetime' => '2018-03-21 18:21:03','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '55','exercise_title' => 'Triceps nedtrekk stang i kabel','exercise_title_clean' => 'triceps_nedtrekk_stang_i_kabel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '1','exercise_muscle_group_id_sub' => '3','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '23','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Hekt på en stang i en kabel. <br />Still kabelen til over hodet ditt. <br />Stå med skulderavstand i beina. <br />Ta tak i stangen.</p>','exercise_guide' => '<p>Trekk kabelen ned mot gulvet. Slipp den opp i et kontrollert tempo.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Denne øvelsen trener triceps.</li>
<li>Øvelsen kan også gjøres med tau.</li>
</ul>','exercise_created_datetime' => '2018-03-21 18:34:59','exercise_updated_datetime' => '2018-03-21 18:34:59','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '56','exercise_title' => 'Nedtrekk bredt grep','exercise_title_clean' => 'nedtrekk_bredt_grep','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '8','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '24','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Start med armene helt ut på toppen.</p>','exercise_guide' => '<p>Trekk stangen kontrollert mot brystet mens fokuset er på å trekke albuen inn i siden. Når stangen er ved brystet skal du presse noen sekuner før stangen bringes sakte tilbake til startposisjon. Tilbaketrekningen bør være 2-4 sekunder. Når stangen er på toppen skal armene være helt utstrakte og bevegelsen kan gjentas. Sørg for at skuldrene er trukket tilbake gjennom hele øvelsen.</p>','exercise_important' => '<ul><li>
<p style="margin:4px 0px 6px 0px;padding:0;">Sitt nesten rett opp (og ikke lener vei tilbake som mange mennesker vil gjøre). Dette vil bidra til å holde fokus på latissimus dorsi og ikke midten av ryggen.</p>
</li>
<li>
<p style="margin:4px 0px 6px 0px;padding:0;">Nedtrekk er ikke veldig komplisert, men vil du ofte se mange gjøre den feil. Hvis målet ditt er styrke og størrelse for latissimus dorsi må øvelsen utføres med kontrollerte og lave vekter. Hold fokus på hvordan latissimus dorsi aktiveres gjennom hele bevegelsen.</p>
</li>
</ul>','exercise_created_datetime' => '2018-03-21 18:45:03','exercise_updated_datetime' => '2018-03-21 18:45:03','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '57','exercise_title' => 'Nedtrekk V-Bar','exercise_title_clean' => 'nedtrekk_v-bar','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '8','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '25','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Plasser lårene under putene og strekk armene over hodet og ta tak i håndtakene. </p>','exercise_guide' => '<p>Trekk håndtaket mot øvre del av brystet. Når håndtaket er ved brystet reverseres bevegeselen langsomt til utgangsposisjonen. Gjenta for ønsket antall repetisjoner.</p>','exercise_important' => '<ul><li>Ikke sving eller rykk i vektene i løpet av øvelsen. Kroppen bør holde seg i ro under øvelsen.</li>
</ul>','exercise_created_datetime' => '2018-03-21 18:55:24','exercise_updated_datetime' => '2018-03-21 18:59:32','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '58','exercise_title' => 'Liggende beinhev','exercise_title_clean' => 'liggende_beinhev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '26','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg deg på ryggen.</p>
<p>Ha  hendene på siden av kroppen din.</p>','exercise_guide' => '<p>Løft opp beina dine, med knærne litt bøyd. Når beina er helt på toppen holder du en kort stund før du senker de igjen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Du kan gjøre denne øvelsen på en yoga-matte.</li>
<li>Du kan legge på mer vekt ved å holde en manual mellom føttende.</li>
</ul>','exercise_created_datetime' => '2018-03-23 16:22:42','exercise_updated_datetime' => '2018-03-23 16:22:42','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '59','exercise_title' => 'Liggende vekslende beinhev','exercise_title_clean' => 'liggende_vekslende_beinhev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '26','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg deg på ryggen.<br />Ha hendene på siden av kroppen din.</p>','exercise_guide' => '<p>Løft opp det ene beinet ditt, med kneet litt bøyd. Når beina er helt på toppen holder du en kort stund før du senker de igjen. <br />Gjenta så med det andre beinet</p>
<p>Gjenta hele prossedyren for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 16:31:40','exercise_updated_datetime' => '2018-03-23 16:31:40','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '60','exercise_title' => 'Beintrekk','exercise_title_clean' => 'beintrekk','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '3','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Sitt deg ned på en benk. <br />Hold deg fast med hendene på siden av benken.<br />Len deg litt tilbake, samtidig som du holder ryggen din rett.</p>','exercise_guide' => '<p>Dra inn føttene mot deg, samtidig som du bøyer knærne dine. <br />Hold et lite øyeblikk og skyv så beina ut igjen. </p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 16:38:30','exercise_updated_datetime' => '2018-03-23 16:38:30','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '61','exercise_title' => 'Sittende twists','exercise_title_clean' => 'sittende_twists','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '27','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p>Finn en passende størrelse på en vekstkive, medisinball eller en kettlebell. <br />Sett deg på en treningsmatte.</p>','exercise_guide' => '<p>Enten roter overkroppen fra siden til siden. Dette kalles for russion twists.</p>
<p>Hvis du ikke ønsker dette kan du kun rotere armene.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 16:45:57','exercise_updated_datetime' => '2018-03-23 16:45:57','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '62','exercise_title' => 'Sit-ups','exercise_title_clean' => 'sit-ups','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '26','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg deg ned på en treningsmatte.</p>','exercise_guide' => '<p>Løft deg opp med magemusklene til du er oppe. <br />Hold ryggen rett under øvelsen.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '<ul><li>Ikke sving med kroppen.</li>
<li>Ikke dra deg fremover.</li>
</ul>','exercise_created_datetime' => '2018-03-23 16:54:44','exercise_updated_datetime' => '2018-03-23 16:54:44','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '63','exercise_title' => 'Hengende beinhev','exercise_title_clean' => 'hengende_beinhev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '5','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p><span lang="no" xml:lang="no"><span>Heng fra en stang med armene helt utstrakt. Beina skal være litt bak kroppen. <br /></span></span></p>','exercise_guide' => '<p><span lang="no" xml:lang="no"><span>Løft beina til du får en 90 graders vinkel med beina.</span> <span>Pust ut når du utfører denne bevegelsen, og hold et øyeblikk før du går tilbake til utgangsstilling. <br /></span></span></p>
<p><span lang="no" xml:lang="no"><span>Repter for ønsket antall repitisjoner.</span></span></p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 16:59:51','exercise_updated_datetime' => '2018-03-23 16:59:51','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '64','exercise_title' => 'Cross-Body Crunch','exercise_title_clean' => 'cross-body_crunch','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '26','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p><span lang="no" xml:lang="no"><span>Finn en treningsmatte. Legg deg ned på den helt flat. Lag en bøy i knærne på 60 grader.</span><br />Legg hendene løst bak hodet. <span>Dette vil være din startposisjon.</span></span></p>','exercise_guide' => '<p>Løft venstre bein og krøll sammen kroppen med din høyre overkropp. Senk så venstre bein og rett deg ut.<br />Gjør det samme med andre siden.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 17:17:15','exercise_updated_datetime' => '2018-03-23 17:25:06','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '65','exercise_title' => 'Omvendt skr&aring; crunches','exercise_title_clean' => 'omvendt_skra_crunches','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '6','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p><span lang="no" xml:lang="no">Juster en benk slik at den går på skrå oppover. <br />Legg deg ned på benken med ryggen. <br />Hold deg fast i benken ved å holde i toppen av benken. </span></p>
<p><span lang="no" xml:lang="no">Hold beina parallelt med gulvet med magemusklene. Beina skal være fullt utstrakt med en liten bøy på kneet. <br /></span></p>','exercise_guide' => '<p>Trekk beina mot deg og skyv de opp i lufen. Trekk de så mot deg og skyv de ut fra deg.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 17:29:09','exercise_updated_datetime' => '2018-03-23 17:29:09','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '66','exercise_title' => 'Rollout med hjul','exercise_title_clean' => 'rollout_med_hjul','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '28','exercise_type_id' => '2','exercise_level_id' => '2','exercise_preparation' => '<p>Sett deg på knær. Hold hjulet med begge hendene. <br />Plasser hjulet på gulvet foran deg. <span lang="no" xml:lang="no"></span></p>
<p> </p>','exercise_guide' => '<p><span lang="no" xml:lang="no"><span>Rull sakte rett fremover, og strekk kroppen din i en rett stilling.</span><span> <br />Gå ned så langt du kan uten å berøre gulvet med kroppen din.</span> </span></p>
<p><span lang="no" xml:lang="no">Rull deg så opp igjen.</span></p>
<p><span lang="no" xml:lang="no">Gjenta for ønsket antall repitisjoner.</span></p>
<p> </p>','exercise_important' => '<ul><li>Kontakt din PT om du har ryggproblemer for å finne alternative øvelser.</li>
</ul>','exercise_created_datetime' => '2018-03-23 17:37:16','exercise_updated_datetime' => '2018-03-23 17:37:16','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '67','exercise_title' => 'Ab crunches i kabel','exercise_title_clean' => 'ab_crunches_i_kabel','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '8','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still inn ønsket vekt i maskinen. <br />Fest på et tau. <br />Still deg med ryggen til maskinen og ta tak i tauet.</p>
<p>Gå ned slik at du sitter på knær. Trekk ned vekten samtidig som du går ned i utgangs-stillingen.<br /><br /></p>','exercise_guide' => '<p>Beveg deg fremover slik at du kjenner magemusklene ta tak. <br />Trekk deg så kontrollert tilbake.</p>
<p>Gjenta for ønsket antall repitisjoner.</p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 17:59:36','exercise_updated_datetime' => '2018-03-23 17:59:36','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '68','exercise_title' => 'Flutter Kicks','exercise_title_clean' => 'flutter_kicks','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '22','exercise_muscle_group_id_sub' => '23','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '26','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Legg deg på magen eller ryggen.</p>','exercise_guide' => '<p><span lang="no" xml:lang="no">Hold beina rett og beveg ett bein opp. Senk det så ned igjen.<br />Beveg så det andre beinet opp og senk det så igjen.</span></p>
<p><span lang="no" xml:lang="no">Gjentaa for ønsket antall repitisjoner. </span><span lang="no" xml:lang="no"></span></p>','exercise_important' => '','exercise_created_datetime' => '2018-03-23 18:09:59','exercise_updated_datetime' => '2018-03-23 18:09:59','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL),
  array('exercise_id' => '69','exercise_title' => 'Rygghev','exercise_title_clean' => 'rygghev','exercise_user_id' => '1','exercise_language' => 'no','exercise_muscle_group_id_main' => '5','exercise_muscle_group_id_sub' => '9','exercise_muscle_part_of_id' => '0','exercise_equipment_id' => '29','exercise_type_id' => '2','exercise_level_id' => '1','exercise_preparation' => '<p>Still deg opp i rygghevstativet. <br />Ha eventuelt en vektskive liggende foran deg hvis du ønsker å ha mer motstand i øvelsen.</p>','exercise_guide' => '<p>Gå ned, mens du holder ryggen din rett. <br />Beveg deg så kontrollert opp igjen.<br />Øvelsen skal gi deg kontakt med nedredelen av ryggen din.</p>','exercise_important' => '<ul><li>Ha en rett rygg under øvelsen.</li>
</ul>','exercise_created_datetime' => '2018-03-23 18:25:12','exercise_updated_datetime' => '2018-03-23 18:25:12','exercise_user_ip' => '81.166.225.197','exercise_uniqe_hits' => '0','exercise_uniqe_hits_ip_block' => NULL,'exercise_likes' => '0','exercise_dislikes' => '0','exercise_rating' => '0','exercise_rating_ip_block' => NULL,'exercise_number_of_comments' => '0','exercise_reported' => NULL,'exercise_reported_checked' => NULL,'exercise_reported_reason' => NULL)
);
		
		$datetime = date("Y-m-d H:i:s");
		foreach($stram_exercise_index as $v){
			
			$exercise_title = $v["exercise_title"];
			$exercise_title_clean = $v["exercise_title_clean"];
			$exercise_user_id = $v["exercise_user_id"];
			$exercise_language = $v["exercise_language"];
			$exercise_muscle_group_id_main = $v["exercise_muscle_group_id_main"];
			$exercise_muscle_group_id_sub = $v["exercise_muscle_group_id_sub"];
			$exercise_muscle_part_of_id = $v["exercise_muscle_part_of_id"];
			$exercise_equipment_id = $v["exercise_equipment_id"];
			if($exercise_equipment_id == ""){ $exercise_equipment_id = "0";	}
			$exercise_type_id = $v["exercise_type_id"];
			$exercise_level_id = $v["exercise_level_id"];
			$exercise_preparation = $v["exercise_preparation"];
			$exercise_guide = $v["exercise_guide"];
			$exercise_important = $v["exercise_important"];
		
			mysqli_query($link, "INSERT INTO $t_exercise_index
			(exercise_id, exercise_title, exercise_title_clean, exercise_user_id, exercise_language, exercise_muscle_group_id_main, 
			exercise_muscle_group_id_sub, exercise_muscle_part_of_id, exercise_equipment_id, exercise_type_id, exercise_level_id, exercise_preparation, exercise_guide, exercise_important, exercise_created_datetime, exercise_updated_datetime) 
			VALUES 
			(NULL, '$exercise_title', '$exercise_title_clean', '$exercise_user_id', '$exercise_language', '$exercise_muscle_group_id_main', 
			'$exercise_muscle_group_id_sub', '$exercise_muscle_part_of_id', '$exercise_equipment_id', '$exercise_type_id', '$exercise_level_id',
			'$exercise_preparation', '$exercise_guide', '$exercise_important', '$datetime', '$datetime')
			")
			or die(mysqli_error($link));


		}


	}
	echo"
	<!-- //exercises -->

	<!-- exercise_index_translated -->
	";
	$query = "SELECT * FROM $t_exercise_index_translations_relations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_translations_relations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_translations_relations(
	  	 relation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(relation_id), 
	  	   exercise_original_id INT,
	  	   exercise_target_id INT,
	  	   exercise_language VARCHAR(250),
	  	   exercise_translated INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //exercise_index_translated-->

	<!-- images -->
	";
	$query = "SELECT * FROM $t_exercise_index_images";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_images: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_images(
	  	 exercise_image_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(exercise_image_id), 
	  	   exercise_image_user_id INT,
	  	   exercise_image_exercise_id INT,
	  	   exercise_image_datetime DATETIME,
	  	   exercise_image_user_ip VARCHAR(250),
	  	   exercise_image_type VARCHAR(250),
	  	   exercise_image_path VARCHAR(250),
	  	   exercise_image_file VARCHAR(250),
	  	   exercise_image_thumb_small VARCHAR(250),
	  	   exercise_image_thumb_medium VARCHAR(250),
	  	   exercise_image_thumb_large VARCHAR(250),
	  	   exercise_image_uniqe_hits INT,
	  	   exercise_image_uniqe_hits_ip_block TEXT)")
		   or die(mysqli_error());

$stram_exercise_index_images = array(
  array('exercise_image_id' => '3','exercise_image_user_id' => '1','exercise_image_exercise_id' => '3','exercise_image_datetime' => '2018-02-18 12:53:12','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/biceps_curl_med_ez_stang','exercise_image_file' => 'biceps_curl_med_ez_stang_3_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '4','exercise_image_user_id' => '1','exercise_image_exercise_id' => '3','exercise_image_datetime' => '2018-02-18 12:53:45','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/biceps_curl_med_ez_stang','exercise_image_file' => 'biceps_curl_med_ez_stang_3_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '5','exercise_image_user_id' => '1','exercise_image_exercise_id' => '4','exercise_image_datetime' => '2018-02-18 13:01:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/bicepscurl_med_hantler','exercise_image_file' => 'bicepscurl_med_hantler_4_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '6','exercise_image_user_id' => '1','exercise_image_exercise_id' => '4','exercise_image_datetime' => '2018-02-18 13:01:07','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/bicepscurl_med_hantler','exercise_image_file' => 'bicepscurl_med_hantler_4_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '7','exercise_image_user_id' => '1','exercise_image_exercise_id' => '2','exercise_image_datetime' => '2018-02-18 20:08:11','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength//nedtrekk_tau','exercise_image_file' => 'nedtrekk_tau_2_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '8','exercise_image_user_id' => '1','exercise_image_exercise_id' => '2','exercise_image_datetime' => '2018-02-18 20:08:16','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength//nedtrekk_tau','exercise_image_file' => 'nedtrekk_tau_2_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '9','exercise_image_user_id' => '1','exercise_image_exercise_id' => '5','exercise_image_datetime' => '2018-02-19 16:55:34','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress','exercise_image_file' => 'benkpress_5_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '10','exercise_image_user_id' => '1','exercise_image_exercise_id' => '5','exercise_image_datetime' => '2018-02-19 16:55:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress','exercise_image_file' => 'benkpress_5_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '13','exercise_image_user_id' => '1','exercise_image_exercise_id' => '7','exercise_image_datetime' => '2018-02-21 17:30:55','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/pull_ups','exercise_image_file' => 'pull_ups_7_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '14','exercise_image_user_id' => '1','exercise_image_exercise_id' => '7','exercise_image_datetime' => '2018-02-21 17:31:00','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/pull_ups','exercise_image_file' => 'pull_ups_7_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '15','exercise_image_user_id' => '1','exercise_image_exercise_id' => '8','exercise_image_datetime' => '2018-02-21 17:45:55','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/armhevninger','exercise_image_file' => 'armhevninger_8_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '16','exercise_image_user_id' => '1','exercise_image_exercise_id' => '8','exercise_image_datetime' => '2018-02-21 17:46:01','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/armhevninger','exercise_image_file' => 'armhevninger_8_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '17','exercise_image_user_id' => '1','exercise_image_exercise_id' => '9','exercise_image_datetime' => '2018-03-10 17:19:31','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/supermann','exercise_image_file' => 'supermann_9_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '18','exercise_image_user_id' => '1','exercise_image_exercise_id' => '9','exercise_image_datetime' => '2018-03-10 17:19:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/supermann','exercise_image_file' => 'supermann_9_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '19','exercise_image_user_id' => '1','exercise_image_exercise_id' => '10','exercise_image_datetime' => '2018-03-10 17:33:00','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/skra_hantlepress','exercise_image_file' => 'skra_hantlepress_10_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '20','exercise_image_user_id' => '1','exercise_image_exercise_id' => '10','exercise_image_datetime' => '2018-03-10 17:33:05','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/skra_hantlepress','exercise_image_file' => 'skra_hantlepress_10_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '21','exercise_image_user_id' => '1','exercise_image_exercise_id' => '11','exercise_image_datetime' => '2018-03-10 18:20:30','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/hantlepress','exercise_image_file' => 'hantlepress_11_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '22','exercise_image_user_id' => '1','exercise_image_exercise_id' => '11','exercise_image_datetime' => '2018-03-10 18:20:34','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/hantlepress','exercise_image_file' => 'hantlepress_11_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '23','exercise_image_user_id' => '1','exercise_image_exercise_id' => '12','exercise_image_datetime' => '2018-03-10 18:29:09','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/sholder/skulderpress_med_hantler','exercise_image_file' => 'skulderpress_med_hantler_12_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '24','exercise_image_user_id' => '1','exercise_image_exercise_id' => '12','exercise_image_datetime' => '2018-03-10 18:29:14','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/sholder/skulderpress_med_hantler','exercise_image_file' => 'skulderpress_med_hantler_12_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '25','exercise_image_user_id' => '1','exercise_image_exercise_id' => '13','exercise_image_datetime' => '2018-03-10 18:36:37','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/kabel_flyes_hoye','exercise_image_file' => 'kabel_flyes_hoye_13_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '26','exercise_image_user_id' => '1','exercise_image_exercise_id' => '13','exercise_image_datetime' => '2018-03-10 18:36:43','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/kabel_flyes_hoye','exercise_image_file' => 'kabel_flyes_hoye_13_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '27','exercise_image_user_id' => '1','exercise_image_exercise_id' => '14','exercise_image_datetime' => '2018-03-10 18:44:32','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/kneboy_med_stang','exercise_image_file' => 'kneboy_med_stang_14_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '28','exercise_image_user_id' => '1','exercise_image_exercise_id' => '14','exercise_image_datetime' => '2018-03-10 18:44:38','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/kneboy_med_stang','exercise_image_file' => 'kneboy_med_stang_14_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '29','exercise_image_user_id' => '1','exercise_image_exercise_id' => '15','exercise_image_datetime' => '2018-03-10 21:44:57','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/markloft_med_hantler','exercise_image_file' => 'markloft_med_hantler_15_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '30','exercise_image_user_id' => '1','exercise_image_exercise_id' => '15','exercise_image_datetime' => '2018-03-10 21:45:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/markloft_med_hantler','exercise_image_file' => 'markloft_med_hantler_15_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '31','exercise_image_user_id' => '1','exercise_image_exercise_id' => '16','exercise_image_datetime' => '2018-03-10 21:51:22','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/sholder/fronthev','exercise_image_file' => 'fronthev_16_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '32','exercise_image_user_id' => '1','exercise_image_exercise_id' => '16','exercise_image_datetime' => '2018-03-10 21:51:27','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/sholder/fronthev','exercise_image_file' => 'fronthev_16_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '33','exercise_image_user_id' => '1','exercise_image_exercise_id' => '17','exercise_image_datetime' => '2018-03-10 23:01:26','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/intervaller_400_m_x_12__1_min_pause','exercise_image_file' => 'intervaller_400_m_x_12__1_min_pause_17_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '34','exercise_image_user_id' => '1','exercise_image_exercise_id' => '18','exercise_image_datetime' => '2018-03-10 23:12:55','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/lett_joggetur','exercise_image_file' => 'lett_joggetur_18_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '35','exercise_image_user_id' => '1','exercise_image_exercise_id' => '19','exercise_image_datetime' => '2018-03-11 09:03:18','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/intervaller_800_m_x_6__2_min_pause','exercise_image_file' => 'intervaller_800_m_x_6__2_min_pause_19_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '36','exercise_image_user_id' => '1','exercise_image_exercise_id' => '20','exercise_image_datetime' => '2018-03-11 09:08:18','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/intervaller_1_6_km_x_3__3_min_pause','exercise_image_file' => 'intervaller_1_6_km_x_3__3_min_pause_20_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '37','exercise_image_user_id' => '1','exercise_image_exercise_id' => '21','exercise_image_datetime' => '2018-03-11 09:12:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/tempo_joggetur','exercise_image_file' => 'tempo_joggetur_21_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '38','exercise_image_user_id' => '1','exercise_image_exercise_id' => '22','exercise_image_datetime' => '2018-03-11 09:30:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/cardio/rompe__lar_og_legger/langkjoring_joggetur','exercise_image_file' => 'langkjoring_joggetur_22_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '39','exercise_image_user_id' => '1','exercise_image_exercise_id' => '23','exercise_image_datetime' => '2018-03-12 16:52:43','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/hammercurl_med_hantler','exercise_image_file' => 'hammercurl_med_hantler_23_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '40','exercise_image_user_id' => '1','exercise_image_exercise_id' => '23','exercise_image_datetime' => '2018-03-12 16:52:49','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/hammercurl_med_hantler','exercise_image_file' => 'hammercurl_med_hantler_23_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '41','exercise_image_user_id' => '1','exercise_image_exercise_id' => '24','exercise_image_datetime' => '2018-03-17 22:19:35','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/markloft_med_stang','exercise_image_file' => 'markloft_med_stang_24_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '42','exercise_image_user_id' => '1','exercise_image_exercise_id' => '24','exercise_image_datetime' => '2018-03-17 22:19:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/markloft_med_stang','exercise_image_file' => 'markloft_med_stang_24_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '43','exercise_image_user_id' => '1','exercise_image_exercise_id' => '25','exercise_image_datetime' => '2018-03-18 08:26:35','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/utfall_med_stang','exercise_image_file' => 'utfall_med_stang_25_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '44','exercise_image_user_id' => '1','exercise_image_exercise_id' => '25','exercise_image_datetime' => '2018-03-18 08:26:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/utfall_med_stang','exercise_image_file' => 'utfall_med_stang_25_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '45','exercise_image_user_id' => '1','exercise_image_exercise_id' => '26','exercise_image_datetime' => '2018-03-18 08:50:23','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/omvendt_roing_i_smithmaskin','exercise_image_file' => 'omvendt_roing_i_smithmaskin_26_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '46','exercise_image_user_id' => '1','exercise_image_exercise_id' => '26','exercise_image_datetime' => '2018-03-18 08:50:27','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/omvendt_roing_i_smithmaskin','exercise_image_file' => 'omvendt_roing_i_smithmaskin_26_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '47','exercise_image_user_id' => '1','exercise_image_exercise_id' => '27','exercise_image_datetime' => '2018-03-18 09:04:23','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/dips','exercise_image_file' => 'dips_27_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '48','exercise_image_user_id' => '1','exercise_image_exercise_id' => '27','exercise_image_datetime' => '2018-03-18 09:04:28','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/dips','exercise_image_file' => 'dips_27_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '49','exercise_image_user_id' => '1','exercise_image_exercise_id' => '28','exercise_image_datetime' => '2018-03-18 09:13:57','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/kabel_flyes_lave','exercise_image_file' => 'kabel_flyes_lave_28_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '50','exercise_image_user_id' => '1','exercise_image_exercise_id' => '28','exercise_image_datetime' => '2018-03-18 09:14:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/kabel_flyes_lave','exercise_image_file' => 'kabel_flyes_lave_28_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '51','exercise_image_user_id' => '1','exercise_image_exercise_id' => '29','exercise_image_datetime' => '2018-03-18 09:30:08','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/crunches','exercise_image_file' => 'crunches_29_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '52','exercise_image_user_id' => '1','exercise_image_exercise_id' => '29','exercise_image_datetime' => '2018-03-18 09:30:13','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/crunches','exercise_image_file' => 'crunches_29_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '53','exercise_image_user_id' => '1','exercise_image_exercise_id' => '30','exercise_image_datetime' => '2018-03-18 09:43:31','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/omvendt_skra_hantlepress','exercise_image_file' => 'omvendt_skra_hantlepress_30_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '54','exercise_image_user_id' => '1','exercise_image_exercise_id' => '30','exercise_image_datetime' => '2018-03-18 09:43:36','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/omvendt_skra_hantlepress','exercise_image_file' => 'omvendt_skra_hantlepress_30_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '55','exercise_image_user_id' => '1','exercise_image_exercise_id' => '31','exercise_image_datetime' => '2018-03-18 15:06:19','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/liggende_tricepspress','exercise_image_file' => 'liggende_tricepspress_31_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '56','exercise_image_user_id' => '1','exercise_image_exercise_id' => '31','exercise_image_datetime' => '2018-03-18 15:06:23','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/liggende_tricepspress','exercise_image_file' => 'liggende_tricepspress_31_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '57','exercise_image_user_id' => '1','exercise_image_exercise_id' => '32','exercise_image_datetime' => '2018-03-18 15:58:17','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/flyes_med_hantler','exercise_image_file' => 'flyes_med_hantler_32_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '58','exercise_image_user_id' => '1','exercise_image_exercise_id' => '32','exercise_image_datetime' => '2018-03-18 15:58:21','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/flyes_med_hantler','exercise_image_file' => 'flyes_med_hantler_32_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '59','exercise_image_user_id' => '1','exercise_image_exercise_id' => '33','exercise_image_datetime' => '2018-03-18 16:08:45','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/utfall_med_hantler','exercise_image_file' => 'utfall_med_hantler_33_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '60','exercise_image_user_id' => '1','exercise_image_exercise_id' => '33','exercise_image_datetime' => '2018-03-18 16:08:49','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/utfall_med_hantler','exercise_image_file' => 'utfall_med_hantler_33_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '61','exercise_image_user_id' => '1','exercise_image_exercise_id' => '34','exercise_image_datetime' => '2018-03-18 16:16:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/sholder/sidehev','exercise_image_file' => 'sidehev_34_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '62','exercise_image_user_id' => '1','exercise_image_exercise_id' => '34','exercise_image_datetime' => '2018-03-18 16:16:44','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/sholder/sidehev','exercise_image_file' => 'sidehev_34_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '63','exercise_image_user_id' => '1','exercise_image_exercise_id' => '35','exercise_image_datetime' => '2018-03-19 21:49:50','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/benspark_leg_extension','exercise_image_file' => 'benspark_leg_extension_35_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '64','exercise_image_user_id' => '1','exercise_image_exercise_id' => '35','exercise_image_datetime' => '2018-03-19 21:49:58','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/benspark_leg_extension','exercise_image_file' => 'benspark_leg_extension_35_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '65','exercise_image_user_id' => '1','exercise_image_exercise_id' => '36','exercise_image_datetime' => '2018-03-20 16:36:49','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/beinpress_leg_press','exercise_image_file' => 'beinpress_leg_press_36_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '66','exercise_image_user_id' => '1','exercise_image_exercise_id' => '36','exercise_image_datetime' => '2018-03-20 16:36:55','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/beinpress_leg_press','exercise_image_file' => 'beinpress_leg_press_36_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '67','exercise_image_user_id' => '1','exercise_image_exercise_id' => '37','exercise_image_datetime' => '2018-03-20 16:47:54','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/franskpress','exercise_image_file' => 'franskpress_37_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '68','exercise_image_user_id' => '1','exercise_image_exercise_id' => '37','exercise_image_datetime' => '2018-03-20 16:47:58','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/franskpress','exercise_image_file' => 'franskpress_37_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '69','exercise_image_user_id' => '1','exercise_image_exercise_id' => '38','exercise_image_datetime' => '2018-03-20 16:54:30','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/larcurl_leg_curl','exercise_image_file' => 'larcurl_leg_curl_38_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '70','exercise_image_user_id' => '1','exercise_image_exercise_id' => '38','exercise_image_datetime' => '2018-03-20 16:54:35','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/larcurl_leg_curl','exercise_image_file' => 'larcurl_leg_curl_38_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '71','exercise_image_user_id' => '1','exercise_image_exercise_id' => '39','exercise_image_datetime' => '2018-03-20 17:03:09','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress_i_maskin','exercise_image_file' => 'benkpress_i_maskin_39_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '72','exercise_image_user_id' => '1','exercise_image_exercise_id' => '39','exercise_image_datetime' => '2018-03-20 17:03:14','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress_i_maskin','exercise_image_file' => 'benkpress_i_maskin_39_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '73','exercise_image_user_id' => '1','exercise_image_exercise_id' => '40','exercise_image_datetime' => '2018-03-20 17:35:55','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/en_arms_bicepscurl_med_hantel','exercise_image_file' => 'en_arms_bicepscurl_med_hantel_40_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '74','exercise_image_user_id' => '1','exercise_image_exercise_id' => '40','exercise_image_datetime' => '2018-03-20 17:36:00','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/en_arms_bicepscurl_med_hantel','exercise_image_file' => 'en_arms_bicepscurl_med_hantel_40_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '75','exercise_image_user_id' => '1','exercise_image_exercise_id' => '41','exercise_image_datetime' => '2018-03-20 17:47:19','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/en_arms_tricepspress_med_hantel','exercise_image_file' => 'en_arms_tricepspress_med_hantel_41_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '76','exercise_image_user_id' => '1','exercise_image_exercise_id' => '41','exercise_image_datetime' => '2018-03-20 17:47:23','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/en_arms_tricepspress_med_hantel','exercise_image_file' => 'en_arms_tricepspress_med_hantel_41_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '77','exercise_image_user_id' => '1','exercise_image_exercise_id' => '1','exercise_image_datetime' => '2018-03-20 18:04:21','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/bulgarsk_utfall','exercise_image_file' => 'bulgarsk_utfall_1_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '78','exercise_image_user_id' => '1','exercise_image_exercise_id' => '1','exercise_image_datetime' => '2018-03-20 18:04:25','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/bulgarsk_utfall','exercise_image_file' => 'bulgarsk_utfall_1_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '79','exercise_image_user_id' => '1','exercise_image_exercise_id' => '42','exercise_image_datetime' => '2018-03-20 18:14:19','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/goblet_squats','exercise_image_file' => 'goblet_squats_42_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '80','exercise_image_user_id' => '1','exercise_image_exercise_id' => '42','exercise_image_datetime' => '2018-03-20 18:14:24','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/goblet_squats','exercise_image_file' => 'goblet_squats_42_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '81','exercise_image_user_id' => '1','exercise_image_exercise_id' => '43','exercise_image_datetime' => '2018-03-20 18:22:59','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/biceps_curl_med_ez_stang_over_benk','exercise_image_file' => 'biceps_curl_med_ez_stang_over_benk_43_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '82','exercise_image_user_id' => '1','exercise_image_exercise_id' => '43','exercise_image_datetime' => '2018-03-20 18:23:04','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/biceps_curl_med_ez_stang_over_benk','exercise_image_file' => 'biceps_curl_med_ez_stang_over_benk_43_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '83','exercise_image_user_id' => '1','exercise_image_exercise_id' => '44','exercise_image_datetime' => '2018-03-20 18:28:50','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/staende_roing_med_stang','exercise_image_file' => 'staende_roing_med_stang_44_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '84','exercise_image_user_id' => '1','exercise_image_exercise_id' => '44','exercise_image_datetime' => '2018-03-20 18:28:56','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/staende_roing_med_stang','exercise_image_file' => 'staende_roing_med_stang_44_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '85','exercise_image_user_id' => '1','exercise_image_exercise_id' => '45','exercise_image_datetime' => '2018-03-20 21:29:23','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/en_arms_roing_med_hantler','exercise_image_file' => 'en_arms_roing_med_hantler_45_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '86','exercise_image_user_id' => '1','exercise_image_exercise_id' => '45','exercise_image_datetime' => '2018-03-20 21:29:28','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/en_arms_roing_med_hantler','exercise_image_file' => 'en_arms_roing_med_hantler_45_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '87','exercise_image_user_id' => '1','exercise_image_exercise_id' => '46','exercise_image_datetime' => '2018-03-20 21:40:44','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sittende_ab_crunches_i_kabel','exercise_image_file' => 'sittende_ab_crunches_i_kabel_46_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '88','exercise_image_user_id' => '1','exercise_image_exercise_id' => '46','exercise_image_datetime' => '2018-03-20 21:40:52','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sittende_ab_crunches_i_kabel','exercise_image_file' => 'sittende_ab_crunches_i_kabel_46_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '89','exercise_image_user_id' => '1','exercise_image_exercise_id' => '47','exercise_image_datetime' => '2018-03-21 17:08:15','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/roing','exercise_image_file' => 'roing_47_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '90','exercise_image_user_id' => '1','exercise_image_exercise_id' => '47','exercise_image_datetime' => '2018-03-21 17:08:21','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/roing','exercise_image_file' => 'roing_47_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '91','exercise_image_user_id' => '1','exercise_image_exercise_id' => '48','exercise_image_datetime' => '2018-03-21 17:20:13','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/sittende_leggcurl','exercise_image_file' => 'sittende_leggcurl_48_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '92','exercise_image_user_id' => '1','exercise_image_exercise_id' => '48','exercise_image_datetime' => '2018-03-21 17:20:18','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/rompe__lar_og_legger/sittende_leggcurl','exercise_image_file' => 'sittende_leggcurl_48_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '93','exercise_image_user_id' => '1','exercise_image_exercise_id' => '49','exercise_image_datetime' => '2018-03-21 17:28:07','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/sholder/shrugs','exercise_image_file' => 'shrugs_49_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '94','exercise_image_user_id' => '1','exercise_image_exercise_id' => '49','exercise_image_datetime' => '2018-03-21 17:28:12','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/sholder/shrugs','exercise_image_file' => 'shrugs_49_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '95','exercise_image_user_id' => '1','exercise_image_exercise_id' => '50','exercise_image_datetime' => '2018-03-21 17:41:37','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sideboy_med_hantel','exercise_image_file' => 'sideboy_med_hantel_50_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '96','exercise_image_user_id' => '1','exercise_image_exercise_id' => '50','exercise_image_datetime' => '2018-03-21 17:41:41','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sideboy_med_hantel','exercise_image_file' => 'sideboy_med_hantel_50_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '97','exercise_image_user_id' => '1','exercise_image_exercise_id' => '51','exercise_image_datetime' => '2018-03-21 17:50:01','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sideplanke','exercise_image_file' => 'sideplanke_51_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '98','exercise_image_user_id' => '1','exercise_image_exercise_id' => '51','exercise_image_datetime' => '2018-03-21 17:50:06','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sideplanke','exercise_image_file' => 'sideplanke_51_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '99','exercise_image_user_id' => '1','exercise_image_exercise_id' => '52','exercise_image_datetime' => '2018-03-21 18:10:13','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress_i_smithmaskin','exercise_image_file' => 'benkpress_i_smithmaskin_52_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '100','exercise_image_user_id' => '1','exercise_image_exercise_id' => '52','exercise_image_datetime' => '2018-03-21 18:10:18','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/chest/benkpress_i_smithmaskin','exercise_image_file' => 'benkpress_i_smithmaskin_52_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '101','exercise_image_user_id' => '1','exercise_image_exercise_id' => '53','exercise_image_datetime' => '2018-03-21 18:16:29','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/other//staende_bicepscurl_med_stang_i_kabel','exercise_image_file' => 'staende_bicepscurl_med_stang_i_kabel_53_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '102','exercise_image_user_id' => '1','exercise_image_exercise_id' => '53','exercise_image_datetime' => '2018-03-21 18:16:34','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/other//staende_bicepscurl_med_stang_i_kabel','exercise_image_file' => 'staende_bicepscurl_med_stang_i_kabel_53_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '103','exercise_image_user_id' => '1','exercise_image_exercise_id' => '54','exercise_image_datetime' => '2018-03-21 18:24:40','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/staende_pushdown_med_boyd_stang','exercise_image_file' => 'staende_pushdown_med_boyd_stang_54_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '104','exercise_image_user_id' => '1','exercise_image_exercise_id' => '54','exercise_image_datetime' => '2018-03-21 18:24:46','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/staende_pushdown_med_boyd_stang','exercise_image_file' => 'staende_pushdown_med_boyd_stang_54_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '105','exercise_image_user_id' => '1','exercise_image_exercise_id' => '55','exercise_image_datetime' => '2018-03-21 18:36:57','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/arms/triceps_nedtrekk_stang_i_kabel','exercise_image_file' => 'triceps_nedtrekk_stang_i_kabel_55_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '106','exercise_image_user_id' => '1','exercise_image_exercise_id' => '55','exercise_image_datetime' => '2018-03-21 18:37:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/arms/triceps_nedtrekk_stang_i_kabel','exercise_image_file' => 'triceps_nedtrekk_stang_i_kabel_55_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '107','exercise_image_user_id' => '1','exercise_image_exercise_id' => '56','exercise_image_datetime' => '2018-03-21 18:47:14','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/nedtrekk_bredt_grep','exercise_image_file' => 'nedtrekk_bredt_grep_56_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '108','exercise_image_user_id' => '1','exercise_image_exercise_id' => '56','exercise_image_datetime' => '2018-03-21 18:47:20','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/nedtrekk_bredt_grep','exercise_image_file' => 'nedtrekk_bredt_grep_56_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '109','exercise_image_user_id' => '1','exercise_image_exercise_id' => '57','exercise_image_datetime' => '2018-03-21 18:58:45','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength//nedtrekk_v-bar','exercise_image_file' => 'nedtrekk_v-bar_57_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '110','exercise_image_user_id' => '1','exercise_image_exercise_id' => '57','exercise_image_datetime' => '2018-03-21 18:58:48','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength//nedtrekk_v-bar','exercise_image_file' => 'nedtrekk_v-bar_57_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '111','exercise_image_user_id' => '1','exercise_image_exercise_id' => '58','exercise_image_datetime' => '2018-03-23 16:30:17','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/liggende_beinhev','exercise_image_file' => 'liggende_beinhev_58_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '112','exercise_image_user_id' => '1','exercise_image_exercise_id' => '58','exercise_image_datetime' => '2018-03-23 16:30:21','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/liggende_beinhev','exercise_image_file' => 'liggende_beinhev_58_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '113','exercise_image_user_id' => '1','exercise_image_exercise_id' => '59','exercise_image_datetime' => '2018-03-23 16:34:13','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/liggende_vekslende_beinhev','exercise_image_file' => 'liggende_vekslende_beinhev_59_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '114','exercise_image_user_id' => '1','exercise_image_exercise_id' => '59','exercise_image_datetime' => '2018-03-23 16:34:17','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/liggende_vekslende_beinhev','exercise_image_file' => 'liggende_vekslende_beinhev_59_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '115','exercise_image_user_id' => '1','exercise_image_exercise_id' => '60','exercise_image_datetime' => '2018-03-23 16:42:11','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/beintrekk','exercise_image_file' => 'beintrekk_60_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '116','exercise_image_user_id' => '1','exercise_image_exercise_id' => '60','exercise_image_datetime' => '2018-03-23 16:42:16','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/beintrekk','exercise_image_file' => 'beintrekk_60_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '117','exercise_image_user_id' => '1','exercise_image_exercise_id' => '61','exercise_image_datetime' => '2018-03-23 16:50:57','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sittende_twists','exercise_image_file' => 'sittende_twists_61_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '118','exercise_image_user_id' => '1','exercise_image_exercise_id' => '61','exercise_image_datetime' => '2018-03-23 16:51:03','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sittende_twists','exercise_image_file' => 'sittende_twists_61_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '119','exercise_image_user_id' => '1','exercise_image_exercise_id' => '62','exercise_image_datetime' => '2018-03-23 16:56:58','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sit-ups','exercise_image_file' => 'sit-ups_62_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '120','exercise_image_user_id' => '1','exercise_image_exercise_id' => '62','exercise_image_datetime' => '2018-03-23 16:57:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/sit-ups','exercise_image_file' => 'sit-ups_62_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '121','exercise_image_user_id' => '1','exercise_image_exercise_id' => '63','exercise_image_datetime' => '2018-03-23 17:02:58','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/hengende_beinhev','exercise_image_file' => 'hengende_beinhev_63_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '122','exercise_image_user_id' => '1','exercise_image_exercise_id' => '63','exercise_image_datetime' => '2018-03-23 17:03:02','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/hengende_beinhev','exercise_image_file' => 'hengende_beinhev_63_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '123','exercise_image_user_id' => '1','exercise_image_exercise_id' => '64','exercise_image_datetime' => '2018-03-23 17:19:44','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/sholder/cross-body_crunch','exercise_image_file' => 'cross-body_crunch_64_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '124','exercise_image_user_id' => '1','exercise_image_exercise_id' => '64','exercise_image_datetime' => '2018-03-23 17:19:50','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/sholder/cross-body_crunch','exercise_image_file' => 'cross-body_crunch_64_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '125','exercise_image_user_id' => '1','exercise_image_exercise_id' => '65','exercise_image_datetime' => '2018-03-23 17:34:04','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/omvendt_skra_crunches','exercise_image_file' => 'omvendt_skra_crunches_65_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '126','exercise_image_user_id' => '1','exercise_image_exercise_id' => '65','exercise_image_datetime' => '2018-03-23 17:34:09','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/omvendt_skra_crunches','exercise_image_file' => 'omvendt_skra_crunches_65_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '127','exercise_image_user_id' => '1','exercise_image_exercise_id' => '66','exercise_image_datetime' => '2018-03-23 17:42:38','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/rollout_med_hjul','exercise_image_file' => 'rollout_med_hjul_66_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '128','exercise_image_user_id' => '1','exercise_image_exercise_id' => '66','exercise_image_datetime' => '2018-03-23 17:42:44','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/rollout_med_hjul','exercise_image_file' => 'rollout_med_hjul_66_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '129','exercise_image_user_id' => '1','exercise_image_exercise_id' => '67','exercise_image_datetime' => '2018-03-23 18:06:41','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/ab_crunches_i_kabel','exercise_image_file' => 'ab_crunches_i_kabel_67_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '130','exercise_image_user_id' => '1','exercise_image_exercise_id' => '67','exercise_image_datetime' => '2018-03-23 18:06:47','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/ab_crunches_i_kabel','exercise_image_file' => 'ab_crunches_i_kabel_67_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '131','exercise_image_user_id' => '1','exercise_image_exercise_id' => '68','exercise_image_datetime' => '2018-03-23 18:12:48','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/stomach/flutter_kicks','exercise_image_file' => 'flutter_kicks_68_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '132','exercise_image_user_id' => '1','exercise_image_exercise_id' => '68','exercise_image_datetime' => '2018-03-23 18:12:52','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/stomach/flutter_kicks','exercise_image_file' => 'flutter_kicks_68_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '133','exercise_image_user_id' => '1','exercise_image_exercise_id' => '69','exercise_image_datetime' => '2018-03-23 18:29:22','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_1','exercise_image_path' => '_uploads/exercises/no/strength/back/rygghev','exercise_image_file' => 'rygghev_69_guide_1.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => ''),
  array('exercise_image_id' => '134','exercise_image_user_id' => '1','exercise_image_exercise_id' => '69','exercise_image_datetime' => '2018-03-23 18:29:27','exercise_image_user_ip' => '81.166.225.197','exercise_image_type' => 'guide_2','exercise_image_path' => '_uploads/exercises/no/strength/back/rygghev','exercise_image_file' => 'rygghev_69_guide_2.png','exercise_image_uniqe_hits' => '0','exercise_image_uniqe_hits_ip_block' => '')
);


		foreach($stram_exercise_index_images as $v){
			
			$exercise_image_user_id = $v["exercise_image_user_id"];
			$exercise_image_exercise_id = $v["exercise_image_exercise_id"];
			$exercise_image_datetime = $v["exercise_image_datetime"];
			$exercise_image_type = $v["exercise_image_type"];
			$exercise_image_path = $v["exercise_image_path"];
			$exercise_image_file = $v["exercise_image_file"];
		
			mysqli_query($link, "INSERT INTO $t_exercise_index_images
			(exercise_image_id, exercise_image_user_id, exercise_image_exercise_id, exercise_image_datetime, exercise_image_type, exercise_image_path, exercise_image_file) 
			VALUES 
			(NULL, '$exercise_image_user_id', '$exercise_image_exercise_id', '$exercise_image_datetime', '$exercise_image_type', '$exercise_image_path', 
			'$exercise_image_file')
			")
			or die(mysqli_error($link));


		}



	}
	echo"
	<!-- //images -->

	<!-- videos -->
	";
	$query = "SELECT * FROM $t_exercise_index_videos";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_videos: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_videos(
	  	 exercise_video_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(exercise_video_id), 
	  	   exercise_video_user_id INT,
	  	   exercise_video_exercise_id INT,
	  	   exercise_video_datetime DATETIME,
	  	   exercise_video_user_ip VARCHAR(250),
	  	   exercise_video_service_name VARCHAR(250),
	  	   exercise_video_service_id VARCHAR(250),
	  	   exercise_video_path VARCHAR(250),
	  	   exercise_video_file VARCHAR(250),
	  	   exercise_video_uniqe_hits INT,
	  	   exercise_video_uniqe_hits_ip_block TEXT)")
		   or die(mysqli_error());

$stram_exercise_index_videos = array(
  array('exercise_video_id' => '1','exercise_video_user_id' => '1','exercise_video_exercise_id' => '3','exercise_video_datetime' => '2018-02-18 12:52:09','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'kwG2ipFRgfo','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '2','exercise_video_user_id' => '1','exercise_video_exercise_id' => '4','exercise_video_datetime' => '2018-02-18 13:01:32','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'sAq_ocpRh_I','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '3','exercise_video_user_id' => '1','exercise_video_exercise_id' => '2','exercise_video_datetime' => '2018-02-18 20:09:09','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'vB5OHsJ3EME','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '4','exercise_video_user_id' => '1','exercise_video_exercise_id' => '5','exercise_video_datetime' => '2018-02-19 16:56:14','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '80369ZMnriU','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '6','exercise_video_user_id' => '1','exercise_video_exercise_id' => '7','exercise_video_datetime' => '2018-02-21 17:31:59','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'iBJls--mXAo','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '7','exercise_video_user_id' => '1','exercise_video_exercise_id' => '8','exercise_video_datetime' => '2018-02-21 17:46:18','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'EXj_Hq86ZGk','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '8','exercise_video_user_id' => '1','exercise_video_exercise_id' => '9','exercise_video_datetime' => '2018-03-10 17:20:03','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'cc6UVRS7PW4','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '9','exercise_video_user_id' => '1','exercise_video_exercise_id' => '10','exercise_video_datetime' => '2018-03-10 17:33:33','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'xhuzFDvo0Ik','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '10','exercise_video_user_id' => '1','exercise_video_exercise_id' => '11','exercise_video_datetime' => '2018-03-10 18:21:38','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'ep3scfNxL3A','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '11','exercise_video_user_id' => '1','exercise_video_exercise_id' => '12','exercise_video_datetime' => '2018-03-10 18:29:43','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '9G8aDAi24dA','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '12','exercise_video_user_id' => '1','exercise_video_exercise_id' => '13','exercise_video_datetime' => '2018-03-10 18:37:05','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'Iwe6AmxVf7o','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '13','exercise_video_user_id' => '1','exercise_video_exercise_id' => '14','exercise_video_datetime' => '2018-03-10 18:44:53','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'sLx7FNZzLeQ','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '14','exercise_video_user_id' => '1','exercise_video_exercise_id' => '15','exercise_video_datetime' => '2018-03-10 21:45:21','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'kRrftR4M0Hc','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '15','exercise_video_user_id' => '1','exercise_video_exercise_id' => '16','exercise_video_datetime' => '2018-03-10 21:51:44','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'sGVJbZd1dTM','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '16','exercise_video_user_id' => '1','exercise_video_exercise_id' => '17','exercise_video_datetime' => '2018-03-10 23:02:33','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'fMDRhzeYU1s','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '17','exercise_video_user_id' => '1','exercise_video_exercise_id' => '18','exercise_video_datetime' => '2018-03-10 23:13:16','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'veAQ73OJdwY','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '18','exercise_video_user_id' => '1','exercise_video_exercise_id' => '19','exercise_video_datetime' => '2018-03-11 09:04:02','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'fQS4YYb5TBg','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '19','exercise_video_user_id' => '1','exercise_video_exercise_id' => '20','exercise_video_datetime' => '2018-03-11 09:08:27','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'qwDUGD-NURc','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '20','exercise_video_user_id' => '1','exercise_video_exercise_id' => '21','exercise_video_datetime' => '2018-03-11 09:12:44','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'WamrGG-yQQc','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '21','exercise_video_user_id' => '1','exercise_video_exercise_id' => '22','exercise_video_datetime' => '2018-03-11 09:30:41','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'L5Kfveu51lc','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '22','exercise_video_user_id' => '1','exercise_video_exercise_id' => '23','exercise_video_datetime' => '2018-03-12 16:53:11','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'zC3nLlEvin4','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '23','exercise_video_user_id' => '1','exercise_video_exercise_id' => '24','exercise_video_datetime' => '2018-03-17 22:19:57','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'WizLaNKKKuE','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '24','exercise_video_user_id' => '1','exercise_video_exercise_id' => '25','exercise_video_datetime' => '2018-03-18 08:27:18','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'wQ1aFhHE0SE','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '25','exercise_video_user_id' => '1','exercise_video_exercise_id' => '26','exercise_video_datetime' => '2018-03-18 08:49:22','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'p8B0ecwM0gA','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '26','exercise_video_user_id' => '1','exercise_video_exercise_id' => '27','exercise_video_datetime' => '2018-03-18 09:04:48','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'sM6XUdt1rm4','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '27','exercise_video_user_id' => '1','exercise_video_exercise_id' => '28','exercise_video_datetime' => '2018-03-18 09:14:21','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'M1N804yWA-8','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '28','exercise_video_user_id' => '1','exercise_video_exercise_id' => '29','exercise_video_datetime' => '2018-03-18 09:30:33','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '1V4RXxLHNCY','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '29','exercise_video_user_id' => '1','exercise_video_exercise_id' => '30','exercise_video_datetime' => '2018-03-18 09:44:16','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '0xRvl4Qv3ZY','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '30','exercise_video_user_id' => '1','exercise_video_exercise_id' => '31','exercise_video_datetime' => '2018-03-18 15:06:52','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'GZpJ-GFU6-4','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '31','exercise_video_user_id' => '1','exercise_video_exercise_id' => '32','exercise_video_datetime' => '2018-03-18 15:58:32','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'eozdVDA78K0','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '32','exercise_video_user_id' => '1','exercise_video_exercise_id' => '33','exercise_video_datetime' => '2018-03-18 16:09:12','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'UoCYXLtYTqo','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '33','exercise_video_user_id' => '1','exercise_video_exercise_id' => '34','exercise_video_datetime' => '2018-03-18 16:17:00','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'I_9YzXFWfBs','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '34','exercise_video_user_id' => '1','exercise_video_exercise_id' => '35','exercise_video_datetime' => '2018-03-19 21:50:24','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'YyvSfVjQeL0','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '35','exercise_video_user_id' => '1','exercise_video_exercise_id' => '36','exercise_video_datetime' => '2018-03-20 16:37:01','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'Aq5uxXrXq7c','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '36','exercise_video_user_id' => '1','exercise_video_exercise_id' => '37','exercise_video_datetime' => '2018-03-20 16:48:30','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'd_KZxkY_0cM','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '37','exercise_video_user_id' => '1','exercise_video_exercise_id' => '38','exercise_video_datetime' => '2018-03-20 16:54:40','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 't2KWJeCGzc4','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '38','exercise_video_user_id' => '1','exercise_video_exercise_id' => '39','exercise_video_datetime' => '2018-03-20 17:03:22','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '-BG2-KADomM','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '39','exercise_video_user_id' => '1','exercise_video_exercise_id' => '40','exercise_video_datetime' => '2018-03-20 17:36:19','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '-4Z-KqH_mrw','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '40','exercise_video_user_id' => '1','exercise_video_exercise_id' => '41','exercise_video_datetime' => '2018-03-20 17:47:44','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'YbX7Wd8jQ-Q','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '41','exercise_video_user_id' => '1','exercise_video_exercise_id' => '42','exercise_video_datetime' => '2018-03-20 18:14:36','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'O4UiWEHB92U','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '42','exercise_video_user_id' => '1','exercise_video_exercise_id' => '43','exercise_video_datetime' => '2018-03-20 18:24:05','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'T2TFp7i6LGQ','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '43','exercise_video_user_id' => '1','exercise_video_exercise_id' => '44','exercise_video_datetime' => '2018-03-20 18:28:59','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'GY_Lghy-SSE','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '44','exercise_video_user_id' => '1','exercise_video_exercise_id' => '45','exercise_video_datetime' => '2018-03-20 21:29:48','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'qBKeaL9LAHk','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '45','exercise_video_user_id' => '1','exercise_video_exercise_id' => '46','exercise_video_datetime' => '2018-03-20 21:41:32','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'AV5PmZJIrrw','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '46','exercise_video_user_id' => '1','exercise_video_exercise_id' => '47','exercise_video_datetime' => '2018-03-21 17:08:45','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '9A5rFtR22mg','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '47','exercise_video_user_id' => '1','exercise_video_exercise_id' => '48','exercise_video_datetime' => '2018-03-21 17:20:35','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'ELOCsoDSmrg','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '48','exercise_video_user_id' => '1','exercise_video_exercise_id' => '49','exercise_video_datetime' => '2018-03-21 17:28:18','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'cJRVVxmytaM','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '49','exercise_video_user_id' => '1','exercise_video_exercise_id' => '50','exercise_video_datetime' => '2018-03-21 17:41:48','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'dL9ZzqtQI5c','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '50','exercise_video_user_id' => '1','exercise_video_exercise_id' => '51','exercise_video_datetime' => '2018-03-21 17:50:22','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'NXr4Fw8q60o','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '51','exercise_video_user_id' => '1','exercise_video_exercise_id' => '52','exercise_video_datetime' => '2018-03-21 18:10:28','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'bqmo9MrWeiI','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '52','exercise_video_user_id' => '1','exercise_video_exercise_id' => '53','exercise_video_datetime' => '2018-03-21 18:16:07','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'kyyP5l8noSY','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '53','exercise_video_user_id' => '1','exercise_video_exercise_id' => '54','exercise_video_datetime' => '2018-03-21 18:24:52','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'AjCCGN2tU3Q','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '54','exercise_video_user_id' => '1','exercise_video_exercise_id' => '55','exercise_video_datetime' => '2018-03-21 18:37:33','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'mRmIthbCSNI','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '55','exercise_video_user_id' => '1','exercise_video_exercise_id' => '56','exercise_video_datetime' => '2018-03-21 18:48:25','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'TJ9wo24eB3c','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '56','exercise_video_user_id' => '1','exercise_video_exercise_id' => '57','exercise_video_datetime' => '2018-03-21 18:59:32','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'EjIETxOawcg','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '57','exercise_video_user_id' => '1','exercise_video_exercise_id' => '58','exercise_video_datetime' => '2018-03-23 16:30:28','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'JB2oyawG9KI','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '58','exercise_video_user_id' => '1','exercise_video_exercise_id' => '59','exercise_video_datetime' => '2018-03-23 16:34:21','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'LhbEEzpO9sU','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '59','exercise_video_user_id' => '1','exercise_video_exercise_id' => '60','exercise_video_datetime' => '2018-03-23 16:42:19','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'GPBVNHl5cS8','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '60','exercise_video_user_id' => '1','exercise_video_exercise_id' => '61','exercise_video_datetime' => '2018-03-23 16:51:17','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'r8Ni_dhNvqc','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '61','exercise_video_user_id' => '1','exercise_video_exercise_id' => '62','exercise_video_datetime' => '2018-03-23 16:57:26','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => '1fbU_MkV7NE','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '62','exercise_video_user_id' => '1','exercise_video_exercise_id' => '63','exercise_video_datetime' => '2018-03-23 17:03:11','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'hdng3Nm1x_E','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '63','exercise_video_user_id' => '1','exercise_video_exercise_id' => '64','exercise_video_datetime' => '2018-03-23 17:20:17','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'cDIYH5rH0qU','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '64','exercise_video_user_id' => '1','exercise_video_exercise_id' => '65','exercise_video_datetime' => '2018-03-23 17:34:29','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'YcMj0EEadQo','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '65','exercise_video_user_id' => '1','exercise_video_exercise_id' => '66','exercise_video_datetime' => '2018-03-23 17:43:05','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'A3uK5TPzHq8','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '66','exercise_video_user_id' => '1','exercise_video_exercise_id' => '67','exercise_video_datetime' => '2018-03-23 18:07:16','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'NJQROeaBiVE','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '67','exercise_video_user_id' => '1','exercise_video_exercise_id' => '68','exercise_video_datetime' => '2018-03-23 18:12:58','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'ANVdMDaYRts','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => ''),
  array('exercise_video_id' => '68','exercise_video_user_id' => '1','exercise_video_exercise_id' => '69','exercise_video_datetime' => '2018-03-23 18:29:53','exercise_video_user_ip' => '81.166.225.197','exercise_video_service_name' => 'youtube','exercise_video_service_id' => 'Tcv0U7iylaI','exercise_video_path' => '','exercise_video_file' => '','exercise_video_uniqe_hits' => '0','exercise_video_uniqe_hits_ip_block' => '')
);


		foreach($stram_exercise_index_videos as $v){
			
			$exercise_video_user_id = $v["exercise_video_user_id"];
			$exercise_video_exercise_id = $v["exercise_video_exercise_id"];
			$exercise_video_datetime = $v["exercise_video_datetime"];
			$exercise_video_service_name = $v["exercise_video_service_name"];
			$exercise_video_service_id = $v["exercise_video_service_id"];
			$exercise_video_path = $v["exercise_video_path"];
			$exercise_video_file = $v["exercise_video_file"];
		
			mysqli_query($link, "INSERT INTO $t_exercise_index_videos
			(exercise_video_id, exercise_video_user_id, exercise_video_exercise_id, exercise_video_datetime, exercise_video_service_name, exercise_video_service_id, exercise_video_path, exercise_video_file) 
			VALUES 
			(NULL, '$exercise_video_user_id', '$exercise_video_exercise_id', '$exercise_video_datetime', '$exercise_video_service_name', '$exercise_video_service_id', '$exercise_video_path', '$exercise_video_file')
			")
			or die(mysqli_error($link));


		}



	}
	echo"
	<!-- //videos -->

	<!-- muscles -->
	";
	$query = "SELECT * FROM $t_exercise_index_muscles";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_muscles: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_muscles(
	  	 exercise_muscle_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(exercise_muscle_id), 
	  	   exercise_muscle_exercise_id INT,
	  	   exercise_muscle_muscle_id INT,
	  	   exercise_muscle_type VARCHAR(20))")
		   or die(mysqli_error());

$stram_exercise_index_muscles = array(
  array('exercise_muscle_id' => '1','exercise_muscle_exercise_id' => '3','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '2','exercise_muscle_exercise_id' => '3','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '3','exercise_muscle_exercise_id' => '3','exercise_muscle_muscle_id' => '3','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '4','exercise_muscle_exercise_id' => '4','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '5','exercise_muscle_exercise_id' => '4','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '6','exercise_muscle_exercise_id' => '4','exercise_muscle_muscle_id' => '3','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '7','exercise_muscle_exercise_id' => '2','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '8','exercise_muscle_exercise_id' => '1','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '9','exercise_muscle_exercise_id' => '1','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '10','exercise_muscle_exercise_id' => '1','exercise_muscle_muscle_id' => '17','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '11','exercise_muscle_exercise_id' => '1','exercise_muscle_muscle_id' => '18','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '12','exercise_muscle_exercise_id' => '1','exercise_muscle_muscle_id' => '20','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '13','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '14','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '15','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '16','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '14','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '17','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '18','exercise_muscle_exercise_id' => '5','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '19','exercise_muscle_exercise_id' => '6','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '20','exercise_muscle_exercise_id' => '6','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '21','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '22','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '32','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '23','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '24','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '25','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '42','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '26','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '10','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '27','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '28','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '29','exercise_muscle_exercise_id' => '7','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '30','exercise_muscle_exercise_id' => '8','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '34','exercise_muscle_exercise_id' => '8','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '35','exercise_muscle_exercise_id' => '8','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '36','exercise_muscle_exercise_id' => '8','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '37','exercise_muscle_exercise_id' => '9','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '38','exercise_muscle_exercise_id' => '10','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '39','exercise_muscle_exercise_id' => '10','exercise_muscle_muscle_id' => '13','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '40','exercise_muscle_exercise_id' => '10','exercise_muscle_muscle_id' => '14','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '41','exercise_muscle_exercise_id' => '10','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '42','exercise_muscle_exercise_id' => '11','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '43','exercise_muscle_exercise_id' => '11','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '44','exercise_muscle_exercise_id' => '11','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '45','exercise_muscle_exercise_id' => '11','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '46','exercise_muscle_exercise_id' => '12','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '48','exercise_muscle_exercise_id' => '12','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '49','exercise_muscle_exercise_id' => '12','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '50','exercise_muscle_exercise_id' => '12','exercise_muscle_muscle_id' => '14','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '51','exercise_muscle_exercise_id' => '13','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '52','exercise_muscle_exercise_id' => '13','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '53','exercise_muscle_exercise_id' => '13','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '54','exercise_muscle_exercise_id' => '13','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '55','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '56','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '57','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '58','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '59','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '39','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '60','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '6','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '61','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '40','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '62','exercise_muscle_exercise_id' => '14','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '63','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '64','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '65','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '66','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '67','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '42','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '68','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '10','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '69','exercise_muscle_exercise_id' => '15','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '70','exercise_muscle_exercise_id' => '16','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '71','exercise_muscle_exercise_id' => '16','exercise_muscle_muscle_id' => '34','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '72','exercise_muscle_exercise_id' => '16','exercise_muscle_muscle_id' => '32','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '73','exercise_muscle_exercise_id' => '16','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '74','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '75','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '76','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '77','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '78','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '79','exercise_muscle_exercise_id' => '17','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '80','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '82','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '83','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '84','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '85','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '86','exercise_muscle_exercise_id' => '18','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '87','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '88','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '89','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '90','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '91','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '92','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '26','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '93','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '27','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '94','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '95','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '96','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '17','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '97','exercise_muscle_exercise_id' => '19','exercise_muscle_muscle_id' => '18','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '98','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '99','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '100','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '27','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '101','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '26','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '102','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '103','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '104','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '105','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '106','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '107','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '17','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '108','exercise_muscle_exercise_id' => '20','exercise_muscle_muscle_id' => '18','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '109','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '110','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '111','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '27','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '112','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '26','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '113','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '114','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '115','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '116','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '117','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '118','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '17','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '119','exercise_muscle_exercise_id' => '21','exercise_muscle_muscle_id' => '18','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '120','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '121','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '122','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '27','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '123','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '26','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '124','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '30','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '125','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '126','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '127','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '128','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '129','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '17','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '130','exercise_muscle_exercise_id' => '22','exercise_muscle_muscle_id' => '18','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '131','exercise_muscle_exercise_id' => '23','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '132','exercise_muscle_exercise_id' => '23','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '133','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '134','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '135','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '136','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '137','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '138','exercise_muscle_exercise_id' => '24','exercise_muscle_muscle_id' => '42','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '139','exercise_muscle_exercise_id' => '25','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '140','exercise_muscle_exercise_id' => '25','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '141','exercise_muscle_exercise_id' => '25','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '142','exercise_muscle_exercise_id' => '25','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '143','exercise_muscle_exercise_id' => '25','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '144','exercise_muscle_exercise_id' => '26','exercise_muscle_muscle_id' => '40','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '145','exercise_muscle_exercise_id' => '26','exercise_muscle_muscle_id' => '39','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '146','exercise_muscle_exercise_id' => '26','exercise_muscle_muscle_id' => '6','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '147','exercise_muscle_exercise_id' => '26','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '148','exercise_muscle_exercise_id' => '27','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '149','exercise_muscle_exercise_id' => '27','exercise_muscle_muscle_id' => '13','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '150','exercise_muscle_exercise_id' => '27','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '151','exercise_muscle_exercise_id' => '27','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '152','exercise_muscle_exercise_id' => '28','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '153','exercise_muscle_exercise_id' => '28','exercise_muscle_muscle_id' => '13','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '154','exercise_muscle_exercise_id' => '28','exercise_muscle_muscle_id' => '14','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '155','exercise_muscle_exercise_id' => '28','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '156','exercise_muscle_exercise_id' => '28','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '158','exercise_muscle_exercise_id' => '29','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '160','exercise_muscle_exercise_id' => '30','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '161','exercise_muscle_exercise_id' => '30','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '162','exercise_muscle_exercise_id' => '30','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '163','exercise_muscle_exercise_id' => '31','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '164','exercise_muscle_exercise_id' => '31','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '165','exercise_muscle_exercise_id' => '31','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '166','exercise_muscle_exercise_id' => '32','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '167','exercise_muscle_exercise_id' => '32','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '168','exercise_muscle_exercise_id' => '32','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '169','exercise_muscle_exercise_id' => '33','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '170','exercise_muscle_exercise_id' => '33','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '171','exercise_muscle_exercise_id' => '33','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '172','exercise_muscle_exercise_id' => '33','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '173','exercise_muscle_exercise_id' => '33','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '174','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '175','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '34','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '176','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '32','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '177','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '178','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '14','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '179','exercise_muscle_exercise_id' => '34','exercise_muscle_muscle_id' => '11','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '180','exercise_muscle_exercise_id' => '35','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '181','exercise_muscle_exercise_id' => '35','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '182','exercise_muscle_exercise_id' => '36','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '183','exercise_muscle_exercise_id' => '37','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '184','exercise_muscle_exercise_id' => '37','exercise_muscle_muscle_id' => '33','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '185','exercise_muscle_exercise_id' => '37','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '186','exercise_muscle_exercise_id' => '38','exercise_muscle_muscle_id' => '21','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '187','exercise_muscle_exercise_id' => '38','exercise_muscle_muscle_id' => '22','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '188','exercise_muscle_exercise_id' => '38','exercise_muscle_muscle_id' => '23','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '190','exercise_muscle_exercise_id' => '39','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '191','exercise_muscle_exercise_id' => '39','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '192','exercise_muscle_exercise_id' => '40','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '193','exercise_muscle_exercise_id' => '41','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '195','exercise_muscle_exercise_id' => '42','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '196','exercise_muscle_exercise_id' => '42','exercise_muscle_muscle_id' => '25','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '197','exercise_muscle_exercise_id' => '43','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '198','exercise_muscle_exercise_id' => '44','exercise_muscle_muscle_id' => '6','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '199','exercise_muscle_exercise_id' => '44','exercise_muscle_muscle_id' => '39','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '200','exercise_muscle_exercise_id' => '44','exercise_muscle_muscle_id' => '40','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '201','exercise_muscle_exercise_id' => '44','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '202','exercise_muscle_exercise_id' => '45','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '203','exercise_muscle_exercise_id' => '45','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '205','exercise_muscle_exercise_id' => '45','exercise_muscle_muscle_id' => '42','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '206','exercise_muscle_exercise_id' => '45','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '207','exercise_muscle_exercise_id' => '46','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '208','exercise_muscle_exercise_id' => '47','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '209','exercise_muscle_exercise_id' => '47','exercise_muscle_muscle_id' => '8','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '210','exercise_muscle_exercise_id' => '47','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '211','exercise_muscle_exercise_id' => '47','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '212','exercise_muscle_exercise_id' => '48','exercise_muscle_muscle_id' => '28','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '213','exercise_muscle_exercise_id' => '49','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '214','exercise_muscle_exercise_id' => '50','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '215','exercise_muscle_exercise_id' => '50','exercise_muscle_muscle_id' => '37','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '216','exercise_muscle_exercise_id' => '50','exercise_muscle_muscle_id' => '36','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '217','exercise_muscle_exercise_id' => '51','exercise_muscle_muscle_id' => '37','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '218','exercise_muscle_exercise_id' => '51','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '219','exercise_muscle_exercise_id' => '51','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '220','exercise_muscle_exercise_id' => '52','exercise_muscle_muscle_id' => '12','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '221','exercise_muscle_exercise_id' => '52','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '222','exercise_muscle_exercise_id' => '52','exercise_muscle_muscle_id' => '31','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '223','exercise_muscle_exercise_id' => '53','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '224','exercise_muscle_exercise_id' => '54','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '226','exercise_muscle_exercise_id' => '54','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '227','exercise_muscle_exercise_id' => '55','exercise_muscle_muscle_id' => '4','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '228','exercise_muscle_exercise_id' => '56','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '229','exercise_muscle_exercise_id' => '56','exercise_muscle_muscle_id' => '32','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '230','exercise_muscle_exercise_id' => '56','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '231','exercise_muscle_exercise_id' => '57','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '232','exercise_muscle_exercise_id' => '57','exercise_muscle_muscle_id' => '1','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '233','exercise_muscle_exercise_id' => '57','exercise_muscle_muscle_id' => '32','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '234','exercise_muscle_exercise_id' => '57','exercise_muscle_muscle_id' => '2','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '235','exercise_muscle_exercise_id' => '58','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '236','exercise_muscle_exercise_id' => '59','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '237','exercise_muscle_exercise_id' => '60','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '238','exercise_muscle_exercise_id' => '61','exercise_muscle_muscle_id' => '37','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '239','exercise_muscle_exercise_id' => '61','exercise_muscle_muscle_id' => '36','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '240','exercise_muscle_exercise_id' => '61','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '241','exercise_muscle_exercise_id' => '62','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '242','exercise_muscle_exercise_id' => '63','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '243','exercise_muscle_exercise_id' => '64','exercise_muscle_muscle_id' => '37','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '244','exercise_muscle_exercise_id' => '64','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '245','exercise_muscle_exercise_id' => '65','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '246','exercise_muscle_exercise_id' => '66','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '247','exercise_muscle_exercise_id' => '67','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '248','exercise_muscle_exercise_id' => '68','exercise_muscle_muscle_id' => '35','exercise_muscle_type' => 'main'),
  array('exercise_muscle_id' => '249','exercise_muscle_exercise_id' => '68','exercise_muscle_muscle_id' => '24','exercise_muscle_type' => 'assistant'),
  array('exercise_muscle_id' => '250','exercise_muscle_exercise_id' => '69','exercise_muscle_muscle_id' => '41','exercise_muscle_type' => 'main')
);


		foreach($stram_exercise_index_muscles as $v){
			
			$exercise_muscle_exercise_id = $v["exercise_muscle_exercise_id"];
			$exercise_muscle_muscle_id = $v["exercise_muscle_muscle_id"];
			$exercise_muscle_type = $v["exercise_muscle_type"];
		
			mysqli_query($link, "INSERT INTO $t_exercise_index_muscles
			(exercise_muscle_id, exercise_muscle_exercise_id, exercise_muscle_muscle_id, exercise_muscle_type) 
			VALUES 
			(NULL, '$exercise_muscle_exercise_id', '$exercise_muscle_muscle_id', '$exercise_muscle_type')
			")
			or die(mysqli_error($link));


		}


	}
	echo"
	<!-- //muscles -->

	<!-- muscles -->
	";
	$query = "SELECT * FROM $t_exercise_index_muscles_images";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_muscles_images: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_muscles_images(
	  	 exercise_muscle_image_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(exercise_muscle_image_id), 
	  	   exercise_muscle_image_exercise_id INT,
	  	   exercise_muscle_image_file VARCHAR(250))")
		   or die(mysqli_error());

		// Will be added automatically
	}
	echo"
	<!-- //muscles -->


	<!-- exercise_tags -->
	";
	$query = "SELECT * FROM $t_exercise_index_tags";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_tags: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_tags(
	  	 tag_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(tag_id), 
	  	   tag_exercise_id INT,
	  	   tag_language VARCHAR(20),
	  	   tag_text VARCHAR(200),
	  	   tag_clean VARCHAR(200))")
		   or die(mysqli_error());
	}
	echo"
	<!-- //exercise_tags -->

	<!-- exercise_index_comments -->
	";
	$query = "SELECT * FROM $t_exercise_index_comments";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_index_comments: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_index_comments(
	  	 comment_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(comment_id), 
	  	   comment_exercise_id INT,
	  	   comment_text TEXT,
	  	   comment_by_user_id INT,
	  	   comment_by_user_name VARCHAR(50),
	  	   comment_by_user_image_path VARCHAR(250),
	  	   comment_by_user_image_file VARCHAR(50),
	  	   comment_by_user_image_thumb_60 VARCHAR(50),
	  	   comment_by_user_ip VARCHAR(200),
	  	   comment_created DATETIME,
	  	   comment_created_saying VARCHAR(50),
	  	   comment_created_timestamp VARCHAR(50),
	  	   comment_updated DATETIME,
	  	   comment_updated_saying VARCHAR(50),
	  	   comment_likes INT,
	  	   comment_dislikes INT,
	  	   comment_number_of_replies INT,
	  	   comment_read_blog_owner INT,
	  	   comment_reported INT,
	  	   comment_reported_by_user_id INT,
	  	   comment_reported_reason TEXT,
	  	   comment_reported_checked INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //exercise_index_comments -->

	<!-- exercise_tags_cloud -->
	";
	$query = "SELECT * FROM $t_exercise_tags_cloud";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_tags_cloud: $row_cnt</p>
		";
	}
	else{
echo"<pre>CREATE TABLE $t_exercise_tags_cloud(
	  	 cloud_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(cloud_id), 
	  	   cloud_language VARCHAR(20),
	  	   cloud_text VARCHAR(200),
	  	   cloud_clean VARCHAR(200),
	  	   cloud_occurrences INT)</pre>";

		mysqli_query($link, "CREATE TABLE $t_exercise_tags_cloud(
	  	 cloud_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(cloud_id), 
	  	   cloud_language VARCHAR(20),
	  	   cloud_text VARCHAR(20),
	  	   cloud_clean VARCHAR(200),
	  	   cloud_occurrences INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //exercise_tags_cloud -->




	<!-- types -->
	";
	$query = "SELECT * FROM $t_exercise_types";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_types: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_types(
	  	 type_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(type_id), 
	  	   type_title VARCHAR(250),
	  	   type_image_path VARCHAR(250),
	  	   type_image_file VARCHAR(250))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_exercise_types
		(type_id, type_title) 
		VALUES 
		(NULL, 'CrossFit'),
		(NULL, 'Strength'),
		(NULL, 'Endurance Strength'),
		(NULL, 'Yoga'),
		(NULL, 'Cardio'),
		(NULL, 'Other')")
		or die(mysqli_error($link)); 
	}
	echo"
	<!-- //types -->


	<!-- type_translations -->
	";
	$query = "SELECT * FROM $t_exercise_types_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_types_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_types_translations(
	  	 type_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(type_translation_id), 
	  	   type_id INT,
	  	   type_translation_language VARCHAR(20),
	  	   type_translation_value VARCHAR(250))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_exercise_types_translations
		(type_translation_id, type_id, type_translation_language, type_translation_value) 
		VALUES 
		(NULL, '1', 'en', 'CrossFit'),
		(NULL, '2', 'en', 'Strength'),
		(NULL, '3', 'en', 'Endurance Strength'),
		(NULL, '4', 'en', 'Yoga'),
		(NULL, '5', 'en', 'Cardio'),
		(NULL, '6', 'en', 'Other')")
		or die(mysqli_error($link)); 

		mysqli_query($link, "INSERT INTO $t_exercise_types_translations
		(type_translation_id, type_id, type_translation_language, type_translation_value) 
		VALUES 
		(NULL, '1', 'no', 'CrossFit'),
		(NULL, '2', 'no', 'Syrke'),
		(NULL, '3', 'no', 'Utholdene styrke'),
		(NULL, '4', 'no', 'Yoga'),
		(NULL, '5', 'no', 'Cardio'),
		(NULL, '6', 'no', 'Annet')")
		or die(mysqli_error($link)); 
	}
	echo"
	<!-- //types_translations -->


	<!-- levels -->
	";
	$query = "SELECT * FROM $t_exercise_levels";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_levels: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_levels(
	  	 level_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(level_id), 
	  	   level_title VARCHAR(250))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_exercise_levels
		(level_id, level_title) 
		VALUES 
		(NULL, 'Beginner'),
		(NULL, 'Intermediate'),
		(NULL, 'Expert')")
		or die(mysqli_error($link)); 
	}
	echo"
	<!-- //levels -->


	<!-- level_translations -->
	";
	$query = "SELECT * FROM $t_exercise_levels_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_levels_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_exercise_levels_translations(
	  	 level_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(level_translation_id), 
	  	   level_id INT,
	  	   level_translation_language VARCHAR(20),
	  	   level_translation_value VARCHAR(250))")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_exercise_levels_translations
		(level_translation_id, level_id, level_translation_language, level_translation_value) 
		VALUES 
		(NULL, '1', 'en', 'Beginner'),
		(NULL, '2', 'en', 'Intermediate'),
		(NULL, '3', 'en', 'Expert')")
		or die(mysqli_error($link)); 

		mysqli_query($link, "INSERT INTO $t_exercise_levels_translations
		(level_translation_id, level_id, level_translation_language, level_translation_value) 
		VALUES 
		(NULL, '1', 'no', 'Nybegynner'),
		(NULL, '2', 'no', 'Medium'),
		(NULL, '3', 'no', 'Ekspert')")
		or die(mysqli_error($link)); 
	}
	echo"
	<!-- //levels_translations -->




	<!-- equipments -->
	";
	$query = "SELECT * FROM $t_exercise_equipments";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_equipments: $row_cnt</p>
		";
	}
	else{

		mysqli_query($link, "CREATE TABLE $t_exercise_equipments(
	  	 equipment_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(equipment_id), 
	  	   equipment_title VARCHAR(250), 
	  	   equipment_title_clean VARCHAR(250), 
	  	   equipment_user_id INT,
	  	   equipment_language VARCHAR(20),
	  	   equipment_muscle_group_id_main INT,
	  	   equipment_muscle_group_id_sub INT,
	  	   equipment_muscle_part_of_id INT,
	  	   equipment_type_id INT,
	  	   equipment_text TEXT,
	  	   equipment_image_path VARCHAR(250),
	  	   equipment_image_file VARCHAR(250),
	  	   equipment_created_datetime DATETIME,
	  	   equipment_updated_datetime DATETIME,
	  	   equipment_user_ip VARCHAR(250),
	  	   equipment_uniqe_hits INT,
	  	   equipment_uniqe_hits_ip_block TEXT,
	  	   equipment_likes INT,
	  	   equipment_dislikes INT,
	  	   equipment_rating INT,
	  	   equipment_rating_ip_block TEXT,
	  	   equipment_number_of_comments INT,
	  	   equipment_reported INT,
	  	   equipment_reported_checked INT,
	  	   equipment_reported_reason TEXT)")
		   or die(mysqli_error());
	
		$stram_exercise_equipments = array(
  array('equipment_id' => '1','equipment_title' => 'EZ vektstang','equipment_title_clean' => 'ez_vektstang','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '1','equipment_muscle_group_id_sub' => '2','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '<p><span lang="no" xml:lang="no"><span>EZ stangen ble oppfunnet av Lewis G. Dymeck. Den benyttes mye til bicepscurl, stående roing og triceps. </span></span></p>
<p><span lang="no" xml:lang="no">Den buede profilen til stangen i grepområdet tillater brukerens håndledd og underarmer å ta en mer nøytral og naturlig stilling. Dette reduserer risikoen for skader ved øvelsene. Det negative ved å benytte EZ bar til bicepscurl er at man ikke får en fullstendig sammentrekning av biceps, og dermed kan det vise seg en mindre effektiv treningen.<br /></span></p>','equipment_image_path' => '_uploads/exercises/no/equipment/ez_vektstang','equipment_image_file' => 'ez_vektstang_1.png','equipment_created_datetime' => '2018-02-18 12:32:38','equipment_updated_datetime' => '2018-02-18 12:32:38','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '2','equipment_title' => 'Hantler','equipment_title_clean' => 'hantler','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '1','equipment_muscle_group_id_sub' => '2','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '<p><span lang="no" xml:lang="no"><span title="The forerunner of the dumbbell, halteres, were used in ancient Greece as lifting weights[1][2] and also as weights in the ancient Greek version of the long jump.[3]">Hantler kan spores tilbake til det gamle Hellas. Det ble der benyttet til vekløfting. Hantler er veldig mye brukt innenfor trening da de lar oss trene alt fra armer, rygg til bein. </span></span></p>','equipment_image_path' => '_uploads/exercises/no/equipment/hantler','equipment_image_file' => 'hantler_2.png','equipment_created_datetime' => '2018-02-18 13:00:54','equipment_updated_datetime' => '2018-02-18 13:00:54','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '3','equipment_title' => 'Flatbenk','equipment_title_clean' => 'flatbenk','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/flatbenk','equipment_image_file' => 'flatbenk_3.png','equipment_created_datetime' => '2018-02-19 16:34:39','equipment_updated_datetime' => '2018-02-19 16:34:39','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '4','equipment_title' => 'Benkpress','equipment_title_clean' => 'benkpress','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '11','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/benkpress','equipment_image_file' => 'benkpress_4.png','equipment_created_datetime' => '2018-02-19 16:41:03','equipment_updated_datetime' => '2018-02-19 16:41:03','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '5','equipment_title' => 'Pull ups bar','equipment_title_clean' => 'pull_ups_bar','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '9','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-02-21 17:30:43','equipment_updated_datetime' => '2018-02-21 17:30:43','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '6','equipment_title' => 'Skr&aring;benk','equipment_title_clean' => 'skrabenk','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '11','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/skrabenk','equipment_image_file' => 'skrabenk_6.png','equipment_created_datetime' => '2018-03-10 17:32:51','equipment_updated_datetime' => '2018-03-10 17:32:51','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '8','equipment_title' => 'CrossOver','equipment_title_clean' => 'crossover','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '12','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-10 18:36:21','equipment_updated_datetime' => '2018-03-10 18:36:21','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '9','equipment_title' => 'Squat Stand','equipment_title_clean' => 'squat_stand','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/squat_stand','equipment_image_file' => 'squat_stand_9.png','equipment_created_datetime' => '2018-03-10 18:44:25','equipment_updated_datetime' => '2018-03-10 18:44:25','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '10','equipment_title' => 'Tredem&oslash;lle','equipment_title_clean' => 'tredemolle','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-10 22:59:04','equipment_updated_datetime' => '2018-03-10 22:59:04','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '11','equipment_title' => 'Pulsklokke','equipment_title_clean' => 'pulsklokke','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-10 23:12:21','equipment_updated_datetime' => '2018-03-10 23:12:21','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '12','equipment_title' => 'Vektstang','equipment_title_clean' => 'vektstang','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/vektstang','equipment_image_file' => 'vektstang_12.png','equipment_created_datetime' => '2018-03-17 22:19:21','equipment_updated_datetime' => '2018-03-17 22:19:21','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '13','equipment_title' => 'Smithmaskin','equipment_title_clean' => 'smithmaskin','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '11','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/smithmaskin','equipment_image_file' => 'smithmaskin_13.png','equipment_created_datetime' => '2018-03-18 08:50:04','equipment_updated_datetime' => '2018-03-18 08:50:04','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '14','equipment_title' => 'Dipsstativ','equipment_title_clean' => 'dipsstativ','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '12','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-18 09:02:27','equipment_updated_datetime' => '2018-03-18 09:02:27','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '15','equipment_title' => 'Beinpress','equipment_title_clean' => 'beinpress','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-19 21:49:39','equipment_updated_datetime' => '2018-03-19 21:49:39','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '16','equipment_title' => 'L&aring;rcurl','equipment_title_clean' => 'larcurl','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '16','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-20 16:53:28','equipment_updated_datetime' => '2018-03-20 16:53:28','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '17','equipment_title' => 'Benkpress maskin','equipment_title_clean' => 'benkpress_maskin','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '10','equipment_muscle_group_id_sub' => '11','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-20 17:03:02','equipment_updated_datetime' => '2018-03-20 17:03:02','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '18','equipment_title' => 'Tau','equipment_title_clean' => 'tau','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '22','equipment_muscle_group_id_sub' => '23','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-20 21:39:14','equipment_updated_datetime' => '2018-03-20 21:39:14','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '19','equipment_title' => 'Romaskin','equipment_title_clean' => 'romaskin','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '7','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 17:08:02','equipment_updated_datetime' => '2018-03-21 17:08:02','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '20','equipment_title' => 'Leggcurl','equipment_title_clean' => 'leggcurl','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '13','equipment_muscle_group_id_sub' => '15','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 17:20:02','equipment_updated_datetime' => '2018-03-21 17:20:02','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '21','equipment_title' => 'B&oslash;yd stang','equipment_title_clean' => 'boyd_stang','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '7','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 18:23:35','equipment_updated_datetime' => '2018-03-21 18:23:35','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '23','equipment_title' => 'Rett stang','equipment_title_clean' => 'rett_stang','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '1','equipment_muscle_group_id_sub' => '3','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 18:36:49','equipment_updated_datetime' => '2018-03-21 18:36:49','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '24','equipment_title' => 'Nedtrekk','equipment_title_clean' => 'nedtrekk','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '8','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 18:46:53','equipment_updated_datetime' => '2018-03-21 18:46:53','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '25','equipment_title' => 'V-Bar','equipment_title_clean' => 'v-bar','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '0','equipment_muscle_group_id_sub' => '0','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-21 18:59:08','equipment_updated_datetime' => '2018-03-21 18:59:08','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '26','equipment_title' => 'Treningsmatte','equipment_title_clean' => 'treningsmatte','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '22','equipment_muscle_group_id_sub' => '23','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-23 16:30:08','equipment_updated_datetime' => '2018-03-23 16:30:08','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '27','equipment_title' => 'Medisinball','equipment_title_clean' => 'medisinball','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '22','equipment_muscle_group_id_sub' => '23','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-23 16:49:10','equipment_updated_datetime' => '2018-03-23 16:49:10','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '28','equipment_title' => 'Treiningshjul','equipment_title_clean' => 'treiningshjul','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '22','equipment_muscle_group_id_sub' => '23','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-23 17:42:25','equipment_updated_datetime' => '2018-03-23 17:42:25','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '29','equipment_title' => 'Rygghevstativ','equipment_title_clean' => 'rygghevstativ','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '9','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => NULL,'equipment_image_path' => NULL,'equipment_image_file' => NULL,'equipment_created_datetime' => '2018-03-23 18:29:11','equipment_updated_datetime' => '2018-03-23 18:29:11','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL),
  array('equipment_id' => '30','equipment_title' => 'Pull ups belte','equipment_title_clean' => 'pull_ups_belte','equipment_user_id' => '1','equipment_language' => 'no','equipment_muscle_group_id_main' => '5','equipment_muscle_group_id_sub' => '9','equipment_muscle_part_of_id' => NULL,'equipment_type_id' => NULL,'equipment_text' => '','equipment_image_path' => '_uploads/exercises/no/equipment/pull_ups_belte','equipment_image_file' => 'pull_ups_belte_30.png','equipment_created_datetime' => '2018-03-23 19:10:15','equipment_updated_datetime' => '2018-03-23 19:10:15','equipment_user_ip' => '81.166.225.197','equipment_uniqe_hits' => '0','equipment_uniqe_hits_ip_block' => '','equipment_likes' => '0','equipment_dislikes' => '0','equipment_rating' => '0','equipment_rating_ip_block' => NULL,'equipment_number_of_comments' => '0','equipment_reported' => NULL,'equipment_reported_checked' => NULL,'equipment_reported_reason' => NULL)
);

		$datetime = date("Y-m-d H:i:s");
		foreach($stram_exercise_equipments as $v){
			
			$equipment_title = $v["equipment_title"];
			$equipment_title_clean = $v["equipment_title_clean"];
			$equipment_user_id = $v["equipment_user_id"];
			$equipment_language = $v["equipment_language"];
			$equipment_muscle_group_id_main = $v["equipment_muscle_group_id_main"];
			$equipment_muscle_group_id_sub = $v["equipment_muscle_group_id_sub"];

			$equipment_muscle_part_of_id = $v["equipment_muscle_part_of_id"];
			if($equipment_muscle_part_of_id == ""){
				$equipment_muscle_part_of_id = "0";
			}
			$equipment_type_id = $v["equipment_type_id"];
			if($equipment_type_id == ""){
				$equipment_type_id = "0";
			}
			$equipment_text = $v["equipment_text"];
			$equipment_image_path = $v["equipment_image_path"];
			$equipment_image_file = $v["equipment_image_file"];
		
			mysqli_query($link, "INSERT INTO $t_exercise_equipments
			(equipment_id, equipment_title, equipment_title_clean, equipment_user_id, equipment_language, equipment_muscle_group_id_main, equipment_muscle_group_id_sub, 
equipment_muscle_part_of_id, equipment_type_id, equipment_text, equipment_image_path, equipment_image_file, equipment_created_datetime, equipment_updated_datetime) 
			VALUES 
			(NULL, '$equipment_title', '$equipment_title_clean', '$equipment_user_id', '$equipment_language', '$equipment_muscle_group_id_main', '$equipment_muscle_group_id_sub', 
		'$equipment_muscle_part_of_id', '$equipment_type_id', '$equipment_text', '$equipment_image_path', '$equipment_image_file', '$datetime', '$datetime')
			")
			or die(mysqli_error($link));


		}

	}
	echo"
	<!-- //equipments -->


	
	";
?>