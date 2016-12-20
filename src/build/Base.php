<?php namespace houdunwang\cache\build;
/**
 * 缓存服务基础类
 * Class Base
 * @package hdphp\cache
 * @author 向军 <2300071698@qq.com>
 */
trait Base {
	protected $cache = [ ];

	public function __construct() {
		$this->connect();
	}
}