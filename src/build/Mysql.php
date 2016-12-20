<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\cache\build;

use houdunwang\db\Db;

/**
 * Mysql缓存
 * Class Mysql
 * @package hdphp\cache
 */
class Mysql implements InterfaceCache {
	use Base;
	//缓存目录
	protected $link;

	//连接
	public function connect() {
		//没有设置表配置
		if ( ! c( 'database' ) ) {
			$config = array_merge( [
				//读库列表
				'read'     => [ ],
				//写库列表
				'write'    => [ ],
				//表字段缓存目录
				'cacheDir' => 'storage/field',
				//开启读写分离
				'proxy'    => false,
				//开启调度模式
				'debug'    => true,
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
				//表前缀
				'prefix'   => ''
			], c( 'cache.mysql' ) );
			c( 'database', $config );
		}
		$this->link = ( new Db() )->table( c( 'cache.mysql.table' ) );
	}

	//设置
	public function set( $name, $content, $expire = 0 ) {
		$data = [ 'name' => $name, 'data' => serialize( $content ), 'create_at' => time(), 'expire' => $expire ];
		var_dump( $data );

		return $this->link->replace( $data ) ? true : false;
	}

	//获取
	public function get( $name ) {
		$data = $this->link->where( 'name', $name )->first();
		if ( $data['expire'] > 0 && $data['create_at'] + $data['expire'] < time() ) {
			//缓存过期
			$this->link->where( 'name', $name )->delete();
		} else {
			return unserialize( $data['data'] );
		}
	}

	//删除
	public function del( $name ) {
		return $this->link->where( 'name', $name )->delete();
	}

	//删除所有
	public function flush() {
		return Schema::truncate( c( 'cache.mysql.table' ) );
	}
}