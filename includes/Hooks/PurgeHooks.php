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

use MediaWiki\Hook\TitleSquidURLsHook;

class PurgeHooks implements TitleSquidURLsHook {

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
