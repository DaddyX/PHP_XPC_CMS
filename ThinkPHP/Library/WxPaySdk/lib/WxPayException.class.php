<?php

namespace WxPaySdk\lib;

use Think\Exception;

class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
