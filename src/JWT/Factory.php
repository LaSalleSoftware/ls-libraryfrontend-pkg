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
 * @copyright  (c) 2019-2025 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see        https://lasallesoftware.ca
 * @see        https://packagist.org/packages/lasallesoftware/ls-libraryfrontend-pkg
 * @see        https://github.com/LaSalleSoftware/ls-libraryfrontend-pkg
 */


namespace Lasallesoftware\Libraryfrontend\JWT;

// Laravel
use Illuminate\Support\Str;

// Third party classes
use DateTimeImmutable; 
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

// https://lcobucci-jwt.readthedocs.io/en/latest/upgrading/ (from v3 to v4)


class Factory
{
    /**
     * Create a JWT
     *
     * https://auth0.com/docs/tokens/jwt-claims
     * https://tools.ietf.org/html/rfc7519#section-4
     *
     * The JWT specification defines seven reserved claims that are not required, but are recommended to allow interoperability with third-party applications. These are:
     *
     *  iss (issuer): Issuer of the JWT
     *  sub (subject): Subject of the JWT (the user)
     *  aud (audience): Recipient for which the JWT is intended
     *  exp (expiration time): Time after which the JWT expires
     *  nbf (not before time): Time before which the JWT must not be accepted for processing
     *  iat (issued at time): Time at which the JWT was issued; can be used to determine age of the JWT
     *  jti (JWT ID): Unique identifier; can be used to prevent the JWT from being replayed (allows a token to be used only once)
     *
     * @return string
     */
    public function createJWT()
    {
        $signer    = new Sha256();
        $key       = InMemory::plainText(config('lasallesoftware-libraryfrontend.lasalle_jwt_key'));
        $now       = new DateTimeImmutable();

        $issClaim  = config('lasallesoftware-libraryfrontend.lasalle_app_domain_name');
        $audClaim  = config('lasallesoftware-libraryfrontend.lasalle_jwt_aud_claim'); 
        $jtiClaim  = $this->createJtiClaim();
        $iatClaim  = $now;
        $nbfClaim  = $now->modify('+1 minute');  // not used, but left as a placeholder
        $expClaim  = $now->modify('+'.config('lasallesoftware-libraryfrontend.lasalle_jwt_exp_claim_seconds_to_expiration').' seconds');

        // https://lcobucci-jwt.readthedocs.io/en/latest/issuing-tokens/
        $config = Configuration::forSymmetricSigner(new Sha256(), $key);

        $token = $config->builder()
            ->issuedBy($issClaim)                // Configures the issuer (iss claim)
            ->permittedFor($audClaim)            // Configures the audience (aud claim)
            ->identifiedBy($jtiClaim, true)      // Configures the id (jti claim), replicating as a header item
            ->issuedAt($iatClaim)                // Configures the time that the token was issued (iat claim) 
            ->canOnlyBeUsedAfter($nbfClaim)      // Configures the time that the token can be used (nbf claim)
            ->expiresAt($expClaim)               // Configures the expiration time of the token (exp claim)
            ->getToken($config->signer(), $config->signingKey())   // Retrieves the generated token
        ;

        return $token->toString();
    }

    /**
     * Create the JTI claim.
     * 
     * https://tools.ietf.org/html/rfc7519#section-4.1.7
     *
     * @return string
     */
    private function createJtiClaim()
    {
        return Str::random(40);
    }
}
