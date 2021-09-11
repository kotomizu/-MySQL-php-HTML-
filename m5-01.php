<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
  <?php
    //テーブルを接続する
    $dsn = 'mysql:dbname=tb230355db;host=localhost';
    $user = 'tb-230355';
    $password = 'tm7aLnFPNX';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //テーブルを作成する
    $sql="CREATE TABLE IF NOT EXISTS tbtest"
     ." ("
     ."id INT AUTO_INCREMENT PRIMARY KEY,"
     ."name char(32),"
     ."comment TEXT,"
     ."date DATETIME,"
     ."password INT"
     .");";
     $stmt=$pdo->query($sql);
     $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";
    }
     

    ?>
    【投稿フォーム】
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"
               value=""><br>
        <input type="text" name="comment" placeholder="コメント"
               value=""><br>
        <input type="passward" name="namepass" placeholder="パスワード">
        <input type="submit" name="submit" value="送信"><br>       
        <input type="number" name="number" value="">       
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
        <input type="submit" namr="submit3" value="編集"><br>
    </form>
    
    <?php
    
        //投稿フォーム
        if(!empty($_POST["submit"])){//送信ボタン押された
            if(!empty($_POST["number"])){//編集番号あり
                
            }else{//編集番号なし(通常の投稿)
                if(!empty($_POST["name"])&&!empty($_POST["comment"])){//名前とコメントが入力あり
                    if(!empty($_POSY["namepass"])){//パスワードあり
                        $name=$_POST["name"];
                        $comment=$_POST["comment"];
                        $namepass=$_POSR["namepass"];
                        //データ入力、データレコードの挿入
                        $sql=$pdo->prepare("INSERT INTO tbtest (name, comment, date, passward) 
                        　　VALUES (:name, :comment, :date, :passward,)");
                        $sql->bindParam(':name', $name, PDO::PARAM_STR);
                        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql->bindParam(':date', $date, PDO::PARAM_STR);
                        $sql->bindParam(':passward', $passward, PDO::PARAM_STR);
                        $name='($name)';
                        $comment='($commant)';
                        $date='()';
                        $passward='($namepass)';
                        $sql->execute();
                    }else{//パスワードなし
                        echo "新規の投稿にパスワードが入力されていません。<br>";
                    }
                }else{//名前とコメント空欄
                    echo "名前とコメントが入力されていません。<br>";
                }
            }
        }else{//送信ボタン押されてない
            echo "";
        }
    ?>    
        
      
</body>
</html>