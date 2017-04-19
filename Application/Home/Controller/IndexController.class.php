<?php

namespace Home\Controller;

use Common\Controller\BaseController;

class IndexController extends BaseController {

	public function index() {
		$username = cookie('username');
		$password = cookie('password');
		if (empty($username) || empty($password)) {
			$this -> redirect('Public/login');
// 			$url = U('Public/login');
// 			$redirect = $_SERVER['REQUEST_URI'];
// 			$redirect = urlencode($redirect);
// 			$url = $this -> getCurrentHost() . $url . '?redirect=' . $redirect;
// 			header('Location: ' . $url);
// 			exit();
		}
		$this -> display();
	}

	public function header() {
		$this -> display();
	}

	public function menu() {
		$m = M('WebMenu');
		$navList = array ();
		$where['type'] = 1;
		$where['status'] = 1;
		$navData = $m -> where($where) -> select();
		foreach($navData as $key => $item) {
			$navChildList = array ();
			$whereChild['pid'] = $item['id'];
			$whereChild['status'] = 1;
			$navChildData = $m -> where($whereChild) -> select();
			foreach($navChildData as $key2 => $item2) {
				$navChildList[$key2]['id'] = $item2['id'];
				$navChildList[$key2]['func'] = $item2['func'];
				$navChildList[$key2]['name'] = $item2['name'];
			}
			$navList[$key]['name'] = $item['name'];
			$navList[$key]['navChildList'] = $navChildList;
		}
		$this -> assign('navList', $navList);
		$this -> display();
	}

}