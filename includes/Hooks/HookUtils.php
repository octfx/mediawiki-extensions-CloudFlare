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
		if ( empty( $zoneId ) || empty( $apiToken ) || empty( $accountId ) || empty( $urls ) ) {
			return;
		}

		$headers = [];
		$headers[] = "X-Auth-Key: $accountId";
		$headers[] = "Authorization: Bearer $apiToken";
		$headers[] = "Content-Type: application/json";

		$options = [
			CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/$zoneId/purge_cache",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => json_encode( [ 'files' => $urls ] ),
			CURLOPT_HTTPHEADER => $headers,
		];

		$ch = curl_init();
		curl_setopt_array( $ch, $options );

		$result = curl_exec( $ch );
		if ( curl_errno( $ch ) ) {
			echo 'Error: ' . curl_error( $ch );
		}
		curl_close( $ch );
	}
}
