<?php
class User {
    private $data = array();
    private $token;
    private $db;
    public function __construct() {
        $this->db = July::instance('db');
    }
    /**
     *  authenticate by token.按照分析出的id从数据库中读入password,再MD5验证.数据库可抛出错误.
     * @param string $encryptedToken
     * @return boolean
     */
    public function authenticate($encryptedToken) {
        if (!empty($encryptedToken)) {
            list($null,$userId,$token) = explode('_', $encryptedToken);
        } else {
            return false;
        }
        $queryString = "SELECT id,password FROM user WHERE id=".$userId;
        $user = $this->db->selectFirst($queryString, true);
        if ($token === md5($user['id'].$user['password'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     *  login use account and password,and save token in this object.if not or account/password empty, throw exception
     * @param string $account
     * @param string $password
     */
    public function login($account,$password) {
        if (empty($account) || empty($password)) {
            throw new Exception("account or password is empty\n");
        }
        $queryString = "SELECT id,password FROM user WHERE account='{$account}'";
        $user = $this->db->selectFirst($queryString, true);
        if ($user['password'] == $password) {
            $this->token = $user['id'].'_'.md5($user['id'].$user['password']);
        } else {
            throw new Exception("wrong password\n");
        }
    }
    /**
     *  cookie current user's token
     * @param int $expire expire second
     * @param string $path effect path
     */
    public function remember($expire,$path) {
        $value = $this->data['id'].'_'.$this->token;
        $expire = $expire == 0 ? 0 : time()+$expire;
        setcookie('token', $value, $expire, $path, $_SERVER['HTTP_HOST']);
    }
    /**
     *  get current user's token
     * @return string
     */
    public function token() {
        return $this->data['id'].'_'.$this->token;
    }
    /**
     *  register a new user
     * @param array $data associate array,field must effect in db.
     */
    public function register($data) {
        $queryString = "INSERT INTO user (".implode(array_keys($data), ',').") VALUES (".implode($data, ',').")";
        if (!$this->db->insert($queryString)) {
            throw new Exception("user information insert failed\n");
        }
    }
    /**
     *  delete a user by id
     * @param int $id
     */
    public function delete($id) {
        $queryString = "DELETE FROM user WHERE id = {$id}";
        if (!$this->db->delete($queryString)) {
            throw new Exception("user delete failed\n");
        }
    }
    /**
     *  get user's infomation
     * @param int $id
     * @return array associate array
     */
    public function infomation($id) {
        if (empty($this->data)) {
            $queryString = "SELECT * FROM user WHERE id=".$id;
            $user = $this->db->selectFirst($queryString, true);
            return $user;
        }else {
            return $this->data;
        }
    }
    /**
     *  change user's passowrd
     * @param int $id
     * @param string $oldPassword
     * @param string $newPassword
     * @return boolean
     */
    public function changePassword($id,$oldPassword,$newPassword) {
        if ($oldPassword == $this->user['password']) {
            $queryString = "UPDATE user SET password = {$newPassword} WHERE id = {$id}";
            if ($this->db->update($queryString)) {
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    /**
     *  modify user's infomation
     * @param array $newData keys must effect in db
     */
    public function modifyInfomation($id,$newData) {
        $updateString = "UPDATE user SET ";
        if (!empty($newData)) {
            foreach ($newData as $key => $value) {
                $updateString .= $key.' = '.$value.',';
            }
            $updateString = substr($updateString, 0, -1);
            $updateString .= "WHERE id = {$id}";
            if (!$this->db->update($updateString)) {
                throw new Exception("modify is not null\n");
            }
        }else {
            throw new Exception("nothing need to modify\n");
        }
        
    }
}
?>
