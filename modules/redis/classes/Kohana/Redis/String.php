<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Redis
 * Type: 	string
 * Editor: 	majin
 * Updated:	2016-07-22
 * Des:		字符串模式(key=>value)
 *
 * 	$me = Redis_String::instance('default')->get('majin');
 *
 *
 */
class Kohana_Redis_String extends Kohana_Redis_Connect {

	public static $type = 'String';

	public static function instance($name = NULL, array $config = NULL){
		Kohana_Redis::$type = Kohana_Redis_String::$type;
		return parent::instance($name,$config);
	}
	/** 是否存在
	 * @param null $key
	 * @return bool : If the key exists, return TRUE, otherwise return FALSE.
	 * @throws Redis_Exception
	 */
	public function exists($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->exists($key);
	}


	/** 类型
	 * @param null $key
	 * @return bool | Depending on the type of the data pointed by the key, this method will return the following
	 * value:
	 * 		string: Redis::REDIS_STRING set: Redis::REDIS_SET list: Redis::REDIS_LIST zset: Redis::REDIS_ZSET
	 * 		hash: Redis::REDIS_HASH
	 * 		other: Redis::REDIS_NOT_FOUND
	 * @throws Redis_Exception
	 */
	public function type($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->type($key);
	}

	/** 长度
	 * @param null $key
	 * @return bool | Int
	 * @throws Redis_Exception
	 */
	public function strlen($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->strLen($key);
	}


	/** 获取:单个|批量
	 * @param null $key
	 * @return bool | String |  Array: Array containing the values related to keys in argument
	 * @throws Redis_Exception
	 */
	public function get($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		if(is_array($key)){
			return $this->_connection->mGet($key);
		}
		return $this->_connection->get($key);
	}



	/** 单个设置
	 * @param null $key
	 * @param $value
	 * @param null $params
	 *
	 * @param $key-values
	 * @param null $params
	 *
	 *
	 * @return bool
	 * @throws Redis_Exception
	 */
	public function set($key=NULL, $value=NULL, $params=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		if(is_array($key)){
			if($value!==NULL){
				$params = $value;
				return $this->_connection->mSet($key, $params); // mset(array('a1'=>'v1','a2'=>'v2'),array('xx','ex'=>1200))
			}
			return $this->_connection->mSet($key);//mset(array('a1'=>'v1','a2'=>'v2'));
		}
		if($value===NULL){
			return FALSE;
		}
		if($params!==NULL){
			return $this->_connection->set($key, $value, $params);
		}else{
			return $this->_connection->set($key, $value);
		}
	}


	/** 追加
	 * @param null $key
	 * @param $value
	 * @return bool | Int Size of the value after the append
	 * @throws Redis_Exception
	 */
	public function append($key=NULL, $value) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->append($key, $value);
	}


	/** 删除
	 * @param null $key | array $keys 支持数组可以删除多个
	 * @return bool | Long Number of keys deleted.
	 * @throws Redis_Exception
	 */
	public function del($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->delete($key);

	}


	/** 设置过期时间
	 * @param null $key
	 * @param $seconds
	 * @return bool
	 * @throws Redis_Exception
	 */
	public function expire($key=NULL, $seconds) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->setTimeout($key, $seconds);
	}


	/** 搜索KEY
	 * @param null $key
	 * @return bool | array
	 * @throws Redis_Exception
	 * find('user_*');//搜索user_开头的键
	 * find('*');//搜索全部键
	 */
	public function find($key=NULL) {
		if($key===NULL){
			return FALSE;
		}
		$this->_connection or $this->connect();
		return $this->_connection->keys($key);
	}


    /** 更改键名
     * @param null $key
     * @param null $newkey
     * @return bool
     * @throws Redis_Exception
     */
    public function rename($key=NULL,$newkey=NULL){
        if($key===NULL || $newkey===NULL){
            return FALSE;
        }
        $this->_connection or $this->connect();
        return $this->_connection->rename($key,$newkey);
    }





} // End
