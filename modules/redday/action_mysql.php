<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_cats';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows';
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cats (
    id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
    title varchar(250) NOT NULL,
    description text DEFAULT NULL,
    add_time int(11) NOT NULL DEFAULT 0,
    edit_time int(11) NOT NULL DEFAULT 0,
    status tinyint(1) NOT NULL DEFAULT 1,
    weight smallint(4) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY title (title)
) ENGINE=InnoDB";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    catid mediumint(5) NOT NULL,
    day tinyint(2) NOT NULL,
    month tinyint(2) NOT NULL,
    image varchar(250) DEFAULT NULL,
    content text NOT NULL,
    add_time int(11) NOT NULL DEFAULT 0,
    edit_time int(11) NOT NULL DEFAULT 0,
    status tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    KEY catid (catid),
    KEY day (day),
    KEY month (month),
    KEY add_time (add_time),
    KEY edit_time (edit_time),
    KEY status (status)
) ENGINE=InnoDB";
