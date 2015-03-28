<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
	die( 'Stop!!!' );
$page_title = "Redday";
global $currentlang, $datafold, $adminfile;
$day = $nv_Request->get_int( 'day', 'post', 0 );
$month = $nv_Request->get_int( 'month', 'post', 0 );

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );

$lang_module['rdeditday'] = sprintf( $lang_module['rdeditday'], $day, $month );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" );

for( $i = 1; $i <= 31; $i++ )
{
	$array['value'] = $i;
	$array['sl'] = ($i == $day) ? " selected=\"selected\"" : "";
	$xtpl->assign( 'DAY', $array );
	$xtpl->parse( 'main.loop_day' );
}
for( $i = 1; $i <= 12; $i++ )
{
	$array['value'] = $i;
	$array['sl'] = ($i == $month) ? " selected=\"selected\"" : "";
	$xtpl->assign( 'MONTH', $array );
	$xtpl->parse( 'main.loop_month' );
}
if( $nv_Request->isset_request( 'submit1', 'post' ) )
{
	$error = array( );
	if( $day <= 0 or $day > 31 or $month <= 0 or $month > 12 )
	{
		$error[] = sprintf( $lang_module['error_month'], $month, $day );
	}
	if( in_array( $month, array(
		4,
		6,
		9,
		11
	) ) and $day == 31 )
	{
		$error[] = sprintf( $lang_module['error_month'], $month, $day );
	}
	if( $month == 2 and $day > 29 )
	{
		$error[] = sprintf( $lang_module['error_month2'], $day );
	}
	if( !empty( $error ) )
	{
		$xtpl->assign( 'ERROR', implode( "<br />", $error ) );
		$xtpl->parse( 'main.error' );
	}
	else
	{
		$mday = str_pad( $day, 2, "0", STR_PAD_LEFT );
		$mmonth = str_pad( $month, 2, "0", STR_PAD_LEFT );
		$filename = NV_ROOTDIR . "/modules/redday/data/" . $mday . $mmonth . "_vietnamese.txt";
		$unserialize = array( );
		if( file_exists( $filename ) )
		{
			$content_file = file_get_contents( $filename );
			$content_file = trim( $content_file );

			if( !empty( $content_file ) )
			{
				//print_r($content_file);
				//var_dump($2);die;
				
				$out = preg_replace( '!s\:(\d+)\:"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $content_file );
				//print('!s:(\d+):"(.*?)";!se');
				//die( "'s:'.strlen('$2').':\"$2\";'");

				// $out = preg_replace_callback( '!s\:(\d+)\:"(.*?)";!s', function( $matches )
				// {
					// return "'s:'.strlen('$matches[2]').':\"$matches[2]\";'";
				// }, $content_file );

				$unserialize = unserialize( $out );
			}
		}

		if( $unserialize[1] != array( ) )
		{
			foreach( $unserialize[1] as $key => $val )
			{
				$xtpl->assign( 'stateevents', stripslashes( $val ) );
				$xtpl->parse( 'main.content.loop_stateevents' );
			}
		}
		if( $unserialize[2] != array( ) )
		{
			foreach( $unserialize[2] as $key => $val )
			{
				$xtpl->assign( 'interevents', stripslashes( $val ) );
				$xtpl->parse( 'main.content.loop_interevents' );
			}
		}

		$xtpl->assign( 'day', $day );
		$xtpl->assign( 'month', $month );
		$xtpl->assign( 'rdholydays', $unserialize[0] );
		$xtpl->assign( 'otherevents', $unserialize[3] );
		$xtpl->parse( 'main.content' );
	}
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
