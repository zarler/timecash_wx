<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: majin
 * Date: 16/3/14
 * Time: 下午5:36
 */

class HTTP_Exception_500 extends Kohana_HTTP_Exception_500 {

    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     *
     * @return Response
     */
    public function get_response() {
        //Template::factory('Error/404',array('title'=>'404', 'content'=>'404 not found!'))->response();

        $view = View::factory('Error/500');
 
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
		$view->title='500';
		$view->content='服务器内部错误';
        $response = Response::factory()
            ->status(500)
            ->body($view->render());
 
        return $response;
    }


}