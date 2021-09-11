<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-03</title>
</head>
<body>
    <form action = "" method = "post">
        <input type ="text" name = "str">
        <input type ="submit" name = "submit">
    </form>
    
    <?php
      if ($_POST["str"]==""){
          echo "";
      }else{
          $str = $_POST["str"];
          $filename ="mission_2-03.txt";
          $fp = fopen($filename,"a");
          fwrite($fp, $str.PHP_EOL);
          fclose ($fp);
          echo $str."<br>";
      }
      
     ?>
</body>
</html>