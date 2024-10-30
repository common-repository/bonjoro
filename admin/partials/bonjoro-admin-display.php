<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.bonjoro.com
 * @since      1.0.0
 *
 * @package    Bonjoro
 * @subpackage Bonjoro/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1>Bonjoro</h1>

<form action='options.php' method='post'> 
	<?php
 settings_fields("bonjoro_plugin_options");
 do_settings_sections("bonjoro");
 ?>

	<button><?php esc_attr_e("Save"); ?></button>
</form>
