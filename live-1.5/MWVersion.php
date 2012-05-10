<?php

# MW_SECURE_HOST set from secure gateway?
$secure = getenv( 'MW_SECURE_HOST' );
$host = $secure ? $secure : $_SERVER['HTTP_HOST'];

if ( $host === 'test.wikipedia.org' && !$secure
	&& !preg_match( '!thumb\.php!', $_SERVER['REQUEST_URI'] ) )
{
	# Test wiki mostly runs off the version of MediaWiki on /home.
	# As horrible hack for NFS-less image scalers, use regular docroot for thumbs?
	require_once( '/home/wikipedia/common/multiversion/MWVersion.php' );
} else {
	require_once( '/usr/local/apache/common-local/multiversion/MWVersion.php' );
}
