<?php defined('SYSPATH') or die('No direct script access.');
	/*
		
	*/
    class Model_Coupon extends Model_Home{
		//获取表前缀
		private function prefix(){
			return Kohana::$config->load('database.default.table_prefix');
		}
		//读取当前用户所有可以使用的优惠券  $userid  用户id
        public function UserCoupon($userid){	
			$time = time();
			//优惠券列表
			$list['couponlist'] = DB::query(Database::SELECT, "select `type`,min_day,min_loan,full_cut,id,name,amount,expire_time from tc_coupon_data where (status='1' or status='0') and user_id='{$userid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' order by min_loan asc")->execute()->as_array();
			//优惠券个数
			$list['count']=count($list['couponlist']);
			return $list;
		}
		//设置优惠券待用状态
		public function set_status($array,$couponid){
			DB::update('coupon_data')->set($array)->where('id', '=', $couponid)->execute();
		}
		//获得用户指定优惠券信息
		public function get_coupon($couponid){
			return DB::select('status,id')->from('coupon_data')->where('id', '=', $couponid)->execute()->current();
		}



		/*
			//判断用户上传上来的优惠券ID是否可用
			$userid  用户id
			$id      优惠券ID
			$money   借款金额
			$poundage 借款利息
		*/
		public function CouponId($userid,$id,$money,$day,$poundage){
			//当前时间  用于判断别搜到过期的优惠券
			$time = time();
			$coupin = DB::query(Database::SELECT, "select amount,`type`,min_day,min_loan,full_cut from {$this->prefix()}coupon_data where id='{$id}' and (status='1' or status='0') and user_id='{$userid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' ")->execute()->current();
			//如果不存在  直接false
			if(empty($coupin)){
				return false;
			}else{
				//判断优惠券类别，在类型中的优惠券  是否可用
				switch ($coupin['type']){
					//满金额
					case '1':
						if($money>=$coupin['min_loan']){
							//可用返回可用的最小金额
							return $coupin['amount'];
						}else{
							return false;
						}
						break;
					//满金额 满日期
					case '2':
						if($money>=$coupin['min_loan']&&$day>=$coupin['min_day']){
							return $coupin['amount'];
						}else{
							return false;
						}
						break;
					//手续费 满减
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
			//查询出当来的订单是否应用了优惠券 用于中途退出的订单
			$uid      用户id
			$orderid  订单ID
		*/
		public function OrderCoupin($uid,$orderid){
		
			$time=time();
			return  DB::query(Database::SELECT, "select id,amount from {$this->prefix()}coupon_data where user_id='{$uid}' and status='1' and order_id='{$orderid}' and (start_time<'{$time}' or start_time='0') and expire_time>'{$time}' ")->execute()->current();
			//return $OrderCoupin
		}
	}