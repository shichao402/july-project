<?php
session_start();
session_destroy();
include '../sftp.php';
include './ftpconfig.php';
foreach ($ftpip as $ip) {
    $sftp = new SFTPConnection($ip);
    $sftp->login('xj', 'ju8$#%^8kmj,)@qamv');
    $result = $sftp->scanFilesystem('/home/xj/webapps/');
    for ($i = count($result) - 1; $i>=0;$i--) {
        if (strstr($result[$i], '.tar.gz') !== false) {
            unset($result[$i]);
        }
        if (strstr($result[$i], '.tgz') !== false) {
            unset($result[$i]);
        }
    }
    $result = array_diff($result,$ignore);
    if (!file_exists("./temp/{$ip}")) {
        mkdir("./temp/{$ip}");
    }
    foreach ($result as $each) {
        $sftp->receiveFile("/home/xj/webapps/{$each}/Application/Config/Config.php", "./temp/{$ip}/{$each}");
    }
}
echo "<script>window.location.href='./paser.php'</script>";
?>
