<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\cache;

use houdunwang\arr\Arr;
use houdunwang\config\Config;

/**
 * 缓存处理基类
 * Class Cache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class Cache {
	//连接
	protected $link = null;
	protected $config;

	public function __construct() {
		$this->config( Config::get( 'cache' ) );
	}

	//设置配置项
	public function config( $name ) {
		if ( is_array( $name ) ) {
			$this->config = $name;

			return $this;
		} else {
			return Arr::get( $this->config, $name );
		}
	}

	//更改缓存驱动
	protected function driver( $driver = null ) {
		$driver     = $driver ?: $this->config( 'driver' );
		$driver     = '\houdunwang\cache\\build\\' . ucfirst( $driver );
		$this->link = new $driver( $this );

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}
		if ( method_exists( $this->link, $method ) ) {
			return call_user_func_array( [ $this->link, $method ], $params );
		}
	}

	public static function __callStatic( $name, $arguments ) {
		return call_user_func_array( [ new static(), $name ], $arguments );
	}
}