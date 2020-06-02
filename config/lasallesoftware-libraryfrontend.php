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
 * @see       https://lasallesoftware.ca
 * @see       https://packagist.org/packages/lasallesoftware/ls-libraryfrontend-pkg
 * @see       https://github.com/LaSalleSoftware/ls-libraryfrontend-pkg
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
   | ========================================================================
   | START: PATHS FOR FEATURED IMAGES
   | ========================================================================
   |
   | You may want to store featured image images (!) in S3 folders, and not just
   | in S3 buckets. And, you may want store Nova resource featured images in
   | their own folders. You can specify individual S3 folders here for profile
   | and blog resources.
   |
   | Must have a leading slash.
   | Must not have a trailing slash.
   |
   | Do not want to use an S3 folder at all? Just put the images in the S3 bucket?
   | Then, just specify '/',
   |
   | I designed this specifically for S3, but it applies generally because Nova
   | uses Laravel's storage facade
   | * https://laravel.com/docs/master/filesystem
   | * https://nova.laravel.com/docs/2.0/resources/file-fields.html#file-fields
   |
   | IMPORTANT!!! ****You need to set up each S3 folder in your AWS console.****
   | See https://github.com/LaSalleSoftware/ls-adminbackend-app/blob/master/AWS_S3_NOTES_README.md
   |
   */

    // for Nova resources in the novabackend package
    'image_path_for_address_nova_resource' => '/',
    //'image_path_for_address_nova_resource' => '/address',

    'image_path_for_company_nova_resource' => '/',
    //'image_path_for_company_nova_resource' => '/company',

    'image_path_for_person_nova_resource'  => '/',
    //'image_path_for_person_nova_resource'  => '/person',


    // for Nova resources in the blogbackend package
    'image_path_for_category_nova_resource' => '/',
    //'image_path_for_category_nova_resource' => '/category',

    'image_path_for_post_nova_resource'     => '/',
    //'image_path_for_post_nova_resource'     => '/post',

    /*
   | ========================================================================
   | END: PATHS FOR FEATURED IMAGES
   | ========================================================================
   */

];
