<?php
require 'vendor/autoload.php';
$config = [
	/**
	 * 系统支持多种缓存驱动
	 * 修改驱动为:file memcache redis mysql即可更改缓存机制
	 * memcache、redis需要自行安装服务器软件
	 * mysql缓存需要创建数据表
	 */
	'driver'   => 'file',
	/**
	 * 文件缓存
	 */
	'file'     => [
		'dir' => 'storage/cache'
	],
	/**
	 * memcache缓存
	 * 多个服务器设置二维数组
	 */
	'memcache' => [
		'host' => '127.0.0.1',
		'port' => 11211,
	],
	/**
	 * redis缓存
	 * 多个服务器设置二维数组
	 */
	'redis'    => [
		'host'     => '127.0.0.1',
		'port'     => 6379,
		'password' => '',
		'database' => 0,
	],
	/**
	 * mysql缓存
	 * 可以使用命令创建缓存表
	 * php hd table:cache
	 */
	'mysql'    => [
		//主机
		'host'     => 'localhost',
		//类型
		'driver'   => 'mysql',
		//帐号
		'user'     => 'root',
		//密码
		'password' => 'admin888',
		//数据库
		'database' => 'demo',
		//缓存表
		'table'    => 'core_cache'
	]
];
c( 'cache', $config );
$obj = new \houdunwang\cache\Cache();
$obj->set( 'name', '后盾人' );
print_r($obj->get('name'));