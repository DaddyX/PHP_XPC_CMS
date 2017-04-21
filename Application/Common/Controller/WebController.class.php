<?php

namespace Common\Controller;

class WebController extends BaseController {
	
	public function __construct() {
		parent :: __construct();
		$menuList = cookie('menuList');
		if (empty($menuList)){
			$menus = array(
					'menu1' => array(
							'name' => '首页',
							'url' => '/xpc/Index/main'
					),
			);
			$menuList = json_encode($menus);
			cookie('menuList', $menuList);
		}
		$menuList = json_decode($menuList, true);
		$this->assign('menuList', $menuList);
	}

}