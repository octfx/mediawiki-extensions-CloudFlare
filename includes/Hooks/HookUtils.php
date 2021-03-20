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

		$str = implode( "\", \"", $urls );
		$str = "{\"files\":[\"$str\"]}";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/$zoneId/purge_cache" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $str );

		$headers = [];
		$headers[] = "X-Auth-Key: $accountId";
		$headers[] = "Authorization: Bearer $apiToken";
		$headers[] = "Content-Type: application/json";

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		$result = curl_exec( $ch );
		if ( curl_errno( $ch ) ) {
			echo 'Error: ' . curl_error( $ch );
		}
		curl_close( $ch );
	}
}
