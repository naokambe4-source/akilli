<?php
/**
 * Inline SVG icon set (original, stroke based, 24×24). Shared by plugin and theme.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'akilli_icon_paths' ) ) {
	/**
	 * Icon path data.
	 *
	 * @return array
	 */
	function akilli_icon_paths() {
		return array(
			'arrow-right'    => '<path d="M4 12h15M13 6l6 6-6 6"/>',
			'arrow-up-right' => '<path d="M7 17 17 7M8 7h9v9"/>',
			'arrow-down'     => '<path d="M12 4v15M6 13l6 6 6-6"/>',
			'phone'          => '<path d="M5 3.5h3.2l1.6 4.2-2.1 1.4a11.5 11.5 0 0 0 5.2 5.2l1.4-2.1 4.2 1.6V17a2.5 2.5 0 0 1-2.7 2.5C10 19 5 14 4.5 6.2A2.5 2.5 0 0 1 5 3.5Z"/>',
			'whatsapp'       => '<path d="M4.5 19.5l1.2-3.6A8 8 0 1 1 8.4 18.4Z"/><path d="M9.2 8.6c.2 2.7 2.1 4.8 5 5.4l.9-1.2 1.6.8c-.2 1.1-1.1 1.8-2.2 1.7-3.6-.5-6.2-3.1-6.7-6.6-.1-1.1.6-2 1.7-2.2l.8 1.6Z"/>',
			'mail'           => '<rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="m4 7 8 6 8-6"/>',
			'map-pin'        => '<path d="M12 21s-6.5-5.6-6.5-11A6.5 6.5 0 0 1 18.5 10c0 5.4-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/>',
			'clock'          => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>',
			'instagram'      => '<rect x="4" y="4" width="16" height="16" rx="4.5"/><circle cx="12" cy="12" r="3.6"/><circle cx="16.8" cy="7.2" r=".6" fill="currentColor"/>',
			'linkedin'       => '<rect x="4" y="4" width="16" height="16" rx="2.5"/><path d="M8 10.5V16M8 8v.01M11.5 16v-3.2c0-1.4.9-2.3 2.1-2.3s1.9.9 1.9 2.3V16M11.5 10.5V16"/>',
			'facebook'       => '<path d="M14.5 8H16V4.8h-2.2C11.6 4.8 10.5 6.2 10.5 8.4V10H8.5v3h2v7h3v-7h2.3l.5-3h-2.8V8.7c0-.5.2-.7 1-.7Z"/>',
			'youtube'        => '<rect x="3" y="6" width="18" height="12" rx="3.5"/><path d="m10.5 9.5 4 2.5-4 2.5Z"/>',
			'x'              => '<path d="M5 4.5 19 19.5M19 4.5 5 19.5"/>',
			'search'         => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4 4"/>',
			'menu'           => '<path d="M4 8h16M4 16h16"/>',
			'close'          => '<path d="M6 6l12 12M18 6 6 18"/>',
			'plus'           => '<path d="M12 5v14M5 12h14"/>',
			'minus'          => '<path d="M5 12h14"/>',
			'check'          => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
			'chevron-down'   => '<path d="m6 9 6 6 6-6"/>',
			'external'       => '<path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
			'play'           => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 5.5 3.5-5.5 3.5Z"/>',
			'web'            => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="M3 9h18M6.5 6.8h.01M9 6.8h.01"/>',
			'cart'           => '<path d="M3.5 4.5h2.2l2 10.5h10l2-7.5H7"/><circle cx="9" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>',
			'pen'            => '<path d="M4 20l1-4.5L15.5 5a2.1 2.1 0 0 1 3 3L8 18.5Z"/><path d="m13.5 7 3 3"/>',
			'growth'         => '<path d="M4 19h16"/><path d="m5 15 4.5-4.5 3 3L19 7"/><path d="M14.5 7H19v4.5"/>',
			'code'           => '<path d="m8.5 8-4 4 4 4M15.5 8l4 4-4 4M13.5 5.5l-3 13"/>',
			'spark'          => '<path d="M12 3.5 13.8 10l6.7 2-6.7 2L12 20.5 10.2 14l-6.7-2 6.7-2Z"/>',
			'layers'         => '<path d="m12 4 8.5 4.5L12 13 3.5 8.5Z"/><path d="m3.5 12.5 8.5 4.5 8.5-4.5M3.5 16.5 12 21l8.5-4.5"/>',
			'shield'         => '<path d="M12 3.5 19 6v5.5c0 4.6-3 7.7-7 9-4-1.3-7-4.4-7-9V6Z"/><path d="m9 12 2 2 4-4"/>',
			'chat'           => '<path d="M4.5 18.5V7a2.5 2.5 0 0 1 2.5-2.5h10A2.5 2.5 0 0 1 19.5 7v6a2.5 2.5 0 0 1-2.5 2.5H8Z"/><path d="M8.5 9.5h7M8.5 12.5h4"/>',
			'target'         => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r=".8" fill="currentColor"/>',
			'compass'        => '<circle cx="12" cy="12" r="8.5"/><path d="m15.5 8.5-2 5-5 2 2-5Z"/>',
			'rocket'         => '<path d="M13.5 5.5c2.5-1.5 5-1.5 5-1.5s0 2.5-1.5 5l-5.5 5.5-3.5-3.5Z"/><path d="M8 10.5H5l2.5-2.5h3.5M13.5 16v3l2.5-2.5V13M7 15.5c-1.5.5-2.5 2-2.5 4 2 0 3.5-1 4-2.5"/>',
			'tooth'          => '<path d="M8 4c1.6 0 2.4.8 4 .8S14.4 4 16 4c2.5 0 3.8 2.3 3.2 5-.4 1.9-1.3 3.2-1.7 5.2-.5 2.6-1 5.8-2.5 5.8-1.6 0-1.4-4.5-3-4.5s-1.4 4.5-3 4.5c-1.5 0-2-3.2-2.5-5.8C6.1 12.2 5.2 10.9 4.8 9 4.2 6.3 5.5 4 8 4Z"/>',
			'scale'          => '<path d="M12 4v16M7 20h10M5 7.5h14M12 4.5l-.01.01"/><path d="m5 7.5-2.5 6h5Zm14 0-2.5 6h5Z"/>',
			'heart'          => '<path d="M12 19.5s-7.5-4.3-7.5-9.7A4.3 4.3 0 0 1 12 7.2a4.3 4.3 0 0 1 7.5 2.6c0 5.4-7.5 9.7-7.5 9.7Z"/>',
			'card'           => '<rect x="3" y="5.5" width="18" height="13" rx="2.2"/><path d="M3 10h18M7 15h4"/>',
			'plug'           => '<path d="M9 3.5V8M15 3.5V8M7 8h10v3.5a5 5 0 0 1-10 0ZM12 16.5v4"/>',
			'palette'        => '<path d="M12 3.5a8.5 8.5 0 1 0 0 17c1.3 0 1.8-.9 1.4-1.9-.5-1.2.3-2.4 1.6-2.4h1.5a4 4 0 0 0 4-4c0-4.9-3.8-8.7-8.5-8.7Z"/><circle cx="8" cy="11" r="1"/><circle cx="11" cy="7.5" r="1"/><circle cx="15.5" cy="8.5" r="1"/>',
			'megaphone'      => '<path d="M4 10v4h3l7 4V6l-7 4Z"/><path d="M17.5 9a4 4 0 0 1 0 6M7 14l1.5 5h2.5l-1-4.5"/>',
			'users'          => '<circle cx="9" cy="9" r="3.2"/><path d="M3.5 19c.5-3 2.8-4.8 5.5-4.8s5 1.8 5.5 4.8"/><path d="M15.5 6.2a3 3 0 0 1 0 5.6M17 14.5c1.9.5 3.2 2 3.5 4.5"/>',
			'plane'          => '<path d="m3.5 13 17-7.5L16 20l-4.5-5-8-2Z"/><path d="m11.5 15 9-9.5"/>',
			'figma'          => '<path d="M9 3.5h3v6H9a3 3 0 0 1 0-6ZM12 3.5h3a3 3 0 0 1 0 6h-3ZM9 9.5h3v6H9a3 3 0 0 1 0-6ZM9 15.5h3v2a3 3 0 1 1-3-2Z"/><circle cx="15" cy="12.5" r="3"/>',
			'id'             => '<rect x="3.5" y="5" width="17" height="14" rx="2.2"/><circle cx="9" cy="11" r="2.2"/><path d="M5.8 16c.5-1.5 1.7-2.3 3.2-2.3s2.7.8 3.2 2.3M14.5 10h3.5M14.5 13h2.5"/>',
			'image'          => '<rect x="3.5" y="4.5" width="17" height="15" rx="2.2"/><circle cx="9" cy="9.5" r="1.7"/><path d="m4 17 5-5 4 4 2.5-2.5L20 18"/>',
			'wordpress'      => '<circle cx="12" cy="12" r="8.5"/><path d="M5.5 9.5 9.5 19M8 9.5h3.5M13.5 9.5H17M11 9.5l3.5 9.5 3-8"/>',
			'gear'           => '<circle cx="12" cy="12" r="3"/><path d="M12 3.5v2.3M12 18.2v2.3M3.5 12h2.3M18.2 12h2.3M6 6l1.6 1.6M16.4 16.4 18 18M6 18l1.6-1.6M16.4 7.6 18 6"/>',
			'quote'          => '<path d="M5 17.5v-4c0-3.5 1.5-6 4.5-7M14 17.5v-4c0-3.5 1.5-6 4.5-7"/><path d="M5 13.5h4v4H5zM14 13.5h4v4h-4z"/>',
		);
	}
}

if ( ! function_exists( 'akilli_icon' ) ) {
	/**
	 * Return inline SVG markup for an icon (decorative, aria-hidden).
	 *
	 * @param string $name  Icon key.
	 * @param string $class Extra class.
	 * @return string
	 */
	function akilli_icon( $name, $class = '' ) {
		$paths = akilli_icon_paths();
		if ( ! isset( $paths[ $name ] ) ) {
			$name = 'spark';
		}
		return '<svg class="ak-icon ' . esc_attr( $class ) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
	}
}
