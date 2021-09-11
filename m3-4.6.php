<?php
    $filename="mission_3-4.6.txt";
    $value1="";
    $value2="";
    //編集フォーム
        if(!empty($_POST["submit3"])){//編集ボタンが押された時
            if(!empty($_POST["edit"])){//番号が入っていたとき
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);//テキストファイルを読み込む
                    foreach($lines as $line){//ループ処理
                        $text=explode("<>",$line);
                        $edit=$_POST["edit"];
                        if($text[0]==$edit){//番号が同じだったとき
                           $value1=$text[1];//その投稿の名前とコメントを取得
                           $value2=$text[2];
                        }
                    }
                }
            }else{//番号がなかったとき
               //編集したい番号が入力されていません
               $value1="";
               $value2="";
               $edit="";
            }
        }else{//編集ボタンが押されなかった時
            $value1="";
            $value2="";
            $edit="";
        }
        
    ?>
        
    
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-04</title>
</head>
<body>
    

    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"  
            value="<?php echo $value1;?>"><br>
        <input type="text" name="comment" placeholder="コメント"
            value="<?php echo $value2;?>">
        <input type="submit" name="submit" value="送信"><br>
        <input type="hidden" name="number" value="<?php echo $edit;?>"><br><br>
    </form>
    
    <form action="" method="post">
        <input type="number" name="delete" placeholder="削除対象番号">
        <input type="submit" name="submit2" value="削除"><br><br>
    </form>
    
    <form action="" method="post">
        <input type="number" name="edit" placeholder="編集対象番号">
        <input type="submit" name="submit3" value="編集"><br><br>
    </form>
    
    <?php
       

    
      $filename="mission_3-4.6.txt";
     //投稿フォーム 
        if(!empty($_POST["submit"])){//送信が押されたとき
            if(!empty($_POST["number"])){//編集したい番号が入っているとき
                if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントに入力あり
                    if(file_exists($filename)){
                        $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        $fp=fopen($filename,"w");
                        ftruncate($fp,0);
                        fclose($fp);
                        //上書き開始、対象行のみ変更
                        foreach($lines as $line){
                            $text=explode("<>",$line);
                            $number=$_POST["number"];
                            $fp=fopen($filename,"a");
                            if($text[0]<$number){
                                fwrite($fp,$line.PHP_EOL);
                            }elseif($text[0]==$number){//番号が同じだったとき
                                $name=$_POST["name"];
                                $comment=$_POST["comment"];
                                $date=date("Y年m月d日 H:i:s");
                                $str=$number."<>".$name."<>".$comment."<>".$date;
                                fwrite($fp,$str.PHP_EOL);
                            }elseif($text[0]>$number){
                                fwrite($fp,$line.PHP_EOL);
                                    fclose($fp);
                            }
                        }//ループ終了
                        if(file_exists($filename)){//ブラウザに表示
                            $lines=file($filename,FILE_IGNORE_NEW_LINES);
                            foreach($lines as $line){//配列のループ開始
                                $text=explode("<>",$line);//分割して値を取得
                                echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                            }
                        }
                    }
                }else{//名前とコメントが空
                    echo "この番号は存在しません<br>";
                    if(file_exists($filename)){//ブラウザに表示
                        $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){//配列のループ開始
                             $text=explode("<>",$line);//分割して値を取得
                             echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                        }
                    }
                }
            }else{//編集したい番号が入ってないとき
                if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントを入力あり
                      //テキストファイルへの書き込み
                    $fp=fopen($filename,"a");
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $date=date("Y年m月d日 H:i:s");
                    $num=count(file($filename))+1;
                    $str=$num."<>".$name."<>".$comment."<>".$date;
                    fwrite($fp,$str.PHP_EOL);
                    fclose($fp);
                    if(file_exists($filename)){//ブラウザに表示
                        $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){//配列のループ開始
                            $text=explode("<>",$line);//分割して値を取得
                            echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                        }
                    }
                }else{//入力なし
                    echo "新しい入力がありません。<br>";
                    if(file_exists($filename)){//ブラウザに表示
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){//配列のループ開始
                            $text=explode("<>",$line);//分割して値を取得
                            echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                        }
                    }
                }  
            }
        }else{//送信が押されなかったとき
          echo "";
        }
        
        //削除機能
        if(!empty($_POST["submit2"])){//ボタンが押された
            if(!empty($_POST["delete"])){//番号があった
                $lines=file($filename,FILE_IGNORE_NEW_LINES);//ファイルの読み込み
                $fp=fopen($filename,"w");//書き込み準備
                ftruncate($fp,0);//中身を空にする
                fclose($fp);
                foreach($lines as $line){//ループ開始
                    $text=explode("<>",$line);
                    $delete=$_POST["delete"];
                    if($text[0]!=$delete){//番号が一致しない行
                        $fp=fopen($filename,"a");//書き込み準備
                        fwrite($fp,$line.PHP_EOL);
                        fclose($fp);//ファイルを閉じる
                    }
                }//ループ終了
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $text=explode("<>",$line);
                        echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                    }
                }
            }else{//番号なし
                echo "削除したい番号が入力されていません<br>";
                if(file_exists($filename)){//削除されないですべて表示
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $text=explode("<>",$line);
                        echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                    }
                }
            }
        }else{//ボタンが押されなかった
           echo ""; 
        }
        
        //編集フォーム
        if(!empty($_POST["submit3"])){//編集ボタンが押された時
            if(!empty($_POST["edit"])){//番号が入っていたとき
                if(file_exists($filename)){
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);//テキストファイルを読み込む
                    foreach($lines as $line){//ループ処理
                        $text=explode("<>",$line);
                        echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                        $edit=$_POST["edit"];
                        if($text[0]==$edit){//番号が同じだったとき
                           
                        }
                    }
                }
            }else{//番号がなかったとき
               echo "編集したい番号が入力されていません<br>";
               if(file_exists($filename)){//削除されないですべて表示
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){
                        $text=explode("<>",$line);
                        echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                    }
                }
            }
        }else{//編集ボタンが押されなかった時
            $value1="";
            $value2="";
            $edit="";
        }
        
        
        
    ?>
</body>
</html>