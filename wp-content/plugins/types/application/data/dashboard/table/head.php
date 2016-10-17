<?php
return array(

	'type' => array(
		'id'            => 'type',
		'title'         => __( 'Post Type', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'A list of all Post Types available in your site.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-post-types', 'tooltip' )
			),
		)
	),

	'fields' => array(
		'id'            => 'fields',
		'title'         => __( 'Fields', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'A list of all Post Fields and their attachment to the Post Types.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-fields', 'tooltip' )
			),
		)
	),

	'taxonomies' => array(
		'id'            => 'taxonomies',
		'title'         => __( 'Taxonomies', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'A list of all Taxonomies and their attachment to the Post Types.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-taxonomies', 'tooltip' )
			),
		)
	),





	'template' => array(
		'id'            => 'template',
		'title'         => __( 'Template', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'A template displays single-item pages with your design and fields.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-template', 'tooltip' )
			),
		)
	),

	'archive' => array(
		'id'            => 'archive',
		'title'         => __( 'Archive', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'An archive is the standard list that WordPress produces for content.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-archive', 'tooltip' )
			),
		)
	),

	'views' => array(
		'id'            => 'views',
		'title'         => __( 'Views', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'Views are custom lists of content, which you can display anywhere in the site.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-views', 'tooltip' )
			),
		)
	),

	'forms' => array(
		'id'            => 'forms',
		'title'         => __( 'Forms', 'types' ),
		'description'   => array(
			array(
				'type' => 'paragraph',
				'content' => __( 'Forms allow to create and edit content from the site’s front-end.', 'types' )
			),
			array(
				'type'   => 'link',
				'external' => true,
				'label'  => __( 'Learn more', 'types' ),
				'target' => Types_Helper_Url::get_url( 'learn-how-forms', 'tooltip' )
			),
		)
	)
);