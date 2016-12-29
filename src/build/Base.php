<?php namespace houdunwang\cache\build;

use houdunwang\arr\Arr;
use houdunwang\config\Config;

/**
 * 缓存服务基础类
 * Class Base
 * @package hdphp\cache
 * @author 向军 <2300071698@qq.com>
 */
trait Base {
	//配置
	protected $config;

	//设置配置项
	public function config( $name ) {
		if ( is_array( $name ) ) {
			$this->config = $name;

			return $this;
		} else {
			return Arr::get( $this->config, $name );
		}

		return $this;
	}
}