<?php

/**
 * default.tmpl.php - Default template for the Lyquix Filters block
 *
 * @version     3.0.0
 * @package     wp_theme_lyquix
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2018 Lyquix
 * @license     GNU General Public License version 2 or later
 * @link        https://github.com/Lyquix/wp_theme_lyquix
 */

//    .d8888b. 88888888888 .d88888b.  8888888b.   888
//   d88P  Y88b    888    d88P" "Y88b 888   Y88b  888
//   Y88b.         888    888     888 888    888  888
//    "Y888b.      888    888     888 888   d88P  888
//       "Y88b.    888    888     888 8888888P"   888
//         "888    888    888     888 888         Y8P
//   Y88b  d88P    888    Y88b. .d88P 888          "
//    "Y8888P"     888     "Y88888P"  888         888
//
//  DO NOT MODIFY THIS FILE!
//  Instead, copy it to /php/custom/blocks/filters/default.tmpl.php to override it
//  You may also create overrides for specific presets, by copying this file to /php/custom/blocks/filters/{preset}.tmpl.php

?>
<section
	id="<?= esc_attr($s['anchor']) ?>"
	class="lqx-block-filters <?= esc_attr($s['class']) ?>">

	<div
		class="filters"
		id="<?= esc_attr($s['hash']) ?>"
		data-settings="<?= esc_attr(json_encode(\lqx\filters\prepare_json_data($s))) ?>">

		<?php
		switch ($s['render_mode']) {
			case 'php':
				require \lqx\blocks\get_template('filters', $s['preset'], 'controls');
				require \lqx\blocks\get_template('filters', $s['preset'], 'posts');
				require \lqx\blocks\get_template('filters', $s['preset'], 'pagination');
				break;

			case 'js':
				require \lqx\blocks\get_template('filters', $s['preset'], 'js');
				break;
		}
		?>

	</div>

</section>
