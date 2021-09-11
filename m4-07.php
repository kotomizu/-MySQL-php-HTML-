<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-07</title>
</head>
<body>
    
    <?php
    
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $id=1;
    $name="(ぶどう)";
    $comment='(酸っぱい)';
    $sql='UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':name',$name, PDO::PARAM_STR);
    $stmt->bindParam(':comment',$comment, PDO::PARAM_STR);
    $stmt->bindParam(':id',$id, PDO::PARAM_INT);
    $stmt->execute();
    ?>
    
</body>
</html>
