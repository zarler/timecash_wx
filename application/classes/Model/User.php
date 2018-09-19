<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 身份证图片数据
 */
//关键词常量
class Model_User extends Model_Home {
    //获得用户信息
    public function get_userinfo($openid){
        return DB::query(Database::SELECT, "SELECT f.credit_amount as credit_amount ,u.name as name,u.mobile as mobile,w.headimgurl as headimgurl FROM {$this->prefix}user as u, {$this->prefix}user_wechat as w ,{$this->prefix}finance_profile as f where w.openid='{$openid}' and w.user_id = u.id and f.user_id = u.id")->execute()->current();
    }
    //获得用户基本信息
    public function get_basic_userinfo($openid){
        return DB::select('user_id,nickname,headimgurl,wechat_passport')->from('user_wechat')->where('openid','=',$openid)->limit(1)->execute()->current();
    }
    //获得用户基本信息
    public function get_basic_userinfo_field($field = null,$openid){
        if(empty($field)){
            return false;
        }
        return DB::select($field)->from('user_wechat')->where('openid','=',$openid)->limit(1)->execute()->current();
    }
    //获得用户基本信息
    public function get_userinfo_touid($user_id){
        return DB::select('user_id,nickname,headimgurl,mobile')->from('user_wechat')->where('user_id','=',$user_id)->limit(1)->execute()->current();
    }
//获得用户基本信息
    public function get_userinfo_arr($field,$array = null){
        if(!$array){
            return false;
        }
        $query = DB::select($field)->from('user_wechat');
        foreach($array as $key=>$val){
            $query->and_where($key,'=',$val);
        }
        return $query ->limit(1)->order_by('update_time','DESC')->execute()->current();
    }
    //获得用户性别，判断进来的用户是男 是女 用于身份证上传那的男女背景图展示
    public function get_sex(){
        $uid = $this->session->sessionGet('uid');
        return DB::query(Database::SELECT, "SELECT sex FROM {$this->prefix}user_identity   WHERE user_id='{$uid}' order by create_time desc limit 1")->execute()->current();
    }
    //查找用户身份证
    public function get_identity(){
        return  DB::select('code')->from('user_identity')->where('user_id', '=', $this->session->sessionGet('uid'))->and_where('status', '=', '1')->execute()->current();
    }
    //修改微信返回用户信息
    public function set_user_wechat_info($array,$openid){
        //Tool::factory('Debug')->array2file(array($array,$openid,1111111,DB::update('user_wechat')->set($array)->where('openid','=',$openid)->compile()), APPPATH.'../static/liu_test.php');
        return DB::update('user_wechat')->set($array)->where('openid','=',$openid)->execute();
    }

    //修改微信返回用户信息,用userid
    public function set_user_wechat_info_userid($array,$userid){
        //Tool::factory('Debug')->array2file(array($array,$openid,1111111,DB::update('user_wechat')->set($array)->where('openid','=',$openid)->compile()), APPPATH.'../static/liu_test.php');
        return DB::update('user_wechat')->set($array)->where('user_id','=',$userid)->execute();
    }

    //修改用户step信息
    public function set_user_step_info($array=null,$user_id=null){
        //Tool::factory('Debug')->array2file(array($array,$openid,1111111,DB::update('user_wechat')->set($array)->where('openid','=',$openid)->compile()), APPPATH.'../static/liu_test.php');
        if(empty($array)||empty($user_id)){
            return false;
        }
        return DB::update('ci_step')->set($array)->where('user_id','=',$user_id)->execute();
    }

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
    
    
    
    //创建新用户
    public function insert_user_info($array){
        list($insert_id, $total_rows) = DB::insert('user', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //创建用户微信关联表信息
    public function insert_user_wechat_info($array){
        list($insert_id, $total_rows) =  DB::insert('user_wechat',array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //取user表里的 某些字段做判断
    public function user_isstatus($openid,$field){
        return DB::query(Database::SELECT, "SELECT $field FROM {$this->prefix}user where id = (select user_id from {$this->prefix}user_wechat where openid='{$openid}' )")->execute()->current();
    }
    //修改用户信息
    public function set_user_info($array){
         DB::update('user')->set($array)->where('id', '=', $this->session->sessionGet('uid'))->execute();
    }



   //根据字段获取信息
    public function get_fieldstatus($field){//echo date('Y-m-d','1457625600');
        //查询当前用户的借款状态
        $user = Model::factory('Order')->get_orderStatus($field);
        //一笔都没有借的
        if(!isset($user[0]['status'])){
            $info['status']='130';
            $info['statustext']='还没有借款，先来一笔哟';
            //中途退出的
        }elseif($user[0]['status']==='0'){
            $info['status']='140';
            $info['con']=$user[0];
            $info['statustext']='继续借款';
        }else{
            //借了之后的
            if($user[0]['status']==2||$user[0]['status']==4||$user[0]['status']==12||$user[0]['status']==13||$user[0]['status']==14){
                $info['status']='150';
                $info['statustext']='请耐心等待，正在放款中';
            }elseif($user[0]['status']==1){
                $info['status']='240';
                $info['statustext']='借款审核中';
            }
            //借成功之后
            elseif($user[0]['status']==22||$user[0]['status']==9){
                $expire_time = strtotime(date('Y-m-d',$user[0]['expire_time']-86400));
                $time = strtotime(date('Y-m-d',time()));
                $day = ($time-$expire_time)/86400;

                if($day<=0){
                    $info['statustext']='还款失败';
                    $info['status']='270';
                }elseif($day>0 && $day<=3){
                    $info['statustext']='还款失败 已逾期'.$day.'天';
                    $info['status']='270';
                }elseif($day>3){
                    $info['statustext']='还款失败 已逾期'.$day.'天';
                    $info['status']='170';
                }
            }elseif($user[0]['status']==5||$user[0]['status']==20||$user[0]['status']==7||$user[0]['status']==23){
                $expire_time = strtotime(date('Y-m-d',$user[0]['expire_time']-86400));
                $time = strtotime(date('Y-m-d',time()));
                $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
                $abs = abs($day);
                if($abs=='0'){
                    $info['statustext']='今日还款';
                    $info['status']='180';
                }elseif($day>0){
                    $info['statustext']='等待还款 距离还款日还有'.$day .'天';
                    $info['status']='180';
                }elseif($day<0 &&$abs>3){
                    $info['statustext']='还款日'.date('Y-m-d',$user[0]['expire_time']-86400).' 已逾期'.$abs.'天';
                    $info['status']='250';
                }elseif($day<0 &&$abs<=3){
                    $info['statustext']='还款日'.date('Y-m-d',$user[0]['expire_time']-86400).' 已逾期'.$abs.'天';
                    $info['status']='260';
                }else{
                    $info['statustext']='还款日'.date('Y-m-d',$user[0]['expire_time']-86400).' 已逾期'.$abs.'天';
                    $info['status']='250';
                }
            }elseif($user[0]['status']==8||$user[0]['status']==21||$user[0]['status']==51){
                $info['statustext']='还款成功';
                $info['status']='190';
            }elseif($user[0]['status']==50){ //计算出逾期天数
                $expire_time = strtotime(date('Y-m-d',$user[0]['expire_time']-86400));
                $time = strtotime(date('Y-m-d',time()));
                $day = ($time-$expire_time)/86400;
                $info['statustext']='还款日'.date('Y-m-d',$user[0]['expire_time']-86400).' 已逾期'.$day.'天';
                $info['status']='200';
            }elseif($user[0]['status']==3||$user[0]['status']==10){
                $info['statustext']='订单已关闭';
                $info['status']='210';
            }elseif($user[0]['status']==52){
                $info['statustext']='逾期订单关闭';
                $info['status']='220';
            }elseif($user[0]['status']==6||$user[0]['status']==11){
                $info['statustext']='还款处理中';
                $info['status']='230';
            }else{
                $info['statustext']='请稍等，正在处理中';
            }
            $info['con']=$user[0];
        }
        return $info;
    }
}