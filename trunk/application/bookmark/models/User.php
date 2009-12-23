<?php
class User {
    private $data = array();
    private $token;
    public function __construct() {
        $this->db = July::instance('db');
    }
    public function authenticate($encryptedToken) {
        if (!empty($token)) {
            list($userId,$token) = explode('_', $encryptedToken);
        }
        else {
            throw new Exception("havent login yet\n");
        }
        $queryString = "SELECT id,password FROM user WHERE id=".$userId;
        $user = $this->db->selectFirst($queryString, true);
        if ($token === md5($user['id'].$user['password'])) {
            return true;
        }
        else {
            throw new Exception("token is not effect\n");
        }
    }
    public function login($account,$password) {
        if (empty($account) || empty($password)) {
            throw new Exception("account or password is empty\n");
        }
        $queryString = "SELECT id,password FROM user WHERE account=".$account;
        $user = $this->db->selectFirst($queryString, true);
        if ($user['password'] == $password) {
            $this->token = $user['id'].'_'.md5($user['id'].$user['password']);
        }
        else {
            throw new Exception("wrong password\n");
        }
    }
    public function remember($expire,$path) {
        setcookie('token', $this->id.'_'.$this->token, $expire, $path, $_SERVER['HTTP_HOST']);
    }
    public function token() {
        return $this->data['id'].'_'.$this->token;
    }
    public function register($data) {
        $queryString = "INSERT INTO user (".implode(array_keys($data), ',').") VALUES (".implode($data, ',').")";
        if (!$this->db->insert($queryString)) {
            throw new Exception("user information insert failed\n");
        }
    }
    public function delete($id) {
        $queryString = "DELETE FROM user WHERE id = {$id}";
        if (!$this->db->delete($queryString)) {
            throw new Exception("user delete failed\n");
        }
    }
    public function infomation() {
        if (empty($this->data)) {
            throw new Exception("user information is empty\n");
        }else {
            return $this->data;
        }
    }
    public function changePassword($oldPassword,$newPassword) {
        if ($oldPassword == $this->user['password']) {
            $queryString = "UPDATE user SET password = {$newPassword} WHERE id = {$this->user['id']}";
            if ($this->db->update($queryString)) {
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    public function modifyInfomation($newData) {
        $updateString = "UPDATE user SET ";
        if (!empty($newData)) {
            foreach ($newData as $key => $value) {
                $updateString .= $key.' = '.$value.',';
            }
            $updateString = substr($updateString, 0, -1);
            if (!$this->db->update($updateString)) {
                throw new Exception("modify is not null\n");
            }
        }else {
            throw new Exception("nothing need to modify\n");
        }
        
    }
}
?>
