<?php
# WARNING: This file is publicly viewable on the web. Do not put private data here.

if ( $wmgMobileFrontend ) {
	if ( $wmgZeroBanner ) {
		$wgZeroBannerClusterDomain = 'beta.wmflabs.org'; // need a better way to calc this
		if ( !$wmgZeroPortal ) {
			$wgJsonConfigs['JsonZeroConfig']['remote']['url'] = 'https://zero.wikimedia.beta.wmflabs.org/w/api.php';
		}
	}

	// If set to "false": No alternate links will be added to desktop pages,
	// and MobileFrontend won't add a canonical tag
	// If set to "true": Alternate link will be added, MF will add a canonical tag
	$wgMFNoindexPages = true;
}

// T114552
$wgMobileFrontendLogo = $wgLogo;

// T49647
$wgHooks['EnterMobileMode'][] = function () {
	global $wgCentralAuthCookieDomain, $wgHooks;
	$domainRegexp = '/(?<!\.m)\.wikimedia\.beta\.wmflabs\.org$/';
	$mobileDomain = '.m.wikimedia.beta.wmflabs.org';

	if ( preg_match( $domainRegexp, $wgCentralAuthCookieDomain ) ) {
		$wgCentralAuthCookieDomain = preg_replace( $domainRegexp, $mobileDomain, $wgCentralAuthCookieDomain );
	}
	$wgHooks['WebResponseSetCookie'][] = function ( &$name, &$value, &$expire, &$options ) use ( $domainRegexp, $mobileDomain ) {
		if ( isset( $options['domain'] ) && preg_match( $domainRegexp, $options['domain'] ) ) {
			$options['domain'] = preg_replace( $domainRegexp, $mobileDomain, $options['domain'] );
		}
	};
};
