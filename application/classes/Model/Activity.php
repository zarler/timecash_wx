<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 银行卡信息
 */
//关键词常量
class Model_Activity extends Model_Home {

    //查找银行卡
    public function get_activity_info($num = null,$user_id){
        if($num){
            $table = 'ac_'.$num.'_turntable';
        }else{
            $table = 'ac_1_turntable';
        }
        $dbfind = DB::select('time,id,template_id')->from($table)->where('user_id', '=', $user_id)->execute()->current();
        return $dbfind;
    }
    //数据库加1insert_statistics
    public function update_time_1($num = null,$user_id){
        if($num){
            $table = $this->prefix.'ac_'.$num.'_turntable';
        }else{
            $table = $this->prefix.'ac_1_turntable';
        }
        $sql="UPDATE `{$table}` SET `time` = `time`+1 WHERE 1 AND `user_id`= {$user_id}";
        return DB::query(Database::UPDATE,$sql)->execute();
    }
    //创建数据
    public function insert_user_info($array,$num = null){
        if($num){
            $table = 'ac_'.$num.'_turntable';
        }else{
            $table = 'ac_1_turntable';
        }
        list($insert_id, $total_rows) = DB::insert($table, array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
    }
    //修改信息
    public function update_info_field($array,$user_id,$num = null){
        if($num){
            $table = 'ac_'.$num.'_turntable';
        }else{
            $table = 'ac_1_turntable';
        }
        return DB::update($table)->set($array)->where('user_id', '=', $user_id)->execute();
    }

    //获得单个优惠券信息
    public function get_coupon_one($id) {
        return DB::select('type','code','name','description','amount','Interest_free','start_time','max_count','expire_time','min_day','min_loan','user_apply','is_days','life_day','show_name','anon','full_cut','min_day','max_day','status','sort')->from('coupon_template')->where('id','=',$id)->where('status','=',1)->execute()->current();
    }
    //添加
    public function grant_coupon($array=array()) {
        if($array){
            $array['status'] = 0;
            $array['create_time'] = time();
            $key = array_keys($array);
            $val = array_values($array);
            list($insert_id,$affected_rows) = DB::insert("coupon_data", $key)->values($val)->execute();
            if($insert_id) {
                return $insert_id;
            }
        }
        return FALSE;
    }
   //搜索信息
    public function get_browse_info($arrand = null,$arror=null){

        if(empty($arrand)||empty($arror)){
            return false;
        }else{
            $dbfind = DB::select()->from('share_total');
            foreach ($arrand as $key=>$val){
                $dbfind->and_where($key,'=',$val);
            }
            $dbfind->and_where_open();
            foreach ($arror as $key=>$val){
                $dbfind->or_where($key,'=',$val);
            }
            $dbfind->where_close();
        }
        $result = $dbfind->execute()->current();
        if(empty($result)){
            return false;
        }
        return $result;
    }
    //搜索信息
    public function get_share_info($arrand = null,$time=true){
        if(empty($arrand)){
            return false;
        }else{
            $dbfind = DB::select()->from('share_total');
            foreach ($arrand as $key=>$val){
                $dbfind->and_where($key,'=',$val);
            }
        }
        if($time){
            $starttime = strtotime(Date('Y-m-d',time()));
            $endtime = $starttime+60*60*24;
            $dbfind->and_where('create_time','>=',$starttime);
            $dbfind->and_where('create_time','<=',$endtime);
        }
        $result = $dbfind->execute()->current();
        return count($result)>0?false:true;
    }
    //搜索信息
    public function get_info($arrand = null,$table=null){
        if(empty($arrand)||empty($table)){
            return false;
        }else{
            $dbfind = DB::select()->from($table);
            foreach ($arrand as $key=>$val){
                $dbfind->and_where($key,'=',$val);
            }
        }
        $result = $dbfind->execute()->current();
        return count($result)>0?false:true;
    }
    //插入数据
    public function insert_browse_info($array = null){
        if(empty($array)){
            return false;
        }
        list($insert_id, $total_rows) = DB::insert('share_total', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    
    //记录h5统计下载页面点击数
    public function get_total_click($array=array()){
        if(empty($array)){
            return false;
        }
        $query=DB::select(array(DB::expr('COUNT(*)'),'total'))->from('click_statistics_h5');
        foreach ($array as $key=>$value){
            $query->where($key,'=',$value);
        }



        $rs=$query->execute()->current();
        return isset($rs['total']) ? $rs['total'] : 0 ;
    }
    //记录h5统计下载页面点击数
    public function insert_click_statistics($array=null){
        if(!empty($array)){
            list($insert_id,$affected_rows) = DB::insert('click_statistics_h5',array_keys($array))->values(array_values($array))->execute();
            return $insert_id;
        }
        return NULL;
    }
    //修改h5统计下载页面点击数
    public function update_click_statistics($user_id=NULL){
        if(!empty($user_id)){
            $sql = 'UPDATE tcwx_click_statistics_h5 SET check_times = check_times+1 WHERE user_id = '.$user_id;
            $query = DB::query(Database::UPDATE, $sql);
            $query->execute();
        }
        return NULL;

    }

    //年庆统计
    public function insert_celebrate_statistics($array=null){
        if(!empty($array)){
            list($insert_id,$affected_rows) = DB::insert('ac_celebrate',array_keys($array))->values(array_values($array))->execute();
            return $insert_id;
        }
        return NULL;
    }

    //统计
    public function insert_statistics($array=null,$table=null){
        if(!empty($array)&&!empty($table)){
            list($insert_id,$affected_rows) = DB::insert($table,array_keys($array))->values(array_values($array))->execute();
            return $insert_id;
        }
        return NULL;
    }
    //获取统计
    public function get_statistics($array=null,$table=null,$time=true){
        if(empty($array)||empty($table)){
            return false;
        }
        $dbfind = DB::select('id')->from($table);
        foreach ($array as $key => $value){
            $dbfind->where($key, '=', $value);
        }
        //是否有时间限制
        if($time){
            $starttime = strtotime(Date('Y-m-d',time()));
            $endtime = $starttime+60*60*24;
            $dbfind->and_where('create_time','>=',$starttime);
            $dbfind->and_where('create_time','<=',$endtime);
        }

//        return $dbfind->compile();
        $result = $dbfind->execute()->current();
        return count($result)>0?false:true;
    }

    //年庆统计
    public function get_celebrate_info($array = null){
        if(empty($array)){
            return false;
        }
        $dbfind = DB::select('id')->from('ac_celebrate');
        foreach ($array as $key => $value){
            $dbfind->where($key, '=', $value);
        }
        $result = $dbfind->execute()->current();
        return count($result)>0?false:true;
    }
    //获取用户授权情况
    //得到用户step信息
    public function get_user_step_info($field,$array = null){
        if(!$array){
            return false;
        }
        $query = DB::select($field)->from('ci_step');
        foreach($array as $key=>$val){
            $query->and_where($key,'=',$val);
        }
        return $query ->limit(1)->execute()->current();
    }
    
    //订单统计
    public function insert_order_count($array=null,$table=null){
        if(!empty($array)&&!empty($table)){
            list($insert_id,$affected_rows) = DB::insert($table,array_keys($array))->values(array_values($array))->execute();
            return $insert_id;
        }
        return NULL;
    }

    //用户浏览查询
    public function select_userid_day($array=null,$table=null,$time=true){
        if(!$array){
            return false;
        }
        $query = DB::select('id')->from($table);
        foreach($array as $key=>$val){
            $query->and_where($key,'=',$val);
        }
        //是否有时间限制
        if($time){
            $starttime = strtotime(Date('Y-m-d',time()));
            $endtime = $starttime+60*60*24;
            $query->and_where('create_time','>=',$starttime);
            $query->and_where('create_time','<=',$endtime); 
        }
        return count($query ->limit(1)->execute()->current())>0?false:true;
    }

    //用户浏览统计,根据用户id和日时间
    public function insert_userid_day($array=null,$table=null){
        if(!empty($array)&&!empty($table)){
            list($insert_id,$affected_rows) = DB::insert($table,array_keys($array))->values(array_values($array))->execute();
            return $insert_id;
        }
        return NULL;
    }

    public function update_counter($action=NULL){
        if(!empty($action)){
            $query = DB::select('id')->from('counter')->where('action','=',$action)->execute()->current();;
            if(Valid::not_empty($query)){
                $sql = 'UPDATE tcwx_counter SET times = times+1 WHERE action = "'.$action.'"';
                $query = DB::query(Database::UPDATE, $sql);
                $query->execute();
            }else{
                DB::insert('counter',array('action','times','create_time'))->values(array($action,1,time()))->execute();
            }
        }
    }


}