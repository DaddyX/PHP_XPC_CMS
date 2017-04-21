<?php

namespace Common\Controller;

use Think\Controller;

class BaseController extends Controller {
	
	/**
	 * 返回客户端数据格式 (non-PHPdoc)
	 * @see \Think\Controller::ajaxReturn()
	 */
	public function ajaxReturn($code, $msg = '', $data = array()) {
		$dataReturn['code'] = $code;
		$dataReturn['msg'] = $msg;
		if (!empty($data)) {
			$dataReturn['data'] = $data;
		}
		parent :: ajaxReturn($dataReturn);
	}
	
	/**
	 * 获取当前域名
	 * @return string
	 */
	public function getCurrentHost() {
		$host = 'http';
		if (isset($_SERVER["HTTPS"])) {
			if ($_SERVER["HTTPS"] == "on") {
				$host .= "s";
			}
		}
		$host .= "://";
	
		if ($_SERVER["SERVER_PORT"] != "80") {
			// 			$host .= $_SERVER["HTTP_HOST"] . ":" . $_SERVER["SERVER_PORT"];
			$host .= $_SERVER["SERVER_NAME"];
		} else {
			$host .= $_SERVER["SERVER_NAME"];
		}
		return $host;
	}

}