<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5</title>
    </head>
    <body>
    <?php
        
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $pass=$_POST["pass"];
        $delete=$_POST["deletenum"];
        $edit=$_POST["editnum"];
        $num=$_POST["num"];
        $delpass=$_POST["delpass"];
        $edipass=$_POST["edipass"];
        
        //DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //mission4-2 テーブル設置
        $sql = "CREATE TABLE IF NOT EXISTS tbboard"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32),"
	    . "comment TEXT,"
	    . "date DATETIME,"
	    . "pass TEXT"
	    .");";
	    $stmt = $pdo->query($sql);
	    
	    
	     if(!empty($name) && !empty($comment) && !empty($pass) && empty($num)){
	         
	         $sql = $pdo -> prepare("INSERT INTO tbboard (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
	         $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	         $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	         $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	         $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
           	 $name = $_POST["name"];
	         $comment =$_POST["comment"];//好きな名前、好きな言葉は自分で決めること
	         $date=date("Y年m月d日 H:i:s");
	         $pass=$_POST["pass"];
	         $sql -> execute();

         }
         
          if(!empty($name) && !empty($comment) && !empty($pass) &&!empty($num)){
              
         $id=$num;
         $name= $_POST["name"];
         $comment=$_POST["comment"];
         $pass=$_POST["pass"];
         $date=date("Y年m月d日 H:i:s");
         
         $sql="UPDATE tbboard SET name=:name, comment=:comment, date=:date, pass=:pass WHERE id=:id";
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(":name", $name, PDO::PARAM_STR);
         $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
         $stmt->bindParam(":date", $date, PDO::PARAM_STR);
         $stmt->bindParam("pass", $pass, PDO::PARAM_STR);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();
         
          }
          

         if(!empty($delete) && !empty($delpass)){
             
             $sql ="SELECT * FROM tbboard";
             $stmt = $pdo->query($sql);
             $results = $stmt->fetchAll();
             foreach($results as $row){
                 $deleteid = $row["id"];
                 $deletepassword = $row["pass"];
             }
         if($deleteid == $delete && $deletepassword == $delpass){
             
         $id = $deleteid;
         $sql="delete from tbboard where id=:id";
         $stmt= $pdo->prepare($sql);
         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
         $stmt->execute();
         }
         
         }
         
         
         $edit=$_POST["editnum"];
         $edipass=$_POST["edipass"];

         if(!empty($edit)){
             $id=$edit;
             
             $sql = "SELECT * FROM tbboard WHERE id=:id";
             $stmt=$pdo->prepare($sql);
             $stmt->bindParam(":id", $id, PDO::PARAM_INT);
             $stmt->execute();
             $results= $stmt->fetchAll();
             
             foreach($results as $row){
                 $editid=$row["id"];
                 $editpassword=$row["pass"];
             }
             
             if($editid == $edit && $editpassword == $edipass){
                 
                 $sql = "SELECT * FROM tbboard";
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach($results as $row){
                     $editname= $row["name"];
                     $editcomment = $row["comment"];
                     $editpass = $row["pass"];
                 }
             }

         }
         
         
         #4-6
         $sql="SELECT * FROM tbboard";
         $stmt= $pdo->query($sql);
         $results = $stmt->fetchAll();
         var_dump($results);
         foreach($results as $row){
             
             echo $row["id"].",";
             echo $row["name"].",";
             echo $row["comment"].",";
             echo $row["date"].",";
             echo $row["pass"]."<br>";
             echo "<hr>";
         }
	    
	  
    
        ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5</title>
    </head>
    <body>
         <!---新規投稿フォーム--->
              <form action=""method="post">
            <input type="text" name="name" placeholder="名前" 
            value="<?php if(!empty($_POST["editnum"])){if($editid == $edit && $editpassword == $edipass){ echo $editname;}}?>"><br>
            <input type="text" name="comment" placeholder="コメント"
            value="<?php if(!empty($_POST["editnum"])){if($editid == $edit && $editpassword == $edipass){echo $editcomment;}}?>"><br>
            <input type="text" name="pass" placeholder="パスワード" 
            value="<?php if(!empty($_POST["editnum"])){if($editid == $edit && $editpassword == $edipass){echo $editpass;}}?>"><br>
            <input type="hidden" name="num" value="<?php if(!empty($_POST["editnum"])){echo $edit;}?>">
            <input type="submit" >
        </form>
        <br>
        <!---削除フォーム--->
        <form action=""method="post">
            <input type="text" name="deletenum" placeholder="削除対象番号"><br>
            <input type="text" name="delpass" placeholder="パスワード">
            <input type="submit" value="削除">
        </form>
        <br>
        <!---編集フォーム--->
        <form action=""method="post">
            <input type="text" name="editnum" placeholder="編集対象番号"><br>
            <input type="text" name="edipass" placeholder="パスワード">
            <input type="submit" value="編集">
        </form>
    </body>
</html>