<?php

namespace Home\Controller;

use Think\Controller;

class MailerController extends Controller {

	public function index() {
		$this -> display();
	}

	public function send() {
		if (empty($_POST)) {
			$this -> display();
		} else {
			$emailStr = I('post.emailStr', ""); // 地址
			$subject = I('post.subject', "（无主题）"); // 主题
			$body = I('post.body', "（无内容）"); // 内容
			
			$toEmail = explode(',', $emailStr);
			$result = $this -> send_email($toEmail, $subject, $body);
			if ($result) {
				$this -> ajaxReturn(200, 'success');
			} else {
				$this -> ajaxReturn(300, 'failed');
			}
		}
	}
	
	// 作者:深蓝 QQ:1668142999 TEL:13884867561 主页:www.lanelead.com 公司:蓝锂网络
	// 功能函数 - 发送email
	// 参数: $toemail - 要发送到的email地址, 多个使用一维数组即可; $subject - email标题; $body - email主体内容
	function send_email($toemail, $subject, $body) {
		// 示例化PHPMailer核心类
		// vendor模式
		vendor('phpmailer.phpmailer#class');
		$mail = new \PHPMailer\PHPMailer();
		// nameplace 模式;
		// $mail = new \LaneLead\PHPMailer\PHPMailer();
		// 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
		$mail->SMTPDebug = 0;
		
		// 使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
		// 可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
		$mail -> isSMTP();
		// 加密方式 "ssl" or "tls"
		$mail->SMTPSecure = C('email_config.secure'); // 这里要注意, QQ发送邮件使用的ssl方式,如果不设置, 则会失败! 请认真查看下面的配置文件!!!
		                                              // smtp需要鉴权 这个必须是true
		$mail->SMTPAuth = true;
		// 链接qq域名邮箱的服务器地址
		$mail->Host = C('email_config.host');
		// 设置ssl连接smtp服务器的远程服务器端口号 可选465或587
		$mail->Port = C('email_config.port');
		// smtp登录的账号 这里填入字符串格式的qq号即可
		$mail->Username = C('email_config.username');
		// smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
		$mail->Password = C('email_config.psw');
		// 设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
		$mail->From = C('email_config.From');
		// 设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
		$mail->FromName = C('email_config.FromName');
		
		// 设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
		$mail->CharSet = 'UTF-8';
		// 邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
		$mail -> isHTML(true);
		// 设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
		// 添加收件人地址，可以多次使用来添加多个收件人
		if (is_array($toemail)) {
			foreach($toemail as $to_email) {
				$mail -> AddAddress($to_email);
			}
		} else {
			$mail -> AddAddress($toemail);
		}
		// 添加该邮件的主题
		$mail->Subject = $subject;
		// 添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		$mail->Body = $body;
		// 为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
		// $mail->addAttachment('./d.jpg','mm.jpg');
		// 同样该方法可以多次调用 上传多个附件
		// $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
		// dump($mail);exit;
		
		// 发送命令 返回布尔值
		// PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
		$status = $mail -> send();
		
		// 简单的判断与提示信息
		if ($status) {
			// echo 'success';
			return true;
		} else {
			// dump($mail->ErrorInfo);
			return false;
		}
	}

}
