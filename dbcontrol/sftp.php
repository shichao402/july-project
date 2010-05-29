<?php
class SFTPConnection {
    private $connection;
    private $sftp;

    public function __construct($host, $port=22) {
        $this->connection = @ssh2_connect($host, $port);
        if (! $this->connection)
            throw new Exception("Could not connect to $host on port $port.");
    }

    public function login($username, $password) {
        if (! @ssh2_auth_password($this->connection, $username, $password))
            throw new Exception("Could not authenticate with username $username " . "and password $password.");
        $this->sftp = @ssh2_sftp($this->connection);
        if (! $this->sftp)
            throw new Exception("Could not initialize SFTP subsystem.");
    }

    public function uploadFile($local_file, $remote_file) {
        $sftp = $this->sftp;
        if (!file_exists(dirname("ssh2.sftp://$sftp$remote_file"))) {
            $this->RecursiveMkdir(dirname("ssh2.sftp://$sftp$remote_file"),0777);
        }
        $stream = @fopen("ssh2.sftp://$sftp$remote_file", 'w');
        if (! $stream)
            throw new Exception("Could not open file: $remote_file");
        $data_to_send = file_get_contents($local_file);
        if ($data_to_send === false)
            throw new Exception("Could not open local file: $local_file.");
        if (@fwrite($stream, $data_to_send) === false)
            throw new Exception("Could not send data from file: $local_file.");
        @fclose($stream);
    }
    public function copyfile($filepath,$filename,$dir) {
        $sftp = $this->sftp;
        if (!file_exists("ssh2.sftp://$sftp$dir")) {
            $this->RecursiveMkdir("ssh2.sftp://$sftp$dir",0777);
        }
        if (file_exists("ssh2.sftp://$sftp$filepath/$filename")) {
            if (!file_exists(dirname("ssh2.sftp://$sftp$dir/$filename"))) {
                $this->RecursiveMkdir(dirname("ssh2.sftp://$sftp$dir/$filename"),0777);
            }
            if (!copy("ssh2.sftp://$sftp$filepath/$filename","ssh2.sftp://$sftp$dir/$filename")) {
                throw new Exception("copy failed: ssh2.sftp://$sftp$filepath/$filename -> ssh2.sftp://$sftp$dir/$filename");
            }
        }
    }
    public function rename($filepath,$filename,$dir) {
        $sftp = $this->sftp;
        $from = "$filepath/$filename";
        $to = "$dir/$filename";
        if (!file_exists("ssh2.sftp://$sftp$dir")) {
            $this->RecursiveMkdir("ssh2.sftp://$sftp$dir",0777);
        }
        if (file_exists("ssh2.sftp://$sftp$filepath/$filename")) {
            if (!file_exists(dirname("ssh2.sftp://$sftp$dir/$filename"))) {
                $this->RecursiveMkdir(dirname("ssh2.sftp://$sftp$dir/$filename"),0777);
            }
            if (!ssh2_sftp_rename($sftp,$from,$to)) {
                throw new Exception("rename failed: $from -> $to");
            }
        }
    }
    function scanFilesystem($remote_file) {
        $sftp = $this->sftp;
        $dir = "ssh2.sftp://$sftp$remote_file";
        $tempArray = array();
        $handle = opendir($dir);
        // List all the files
        while (false !== ($file = readdir($handle))) {
            if (substr("$file", 0, 1) != ".") {
                if(is_dir($file)) {
//                $tempArray[$file] = $this->scanFilesystem("$dir/$file");
                } else {
                    $tempArray[]=$file;
                }
            }
        }
        closedir($handle);
        return $tempArray;
    }

    public function receiveFile($remote_file, $local_file) {
        $sftp = $this->sftp;
        $stream = fopen("ssh2.sftp://$sftp$remote_file", 'r');
        if (! $stream) {
            throw new Exception("Could not open file: $remote_file");
        }
        $contents = stream_get_contents($stream);
        file_put_contents ($local_file, $contents);
        @fclose($stream);
    }

    public function deleteFile($remote_file) {
        $sftp = $this->sftp;
        unlink("ssh2.sftp://$sftp$remote_file");
    }
    public function RecursiveMkdir($path,$mode) {
        if (!file_exists($path)) {
            $this->RecursiveMkdir(dirname($path), $mode);
            mkdir($path, $mode);
        }
    }
}
?>