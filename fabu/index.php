<?php
header("Content-type: text/html; charset=utf-8");
require 'common.php';
require 'create.php';
if ($_POST) {
	$pwd = $_POST['pwd'];
	$data = [];
	// $data['picture'] = getPictureUrl($_FILES, 'picture');
	$data['title'] = $_POST['title'];
	$data['desc'] = $_POST['desc'];
	$data['content'] = $_POST['editorValue'];

	$data['type']  = $_POST['type'];


	// $data['picture'] = '../../images/ma05.jpg';
	// $data['title'] = '行业新闻 分析中国服装企业信息化管理现状';
	// $data['desc'] = '近年来,服装业的信息化管理发展迅速，国内一些服装企业已经采纳了服装软件信息化这种新型的管理模式，然而信息化管理的利与弊在应用过程中是并存的。';
	// $data['content'] = '<p style="text-align: center;"><span style="font-family: &quot;Microsoft YaHei&quot;; font-size: medium;">分享转发 获取领取一张优惠券信息分享转发 获取领取一张优惠券信息</span></p>';

	// $data['type'] = '行业新闻';
	

	$dirname = $data['type'] == '公司动态'? '8': '88';
	
	if($pwd != "misall") {
		echo '<script>alert("新闻秘钥有误，无法发布新闻")</script>';
		include "index.html";
		return;
	}
	// 生成详情页
	echo '开始生成'.$data['type']."<br>";
	$file_name = createNewsDetailPage($data, $dirname);//新生成的页面名字
	if($file_name){
		// 修改首页
		editIndexPage($data, $dirname, $file_name);
	}
	echo '生成'.$data['type']."完成<br><br>";

    echo '<a href="index.php">继续发布</a><br>';

}else{
	include "index.html";
}
?>



