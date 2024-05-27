<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>评论区-明日之后IOS</title>
<style>
body
{
    background-color: #f1f1f1;
    font-family: Arial;
    font-size:14px;
}
.container
{
    width:80%;
    margin:50px auto;
    background-color: #fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0010px #ccc;
}
h1
{
    text-align: center;
    margin-bottom:30px;
}
form
{
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom:20px;
}
form input, form textarea
{
    padding:10px;
    margin-bottom:10px;
    border-radius:5px;
    border: 2px solid#ccc;
    box-shadow:005px #ccc;
    width:100%;
    max-width:400px;
    font-size:16px;
}

input:focus {
 border-color: #aaa;
 box-shadow:005px #aaa;
}

form button
{
    padding:10px 180px;
    background-color: #3A3A3A;
    color: #fff;
    border: none;
    border-radius:5px;
    font-size:16px;
    cursor: pointer;
}
.comment
{
    margin-bottom:20px;
    border-radius:5px;
    border:1px solid #ccc;
    padding:10px;
    box-shadow:005px #ccc;
}
.comment h3
{
    font-size:20px;
    margin-bottom:10px;
}
.comment p
{
    margin:0;
    font-size:16px;
    color: #414141;
}
hr
{
    margin:20px 0;
    border: none;
    border-top:1px solid #ccc;
}

.aabutton
{
    padding:10px 136px;
    background-color: #0081FF;
    color: #fff;
    border: none;
    border-radius:5px;
    font-size:16px;
    cursor: pointer;
}
a{
color:#FF0045
}
</style>
</head>
<body>
<div class="container">
<h1>评论区-明日之后IOS</h1>
<center>
<h3> <a href="/">联系站长</a> | 旗下网站:<a href="/">芬森博客</a></h3>
</center>
<h6></h6>
<form method="post" action="">
<input type="text" name="name" placeholder="请输入您的名称">
<textarea name="content" placeholder="请输入评论内容"></textarea>
<button type="submit" name="submit">发布</button>
</form>
<?php function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
if (isset($_POST['submit']))
{
    $name = $_POST['name'];
    $content = $_POST['content'];
    if (empty($name) || empty($content))
    {
        echo "<p style='color: red;'>请输入名称和评论内容！</p>";
    }
    else
    {
                $time = date("Y年m月d日 H:i:s");
        $ip = getRealIpAddr();
        $url = "https://api.vvhan.com/api/ipInfo?ip=".$ip;
        $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($ch);
          curl_close($ch);
            // 处理响应数据
            $result = json_decode($response, true); // 将JSON字符串解析为数组

        $comment = " \n<div class='comment'><h2>{$name}</h2><h4>{$content}</h4><p>IP地址: {$result['info']['country']} {$result['info']['prov']} {$result['info']['city']}</p><p>在 {$time} 发布</p></div> \n";
        $filename = "安全监督IP日志.txt";
         $goog = " \n 昵称:{$name} IP地址:{$ip} 说:{$content} \n";
         file_put_contents($filename, $goog, FILE_APPEND);
        $fp = fopen("审核/comments.txt", "a");
        fwrite($fp, $comment);
        fclose($fp);
        echo $comment;
    }
}
else
{
    $comments = file_get_contents("comments.txt");
    echo $comments;
}
?>

</div>
</body>
</html>