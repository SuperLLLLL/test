

<?php
	// 输入内容检查部分
	// 输入部分不能大于多少还没判断
	if (empty($_GET["music_name"])){
 		echo"<script>alert('输入参数不正确');history.go(-1);</script>";
 		exit();
	}
	if(empty($_GET["platform"])){
 		echo"<script>alert('checkbox参数不正确');history.go(-1);</script>";
 		exit();
	}
	$_GET['music_name'] = trim($_GET['music_name']);
	//转义
	$_GET = escape($link,$_GET);
	echo var_dump($_GET);
?>

<?php
	// 查找部分
	// 循环checkbox查找数据库内容
	$html = "";
	$backcolor = array("#eac7c7", "#eae0c7", "#c7eacb", "#c7caea", "#eac7e2");
	$back_color_count = 0;
	foreach( $_GET['platform'] as $num){
 		$query = "select * from search where platform = {$num} and music_name like '%{$_GET["music_name"]}%' limit 0,5";
 		$result = execute($link,$query);
 		if(mysqli_num_rows($result)){
 			while($data = mysqli_fetch_assoc($result)){
$html .= <<< A
			<tr style='background:{$backcolor[$back_color_count]}'>
			<td>{$MUSIC_NUM[$num]}</td>
			<td>{$data["music_name"]}</td>
			<td>{$data["singer"]}</td>
			<td>{$data["album_title"]}</td>
			<td><audio controls><source src = {$data["song_play_url"]} ></audio></td>
			</ tr>
A;
 			}
 		}else{
 			echo "数据库中不存在";
 			$_GET["music_name"] = $_GET["music_name"];
 			$output = get_music_info($num,$_GET["music_name"]);
			echo var_dump($output);
			// exit;
			foreach($output as $key => $value){
				$list_music_info = json_decode($value);
				// echo var_dump(unicode_decode($list_music_info));
				// echo $list_music_info[2];
				// echo "<br />";
$html .= <<< A
			<tr style='background:{$backcolor[$back_color_count]}'>
			<td>{$MUSIC_NUM[$num]}</td>
			<td>{$list_music_info[1]}</td>
			<td>{$list_music_info[2]}</td>
			<td>{$list_music_info[3]}</td>
			<td><audio controls><source src = {$list_music_info[5]} ></audio></td>
			</ tr>
A;
			}
 		}
 		$back_color_count += 1;
		if ($back_color_count >= count($backcolor)){
			$back_color_count = 0;
		}
 	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/search.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>搜索结果</title>
</head>
<body>
    <form action="/search" method="get" class="search">
        音乐名称(支持但不完全支持歌手搜索)： <input type="text" class="song_name" name="kw"> <button class="search-pro">查询</button>
    </form>
    <table>
        <thead>
            <tr>
<!--                <span class="asc">↑</span><span class="desc">↓</span>-->
                <th style="width:10%">平台</th>
                <th style="width:40%">音乐标题</th>
                <th style="width:20%">歌手</th>
                <th style="width:25%">专辑</th>
<!--                <th style="width:10%">时长</th>-->
                <th style="width:5%">在线试听/下载</th>
            </tr>
        </thead>
            <tbody>
                <?php
					echo $html;
                ?>
            </tbody>
        </table>
</body>
</html>