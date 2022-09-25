<?php


add_action( 'wp_enqueue_scripts', 'businessbrainz_enqueue_styles' );
function businessbrainz_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style('businessbrainz-owlcaousel-style', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(),null);
    wp_enqueue_style('businessbrainz-font-awesome',
                     '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), null);
    wp_enqueue_style( 'businessbrainz-style', get_stylesheet_uri(), array());

    wp_enqueue_script('jquery-validation','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), null);
    wp_enqueue_script('jquery-validation-additional-method','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js', array('jquery'), null);
    wp_enqueue_script(
        'bootstrap-js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
        array('jquery'),
        null,
        true
    );
    wp_enqueue_script('businessbrainz-owlcaousel', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array(), null,
                      true);
    wp_enqueue_script( 'businessbrainz-child-main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'),null,true);
    $businessbrainz__js_param = array(
        'ajaxUrl'           => admin_url('admin-ajax.php'),
    );
    wp_localize_script('businessbrainz-child-main', 'businessbrainz_php_vars', $businessbrainz__js_param);
}

function businessBrainz_custom_type_report()
{
    $labels = [
        "name"          => __("Reports", "twentytwentyone"),
        "singular_name" => __("Report", "twentytwentyone"),
    ];
    $args   = [
        "label"                 => __("Reports", "twentytwentyone"),
        "labels"                => $labels,
        "description"           => "",
        "public"                => true,
        "publicly_queryable"    => true,
        "show_ui"               => true,
        "show_in_rest"          => true,
        "rest_base"             => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive"           => 'reports',
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "delete_with_user"      => false,
        "exclude_from_search"   => false,
        "capability_type"       => "post",
        "map_meta_cap"          => true,
        "hierarchical"          => true,
        "rewrite"               => ["slug" => "reports/%report_category%", "with_front" => false],
        "query_var"             => true,
        "menu_icon"             => "dashicons-media-document",
        "supports"              => ["title", "thumbnail"],
    ];

    register_post_type("reports", $args);
    flush_rewrite_rules( false );
}

add_action('init', 'businessBrainz_custom_type_report');

function businessBrainz_custom_tax_sectors() {

    /**
     * Taxonomy: Sectors.
     */

    $labels = [
        "name" => __( "Sectors", "twentytwentyone" ),
        "singular_name" => __( "Sector", "twentytwentyone" ),
    ];

    $args = [
        "label" => __( "Sectors", "twentytwentyone" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'sectors', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "sectors",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy( "sectors", [ "reports" ], $args );
}
add_action( 'init', 'businessBrainz_custom_tax_sectors' );

function businessBrainz_custom_tax_report_category() {

    /**
     * Taxonomy: Report Category.
     */

    $labels = [
        "name" => __( "Report Category", "twentytwentyone" ),
        "singular_name" => __( "Report Category", "twentytwentyone" ),
    ];

    $args = [
        "label" => __( "Report Category", "twentytwentyone" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'report_category', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "report_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy( "report_category", [ "reports" ], $args );
}
add_action( 'init', 'businessBrainz_custom_tax_report_category' );



function businessBrainz_show_report_category($report_id)
{
    $categories      = get_the_category($report_id);
    $string_category = "";
    $current_index   = 0;
    foreach ($categories as $category) {
        $string_category .= count($categories) - 1 === $current_index ? $category->name : $category->name . ", ";
        $current_index++;
    }

    return $string_category;
}

add_action('wp_ajax_businessBrainz_load_more_reports', 'businessBrainz_load_more_reports');
add_action('wp_ajax_nopriv_businessBrainz_load_more_reports', 'businessBrainz_load_more_reports');
function businessBrainz_load_more_reports()
{
    $page     = (int)$_POST['page'];
    $category = $_POST['category'] === '' ? null : sanitize_text_field($_POST['category']);
    $perPage  = 6;
    if ($page > 1) {
        $offset = absint(($page - 1) * $perPage);
        $items = new WP_Query(businessbrainz_get_wp_query_args($offset, $category));
        if (ceil( $items->found_posts/ $perPage) <= $page) {
            echo json_encode(['lastPage' => true, 'success' => true, 'count' => ceil( $items->found_posts/ $perPage) ]);
            wp_die();
        }
        $html = '';
        while ($items->have_posts()) {
            $items->the_post();
            $id   = get_the_ID();
            $html .= '<div class="col-md-6 col-sm-12 fix-width-3 card report-box mt-2">';
            $html .= '<a href="' . get_permalink($id) . '" >';
            $html .= '<div style="background: url('. get_the_post_thumbnail_url($id, 'thumbnail') .');background-repeat:no-repeat;background-position: center; height: 200px"></div>';
            $html .= '<div class="card-body single-report-content">';
            $html .= '<div class="title">' . get_the_title() . '</div>';
            $html .= '<div class="category">'. show_sectors($id) .'</div>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
        wp_reset_postdata();
        wp_reset_query();
        $response['success'] = true;
        $response['html']    = $html;
    }
    else {
        $response['success'] = false;
    }
    if (ceil( $items->found_posts/ $perPage) <= $page) {
        $response['lastPage'] = true;
    }
    else {
        $response['lastPage'] = false;
    }
    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_businessBrainz_submit_cta_form', 'businessBrainz_submit_cta_form');
add_action('wp_ajax_nopriv_businessBrainz_submit_cta_form', 'businessBrainz_submit_cta_form');

function businessBrainz_submit_cta_form(){
    $email = $_POST['email'] === '' ? null : sanitize_text_field($_POST['email']);
    $company_name = $_POST['company_name'] === '' ? null : sanitize_text_field($_POST['company_name']);
    $website = $_POST['website'] === '' ? null : sanitize_text_field($_POST['website']);
    $client_role = $_POST['client_role'] === '' ? null : sanitize_text_field($_POST['client_role']);
    $winning_amount = $_POST['winning_amount'] === '' ? null : sanitize_text_field($_POST['winning_amount']);
    $requirement_sector = $_POST['requirement_sector'] === '' ? null : sanitize_text_field($_POST['requirement_sector']);
    $reason_for_appointment = isset( $_POST['reason_for_appointment'] ) ? (array) $_POST['reason_for_appointment'] : array();
    $reason_for_appointment = array_map( 'esc_attr', $reason_for_appointment );


    $admin_subject = "Client Scheduled Appointment with Additional Information";
    $headers = 'From: BusinessBrainz <hello@businessbrainz.com>' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n" ;
    ob_start();
    include ('cta-emai-admin-template.php');
    $admin_body = ob_get_contents();
    ob_end_clean();
    $result = wp_mail( 'contact@businessbrainz.com', $admin_subject, $admin_body, $headers );
    $response['success'] = $result;
    echo json_encode($response);
    wp_die();
}


add_action('wp_ajax_businessBrainz_search_reports', 'businessBrainz_search_reports');
add_action('wp_ajax_nopriv_businessBrainz_search_reports', 'businessBrainz_search_reports');

function businessBrainz_search_reports()
{
    $search_query = $_POST['search_query'];
    global $wpdb;
    $result_posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title LIKE '%s' AND post_type = 'reports' AND post_status  = 'publish'",
                                                      '%' . $wpdb->esc_like($search_query) . '%'));
    $html         = '';
    if(!empty($result_posts)):
        foreach ($result_posts as $result_post) {
            $post = get_post($result_post);
            $id   = $result_post->ID;
            $html .= '<div class="col-md-4 fix-width-3 card report-box mt-2">';
            $html .= '<a href="' . get_permalink($id) . '" >';
            $html .= '<div style="background: url('. get_the_post_thumbnail_url($id,'thumbnail') .');background-repeat:no-repeat;background-position: center; height: 200px"></div>';
            $html .= '<div class="card-body single-report-content">';
            $html .= '<div class="title">' . $result_post->post_title . '</div>';
            $html .= '<div class="category">' . show_sectors($id) . '</div>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';

        }
    else:
        $html .= '<div class="col-12 mt-5 text-center">';
        $html .= '<h3>No reports found</h3>';
        $html .= '</div>';
    endif;
    $response['success'] = true;
    $response['html']    = $html;
    echo json_encode($response);
    wp_die();

}

function businessbrainz_get_terms_for_taxonomy($taxonomy)
{
    $term_args = array(
        'post_type'  => 'reports',
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'fields'     => 'all',
    );

    return (new WP_Term_Query($term_args))->terms;
}

function businessbrainz_get_wp_query_args($offset = false, $category = false, $orderby = false, $posts_per_page = 6)
{
    $args = array(
        'post_type'      => 'reports',
        'order'          => 'ASC',
        'posts_per_page' => $posts_per_page,
    );
    if($orderby){
        $args['orderby'] = $orderby;
    }
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'report_category',
                'field'    => 'slug',
                'terms'    => $category,
            )
        );
    }
    if($offset){
        $args['offset'] = $offset;
    }
    return $args;
}

function get_sectors_for_specific_post( $post_id , $slug = true){
    $term_slugs = [];
    $sectors = get_the_terms( get_the_ID(), 'sectors' );
    if($sectors){
        if($slug){
            foreach($sectors as $terms){
                $term_slugs[] = $terms->slug;
            }
        }else{
            foreach($sectors as $terms){
                $term_slugs[] = $terms->name;
            }
        }
    }


    return $term_slugs;
}


add_filter('post_type_link', 'projectcategory_permalink_structure', 10, 4);
function projectcategory_permalink_structure($post_link, $post, $leavename, $sample)
{
    if (false !== strpos($post_link, '%report_category%')) {
        $projectscategory_type_term = get_the_terms($post->ID, 'report_category');
        if (!empty($projectscategory_type_term)) {
            $post_link = str_replace('%report_category%', array_pop($projectscategory_type_term)->
            slug, $post_link);
        }
        else {
            $post_link = str_replace('%report_category%', 'uncategorized', $post_link);
        }
    }

    return $post_link;
}

function show_sectors($post_id){
    $sectors = get_sectors_for_specific_post($post_id, false);
    $length = count($sectors);
    $result = null;
    foreach ($sectors as $index => $names) {
        $result = ($index === $length - 1)? $names :  $names . ", ";
    }
    return $result;
}

function businsesBrainz_custom_tracker() {
    do_action('businsesBrainz_custom_tracker');
}


class businessbrainz_display_reports extends WP_Widget
{

// The construct part
    function __construct()
    {
        parent::__construct(
            'businessbrainz_display_reports',
            __('Lastest Report', 'businessbrainz_display_reports'),
            array( 'description' => __( 'Shows latest 5 reports', 'businessbrainz_display_reports' ), )
        );
    }

// Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<aside id="categories-2" class="widget widget_categories">
                <h2 class="widget-title">Reports</h2>
                    <nav role="navigation" aria-label="Recent Posts">
		                <ul>';
        $the_query = new WP_Query(array(
                                      'post_type'      => 'reports',
                                      'order'          => 'DESC',
                                      'posts_per_page' => 5,
                                  ));
        if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) :
                $the_query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endwhile; ?>
            </ul>
            </nav>
            </aside>
            <?php wp_reset_postdata();
        endif;
    }

}

function wpb_load_widget() {
    register_widget( 'businessbrainz_display_reports' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


add_action('businsesBrainz_custom_tracker','data_tracker_code');
function data_tracker_code() {
    global $wp_query;
    $postid = $wp_query->post->ID;
    the_field('google_tags',$postid);
    wp_reset_query();
}

function add_query_vars($query_param) {
    $query_param[] = "reportDownloaded"; // represents the name of the product category as shown in the URL
    return $query_param;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function render_category_list( $terms = null){
    $categories = businessbrainz_get_terms_for_taxonomy('report_category');
    foreach ($categories as $category){ ?>
        <a href="/reports/<?php echo $category->slug?>" <?php if($terms && $terms->slug === $category->slug): echo "class='active'";  endif;?>><li><?php echo $category->name ?></li></a>
    <?php }
}

add_action('wp_ajax_businessBrainz_send_report_email', 'businessBrainz_send_report_email');
add_action('wp_ajax_nopriv_businessBrainz_send_report_email', 'businessBrainz_send_report_email');
function businessBrainz_send_report_email(){
    $name = $_POST['name'] === '' ? null : sanitize_text_field($_POST['name']);
    $email = $_POST['email'] === '' ? null : sanitize_text_field($_POST['email']);
    $company = $_POST['company'] === '' ? null : sanitize_text_field($_POST['company']);
    $post_id = $_POST['post_id'] === '' ? null : sanitize_text_field($_POST['post_id']);
    $file = get_field('report_file',$post_id);
    if(is_null($name) ||is_null($email) ||is_null($company) ){
        wp_die(['message' => 'Required field is not filled']);
    }

    if( $file ):
        $filename = $file['filename'];
        $url = $file['url'];
        $subject = "Reports from Business Brainz";
        $admin_subject = "Reports Downloaded from Business Brainz";
        $headers = 'From: BusinessBrainz <hello@businessbrainz.com>' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n" ;
        ob_start();
        include ('report-email-template.php');
        $body = ob_get_contents();
        ob_end_clean();
        ob_start();
        include ('report-email-admin-template.php');
        $admin_body = ob_get_contents();
        ob_end_clean();
        wp_mail( $email, $subject, $body, $headers, array($url) );
        wp_mail( 'contact@businessbrainz.com', $admin_subject, $admin_body, $headers );
    endif;
}

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
                             'page_title' 	=> 'Custom Settings',
                             'menu_title'	=> 'Custom Settings',
                             'menu_slug' 	=> 'custom-settings',
                             'capability'	=> 'edit_posts',
                             'redirect'		=> false
                         ));

}

function render_schema_data($page)
{
    switch ($page) {
        //Homepage
        case 11: ?>
            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Organization",
                    "name": "Business Brainz : ABM Research Agency",
                    "alternateName": "BBZ: Account-Based Marketing Research Agency",
                    "url": "https://www.businessbrainz.com/",
                    "logo": "https://www.businessbrainz.com/wp-content/uploads/2020/08/cropped-Business-Brainz-old-1-120x120.png",
                    "sameAs": [
                        "https://www.linkedin.com/company/business-brainz/",
                        "https://twitter.com/BusinessBrainz_",
                        "https://www.youtube.com/channel/UC3nsl_KJdmp3PTJjDfwjbyg"
                    ]
                }
            </script>
            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "LocalBusiness",
                    "name": "Business Brainz: ABM Research Agency",
                    "image": "https://www.businessbrainz.com/wp-content/uploads/2020/08/cropped-Business-Brainz-old-1-120x120.png",
                    "@id": "",
                    "url": "https://www.businessbrainz.com/",
                    "telephone": "+977 01 6923254",
                    "priceRange": "$$$",
                    "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "Anamnagar",
                        "addressLocality": "Kathmandu",
                        "postalCode": "44600",
                        "addressCountry": "NP"
                    },
                    "openingHoursSpecification": {
                        "@type": "OpeningHoursSpecification",
                        "dayOfWeek": [
                            "Monday",
                            "Tuesday",
                            "Wednesday",
                            "Thursday",
                            "Friday",
                            "Sunday"
                        ],
                        "opens": "09:00",
                        "closes": "18:00"
                    }
                }
            </script>
            <?php break;
        //Industry Insights
        case 336: ?>
            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@graph": [
                        {
                            "@type": "WebSite",
                            "@id": "https://www.businessbrainz.com/#website",
                            "url": "https://www.businessbrainz.com/",
                            "name": "ABM Research Agency | Account Based Marketing Services | Business Brainz",
                            "description": "We are an Account-Based Marketing Research Agency specialized in building bespoke account profiles and industry insights to help B2B sales and marketing teams.",
                            "potentialAction": [
                                {
                                    "@type": "SearchAction",
                                    "target": "https://businessbrainz.com/?s={search_term_string}",
                                    "query-input": "required name=search_term_string"
                                }
                            ],
                            "inLanguage": "en-US"
                        },
                        {
                            "@type": "WebPage",
                            "@id": "https://www.businessbrainz.com/services/industry-insight/#webpage",
                            "url": "https://www.businessbrainz.com/services/industry-insight/",
                            "name": "Tailor-made Industry Insight | Industry Research Reports | Business Brainz",
                            "isPartOf": {
                                "@id": "https://businessbrainz.com/#website"
                            },
                            "datePublished": "2020-01-11T14:16:19+00:00",
                            "dateModified": "2020-02-20T11:30:54+00:00",
                            "description": "Highly tailored Industry Insight solution to empower ABM campaigns with industry-level intelligence.",
                            "inLanguage": "en-US",
                            "potentialAction": [
                                {
                                    "@type": "ReadAction",
                                    "target": [
                                        "https://www.businessbrainz.com/services/industry-insight/"
                                    ]
                                }
                            ]
                        }
                    ]
                }</script>
            <?php break;
        //Account Insight
        case 333: ?>
            <script type="application/ld+json">
                {
                    "@context":"https://schema.org",
                    "@graph":[
                        {
                            "@type":"WebSite",
                            "@id":"https://www.businessbrainz.com/#website",
                            "url":"https://www.businessbrainz.com/",
                            "name":"ABM Research Agency | Account Based Marketing Services | Business Brainz",
                            "description":"We are an Account-Based Marketing Research Agency specialized in building bespoke account profiles and industry insights to help B2B sales and marketing teams.",
                            "potentialAction":[
                                {
                                    "@type":"SearchAction",
                                    "target":"https://businessbrainz.com/?s={search_term_string}",
                                    "query-input":"required name=search_term_string"
                                }
                            ],
                            "inLanguage":"en-US"
                        },
                        {
                            "@type":"WebPage",
                            "@id":"https://www.businessbrainz.com/services/abm-account-insight/#webpage",
                            "url":"https://www.businessbrainz.com/services/abm-account-insight/",
                            "name":"Account Insight on Your Target Accounts | ABM Account Profiles | Business Brainz",
                            "isPartOf":{
                                "@id":"https://businessbrainz.com/#website"
                            },
                            "datePublished":"2020-01-11T14:16:19+00:00",
                            "dateModified":"2020-02-20T11:30:54+00:00",
                            "description":"Custom account insight solution on your enterprise accounts to give deep-dive intelligence at an account level.",
                            "inLanguage":"en-US",
                            "potentialAction":[
                                {
                                    "@type":"ReadAction",
                                    "target":[
                                        "https://www.businessbrainz.com/services/abm-account-insight/"
                                    ]
                                }
                            ]
                        }
                    ]
                }</script>
            <?php break;
        //Competitive Intelligence
        case 339: ?>
            <script type="application/ld+json">
                {
                    "@context":"https://schema.org",
                    "@graph":[
                        {
                            "@type":"WebSite",
                            "@id":"https://www.businessbrainz.com/#website",
                            "url":"https://www.businessbrainz.com/",
                            "name":"ABM Research Agency | Account Based Marketing Services | Business Brainz",
                            "description":"We are an Account-Based Marketing Research Agency specialized in building bespoke account profiles and industry insights to help B2B sales and marketing teams.",
                            "potentialAction":[
                                {
                                    "@type":"SearchAction",
                                    "target":"https://businessbrainz.com/?s={search_term_string}",
                                    "query-input":"required name=search_term_string"
                                }
                            ],
                            "inLanguage":"en-US"
                        },
                        {
                            "@type":"WebPage",
                            "@id":"https://www.businessbrainz.com/services/competitive-intelligence/#webpage",
                            "url":"https://www.businessbrainz.com/services/competitive-intelligence/",
                            "name":"Insights on Your Competitors | Competitive Intelligence | Business Brainz",
                            "isPartOf":{
                                "@id":"https://businessbrainz.com/#website"
                            },
                            "datePublished":"2020-01-11T14:16:19+00:00",
                            "dateModified":"2020-02-20T11:30:54+00:00",
                            "description":"Insight solution to help clients uncover competitor practices and reveal actionable insights to drive business.",
                            "inLanguage":"en-US",
                            "potentialAction":[
                                {
                                    "@type":"ReadAction",
                                    "target":[
                                        "https://www.businessbrainz.com/services/competitive-intelligence/"
                                    ]
                                }
                            ]
                        }
                    ]
                }</script>
            <?php break;
    }
}


function pricing_table_1() {
  ?>
    <style>
        .pricing_table_wrapper .pricing_table_header {
            font-size: 1.5rem;
            color: #013F59;
        }

        .pricing_table_wrapper .pricing_table th {
            background: #013F59;
            color: #FBCF42;
            font-size: 1.3rem;
        }
    </style>

    <div class="pricing_table_wrapper">
        <h2 class="pricing_table_header"> In-depth Account Insight</h2>
        <table class="pricing_table">
            <thead>
            <tr>
                <th style="width: 20%">Insight Covered</th>
                <th style="width: 75%">More about the Insight</th>
                <th style="width: 5%"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Account Overview</td>
                <td>General overview of the target account.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Key Decision Makers</td>
                <td>List of key decision-makers and influencers in the account.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Strategic Priorities </td>
                <td>Detailed analysis of the company’s core strategies, goals and targets, initiatives taken, outcomes, partners, journey, and progress.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Business Challenges</td>
                <td>Analysis of key pain points and major challenges faced by the account</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Custom Insight Section</td>
                <td>Detailed analysis of custom section based upon your selection per client’s need. We've built insight reports to help firms in IT and Telecom, Marketing and Sales, SaaS, Supply chain and Logistics, and Manufacturing, among others.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Financial Highlights</td>
                <td>Quick overview of the company's financial health, and high-level analysis of the past 5 years.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Opportunity Identification</td>
                <td>Matching the target company’s insights, challenges, investment plans, and strategies with the client’s offering to uncover potential business opportunities</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php
}
add_shortcode('pricing_table_1', 'pricing_table_1');


function pricing_table_2() {
  ?>
    <style>
        .pricing_table_wrapper .pricing_table_header {
            font-size: 1.5rem;
            color: #013F59;
        }

        .pricing_table_wrapper .pricing_table th {
            background: #013F59;
            color: #FBCF42;
            font-size: 1.3rem;
        }
    </style>

    <div class="pricing_table_wrapper">
        <h2 class="pricing_table_header">In-depth Industry Insight</h2>
        <table class="pricing_table">
            <thead>
            <tr>
                <th style="width: 20%">Insight Covered</th>
                <th style="width: 75%">More about the Insight</th>
                <th style="width: 5%"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Industry Overview </td>
                <td>Detailed overview of the target industry including market size, growth factors, key players among others.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Industry Trends</td>
                <td>Detailed analysis of industry trends supported by hard data and real-life examples.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>CIO/ Technology Trends </td>
                <td>Detailed analysis of technology shaping up the industry supported by hard data and real-life examples.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Key Quotes</td>
                <td>Quotes by key players and industry leaders regarding the industry.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Case Study</td>
                <td>Overview of case studies most relevant to the research brief.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            <tr>
                <td>Industry Challenges</td>
                <td>Major challenges and pain points observed in the industry.</td>
                <td>
                    <img src="https://businessbrainz.com/wp-content/uploads/2022/06/pngfind.com-check-box-png-198669.png"
                         alt="checkbox" width="20" height="20"></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php
}
add_shortcode('pricing_table_2', 'pricing_table_2');


function custom_image(){
    ?>
    <style>
        .custom_image_wrapper{
            position: relative;
        }

        .area_1{
            width: 84px;
            height: 44px;
            position: absolute;
            top: 82px;
            left: 443px;
        }

        .area_2{
            width: 112px;
            height: 50px;
            position: absolute;
            top: 165px;
            left: 431px;
        }

        .area_3{
            width: 200px;
            height: 50px;
            position: absolute;
            top: 266px;
            left: 383px;
        }

        @media screen and (max-width: 1024px) {
            .area_1{
                top: 74px;
                left: 393px;
            }

            .area_2{
                top: 147px;
                left: 380px;
            }

            .area_3{
                top: 240px;
                left: 339px;
            }
        }

        @media screen and (max-width: 768px) {
            .area_1{
                top: 40px;
                left: 281px;
            }

            .area_2{
                top: 99px;
                left: 268px;
            }

            .area_3{
                top: 170px;
                left: 225px;
            }
        }

        @media screen and (max-width: 425px) {
            .area_1, .area_2, .area_3{
                display: none
            }
        }

    </style>
    <div class="custom_image_wrapper">
        <a href="/reports/abm-company-profile-reports/" target="_blank"><div class="area_1"></div></a>
        <a href="/reports/one-to-few-abm-reports/" target="_blank"><div class="area_2"></div></a>
        <a href="/reports/one-to-many-reports/" target="_blank"><div class="area_3"></div></a>
        <img src="https://businessbrainz.com/wp-content/uploads/2022/08/Pyramid-Banner-copy-1-1-scaled.jpg" alt="abm pyramid">
    </div>

<?php
}
add_shortcode('custom_image', 'custom_image');



function report_slider(){
    $the_query = new WP_Query(businessbrainz_get_wp_query_args(false, false, 'rand', 12));
    if ($the_query->have_posts()) : ?>
    <style>
        .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev{
            outline: none !important;
        }
    </style>
            <div class="report-slider owl-carousel owl-theme">
                <?php while ($the_query->have_posts()) :$the_query->the_post(); ?>
                    <div class="item card" style="border: none">
                        <a href="<?php the_permalink(); ?>">
                            <div style="background: url('<?php the_post_thumbnail_url('thumbnail'); ?>');background-repeat:no-repeat;background-position: center; height: 200px"></div>
                            <div class="card-body single-report-content">
                                <div class="title"><?php the_title(); ?></div>
                                <div class="category"><?php echo show_sectors(get_the_ID()); ?></div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php wp_reset_postdata();
    else: ?>
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h3>No reports found</h3>
            </div>
        </div>
    <?php endif;
}



add_shortcode('report_slider', 'report_slider');

function abm_coe(){
    ?>
    <style>
        .custom_image_wrapper{
            position: relative;
        }

        .area_1{
            width: 170px;
            height: 70px;
            position: absolute;
            top: 100px;
            left: 300px;

        }

        .area_2{
            width: 183px;
            height: 70px;
            position: absolute;
            top: 97px;
            left: 540px;
        }

        .area_3{
            width: 200px;
            height: 70px;
            position: absolute;
            top: 300px;
            left: 650px;

        }

        .area_4{
            width: 200px;
            height: 70px;
            position: absolute;
            top: 509px;
            left: 532px;

        }

        .area_5{
            width: 200px;
            height: 90px;
            position: absolute;
            top: 509px;
            left: 294px;

        }

        .area_6{
            width: 200px;
            height: 90px;
            position: absolute;
            top: 300px;
            left: 176px;

        }

        @media screen and (max-width: 1024px) {
            .area_1{
                top: 95px;
                left: 285px;
            }

            .area_2{
                top: 95px;
                left: 508px;
            }

            .area_3{
                top: 285px;
                left: 618px;
            }

            .area_4{
                top: 482px;
                left: 512px;
            }

            .area_5{
                top: 482px;
                left: 285px;
            }

            .area_6{
                top: 285px;
                left: 173px;
            }


        }

        @media screen and (max-width: 768px) {
            .area_1{
                top: 66px;
                left: 208px;
                height: 55px;
                width: 130px;
            }

            .area_2{
                top: 66px;
                left: 378px;
                height: 55px;
                width: 130px;
            }

            .area_3{
                top: 212px;
                left: 462px;
                height: 55px;
                width: 130px;
            }
            .area_4{
                top: 360px;
                left: 380px;
                height: 55px;
                width: 130px;
            }
             .area_5{
                top: 360px;
                left: 214px;
                height: 60px;
                width: 130px;
            }
             .area_6{
                top: 206px;
                left: 130px;
                height: 60px;
                width: 130px;
            }

        }

        @media screen and (max-width: 425px) {
            .area_1, .area_2, .area_3,.area_4, .area_5, .area_6{
                display: none
            }
        }

    </style>
    <div class="custom_image_wrapper">
        <a href="/reports/abm-company-profile-reports/" target="_blank"><div class="area_1"></div></a>
        <a href="/reports/one-to-few-abm-reports/" target="_blank"><div class="area_2"></div></a>
        <a href="/reports/one-to-many-reports/" target="_blank"><div class="area_3"></div></a>
        <a href="/reports/one-to-many-reports/" target="_blank"><div class="area_4"></div></a>
        <a href="/reports/one-to-many-reports/" target="_blank"><div class="area_5"></div></a>
        <a href="/reports/one-to-many-reports/" target="_blank"><div class="area_6"></div></a>
        <img src="https://businessbrainz.com/wp-content/uploads/2022/09/ABM.png" alt="abm coe">
    </div>

    <?php
}
add_shortcode('abm_coe', 'abm_coe');
