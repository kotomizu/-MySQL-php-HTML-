<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-01</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str" value="コメント"><br>
        <input type="submit" name="submit" value="送信">
    </form>
    <?php
            $str = $_POST["str"];
            if ($str ==""){
                echo "<br>";
            }else{
               echo $str . "を受け付けました<br>";  
            }
            
    ?>
    

</body>
</html>