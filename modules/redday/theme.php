<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if( ! defined( 'NV_IS_MOD_REDDAY' ) ) die( 'Stop!!!' );

function nv_theme_redday_main( $array_data, $error )
{
	global $module_name, $module_file, $lang_module, $module_info, $op, $day, $month;

	$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme'] );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name );
	$xtpl->assign( 'main_title_redday', sprintf( $lang_module['main_title_redday'], $day, $month ) );

	if( ! empty( $error ) )
	{
		$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
		$xtpl->parse( 'main.error' );
	}

	for( $i = 1; $i <= 31; $i++ )
	{
		$array['value'] = $i;
		$array['sl'] = ( $i == $day ) ? " selected=\"selected\"" : "";
		$xtpl->assign( 'DAY', $array );
		$xtpl->parse( 'main.loop_day' );
	}
	for( $i = 1; $i <= 12; $i++ )
	{
		$array['value'] = $i;
		$array['sl'] = ( $i == $month ) ? " selected=\"selected\"" : "";
		$xtpl->assign( 'MONTH', $array );
		$xtpl->parse( 'main.loop_month' );
	}
	if( ! empty( $array_data ) )
	{
		if( ! empty( $array_data[0] ) )
		{
			$xtpl->assign( 'reddayevent0', stripslashes( $array_data[0] ) );
		}
		if( ! empty( $array_data[1] ) )
		{
			foreach( $array_data[1] as $key => $val )
			{
				$xtpl->assign( 'stateevents', nl2br( stripslashes( $val ) ) );
				$xtpl->parse( 'main.content.stateevents.loop_stateevents' );
			}
            $xtpl->parse( 'main.content.stateevents' );
		}
		if( ! empty( $array_data[2] ) )
		{
			foreach( $array_data[2] as $key => $val )
			{
				$xtpl->assign( 'interevents', nl2br( stripslashes( $val ) ) );
				$xtpl->parse( 'main.content.interevents.loop_interevents' );
			}
            $xtpl->parse( 'main.content.interevents' );
		}
		if( ! empty( $array_data[3] ) )
		{
			foreach( $array_data[3] as $key => $val )
			{
				$xtpl->assign( 'otherevents', nl2br( stripslashes( $val ) ) );
				$xtpl->parse( 'main.content.otherevents.loop_otherevents' );
			}
            $xtpl->parse( 'main.content.otherevents' );
		}
        $xtpl->parse( 'main.content' );
	}
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}