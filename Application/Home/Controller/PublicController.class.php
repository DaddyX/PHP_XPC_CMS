<?php

namespace Home\Controller;

use Think\Controller;

class PublicController extends Controller {

	/**
	 * 登录
	 */
	public function login() {
		if (!empty($_POST)) {
			$username = I('post.username', "");
			$password = md5(I('post.password', ""));
			
			$where['username'] = $username;
			$where['password'] = $password;
			$rs = M('Admin') -> where($where) -> find();
			if (!$rs) {
				$this -> error("用户名或密码错误");
			}
			cookie('username', $username);
			cookie('password', $password);
			$this -> redirect('Index/index');
			// Redirect("http://" . $_SERVER['SERVER_NAME'] . __ROOT__);
			$this -> success('登录成功，正在跳转...', __ROOT__, 0);
		} else {
			$this -> display();
		}
	}

	/**
	 * 获取验证码
	 */
	public function verify() {
		ob_clean();
		$config['fontSize'] = 20; // 验证码字体大小
		$config['length'] = 4; // 验证码位数
		$config['imageH'] = 35;
		$config['useNoise'] = false; // 关闭验证码杂点
		
		$verify = new \Think\Verify($config);
		$verify->codeSet = '0123456789';
		$verify -> entry();
	}

	/**
	 * 退出登录
	 */
	public function logout() {
		if (!empty($_POST)){
			cookie("username", null);
			cookie("password", null);
			$this->ajaxReturn(200, 'success');
		}else{
			$this->ajaxReturn(300, '退出失败');
		}
		//$this -> redirect('Public/login');
	}

	/**
	 * 清除缓存
	 */
	public function clear() {
		rmdirs(RUNTIME_PATH);
		$this -> display();
	}

	/**
	 * 更改密码
	 */
	public function changepwd() {
		if (IS_POST) {
			$password = I('post.password');
			$repassword = I('post.repassword');
			$oldpassword = I('post.oldpassword');
			
			$map = array ();
			if ($password != $repassword) {
				$this -> mtReturn(300, '两次输入密码不一致！', $_REQUEST['navTabId']);
			}
			$map['password'] = md5(md5($oldpassword));
			$map['id'] = session('uid');
			$User = M('User');
			if (!$User -> where($map) -> field('id') -> find()) {
				$this -> mtReturn(300, '旧密码不符或者用户名错误！', $_REQUEST['navTabId']);
			} else {
				if (empty($password) || strlen($password) < 5) {
					$this -> mtReturn(300, '密码长度必须大于6个字符！', $_REQUEST['navTabId']);
				} else {
					$User['password'] = md5(md5($password));
					$User -> save();
					$this -> mtReturn(200, '密码修改成功！', $_REQUEST['navTabId'], true);
				}
			}
		} else {
			$this -> display();
		}
	}

	/**
	 * 修改信息
	 */
	public function changeinfo() {
		if (!session('uid')) {
			redirect(U('Public/login'));
		}
		$rs = M('User') -> find(session('uid'));
		if (IS_POST) {
			M('User') -> save(I('post.'));
			$this -> mtReturn(200, '修改成功！', $_REQUEST['navTabId'], true);
		} else {
			$this -> assign('Rs', $rs);
			$this -> display();
		}
	}

	/**
	 * 在线人员
	 */
	public function online() {
		$info = M('User');
		$where['update_time'] = array (
				'gt',
				time() - 600 
		);
		$numPerPage = 10;
		cookie('_currentUrl_', __SELF__);
		$list = $info -> where($where) -> limit($numPerPage) -> page($_GET['pageNum'] . ',' . $numPerPage . '') -> select();
		$this -> assign('list', $list);
		$count = $info -> where($where) -> count();
		$this -> assign('totalCount', $count);
		$this -> assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this -> assign('numPerPage', $numPerPage);
		$this -> display();
	}

	public function attfile() {
		$attid = I('attid');
		$this -> assign('attid', $attid);
		$this -> display();
	}

	public function uploads() {
		if (!session('uid')) {
			redirect(U('Public/login'));
		}
		$list = M('files') -> where('attid=' . I("attid")) -> select();
		$this -> assign('list', $list);
		$this -> display();
	}

	/**
	 * 锁定/解锁
	 */
	public function filelock() {
		if (!session('uid')) {
			redirect(U('Public/login'));
		}
		$model = D('files');
		$id = I('get.id');
		if ($id) {
			$data = $model -> find($id);
			$data['id'] = $id;
			if ($data['status'] == 1) {
				$data['status'] = 0;
				$msg = '锁定';
				if (method_exists($this, '_befor_lock')) {
					$this -> _befor_lock($id);
				}
			} else {
				$data['status'] = 1;
				$msg = '启用';
			}
			$model -> save($data);
			$this -> mtReturn(200, $msg . $id, $_REQUEST['navTabId'], true);
		}
	}

	/**
	 * 上传
	 */
	public function upload() {
		if (!session('uid')) {
			redirect(U('Public/login'));
		}
		$upload = new \Think\Upload();
		$upload->maxSize = C('UPLOAD_MAXSIZE');
		$upload->exts = C('UPLOAD_EXTS');
		$upload->savePath = C('UPLOAD_SAVEPATH');
		$info = $upload -> upload();
		$gourl = 'index.php/home/public/attfile/attid/' . I('attid') . '/';
		if (!$info) {
			echo "<script language='javascript' type='text/javascript'>";
			echo "alert('上传失败！$upload->getError()');";
			echo "window.location.href='$gourl'";
			echo "</script>";
			// $this->error($upload->getError());
		} else {
			// dump($info);
			$data['attid'] = I('attid');
			$data['folder'] = 'Uploads/' . str_replace('./', '', $info["filename"]["savepath"]);
			$data['filename'] = $info["filename"]["savename"];
			$data['filetype'] = $info["filename"]["ext"];
			$data['filedesc'] = $info["filename"]["name"];
			$data['uid'] = session('uid');
			$data['addtime'] = date("Y-m-d H:i:s", time());
			// dump($data);
			M('files') -> data($data) -> add();
			$filename = $info["filename"]["name"];
			echo "<script language='javascript' type='text/javascript'>";
			echo "alert('文件$filename 上传成功');";
			echo "window.location.href='$gourl'";
			echo "</script>";
		}
	}

	public function delok() {
		$this -> display();
	}

}