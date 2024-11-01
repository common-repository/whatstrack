<?php
/**
 * Plugin Name: WhatsTrack
 * Description: The Whatsapp icon will scroll on the right side of your website and allow the visitor to contact you on Whatsapp. Not only that you will also be able to track it on Google Analytics
 * Version: 1.0.3
 * Author: Adeel Sarfraz
 * Author URI: https://www.adeelsarfaraz.com
 */

function whatstrack_setup()
{
    add_menu_page(__('WhatsTrack', 'whatstrack'), __('WhatsTrack', 'whatstrack'), 8, basename(__FILE__), 'whatstrack_settings_page', plugin_dir_url(__FILE__) . 'img/wh-icon.ico');
	//call register settings function
	add_action( 'admin_init', 'whatstrack_settings' );
}

function whatstrack_settings() {
	//register our settings
	register_setting( 'whatstrack-group', 'whatstrack_number' );
	register_setting( 'whatstrack-group', 'whatstrack_text' );	
}

function whatstrack_settings_page() {
?>
<div class="wrap">
<h1>WhatsTrack</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'whatstrack-group' ); ?>
    <?php do_settings_sections( 'whatstrack-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Whatsapp ID</th>
        <td><input type="text" name="whatstrack_number" value="<?php echo esc_attr( get_option('whatstrack_number') ); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Whatsapp Text</th>
        <td><input type="text" name="whatstrack_text" placeholder="Enter any text to notify yourself" value="<?php echo esc_attr( get_option('whatstrack_text') ); ?>" /></td>
        </tr>        
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php } 

function add_whatstrack_code()
{
	echo '<a href="https://api.whatsapp.com/send?phone='.esc_attr(get_option('whatstrack_number')).'&amp;text='.esc_attr(get_option('whatstrack_text')).'" onclick="gtag(\'event\', \'click\', {\'event_category\': \'Whatsapp\',\'event_label\': document.location.href,\'transport_type\': \'beacon\'});" target="_blank"><img class="imgWhatsTrack" src="'. plugin_dir_url( __FILE__ ) . 'images/whatsapp_track_logo.png" border="0" /></a>';
    echo '<style type="text/css">.imgWhatsTrack{position:fixed; bottom:15px; right:15px; z-index:100000;}</style>';
}

// Add settings page and register settings with WordPress
add_action('admin_menu', 'whatstrack_setup');
// Add the code to footer
add_action('wp_footer', 'add_whatstrack_code');
