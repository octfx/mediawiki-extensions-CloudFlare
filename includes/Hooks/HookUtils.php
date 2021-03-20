<?php
/**
 * CloudFlare extension hooks
 *
 * @file
 * @ingroup Extensions
 * @license MIT
 */

namespace MediaWiki\Extension\CloudFlare\Hooks;

use MediaWiki\MediaWikiServices;
use MWException;
use Status;

class HookUtils {

	/**
	 * Send URLs to CloudFlare to purge
	 * Based on Extension:CloudflarePurge by Alex Lee
	 * @param array $urls URLs to purge
	 */
	public function purgeUrls( $urls ): void {
		$config = MediaWikiServices::getInstance()->getMainConfig();
		$zoneId = $config->get( 'CloudFlareZoneId' );
		$apiToken = $config->get( 'CloudFlareApiToken' );
		$accountId = $config->get( 'CloudFlareAccountId' );

		// Return if any info is missing
		if ( empty( $zoneId ) || empty( $apiToken ) || empty( $accountId ) ) {
			return;
		}

		$fac = MediaWikiServices::getInstance()->getHttpRequestFactory();
		$req = $fac->create( sprintf( 'https://api.cloudflare.com/client/v4/zones/%s/purge_cache', $zoneId ) );
		$req->setHeader( 'X-Auth-Key', $accountId );
		$req->setHeader( 'Authorization', sprintf( 'Bearer %s', $apiToken ) );
		$req->setHeader( 'Content-Type', 'application/json' );

		$req->setData( [
			'files' => $urls
		] );

		$status = Status::newGood();
		try {
			$status = $req->execute();
		} catch ( MWException $e ) {
			wfLogWarning( sprintf( 'Could not purge CloudFlare URLS. Error: %s', $e->getMessage() ) );
			return;
		} finally {
			if ( !$status->isOK() ) {
				wfLogWarning( sprintf( 'Could not purge CloudFlare URLS. Error: %s', json_encode( $status->getErrors() ) ) );
				return;
			}
		}
	}
}
