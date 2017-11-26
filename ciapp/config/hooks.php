<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
// post_controller_constructor
// pre_controller
$hook['post_controller_constructor'] = [
	'class'    => 'LoginChecker',//呼ぶクラス
	'function' => 'check',//呼ぶメソッド
	'filename' => 'LoginChecker.php',//呼ぶクラスファイル名
	'filepath' => 'hooks',//クラスファイルのあるディレクトリ
	// 'params'   => array('beer', 'wine', 'snacks')
];
