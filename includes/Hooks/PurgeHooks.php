<?php
/**
 * CloudFlare purge hooks
 *
 * @file
 * @ingroup Extensions
 * @license GPL-3.0-or-later
 */

declare( strict_types=1 );

namespace MediaWiki\Extension\CloudFlare\Hooks;

use MediaWiki\Hook\LocalFilePurgeThumbnailsHook;
use MediaWiki\Hook\TitleSquidURLsHook;

class PurgeHooks implements TitleSquidURLsHook {

	/**
	 * Retrieve a list of thumbnail URLs that needs to be purged
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/LocalFilePurgeThumbnails
	 *
	 * @param File $file The File of which the thumbnails are being purged
	 * @param string $archiveName Name of an old file version or false if it's the current one
	 * @param array $urls Urls to be purged
	 */
	public function onLocalFilePurgeThumbnails( $file, $archiveName, $urls ) {
		if ( $urls ) {
			HookUtils::purgeUrls( $urls );
		}
	}

	/**
	 * Retrieve a list of URLs that needs to be purged
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/TitleSquidURLs
	 *
	 * @param Title $title Title object to purge
	 * @param string[] &$urls Array of URLs to purge from the caches, to be manipulated
	 */
	public function onTitleSquidURLs( $title, &$urls ) {
		if ( $urls ) {
			HookUtils::purgeUrls( $urls );
		}
	}
}
