<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-01</title>
</head>
<body>
    <form action="" method="post">
        名前：<input type ="taxt" name = "name" ><br>
        コメント：<input type ="taxt" name ="comme"><br>
         <input type ="submit" name = "submit" value = "送信">
    </form>
        
    <?php
       $name = $_POST["name"];
       $comme = $_POST["comme"];
       $datetime = date("Y/m/d H:i:s");
       $filename = "mission_3-01.txt";
       
       if ($name ==""  && $comme ==""){
           echo "";
       }elseif($name ==""){
           echo "";
       }elseif($comme ==""){
           echo "";
       }else{   
           if(file_exists($filename)){
           $i = count(file($filename))+1;
       }else{
           $i =1;
       }
       
       if(!mb_strlen($name) && !mb_strlen($comme)){
           echo "文字を入力して下さい。<br>";
       }else{
           $fp = fopen($filename,"a");
           fwrite($fp, $i."<>".$name."<>".$comme."<>".$datetime.PHP_EOL);
           fclose($fp);
        }

    }
      

    ?>
</body>
</html>