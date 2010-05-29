<?php
include './DB.php';
include './sftp.php';
$id=$_POST['id'];
$localPath = trim($_POST['path']);
$backup = trim($_POST['backup']);

$db = new DB('61.160.192.2', 'xj', 'z;fs6pjahsuu^5o8', 'xj_admin');
$queryString = "SELECT `ftp_ip`,`ftp_user`,`ftp_password`,`ftp_path` FROM `server_config` WHERE id = {$id}";
$ftpinfo = $db->selectFirst($queryString, true);

$localFileList = scanFilesystemAsList($localPath);
$localPathLength = strlen($localPath);
foreach ($localFileList as $each) {
    $temp[]= trim(substr($each, $localPathLength+1));
}
$localFileList = $temp;
$remotePath = trim($ftpinfo['ftp_path']);
$date = date('Ymdhis');
try {
    $sftp= new SFTPConnection($ftpinfo['ftp_ip']);
    $sftp->login($ftpinfo['ftp_user'], $ftpinfo['ftp_password']);
    if ($backup == 'true') {
        foreach ($localFileList as $each) {
            $localFile = "$localPath/$each";
            $remoteFile = "$remotePath/$each";
            $sftp->rename($remotePath,$each, $ftpinfo['ftp_path'].'/backup/'.$date);
        }
        echo "move $remotePath -> {$ftpinfo['ftp_path']}/backup/$date...ok<br />";
    }
    foreach ($localFileList as $each) {
        $localFile = trim("$localPath/$each");
        $remoteFile = trim("$remotePath/$each");
        $sftp->uploadFile($localFile, $remoteFile);
    }
    echo "upload {$ftpinfo['ftp_ip']}:{$ftpinfo['ftp_path']}...ok<br />";
} catch (Exception $e) {
    echo $e->getMessage();
    echo "failed<br />";
}
function scanFilesystemAsList($dir) {
    $tempArray = array();
    $handle = opendir($dir);
    while (false !== ($file = readdir($handle))) {
        if (substr("$file", 0, 1) != ".") {
            if(is_dir("$dir/$file")) {
                $tempArray = array_merge($tempArray,scanFilesystemAsList("$dir/$file"));
            } else {
                $tempArray[]="$dir/$file ";
            }
        }
    }
    closedir($handle);
    return $tempArray;
}
?>