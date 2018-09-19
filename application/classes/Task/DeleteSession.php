<?php defined('SYSPATH') or die('NoD direct script access.');
/*
 * 删除appsession
 *
*/
class Task_DeleteSession extends Minion_Task
{
	protected  $_options = array();
	public function _execute(array $params){
		DB::query(Database::DELETE, 'DELETE  from `tcwx_session_app` where `expire_in`<unix_timestamp(now())')->execute();
	}
}