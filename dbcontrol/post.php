<?php
include './DB.php';
include './sftp.php';
ob_start();
$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
foreach ($_POST as $key => $each) {
    foreach ($each as $key2 => $value) {
        $queryArray[$key2][$key] = trim($value);
    }
}
foreach ($queryArray as $eachQuery) {
    foreach ($eachQuery as $key => $value) {
        $setArray[] = "`$key` = '$value'";
    }
    extract($eachQuery,EXTR_OVERWRITE);
    require './Config.template.php';
    $fileContent = "<?php\r\n".ob_get_contents()."\r\n?>";
    ob_clean();
    $queryString = "UPDATE `server_config` SET ".implode(',',$setArray)." WHERE id='{$eachQuery['id']}'";
    if (!$db->update($queryString)) {
        echo "<font color='red'>write to database not modified or failed</font><br />\n";
    } else {
        echo "<font color='green'>write to database success</font><br />\n";
    }
    try {
        $remotefile = "{$eachQuery['ftp_path']}/Application/Config/Config.php";
        if (!file_put_contents('./tempfile', $fileContent)) {
            throw new Exception('write localfile failed!');
        }
        $sftp= new SFTPConnection($eachQuery['ftp_ip']);
        $sftp->login($eachQuery['ftp_user'], $eachQuery['ftp_password']);
        $sftp->uploadFile('./tempfile', $remotefile);
        echo "<font color='green'>upload $remotefile config at {$eachQuery['ftp_ip']}...successed!</font><br />\n";
    } catch (Exception $e) {
        echo $e->getMessage();
        echo "<font color='red'>upload $remotefile config at {$eachQuery['ftp_ip']}...failed!</font><br />\n";
    }
    ob_flush();
}
?>
