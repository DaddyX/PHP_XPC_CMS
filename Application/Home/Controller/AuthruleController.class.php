<?php

namespace Home\Controller;

use Common\Controller\WebController;

class AuthruleController extends WebController {
	public $typeList = array (
			1 => '一级菜单',
			2 => '二级菜单',
			3 => '隐藏操作' 
	);

	public function index() {
		//$where['status'] = 1;
		$navData = M('WebMenu') -> select();
		foreach($navData as $key => $item) {
			$navList[$item['id']] = $item['name'];
		}
		$this -> assign('data', $navData);
		$this -> assign('navList', $navList);
		$this -> assign('navType', $this->typeList);
		$navStatus = array (
				1 => '已启用',
				2 => '已禁用' 
		);
		$this -> assign('navStatus', $navStatus);
		$this -> display();
	}

	public function save() {
		if (!empty($_POST)) {
			$func = I('post.func', "");
			$type = I('post.type', 0);
			$pid = I('post.pid', 0);
			$name = I('post.name', "");
			
			empty($func) && $this -> ajaxReturn('01', '请输入控制器名称');
			empty($type) && $this -> ajaxReturn('301', '请选择菜单类型');
			if($type != 1 && $pid == 0) {
				$this -> ajaxReturn('301','请选择父级菜单');
			}
			$pid = $type == 1 ? 0 : $pid;
			empty($name) && $this -> ajaxReturn('301', '请输入菜单名称');
			
			$data['func'] = $func;
			$data['type'] = $type;
			$data['pid'] = $pid;
			$data['name'] = $name;
			
			$result = M('WebMenu') -> add($data);
			if ($result) {
				$this -> ajaxReturn(200, '添加成功');
			} else {
				$this -> ajaxReturn(300, '添加失败');
			}
		} else {
			$where['status'] = 1;
			$where['type'] = 1;
			$navData = M('WebMenu') -> field('id,name') -> where($where) -> select();
			foreach($navData as $key => $item) {
				$navList[$item['id']] = $item['name'];
			}
			$this -> assign('navList', $navList);
			$this -> assign('navType', $this->typeList);
			$this -> display();
		}
	}

	public function status() {
		if (!empty($_POST)) {
			$id = I('post.id', 0);
			$status = I('post.status', 1);
			
			$where['id'] = $id;
			$setField = M('WebMenu') -> where($where) -> setField('status', $status);
			if ($setField) {
				$this -> ajaxReturn(200, "操作成功");
			} else {
				$this -> ajaxReturn(300, "操作失败");
			}
		}
	}

}