<?php
include '../sftp.php';
ob_start();
$data = file_get_contents('./data');
$data = unserialize($data);
echo "<pre>\n";
ob_flush();
foreach ($data as $filename => $value) {
    extract($value,EXTR_OVERWRITE);
    if ($upload == 'on') {
        include './template/Config.template.php';
        $fileContent = "<?php\r\n".ob_get_contents()."\r\n?>";
        ob_clean();
        $temp = explode('/',$filename);
        $_ip = str_replace('_','.',$temp[0]);
        $_name = $temp[1];
        $localfile = './temp/'.$_ip.'/'.$_name;
        file_put_contents($localfile, $fileContent);
        try {
            $sftp= new SFTPConnection($_ip);
            $sftp->login('xj', 'ju8$#%^8kmj,)@qamv');
            $sftp->uploadFile($localfile, "/home/xj/webapps/{$_name}/Application/Config/Config.php");
            echo "<font color='green'>upload $_name config at $_ip...successed!</font>\n";
        } catch (Exception $e) {
            echo "<font color='red'>upload $_name config at $_ip...failed!</font>\n";
        }
        ob_flush();
    }
    $upload = '';
}
echo "</pre>";

?>
<a href="reciver.php" >recive config from remote server</a><br />
<a href="view.php">view local config</a>