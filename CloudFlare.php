<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'CloudFlare' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['CloudFlare'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for CloudFlare extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the CloudFlare extension requires MediaWiki 1.35+' );
}
