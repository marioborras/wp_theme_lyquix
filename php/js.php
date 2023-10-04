<?php

/**
 * js.php - Includes JavaScript libraries
 *
 * @version     3.0.0
 * @package     wp_theme_lyquix
 * @author      Lyquix
 * @copyright   Copyright (C) 2015 - 2017 Lyquix
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

namespace lqx\js;

function enqueue_scripts() {
	// Prevent adding js libraries in wp_head()
	global $wp_scripts, $tmpl_url, $tmpl_path;
	$remove_js_libraries = explode("\n", trim(get_theme_mod('remove_js_libraries', '')));
	foreach ($wp_scripts->queue as $i => $js) {
		if (array_search(trim($js), $remove_js_libraries)) unset($wp_scripts->queue[$i]);
	}

	// Enable jQuery
	if (get_theme_mod('enable_jquery', '1')) {
		wp_enqueue_script('jquery');
	} else {
		wp_dequeue_script('jquery');
	}

	// Enable jQuery UI
	if (get_theme_mod('enable_jquery_ui', '0')) {
		wp_enqueue_script('jquery-ui-core');
		if (get_theme_mod('enable_jquery_ui') == 2) wp_enqueue_script('jquery-ui-sortable');
	} else {
		wp_dequeue_script('jquery-ui-core');
		wp_dequeue_script('jquery-ui-sortable');
	}

	// Array to store all scripts to be loaded
	$scripts = [];

	// Use non minified version?
	$non_min_js = get_theme_mod('non_min_js', '0');

	// MobileDetect
	$scripts[] = [
		'handle' => 'mobile-detect',
		'url' => 'https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.5/mobile-detect' . ($non_min_js ? '' : '.min') . '.js',
		'version' => '1.4.5'
	];

	// Day.js
	if (get_theme_mod('dayjs', 0)) {
		$scripts[] = [
			'handle' => 'dayjs',
			'url' => 'https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/dayjs' . ($non_min_js ? '' : '.min') . '.js',
			'version' => '1.11.9'
		];
		$scripts[] = [
			'handle' => 'dayjs-locale-en',
			'url' => 'https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/locale/en' . ($non_min_js ? '' : '.min') . '.js',
			'version' => '1.11.9'
		];
	}

	// Additional JS Libraries
	$add_js_libraries = explode("\n", trim(get_theme_mod('add_js_libraries', '')));
	foreach ($add_js_libraries as $jsurl) {
		$jsurl = trim($jsurl);
		if ($jsurl) {
			// Check if script is local or remote
			if (parse_url($jsurl, PHP_URL_SCHEME)) {
				// Absolute URL
				$scripts[] = [
					'url' => $jsurl
				];
			} elseif (parse_url($jsurl, PHP_URL_PATH)) {
				// Relative URL
				// Add leading / if missing
				if (substr($jsurl, 0, 1) != '/') $jsurl = '/' . $jsurl;
				// Check if file exist
				if (file_exists(ABSPATH . $jsurl)) {
					$scripts[] = [
						'url' => $jsurl,
						'version' => date("YmdHis", filemtime(get_home_path() . $jsurl))
					];
				}
			}
		}
	}

	// Lyquix
	$scripts[] = [
		'handle' => 'lyquix',
		'url' => $tmpl_url . '/js/lyquix' . ($non_min_js ? '' : '.min') . '.js',
		'version' => date("YmdHis", filemtime($tmpl_path . '/js/lyquix' . ($non_min_js ? '' : '.min') . '.js'))
	];

	// Vue
	if (file_exists($tmpl_path . '/js/vue.js')) {
		$scripts[] = [
			'handle' => 'vue',
			'url' => 'https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global' . ($non_min_js ? '' : '.prod') . '.js'
		];
		$scripts[] = [
			'handle' => 'lyquix-vue',
			'url' => $tmpl_url . '/js/vue' . ($non_min_js ? '' : '.min') . '.js',
			'version' => date("YmdHis", filemtime($tmpl_path . '/js/vue' . ($non_min_js ? '' : '.min') . '.js'))
		];
	}

	// Scripts
	if (file_exists($tmpl_path . '/js/scripts.js')) {
		$scripts[] = [
			'handle' => 'scripts',
			'url' => $tmpl_url . '/js/scripts' . ($non_min_js ? '' : '.min') . '.js',
			'version' => date("YmdHis", filemtime($tmpl_path . '/js/scripts' . ($non_min_js ? '' : '.min') . '.js'))
		];
	}

	// Queue styles
	foreach ($scripts as $js_url) {
		wp_enqueue_script($js_url['handle'], $js_url['url'], [], array_key_exists('version', $js_url) ? $js_url['version'] : null, true);
	}
}
add_action('wp_enqueue_scripts', 'lqx\js\enqueue_scripts', 100);


function render_lyquix_options() {
	global $site_abs_url, $tmpl_url;

	// Set lqx options
	$lqx_options = [
		'debug' => get_theme_mod('lqx_debug', '0'),
		'siteURL' => $site_abs_url,
		'tmplURL' => $tmpl_url
	];

	if (get_theme_mod('ga_account', '') || get_theme_mod('ga4_account', '')) {
		$lqx_options['analytics'] = [
			'trackingId' => get_theme_mod('ga_account'),
			'measurementId' => get_theme_mod('ga4_account')
		];
	}

	if (!get_theme_mod('ga_pageview', '1')) $lqx_options['analytics']['sendPageview'] = false;
	if (get_theme_mod('ga_via_gtm', '0')) $lqx_options['analytics']['usingGTM'] = true;
	if (!get_theme_mod('ga_use_analytics_js', '1')) $lqx_options['analytics']['useAnalyticsJS'] = false;

	// Merge with options from template settings
	$theme_lqx_options = json_decode(get_theme_mod('lqx_options'), true);
	if (!$theme_lqx_options) $theme_lqx_options = [];
	$lqx_options = array_replace_recursive($lqx_options, $theme_lqx_options);
	$theme_script_options = json_decode(get_theme_mod('scripts_options'), true);
	if (!$theme_script_options) $theme_script_options = [];
	$scripts_options = array_replace_recursive([], $theme_script_options);

	echo '<script>lqx.init(JSON.parse(\'' . json_encode($lqx_options) . '\')); $lqx.init(JSON.parse(\'' . json_encode($scripts_options) . '\'));</script>' . "\n";
}

function render_gtm_head_code() {
	// Load GTM head code
	if (get_theme_mod('gtm_account', '')) {
?>
		<!-- Google Tag Manager -->
		<script>
			(function(w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start': new Date().getTime(),
					event: 'gtm.js'
				});
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', '<?= get_theme_mod('gtm_account') ?>');
		</script>
		<!-- End Google Tag Manager -->
	<?
	}
}

function render_gtm_body_code() {
	// Load GTM head code
	if (get_theme_mod('gtm_account', '')) {
	?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= get_theme_mod('gtm_account') ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
<?
	}
}
