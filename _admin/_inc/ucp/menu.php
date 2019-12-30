<?php
/**
*
* File: _admin/_inc/ucp/menu.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}



echo"
		<ul>
			<li";if($page == "" OR $page == "default"){echo" class=\"down\"";}echo"><a href=\"./?open=ucp&amp;page=default\"";if($page == "default"){echo" class=\"selected\"";}echo">";if($userAliasSav == ""){echo"Profil";}else{echo"$userAliasSav";}echo"</a></li>
			
			";
			if($page == "" OR $page == "default"){
				echo"
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=alias&amp;focus=inp_alias\">Alias</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=email&amp;focus=inp_mail\">E-postadresse</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=password&amp;focus=inp_password\">Passord</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=profil\">Profil</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=avatar\">Avatar</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=picture\">Bilde</a></li>
				<li class=\"sub\"><a href=\"./?open=ucp&amp;page=default&amp;sub=free_text\">Fritekst</a></li>
				";
			}
			echo"
		</ul>
";
?>