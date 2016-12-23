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

/**
 * 缓存处理基类
 * Class Cache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class Cache {
	//连接
	protected $link;

	public function __construct() {
	}

	//更改缓存驱动
	public static function driver( $driver = null ) {
		$driver = $driver ?: c( 'cache.driver' );
		$driver = '\houdunwang\cache\\build\\' . ucfirst( $driver );
		static $links = [ ];
		if ( ! isset( $links[ $driver ] ) ) {
			$obj       = new Cache();
			$obj->link = new $driver;
			$obj->link->connect();

			$links[ $driver ] = $obj;
		}

		return $links[ $driver ];
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
		return call_user_func_array( [ static::driver(), $name ], $arguments );
	}
}