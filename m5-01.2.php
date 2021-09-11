<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
  <?php
    //テーブルを接続する
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //テーブルを作成する
    $sql="CREATE TABLE IF NOT EXISTS tbm512"
     ." ("
     ."id INT AUTO_INCREMENT PRIMARY KEY,"
     ."name char(32),"
     ."comment TEXT,"
     ."date TEXT,"
     ."password TEXT"
     .");";
     $stmt=$pdo->query($sql);
    
    $value1="";
    $value2="";
    //編集フォーム

    if(!empty($_POST["submit3"])){//編集ボタンが押されたとき
        if(!empty($_POST["edit"])){//編集したい番号が入力
            if(!empty($_POST["editpass"])){//編集パスワードが入力されている
                $edit=$_POST["edit"];
                //データを抽出する
                $sql = 'SELECT * FROM tbm512';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($row['id']==$edit){//削除際たい番号が同じとき
                        $editpass=$_POST["editpass"];
                        if($editpass==$row['password']){//パスワード正解
                            $value1=$row['name'];//その投稿の名前とコメントを取得
                            $value2=$row['comment'];
                        }else{//パスワード間違い
                            echo "パスワードが間違っています。<br>";
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
       
     //投稿フォーム 
    if(!empty($_POST["submit"])){//送信ボタンが押されたとき
        if(!empty($_POST["number"])){//編集したい番号を受信
            if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントが入力されている
                if(!empty($_POST["namepass"])){//パスワードが入力されている
                    $number=$_POST["number"];
                    //データを抽出する
                    $sql = 'SELECT * FROM tbm512';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        if($row['id']==$number){//編集したい番号が同じとき
                            $namepass=$_POST["namepass"];
                            if($namepass==$row['password']){//パスワード正解
                                $id=$number;
                                $name=$_POST["name"];
                                $comment=$_POST["comment"];
                                $date=date("Y年m月d日 H:i:s");
                                $sql='UPDATE tbm512 SET name=:name,comment=:comment, date=:date WHERE id=:id';
                                $stmt=$pdo->prepare($sql);
                                $stmt->bindParam(':name',$name, PDO::PARAM_STR);
                                $stmt->bindParam(':comment',$comment, PDO::PARAM_STR);
                                $stmt->bindParam(':date',$date, PDO::PARAM_STR);
                                $stmt->bindParam(':id',$id, PDO::PARAM_INT);
                                $stmt->execute();
                                
                                //データを表示する
                                $sql = 'SELECT * FROM tbm512';
                                $stmt = $pdo->query($sql);
                                $results = $stmt->fetchAll();
                                foreach ($results as $row){
                                   //$rowの中にはテーブルのカラム名が入る
                                    echo $row['id'].',';
                                    echo $row['name'].',';
                                    echo $row['comment'].',';
                                    echo $row['date'].'<br>';
                                    echo "<hr>";
                                }
                            }else{//パスワード間違い
                                echo "";
                        }
                    }
                }               
                }else{//パスワードが入力されていない
                    echo "";
                }
            }else{//名前とコメントが入力されていない
                echo "";
                
            }
        }else{//編集番号受信してない（通常の投稿）
            if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントが入力されている。
                if(!empty($_POST["namepass"])){//新規投稿パスワード入力
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $date=date("Y年m月d日 H:i:s");
                    $namepass=$_POST["namepass"];
                    //データ入力
                    $sql=$pdo->prepare("INSERT INTO tbm512 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
                    $sql->bindParam(':name', $name, PDO::PARAM_STR);
                    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql->bindParam(':date', $date, PDO::PARAM_STR);
                    $sql->bindParam(':password', $namepass, PDO::PARAM_STR);
                    $sql->execute();
                    
                    //データを表示する
                    $sql = 'SELECT * FROM tbm512';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                    //$rowの中にはテーブルのカラム名が入る
                        echo $row['id'].',';
                        echo $row['name'].',';
                        echo $row['comment'].',';
                        echo $row['date'].'<br>';
                        echo "<hr>";
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
                $delete=$_POST["delete"];
                //データを抽出する
                $sql = 'SELECT * FROM tbm512';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($row['id']==$delete){//削除したい番号が同じとき
                        $deletepass=$_POST["deletepass"];
                        if($deletepass==$row['password']){//パスワード正解
                            $id=$delete;
                            //データレコードを削除する
                            $sql='delete from tbm512 where id=:id';
                            $stmt=$pdo->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            
                            //データを表示する
                            $sql = 'SELECT * FROM tbm512';
                            $stmt = $pdo->query($sql);
                            $results = $stmt->fetchAll();
                            foreach ($results as $row){
                                //$rowの中にはテーブルのカラム名が入る
                                echo $row['id'].',';
                                echo $row['name'].',';
                                echo $row['comment'].',';
                                echo $row['date'].'<br>';
                                echo "<hr>";
                            }
                        }else{//パスワード間違い
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
                $edit=$_POST["edit"];
                //データを抽出する
                $sql = 'SELECT * FROM tbm512';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($row['id']==$edit){//編集したい番号が同じとき
                        $editpass=$_POST["editpass"];
                        if($editpass==$row['password']){//パスワード正解
                            
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
            //データを表示する
            $sql = 'SELECT * FROM tbm512';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
                echo "<hr>";
            }
        }
    }else{//編集ボタンが押されなかったとき
        echo "";
        $value1="";
        $value2="";
        $edit="";
    }   
        
        
        
        
    ?>    
        
      
</body>