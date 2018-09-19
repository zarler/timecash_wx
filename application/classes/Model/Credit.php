<?php defined('SYSPATH') or die('No direct script access.');
	/*
		
	*/
    class Model_Credit extends Model_Home{
		protected $_field = array(
			'user_id','company','contacts','taobao','jingdong','operator','status'
		);
		protected $_table = 'ci_step';

		//��ȡ��ǰ׺
		private function prefix(){
			return Kohana::$config->load('database.default.table_prefix');
		}
		//����û���Ȩ����
		public function select_credit_count($user_id){
			if(!Valid::not_empty($user_id)){
				return false;
			}
			return  DB::select(implode(',',$this->_field))
				  ->from($this->_table)
				  ->where('user_id','=',$user_id)
				  ->order_by('update_time','DESC')
				  ->limit(1)
				  ->execute()
				  ->count();
		}
		//����û���Ȩ����
		public function select_credit_info($field,$user_id){
			if(!Valid::not_empty($user_id)){
				return false;
			}
			return  DB::select($field)
				->from($this->_table)
				->where('user_id','=',$user_id)
				->order_by('id','DESC')
				->execute()
				->current();
		}
		//����û���Ȩ������Ϣ
		public function insert_credit_step($user_id){
			if(!Valid::not_empty($user_id)){
				return false;
			}
			list($insert_id, $total_rows) = DB::insert($this->_table,$this->_field)
				->values(array($user_id, 0, 0, 0,0,0,1))->execute();
			if($insert_id){
				return $insert_id;
			}
			return false;
		}

		//�������Ϣ������ظ��޸�
			public function insert_update_creditStep($array){
				if(!$array){
					return false;
				}
				$keyarr = implode(",",array_keys($array));
				$valarr = "'".implode("','",array_values($array))."'";
				DB::query(Database::INSERT,"
						INSERT INTO {$this->_prefix}ci_step($keyarr)
						VALUES({$valarr})
						ON DUPLICATE
						KEY UPDATE work_info=VALUES(work_info),
						home_info=VALUES(home_info),
						account_taobao=VALUES(account_taobao),
						account_jingdong=VALUES(account_jingdong),
						mno=VALUES(mno),
						phone_book=VALUES(phone_book),
						call_history=VALUES(call_history),
						contact=VALUES(contact),
						picauth=VALUES(picauth),
						faceid=VALUES(faceid),
						has_fastloan_order=VALUES(has_fastloan_order),
						location=VALUES(location),
						zhimacredit = VALUES(zhimacredit),
						creditcardbill = VALUES(creditcardbill)
						"
				)->execute();
				return true;
			}
	}