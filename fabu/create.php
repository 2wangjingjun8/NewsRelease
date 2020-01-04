
<?php

/**
 * 发布新闻 
    // echo htmlspecialchars($preg, ENT_QUOTES, 'UTF-8', true);
    // $arr = preg_match_all($preg, $content);
    // var_dump($arr);exit;
 */
// 生成新闻详情页
function createNewsDetailPage($data, $dirname='8'){
	$content = file_get_contents("./template/".$dirname."/default.html");
	$content = str_replace('{{title}}',$data['title'],$content);
    $content = str_replace('{{desc}}',$data['desc'],$content);
    $content = str_replace('{{type}}',$data['type'],$content);
    $content = str_replace('{{content}}',$data['content'],$content);
    
	$maxNum_path = "./template/".$dirname."/maxNum.txt";
	$maxNum = getMaxNum($maxNum_path);
    $file_name = $maxNum.'.html';
    //生成新闻详情页,路径在news/".$dirname."/
    $file_path = "../news/".$dirname."/".$file_name;
    $ok = file_put_contents($file_path,$content);
    // 写入成功，修改最大文件名序号 $maxNum_path
    if($ok){
        file_put_contents($maxNum_path,$maxNum);
        echo $data['type'].'详情页成功生成'.$file_name.'<br>';
        echo '<a target="_blank" href="../News/'.$dirname.'/'.$file_name.'">点击预览页面</a><br>';
        return $file_name;
    }else{
        return '';
    }
}

function editIndexPage($data, $dirname, $file_name){
    if($data['type'] == '公司动态'){
        $falg = 'companyNews';
    }else{
        $falg = 'industryNews';
    }
	$content = file_get_contents("../index.html");
	file_put_contents("./template/back/index.html", $content); // 备份首页html

	// 找到列表前面并新增一条
    $preContent = '
    <li class="item">
                    <a href="News/'.$dirname.'/'.$file_name.'"><span>'.date("Y-m-d").'</span>'.$data["title"].'</a>
                </li>';

	// 列表头部标志正则
    $preg = '#<ul class="list '.$falg.'".*?>([^"]+?)#s';

	$content = preg_replace($preg,'<ul class="list '.$falg.'" data-aos="fade-right" data-aos-anchor-placement="top-bottom">'.$preContent.'$1',$content);

    echo '首页新闻列表开头新增一条记录...<br>';

	// 找到并最后一条
    $preg = "/<li class=\"item\">.*?<a.*?href=\"News\/".$dirname."\/.*?\">.*?<span>.*?<\/span>.*?<\/a>.*?<\/li>/su";
    // echo htmlspecialchars($preg, ENT_QUOTES, 'UTF-8', true);
    // $arr = preg_match_all($preg, $content);
    // var_dump($arr);exit;

	preg_match_all($preg,$content,$array);
	// end() 将内部指针指向数组中的最后一个元素，并输出
    $content = str_replace(end($array[0]),'',$content);
    
    echo '首页新闻列表删除最后一条记录...<br>';
    
	// 输出生成新的html
	file_put_contents('../index.html', $content);
    echo '首页重新生成完成...';
}


function editNewsListPage($data, $dirname, $file_name){

    $l_num = $data['type'] == '公司动态'? '90': '89';
    
	$content = file_get_contents('../news/3/'.$l_num.'.html');
    file_put_contents('./template/back/'.$l_num.'.html', $content); // 备份列表页html

	// 找到列表前面并新增一条
	$preContent = '<li>
    <a href="../../News/'.$dirname.'/'.$file_name.'"><img src="'.$data['picture'].'" alt=""></a>
    <div class="newinfo">
        <h3><a href="../../News/'.$dirname.'/'.$file_name.'">'.$data['title'].'</a></h3>
        <p>'.$data['desc'].'</p>
    </div>
</li>';
	// 列表头部标志正则
    $preg = '#<ul class="minewlist">([^"]+?)#s';
	$content = preg_replace($preg,'<ul class="minewlist">'.$preContent.'$1',$content);

    echo '列表开头新增一条记录...<br>';


	file_put_contents('../news/3/'.$l_num.'.html', $content);
    echo '列表页重新生成完成...'."<br>";
}


function getMaxNum($maxNum_path){
	if(file_exists($maxNum_path)){
		$str = file_get_contents($maxNum_path);//将整个文件内容读入到一个字符串中
		return intval($str)+1;
	}else{
		return 1000;
	}
}