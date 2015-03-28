<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 2:29
 */

if( ! defined( 'NV_IS_MOD_REDDAY' ) ) die( 'Stop!!!' );

$index = 1;

global $day, $month;
$day = $nv_Request->get_int( 'day', 'post', date( "d", NV_CURRENTTIME ) );
$month = $nv_Request->get_int( 'month', 'post', date( "m", NV_CURRENTTIME ) );

$error = array();
if( $day <= 0 or $day > 31 or $month <= 0 or $month > 12 )
{
	$error[] = sprintf( $lang_module['error_month'], $month, $day );
}
$error = array();
if( $day <= 0 or $day > 31 or $month <= 0 or $month > 12 )
{
	$error[] = sprintf( $lang_module['error_month'], $month, $day );
}
if( in_array( $month, array( 4, 6, 9, 11 ) ) and $day == 31 )
{
	$error[] = sprintf( $lang_module['error_month'], $month, $day );
}
if( $month == 2 and $day > 29 )
{
	$error[] = sprintf( $lang_module['error_month2'], $day );
}
if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( "<br />", $error ) );
	$xtpl->parse( 'main.error' );
}
else
{
	$mday = str_pad( $day, 2, "0", STR_PAD_LEFT );
	$mmonth = str_pad( $month, 2, "0", STR_PAD_LEFT );
	$filename = "modules/redday/data/" . $mday . $mmonth . "_vietnamese.txt";
	$array_data = array();
	if( file_exists( $filename ) )
	{
		$content_file = file_get_contents( $filename );
		$out = preg_replace( '!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $content_file );
		$array_data = unserialize( $out );
	}	
}

$contents = nv_theme_redday_main ( $array_data, $error );

$page_title = sprintf( $lang_module['main_title_redday'], $day, $month );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>