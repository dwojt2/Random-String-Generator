<?php
/*
Plugin Name: Random String Generator
Description: Generates a random 3-letter and 3-number string. Use: [random_string]
Version: 3.2
Author: Dominik Wojtysiak
License: MIT
*/

// Register a shortcode
function cwpai_random_string_shortcode($atts) {
    $atts = shortcode_atts(array(
        'length' => 4 // Set initial length to a default of 4
    ), $atts);

  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $characters_length = strlen($characters);
  $str = '';

    // Generate random string with specified length
    for ($i = 0; $i < $atts['length']; $i++) {
        $str .= $characters[rand(0, $characters_length - 1)];
    }


    return $str;
}
add_shortcode('random_string', 'cwpai_random_string_shortcode');
//[random_string] can be used to output the generated string on any page or post.

// Settings page
function cwpai_random_string_settings_page() {
    // Retrieve current length from database
    $length = get_option('cwpai_random_string_length', 4);

    if (isset($_POST['submit'])) {
        // Update length if form is submitted
        $new_length = (int)$_POST['length'];
        update_option('cwpai_random_string_length', $new_length);
    }
    ?>
    <div class="wrap">
        <h1>Random String Generator Settings</h1>
        <br>
        <form method="post" action="">
            <label for="length">String Length:</label>
            <input type="number" name="length" id="length" value="<?php echo $length; ?>" min="1" max="10" required>
            <br>
            <br>
            <br>
            <input type="submit" name="submit" value="Save Settings" class="button-primary">
        </form>
    </div>

    <?php
}

function cwpai_random_string_settings_menu() {
    add_options_page('Random String Generator', 'Random String Generator', 'manage_options', 'cwpai-random-string', 'cwpai_random_string_settings_page');
}
add_action('admin_menu', 'cwpai_random_string_settings_menu');

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/dwojt2/Random-String-Generator',
	__FILE__,
	'random_string_generator'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

?>


