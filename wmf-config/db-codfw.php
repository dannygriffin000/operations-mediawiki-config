<?php
# WARNING: This file is publically viewable on the web. Do not put private data here.

if ( !defined( 'DBO_DEFAULT' ) ) {
	define( 'DBO_DEFAULT', 16 );
}

# $wgReadOnly = "Wikimedia Sites are currently read-only during maintenance, please try again soon.";

$wmgParserCacheDBs = [
	'10.64.0.12'   => '10.192.16.170', # pc2004, B5 2.4TB 256GB
	'10.64.32.72'  => '10.192.32.128', # pc2005, C5 2.4TB 256GB
	'10.64.48.128' => '10.192.48.39',  # pc2006, D5 2.4TB 256GB
];

$wmgOldExtTemplate = [
	'10.192.16.171' => 1, # es2011, B1 11TB 128GB
	'10.192.32.129' => 1, # es2012, C1 11TB 128GB
	'10.192.48.40'  => 1, # es2013, D1 11TB 128GB
];

$wgLBFactoryConf = [

'class' => 'LBFactoryMulti',

'sectionsByDB' => [
	# s1: enwiki
	'enwiki'       => 's1',

	# s2: large wikis
	'bgwiki'       => 's2',
	'bgwiktionary' => 's2',
	'cswiki'       => 's2',
	'enwikiquote'  => 's2',
	'enwiktionary' => 's2',
	'eowiki'       => 's2',
	'fiwiki'       => 's2',
	'idwiki'       => 's2',
	'itwiki'       => 's2',
	'nlwiki'       => 's2',
	'nowiki'       => 's2',
	'plwiki'       => 's2',
	'ptwiki'       => 's2',
	'svwiki'       => 's2',
	'thwiki'       => 's2',
	'trwiki'       => 's2',
	'zhwiki'       => 's2',

	# s3 (default)

	# s4: commons
	'commonswiki'  => 's4',

	# s5: dewiki and wikidata
	'dewiki'       => 's5',

	# s6: large wikis
	'frwiki'       => 's6',
	'jawiki'       => 's6',
	'ruwiki'       => 's6',

	# s7: large wikis, centralauth
	'eswiki'       => 's7',
	'huwiki'       => 's7',
	'hewiki'       => 's7',
	'ukwiki'       => 's7',
	'frwiktionary' => 's7',
	'metawiki'     => 's7',
	'arwiki'       => 's7',
	'centralauth'  => 's7',
	'cawiki'       => 's7',
	'viwiki'       => 's7',
	'fawiki'       => 's7',
	'rowiki'       => 's7',
	'kowiki'       => 's7',

	# s8: wikidata
	'wikidatawiki' => 's8',

	# labs-related wikis
	'labswiki'     => 'silver',
	'labtestwiki'  => 'labtestweb2001',
],

# Load lists
#
# Masters should be in slot [0].
#
# All servers for which replication lag matters should be in the load
# list, not commented out, because otherwise maintenance scripts such
# as compressOld.php won't wait for those servers when they lag.
#
# Conversely, all servers which are down or do not replicate should be
# removed, not set to load zero, because there are certain situations
# when load zero servers will be used, such as if the others are lagged.
# Servers which are down should be removed to avoid a timeout overhead
# per invocation.
#
# Additionally, if a server should not to be lagged (for example,
# an api node, or a recentchanges node, set the load to at least 1.
# This will make the node be taken into account on the wait for lag
# function (the master is not included, as by definition has lag 0).

'sectionLoads' => [
	's1' => [
		'db2048'      => 0,   # C6 2.9TB 160GB, master
		# 'db2016'      => 0,   # B6 2.9TB  96GB, old master
		'db2034'      => 50,  # A5 2.9TB 160GB, rc, log
		'db2042'      => 50,  # C6 2.9TB 160GB, rc, log
		'db2055'      => 50,  # D6 3.3TB 160GB, dump (inactive), vslow, api
		'db2062'      => 50,  # B5 3.3TB 160GB, api # mariadb 10.1
		'db2069'      => 50,  # D6 3.3TB 160GB, api
		'db2070'      => 400, # C5 3.3TB 160GB
		'db2071'      => 50,  # A6 3.6TB 512GB, api
		'db2072'      => 500, # B6 3.6TB 512GB, # mariadb 10.1
		'db2088:3311' => 1, # D1 3.3TB 512GB # rc, log: s1 and s2
		'db2085:3311' => 1, # A5 3.3TB 512GB # rc, log: s1 and s8
	],
	's2' => [
		'db2017'      => 0,   # B6 2.9TB  96GB, master
		'db2035'      => 50,  # C6 2.9TB 160GB, rc, log
		'db2041'      => 100, # C6 2.9TB 160GB, api
		'db2049'      => 400, # C6 2.9TB 160GB,
		'db2056'      => 50,  # D6 3.3TB 160GB, dump (inactive), vslow #innodb compressed
		'db2063'      => 100, # D6 3.3TB 160GB, api
		'db2064'      => 400, # D6 3.3TB 160GB
		'db2088:3312' => 1, # D1 3.3TB 512GB # rc, log: s1 and s2
		'db2091:3312' => 1, # A8 3.3TB 512GB # rc, log: s2 and s4
	],
	/* s3 */ 'DEFAULT' => [
		'db2018'      => 0,   # B6 2.9TB  96GB, master
		'db2036'      => 50,  # C6 2.9TB 160GB
		'db2043'      => 50,  # C6 2.9TB 160GB, dump (inactive), vslow
		'db2050'      => 150, # C6 2.9TB 160GB
		'db2057'      => 400, # D6 3.3TB 160GB
		'db2074'      => 400, # D6 3.3TB 512GB # InnoDB compressed
	],
	's4' => [
		'db2051'      => 0,   # B8 2.9TB 160GB, master
		# 'db2019'      => 0, # B6 2.9TB  96GB, old master
		'db2037'      => 50,  # C6 2.9TB 160GB, rc, log
		'db2044'      => 50,  # C6 2.9TB 160GB, rc, log
		'db2058'      => 50,  # D6 3.3TB 160GB, dump (inactive), vslow
		'db2065'      => 200, # D6 3.3TB 160GB, api
		'db2073'      => 400, # C6 3.3TB 512GB # Compressed InnoDB
		'db2084:3314' => 1, # D6 3.3TB 512GB # rc, log: s4 and s5
		'db2091:3314' => 1, # A8 3.3TB 512GB # rc, log: s2 and s4
	],
	's5' => [
		'db2052'      => 50,  # D6 2.9TB 160GB, master
		# 'db2023'      => 0,   # B6 2.9TB  96GB, to be decomm.
		'db2038'      => 0,   # C6 2.9TB 160GB, dump (inactive), vslow, old master
		'db2059'      => 100, # D6 3.3TB 160GB, api
		'db2066'      => 400, # D6 3.3TB 160GB
		'db2075'      => 400, # A1 3.3TB 512GB # Compressed InnoDB
		'db2084:3315' => 1, # D6 3.3TB 512GB # rc, log: s4 and s5
		'db2089:3315' => 1, # A3 3.3TB 512GB # rc, log: s5 and s6
	],
	's6' => [
		'db2039'      => 0,   # C6 2.9TB 160GB, master, partitioned!
		'db2046'      => 400, # C6 2.9TB 160GB
		'db2053'      => 100, # D6 2.9TB 160GB, dump (inactive), vslow
		'db2060'      => 100, # D6 3.3TB 160GB, api
		'db2067'      => 400, # D6 3.3TB 160GB
		'db2076'      => 400, # B1 3.3TB 512GB
		'db2087:3316' => 1, # C1 3.3TB 512GB # rc, log: s6 and s7
		'db2089:3316' => 1, # A3 3.3TB 512GB # rc, log: s6 and s5(s8)
	],
	's7' => [
		'db2029'      => 0,   # B6 2.9TB  96GB, master
		'db2040'      => 200, # C6 2.9TB 160GB, rc, log
		'db2047'      => 400, # C6 2.9TB 160GB,
		'db2054'      => 200, # D6 2.9TB 160GB, dump (inactive), vslow
		'db2061'      => 200, # D6 3.3TB 160GB, api
		'db2068'      => 300, # D6 3.3TB 160GB
		'db2077'      => 400, # C1 3.3TB 512GB
		'db2086:3317' => 1, # B1 3.3TB 512GB # rc, log: s5 and s7
		'db2087:3317' => 1, # C1 3.3TB 512GB # rc, log: s6 and s7
	],
	's8' => [
		'db2045'      => 0,   # C6 2.9TB 160GB, master
		'db2079'      => 10,  # A5 3.3TB 512GB, vslow, dump
		'db2080'      => 10,  # C5 3.3TB 512GB, api
		'db2081'      => 10,  # A6 3.3TB 512GB, api
		'db2082'      => 100, # B6 3.3TB 512GB
		'db2083'      => 100, # C6 3.3TB 512GB
		'db2085:3318' => 1, # A5 3.3TB 512GB # rc, log: s1 and s8
		'db2086:3318' => 1, # B1 3.3TB 512GB # rc, log: s7 and s8
	],

	'silver' => [
		'silver' => 1,
	],
	'labtestweb2001' => [
		'labtestweb2001' => 1,
	],
],

'serverTemplate' => [
	'dbname'	  => $wgDBname,
	'user'		  => $wgDBuser,
	'password'	  => $wgDBpassword,
	'type'		  => 'mysql',
	'flags'		  => DBO_DEFAULT,
	'max lag'	  => 6, // should be safely less than $wgCdnReboundPurgeDelay
	'variables'   => [
		'innodb_lock_wait_timeout' => 15
	]
],

'templateOverridesBySection' => [
	's1' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's1', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's2' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's2', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	'DEFAULT' /* s3 */  => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's3', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's4' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's4', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's5' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's5', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's6' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's6', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's7' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's7', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
	's8' => [
		'lagDetectionMethod' => 'pt-heartbeat',
		'lagDetectionOptions' => [
			'conds' => [ 'shard' => 's8', 'datacenter' => $wmfMasterDatacenter ]
		],
		'useGTIDs' => true
	],
],

'groupLoadsBySection' => [
	's1' => [
		'watchlist' => [
			'db2034' => 1,
			'db2042' => 1,
			'db2088:3311' => 1,
			'db2085:3311' => 1,
		],
		'recentchanges' => [
			'db2034' => 1,
			'db2042' => 1,
			'db2088:3311' => 1,
			'db2085:3311' => 1,
		],
		'recentchangeslinked' => [
			'db2034' => 1,
			'db2042' => 1,
			'db2088:3311' => 1,
			'db2085:3311' => 1,
		],
		'contributions' => [
			'db2034' => 1,
			'db2042' => 1,
			'db2088:3311' => 1,
			'db2085:3311' => 1,
		],
		'logpager' => [
			'db2034' => 1,
			'db2042' => 1,
			'db2088:3311' => 1,
			'db2085:3311' => 1,
		],
		'dump' => [
			'db2055' => 1,
		],
		'vslow' => [
			'db2055' => 1,
		],
		'api' => [
			'db2055' => 1,
			'db2062' => 1,
			'db2069' => 1,
			'db2071' => 5,
		],
	],
	's2' => [
		'watchlist' => [
			'db2035' => 1,
			'db2088:3312' => 1,
			'db2091:3312' => 1,
		],
		'recentchanges' => [
			'db2035' => 1,
			'db2088:3312' => 1,
			'db2091:3312' => 1,
		],
		'recentchangeslinked' => [
			'db2035' => 1,
			'db2088:3312' => 1,
			'db2091:3312' => 1,
		],
		'contributions' => [
			'db2035' => 1,
			'db2088:3312' => 1,
			'db2091:3312' => 1,
		],
		'logpager' => [
			'db2035' => 1,
			'db2088:3312' => 1,
			'db2091:3312' => 1,
		],
		'dump' => [
			'db2056' => 1,
		],
		'vslow' => [
			'db2056' => 1,
		],
		'api' => [
			'db2041' => 1,
			'db2063' => 1,
		],
	],
	/* s3 */ 'DEFAULT' => [
		'dump' => [
			'db2043' => 1,
		],
		'vslow' => [
			'db2043' => 1,
		],
	],
	's4' => [
		'watchlist' => [
			'db2037' => 1,
			'db2044' => 1,
			'db2084:3314' => 1,
			'db2091:3314' => 1,
		],
		'recentchanges' => [
			'db2037' => 1,
			'db2044' => 1,
			'db2084:3314' => 1,
			'db2091:3314' => 1,
		],
		'recentchangeslinked' => [
			'db2037' => 1,
			'db2044' => 1,
			'db2084:3314' => 1,
			'db2091:3314' => 1,
		],
		'contributions' => [
			'db2037' => 1,
			'db2044' => 1,
			'db2084:3314' => 1,
			'db2091:3314' => 1,
		],
		'logpager' => [
			'db2037' => 1,
			'db2044' => 1,
			'db2084:3314' => 1,
			'db2091:3314' => 1,
		],
		'dump' => [
			'db2058' => 1,
		],
		'vslow' => [
			'db2058' => 1,
		],
		'api' => [
			'db2065' => 1,
		],
	],
	's5' => [
		'watchlist' => [
			'db2084:3315' => 1,
			'db2089:3315' => 1,
		],
		'recentchanges' => [
			'db2084:3315' => 1,
			'db2089:3315' => 1,
		],
		'recentchangeslinked' => [
			'db2084:3315' => 1,
			'db2089:3315' => 1,
		],
		'contributions' => [
			'db2084:3315' => 1,
			'db2089:3315' => 1,
		],
		'logpager' => [
			'db2084:3315' => 1,
			'db2089:3315' => 1,
		],
		'dump' => [
			'db2038' => 1,
		],
		'vslow' => [
			'db2038' => 1,
		],
		'api' => [
			'db2059' => 1,
		],
	],
	's6' => [
		'watchlist' => [
			'db2087:3316' => 1,
			'db2089:3316' => 1,
		],
		'recentchanges' => [
			'db2087:3316' => 1,
			'db2089:3316' => 1,
		],
		'recentchangeslinked' => [
			'db2087:3316' => 1,
			'db2089:3316' => 1,
		],
		'contributions' => [
			'db2087:3316' => 1,
			'db2089:3316' => 1,
		],
		'logpager' => [
			'db2087:3316' => 1,
			'db2089:3316' => 1,
		],
		'dump' => [
			'db2053' => 1,
		],
		'vslow' => [
			'db2053' => 1,
		],
		'api' => [
			'db2060' => 1,
		],
	],
	's7' => [
		'watchlist' => [
			'db2040' => 1,
			'db2086:3317' => 1,
			'db2087:3317' => 1,
		],
		'recentchanges' => [
			'db2040' => 1,
			'db2086:3317' => 1,
			'db2087:3317' => 1,
		],
		'recentchangeslinked' => [
			'db2040' => 1,
			'db2086:3317' => 1,
			'db2087:3317' => 1,
		],
		'contributions' => [
			'db2040' => 1,
			'db2086:3317' => 1,
			'db2087:3317' => 1,
		],
		'logpager' => [
			'db2040' => 1,
			'db2086:3317' => 1,
			'db2087:3317' => 1,
		],
		'dump' => [
			'db2054' => 1,
		],
		'vslow' => [
			'db2054' => 1,
		],
		'api' => [
			'db2061' => 1,
		],
	],
	's8' => [
		'watchlist' => [
			'db2085:3318' => 1,
			'db2086:3318' => 1,
		],
		'recentchanges' => [
			'db2085:3318' => 1,
			'db2086:3318' => 1,
		],
		'recentchangeslinked' => [
			'db2085:3318' => 1,
			'db2086:3318' => 1,
		],
		'contributions' => [
			'db2085:3318' => 1,
			'db2086:3318' => 1,
		],
		'logpager' => [
			'db2085:3318' => 1,
			'db2086:3318' => 1,
		],
		'dump' => [
			'db2079' => 1,
		],
		'vslow' => [
			'db2079' => 1,
		],
		'api' => [
			'db2080' => 1,
			'db2081' => 1,
		],
	],
],

'groupLoadsByDB' => [],

# Hosts settings
# Do not remove servers from this list ever
# Removing a server from this list does not remove the server from rotation,
# it just breaks the site horribly.
'hostsByName' => [
	'db1001' => '10.64.0.5', # do not remove or comment out
	'db1009' => '10.64.0.13', # do not remove or comment out
	'db1011' => '10.64.0.15', # do not remove or comment out
	'db1020' => '10.64.16.9', # do not remove or comment out
	'db1030' => '10.64.16.19', # do not remove or comment out
	'db1039' => '10.64.16.28', # do not remove or comment out
	'db1043' => '10.64.16.32', # do not remove or comment out
	'db1047' => '10.64.16.36', # do not remove or comment out
	'db1051' => '10.64.16.76', # do not remove or comment out
	'db1052' => '10.64.16.77', # do not remove or comment out
	'db1053' => '10.64.0.87', # do not remove or comment out
	'db1054' => '10.64.0.206', # do not remove or comment out
	'db1055' => '10.64.32.25', # do not remove or comment out
	'db1056' => '10.64.32.26', # do not remove or comment out
	'db1060' => '10.64.32.30', # do not remove or comment out
	'db1061' => '10.64.32.227', # do not remove or comment out
	'db1062' => '10.64.48.15', # do not remove or comment out
	'db1063' => '10.64.32.228', # do not remove or comment out
	'db1064' => '10.64.48.19', # do not remove or comment out
	'db1065' => '10.64.48.20', # do not remove or comment out
	'db1066' => '10.64.48.21', # do not remove or comment out
	'db1067' => '10.64.48.22', # do not remove or comment out
	'db1068' => '10.64.48.23', # do not remove or comment out
	'db1069' => '10.64.48.24', # do not remove or comment out
	'db1070' => '10.64.48.25', # do not remove or comment out
	'db1071' => '10.64.48.26', # do not remove or comment out
	'db1072' => '10.64.16.39', # do not remove or comment out
	'db1073' => '10.64.16.79', # do not remove or comment out
	'db1074' => '10.64.0.204', # do not remove or comment out
	'db1075' => '10.64.0.205', # do not remove or comment out
	'db1076' => '10.64.16.190', # do not remove or comment out
	'db1077' => '10.64.16.191', # do not remove or comment out
	'db1078' => '10.64.32.136', # do not remove or comment out
	'db1079' => '10.64.0.91', # do not remove or comment out
	'db1080' => '10.64.0.92', # do not remove or comment out
	'db1081' => '10.64.0.93', # do not remove or comment out
	'db1082' => '10.64.0.94', # do not remove or comment out
	'db1083' => '10.64.16.101', # do not remove or comment out
	'db1084' => '10.64.16.102', # do not remove or comment out
	'db1085' => '10.64.16.103', # do not remove or comment out
	'db1086' => '10.64.16.104', # do not remove or comment out
	'db1087' => '10.64.32.113', # do not remove or comment out
	'db1088' => '10.64.32.114', # do not remove or comment out
	'db1089' => '10.64.32.115', # do not remove or comment out
	'db1090' => '10.64.32.116', # do not remove or comment out
	'db1091' => '10.64.48.150', # do not remove or comment out
	'db1092' => '10.64.48.151', # do not remove or comment out
	'db1093' => '10.64.48.152', # do not remove or comment out
	'db1094' => '10.64.48.153', # do not remove or comment out
	'db1096:3315' => '10.64.0.163:3315', # do not remove or comment out
	'db1096:3316' => '10.64.0.163:3316', # do not remove or comment out
	'db1097:3314' => '10.64.48.11:3314', # do not remove or comment out
	'db1097:3315' => '10.64.48.11:3315', # do not remove or comment out
	'db1098:3316' => '10.64.16.83:3316', # do not remove or comment out
	'db1098:3317' => '10.64.16.83:3317', # do not remove or comment out
	'db1099:3311' => '10.64.16.84:3311', # do not remove or comment out
	'db1099:3318' => '10.64.16.84:3318', # do not remove or comment out
	'db1100' => '10.64.32.197', # do not remove or comment out
	'db1101:3317' => '10.64.32.198:3317', # do not remove or comment out
	'db1101:3318' => '10.64.32.198:3318', # do not remove or comment out
	'db1103:3312' => '10.64.0.164:3312', # do not remove or comment out
	'db1103:3314' => '10.64.0.164:3314', # do not remove or comment out
	'db1104' => '10.64.16.85', # do not remove or comment out
	'db1105:3311' => '10.64.32.222:3311', # do not remove or comment out
	'db1105:3312' => '10.64.32.222:3312', # do not remove or comment out
	'db1106' => '10.64.48.13', # do not remove or comment out
	'db1109' => '10.64.48.172', # do not remove or comment out
	'db1110' => '10.64.32.73', # do not remove or comment out
	'db2001' => '10.192.0.4', # do not remove or comment out
	'db2002' => '10.192.0.5', # do not remove or comment out
	'db2003' => '10.192.0.6', # do not remove or comment out
	'db2004' => '10.192.0.7', # do not remove or comment out
	'db2005' => '10.192.0.8', # do not remove or comment out
	'db2006' => '10.192.0.9', # do not remove or comment out
	'db2007' => '10.192.0.10', # do not remove or comment out
	'db2011' => '10.192.0.14', # do not remove or comment out
	'db2012' => '10.192.0.15', # do not remove or comment out
	'db2013' => '10.192.0.16', # do not remove or comment out
	'db2014' => '10.192.0.17', # do not remove or comment out
	'db2015' => '10.192.0.18', # do not remove or comment out
	'db2016' => '10.192.16.4', # do not remove or comment out
	'db2017' => '10.192.16.5', # do not remove or comment out
	'db2018' => '10.192.16.6', # do not remove or comment out
	'db2019' => '10.192.16.7', # do not remove or comment out
	'db2020' => '10.192.16.8', # do not remove or comment out
	'db2021' => '10.192.16.9', # do not remove or comment out
	'db2022' => '10.192.16.10', # do not remove or comment out
	'db2023' => '10.192.16.11', # do not remove or comment out
	'db2024' => '10.192.16.12', # do not remove or comment out
	'db2025' => '10.192.16.13', # do not remove or comment out
	'db2026' => '10.192.16.14', # do not remove or comment out
	'db2027' => '10.192.16.15', # do not remove or comment out
	'db2029' => '10.192.16.17', # do not remove or comment out
	'db2030' => '10.192.16.18', # do not remove or comment out
	'db2031' => '10.192.16.19', # do not remove or comment out
	'db2032' => '10.192.16.20', # do not remove or comment out
	'db2033' => '10.192.32.4', # do not remove or comment out
	'db2034' => '10.192.0.87', # do not remove or comment out
	'db2035' => '10.192.32.6', # do not remove or comment out
	'db2036' => '10.192.32.7', # do not remove or comment out
	'db2037' => '10.192.32.8', # do not remove or comment out
	'db2038' => '10.192.32.9', # do not remove or comment out
	'db2039' => '10.192.32.10', # do not remove or comment out
	'db2040' => '10.192.32.11', # do not remove or comment out
	'db2041' => '10.192.32.12', # do not remove or comment out
	'db2042' => '10.192.32.13', # do not remove or comment out
	'db2043' => '10.192.32.103', # do not remove or comment out
	'db2044' => '10.192.32.104', # do not remove or comment out
	'db2045' => '10.192.32.105', # do not remove or comment out
	'db2046' => '10.192.32.106', # do not remove or comment out
	'db2047' => '10.192.32.107', # do not remove or comment out
	'db2048' => '10.192.32.108', # do not remove or comment out
	'db2049' => '10.192.32.109', # do not remove or comment out
	'db2050' => '10.192.32.110', # do not remove or comment out
	'db2051' => '10.192.16.22', # do not remove or comment out
	'db2052' => '10.192.48.4', # do not remove or comment out
	'db2053' => '10.192.48.5', # do not remove or comment out
	'db2054' => '10.192.48.6', # do not remove or comment out
	'db2055' => '10.192.48.7', # do not remove or comment out
	'db2056' => '10.192.48.8', # do not remove or comment out
	'db2057' => '10.192.48.9', # do not remove or comment out
	'db2058' => '10.192.48.10', # do not remove or comment out
	'db2059' => '10.192.48.11', # do not remove or comment out
	'db2060' => '10.192.48.12', # do not remove or comment out
	'db2061' => '10.192.48.13', # do not remove or comment out
	'db2062' => '10.192.16.195', # do not remove or comment out
	'db2063' => '10.192.48.15', # do not remove or comment out
	'db2064' => '10.192.48.16', # do not remove or comment out
	'db2065' => '10.192.48.17', # do not remove or comment out
	'db2066' => '10.192.48.18', # do not remove or comment out
	'db2067' => '10.192.48.19', # do not remove or comment out
	'db2068' => '10.192.48.20', # do not remove or comment out
	'db2069' => '10.192.48.21', # do not remove or comment out
	'db2070' => '10.192.32.5', # do not remove or comment out
	'db2071' => '10.192.0.4', # do not remove or comment out
	'db2072' => '10.192.16.37', # do not remove or comment out
	'db2073' => '10.192.32.167', # do not remove or comment out
	'db2074' => '10.192.48.84', # do not remove or comment out
	'db2075' => '10.192.0.5', # do not remove or comment out
	'db2076' => '10.192.16.38', # do not remove or comment out
	'db2077' => '10.192.32.168', # do not remove or comment out
	'db2079' => '10.192.0.6', # do not remove or comment out
	'db2080' => '10.192.32.169', # do not remove or comment out
	'db2081' => '10.192.0.7', # do not remove or comment out
	'db2082' => '10.192.16.39', # do not remove or comment out
	'db2083' => '10.192.32.170', # do not remove or comment out
	'db2084:3314' => '10.192.48.86:3314', # do not remove or comment out
	'db2084:3315' => '10.192.48.86:3315', # do not remove or comment out
	'db2085:3311' => '10.192.0.8:3311', # do not remove or comment out
	'db2085:3318' => '10.192.0.8:3318', # do not remove or comment out
	'db2086:3318' => '10.192.16.40:3318', # do not remove or comment out
	'db2086:3317' => '10.192.16.40:3317', # do not remove or comment out
	'db2087:3316' => '10.192.32.171:3316', # do not remove or comment out
	'db2087:3317' => '10.192.32.171:3317', # do not remove or comment out
	'db2088:3311' => '10.192.48.87:3311', # do not remove or comment out
	'db2088:3312' => '10.192.48.87:3312', # do not remove or comment out
	'db2089:3315' => '10.192.0.9:3315', # do not remove or comment out
	'db2089:3316' => '10.192.0.9:3316', # do not remove or comment out
	'db2091:3312' => '10.192.0.10:3312', # do not remove or comment out
	'db2091:3314' => '10.192.0.10:3314', # do not remove or comment out
	'virt1000' => '208.80.154.18', # do not remove or comment out
	'silver' => '208.80.154.136', # do not remove or comment out
	'labtestweb2001' => '208.80.153.14', # do not remove or comment out
],

'externalLoads' => [
	# Recompressed stores
	'rc1' => $wmgOldExtTemplate,

	# Former Ubuntu dual-purpose stores
	'cluster3' => $wmgOldExtTemplate,
	'cluster4' => $wmgOldExtTemplate,
	'cluster5' => $wmgOldExtTemplate,
	'cluster6' => $wmgOldExtTemplate,
	'cluster7' => $wmgOldExtTemplate,
	'cluster8' => $wmgOldExtTemplate,
	'cluster9' => $wmgOldExtTemplate,
	'cluster10' => $wmgOldExtTemplate,
	'cluster20' => $wmgOldExtTemplate,
	'cluster21' => $wmgOldExtTemplate,

	# Clusters required for T24624
	'cluster1' => $wmgOldExtTemplate,
	'cluster2' => $wmgOldExtTemplate,

	# Old dedicated clusters
	'cluster22' => $wmgOldExtTemplate,
	'cluster23' => $wmgOldExtTemplate,

	# es2
	'cluster24' => [
		'10.192.48.41'  => 1, # es2016, D1 11TB 128GB, master
		'10.192.0.141'  => 3, # es2014, A1 11TB 128GB
		'10.192.32.130' => 3, # es2015, C1 11TB 128GB
	],
	# es3
	'cluster25' => [
		'10.192.0.142'  => 3, # es2017, A6 11TB 128GB, master
		# '10.192.16.172' => 1, # es2018, B6 11TB 128GB, crashed
		'10.192.48.42'  => 3, # es2019, D6 11TB 128GB
	],
	# ExtensionStore shard1
	'extension1' => [
		'10.192.32.4' => 1, # db2033, C6 3.5TB 160GB, master
	],
],

'masterTemplateOverrides' => [],

'externalTemplateOverrides' => [
	'flags' => 0, // No transactions
],

'templateOverridesByCluster' => [
	'rc1'		=> [ 'is static' => true ],
	'cluster1'	=> [ 'blobs table' => 'blobs_cluster1', 'is static' => true ],
	'cluster2'	=> [ 'blobs table' => 'blobs_cluster2', 'is static' => true ],
	'cluster3'	=> [ 'blobs table' => 'blobs_cluster3', 'is static' => true ],
	'cluster4'	=> [ 'blobs table' => 'blobs_cluster4', 'is static' => true ],
	'cluster5'	=> [ 'blobs table' => 'blobs_cluster5', 'is static' => true ],
	'cluster6'	=> [ 'blobs table' => 'blobs_cluster6', 'is static' => true ],
	'cluster7'	=> [ 'blobs table' => 'blobs_cluster7', 'is static' => true ],
	'cluster8'	=> [ 'blobs table' => 'blobs_cluster8', 'is static' => true ],
	'cluster9'	=> [ 'blobs table' => 'blobs_cluster9', 'is static' => true ],
	'cluster10'	=> [ 'blobs table' => 'blobs_cluster10', 'is static' => true ],
	'cluster20'	=> [ 'blobs table' => 'blobs_cluster20', 'is static' => true ],
	'cluster21'	=> [ 'blobs table' => 'blobs_cluster21', 'is static' => true ],
	'cluster22'	=> [ 'blobs table' => 'blobs_cluster22', 'is static' => true ],
	'cluster23'	=> [ 'blobs table' => 'blobs_cluster23', 'is static' => true ],
	'cluster24'	=> [ 'blobs table' => 'blobs_cluster24' ],
	'cluster25'	=> [ 'blobs table' => 'blobs_cluster25' ],
],

# This key must exist for the master switch script to work, which means comment and uncomment
# the individual shards, but leave the 'readOnlyBySection' => [ ], alone.
#
# When going read only, please change the comment to something appropiate (like a brief idea
# of what is happening, with a wiki link for further explanation. Avoid linking to external
# infrastructure if possible (IRC, other webpages) or infrastructure not prepared to absorve
# large traffic (phabricator) because they tend to collapse. A meta page would be appropiate.
#
# Also keep these read only messages if codfw is not the active dc, to prevent accidental writes
# getting trasmmitted from codfw to eqiad when the master dc is eqiad.
'readOnlyBySection' => [
	's1'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	's2'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	'DEFAULT' => 'This request is served by a passive datacenter. If you see this something is really wrong.', # s3
	's4'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	's5'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	's6'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	's7'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
	's8'      => 'This request is served by a passive datacenter. If you see this something is really wrong.',
],

];

$wgDefaultExternalStore = [
	'DB://cluster24',
	'DB://cluster25',
];
