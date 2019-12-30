<?php
echo"

			<!-- Menu -->
				<div class=\"tabs\">
					<ul>
						<li><a href=\"index.php?open=$open&amp;page=users_edit_user&amp;user_id=$user_id&amp;l=$l&amp;refer=$refer&amp;editor_language=$editor_language\""; if($action == ""){ echo" class=\"active\""; } echo">$l_edit_user</a></li>
						<li><a href=\"index.php?open=$open&amp;page=users_edit_user_profile&amp;action=edit_profile&amp;user_id=$user_id&amp;l=$l&amp;refer=$refer&amp;editor_language=$editor_language\""; if($action == "edit_profile"){ echo" class=\"active\""; } echo">$l_edit_profile</a></li>
						<li><a href=\"index.php?open=$open&amp;page=users_edit_user_password&amp;action=edit_password&amp;user_id=$user_id&amp;l=$l&amp;refer=$refer&amp;editor_language=$editor_language\" "; if($action == "edit_password"){ echo" class=\"active\""; } echo">$l_password</a></li>
						<li><a href=\"index.php?open=$open&amp;page=users_edit_user_photos&amp;action=photos&amp;user_id=$user_id&amp;l=$l&amp;refer=$refer&amp;editor_language=$editor_language\""; if($action == "photos"){ echo" class=\"active\""; } echo">$l_photos</a></li>
						<li><a href=\"index.php?open=$open&amp;page=users_edit_user_professional&amp;action=professional&amp;user_id=$user_id&amp;l=$l&amp;refer=$refer&amp;editor_language=$editor_language\""; if($action == "professional"){ echo" class=\"active\""; } echo">Professional</a></li>
					</ul>
				</div>
				<div class=\"clear\"></div>
			<!-- //Menu -->
";
?>