<?php

function thegem_title_post_type_init() {
	$labels = array(
		'name'               => __('Titles', 'thegem'),
		'singular_name'      => __('Titler', 'thegem'),
		'menu_name'          => __('Custom Titles', 'thegem'),
		'name_admin_bar'     => __('Title', 'thegem'),
		'add_new'            => __('Add New', 'thegem'),
		'add_new_item'       => __('Add New Title', 'thegem'),
		'new_item'           => __('New Title', 'thegem'),
		'edit_item'          => __('Edit Title', 'thegem'),
		'view_item'          => __('View Title', 'thegem'),
		'all_items'          => __('All Titles', 'thegem'),
		'search_items'       => __('Search Titles', 'thegem'),
		'not_found'          => __('No titles found.', 'thegem'),
		'not_found_in_trash' => __('No titles found in Trash.', 'thegem')
	);

	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'exclude_from_search'  => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'query_var'            => false,
		'hierarchical'         => false,
		'supports'             => array('title', 'editor'),
		'menu_position'        => 39
	);

	register_post_type('thegem_title', $args);
}
add_action('init', 'thegem_title_post_type_init', 5);

function thegem_force_title_type_private($post) {
	if ($post['post_type'] == 'thegem_title' && $post['post_status'] != 'trash') {
		$post['post_status'] = 'private';
	}
	return $post;
}
add_filter('wp_insert_post_data', 'thegem_force_title_type_private');

function thegem_custom_title_shortcodes_array($shortcodes) {
	global $pagenow;
	if((is_admin() && in_array($pagenow, array('post-new.php', 'post.php', 'admin-ajax.php'))) || (!is_admin() && in_array($pagenow, array('index.php')))) {
		$activate = 0;
		if($pagenow === 'post-new.php' && !empty($_REQUEST['post_type']) && $_REQUEST['post_type'] === 'thegem_title') {
			$activate = true;
		}
		if($pagenow === 'post.php' && !empty($_REQUEST['post']) && get_post_type($_REQUEST['post']) === 'thegem_title') {
			$activate = true;
		}
		if($pagenow === 'post.php' && !empty($_REQUEST['post_id']) && get_post_type($_REQUEST['post_id']) === 'thegem_title') {
			$activate = true;
		}
		if($pagenow === 'admin-ajax.php' && !empty($_REQUEST['post_id']) && get_post_type($_REQUEST['post_id']) === 'thegem_title') {
			$activate = true;
		}
		if($pagenow === 'index.php' && !empty($_REQUEST['vc_post_id']) && get_post_type($_REQUEST['vc_post_id']) === 'thegem_title') {
			$activate = true;
		}
		if($activate) {
			$shortcodes['gem_title_title'] = array(
				'name' => __('Title', 'thegem'),
				'base' => 'gem_title_title',
				'icon' => 'thegem-icon-wpb-ui-title-title',
				'category' => __('Custom Page Title', 'thegem'),
				'description' => __('Custom Title - Title', 'thegem'),
				'weight' => 10,
				'params' => array_merge(array(
					array(
						'type' => 'checkbox',
						'heading' => __('Disable automatic page / post title', 'thegem'),
						'param_name' => 'use_shortcode_data',
						'value' => array(__('Yes', 'thegem') => '1'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Type', 'thegem'),
						'param_name' => 'type',
						'value' => array(__('Simple text', 'thegem') => 'sipmle', __('Rich text', 'thegem') => 'rich'),
						'dependency' => array(
							'element' => 'use_shortcode_data',
							'not_empty' => true
						),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Text', 'thegem'),
						'param_name' => 'text',
						'dependency' => array(
							'element' => 'type',
							'value' => 'sipmle'
						),
					),
					array(
						'type' => 'textarea_html',
						'heading' => __('Content', 'thegem'),
						'param_name' => 'content',
						'dependency' => array(
							'element' => 'type',
							'value' => 'rich'
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Color', 'thegem'),
						'param_name' => 'color',
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Alignment', 'thegem'),
						'param_name' => 'alignment',
						'value' => array(__('Left', 'thegem') => 'left', __('Right', 'thegem') => 'right', __('Center', 'thegem') => 'center'),
					),
					array(
						'type' => 'checkbox',
						'heading' => __('xLarge text', 'thegem'),
						'param_name' => 'xlarge',
						'value' => array(__('Yes', 'thegem') => '1'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Max width', 'thegem'),
						'param_name' => 'width',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin top', 'thegem'),
						'param_name' => 'margin_top',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin bottom', 'thegem'),
						'param_name' => 'margin_bottom',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Extra Class', 'thegem'),
						'param_name' => 'extra_class',
					),
				)),
			);
			$shortcodes['gem_title_excerpt'] = array(
				'name' => __('Excerpt', 'thegem'),
				'base' => 'gem_title_excerpt',
				'icon' => 'thegem-icon-wpb-ui-title-excerpt',
				'category' => __('Custom Page Title', 'thegem'),
				'description' => __('Custom Title - Excerpt', 'thegem'),
				'weight' => 10,
				'params' => array_merge(array(
					array(
						'type' => 'checkbox',
						'heading' => __('Disable automatic page / post title', 'thegem'),
						'param_name' => 'use_shortcode_data',
						'value' => array(__('Yes', 'thegem') => '1'),
					),
					array(
						'type' => 'textarea_html',
						'heading' => __('Content', 'thegem'),
						'param_name' => 'content',
						'dependency' => array(
							'element' => 'use_shortcode_data',
							'not_empty' => true
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Color', 'thegem'),
						'param_name' => 'color',
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Alignment', 'thegem'),
						'param_name' => 'alignment',
						'value' => array(__('Left', 'thegem') => 'left', __('Right', 'thegem') => 'right', __('Center', 'thegem') => 'center'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Max width', 'thegem'),
						'param_name' => 'width',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin top', 'thegem'),
						'param_name' => 'margin_top',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin bottom', 'thegem'),
						'param_name' => 'margin_bottom',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Extra Class', 'thegem'),
						'param_name' => 'extra_class',
					),
				)),
			);
			$shortcodes['gem_title_icon'] = array(
				'name' => __('Icon', 'thegem'),
				'base' => 'gem_title_icon',
				'icon' => 'thegem-icon-wpb-ui-title-icon',
				'category' => __('Custom Page Title', 'thegem'),
				'description' => __('Custom Title - Icon', 'thegem'),
				'weight' => 10,
				'params' => array_merge(array(
					array(
						'type' => 'dropdown',
						'heading' => __('Icon pack', 'thegem'),
						'param_name' => 'pack',
						'value' => array_merge(array(__('Elegant', 'thegem') => 'elegant', __('Material Design', 'thegem') => 'material', __('FontAwesome', 'thegem') => 'fontawesome'), thegem_userpack_to_dropdown()),
						'std' => 'material'
					),
					array(
						'type' => 'thegem_icon',
						'heading' => __('Icon', 'thegem'),
						'param_name' => 'icon_elegant',
						'icon_pack' => 'elegant',
						'dependency' => array(
							'element' => 'pack',
							'value' => array('elegant')
						),
					),
					array(
						'type' => 'thegem_icon',
						'heading' => __('Icon', 'thegem'),
						'param_name' => 'icon_material',
						'icon_pack' => 'material',
						'dependency' => array(
							'element' => 'pack',
							'value' => array('material')
						),
						'std' => 'f287'
					),
					array(
						'type' => 'thegem_icon',
						'heading' => __('Icon', 'thegem'),
						'param_name' => 'icon_fontawesome',
						'icon_pack' => 'fontawesome',
						'dependency' => array(
							'element' => 'pack',
							'value' => array('fontawesome')
						),
					),
				),
				thegem_userpack_to_shortcode(array(
					array(
						'type' => 'thegem_icon',
						'heading' => __('Icon', 'thegem'),
						'param_name' => 'icon_userpack',
						'icon_pack' => 'userpack',
						'dependency' => array(
							'element' => 'pack',
							'value' => array('userpack')
						),
					),
				)),
				array(
					array(
						'type' => 'dropdown',
						'heading' => __('Shape', 'thegem'),
						'param_name' => 'shape',
						'value' => array(__('Square', 'thegem') => 'square', __('Circle', 'thegem') => 'circle', __('Rhombus', 'thegem') => 'romb', __('Hexagon', 'thegem') => 'hexagon'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Style', 'thegem'),
						'param_name' => 'style',
						'value' => array(__('Default', 'thegem') => '', __('45 degree Right', 'thegem') => 'angle-45deg-r', __('45 degree Left', 'thegem') => 'angle-45deg-l', __('90 degree', 'thegem') => 'angle-90deg'),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Color', 'thegem'),
						'param_name' => 'color',
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Color 2', 'thegem'),
						'param_name' => 'color_2',
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Background Color', 'thegem'),
						'param_name' => 'background_color',
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Border Color', 'thegem'),
						'param_name' => 'border_color',
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Size', 'thegem'),
						'param_name' => 'size',
						'value' => array(__('Small', 'thegem') => 'small', __('Medium', 'thegem') => 'medium', __('Large', 'thegem') => 'large', __('Extra Large', 'thegem') => 'xlarge'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Alignment', 'thegem'),
						'param_name' => 'alignment',
						'value' => array(__('Default position', 'thegem') => 'default', __('Centered', 'thegem') => 'center', __('Left to content', 'thegem') => 'left', __('Right to content', 'thegem') => 'right'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin left', 'thegem'),
						'param_name' => 'margin_left',
						'dependency' => array(
							'element' => 'alignment',
							'value' => array('right')
						),
						'std' => 30,
					),
					array(
						'type' => 'textfield',
						'heading' => __('Margin right', 'thegem'),
						'param_name' => 'margin_right',
						'dependency' => array(
							'element' => 'alignment',
							'value' => array('left')
						),
						'std' => 30,
					),
					array(
						'type' => 'textfield',
						'heading' => __('Extra Class', 'thegem'),
						'param_name' => 'extra_class',
					),
				)),
			);
			$shortcodes['gem_title_background'] = array(
				'name' => __('Background', 'thegem'),
				'base' => 'gem_title_background',
				'is_container' => true,
				'js_view' => 'VcGemTitleBackgroundView',
				'icon' => 'thegem-icon-wpb-ui-title-background',
				'category' => __('Custom Page Title', 'thegem'),
				'description' => __('Custom Title - Background', 'thegem'),
				'weight' => 10,
				'params' => array_merge(array(
					array(
						'type' => 'checkbox',
						'heading' => __('Fullwidth', 'thegem'),
						'param_name' => 'fullwidth',
						'value' => array(__('Yes', 'thegem') => '1')
					),
					array(
						'type' => 'checkbox',
						'heading' => __('Container', 'thegem'),
						'param_name' => 'container',
						'value' => array(__('Yes', 'thegem') => '1'),
						'dependency' => array(
							'element' => 'fullwidth',
							'value' => array('1')
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Background Color', 'thegem'),
						'param_name' => 'background_color',
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Default Text Color', 'thegem'),
						'param_name' => 'color',
					),
					array(
						'type' => 'attach_image',
						'heading' => __('Background image', 'thegem'),
						'param_name' => 'background_image',
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Background style', 'thegem'),
						'param_name' => 'background_style',
						'value' => array(
							__('Default', 'thegem') => '',
							__('Cover', 'thegem') => 'cover',
							__('Contain', 'thegem') => 'contain',
							__('No Repeat', 'thegem') => 'no-repeat',
							__('Repeat', 'thegem') => 'repeat'
						)
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Background horizontal position', 'thegem'),
						'param_name' => 'background_position_horizontal',
						'value' => array(
							__('Center', 'thegem') => 'center',
							__('Left', 'thegem') => 'left',
							__('Right', 'thegem') => 'right'
						)
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Background vertical position', 'thegem'),
						'param_name' => 'background_position_vertical',
						'value' => array(
							__('Top', 'thegem') => 'top',
							__('Center', 'thegem') => 'center',
							__('Bottom', 'thegem') => 'bottom'
						)
					),
					array(
						'type' => 'checkbox',
						'heading' => __('Parallax', 'thegem'),
						'param_name' => 'background_parallax',
						'value' => array(__('Yes', 'thegem') => '1')
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Background video type', 'thegem'),
						'param_name' => 'video_background_type',
						'value' => array(
							__('None', 'thegem') => '',
							__('YouTube', 'thegem') => 'youtube',
							__('Vimeo', 'thegem') => 'vimeo',
							__('Self', 'thegem') => 'self'
						),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Video id (YouTube or Vimeo) or src', 'thegem'),
						'param_name' => 'video_background_src',
						'value' => '',
						'dependency' => array(
							'element' => 'video_background_type',
							'value' => array('youtube', 'vimeo', 'self')
						),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Video Aspect ratio (16:9, 16:10, 4:3...)', 'thegem'),
						'param_name' => 'video_background_acpect_ratio',
						'value' => '16:9',
						'dependency' => array(
							'element' => 'video_background_type',
							'value' => array('youtube', 'vimeo', 'self')
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Background video overlay color', 'thegem'),
						'param_name' => 'video_background_overlay_color',
						'dependency' => array(
							'element' => 'video_background_type',
							'value' => array('youtube', 'vimeo', 'self')
						),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Background video overlay opacity (0 - 1)', 'thegem'),
						'param_name' => 'video_background_overlay_opacity',
						'dependency' => array(
							'element' => 'video_background_type',
							'value' => array('youtube', 'vimeo', 'self')
						),
					),
					array(
						'type' => 'attach_image',
						'heading' => __('Video Poster', 'thegem'),
						'param_name' => 'video_background_poster',
						'dependency' => array(
							'element' => 'video_background_type',
							'value' => array('self')
						)
					),
					array(
						'type' => 'textfield',
						'heading' => __('Padding top', 'thegem'),
						'param_name' => 'padding_top',
						'std' => 80,
					),
					array(
						'type' => 'textfield',
						'heading' => __('Padding bottom', 'thegem'),
						'param_name' => 'padding_bottom',
						'std' => 80,
					),
					array(
						'type' => 'textfield',
						'heading' => __('Padding left', 'thegem'),
						'param_name' => 'padding_left',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Padding right', 'thegem'),
						'param_name' => 'padding_right',
					),
					array(
						'type' => 'textfield',
						'heading' => __('Extra Class', 'thegem'),
						'param_name' => 'extra_class',
					),
				)),
			);
		}
	}
	return $shortcodes;
}
add_filter('thegem_shortcodes_array', 'thegem_custom_title_shortcodes_array');

function thegem_vc_add_element_categories_custom_title($tabs) {
	$title_tab = false;
	$title_tab_key = -1;
	foreach($tabs as $key => $tab) {
		if($tab['name'] === __('Custom Page Title', 'thegem')) {
			$title_tab = $tab;
			$title_tab_key = $key;
		}
	}
	if($title_tab_key > -1) {
		unset($tabs[$title_tab_key]);
		$title_tab['active'] = 1;
		foreach($tabs as $key => $tab) {
			if($tab['active']) {
				$tabs[$key]['active'] = false;
			}
		}
		$tabs = array_merge(array($title_tab), $tabs);
	}
	return $tabs;
}
add_filter('vc_add_element_categories', 'thegem_vc_add_element_categories_custom_title');

add_shortcode('gem_title_title', 'thegem_title_title_shortcode');
add_shortcode('gem_title_excerpt', 'thegem_title_excerpt_shortcode');
add_shortcode('gem_title_icon', 'thegem_title_icon_shortcode');
add_shortcode('gem_title_background', 'thegem_title_background_shortcode');

function thegem_title_title_shortcode($atts) {
	$output = '';
	$atts = shortcode_atts( array(
		'use_shortcode_data' => 0,
		'type' => 'simple',
		'text' => '',
		'content' => '',
		'color' => '',
		'xlarge' => '',
		'alignment' => 'left',
		'width' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'extra_class' => '',
	), $atts, 'gem_title_title' );
	global $thegem_page_title_template_data;
	$page_data = thegem_get_sanitize_page_title_data(0, $thegem_page_title_template_data);
	if($thegem_page_title_template_data['title_use_page_settings']) {
		$atts = array_merge($atts, array(
			'type' => $page_data['title_rich_content'] ? 'rich' : 'simple',
			'text' => !empty($thegem_page_title_template_data['main_title']) ? $thegem_page_title_template_data['main_title'] : '',
			'content' => $page_data['title_content'],
			'color' => $page_data['title_text_color'] ? $page_data['title_text_color'] : $atts['color'],
			'xlarge' => $page_data['title_xlarge'],
			'alignment' => $page_data['title_alignment'] ? $page_data['title_alignment'] : $atts['alignment'],
		));
	}
	if(empty($atts['text']) && !empty($thegem_page_title_template_data['main_title'])) {
		$atts['text'] = $thegem_page_title_template_data['main_title'];
	}
	if(empty($atts['use_shortcode_data']) && !empty($page_data['title_rich_content']) && !empty($page_data['title_content'])) {
		$atts['type'] = 'rich';
		$atts['content'] = $page_data['title_content'];
	}
	$styles = '';
	if($atts['alignment'] == 'right' || $atts['alignment'] == 'center') {
		$styles .= 'text-align: '.$atts['alignment'].';';
	}
	if($atts['alignment'] == 'center') {
		$styles .= 'margin-left: auto;margin-right: auto;';
	}
	if(intval($atts['margin_top']) > 0) {
		$styles .= 'margin-top: '.intval($atts['margin_top']).'px;';
	}
	if(intval($atts['margin_bottom']) > 0) {
		$styles .= 'margin-bottom: '.intval($atts['margin_bottom']).'px;';
	}
	if(intval($atts['width']) > 0) {
		$styles .= 'max-width: '.intval($atts['width']).'px;';
	}
	$output .= '<div class="custom-title-title '.esc_attr($atts['extra_class']).'"'.($styles ? ' style ="'.esc_attr($styles).'"' : '').'>';
	if($atts['type'] == 'simple') {
		$output .= '<h1 '.($atts['xlarge'] ? 'class="title-xlarge"' : '');
	} else {
		$output .= '<div class="custom-title-rich"';
	}
	if($atts['color']) {
		$output .= ' style="color: '.esc_attr($atts['color']).'"';
	}
	$output .= '>';
	if($atts['type'] == 'simple' && !empty($atts['text'])) {
		$output .= $atts['text'];
	} elseif($atts['type'] == 'rich') {
		$output .= do_shortcode($atts['content']);
	} else {
		$output .= 'Custom Title';
	}
	if($atts['type'] == 'simple') {
		$output .= '</h1>';
	} else {
		$output .= '</div>';
	}
	$output .= '</div>';
	return $output;
}

function thegem_title_excerpt_shortcode($atts) {
	$output = '';
	$atts = shortcode_atts( array(
		'use_shortcode_data' => 0,
		'content' => '',
		'color' => '',
		'alignment' => '',
		'width' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'extra_class' => '',
	), $atts, 'gem_title_title' );
	global $thegem_page_title_template_data;
	$page_data = thegem_get_sanitize_page_title_data(0, $thegem_page_title_template_data);
	if($thegem_page_title_template_data['title_use_page_settings']) {
		$atts = array_merge($atts, array(
			'content' => $page_data['title_excerpt'],
			'color' => $page_data['title_excerpt_text_color'] ? $page_data['title_excerpt_text_color'] : $atts['color'],
			'alignment' => $page_data['title_alignment'] ? $page_data['title_alignment'] : $atts['alignment'],
		));
	}
	if(!$atts['use_shortcode_data'] && !empty($page_data['title_excerpt'])) {
		$atts['content'] = $page_data['title_excerpt'];
	}
	$output .= '<div class="custom-title-excerpt styled-subtitle '.esc_attr($atts['extra_class']).'"';
	$styles = '';
	if($atts['alignment'] == 'right' || $atts['alignment'] == 'center') {
		$styles .= 'text-align: '.$atts['alignment'].';';
	}
	if($atts['alignment'] == 'center') {
		$styles .= 'margin-left: auto;margin-right: auto;';
	}
	if(intval($atts['margin_top']) > 0) {
		$styles .= 'margin-top: '.intval($atts['margin_top']).'px;';
	}
	if(intval($atts['margin_bottom']) > 0) {
		$styles .= 'margin-bottom: '.intval($atts['margin_bottom']).'px;';
	}
	if(intval($atts['width']) > 0) {
		$styles .= 'max-width: '.intval($atts['width']).'px;';
	}
	if($atts['color']) {
		$styles .= 'color: '.$atts['color'].';';
	}
	$output .= ' style="'.esc_attr($styles).'">';
	if(!empty($atts['content'])) {
		$output .= do_shortcode($atts['content']);
	} else {
		$output .= 'Custom Title Excerpt';
	}
	$output .= '</div>';
	return $output;
}

function thegem_title_icon_shortcode($atts) {
	extract(shortcode_atts(array(
		'use_shortcode_data' => 0,
		'pack' => 'material',
		'icon_elegant' => '',
		'icon_material' => 'f287',
		'icon_fontawesome' => '',
		'icon_userpack' => '',
		'shape' => 'square',
		'style' => '',
		'color' => '',
		'color_2' => '',
		'background_color' => '',
		'border_color' => '',
		'size' => 'small',
		'alignment' => 'default',
		'margin_left' => 30,
		'margin_right' => 30,
		'extra_class' => '',
	), $atts, 'gem_title_icon'));
	global $thegem_page_title_template_data;
	$page_data = thegem_get_sanitize_page_title_data(0, $thegem_page_title_template_data);
	if($thegem_page_title_template_data['title_use_page_settings'] && $page_data['title_icon']) {
		$pack = $page_data['title_icon_pack'];
		$icon_elegant = $page_data['title_icon'];
		$icon_material = $page_data['title_icon'];
		$icon_fontawesome = $page_data['title_icon'];
		$icon_userpack = $page_data['title_icon'];
		$shape = $page_data['title_icon_shape'];
		$style = $page_data['title_icon_style'];
		$color = $page_data['title_icon_color'];
		$color_2 = $page_data['title_icon_color'];
		$background_color = $page_data['title_icon_background_color'];
		$border_color = $page_data['title_icon_border_color'];
		$size = $page_data['title_icon_size'];
	}
	if($pack =='elegant' && empty($icon) && $icon_elegant) {
		$icon = $icon_elegant;
	}
	if($pack =='material' && empty($icon) && $icon_material) {
		$icon = $icon_material;
	}
	if($pack =='fontawesome' && empty($icon) && $icon_fontawesome) {
		$icon = $icon_fontawesome;
	}
	if($pack =='userpack' && empty($icon) && $icon_userpack) {
		$icon = $icon_userpack;
	}
	wp_enqueue_style('icons-'.$pack);
	$shape = thegem_check_array_value(array('circle', 'square', 'romb', 'hexagon'), $shape, 'square');
	$style = thegem_check_array_value(array('', 'angle-45deg-r', 'angle-45deg-l', 'angle-90deg', 'gradient'), $style, '');
	$size = thegem_check_array_value(array('small', 'medium', 'large', 'xlarge'), $size, 'small');
	$alignment = thegem_check_array_value(array('default', 'center', 'left', 'right'), $alignment, 'default');
	$css_style_icon = '';
	$css_style_icon_background = '';
	$css_style_icon_1 = '';
	$css_style_icon_2 = '';
	$css_style_icon_3 = '';

	if($background_color) {
		$css_style_icon_background .= 'background-color: '.$background_color.';';
		if(!$border_color || !$style == 'gradient') {
			$css_style_icon .= 'border-color: '.$background_color.';';
		}
	}

	if($border_color) {
		$css_style_icon .= 'border-color: '.$border_color.';';
	}

	$simple_icon = '';
	if(!($background_color || $border_color)) {
		$simple_icon = ' gem-simple-icon';
	}

	if($color = $color) {
		$css_style_icon_1 = 'color: '.$color.';';
		if(($color_2 = $color_2) && $style) {
			$css_style_icon_2 = 'color: '.$color_2.';';
		} else {
			$css_style_icon_2 = 'color: '.$color.';';
		}
	}

	$output = '<span class="gem-icon-half-1" style="' . $css_style_icon_1 . '"><span class="back-angle">&#x' . $icon . ';</span></span>'.
	'<span class="gem-icon-half-2" style="' . $css_style_icon_2 . '"><span class="back-angle">&#x' . $icon . ';</span></span>';

	$return_html = '<div class="gem-icon gem-icon-pack-'.$pack.' gem-icon-size-'.$size.' '.$style.' gem-icon-shape-'.$shape.$simple_icon.esc_attr($extra_class).'" style="'.$css_style_icon.'">'.

		($shape == 'hexagon' ? '<div class="gem-icon-shape-hexagon-back"><div class="gem-icon-shape-hexagon-back-inner"><div class="gem-icon-shape-hexagon-back-inner-before" style="background-color: '.($border_color ? $border_color : $background_color).'"></div></div></div><div class="gem-icon-shape-hexagon-top"><div class="gem-icon-shape-hexagon-top-inner"><div class="gem-icon-shape-hexagon-top-inner-before" style="'.$css_style_icon_background.'"></div></div></div>' : '').
		'<div class="gem-icon-inner" style="'.$css_style_icon_background.'">'.
		($shape == 'romb' ? '<div class="romb-icon-conteiner">' : '').
		$output.
		($shape == 'romb' ? '</div>' : '').
		'</div>'.
		'</div>';

	$margin_styles = '';
	if($alignment == 'left') {
		$margin_styles .= 'margin-right: '.intval($margin_left).'px;';
	}
	if($alignment == 'right') {
		$margin_styles .= 'margin-left: '.intval($margin_right).'px;';
	}
	$output_html = '<div class="custom-title-icon custom-title-icon-alignment-'.esc_attr($alignment).'" style="'.$margin_styles.'">'.$return_html.'</div>';

	return $output_html;
}

function thegem_title_background_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'use_shortcode_data' => 0,
		'fullwidth' => '',
		'container' => '',
		'color' => '',
		'background_color' => '',
		'background_image' => '',
		'background_style' => '',
		'background_position_horizontal' => 'center',
		'background_position_vertical' => 'top',
		'background_parallax' => '',
		'video_background_type' => '',
		'video_background_src' => '',
		'video_background_acpect_ratio' => '16:9',
		'video_background_overlay_color' => '',
		'video_background_overlay_opacity' => '',
		'video_background_poster' => '',
		'padding_top' => '80',
		'padding_bottom' => '80',
		'padding_left' => '',
		'padding_right' => '',
		'extra_class' => '',
	), $atts, 'gem_title_background'));
	$background_image = thegem_attachment_url($background_image);
	global $thegem_page_title_template_data;
	$page_data = thegem_get_sanitize_page_title_data(0, $thegem_page_title_template_data);
	if($thegem_page_title_template_data['title_use_page_settings']) {
		$background_color = $page_data['title_background_color'] ? $page_data['title_background_color'] : $background_color;
		$background_image = $page_data['title_background_image'] ? $page_data['title_background_image'] : $background_image;
		$background_parallax = $page_data['title_background_image'] && $page_data['title_background_parallax'] ? 1 : 0;
		if($page_data['title_video_background']) {
			$video_background_type = $page_data['title_video_type'];
			$video_background_src = $page_data['title_video_background'];
			$video_background_acpect_ratio = $page_data['title_video_aspect_ratio'];
			$video_background_overlay_color = $page_data['title_video_overlay_color'];
			$video_background_overlay_opacity = $page_data['title_video_overlay_opacity'];
			$video_background_poster = $page_data['title_video_poster'];
		}
	}
	$css_style = '';
	if($color) {
		$css_style .= 'color: '.$color.';';
	}
	if($background_color) {
		$css_style .= 'background-color: '.$background_color.';';
	}
	$background_image_style = '';
	if($background_image) {
		$background_image_style .= 'background-image: url('.esc_url($background_image).');';

		if($background_style == 'cover') {
			$background_image_style .= 'background-repeat: no-repeat; background-size: cover;';
		}
		if($background_style == 'contain') {
			$background_image_style .= 'background-repeat: no-repeat; background-size: contain;';
		}
		if($background_style == 'repeat') {
			$background_image_style .= 'background-repeat: repeat;';
		}
		if($background_style == 'no-repeat') {
			$background_image_style .= 'background-repeat: no-repeat;';
		}
		$background_image_style .= 'background-position: '.$background_position_horizontal.' '.$background_position_vertical.';';
	}

	$video = thegem_video_background($video_background_type, $video_background_src, $video_background_acpect_ratio, false, $video_background_overlay_color, $video_background_overlay_opacity, thegem_attachment_url($video_background_poster));
	if($padding_top) {
		$css_style .= 'padding-top: '.$padding_top.'px;';
	}
	if($padding_bottom) {
		$css_style .= 'padding-bottom: '.$padding_bottom.'px;';
	}
	if($padding_left) {
		$css_style .= 'padding-left: '.$padding_left.'px;';
	}
	if($padding_right) {
		$css_style .= 'padding-right: '.$padding_right.'px;';
	}

	if ($background_parallax) {
		wp_enqueue_script('thegem-parallax-vertical');
	}

	$fullwidth_uid = '';
	$html_js = '';
	if($fullwidth) {
		$fullwidth_uid = uniqid();
		$html_js = '<script type="text/javascript">if (typeof(gem_fix_fullwidth_position) == "function") { gem_fix_fullwidth_position(document.getElementById("fullwidth-block-' . $fullwidth_uid . '")); }</script>';
	}

	$return_html = '<div'.($fullwidth ? ' id="fullwidth-block-' . $fullwidth_uid . '"' : '').' class="custom-title-background'.($fullwidth ? ' fullwidth-block' : '') . ($extra_class ? ' '.esc_attr($extra_class) : '') . ($background_parallax ? ' fullwidth-block-parallax-vertical' : '') . ' clearfix" ' . ' style="'.$css_style.'">' .  $html_js . ($background_image_style != '' ? '<div class="fullwidth-block-background" style="'.  $background_image_style.'"></div>' : '') . $video. '<div class="fullwidth-block-inner">'.  ($container ? '<div class="container">' : '').do_shortcode($content).($container ? '</div>' : '').'</div></div>';
	return $return_html;
}

if(class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_gem_title_background extends WPBakeryShortCodesContainer {}
}
