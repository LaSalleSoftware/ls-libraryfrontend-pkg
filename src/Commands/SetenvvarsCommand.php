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

namespace Lasallesoftware\Libraryfrontend\Commands;

// LaSalle Software class
use Illuminate\Console\ConfirmableTrait;

// Laravel classes
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Third party classes
use Symfony\Component\Console\Input\InputOption;


/**
 * Class LasalleinstallfrontendappCommand.
 */
class SetenvvarsCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lslibraryfrontend:setenvvars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the LaSalle Software specific environment variables in the .env file.';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (env('LASALLE_APP_NAME') != 'basicfrontendapp') {
            echo "\n\n";
            $this->line("This artisan command is specifically for my LaSalle Software's front-end application.");
            $this->line('You are installing my '.mb_strtoupper(env('LASALLE_APP_NAME')).' LaSalle Software application.');
            $this->line('So I am exiting you out of this artisan command.');
            $this->line('exiting...');
            $this->line('You are now exited from lslibraryfrontend:setenvvars.');
            echo "\n\n";

            return;
        }


        // -------------------------------------------------------------------------------------------------------------
        // START: INTRO
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->info('================================================================================');
        $this->info('                       Welcome to my LaSalle Software\'s');
        $this->info('               Front-end App\'s Environment Variable set-up Artisan Command!');
        $this->info('================================================================================');
        $this->info('  This command sets LaSalle Software specific environment variables ');
        $this->info('  in your .env file.');
        $this->info('================================================================================');

        if (file_exists($this->laravel->environmentFilePath())) {
            $this->info('  This is LaSalle Software\'s '.mb_strtoupper(env('LASALLE_APP_NAME')).' application.');
            $this->info('--------------------------------------------------------------------------------');
            $this->info('  This is your '.$this->getLaravel()->environment().' environment.');
            $this->info('--------------------------------------------------------------------------------');
        }

        $this->info('  This artisan command assumes that the LaSalle Software specific environment');
        $this->info('  variables exist in your .env with their original "dummy" values.');
        $this->info('================================================================================');
        $this->info('  Read my https://lasallesoftware.ca/docs/v2/gettingstarted_installation_frontendapp ');
        $this->info('   *BEFORE* running this command.');
        $this->info('================================================================================');
        $this->info('  Thank you for installing my LaSalle Software!');
        $this->info('  --Bob Bloom');
        $this->info('================================================================================');
        // -------------------------------------------------------------------------------------------------------------
        // END: INTRO
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: ARE YOU SURE YOU WANT TO RUN THIS COMMAND?
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->alert('Are you sure that you want to run this command?');
        $runConfirmation = $this->ask('<fg=yellow>(type the full word "yes" to continue)</>');

        if ($runConfirmation != strtolower('yes')) {
            $this->line('<fg=red;bg=yellow>You did *not* type "yes", so aborting this command. Bye!</>');
            $this->echoOutro();
            return;
        }
        $this->comment('ok... you said that you want to continue running this command. Let us continue then...');
        // -------------------------------------------------------------------------------------------------------------
        // END: ARE YOU SURE YOU WANT TO RUN THIS COMMAND?
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: CREATE THE .ENV FILE WHEN IT DOES NOT EXIST
        // -------------------------------------------------------------------------------------------------------------
        if (!file_exists($this->laravel->environmentFilePath())) {

            echo "\n\n";
            $this->line('-----------------------------------------------------------------------');
            $this->line('  .ENV file creation:');
            $this->line('-----------------------------------------------------------------------');
            $this->comment("Your environment file does not exist, so let's create it...");
            $this->makeEnv();
            $this->info("Your .env file now exists!");
        } 
        // -------------------------------------------------------------------------------------------------------------
        // END: CREATE THE .ENV FILE WHEN IT DOES NOT EXIST
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE APP_KEY PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        if (env('APP_KEY') == '') {
            echo "\n\n";
            $this->line('-----------------------------------------------------------------------');
            $this->line('  APP_KEY environment variable:');
            $this->line('-----------------------------------------------------------------------');
            $this->comment("Your APP_KEY environment variable has not been set.");
            $this->comment("So, let's set your APP_KEY environment variable now.");
            $this->comment('Setting your APP_KEY...');
            $this->call('key:generate');
            $this->info("Your env's APP_KEY is now set!");
        }
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE APP_KEY PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------




        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE APP_NAME PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  APP_NAME environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $this->comment("What is your application's name (APP_NAME)?");
        $this->comment('An example is: LaSalle Software Front-end Blog App');
        $appName = $this->ask('(I do *not* check for syntax or for anything, so please type c-a-r-e-f-u-l-l-y!)');
        $this->comment('You typed "'.$appName.'".');
        $this->comment('Attempting to set APP_NAME in your .env to "'.$appName.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyAppName', $appName, true);
        $this->info("Attempt to modify your env's APP_NAME to ".$appName.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE APP_NAME PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------




        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE APP_URL PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  APP_URL environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $this->comment("What is your application's full URL (APP_URL)?");
        $this->comment('  * MUST start with "http://" or "https://"');
        $this->comment('  * NO trailing slash!');
        $this->comment('  * example: https://lasallesoftware.ca');
        $this->comment('  * example: https://lasallesoftware.ca:8888');
        $appURL = $this->ask('(I do *not* check for syntax or for anything, so please type c-a-r-e-f-u-l-l-y!)');
        $this->comment('Attempting to set APP_URL in your .env to "'.$appURL.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyAppURL', $appURL, false);
        $this->info("Attempt to modify your env's APP_URL to ".$appURL.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE APP_URL PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE SET LASALLE_APP_DOMAIN_NAME PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  LASALLE_APP_DOMAIN_NAME environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $this->comment('This is done automatically based on your APP_URL.');
        $lasalleAppDomainName = $this->getLasalleAppDomainName($appURL);
        $this->comment('Attempting to set LASALLE_APP_DOMAIN_NAME in your .env to "'.$lasalleAppDomainName.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyLasalleAppDomainName', $lasalleAppDomainName, false);
        $this->info("Attempt to modify your env's LASALLE_APP_DOMAIN_NAME to ".$lasalleAppDomainName.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE SET LASALLE_APP_DOMAIN_NAME PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE LASALLE_JWT_KEY PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  LASALLE_JWT_KEY environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $lasalleJwtKey = Str::random(64);
        $this->comment('Attempting to set LASALLE_JWT_KEY in your .env to "'.$lasalleJwtKey.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyJwtKey', $lasalleJwtKey, false);
        $this->info("Attempt to modify your env's LASALLE_JWT_KEY to ".$lasalleJwtKey.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE LASALLE_JWT_KEY PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE LASALLE_JWT_AUD_CLAIM PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  LASALLE_JWT_AUD_CLAIM environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $this->comment('This front-end app needs to know what administrative back-end app it belongs to.');
        $this->comment('So, you need to specify the name of the relevant admin app.');
        $this->comment('The name of  your admin app is the value of the "LASALLE_APP_DOMAIN_NAME" in its .env file.');
        $this->comment("Please go to your administrative app's .env file, and copy its LASALLE_APP_DOMAIN_NAME value here.");
        $this->comment("Alternatively, this is the title field of the installed_domains db table.");
        $lasalleJwtAudClaim = $this->ask('What is the name of your admin app?');
        $this->comment('Attempting to set LASALLE_JWT_AUD_CLAIM in your .env to "'.$lasalleJwtAudClaim.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyLasalleJwtAudClaim', $lasalleJwtAudClaim, false);
        $this->info("Attempt to modify your env's LASALLE_JWT_AUD_CLAIM to ".$lasalleJwtAudClaim.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE LASALLE_JWT_AUD_CLAIM PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: SET THE LASALLE_ADMIN_API_URL PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------
        echo "\n\n";
        $this->line('-----------------------------------------------------------------------');
        $this->line('  LASALLE_ADMIN_API_URL environment variable:');
        $this->line('-----------------------------------------------------------------------');
        $this->comment('This front-end app needs to know what administrative back-end app it belongs to.');
        $this->comment('So, you need to specify the url of the relevant admin app.');
        $this->comment('The url of your admin app is the value of the "APP_URL" in its .env file.');
        $this->comment("Please go to your administrative app's .env file, and copy its APP_URL value here.");
        $lasalleAdminApiUrl = $this->ask('What is the URL of your admin app?');
        $this->comment('Attempting to set LASALLE_ADMIN_API_URL in your .env to "'.$lasalleAdminApiUrl.'"...');
        $this->writeEnvironmentFileWithNewKey('DummyLasalleAdminApiUrl', $lasalleAdminApiUrl, false);
        $this->info("Attempt to modify your env's LASALLE_ADMIN_API_URL to ".$lasalleAdminApiUrl.' is successful!');
        // -------------------------------------------------------------------------------------------------------------
        // END: SET THE LASALLE_ADMIN_API_URL PARAM IN .ENV
        // -------------------------------------------------------------------------------------------------------------



        // -------------------------------------------------------------------------------------------------------------
        // START: DONE!
        // -------------------------------------------------------------------------------------------------------------  
        echo "\n\n\n";
        $this->info('************************************************************************************************');
        $this->info(' You now have to log into your admin app and enter info about your new front-end app.  ');
        $this->info('************************************************************************************************');
        $this->info('  ');
        $this->info(' Please log into your admin app, with your owner credentials.');
        $this->info('  ');
        $this->info(' Click "Installed Domains" in the left vertical menu. ');
        $this->info('   * Click the blue "Create Installed Domain" button. ');
        $this->info('   * In the "Title", enter exactly "' . $lasalleAppDomainName . '" ');
        $this->info('   * Enter a "Description" ');
        $this->info('   * Check the "Enabled" box (if not already checked) ');
        $this->info('   * Click the blue "Create Installed Domain" button ');
        $this->info('  ');
        $this->info(' Click "JWT Keys" in the left vertical menu, at the top.  ');
        $this->info('   * Click the blue "Create JWT Key" button. ');
        $this->info('   * Click the down arrow in the "Installed Domain" drop-down');
        $this->info('   * Highlight "' . $lasalleAppDomainName . '", and then click it');
        $this->info('   * In the "Key" box, enter exactly "' . $lasalleJwtKey . '" ');
        $this->info('   * Check the "Enabled" box (if not already checked) ');
        $this->info('   * Click the blue "Create JWT KEY" button ');
        $this->info('  ');
        $this->info('  Done! You may log out of your admin app.');
        $this->info('************************************************************************************************');
        
        $this->echoOutro();
        // -------------------------------------------------------------------------------------------------------------        
        // END: DONE!
        // -------------------------------------------------------------------------------------------------------------
    }

    /**
     * Echo the final message.
     *
     * return void
     */
    protected function echoOutro()
    {
        echo "\n\n";
        $this->info('=====================================================================');
        $this->info('    ** lslibraryfrontend:lasalleinstallfrontendapp has finished **');
        $this->info('=====================================================================');
        echo "\n\n";
    }

    
    /**
     * Get the console command options.
     *
     * PASTED THIS FROM THE CUSTOMDROP COMMAND! (not a refactor candidate, need this method here!)
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
        ];
    }

    /**
     * Create the .env file
     *
     * @return void
     */
    protected function makeEnv()
    {
        $envexampleFile = file_get_contents(base_path() . '/.env.example');
        file_put_contents($this->laravel->environmentFilePath(), $envexampleFile);
    }

    /**
     * @param text $patternToSearchFor        The text being searched
     * @param text $envFileDummyKey           The dummy key to be replaced in .env
     * @param bool $useQuotesInTheReplacement Do you want to use quotes in the replacement string?
     */
    protected function writeEnvironmentFileWithNewKey($patternToSearchFor, $envFileDummyKey, $useQuotesInTheReplacement = true)
    {
        $envFile = file_get_contents($this->laravel->environmentFilePath());

        $pattern = $this->pattern($patternToSearchFor);

        $replacement = $useQuotesInTheReplacement ? "'".$envFileDummyKey."'" : $envFileDummyKey;

        $envFile = preg_replace($pattern, $replacement, $envFile);

        file_put_contents($this->laravel->environmentFilePath(), $envFile);
    }

    /**
     * Return the pattern (being searched) for the preg_replace
     *
     * @param  string  $patternToSearchFor  The text being searched
     * @return string
     */
    protected function pattern($patternToSearchFor)
    {
        $delimiter = '/';

        return $delimiter . $patternToSearchFor . $delimiter;
    }

    /**
     * Return the LASALLE_APP_DOMAIN_NAME, which is based on the APP_URL.
     *
     * The APP_URL *must* start with "http://" or "https://". However, if it does not, the APP_URL is returned,
     * just so something is returned.
     *
     * @param text $appURL The APP_URL
     *
     * @return string
     */
    protected function getLasalleAppDomainName($appURL)
    {
        if ('http://' == substr($appURL, 0, 7)) {
            return substr($appURL, 7, strlen($appURL));
        }

        if ('https://' == substr($appURL, 0, 8)) {
            return substr($appURL, 8, strlen($appURL));
        }

        return $appURL;
    }
}
