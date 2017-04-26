<?php

namespace Common\Controller;

class WebController extends BaseController {
	
	public function __construct() {
		parent :: __construct();
		
		$username = cookie('username');
		if (empty($username)){
			if (CONTROLLER_NAME != 'Public') {
				header('Location:' . U('Public/login'));
				exit();
			}
		}
		
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

	/**
	 * 身份证实名认证 SDK
	 */
	public function checkIdNumber($idNumber, $realName) {
		$url = "http://apis.haoservice.com/idcard/VerifyIdcard";
		$postData = array (
				"key" => " ",
				"cardNo" => $idNumber,
				"realName" => $realName
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		$output = curl_exec($ch);
		curl_close($ch);
		// 获得的数据
		return json_decode($output, true);
	}
}