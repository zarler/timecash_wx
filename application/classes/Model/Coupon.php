<?php defined('SYSPATH') or die('No direct script access.');
	/*
		
	*/
    class Model_Coupon extends Model_Home{
		//��ȡ��ǰ׺
		private function prefix(){
			return Kohana::$config->load('database.default.table_prefix');
		}
		//��ȡ��ǰ�û����п���ʹ�õ��Ż�ȯ  $userid  �û�id
        public function UserCoupon($userid){	
			$time = time();
			//�Ż�ȯ�б�
			$list['couponlist'] = DB::query(Database::SELECT, "select `type`,min_day,min_loan,full_cut,id,name,amount,expire_time from tc_coupon_data where (status='1' or status='0') and user_id='{$userid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' order by min_loan asc")->execute()->as_array();
			//�Ż�ȯ����
			$list['count']=count($list['couponlist']);
			return $list;
		}
		//�����Ż�ȯ����״̬
		public function set_status($array,$couponid){
			DB::update('coupon_data')->set($array)->where('id', '=', $couponid)->execute();
		}
		//����û�ָ���Ż�ȯ��Ϣ
		public function get_coupon($couponid){
			return DB::select('status,id')->from('coupon_data')->where('id', '=', $couponid)->execute()->current();
		}



		/*
			//�ж��û��ϴ��������Ż�ȯID�Ƿ����
			$userid  �û�id
			$id      �Ż�ȯID
			$money   �����
			$poundage �����Ϣ
		*/
		public function CouponId($userid,$id,$money,$day,$poundage){
			//��ǰʱ��  �����жϱ��ѵ����ڵ��Ż�ȯ
			$time = time();
			$coupin = DB::query(Database::SELECT, "select amount,`type`,min_day,min_loan,full_cut from {$this->prefix()}coupon_data where id='{$id}' and (status='1' or status='0') and user_id='{$userid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' ")->execute()->current();
			//���������  ֱ��false
			if(empty($coupin)){
				return false;
			}else{
				//�ж��Ż�ȯ����������е��Ż�ȯ  �Ƿ����
				switch ($coupin['type']){
					//�����
					case '1':
						if($money>=$coupin['min_loan']){
							//���÷��ؿ��õ���С���
							return $coupin['amount'];
						}else{
							return false;
						}
						break;
					//����� ������
					case '2':
						if($money>=$coupin['min_loan']&&$day>=$coupin['min_day']){
							return $coupin['amount'];
						}else{
							return false;
						}
						break;
					//������ ����
					case '3':
						if($poundage>=$coupin['full_cut']){
							return $coupin['amount'];
						}else{
							return false;
						}
						break;
				}
			}
		}
		
		/*
			//��ѯ�������Ķ����Ƿ�Ӧ�����Ż�ȯ ������;�˳��Ķ���
			$uid      �û�id
			$orderid  ����ID
		*/
		public function OrderCoupin($uid,$orderid){
		
			$time=time();
			return  DB::query(Database::SELECT, "select id,amount from {$this->prefix()}coupon_data where user_id='{$uid}' and status='1' and order_id='{$orderid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' ")->execute()->current();
			//return $OrderCoupin
		}
	}