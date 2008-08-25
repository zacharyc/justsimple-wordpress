<?php
if ( function_exists('register_sidebar') )
	register_sidebar();

// helper functions
	$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' and post_status = 'publish'");
		if (0 < $numposts) $numposts = number_format($numposts); 

	$numcmnts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
		if (0 < $numcmnts) $numcmnts = number_format($numcmnts);	
// ----------------


function justsimple_add_theme_page() {

	if ( $_GET['page'] == basename(__FILE__) ) {
	
	    // save settings
		if ( 'save' == $_REQUEST['action'] ) {

			update_option( 'justsimple_asideid', $_REQUEST[ 's_asideid' ] );
			update_option( 'justsimple_sortpages', $_REQUEST[ 's_sortpages' ] );
			if( isset( $_POST[ 'excludepages' ] ) ) { update_option( 'justsimple_excludepages', implode(',', $_POST['excludepages']) ); } else { delete_option( 'justsimple_excludepages' ); }
			// goto theme edit page
			header("Location: themes.php?page=functions.php&saved=true");
			die;

  		// reset settings
		} else if( 'reset' == $_REQUEST['action'] ) {

			delete_option( 'justsimple_asideid' );
			delete_option( 'justsimple_sortpages' );			
			delete_option( 'justsimple_excludepages' );
			
			
			// goto theme edit page
			header("Location: themes.php?page=functions.php&reset=true");
			die;

		}
	}


    add_theme_page("JustSimple Options", "JustSimple Options", 'edit_themes', basename(__FILE__), 'justsimple_theme_page');

}

function justsimple_theme_page() {

	// --------------------------
	// JustSimple theme page content
	// --------------------------

	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>JustSimple Theme: Settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>JustSimple Theme: Settings reset.</strong></p></div>';
	
?>
<style>
	.wrap { border:#ccc 1px dashed;}
	.block { margin:1em;padding:1em;line-height:1.6em;}
	table tr td {border:#ddd 1px solid;font-family:Verdana, Arial, Serif;font-size:0.9em;}
	h4 {font-size:1.3em;color:#969669;font-weight:bold;margin:0;padding:10px 0;}	
</style>
<div class="wrap">

<h2>justsimple 2.0</h2>

<div class="block"><h4>Theme Page: <a href="http://wpthemespot.com/themes/justsimple/">JustSimple</a> </h4> 
					<h4>Designed & Developed by: <a href="http://wpthemespot.com/" target="_blank">WP ThemeSpot</a></h4>
					
</div>


<form method="post">


<!-- blog layout options -->
<fieldset class="options">
<legend>Theme Settings</legend>

<p>Change the way your blog looks and acts with the many blog settings below</p>

<table width="100%" cellspacing="5" cellpadding="10" class="editform">
<tr>
<td valign="top" colspan="2" style="border:0px;margin:0;padding:0;">
	<input type="hidden" name="action" value="save" />
	<?php gf_input( "save", "submit", "", "Save Settings" );?>
</td>
</tr>
<script>
function updateStyle( newStyle ) {	
	document.getElementById( 'StylePreview' ).className = "SP_" + newStyle;
}
</script>
<tr valign="top">
<td align="left">
	<?php
	gf_heading("List Pages / Navigation");		
		global $wpdb;
		$results = $wpdb->get_results("SELECT ID, post_title from $wpdb->posts WHERE post_type='page' AND post_parent=0 ORDER BY post_title");
		$excludepages = explode(',', get_settings('justsimple_excludepages'));
		
		if($results) {				
			_e('<br/>Exclude the Following Pages from the Top Navigation <br/><br/>');
			foreach($results as $page) {
				echo '<input type="checkbox" name="excludepages[]" value="' . $page->ID . '"';
				if(in_array($page->ID, $excludepages)) { echo ' checked="checked"'; }
				echo ' /> <a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a><br />';
			}		
		}
		_e('<br/><br/>');
		echo "<br/><strong> Sort the List Pages by </strong><br/>";
		
		gf_input( "s_sortpages", "radio", "Page Title ?", "post_title", get_settings( 'justsimple_sortpages' ) );		
		gf_input( "s_sortpages", "radio", "Date ?", "post_date", get_settings( 'justsimple_sortpages' ) );		
		gf_input( "s_sortpages", "radio", "Page Order ?", "menu_order", get_settings( 'justsimple_sortpages' ) );
		echo "(Each Page can be given a page order number, from the wordpress admin, edit page area)";
		echo "<br/>";			
?>
</td>
<td>
<?php
	gf_heading( "Support for Asides / Side Notes" );	
	echo "Asides are the 'quick bits' of information you want to post. They do not have to look like a regular post.";
	echo "<br/><br/>Learn More at <a href='http://photomatt.net/2004/05/19/asides/'>Matt's Asides technique</a>";
?>
	<?php
		global $wpdb;
		$id = get_option('justsimple_asideid');
		if ($id != 0) {
		$asides_title = $wpdb->get_var("SELECT cat_name from $wpdb->categories WHERE cat_ID = $id");
		} else {
			$asides_title='NOT SELECTED';
			}
		$asides_cats = $wpdb->get_results("SELECT * from $wpdb->categories WHERE category_count > 0");
	?>
			<p>Select the category here. Any posts under this category will look like an Aside.</p>
			<select name="s_asideid" id="s_asideid">
				<option value="<?php echo get_option('justsimple_asideid'); ?>"><?php echo $asides_title; ?></option>
				<option value="-----">----</option>
				<option value="0">NOT SELECTED</option>
			<?php
				foreach ($asides_cats as $cat) {
					echo '<option value="' . $cat->cat_ID . '">' . $cat->cat_name . '</option>';
	          }
	          ?>
		</select>	
</td>

</td>
</tr>	
<tr>
<td valign="top" colspan="2" style="border:0px;margin:0;padding:0;">
	<input type="hidden" name="action" value="save" />
	<?php gf_input( "save", "submit", "", "Save Settings" );?>
</td>
</tr>
</table>
</fieldset>
</form>

<form method="post">

<fieldset class="options">
<legend>Reset</legend>

<p>If for some reason you want to uninstall "JustSimple" then press the reset button to clean things up in the database.</p>
<p>You have to make sure to delete the theme folder, if you want to completely remove the theme.</p>
<?php

	gf_input( "reset", "submit", "", "Reset Settings" );
	
?>

</div>
<input type="hidden" name="action" value="reset" />
</form>

<?php
}
add_action('admin_menu', 'justsimple_add_theme_page');


function gf_input( $var, $type, $description = "", $value = "", $selected="" ) {

	// ------------------------
	// add a form input control
	// ------------------------
	
 	echo "\n";
 	
	switch( $type ){
	
	    case "text":

	 		echo "<input name=\"$var\" id=\"$var\" type=\"$type\" style=\"width: 60%\" class=\"textbox\" value=\"$value\" />";
			
			break;
			
		case "submit":
		
	 		echo "<p class=\"submit\"><input name=\"$var\" type=\"$type\" value=\"$value\" /></p>";

			break;

		case "option":
		
			if( $selected == $value ) { $extra = "selected=\"true\""; }

			echo "<option value=\"$value\" $extra >$description</option>";
		
		    break;
  		case "radio":
  		
			if( $selected == $value ) { $extra = "checked=\"true\""; }
  		
  			echo "<label><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";
  			
  			break;
  			
		case "checkbox":
		
			if( $selected == $value ) { $extra = "checked=\"true\""; }

  			echo "<label for=\"$var\"><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";

  			break;

		case "textarea":
		
		    echo "<textarea name=\"$var\" id=\"$var\" style=\"width: 80%; height: 10em;\" class=\"code\">$value</textarea>";
		
		    break;
	}

}

function gf_heading( $title ) {

	// ------------------
	// add a table header
	// ------------------

   echo "<h4>" .$title . "</h4>";

}
?>