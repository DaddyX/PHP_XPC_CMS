<?php
return array( 

	'DEFAULT_MODULE' => 'Home', // 默认模块
    'URL_MODEL'   =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	
    'URL_CASE_INSENSITIVE' =>true, //表示URL访问不区分大小写
    
    'URL_HTML_SUFFIX'       =>  '',  // URL伪静态后缀设置html
   
	//权限验证设置
	'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, 
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'xy_auth_group', 
        'AUTH_GROUP_ACCESS' => 'xy_auth_group_access', 
        'AUTH_RULE' => 'xy_auth_rule', 
        'AUTH_USER' => 'xy_user'
    ),
	'NOT_AUTH_MODULE' => 'Public,Index', // 默认无需认证模块
    //超级管理员id,拥有全部权限,只要用户uid在这个角色组里的,就跳出认证.可以设置多个值,如array('1','2','3')
    'ADMINISTRATOR'=>array('1'),
	'SESSION_OPTIONS' =>  array('expire'=>36000),
	'SESSION_PREFIX'        =>  'xykj', 
	
	 // 加载扩展配置文件 多个用,隔开
	'LOAD_EXT_CONFIG' => 'web,db,email,sms,other', 
	
	//上传设置
	'UPLOAD_MAXSIZE'=>31457280,
	'UPLOAD_EXTS'=>array('jpg','gif','png','jpeg','txt','doc','docx','xls','xlsx','ppt','pptx','pdf','rar','zip','wps','wpt','dot','rtf','dps','dpt','pot','pps','et','ett','xlt','mp3','mid','wav','wma'),// 设置附件上传类型 
	'UPLOAD_SAVEPATH'=>'./Public/',
	
	/* COOKIE设置 */
	'COOKIE_PREFIX'        =>  'xpc_', // cookie 前缀
	
	//'SHOW_PAGE_TRACE'=>true,	
	
	//email发信设置 可以在后台进行设置
	'email_config' => array(
			'secure' => 'ssl',	 //链接加密方式 Options: "", "ssl" or "tls"; 为空时, 端口一般是25; ssl , 端口一般为 465 ;
			'host' => 'smtp.qq.com',	 //SMTP 服务器
			'port' => '465',	//SMTP 端口, 一般为25, QQ为465或587
			'username' =>'450183439@qq.com', //邮箱帐号
			'psw' => 'ktfzawngqxbwbijb', //邮箱密码 QQ使用SMTP授权码
			'From' => '450183439@qq.com', //发件人地址
			'FromName' => '童颜无忌', //发件人姓名
	),
);
