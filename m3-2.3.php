<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-02</title>
</head>
<body>
     <form action="" method="post">
        名前：<input type ="taxt" name = "name" ><br>
        コメント：<input type ="taxt" name ="comme"><br>
         <input type ="submit" name = "submit" value = "送信">
    </form>
    
    <?php
        $name=$_POST["name"];
        $comme=$_POST["comme"];
        $date=date("Y/m/d H:i:s");
        $filename="mission_3-02.3.txt";
        
        if(file_exists($filename)){
            $num=count(file($filename))+1;
        }else{
            $num=1;
        }
        
        $str=$num."<>".$name."<>".$comme."<>".$date;
        
        if($name=="" && $comme==""){
            echo "名前とコメントを入力してください。<br>";
        }elseif($name==""){
            echo "名前とコメントを入力してください。";
        }elseif($comme==""){
            echo "名前とコメントを入力してください。";
        }else{
            $fp = fopen($filename,"a");
            fwrite($fp,$str.PHP_EOL);
            fclose($fp);
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
               foreach($lines as $line){
                   echo $line."<br>";
               }
            }
        }
        
    ?>
    
</body>
</html>