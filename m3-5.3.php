<?php
    $filename="mission_3-5.3.txt";
    $value1="";
    $value2="";
    //編集フォーム

    if(!empty($_POST["submit3"])){//編集ボタンが押されたとき
        if(!empty($_POST["edit"])){//編集したい番号が入力
            if(!empty($_POST["editpass"])){//編集パスワードが入力されている
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $edit=$_POST["edit"];
                foreach($lines as $line){//番号取得のループ開始
                    $text=explode("<>",$line);
                    if($text[0]==$edit){//編集したい番号とおなじとき
                        $editpass=$_POST["editpass"];
                        if($editpass==$text[4]){//パスワード正解
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
                        }else{//パスワード間違い
                            $value1="";
                            $value2="";
                            $edit="";
                        }
                    }
                }
            }else{//パスワードが入力されてない
                $value1="";
                $value2="";
                $edit="";
            }
        }else{//番号が入力されていない
            $value1="";
            $value2="";
            $edit="";
        }
    }else{//編集ボタンが押されなかったとき
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
    
【投稿フォーム】<br>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"  
            value="<?php echo $value1;?>"><br>
        <input type="text" name="comment" placeholder="コメント"
            value="<?php echo $value2;?>"><br>
        <input type="passward" name="namepass" placeholder="パスワード">
        <input type="submit" name="submit" value="送信"><br>
        <input type="hidden" name="number" value="<?php echo $edit;?>"><br>
    </form>
【削除フォーム】
   <form action="" method="post">
        <input type="number" name="delete" placeholder="削除対象番号"><br>
        <input type="passward" name="deletepass" placeholder="パスワード">
        <input type="submit" name="submit2" value="削除"><br><br>
    </form>
【編集フォーム】   
    <form action="" method="post">
        <input type="number" name="edit" placeholder="編集対象番号"><br>
        <input type="passward" name="editpass" placeholder="パスワード">
        <input type="submit" name="submit3" value="編集"><br><br>
    </form>
    
    <?php
       

    
      $filename="mission_3-5.3.txt";
     //投稿フォーム 
    if(!empty($_POST["submit"])){//送信ボタンが押されたとき
        if(!empty($_POST["number"])){//編集したい番号を受信
            if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントが入力されている
                if(!empty($_POST["namepass"])){//パスワードが入力されている
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    $number=$_POST["number"];
                    foreach($lines as $line){//番号取得のループ開始
                        $text=explode("<>",$line);
                        if($text[0]==$number){//番号が同じとき
                            $namepass=$_POST["namepass"];
                            if($namepass==$text[4]){//パスワード正解
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
                                        }elseif($text[0]==$number){
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
                            }else{//パスワード違う
                                echo "パスワードが間違っています。<br>";
                            }
                        }
                    }
                }else{//パスワードが入力されていない
                    echo "パスワードが入力されていません。<br>";
                }
            }else{//名前とコメントが入力されていない
                echo "この番号は存在しません<br>";
                if(file_exists($filename)){//ブラウザに表示
                    $lines=file($filename,FILE_IGNORE_NEW_LINES);
                    foreach($lines as $line){//配列のループ開始
                        $text=explode("<>",$line);//分割して値を取得
                        echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                    }
                }
            }
        }else{//編集番号受信してない（通常の投稿）
            if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントが入力されている。
                if(!empty($_POST["namepass"])){//新規投稿パスワード入力
                    $fp=fopen($filename,"a");
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $date=date("Y年m月d日 H:i:s");
                    $namepass=$_POST["namepass"];
                    $num=count(file($filename))+1;
                    $str=$num."<>".$name."<>".$comment."<>".$date."<>".$namepass;
                    fwrite($fp,$str.PHP_EOL);
                    fclose($fp);
                    if(file_exists($filename)){//ブラウザに表示
                        $lines=file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){//配列のループ開始
                            $text=explode("<>",$line);//分割して値を取得
                            echo $text[0]."  ".$text[1]."  ".$text[2]."  ".$text[3]."<br>";
                        }
                    }
                }else{//新規投稿パスワードなし
                    echo "新規の投稿にパスワードを入力して下さい。<br>";
                }
            }else{//名前とコメントが空欄
                echo "名前とコメントが入力されていません。<br>";
            }
        }
    }else{//送信ボタンが押されていないとき
        echo "";
    }
    
        
        //削除機能
    if(!empty($_POST["submit2"])){//削除ボタンが押されたとき
        if(!empty($_POST["delete"])){//番号が入力されているとき 
            if(!empty($_POST["deletepass"])){//パスワードが入力されている
                $lines=file($filename,FILE_IGNORE_NEW_LINES);//ファイルの読み込み
                $delete=$_POST["delete"];
                foreach($lines as $line){//ループ開始
                    $text=explode("<>",$line);//要素番号取得
                    if($text[0]==$delete){//削除したい番号がおなじとき
                        $deletepass=$_POST["deletepass"];
                        if($deletepass==$text[4]){//パスワードが正しい
                            $lines=file($filename,FILE_IGNORE_NEW_LINES);//ファイルの読み込み
                            $fp=fopen($filename,"w");//書き込み準備
                            ftruncate($fp,0);//中身を空にする
                            fclose($fp);
                            foreach($lines as $line){//ループ開始
                                $text=explode("<>",$line);
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
                        }else{//パスワードが間違っている
                            echo "パスワードが間違っています。<br>";    
                        }
                    }
                }
            }else{//パスワードが入力されていない
                echo "パスワードが入力されていません。<br>";
            }
        }else{//削除したい番号がないとき
            echo "削除番号が入力されていません。<br>";
        }
    }else{//削除番号が押されてない
        echo "";
    }
       
       
    
        //編集フォーム
    if(!empty($_POST["submit3"])){//編集ボタンが押されたとき
        if(!empty($_POST["edit"])){//編集したい番号が入力
            if(!empty($_POST["editpass"])){//編集パスワードが入力されている
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                $edit=$_POST["edit"];
                foreach($lines as $line){//番号取得のループ開始
                    $text=explode("<>",$line);
                    if($text[0]==$edit){//編集したい番号とおなじとき
                        $editpass=$_POST["editpass"];
                        if($editpass==$text[4]){//パスワード正解
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
                        }else{//パスワード間違い
                            echo "パスワードが間違っています。<br>";
                        }
                    }
                }
            }else{//パスワードが入力されてない
                echo "パスワードが入力されていません。<br>";
            }
        }else{//番号が入力されていない
            echo "編集したい番号を入力して下さい。<br>";
        }
    }else{//編集ボタンが押されなかったとき
        echo "";
        $value1="";
        $value2="";
        $edit="";
    }   
        
        
    ?>
</body>
</html>