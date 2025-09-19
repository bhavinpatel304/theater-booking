<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session');

function set_flash_message($message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        $html = '<div class="alert alert-' . esc_attr($msg['type']) . '" style="margin:10px 0;padding:10px;border:1px solid #ccc;">';
        $html .= esc_html($msg['text']);
        $html .= '</div>';
        unset($_SESSION['flash_message']); // remove after displaying
        return $html;
    }
    return '';
}
add_shortcode('flash_message', 'display_flash_message');


function mytheme_enqueue_scripts() {

	// Enqueue jQuery UI CSS
    wp_enqueue_style(
        'jquery-ui',
        '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css',
        array(),
        '1.13.2'
    );

	wp_enqueue_style(
        'jquery-ui-timepicker-addon',
        '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css',
        array(),
        '1.6.3'
    );

	wp_enqueue_style(
        'bootstrap',
        '//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        array(),
        '5.3.8'
    );
	
	

	wp_enqueue_script('jquery');

	// Enqueue jQuery UI 
    wp_enqueue_script(
        'jquery-ui-datepicker',
        '//code.jquery.com/ui/1.13.2/jquery-ui.min.js',
        array('jquery'),
        '1.13.2',
        true // load in footer
    );
	wp_enqueue_script(
        'jquery-ui-timepicker-addon',
        '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js',
        array('jquery'),
        '1.6.3',
        true // load in footer
    );

    wp_enqueue_script(
        'my-custom-js', // handle
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/custom.js'), 
		true // load in footer
    );



	
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');


function my_booking_form_shortcode() {
    ob_start(); ?>
    
    <form method="post" action="">
		
			<label class="form-label">Client Name</label><br>
			<input class="form-control" type="text" name="client_name" required><br><br>
		
		
			<label>Client Email</label><br>
			<input class="form-control" type="email" name="client_email" required><br><br>
		
			<label class="form-label">Booking Start Date</label><br>
			<input class="form-control" type="text" name="date_start" id="date_start" required><br><br>
		
			<label class="form-label">Booking End Date</label><br>
			<input class="form-control" type="text" name="date_end" id="date_end" required><br><br>
		
		<input class="btn btn-primary" type="submit" name="submit_booking" value="Submit">
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('booking_form', 'my_booking_form_shortcode');

function my_handle_booking_form() {
    global $wpdb;

    if (isset($_POST['submit_booking'])) {
        $client_name  = sanitize_text_field($_POST['client_name']);
        $client_email = sanitize_email($_POST['client_email']);
        $date_start   = sanitize_text_field($_POST['date_start']);
        $date_end     = sanitize_text_field($_POST['date_end']);


        $wpdb->insert(
            $wpdb->prefix . 'bookings',
            array(
                'client_name'  => $client_name,
                'client_email' => $client_email,
                'date_start'   => $date_start,
                'date_end'     => $date_end
            ),
            array('%s', '%s', '%s', '%s')
        );

		$rtn = add_values($client_name,$client_email,$date_start,$date_end);

		
		if(isset($rtn['error']))
			set_flash_message($rtn['error'], "danger");
		else
			set_flash_message("Form submitted successfully!", "success");

		wp_redirect(get_permalink()); 
    	exit;
    }
}
add_action('wp', 'my_handle_booking_form');


function re($response){
	echo "<pre>";
		print_r($response);
		echo "</pre>";
	die();
}



function add_values($client_name,$client_email,$date_start,$date_end)
{

	$apiKey  = "SET_API_KEY";
	$boardId = 10088351996;
	$groupId = "group_mkvyjhrc";

	$date_start_arr = explode(" ",$date_start);
	$date_end_arr = explode(" ",$date_end);

	$date_from = $date_start_arr[0];
	$date_to = $date_end_arr[0];

	$range = get_data_monday($apiKey,$date_from,$date_to);

	if(!empty($range)){
		return ['error' => 'date range is already blocked'];
	}

	// Column IDs on your board
	$columns = [
		"client_name"  => "text_mkvy22bh",  // replace with your actual client_name column ID
		"client_email" => "text_mkvym6m2",  // replace with your actual client_email column ID
		"date_from"    => "date_mkvyvtrf",  // replace with your actual start date column ID
		"date_to"      => "date_mkvynqzz"   // replace with your actual end date column ID
	];


	// Build column_values JSON
	$columnValues = [
		$columns['client_name']  => $client_name,
		$columns['client_email'] => $client_email,
		$columns['date_from']    => ["date" => $date_from, "time" => $date_start_arr[1]],
		$columns['date_to']      => ["date" => $date_to, "time" => $date_end_arr[1]]
	];

	// GraphQL mutation
	$query = '
	mutation ($boardId: ID!, $groupId: String!, $itemName: String!, $columnVals: JSON!) {
	create_item(
		board_id: $boardId,
		group_id: $groupId,
		item_name: $itemName,
		column_values: $columnVals
	) {
		id
		name
	}
	}';

	$variables = [
		"boardId"    => $boardId,
		"groupId"    => $groupId,
		"itemName"   => uniqid(),
		"columnVals" => json_encode($columnValues)
	];

	// cURL request
	$ch = curl_init("https://api.monday.com/v2/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Authorization: $apiKey",
		"Content-Type: application/json"
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
		"query" => $query,
		"variables" => $variables
	]));
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // disable for testing
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // disable for testing
	// Execute and check errors
	$response = curl_exec($ch);

	if(curl_errno($ch)) {
		echo 'Curl error: ' . curl_error($ch);
		curl_close($ch);
		exit;
	}

	curl_close($ch);

	// Decode response
	$data = json_decode($response, true);

	if(empty($data['data']['create_item'])) {		 
		return [ 'error' => "Invalid JSON response"];
	}

	return [ 'success' => "Success"];

}


function get_data_monday($apiKey,$date_from,$date_to)
{

	// GraphQL query to fetch items and columns
	$query = '{
	boards(ids: [10088351996]) {
		items_page(limit: 100) {
		items {
			id
			name
			column_values {
			id
			text
			value
			}
		}
		}
	}
	}';

	// Initialize cURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.monday.com/v2/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"Content-Type: application/json",
		"Authorization: $apiKey"
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // disable for testing
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // disable for testing
	// Execute and decode response
	$response = curl_exec($ch);
	if(curl_errno($ch)) {
		echo 'Curl error: ' . curl_error($ch);
	}
	curl_close($ch);

	$data = json_decode($response, true);
	$items = [];
	foreach ($data['data']['boards'][0]['items_page']['items'] as $item) {
		$temp = ['id' => $item['id'], 'name' => $item['name']];
		foreach ($item['column_values'] as $col) {
			$temp[$col['id']] = $col['text'];
		}
		$items[] = $temp;
	}

	$search_start = $date_from; // start of your search range
	$search_end   = $date_to; // end of your search range
	$filtered_items = [];
	if(!empty($items)){
		foreach ($items as $item) {
			$item_start = strtotime($item['date_mkvyvtrf']); // replace 'date_from' with your actual column id
			$item_end   = strtotime($item['date_mkvynqzz']);   // replace 'date_to' with your actual column id
			$search_start_ts = strtotime($search_start);
			$search_end_ts   = strtotime($search_end);

			// Check if item overlaps with search range
			if ($item_end >= $search_start_ts && $item_start <= $search_end_ts) {
				$filtered_items[] = $item;
			}
		}
		// Sort results in reverse chronological order (latest first)
		usort($filtered_items, function($a, $b) {
			return strtotime($b['date_mkvyvtrf']) - strtotime($a['date_mkvyvtrf']); // latest first
		});
	}
	
	return $filtered_items;
}

