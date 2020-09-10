<?php

/**
 * This file is part of the Lasalle Software library front-end package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2020 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see        https://lasallesoftware.ca
 * @see        https://packagist.org/packages/lasallesoftware/ls-libraryfrontend-pkg
 * @see        https://github.com/LaSalleSoftware/ls-libraryfrontend-pkg
 */

return [

    /*
    |--------------------------------------------------------------------------
    | The name of this LaSalle Software app being installed?
    |--------------------------------------------------------------------------
    |
    | There are two right now:
    | * adminbackendapp
    | * basicfrontendapp
    |
    | There can be many front ends, but only one administrative backend.
    |
    | The admin backend is the only one with a database, and with access to certain
    | features and database tables.
    |
    */
	'lasalle_app_name' => env('LASALLE_APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | The app's URL, without the "https://"
    |--------------------------------------------------------------------------
    |
    | Best explained by example: if the app's URL is "https://admin.DoubleTrouble.com",
    | then this is "admin.DoubleTrouble.com".
    |
    */
    'lasalle_app_domain_name' => env('LASALLE_APP_DOMAIN_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Admin app's URL
    |--------------------------------------------------------------------------
    |
    | The admin app's full URL.
    |
    */
    'lasalle_admin_api_url' => env('LASALLE_ADMIN_API_URL'),

    /*
    |--------------------------------------------------------------------------
    | The key this front-end application uses for JWT
    |--------------------------------------------------------------------------
    |
    | JWT is encrypted using this key.
    |
    | The administrative backend app must have this key to decrypt the JWT.
    |
    | Set in the .env file.
    |
    */
    'lasalle_jwt_key' => env('LASALLE_JWT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Json Web Token AUD claim
    |--------------------------------------------------------------------------
    |
    | URL of the admin app, without the "https://".
    |
    | Must be in the installed_domains db table, specified in the title field.
    |
    */
    'lasalle_jwt_aud_claim' => env('LASALLE_JWT_AUD_CLAIM'),

    /*
	|--------------------------------------------------------------------------
	| Json Web Token EXP claim duration
	|--------------------------------------------------------------------------
	|
    | How many seconds until a JWT expires?
    |
    | This EXP claim is set in the front-end domain, so you'll want all your domains 
    | set with the same number.
	|
    | https://tools.ietf.org/html/rfc7519#section-4.1.4
	|
	*/
    'lasalle_jwt_exp_claim_seconds_to_expiration' => 3600,

    /*
	|--------------------------------------------------------------------------
	| Date Format
	|--------------------------------------------------------------------------
	|
    | What date format do you want for your front-end views?
    |
	| https://www.php.net/manual/en/function.date.php
	|
	*/
    'lasalle_date_format'  => 'F d, Y',

    /*
	|--------------------------------------------------------------------------
	| Pagination: How Many Items To Display "Per Page"
	|--------------------------------------------------------------------------
	|
	| When displaying a list of items, such as a list of blog posts, how many items do you want
	| to display? For example, if there are 100 blog posts, do you want to display all 100 posts? Probably
	| not. Instead, you probably want to display, say, 15 blog posts at a time. In which case, set this
    | config parameter to "15"
    |
    | https://laravel.com/docs/6.x/pagination
    |
	*/
    //'lasalle_pagination_number_of_items_displayed_per_page'  => 'none',
    'lasalle_pagination_number_of_items_displayed_per_page'  => 6,

    /*
	|--------------------------------------------------------------------------
	| Front-end blade view folder's path
	|--------------------------------------------------------------------------
	|
	| Where is the blade folder that you are using?
	|
    | The LaSalle UI package's "base" folder is the default.
	|
	*/
    'lasalle_path_to_front_end_view_path' => 'lasallesoftwarelasalleuifrontend::base',


    /*
	|--------------------------------------------------------------------------
	| Default Featured Image
	|--------------------------------------------------------------------------
	|
	| When no featured image is specified, use this image.
	|
	| Specify the type of image by commenting out the types that do not apply.
    |  * "external_file" = what you want in the "src" of the IMG html tag (<img src="" >)
    |                      such as a full URL where the image resides, or base64 code
    |  * "code" = the entire html code encompassing the image, that will be rendered in html literally
	|
	*/
    'lasalle_featured_image_default_type'  => 'external_file',
    //'lasalle_featured_image_default_type'  => 'code',
    'lasalle_featured_image_default_image' => '/nature1.jpg',

    /*
	|--------------------------------------------------------------------------
	| Number of Recent Blog Posts to Display on the Home Page
	|--------------------------------------------------------------------------
	|
	| How many recent blog posts do you want to display on the home page? 
	|
	| If you select "0" (zero), then perhaps you should bypass the home page controller.
	|
	*/
    'lasalle_number_of_recent_blog_posts_to_display_on_the_home_page'  => 5,

    /*
	|--------------------------------------------------------------------------
	| Social Media Meta Tag: Twitter Handle for the "twitter:site" tag
	|--------------------------------------------------------------------------
	|
    | This is a Twitter handle, such as '@bobbloom'.
    |
	| For the twitter:site meta tag
	|
	*/
    'lasalle_social_media_meta_tag_site'  => '@bobbloom',

    /*
	|--------------------------------------------------------------------------
	| Social Media Meta Tag: Twitter Handle for the "twitter:creator" tag
	|--------------------------------------------------------------------------
	|
    | This is a Twitter handle, such as '@bobbloom'.
    |
	| For the twitter:creator meta tag.
	|
	*/
    'lasalle_social_media_meta_tag_creator'  => '@bobbloom',

    /*
	|--------------------------------------------------------------------------
	| Default Social Media Tag Image
	|--------------------------------------------------------------------------
	|
	| When no social media image is specified, use this image.
	|
	| Specify the full URL!
	|
	| A social media tag is a Twitter card meta tag, or an Open Graph meta card, or something of that nature.
    |
	| According to https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/markup,
	| "URL of image to use in the card. Images must be less than 5MB in size. JPG, PNG, WEBP and GIF
	| formats are supported. Only the first frame of an animated GIF will be used. SVG is not supported."
	|
	*/
    'lasalle_social_media_meta_tag_default_image'  => 'https://lasallesoftware.ca/nature1.jpg',
    
    /*
	|--------------------------------------------------------------------------
	| Preview in the front-end token
	|--------------------------------------------------------------------------
	|
	| When available, such as an individual blog post, you can view in the front-end but not display to the whole world.
	|
	| You have to set the "preview_in_frontend" field to true (and "enabled" to false), and then
	| append your URL with "?preview_in_frontend=value-of-this-parameter".
	| 
    |  *** PLEASE DO NOT SET TO THE DEFAULT VALUE, BECAUSE THIS IS OPEN SOURCE SOFTWARE SO EVERYONE KNOWS THIS DEFAULT VALUE! ***
	| 
	| Please use a text string that is hard to guess
	| 
	*/
	'preview_in_frontend_token' => 'default-preview-in-frontend-token',

];
