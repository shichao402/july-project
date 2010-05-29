<form action ='./buildpatches.php' method='POST'>
    filelist
    <textarea name ='path' rows="15" cols="100"></textarea>
    </br>
    mysql table
    <textarea name ='table' rows="15" cols="100"></textarea>
    </br>
    user
    <input name ="user" type="input" size="50" value="scyang"/>
    </br>
    comment
    <textarea name ='comment' rows="10" cols="50"></textarea>
    </br>
    <input type= 'submit' name ="submit">
</form>
<?php
if (!isset($_POST['submit'])) {
    exit();
}
$host='192.168.0.3';
$username='xj';
$password='i*&^hj786hj;#d7(!6';
$dbname='xjtest';
$sourceDir = realpath('..');
$patchesRoot = $sourceDir.'/patches';
$user = $_POST['user'];

$table = $_POST['table'];
if (!empty($table)) {
	$tableArray = explode("\r\n",$table);
	$tableArray = array_unique($pathArray);
	$tableString = implode(' ',$tableArray);
} else {
	$tableString = '';
}

$path = $_POST['path'];
if (!empty($path)) {
	$pathArray = explode("\r\n",$path);
	$pathArray = array_unique($pathArray);
	foreach ($pathArray as $each) {
		if (!file_exists($sourceDir.'/'.$each)) {
			$errorPath[] = $sourceDir.'/'.$each;
		}
	}
	if (!empty($errorPath)) {
		exit("path not exists:".var_dump($errorPath));
	}
}

$createtime = date("Y-m-d H:i:s");
$date = date("Ymd");
if (!is_dir("$patchesRoot/$date")) {
    mkdir("$patchesRoot/$date",0777);
}
$versionArray = scanFilesystem("$patchesRoot/$date",0);
foreach ($versionArray as $each) {
    if ($each > $pre) {
        $pre = $each;
    }
}
$version = str_pad((string) ($pre+1),2,'0',STR_PAD_LEFT);

if (!file_exists("$patchesRoot/$date/$version")) {
    mkdir("$patchesRoot/$date/$version",0777);
}
if (!file_exists("$patchesRoot/$date/$version/files")) {
    mkdir("$patchesRoot/$date/$version/files",0777);
}
if (!file_exists("$patchesRoot/$date/$version/mysql")) {
    mkdir("$patchesRoot/$date/$version/mysql",0777);
}
if (!file_exists("$patchesRoot/$date/$version/info.txt")) {
    touch("$patchesRoot/$date/$version/info.txt");
}

foreach ($pathArray as $each) {
    //$a = $a && smartCopy("$sourceDir/$each", "$patchesRoot/$date/$version/files/$each", $options=array('folderPermission'=>0777,'filePermission'=>0777));
    echo system("cd $sourceDir;cp -rv --parents $each $patchesRoot/$date/$version/files",$f);
	echo "\r\n";
}
echo $f == 0 ? "文件复制成功" : "文件复制失败,code:$f\n";
$s = 0;
if (!empty($tableString)) {
	$sqlname = date("YmdHis");
    echo system("/usr/local/mysql/mysqldump -h $host -u$username -p\"$password\" $dbname $tableString > $patchesRoot/$date/$version/mysql/$sqlname.sql",$s);
    echo $s == 0 ? "mysqldump导出成功" : "mysqldump导出失败,code:$s\n";
}

if ($f != 0 || $s != 0 || $i != 0) {
    echo "开始删除...\n";
    echo system("rm -r $patchesRoot/$date/$version",$d);
    echo $d == 0 ? "删除成功" : "删除失败,code:$d\n";
}
echo "</pre>";
function scanFilesystem($dir,$r = 1) {
    $tempArray = array();
    $handle = opendir($dir);
    // List all the files
    while (false !== ($file = readdir($handle))) {
        if (substr("$file", 0, 1) != ".") {
            if(is_dir($dir.'/'.$file)) {
                if ($r == 1) {
                    $tempArray[$file] = scanFilesystem("$dir/$file");
                }elseif($r == 0) {
                    $tempArray[] = $file;
                }
            } else {
                $tempArray[]=$file;
            }
        }
    }
    closedir($handle);
    return $tempArray;
}

$info = array(
    'author' => $user,
    'ctime' => $createtime,
    'version' => $date.$version,
    'comment'=> $_POST['comment'],
    'file' => $file,
    'mysql' => $mysql
);
if (file_put_contents("$patchesRoot/$date/$version/info.txt",$info) == 0) {
    echo "写入patch信息失败\n";
    $i = 1;
}else {
    echo $info;
}
?>