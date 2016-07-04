<?php

define( "DB_DSN", "pgsql:host=localhost;dbname=gunnerysergeant" );

define( "DB_NAME", "gunnerysergeant" );
//define( "DB_USERNAME", "root" );
define( "DB_USERNAME", "thomassoucy" );
//define( "DB_PASSWORD", "mypass" );
//define( "DB_PASSWORD", "root" );
//define( "DB_PASSWORD", "grapesh0t" );
define( "DB_PASSWORD", "" );
define( "PAGE_SIZE", 5 );
define( "TBL_MEMBERS", "members" );

define( "TBL_KABAS", "kabas" );
define( "TBL_GUNS", "guns" );
define( "TBL_DONATIONS", "donations" );

define( "TBL_ACCESS_LOG", "accesslog" );
define( "TBL_SPONSORS", "sponsors" );

define( "TBL_ADMINS", "admins" );

define( "TBL_SERGEANTS", "sergeants" );

// tjs 130226
define( "AGGREGATE_DSN", "firebaseIO.com" );
// ensure all but one of the following options remain uncommented out!
// sandbox tests and development tests:
define( "AGGREGATE_DB_NAME", "collogistics" );
// signup:
//define( "AGGREGATE_DB_NAME", "signup" );
// testing:
//define( "AGGREGATE_DB_NAME", "oddbulb" );
// charityhound production:
//define( "AGGREGATE_DB_NAME", "charityhound" );
// plateslate production:
//define( "AGGREGATE_DB_NAME", "plateslate" );
// tjs 131031
define( "AUTHENTICATION_DSN", "http://localhost:3000" );

?>
