<?php namespace houdunwang\cache\build;
/**
 * 缓存服务基础类
 * Class Base
 * @package hdphp\cache
 * @author 向军 <2300071698@qq.com>
 */
trait Base {
	protected $cache = [ ];
	//外观类
	protected $facade;

	public function __construct( $facade ) {
		$this->facade = $facade;
		$this->connect();
	}
}