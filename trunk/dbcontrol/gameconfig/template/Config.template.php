class Config {
	/**
	 * 数据库
	 * @var unknown_type
	 */
	private static $db = array(
            'common'=>array(
                    'host'=>'<?php echo $dbhost;?>',
                    'username'=>'xj',
					'password'=>'i*&^hj786hj;#d7(!6',
                    'db_name'=>'<?php echo $dbname;?>',
                    'port'=>3306,
             ),
    );

	/**
	 * memcache配置地址
	 * @var unknown_type
	 */
	private static $cache = array(
            'session'=>array(
                    'host'=>'<?php echo $memhost;?>',
                    'port'=><?php echo $memport1;?>,
            ),
            'common'=>array(
                    'host'=>'<?php echo $memhost;?>',
                    'port'=><?php echo $memport1;?>,
            ),
            'fight'=>array(
                    'host'=>'<?php echo $memhost;?>',
                    'port'=><?php echo $memport2;?>,
                    'type'=>'Memcache',
                    'append'=>'fight_bk',
            ),
            'fight_bk'=>array(
                    'host'=>'<?php echo $dbhost;?>',
                    'username'=>'xj',
					'password'=>'i*&^hj786hj;#d7(!6',
                    'db_name'=>'<?php echo $dbname;?>',
                    'port'=>3306,
                    'tb_name'=>'cache',
                    'type'=>'Mysql',
            ),
    );
	/**
	 * xmlrpc地址
	 * @var unknown_type
	 */
	private static $xmlrpc = array(
            'common'=>array(
                    'server'=>'<?php echo $socketprivatehost;?>',
                    'path'=>'/RPC2',
                    'port'=><?php echo $socketport2;?>,
            )
    );

	/**
	 * 获取配置数据
	 * @param String $var 变量名
	 * @param String $key 变量键名
	 * @return Mix $return
	 */
	public static function getConfig($var,$key=null) {
		if(isset(self::${$var}) && $key===null) {
			return self::${$var};
		} elseif(isset(self::${$var}) && isset(self::${$var}[$key])) {
			return self::${$var}[$key];
		} else {
			return null;
		}
	}
}

/**
 * session保存的域
 * @var unknown_type
 */
define('_SES_DOMAIN_','<?php echo $web_domain;?>');

define('_WEB_DOMAIN_','<?php echo $web_domain;?>');

define('_WEBGW_DOMAIN_','<?php echo $webgw_domain;?>');//官网地址

define('_PAY_DOMAIN_','<?php echo $pay_domain;?>');//PAY地址

define('_BBS_DOMAIN_','<?php echo $bbs_domain;?>');//BBS地址

define('_SERVER_DOMAIN_','<?php echo $service_domain;?>');//客服地址

define('_SWF_VER_','<?php echo $swf_ver;?>');

define('_PLAT_VER_','<?php echo $plat_ver;?>');//平台版本

define('_SWF_DOMAIN_','http://swf2.webgame.com.cn/xj/');

define('_SOCKET_IP_','<?php echo $socketpublichost;?>');

define('_SOCKET_PORT_','<?php echo $socketport1;?>');

define('_GAME_TITLE_','<?php echo $game_title;?>');

define('_SAFE_LEVEL_',<?php echo $safe_level;?>);//安全级别，0:无安全限制，1:IP网段限制，2:仅对GM无限制

/**
 * session时间
 * @var unknown_type
 */
define('_SES_LEFETIME_',3600);

/**
 * 请求间隔时间
 * @var unknown_type
 */
define('_SAFE_INTERVAL_',<?php echo $safe_interval;?>);


define('_RPC_KEY_','key');

define('_IS_YEWAMG_','<?php echo $is_yewang;?>');//1  是我们自己平台   0   联合平台

define('_FCM_ON_',<?php echo $FCM;?>);//防沉迷是否打开 0 不打开 1 打开