<?php

/**
 * Class Vc_Vendor_Woocommerce
 *
 * @since 4.4
 * @todo move to separate file and dir.
 */
Class Vc_Vendor_Woocommerce implements Vc_Vendor_Interface {
	protected static $product_fields_list = false;
	protected static $order_fields_list = false;
	/**
	 * @since 4.4
	 */
	public function load() {
		if ( class_exists( 'WooCommerce' ) ) {

			add_action( 'vc_build_admin_page', array(
				&$this,
				'mapShortcodes',
			) );

			add_action( 'vc_load_shortcode', array(
				&$this,
				'mapShortcodes'
			) );

			// $this->mapShortcodes();
			add_action( 'vc_backend_editor_render', array(
				&$this,
				'enqueueJsBackend'
			) );

			add_action( 'vc_frontend_editor_render', array(
				&$this,
				'enqueueJsFrontend'
			) );
			add_filter('vc_grid_item_shortcodes', array(
				&$this,
				'mapGridItemShortcodes'
			));
		}
	}

	/**
	 * @since 4.4
	 */
	public function enqueueJsBackend() {
		wp_enqueue_script( 'vc_vendor_woocommerce_backend',
			vc_asset_url( 'js/vendors/woocommerce.js' ),
			array( 'wpb_js_composer_js_storage' ), '1.0', true );
	}

	/**
	 * @since 4.4
	 */
	public function enqueueJsFrontend() {
		wp_enqueue_script( 'vc_vendor_woocommerce_frontend',
			vc_asset_url( 'js/vendors/woocommerce.js' ),
			array( 'vc_inline_shortcodes_builder_js' ), '1.0', true );
	}

	/**
	 * Add woocommerce shortcodes and hooks/filters for it.
	 * @since 4.4
	 */
	public function mapShortcodes() {
		add_action( 'wp_ajax_vc_woocommerce_get_attribute_terms', array(
			&$this,
			'getAttributeTermsAjax'
		) );

		$order_by_values = array(
			'',
			__( 'Date', 'js_composer' ) => 'date',
			__( 'ID', 'js_composer' ) => 'ID',
			__( 'Author', 'js_composer' ) => 'author',
			__( 'Title', 'js_composer' ) => 'title',
			__( 'Modified', 'js_composer' ) => 'modified',
			__( 'Random', 'js_composer' ) => 'rand',
			__( 'Comment count', 'js_composer' ) => 'comment_count',
			__( 'Menu order', 'js_composer' ) => 'menu_order',
		);

		$order_way_values = array(
			'',
			__( 'Descending', 'js_composer' ) => 'DESC',
			__( 'Ascending', 'js_composer' ) => 'ASC',
		);

		$args = array(
			'type' => 'post',
			'child_of' => 0,
			'parent' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => 'product_cat',
			'pad_counts' => false,

		);
		$categories = get_categories( $args );

		$product_categories_dropdown = array();
		$this->getCategoryChilds( 0, 0, $categories, 0, $product_categories_dropdown );

		/**
		 * @shortcode woocommerce_cart
		 * @description Used on the cart page, the cart shortcode displays the cart contents and interface for coupon codes and other cart bits and pieces.
		 * @no_params
		 * @not_editable
		 */
		vc_map( array(
			'name' => __( 'Cart', 'js_composer' ),
			'base' => 'woocommerce_cart',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Displays the cart contents', 'js_composer' ),
			'show_settings_on_create' => false,
			'php_class_name' => 'Vc_WooCommerce_NotEditable',

		) );

		/**
		 * @shortcode woocommerce_checkout
		 * @description Used on the checkout page, the checkout shortcode displays the checkout process.
		 * @no_params
		 * @not_editable
		 */
		vc_map( array(
			'name' => __( 'Checkout', 'js_composer' ),
			'base' => 'woocommerce_checkout',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Displays the checkout', 'js_composer' ),
			'show_settings_on_create' => false,
			'php_class_name' => 'Vc_WooCommerce_NotEditable',
		) );

		/**
		 * @shortcode woocommerce_order_tracking
		 * @description Lets a user see the status of an order by entering their order details.
		 * @no_params
		 * @not_editable
		 */
		vc_map( array(
			'name' => __( 'Order Tracking Form', 'js_composer' ),
			'base' => 'woocommerce_order_tracking',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Lets a user see the status of an order', 'js_composer' ),
			'show_settings_on_create' => false,
			'php_class_name' => 'Vc_WooCommerce_NotEditable',
		) );

		/**
		 * @shortcode woocommerce_my_account
		 * @description Shows the ‘my account’ section where the customer can view past orders and update their information.
		 * You can specify the number or order to show, it’s set by default to 15 (use -1 to display all orders.)
		 *
		 * @param order_count integer
		 * Current user argument is automatically set using get_user_by( ‘id’, get_current_user_id() ).
		 */
		vc_map( array(
			'name' => __( 'My Account', 'js_composer' ),
			'base' => 'woocommerce_my_account',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Shows the "my account" section', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Order count', 'js_composer' ),
					'value' => 15,
					'param_name' => 'order_count',
					'description' => __( 'You can specify the number or order to show, it\'s set by default to 15 (use -1 to display all orders.)', 'js_composer' ),
				),
			)
		) );

		/**
		 * @shortcode recent_products
		 * @description Lists recent products – useful on the homepage. The ‘per_page’ shortcode determines how many products
		 * to show on the page and the columns attribute controls how many columns wide the products should be before wrapping.
		 * To learn more about the default ‘orderby’ parameters please reference the WordPress Codex: http://codex.wordpress.org/Class_Reference/WP_Query
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 */
		vc_map( array(
			'name' => __( 'Recent products', 'js_composer' ),
			'base' => 'recent_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Lists recent products', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
			)
		) );

		/**
		 * @shortcode featured_products
		 * @description Works exactly the same as recent products but displays products which have been set as “featured”.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 */
		vc_map( array(
			'name' => __( 'Featured products', 'js_composer' ),
			'base' => 'featured_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Display products set as "featured"', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
			)
		) );

		/**
		 * @shortcode product
		 * @description Show a single product by ID or SKU.
		 *
		 * @param id integer
		 * @param sku string
		 * If the product isn’t showing, make sure it isn’t set to Hidden in the Catalog Visibility.
		 * To find the Product ID, go to the Product > Edit screen and look in the URL for the postid= .
		 */
		vc_map( array(
			'name' => __( 'Product', 'js_composer' ),
			'base' => 'product',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show a single product by ID or SKU', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Select identificator', 'js_composer' ),
					'param_name' => 'id',
					'description' => __( 'Input product ID or product SKU or product title to see suggestions', 'js_composer' ),
				),
				array(
					'type' => 'hidden',
					// This will not show on render, but will be used when defining value for autocomplete
					'param_name' => 'sku',
				),
			)
		) );
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_product_id_callback', array(
			&$this,
			'productIdAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_product_id_render', array(
			&$this,
			'productIdAutocompleteRender'
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_product_id_param_value', array(
			&$this,
			'productIdDefaultValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode products
		 * @description Show multiple products by ID or SKU. Make note of the plural ‘products’.
		 *
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 * If the product isn’t showing, make sure it isn’t set to Hidden in the Catalog Visibility.
		 */
		vc_map( array(
			'name' => __( 'Products', 'js_composer' ),
			'base' => 'products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show multiple products by ID or SKU.', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'std' => 'title',
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s. Default by Title', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s. Default by ASC', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Products', 'js_composer' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend
					),
					'description' => __( 'Enter List of Products', 'js_composer' ),
				),
				array(
					'type' => 'hidden',
					'param_name' => 'skus',
				),
			)
		) );
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_products_ids_callback', array(
			&$this,
			'productIdAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_products_ids_render', array(
			&$this,
			'productIdAutocompleteRender'
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_products_ids_param_value', array(
			&$this,
			'productsIdsDefaultValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode add_to_cart
		 * @description Show the price and add to cart button of a single product by ID (or SKU).
		 *
		 * @param id integer
		 * @param sku string
		 * @param style string
		 * If the product isn’t showing, make sure it isn’t set to Hidden in the Catalog Visibility.
		 */
		vc_map( array(
			'name' => __( 'Add to cart', 'js_composer' ),
			'base' => 'add_to_cart',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show multiple products by ID or SKU', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Select identificator', 'js_composer' ),
					'param_name' => 'id',
					'description' => __( 'Input product ID or product SKU or product title to see suggestions', 'js_composer' ),
				),
				array(
					'type' => 'hidden',
					'param_name' => 'sku',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Wrapper inline style', 'js_composer' ),
					'param_name' => 'style',
				),
			)
		) );
		//Filters For autocomplete param: Exactly Same as "product" shortcode
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_add_to_cart_id_callback', array(
			&$this,
			'productIdAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_add_to_cart_id_render', array(
			&$this,
			'productIdAutocompleteRender'
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_add_to_cart_id_param_value', array(
			&$this,
			'productIdDefaultValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode add_to_cart_url
		 * @description Echo the URL on the add to cart button of a single product by ID.
		 *
		 * @param id integer
		 * @param sku string
		 */
		vc_map( array(
			'name' => __( 'Add to cart URL', 'js_composer' ),
			'base' => 'add_to_cart_url',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show URL on the add to cart button', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Select identificator', 'js_composer' ),
					'param_name' => 'id',
					'description' => __( 'Input product ID or product SKU or product title to see suggestions', 'js_composer' ),
				),
				array(
					'type' => 'hidden',
					'param_name' => 'sku',
				),
			)
		) );
		//Filters For autocomplete param: Exactly Same as "product" shortcode
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_add_to_cart_url_id_callback', array(
			&$this,
			'productIdAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_add_to_cart_url_id_render', array(
			&$this,
			'productIdAutocompleteRender'
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_add_to_cart_url_id_param_value', array(
			&$this,
			'productIdDefaultValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode product_page
		 * @description Show a full single product page by ID or SKU.
		 *
		 * @param id integer
		 * @param sku string
		 */
		vc_map( array(
			'name' => __( 'Product page', 'js_composer' ),
			'base' => 'product_page',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show single product by ID or SKU', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Select identificator', 'js_composer' ),
					'param_name' => 'id',
					'description' => __( 'Input product ID or product SKU or product title to see suggestions', 'js_composer' ),
				),
				array(
					'type' => 'hidden',
					'param_name' => 'sku',
				),
			)
		) );
		//Filters For autocomplete param: Exactly Same as "product" shortcode
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_product_page_id_callback', array(
			&$this,
			'productIdAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_product_page_id_render', array(
			&$this,
			'productIdAutocompleteRender'
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_product_page_id_param_value', array(
			&$this,
			'productIdDefaultValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode product_category
		 * @description Show multiple products in a category by slug.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 * @param category string
		 * Go to: WooCommerce > Products > Categories to find the slug column.
		 */
		vc_map( array(
			'name' => __( 'Product category', 'js_composer' ),
			'base' => 'product_category',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Show multiple products in a category', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'How much items per page to show', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Category', 'js_composer' ),
					'value' => $product_categories_dropdown,
					'param_name' => 'category',
					'description' => __( 'Product category list', 'js_composer' ),
				),
			)
		) );
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_product_category_category_callback', array(
			&$this,
			'productCategoryCategoryAutocompleteSuggesterBySlug'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_product_category_category_render', array(
			&$this,
			'productCategoryCategoryRenderBySlugExact'
		), 10, 1 ); // Render exact category by Slug. Must return an array (label,value)

		/**
		 * @shortcode product_categories
		 * @description Display product categories loop.
		 *
		 * @param number integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 * @param hide_empty bool
		 * @param parent integer
		 * @param ids string
		 * The `number` field is used to display the number of products and the `ids` field is to tell the shortcode which categories to display.
		 * Set the parent paramater to 0 to only display top level categories. Set ids to a comma separated list of category ids to only show those.
		 */
		vc_map( array(
			'name' => __( 'Product categories', 'js_composer' ),
			'base' => 'product_categories',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'Display product categories loop', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Number', 'js_composer' ),
					'param_name' => 'number',
					'description' => __( 'The `number` field is used to display the number of products.', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number', 'js_composer' ),
					'param_name' => 'hide_empty',
					'description' => __( 'Hide empty', 'js_composer' ),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Categories', 'js_composer' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'description' => __( 'List of product categories', 'js_composer' ),
				),
			)
		) );
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_product_categories_ids_callback', array(
			&$this,
			'productCategoryCategoryAutocompleteSuggester'
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_product_categories_ids_render', array(
			&$this,
			'productCategoryCategoryRenderByIdExact'
		), 10, 1 ); // Render exact category by id. Must return an array (label,value)

		/**
		 * @shortcode sale_products
		 * @description List all products on sale.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 */
		vc_map( array(
			'name' => __( 'Sale products', 'js_composer' ),
			'base' => 'sale_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'List all products on sale', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'How much items per page to show', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
			)
		) );

		/**
		 * @shortcode best_selling_products
		 * @description List best selling products on sale.
		 *
		 * @param per_page integer
		 * @param columns integer
		 */
		vc_map( array(
			'name' => __( 'Best Selling Products', 'js_composer' ),
			'base' => 'best_selling_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'List best selling products on sale', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'How much items per page to show', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
			)
		) );

		/**
		 * @shortcode top_rated_products
		 * @description List top rated products on sale.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 */
		vc_map( array(
			'name' => __( 'Top Rated Products', 'js_composer' ),
			'base' => 'top_rated_products',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'List all products on sale', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'How much items per page to show', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
			)
		) );

		/**
		 * @shortcode product_attribute
		 * @description List products with an attribute shortcode.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 * @param attribute string
		 * @param filter string
		 */
		$attributes_tax = wc_get_attribute_taxonomies();
		$attributes = array();
		foreach ( $attributes_tax as $attribute ) {
			$attributes[ $attribute->attribute_label ] = $attribute->attribute_name;
		}
		vc_map( array(
			'name' => __( 'Product Attribute', 'js_composer' ),
			'base' => 'product_attribute',
			'icon' => 'icon-wpb-woocommerce',
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'List products with an attribute shortcode', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'How much items per page to show', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Attribute', 'js_composer' ),
					'param_name' => 'attribute',
					'value' => $attributes,
					'description' => __( 'List of product taxonomy attribute', 'js_composer' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Filter', 'js_composer' ),
					'param_name' => 'filter',
					'value' => array( 'empty' => 'empty' ),
					'description' => __( 'Taxonomy values', 'js_composer' ),
					'dependency' => array(
						'element' => 'attribute',
						'is_empty' => true,
						'callback' => 'vc_woocommerce_product_attribute_filter_dependency_callback',
					),
				),
			)
		) );
		//For param: "filter" param value
		//vc_form_fields_render_field_{shortcode_name}_{param_name}_param
		add_filter( 'vc_form_fields_render_field_product_attribute_filter_param', array(
			&$this,
			'productAttributeFilterParamValue'
		), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

		/**
		 * @shortcode related_products
		 * @description List related products.
		 *
		 * @param per_page integer
		 * @param columns integer
		 * @param orderby array
		 * @param order array
		 */
		/* we need to detect post type to show this shortcode */
		global $post, $typenow, $current_screen;
		$post_type = "";

		if ( $post && $post->post_type ) {
			//we have a post so we can just get the post type from that
			$post_type = $post->post_type;
		} elseif ( $typenow ) {
			//check the global $typenow - set in admin.php
			$post_type = $typenow;
		} elseif ( $current_screen && $current_screen->post_type ) {
			//check the global $current_screen object - set in sceen.php
			$post_type = $current_screen->post_type;

		} elseif ( isset( $_REQUEST['post_type'] ) ) {
			//lastly check the post_type querystring
			$post_type = sanitize_key( $_REQUEST['post_type'] );
			//we do not know the post type!
		}

		vc_map( array(
			'name' => __( 'Related Products', 'js_composer' ),
			'base' => 'related_products',
			'icon' => 'icon-wpb-woocommerce',
			'content_element' => $post_type == 'product',
			// disable showing if not product type
			'category' => __( 'WooCommerce', 'js_composer' ),
			'description' => __( 'List related products', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Per page', 'js_composer' ),
					'value' => 12,
					'param_name' => 'per_page',
					'description' => __( 'Please note: the "per_page" shortcode argument will determine how many products are shown on a page. This will not add pagination to the shortcode. ', 'js_composer' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Columns', 'js_composer' ),
					'value' => 4,
					'param_name' => 'columns',
					'description' => __( 'How much columns grid', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order way', 'js_composer' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
			)
		) );

	}
	public function mapGridItemShortcodes(array $shortcodes) {
		require_once vc_path_dir('VENDORS_DIR', 'plugins/woocommerce/class-vc-gitem-woocommerce-shortcode.php');
		require_once vc_path_dir('VENDORS_DIR', 'plugins/woocommerce/grid-item-attributes.php');
		$wc_shortcodes = include vc_path_dir('VENDORS_DIR', 'plugins/woocommerce/grid-item-shortcodes.php');
		return $shortcodes + $wc_shortcodes;
	}
	/**
	 * Defines default value for param if not provided. Takes from other param value.
	 * @since 4.4
	 *
	 * @param array $param_settings
	 * @param $current_value
	 * @param $map_settings
	 * @param $atts
	 *
	 * @return array
	 */
	public function productAttributeFilterParamValue( $param_settings, $current_value, $map_settings, $atts ) {
		if ( isset( $atts['attribute'] ) ) {
			$value = $this->getAttributeTerms( $atts['attribute'] );
			if ( is_array( $value ) && ! empty( $value ) ) {
				$param_settings['value'] = $value;
			}
		}

		return $param_settings;
	}

	/**
	 * Get attribute terms hooks from ajax request
	 * @since 4.4
	 */
	public function getAttributeTermsAjax() {
		$attribute = vc_post_param( 'attribute' );
		$values = $this->getAttributeTerms( $attribute );
		$param = array(
			'param_name' => 'filter',
			'type' => 'checkbox'
		);
		$param_line = '';
		foreach ( $values as $label => $v ) {
			$param_line .= ' <label class="vc_checkbox-label"><input id="' . $param['param_name'] . '-' . $v . '" value="' . $v . '" class="wpb_vc_param_value ' . $param['param_name'] . ' ' . $param['type'] . '" type="checkbox" name="' . $param['param_name'] . '"' . '> ' . __( $label, "js_composer" ) . '</label>';
		}
		die( json_encode( $param_line ) );
	}

	/**
	 * Get attribute terms suggester
	 * @since 4.4
	 *
	 * @param $attribute
	 *
	 * @return array
	 */
	public function getAttributeTerms( $attribute ) {
		$terms = get_terms( 'pa_' . $attribute ); // return array. take slug
		$data = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$data[ $term->name ] = $term->slug;
			}
		}

		return $data;
	}

	/**
	 * Get lists of categories.
	 * @since 4.4
	 *
	 * @param $parent_id
	 * @param $pos
	 * @param array $array
	 * @param $level
	 * @param array $dropdown - passed by  reference
	 */
	public function getCategoryChilds( $parent_id, $pos, $array, $level, &$dropdown ) {

		for ( $i = $pos; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ]->category_parent == $parent_id ) {
				$data = array(
					str_repeat( "- ", $level ) . $array[ $i ]->name => $array[ $i ]->slug,
				);
				$dropdown = array_merge( $dropdown, $data );
				$this->getCategoryChilds( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
			}
		}
	}

	/**
	 * Replace single product sku to id.
	 * @since 4.4
	 *
	 * @param $current_value
	 * @param $param_settings
	 * @param $map_settings
	 * @param $atts
	 *
	 * @return bool|string
	 */
	public function productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
		$value = trim( $current_value );
		if ( strlen( trim( $current_value ) ) == 0 && isset( $atts['sku'] ) && strlen( $atts['sku'] ) > 0 ) {
			$value = $this->productIdDefaultValueFromSkuToId( $atts['sku'] );
		}

		return $value;
	}

	/**
	 * Replaces product skus to id's.
	 * @since 4.4
	 *
	 * @param $current_value
	 * @param $param_settings
	 * @param $map_settings
	 * @param $atts
	 *
	 * @return string
	 */
	public function productsIdsDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
		$value = trim( $current_value );
		if ( isset( $atts['skus'] ) && strlen( $atts['skus'] ) > 0 ) {
			$data = array();
			$skus = $atts['skus'];
			$skus_array = explode( ',', $skus );
			foreach ( $skus_array as $sku ) {
				$id = $this->productIdDefaultValueFromSkuToId( trim( $sku ) );
				if ( is_numeric( $id ) ) {
					$data[] = $id;
				}
			}
			if ( ! empty( $data ) ) {
				$values = explode( ',', $value );
				$values = array_merge( $values, $data );
				$value = implode( ',', $values );
			}
		}

		return $value;
	}

	/**
	 * Suggester for autocomplete by id/name/title/sku
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return array - id's from products with title/sku.
	 */
	public function productIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )",
				$product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' .
				                 $value['id'] .
				                 ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' .
				                                                       $value['title'] : '' ) .
				                 ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . __( 'Sku', 'js_composer' ) . ': ' .
				                                                     $value['sku'] : '' );
				$results[] = $data;
			}
		}

		return $results;
	}

	/**
	 * Find product by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function productIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			$product_sku = $product_object->get_sku();
			$product_title = $product_object->get_title();
			$product_id = $product_object->id;

			$product_sku_display = '';
			if ( ! empty( $product_sku ) ) {
				$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
			}

			$product_title_display = '';
			if ( ! empty( $product_title ) ) {
				$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
			}

			$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

			$data = array();
			$data['value'] = $product_id;
			$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

			return ! empty( $data ) ? $data : false;
		}

		return false;
	}

	/**
	 * Return ID of product by provided SKU of product.
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool
	 */
	public function productIdDefaultValueFromSkuToId( $query ) {
		$result = $this->productIdAutocompleteSuggesterExactSku( $query );

		return isset( $result['value'] ) ? $result['value'] : false;
	}

	/**
	 * Find product by SKU
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function productIdAutocompleteSuggesterExactSku( $query ) {
		global $wpdb;
		$query = trim( $query );
		$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", stripslashes( $query ) ) );
		$product_data = get_post( $product_id );
		if ( 'product' !== $product_data->post_type ) {
			return '';
		}

		$product_object = wc_get_product( $product_data );
		$product_sku = $product_object->get_sku();
		$product_title = $product_object->get_title();
		$product_id = $product_object->id;

		$product_sku_display = '';
		if ( ! empty( $product_sku ) ) {
			$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
		}

		$product_title_display = '';
		if ( ! empty( $product_title ) ) {
			$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
		}

		$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

		$data = array();
		$data['value'] = $product_id;
		$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

		return ! empty( $data ) ? $data : false;
	}

	/**
	 * Autocomplete suggester to search product category by name/slug or id.
	 * @since 4.4
	 *
	 * @param $query
	 * @param bool $slug - determines what output is needed
	 *      default false - return id of product category
	 *      true - return slug of product category
	 *
	 * @return array
	 */
	public function productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
				$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' .
				                 $value['id'] .
				                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' .
				                                                      $value['name'] : '' ) .
				                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' .
				                                                      $value['slug'] : '' );
				$result[] = $data;
			}
		}

		return $result;
	}

	/**
	 * Search product category by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function productCategoryCategoryRenderByIdExact( $query ) {
		global $wpdb;
		$query = $query['value'];
		$cat_id = (int) $query;
		$term = get_term( $cat_id, 'product_cat' );

		return $this->productCategoryTermOutput( $term );
	}

	/**
	 * Suggester for autocomplete to find product category by id/name/slug but return found product category SLUG
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return array - slug of products categories.
	 */
	public function productCategoryCategoryAutocompleteSuggesterBySlug( $query ) {
		$result = $this->productCategoryCategoryAutocompleteSuggester( $query, true );

		return $result;
	}

	/**
	 * Search product category by slug.
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function productCategoryCategoryRenderBySlugExact( $query ) {
		global $wpdb;
		$query = $query['value'];
		$query = trim( $query );
		$term = get_term_by( 'slug', $query, 'product_cat' );

		return $this->productCategoryTermOutput( $term );
	}

	/**
	 * Return product category value|label array
	 *
	 * @param $term
	 *
	 * @since 4.4
	 * @return array|bool
	 */
	protected function productCategoryTermOutput( $term ) {
		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;

		$term_slug_display = '';
		if ( ! empty( $term_sku ) ) {
			$term_slug_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $term_slug;
		}

		$term_title_display = '';
		if ( ! empty( $product_title ) ) {
			$term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
		}

		$term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;

		$data = array();
		$data['value'] = $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

		return ! empty( $data ) ? $data : false;
	}
	public static function getProductsFieldsList() {
		return array(
			__('SKU', 'js_composer') => 'sku',
			__('ID', 'js_composer') => 'id',
			__('Price', 'js_composer') => 'price',
			__('Regular Price', 'js_composer') => 'regular_price',
			__('Sale Price', 'js_composer') => 'sale_price',
			__('Price html', 'js_composer') => 'price_html',
			__('Reviews count', 'js_composer') => 'reviews_count',
			__('Short description', 'js_composer') => 'short_description',
			__('Dimensions', 'js_composer') => 'dimensions',
			__('Rating count', 'js_composer') => 'rating_count',
			__('Weight', 'js_composer') => 'weight',
			__('Is on sale', 'js_composer') => 'on_sale',
			__('Custom field', 'js_composer') => '_custom_',
		);
	}
	public static function getProductFieldLabel($key) {
		if(false === self::$product_fields_list) {
			self::$product_fields_list = array_flip(self::getProductsFieldsList());
		}
		return isset(self::$product_fields_list[$key]) ? self::$product_fields_list[$key] : '';
	}
	public static function getOrderFieldsList() {
		return array(
			__('ID', 'js_composer') => 'id',
			__('Order number', 'js_composer') => 'order_number',
			__('Currency', 'js_composer') => 'order_currency',
			__('Total', 'js_composer') => 'total',
			__('Status', 'js_composer') => 'status',
			__('Payment method', 'js_composer') => 'payment_method',
			__('Billing address city', 'js_composer') => 'billing_address_city',
			__('Billing address country', 'js_composer') => 'billing_address_country',
			__('Shipping address city', 'js_composer') => 'shipping_address_city',
			__('Shipping address country', 'js_composer') => 'shipping_address_country',
			__('Customer Note', 'js_composer') => 'customer_note',
			__('Customer API', 'js_composer') => 'customer_api',
			__('Custom field', 'js_composer') => '_custom_',
		);
	}
	public static function getOrderFieldLabel($key) {
		if(false === self::$order_fields_list) {
			self::$order_fields_list = array_flip(self::getOrderFieldsList());
		}
		return isset(self::$order_fields_list[$key]) ? self::$order_fields_list[$key] : '';
	}
}

/**
 * Removes EDIT button in backend and frontend editor
 * Class Vc_WooCommerce_NotEditable
 * @since 4.4
 */
class Vc_WooCommerce_NotEditable extends WPBakeryShortCode {
	/**
	 * @since 4.4
	 * @var array
	 */
	protected $controls_list = array( 'clone', 'delete' );
}

