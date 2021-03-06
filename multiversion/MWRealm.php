<?php
global $wmfCluster, $wmfDatacenter, $wmfRealm, $wmgRealm;

$env = require __DIR__ . '/../wmf-config/env.php';

$wmfRealm = $wmgRealm = $env['realm'];
$wmfDatacenter = $env['dc'];

// TODO: Remove (unused)
if ( $env['realm'] === 'labs' ) {
	$wmfCluster = 'labs';
} else {
	$wmfCluster = $env['dc'];
}

unset( $env );

/**
 * Get the filename for the current realm/datacenter, falling back
 * to the $filename if not found.
 *
 * Files checked are:
 *   base-realm-datacenter.ext
 *   base-realm.ext
 *   base-datacenter.ext
 *   base.ext
 * ext is optional.
 *
 * The full path to the file is returned, not just the filename
 *
 * @deprecated since 2015 Use explicit paths instead, with one or two
 *  conditonals as needed.
 * @param string $filename Full path to file
 * @return string Full path to file to be used
 */
function getRealmSpecificFilename( $filename ) {
	global $wmfRealm, $wmfDatacenter;

	$pathinfo = pathinfo( $filename );
	$ext = '';
	if ( isset( $pathinfo['extension'] ) ) {
		$ext = '.' . $pathinfo['extension'];
	}
	$base = $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'];

	// Test existence of the following file suffix and return
	// immediately whenever found:
	// - {realm}-{datacenter}
	// - {realm}
	// - {datacenter}
	// - {}
	//
	// Please update /README whenever changing code below.

	$new_filename = "{$base}-{$wmfRealm}-{$wmfDatacenter}{$ext}";
	if ( file_exists( $new_filename ) ) {
		return $new_filename;
	}

	# realm take precedence over datacenter.
	$new_filename = "{$base}-{$wmfRealm}{$ext}";
	if ( file_exists( $new_filename ) ) {
		return $new_filename;
	}

	$new_filename = "{$base}-{$wmfDatacenter}{$ext}";
	if ( file_exists( $new_filename ) ) {
		return $new_filename;
	}

	return $filename;
}

// End /Determine realm and datacenter we are on/
