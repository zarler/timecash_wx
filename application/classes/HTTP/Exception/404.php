<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: majin
 * Date: 16/3/14
 * Time: 下午5:36
 */

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {

    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     *
     * @return Response
     */
    public function get_response() {
//        $response_404 = [
//            'code' => "2404",
//            'message' => "服务不存在",
//            'result' => [],
//            'service' => [
//                'ver'=> "1.0",
//                'time'=> date('Y-m-d H:i:s'),
//            ]
//        ];


        $view = View::factory('/v2/Error/index');
        $view->error = '404页面';
        $view->url = '/User/index?#jump=no';
        $out = $view->render();
        exit( $out);
//        echo json_encode($response_404);
//        exit;
//        Template::factory('Error/404',array('title'=>'404', 'content'=>'404 not found!'))->response();

//        $view = View::factory('Error/404');
//
//        // Remembering that `$this` is an instance of HTTP_Exception_404
//        $view->message = $this->getMessage();
//		$view->title='404';
//		$view->content='当前页面无法显示';
//        $response = Response::factory()
//            ->status(404)
//            ->body($view->render());
//
//        return $response;
    }


}