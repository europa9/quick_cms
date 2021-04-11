<?php
/**
*
* File: _admin/_inc/diet/categories.php
* Version 00.28 20.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_food_categories		  = $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  = $mysqlPrefixSav . "food_categories_translations";
$t_food_index			  = $mysqlPrefixSav . "food_index";
$t_food_index_stores		  = $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		  = $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  = $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  = $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		  = $mysqlPrefixSav . "food_index_contents";
$t_food_stores		  	  = $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  = $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  = $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  = $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations = $mysqlPrefixSav . "food_measurements_translations";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['language'])){
	$language = $_GET['language'];
	$language = strip_tags(stripslashes($language));
}
else{
	$language = "en";
}


if($action == ""){
	echo"
	<h1>Categories</h1>


	<p><a href=\"index.php?open=$open&amp;page=categories&amp;action=new_category&amp;editor_language=$editor_language\">New category</a>
	|
	<a href=\"index.php?open=$open&amp;page=categories&amp;action=translations&amp;editor_language=$editor_language\">Translations</a>
	|
	<a href=\"index.php?open=$open&amp;page=categories&amp;action=sqlite_code_a&amp;editor_language=$editor_language\">SQLite code 1</a>
	|
	<a href=\"index.php?open=$open&amp;page=categories&amp;action=sqlite_code_b&amp;editor_language=$editor_language\">SQLite code 2</a>
	|
	<a href=\"index.php?open=$open&amp;page=categories&amp;action=strings&amp;editor_language=$editor_language\">Strings</a></p>
	
	<!-- Main categories -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Category ID</b></span>
		  </td>
		   <th scope=\"col\">
			<span><b>Name</b></span>
		  </td>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		  </td>
		  </tr>
		 </thead>";
		// Get all categories
		$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_parent_id) = $row;
				
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
				
	
			echo"
			 <tr>
			  <td class=\"$style\">
				<span>$get_category_id</span>
			  </td>
			  <td class=\"$style\">
				<span><a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$get_category_id&amp;language=$language\">$get_category_name</a></span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=edit_category&amp;category_id=$get_category_id&amp;language=$language\">Edit</a>
				|
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=delete_category&amp;category_id=$get_category_id&amp;language=$language\">Delete</a>
				</span>
			  </td>
			 </tr>";
		}

		echo"
		</table>
	<!-- //Main categories -->
	";
}
elseif($action == "open_main_category" && isset($_GET['category_id'])){
	
	// Get variables
	$category_id = $_GET['category_id'];
	$category_id = strip_tags(stripslashes($category_id));
	$category_id_mysql = quote_smart($link, $category_id);

	$language_mysql = quote_smart($link, $language);

	// Select category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_category_id, $get_category_user_id, $get_category_name, $get_category_parent_id) = $row;

	if($get_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Category not found.</p>

		<p><a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a></p>
		";
	}
	else{
		echo"
		<h1>$get_category_name</h1>

		<p>
		<a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$category_id&amp;language=$language\">$get_category_name</a>
		</p>

		<p><a href=\"index.php?open=$open&amp;page=categories&amp;action=new_category&amp;language=$language\">New category</a></p>
		<!-- Sub categories -->

			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				<span><b>Category ID</b></span>
			   </td>
			   <th scope=\"col\">
				<span><b>Name</b></span>
			   </td>
			   <th scope=\"col\">
				<span><b>Actions</b></span>
			  </td>
			  </tr>
			 </thead>";

			// Get all categories
			$category_language_mysql = quote_smart($link, $language);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id=$category_id_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_category_id, $get_category_name, $get_category_parent_id) = $row;
				
				// Style
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
		
				echo"
					 <tr>
					  <td class=\"$style\">
						<span>$get_category_id</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_category_name</span>
				 	 </td>
				 	 <td class=\"$style\">
						<span>
						<a href=\"index.php?open=$open&amp;page=categories&amp;action=edit_category&amp;category_id=$get_category_id&amp;language=$language\">Edit</a>
						|
						<a href=\"index.php?open=$open&amp;page=categories&amp;action=delete_category&amp;category_id=$get_category_id&amp;language=$language\">Delete</a>
						</span>
					  </td>
					 </tr>";
			}

			echo"
			</table>
		<!-- //Sub categories -->
		";
	}
} // open main category
elseif($action == "edit_category" && isset($_GET['category_id'])){
	
	// Get variables
	$category_id = $_GET['category_id'];
	$category_id = strip_tags(stripslashes($category_id));
	$category_id_mysql = quote_smart($link, $category_id);

	// Select category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id, category_age_limit FROM $t_food_categories WHERE category_id=$category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_category_id, $get_current_category_user_id, $get_current_category_name, $get_current_category_parent_id, $get_current_category_age_limit) = $row;

	if($get_current_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Category not found.</p>

		<p><a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a></p>
		";
	}
	else{
		if($process == "1"){
			$inp_category_name = $_POST['inp_category_name'];
			$inp_category_name = output_html($inp_category_name);
			$inp_category_name_mysql = quote_smart($link, $inp_category_name);

			$inp_category_parent_id = $_POST['inp_category_parent_id'];
			$inp_category_parent_id = output_html($inp_category_parent_id);
			$inp_category_parent_id_mysql = quote_smart($link, $inp_category_parent_id);

			$inp_category_age_limit = $_POST['inp_category_age_limit'];
			$inp_category_age_limit = output_html($inp_category_age_limit);
			$inp_category_age_limit_mysql = quote_smart($link, $inp_category_age_limit);


			// Update
			$result = mysqli_query($link, "UPDATE $t_food_categories SET category_name=$inp_category_name_mysql, category_parent_id=$inp_category_parent_id_mysql, category_age_limit=$inp_category_age_limit_mysql WHERE category_id=$category_id_mysql");

			// Send success
			$url = "index.php?open=$open&page=categories&action=edit_category&category_id=$get_current_category_id&ft=success&fm=changes_saved&language=$language";
			header("Location: $url");
			exit;
		}


		echo"
		<h1>$get_current_category_name</h1>

		<!-- Where am I ? -->
			<p>
			<a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a>
			&gt;";
	
			if($get_current_category_parent_id == "0"){
				echo"
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$get_current_category_id&amp;language=$language\">$get_current_category_name</a>
				";
			}
			else{
				// Get parent category name
				$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id='$get_current_category_parent_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_parent_category_id, $get_parent_category_user_id, $get_parent_category_name, $get_parent_category_parent_id) = $row;

				
				echo"
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$get_parent_category_id&amp;language=$language\">$get_parent_category_name</a>
				&gt;
				$get_current_category_name
				";
			}
			echo"
			</p>
		<!-- //Where am I ? -->


		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "Changes saved";
				}
				else{
					$fm = ucfirst($ft);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
		echo"
		<!-- //Feedback -->

		<!-- Edit category form -->
			
			<!-- Focus -->
			<script>
				\$(document).ready(function(){
					\$('[name=\"inp_mail\"]').focus();
				});
			</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=categories&amp;action=edit_category&amp;category_id=$category_id&amp;language=$language&amp;process=1\" enctype=\"multipart/form-data\">


			<p><b>Name:</b><br />
			<input type=\"text\" name=\"inp_category_name\" value=\"$get_current_category_name\" size=\"40\" />
			</p>

			<p><b>Parent:</b><br />
			<select name=\"inp_category_parent_id\">
				<option value=\"0\""; if($get_current_category_parent_id == "0"){ echo" selected=\"selected\""; } echo">- This is parent -</option>\n";
				$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_category_id, $get_category_name, $get_category_parent_id) = $row;
					echo"			";
					echo"<option value=\"$get_category_id\""; if($get_current_category_parent_id == "$get_category_id"){ echo" selected=\"selected\""; } echo">$get_category_name</option>\n";
				}
			echo"
			</select>
			</p>

			<p><b>Age limit:</b><br />
			<input type=\"radio\" name=\"inp_category_age_limit\" value=\"1\""; if($get_current_category_age_limit == "1"){ echo" checked=\"checked\""; } echo" /> Yes
			<input type=\"radio\" name=\"inp_category_age_limit\" value=\"0\""; if($get_current_category_age_limit == "0"){ echo" checked=\"checked\""; } echo" /> No
			</p>

			<p>
			<input type=\"submit\" value=\"Save\" />
			</p>

			</form>
		<!-- //Edit category form -->
		
		";
	}
} // edit_category
elseif($action == "delete_category" && isset($_GET['category_id'])){
	
	// Get variables
	$category_id = $_GET['category_id'];
	$category_id = strip_tags(stripslashes($category_id));
	$category_id_mysql = quote_smart($link, $category_id);

	// Select category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_category_id, $get_current_category_user_id, $get_current_category_name, $get_current_category_parent_id) = $row;

	if($get_current_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Category not found.</p>

		<p><a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a></p>
		";
	}
	else{
		if($process == "1"){
			
			// Delete
			$result = mysqli_query($link, "DELETE FROM $t_food_categories WHERE category_id=$category_id_mysql");

			// Send success
			$url = "index.php?open=$open&page=categories&ft=success&fm=category_deleted&language=$language";
			header("Location: $url");
			exit;
		}


		echo"
		<h1>$get_current_category_name</h1>

		<!-- Where am I ? -->
			<p>
			<a href=\"index.php?open=$open&amp;page=categories\">Categories</a>
			&gt;";
	
			if($get_current_category_parent_id == "0"){
				echo"
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$get_current_category_id&amp;language=$language\">$get_current_category_name</a>
				";
			}
			else{
				// Get parent category name
				$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id='$get_current_category_parent_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_parent_category_id, $get_parent_category_user_id, $get_parent_category_name, $get_parent_category_parent_id) = $row;

				
				echo"
				<a href=\"index.php?open=$open&amp;page=categories&amp;action=open_main_category&amp;category_id=$get_parent_category_id&amp;language=$language\">$get_parent_category_name</a>
				&gt;
				$get_current_category_name
				";
			}
			echo"
			</p>
		<!-- //Where am I ? -->


		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "Changes saved";
				}
				else{
					$fm = ucfirst($ft);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
		echo"
		<!-- //Feedback -->

		<!-- Delete category form -->
			
			<p>
			Are you sure you want to delete the category?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Cancel</a>
			|
			<a href=\"index.php?open=$open&amp;page=categories&amp;action=delete_category&amp;category_id=$category_id&amp;language=$language&amp;process=1\">Delete</a>
			</p>
		<!-- //Delete category form -->
		
		";
	}
} // delete_category
elseif($action == "new_category"){
	if($process == "1"){
		$inp_category_name = $_POST['inp_category_name'];
		$inp_category_name = output_html($inp_category_name);
		$inp_category_name_mysql = quote_smart($link, $inp_category_name);
		if(empty($inp_category_name)){
			echo"No category name";die;
		}

		$inp_category_parent_id = $_POST['inp_category_parent_id'];
		$inp_category_parent_id = output_html($inp_category_parent_id);
		$inp_category_parent_id_mysql = quote_smart($link, $inp_category_parent_id);

		$inp_category_age_limit = $_POST['inp_category_age_limit'];
		$inp_category_age_limit = output_html($inp_category_age_limit);
		$inp_category_age_limit_mysql = quote_smart($link, $inp_category_age_limit);

		$inp_date = date("Y-m-d H:i:s");
		$inp_category_note = "Created $inp_date";
		$inp_category_note_mysql = quote_smart($link, $inp_category_note);


		// Insert
		mysqli_query($link, "INSERT INTO $t_food_categories
		(category_id, category_user_id, category_name, category_parent_id, category_note, category_age_limit) 
		VALUES 
		(NULL, '0', $inp_category_name_mysql, $inp_category_parent_id_mysql, $inp_category_note_mysql, $inp_category_age_limit_mysql)")
		or die(mysqli_error($link));

		// Get category ID
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_note=$inp_category_note_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_category_id, $get_current_category_user_id, $get_current_category_name, $get_current_category_parent_id) = $row;

		// Send success
		if($inp_category_parent_id == "0"){
			$url = "index.php?open=$open&page=categories&action=open_main_category&category_id=$get_current_category_id&language=$language&ft=success&fm=category_created";
		}
		else{
			$url = "index.php?open=$open&page=categories&action=open_main_category&category_id=$inp_category_parent_id&language=$language&ft=success&fm=category_created";
		}
		header("Location: $url");
		exit;
	}

	echo"
	<h1>New category</h1>

	<!-- Where am I ? -->
		<p>
		<a href=\"index.php?open=$open&amp;page=categories&amp;language=$language\">Categories</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=categories&amp;action=new_category&amp;language=$language\">New category</a>
		</p>
	<!-- //Where am I ? -->


		
	<!-- New category form -->
			
		<!-- Focus -->
		<script>
			\$(document).ready(function(){
				\$('[name=\"inp_category_name\"]').focus();
			});
		</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"index.php?open=$open&amp;page=categories&amp;action=new_category&amp;language=$language&amp;process=1\" enctype=\"multipart/form-data\">

		<p><b>Name:</b><br />
		<input type=\"text\" name=\"inp_category_name\" value=\"\" size=\"40\" />
		</p>

		<p><b>Parent:</b><br />
		<select name=\"inp_category_parent_id\">
			<option value=\"0\">This is parent</option>\n";
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_category_id, $get_category_name, $get_category_parent_id) = $row;
				echo"			";
				echo"<option value=\"$get_category_id\">$get_category_name</option>\n";
			}
		echo"
		</select>
		</p>

		<p><b>Age limit:</b><br />
		<input type=\"radio\" name=\"inp_category_age_limit\" value=\"1\" /> Yes
		<input type=\"radio\" name=\"inp_category_age_limit\" value=\"0\" checked=\"checked\" /> No
		</p>

		<p>
		<input type=\"submit\" value=\"Save\" />
		</p>

		</form>
	<!-- //New category form -->
		
	";
} // new_category
elseif($action == "sqlite_code_a"){
	echo"
	<h1>SQLite code 1</h1>

	<p>
	String categoryName = &quot;&quot;;<br /><br />
	";


	// Get all categories
	$category_count=0;
	$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;

		$category_name_lowercase = strtolower($get_main_category_name);
		$category_name_lowercase = str_replace(" ", "_", $category_name_lowercase);
		$category_name_lowercase = str_replace(",", "", $category_name_lowercase);

		// Count
		$category_count++;
		$current_parent_id = $category_count;

		echo"
		categoryName = context.getResources().getString(R.string.$category_name_lowercase);<br />
		setupInsertToCategories(&quot;NULL, '&quot; + categoryName + &quot;', '0', '', NULL&quot;);<br />
		";

		// Get sub

		$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id'";
		$resultb = mysqli_query($link, $queryb);
		while($rowb = mysqli_fetch_row($resultb)) {
			list($get_category_id, $get_category_name, $get_category_parent_id) = $rowb;

			$category_name_lowercase = strtolower($get_category_name);
			$category_name_lowercase = str_replace(" ", "_", $category_name_lowercase);
			$category_name_lowercase = str_replace(",", "", $category_name_lowercase);

			// Count
			$category_count++;


			echo"
			categoryName = context.getResources().getString(R.string.$category_name_lowercase);<br />
			setupInsertToCategories(&quot;NULL, '&quot; + categoryName + &quot;', '$current_parent_id', '', NULL&quot;);<br />
			";
		}

		echo"

		<br />
		";
	}

}
elseif($action == "sqlite_code_b"){
	echo"
	<h1>SQLite code 2</h1>

	";


	// Get all categories
	$category_count = 0;
	$insert_count = 0;
	$transfer_main_category_id = 0;
	$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;

		// Inp
		$inp_main_category_name_mysql = quote_smart($link, $get_main_category_name);

		if($insert_count == "0"){
			echo"db.execSQL(&quot;INSERT INTO food_categories(category_id, category_user_id, category_name, category_parent_id) \n&quot; +<br />
			&quot;VALUES &quot; +<br />
               		";
		}
		else{
			echo",&quot; + <br />\n";
		}

		// Insert main category
		echo"
		&quot;(NULL, '0', $inp_main_category_name_mysql, '0')";
		
		// Main count
		$insert_count++;
		$category_count++;
		$transfer_main_category_id = $category_count;

		// Get sub
		$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id'";
		$resultb = mysqli_query($link, $queryb);
		while($rowb = mysqli_fetch_row($resultb)) {
			list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;

			// Inp
			$inp_sub_category_name_mysql = quote_smart($link, $get_sub_category_name);

			if($insert_count == "0"){
				echo"db.execSQL(&quot;INSERT INTO food_categories(category_id, category_user_id, category_name, category_parent_id) \n&quot; +<br />
				&quot;VALUES &quot; +<br />
               			";
			}
			else{
				echo",&quot; + <br />\n";
			}

			// Insert sub category
			echo"
			&quot;(NULL, '0', $inp_sub_category_name_mysql, '$transfer_main_category_id')";

			// Sub count
			$insert_count++;
			$category_count++;



			// End insert count
			if($insert_count > 10){
				echo"
				&quot;)<br /><br />
				";
				$insert_count = 0;
			}
		}

		// End insert count
		if($insert_count > 10){
			echo"
			&quot;)<br /><br />
			";
			$insert_count = 0;
		}


	}

}
elseif($action == "strings"){
	echo"
	<h1>Strings</h1>

	<p>
	";


	// Get all categories
	$category_count=0;
	$language_mysql = quote_smart($link, $language);
	$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;

		$category_name_lowercase = strtolower($get_main_category_name);
		$category_name_lowercase = str_replace(" ", "_", $category_name_lowercase);
		$category_name_lowercase = str_replace(",", "", $category_name_lowercase);

		echo"
		&lt;string name=&quot;$category_name_lowercase&quot;&gt;$get_main_category_name&lt;/string&gt;<br />
		";

		// Get sub

		$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id'";
		$resultb = mysqli_query($link, $queryb);
		while($rowb = mysqli_fetch_row($resultb)) {
			list($get_category_id, $get_category_name, $get_category_parent_id) = $rowb;

			$category_name_lowercase = strtolower($get_category_name);
			$category_name_lowercase = str_replace(" ", "_", $category_name_lowercase);
			$category_name_lowercase = str_replace(",", "", $category_name_lowercase);



			echo"
			&lt;string name=&quot;$category_name_lowercase&quot;&gt;$get_category_name&lt;/string&gt;<br />
			";
		}

		echo"

		<br />
		";
	}

}
elseif($action == "translations"){
	if($process == 1){
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_name, category_age_restriction FROM $t_food_categories";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;

			$inp_category_translation_value = $_POST["inp_category_translation_value_$get_category_id"];
			$inp_category_translation_value = output_html($inp_category_translation_value);
			$inp_category_translation_value_mysql = quote_smart($link, $inp_category_translation_value);

			// Update
			$result_update = mysqli_query($link, "UPDATE $t_food_categories_translations SET category_translation_value=$inp_category_translation_value_mysql WHERE category_id=$get_category_id AND category_translation_language=$editor_language_mysql") or die(mysqli_error($link));
		}

		$url = "index.php?open=$open&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;

	}


	echo"
	<h1>Translations</h1>


	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- Select language -->

		<script>
		\$(function(){
			// bind change event to select
			\$('#inp_l').on('change', function () {
				var url = \$(this).val(); // get selected value
				if (url) { // require a URL
 					window.location = url; // redirect
				}
				return false;
			});
		});
		</script>

		<form method=\"get\" enctype=\"multipart/form-data\">
		<p>
		$l_language:
		<select id=\"inp_l\">
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_default) = $row;


				// No language selected?
				if($editor_language == ""){
						$editor_language = "$get_language_active_iso_two";
				}
				
				
				echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$get_language_active_iso_two&amp;l=$l\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
		echo"
		</select>
		</p>
		</form>
	<!-- //Select language -->

	

	<!-- Translate form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Name</span>
		   </th>
		   <th scope=\"col\">
			<span>Translation</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_name, category_age_restriction FROM $t_food_categories WHERE category_user_id='0' ORDER BY category_name ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;

			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}	

			// Translation
			$query_translation = "SELECT category_translation_id, category_translation_language, category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$editor_language_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_category_translation_id, $get_category_translation_language, $get_category_translation_value) = $row_translation;
			if($get_category_translation_id == ""){
				// It doesnt exists, create it.

				mysqli_query($link, "INSERT INTO $t_food_categories_translations
				(category_translation_id, category_id, category_translation_language, category_translation_value) 
				VALUES 
				(NULL, '$get_category_id', $editor_language_mysql, '$get_category_name')")
				or die(mysqli_error($link));

				echo"<div class=\"info\"><span>L O A D I N G</span></div>";
				echo"
 				<meta http-equiv=\"refresh\" content=\"0;URL='index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l'\" />
				";

				
			}

			echo"
			<tr>
			  <td class=\"$style\">
				<span>$get_category_name</span>
			  </td>
			  <td class=\"$style\">
				<span><input type=\"text\" name=\"inp_category_translation_value_$get_category_id\" value=\"$get_category_translation_value\" size=\"40\" /></span>
			  </td>
			</tr>
			";
		}
		echo"
		 </tbody>
		</table>

		<p>
		<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" />
		</p>
		</form>

	<!-- //List all categories -->

	<!-- Back -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn\">$l_back</a>
		</p>
	<!-- //Back -->
 	";
} // action == "";
?>