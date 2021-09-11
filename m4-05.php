<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-05</title>
</head>
<body>
    
    <?php
    
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql=$pdo->prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
    $sql->bindParam(':name', $name, PDO::PARAM_STR);
    $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
    $name='(ミズノ)';
    $comment='(ことり)';
    $sql->execute();
    
    ?>
    
</body>
</html>
