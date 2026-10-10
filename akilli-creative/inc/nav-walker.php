<?php
/**
 * Accessible nav walker with automatic mega menu.
 *
 * A top-level item whose children also have children is rendered as a mega
 * panel (columns = second level, lists = third level). Every parent item gets
 * a real <button> toggle with aria-expanded / aria-controls.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

/**
 * Walker.
 */
class Akilli_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * IDs of top-level items rendered as mega menus.
	 *
	 * @var array
	 */
	private $mega = array();

	/**
	 * Stack of parent items for start_lvl.
	 *
	 * @var array
	 */
	private $parents = array();

	/**
	 * Detect mega items before rendering.
	 *
	 * @param WP_Post $element           Item.
	 * @param array   $children_elements Children.
	 * @param int     $max_depth         Max depth.
	 * @param int     $depth             Depth.
	 * @param array   $args              Args.
	 * @param string  $output            Output.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( 0 === $depth && ! empty( $children_elements[ $element->ID ] ) ) {
			foreach ( $children_elements[ $element->ID ] as $child ) {
				if ( ! empty( $children_elements[ $child->ID ] ) ) {
					$this->mega[ $element->ID ] = true;
					break;
				}
			}
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Start sub level.
	 *
	 * @param string   $output Output.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$parent = end( $this->parents );
		$id     = 'ak-sub-' . ( $parent ? $parent->ID : wp_rand() );
		if ( 0 === $depth && $parent && isset( $this->mega[ $parent->ID ] ) ) {
			$output .= '<div class="ak-mega" id="' . esc_attr( $id ) . '"><ul class="ak-mega__grid">';
		} elseif ( 1 === $depth && $this->in_mega() ) {
			$output .= '<ul class="ak-mega__list" id="' . esc_attr( $id ) . '">';
		} else {
			$output .= '<ul class="ak-sub" id="' . esc_attr( $id ) . '">';
		}
	}

	/**
	 * End sub level.
	 *
	 * @param string   $output Output.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$parent = end( $this->parents );
		if ( 0 === $depth && $parent && isset( $this->mega[ $parent->ID ] ) ) {
			$output .= '</ul>' . $this->promo() . '</div>';
		} else {
			$output .= '</ul>';
		}
	}

	/**
	 * Whether we are inside a mega panel.
	 *
	 * @return bool
	 */
	private function in_mega() {
		return ! empty( $this->parents[0] ) && isset( $this->mega[ $this->parents[0]->ID ] );
	}

	/**
	 * Promo box inside the mega menu.
	 *
	 * @return string
	 */
	private function promo() {
		$url = akilli_url_mod( 'akilli_header_cta_url' );
		return '<div class="ak-mega__promo"><div><strong>Hangi hizmetle başlayacağınızdan emin değil misiniz?</strong><p>İhtiyacınızı anlatın; size uygun kapsamı birlikte belirleyelim.</p></div><a class="ak-btn ak-btn--primary ak-btn--sm" href="' . esc_url( $url ) . '"><span class="ak-btn__label">' . esc_html( akilli_mod( 'akilli_header_cta' ) ) . '</span>' . akilli_icon( 'arrow-right' ) . '</a></div>';
	}

	/**
	 * Start element.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item   Item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 * @param int      $id     ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$is_mega      = 0 === $depth && isset( $this->mega[ $item->ID ] );
		$in_mega      = $this->in_mega() || $is_mega;

		$li_classes = array( 'menu-item-' . $item->ID );
		if ( $has_children ) {
			$li_classes[] = 'has-children';
		}
		if ( $is_mega ) {
			$li_classes[] = 'is-mega';
		}
		if ( 1 === $depth && $in_mega ) {
			$li_classes[] = 'ak-mega__col';
		}
		foreach ( $classes as $c ) {
			if ( in_array( $c, array( 'current-menu-item', 'current-menu-ancestor', 'current-menu-parent' ), true ) || ( 0 !== strpos( $c, 'menu-item' ) && 0 !== strpos( $c, 'page_item' ) && 0 !== strpos( $c, 'page-item' ) && $c ) ) {
				$li_classes[] = $c;
			}
		}
		$output .= '<li class="' . esc_attr( implode( ' ', array_unique( array_filter( $li_classes ) ) ) ) . '">';

		$atts = array(
			'href'   => ! empty( $item->url ) ? $item->url : '',
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : ( '_blank' === $item->target ? 'noopener' : '' ),
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
		);
		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$atts['aria-current'] = 'page';
		}
		if ( 1 === $depth && $in_mega ) {
			$atts['class'] = 'ak-mega__title';
		}
		$attr_html = '';
		foreach ( $atts as $k => $v ) {
			if ( '' !== $v ) {
				$attr_html .= ' ' . $k . '="' . ( 'href' === $k ? esc_url( $v ) : esc_attr( $v ) ) . '"';
			}
		}
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$icon  = '';
		if ( 1 === $depth && $in_mega && 'ak_hizmet' === $item->object ) {
			$key  = get_post_meta( (int) $item->object_id, '_ak_icon', true );
			$icon = akilli_icon( $key ? $key : 'spark' );
		}
		$output .= '<a' . $attr_html . '>' . $icon . '<span>' . esc_html( $title ) . '</span></a>';

		if ( $has_children ) {
			$output .= '<button type="button" class="ak-sub-toggle" aria-expanded="false" aria-controls="ak-sub-' . esc_attr( $item->ID ) . '"><span class="screen-reader-text">' . esc_html( sprintf( '%s alt menüsünü aç', $title ) ) . '</span>' . akilli_icon( 'chevron-down' ) . '</button>';
			$this->parents[] = $item;
		}
	}

	/**
	 * End element.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item   Item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			array_pop( $this->parents );
		}
		$output .= '</li>';
	}
}

/**
 * Resolve a URL theme mod (relative paths become home URLs).
 *
 * @param string $key Mod key.
 * @return string
 */
function akilli_url_mod( $key ) {
	$url = (string) akilli_mod( $key );
	if ( $url && 0 === strpos( $url, '/' ) && 0 !== strpos( $url, '//' ) ) {
		return home_url( $url );
	}
	return $url ? $url : home_url( '/' );
}

/**
 * Fallback menu when no primary menu is assigned yet.
 */
function akilli_nav_fallback() {
	echo '<ul class="ak-nav__list">';
	$pages = get_pages(
		array(
			'sort_column' => 'menu_order',
			'parent'      => 0,
			'number'      => 7,
		)
	);
	foreach ( $pages as $p ) {
		if ( (int) get_option( 'page_on_front' ) === $p->ID ) {
			continue;
		}
		echo '<li><a href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( get_the_title( $p ) ) . '</a></li>';
	}
	echo '</ul>';
}
