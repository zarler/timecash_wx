<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Promote extends WxHome
    {
        public function action_index()
        {
            $view = View::factory('Promote/index');
            $view->controller = $this->controller;
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }


    
}