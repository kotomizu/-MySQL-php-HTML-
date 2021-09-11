<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-04</title>
</head>
<body>
    
    <?php
    
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql='SHOW CREATE TABLE tbtest';
    $result=$pdo->query($sql);
    foreach($result as $row){
        echo $row[1];
    }
    echo "<hr>;"
    ?>
    
</body>
</html>
