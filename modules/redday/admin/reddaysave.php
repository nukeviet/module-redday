<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

/*********************************************************/

function Redday_filter( $val )
{
	$val = stripslashes( trim( $val ) );
	if( $val != "" )
	{
		return true;
	}
	return false;
}

global $currentlang, $adminfile, $datafold;
$day = intval( $_REQUEST['day'] );
$month = intval( $_REQUEST['month'] );
$ok = 1;
if( $day <= 0 or $day > 31 or $month <= 0 or $month > 12 )
{
	$ok = 0;
}
if( in_array( $month, array(
	4,
	6,
	9,
	11 ) ) and $day == 31 )
{
	$ok = 0;
}
if( $month == 2 and $day > 29 )
{
	$ok = 0;
}
if( ! $ok )
{
	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "" );
	exit;
}
$serialize = array();
$serialize[0] = stripslashes( trim( $_REQUEST['a0'] ) );
$serialize[1] = array_filter( $_REQUEST['a1'], "Redday_filter" );
$serialize[1] = array_values( $serialize[1] );
$serialize[2] = array_filter( $_REQUEST['a2'], "Redday_filter" );
$serialize[2] = array_values( $serialize[2] );
$serialize[3] = stripslashes( trim( $_REQUEST['a3'] ) );
$serialized = serialize( $serialize );
$mday = ( $day >= 10 ) ? $day : "0" . $day;
$mmonth = ( $month >= 10 ) ? $month : "0" . $month;
$filename = NV_ROOTDIR . "/modules/redday/data/" . $mday . $mmonth . "_vietnamese.txt";
$cache_file = $filename;
$fl = @fopen( $cache_file, "w" );
@fwrite( $fl, $serialized );
@fclose( $fl );

$nv_redirect = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name;
$info = "<div style='text-align:center;'>" . $lang_module['save_ok'] . "<br /><br />\n";
$info .= "\n<img border=\"0\" src=\"" . NV_BASE_SITEURL . "images/load_bar.gif\"><br /><br />\n";
$info .= "[<a href=\"" . $nv_redirect . "\">" . $lang_module['redirect_to_home'] . "</a>]\n</div>";
$contents .= $info;
$contents .= "<meta http-equiv=\"refresh\" content=\"2;url=" . nv_url_rewrite( $nv_redirect ) . "\" />";

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
exit();