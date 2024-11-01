<?php
$shaplatools_settings_page = new ShaplaTools_Settings_API;

// Add settings page
$shaplatools_settings_page->add_menu([
    'parent_slug'  => 'options-general.php',
    'page_title'   => __('ShaplaTools Settings', 'shaplatools' ),
    'menu_title'   => __('ShaplaTools', 'shaplatools' ),
    'capability'   => 'manage_options',
    'menu_slug'    => 'shaplatools',
    'option_name'  => 'shaplatools_options',
]);

// Add settings page tab
$shaplatools_settings_page->add_tab([
    'id' 	=> 'general',
    'title' => __('General', 'shaplatools'),
]);
$shaplatools_settings_page->add_tab([
    'id' 	=> 'post_type',
    'title' => __('Custom Post Type', 'shaplatools'),
]);
$shaplatools_settings_page->add_tab([
    'id' 	=> 'social_link',
    'title' => __('Social Link', 'shaplatools'),
]);

// Add general settings page fields
$shaplatools_settings_page->add_field([
    'id'    => 'google_analytics',
    'type'  => 'text',
    'name'  => __('Google Analytics ID', 'shaplatools'),
    'desc'  => sprintf(
        __( 'In order to use Google Analytics service, go to %s Google Analytics %s and click Access Google Analytics and register for a service for your site. You will get a Google Analytics ID like this formate (UA-XXXXX-X), paste this ID in Google Analytics ID field and click save.', 'shaplatools' ),
        '<a href="https://www.google.com/analytics/" target="_blank">',
        '</a>'
    ),
    'std'   => '',
    'tab'   => 'general'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'google_map_api_key',
    'type'  => 'text',
    'name'  => __('Google Maps API key', 'shaplatools'),
    'desc'  => sprintf(
    	__( 'An API key is required for Google Maps shortcode to work. Here is how you can %1$s get a key %2$s.', 'shaplatools' ),
    	'<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">',
        '</a>'
    ),
    'std'   => '',
    'tab'   => 'general'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'typeahead_search',
    'type'  => 'radio',
    'name'  => __('Autocomplete Search', 'shaplatools'),
    'desc'  => sprintf(
    	__('Autocomplete search form use %s twitter typeahead.js JavaScript library %s for AJAX search. In order to use this feature select "WordPress Default Search" to enable AJAX search for WordPress default search or select "WooCommerce Product Search" to enable WooCommerce products search.', 'shaplatools'),
    	'<a href="https://twitter.github.io/typeahead.js/" target="_blank">',
        '</a>'
    ),
    'std'   => 'no_search',
    'options' => array(
        'no_search'   		=> __('Disabled', 'shaplatools'),
        'default_search' 	=> __('WordPress Default Search', 'shaplatools'),
        'product_search'  	=> __('WooCommerce Product Search', 'shaplatools')
    ),
    'tab'   => 'general'
]);

$shaplatools_settings_page->add_field([
    'id'    => 'shapla_retina_graphics',
    'type'  => 'multi_checkbox',
    'name'  => __('Retina graphics for your website', 'shaplatools'),
    'desc'  => sprintf(
        __('To serve high-resolution images to devices with retina displays. This plugin will use open source script %s retina.js JavaScript library %s and for using retina.js script, a higher quality version of image will be created and stored with @2x added to the filename when an image is uploaded.', 'shaplatools'),
        '<a href="http://imulus.github.io/retinajs/" target="_blank">',
        '</a>'
    ),
    'std'   => array(),
    'options' => array(
        'retina_js'       => __('Load retina.js JavaScript library', 'shaplatools'),
        'retina_image'   => __('Enable retina image', 'shaplatools'),
    ),
    'tab'   => 'general'
]);

// Add post type settings page fields
$shaplatools_settings_page->add_field([
    'id'    => 'shapla_slide',
    'type'  => 'multi_checkbox',
    'name'  => __('Slide', 'shaplatools'),
    'std'   => array(),
    'options' => array(
        'slide_post_type'   	=> __('Enable Slide Post Type', 'shaplatools'),
        'slide_metabox'  		=> __('Enable Slide Default Metabox', 'shaplatools')
    ),
    'tab'   => 'post_type'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'shapla_portfolio',
    'type'  => 'multi_checkbox',
    'name'  => __('Portfolio', 'shaplatools'),
    'std'   => array(),
    'options' => array(
        'portfolio_post_type'   	=> __('Enable Portfolio Post Type', 'shaplatools'),
        'portfolio_metabox'  		=> __('Enable Portfolio Default Metabox', 'shaplatools')
    ),
    'tab'   => 'post_type'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'shapla_team',
    'type'  => 'multi_checkbox',
    'name'  => __('Team', 'shaplatools'),
    'std'   => array(),
    'options' => array(
        'team_post_type'   	=> __('Enable Team Post Type', 'shaplatools'),
        'team_metabox'  		=> __('Enable Team Default Metabox', 'shaplatools')
    ),
    'tab'   => 'post_type'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'shapla_testimonial',
    'type'  => 'multi_checkbox',
    'name'  => __('Testimonial', 'shaplatools'),
    'std'   => array(),
    'options' => array(
        'testimonial_post_type'   	=> __('Enable Testimonial Post Type', 'shaplatools'),
        'testimonial_metabox'  		=> __('Enable Testimonial Default Metabox', 'shaplatools')
    ),
    'tab'   => 'post_type'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'shapla_feature',
    'type'  => 'multi_checkbox',
    'name'  => __('Feature', 'shaplatools'),
    'std'   => array(),
    'options' => array(
        'feature_post_type'   	=> __('Enable Feature Post Type', 'shaplatools'),
        'feature_metabox'  		=> __('Enable Feature Default Metabox', 'shaplatools')
    ),
    'tab'   => 'post_type'
]);

// Add social link settings page fields
$shaplatools_settings_page->add_field([
    'id'    => 'android',
    'type'  => 'url',
    'name'  => __('Android', 'shaplatools'),
    'tab'   => 'social_link'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'apple',
    'type'  => 'url',
    'name'  => __('Apple', 'shaplatools'),
    'tab'   => 'social_link'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'behance',
    'type'  => 'url',
    'name'  => __('Behance', 'shaplatools'),
    'desc'  => 'e.g. https://www.behance.net/username',
    'tab'   => 'social_link'
]);
$shaplatools_settings_page->add_field([
    'id'    => 'bitbucket',
    'type'  => 'url',
    'name'  => __('Bitbucket', 'shaplatools'),
    'desc'  => 'e.g. https://bitbucket.org/username',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'codepen',
    'name' => __('CodePen', 'shaplatools'),
    'desc' => 'e.g. http://codepen.io/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'deviantart',
    'name' => __('Deviant Art', 'shaplatools'),
    'desc' => 'e.g. http://username.deviantart.com',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'dribbble',
    'name' => __('Dribbble', 'shaplatools'),
    'desc' => 'e.g. http://dribbble.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'dropbox',
    'name' => __('Dropbox', 'shaplatools'),
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'facebook',
    'name' => __('Facebook', 'shaplatools'),
    'desc' => 'e.g. http://www.facebook.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'flickr',
    'name' => __('Flickr', 'shaplatools'),
    'desc' => 'e.g. http://www.flickr.com/photos/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'foursquare',
    'name' => __('Foursquare', 'shaplatools'),
    'desc' => 'e.g. https://foursquare.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'github',
    'name' => __('GitHub', 'shaplatools'),
    'desc' => 'e.g. https://github.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'google-plus',
    'name' => __('Google+', 'shaplatools'),
    'desc' => 'e.g. https://plus.google.com/userID',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'instagram',
    'name' => __('Instagram', 'shaplatools'),
    'desc' => 'e.g. http://instagram.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'linkedin',
    'name' => __('LinkedIn', 'shaplatools'),
    'desc' => 'e.g. http://www.linkedin.com/in/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'mail',
    'name' => __('Mail', 'shaplatools'),
    'desc' => 'e.g. mailto:user@name.com',
    'type' => 'email',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'pinterest',
    'name' => __('Pinterest', 'shaplatools'),
    'desc' => 'e.g. http://pinterest.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'rss',
    'name' => __('RSS', 'shaplatools'),
    'desc' => 'e.g. http://example.com/feed',
    'type' => 'url',
    'tab'   => 'social_link',
]);

$shaplatools_settings_page->add_field([
    'id'   => 'skype',
    'name' => __('Skype', 'shaplatools'),
    'type' => 'text',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'stack-exchange',
    'name' => __('Stack Exchange', 'shaplatools'),
    'desc' => 'http://stackexchange.com/users/userID',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'stack-overflow',
    'name' => __('Stack Overflow', 'shaplatools'),
    'desc' => 'e.g. http://stackoverflow.com/users/userID',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'trello',
    'name' => __('Trello', 'shaplatools'),
    'desc' => 'e.g. https://trello.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'tumblr',
    'name' => __('Tumblr', 'shaplatools'),
    'desc' => 'e.g. http://username.tumblr.com',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'twitter',
    'name' => __('Twitter', 'shaplatools'),
    'desc' => 'e.g. http://twitter.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'vimeo',
    'name' => __('Vimeo', 'shaplatools'),
    'desc' => 'e.g. https://vimeo.com/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'vine',
    'name' => __('Vine', 'shaplatools'),
    'desc' => 'e.g. https://vine.co/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'windows',
    'name' => __('Windows', 'shaplatools'),
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'wordpress',
    'name' => __('WordPress', 'shaplatools'),
    'desc' => 'e.g. https://profiles.wordpress.org/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$shaplatools_settings_page->add_field([
    'id'   => 'xing',
    'name' => __('Xing', 'shaplatools'),
    'type' => 'url',
    'tab'   => 'social_link'
]);
$shaplatools_settings_page->add_field([
    'id'   => 'youtube',
    'name' => __('YouTube', 'shaplatools'),
    'desc' => 'e.g. http://www.youtube.com/user/username',
    'type' => 'url',
    'tab'   => 'social_link'
]);

$this->options = $shaplatools_settings_page->get_options();
$GLOBALS['shapla_social_link'] = $shaplatools_settings_page->filter_fields_by_tab('social_link');
