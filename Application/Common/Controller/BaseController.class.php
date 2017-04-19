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

	public function index() {
		$model = M($this->dbname);
		$map = $this -> _search();
		// if (method_exists($this, '_filter')) {
		// $this -> _filter($map);
		// }
		// if (!empty($model)) {
		// $this -> _list($model, $map);
		// }
		// if (method_exists($this, '_befor_index')) {
		// $this -> _befor_index();
		// }
		$this -> display();
	}

	public function save() {
		$model = M($this->dbname);
		
		$data = $this -> _before_save();
		
		if (empty($id)) {
			$data['create_time'] = time();
			$result = $model -> add($data); // 添加
		} else {
			$result = $model -> where('id=' . $data['id']) -> save($data); // 编辑
		}
		$this -> display();
	}

	public function del() {
		$model = D($this->dbname);
		
		$info = $model -> where('status=0') -> select();
		foreach($info as $key => $v) {
			$attid = $v['attid'];
			$ad['attid'] = 0;
			M('files') -> where(array (
					"attid" => $attid 
			)) -> save($ad);
			if (method_exists($this, '_befor_del')) {
				$this -> _befor_del($v['id']);
			}
		}
		$info = M('files') -> where('attid=0 or status=0') -> select();
		foreach($info as $key => $v) {
			$filepath = $v['folder'] . $v['filename'];
			unlink($filepath);
		}
		M('files') -> where('attid=0 or status=0') -> delete();
		if (method_exists($this, '_after_del')) {
			$this -> _after_del();
		}
		$Rs = $model -> where('status=0') -> delete();
		$this -> mtReturn(200, '清理' . $Rs . '条无用的记录', $_REQUEST['navTabId'], false);
	}

	protected function _search($dbname = '') {
		$dbname = $dbname ? $dbname : $this->dbname;
		$model = M($dbname);
		$map = array ();
		foreach($model -> getDbFields() as $key => $val) {
			if (isset($_REQUEST['keys']) && $_REQUEST['keys'] != '') {
				if (in_array($val, C('SEARCHKEY'))) {
					$map[$val] = array (
							'like',
							'%' . urldecode(trim($_REQUEST['keys'])) . '%' 
					);
				} else {
					// $map [$val] = $_REQUEST['keys'];
				}
			}
		}
		$map['_logic'] = 'or';
		if (isset($_REQUEST['keys']) && $_REQUEST['keys'] != '') {
			$where['_complex'] = $map;
			return $where;
		} else {
			$map['id'] = array (
					"neq",
					"0" 
			);
			$where['_complex'] = $map;
			return $where;
		}
	}

}