#!/usr/bin/php
<?php
global $ini_array;
$ini_array = parse_ini_file("tracking.ini", true);

$longopts  = array( "gpsonly","downloadonly","isTar","numdays:","help","period:"); $opt = getopt("p:f:m:t:h",$longopts);
//check for help request
if(isset($opt['help']) || isset($opt['h'])) showhelp();
//now check for required options
if(!$opt || checkrequiredopts($opt)) commanderror();

// only for import form downloaded file - i.e. bypass argos connection
if(isset($opt['p']) && $opt['p']!='') {$period=$opt['p'];} #set period for downloads of csv
if(isset($opt['f']) && $opt['f']!='') {$filename=$opt['f'];}
if(isset($opt['t']) && $opt['t']!='') {$argostypearray=explode(',',$opt['t']);}

if (isset($opt['m']) && $opt['m']!='') $mode=$opt['m'];
if (isset($opt['downloadonly'])) $downloadonly=true;else $downloadonly=false;
if (isset($opt['gpsonly'])) $gpsonly=true;else $gpsonly=false;
if (isset($opt['isTar'])) $isTar=true;else $isTar=false;
if (isset($opt['numdays'])) {$numdays=$opt['numdays'];if($numdays>10) {echo "max days=10! ";commanderror();} }else $numdays=false;
if (isset($opt['period'])) $period=$opt['period'];
require("telemetry_core.php");



function checkrequiredopts($opts){
	$requiredopts=array('m');
	foreach($requiredopts as $reqopt){
		if(!in_array($reqopt,array_keys($opts)))return true; //check keys
	}
	return false;
}
function commanderror(){
	global $argv,$ini_array;
//	print_r($ini_array["Argos"]);
	$scriptname=$argv[0];
	$help="Error :$scriptname -m <mode> -f <filename> [opts]";
	echo "$help\n";exit();
}

