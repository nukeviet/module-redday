<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$console_starttime = microtime(true);

define('NV_SYSTEM', true);
define('NV_IS_CONSOLE', true);
define('NV_ROOTDIR', str_replace(DIRECTORY_SEPARATOR, '/', realpath(pathinfo(str_replace(DIRECTORY_SEPARATOR, '/', __FILE__), PATHINFO_DIRNAME) . '/../..')));
define('NV_CONSOLE_DIR', NV_ROOTDIR . '/private');

require NV_CONSOLE_DIR . '/server.php';
require NV_ROOTDIR . '/includes/mainfile.php';

// Đưa dữ liệu vào CSDL
function add_content_csdl($catid, $day, $month, $content)
{
    global $db;
    try {
        $module_data = 'redday';
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows (
            catid, day, month, content
        ) VALUES (
            " . $catid . ", " . $day . ",  " . $month . ", " . $db->quote($content) . ")";
        $db->query($sql);
    } catch (PDOException $e) {
        echo '================' . PHP_EOL;
        echo $catid . ':' . $day . '/' . $month . PHP_EOL;
        echo print_r($content) . PHP_EOL;
        echo '================' . PHP_EOL;
    }
}
// Đưa dữ liệu vào file khởi tạo
function add_content_file($catid, $day, $month, $content)
{
    global $db, $filename;
    $content = $db->quote($content);
    $content = str_replace("\\\\\\", "\\\\", $content);
    $str = '$sql_create_module[] = "INSERT INTO " . $db_config[\'prefix\'] . "_" . $lang . "_" . $module_data . "_rows (catid, day, month, content) VALUES (\'' . $catid . '\', \'' . $day . '\',\'' . $month . '\', ' . $content . ')";' . "\n";
    file_put_contents(NV_ROOTDIR . '/private/' . $filename, $str, FILE_APPEND);
}

$list_file = scandir(NV_ROOTDIR . '/modules/redday/data');
$filename = 'action_mysql.php';
if (is_file(NV_ROOTDIR . '/private/' . $filename)) {
    unlink(NV_ROOTDIR . '/private/' . $filename);
}
$i = 0;
foreach ($list_file as $file) {
    if (!is_file(NV_ROOTDIR . '/modules/redday/data/' . $file)) {
        continue;
    }
    $day = substr($file, 0, 2);
    $month = substr($file, 2, 2);

    $content_file = file_get_contents(NV_ROOTDIR . '/modules/redday/data/' . $file);
    $content_file = trim($content_file);
    if (empty($content_file)) {
        continue;
    }
    $i++;
    echo $i . ':' . $day . '/' . $month . PHP_EOL;
    $data = unserialize($content_file);
    if (!empty($data[0])) {
        add_content_file(1, $day, $month, $data[0]);
    }

    if (!empty($data[1])) {
        foreach ($data[1] as $content) {
            add_content_file(2, $day, $month, $content);
        }
    }
    if (!empty($data[2])) {
        foreach ($data[2] as $content) {
            add_content_file(3, $day, $month, $content);
        }
    }
    if (!empty($data[3])) {
        if (is_array($data[3])) {
            foreach ($data[3] as $content) {
                add_content_file(4, $day, $month, $content);
            }
        } else {
            add_content_file(4, $day, $month, $data[3]);
        }
    }
}
echo 'END' . PHP_EOL;
exit();
