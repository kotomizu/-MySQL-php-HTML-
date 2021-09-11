<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-03.5</title>
</head>
<body>
    <form action = "" method = "post">
        <input type="text" name="name" placeholder="名前"><br>
        <input type="text" name="comment" placeholder="コメント">
        <input type="submit" name="submit" value="送信"><br><br>
        <input type="number" name="number" placeholder="削除対象番号">
        <input type="submit" name="submit" placeholder="削除">
    </form>
    
    <?php
        $name=($_POST["name"]);
        $comment=($_POST["comment"]);
        $number=($_POST["number"]);
        $date=date("Y年m月d日 H時i分s秒");
        $filename="mission_3-3.7.txt";
       
        //投稿番号に必要な数字を取得
        //テキストファイルの中身を行ごとに配列に返す
        //配列の数を数える
        //一つ目は中身がなく配列がない、そのため＋１をする
        if(file_exists($filename)){
            $num=count(file($filename))+1;
        }else{
            $num=1;
        }
        
        $str=$num."<>".$name."<>".$comment."<>".$date;
        
        if(empty($number)){//数が表示されていなかったら
            if(empty($name)&&empty($comment)){//名前とコメントが空欄の時
                if(file_exists($filename)){//ファイルが存在している
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){//配列ごとのループ開始
                        $text=explode("<>",$line);
                        for($m=0;$m<4;$m++){
                            echo $text[$m];
                            if($m==3){
                                echo "<br>";
                            }
                        }
                    }
                }
            }else{//名前とコメントに記入があるとき
               $fp=fopen($filename,"a");
                fwrite($fp, $str.PHP_EOL);  
                fclose($fp);
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $text=explode("<>",$line);
                        for($m=0;$m<4;$m++){
                            echo $text[$m];
                            if($m==3){
                                echo "<br>";
                            }
                        }
                    }
                }
            }
            
        }else{//数を受信したとき
            if(file_exists($filename)){
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $fp=fopen($filename,"r+");
                ftruncate($fp,0);
                fclose($fp);
                foreach($lines as $line){
                    $text=explode("<>",$line);
                    if($text[0]!=$number){
                        $fp=fopen($filename,"a");
                        fwrite($fp,$line.PHP_EOL);
                        fclose($fp);
                        for($m=0;$m<4;$m++){
                            echo $text[$m];
                            if($m==3){
                                echo "<br>";
                            }
                        }
                    }
                }
            }
            
            
        }
    ?>
    
</body>
</html>