
<?php

$db = new Database();
$pdo =$db->getConnect();
$email ='';
$pass ='';
$emailErrors ='';
$passErrors = '';


if ($_SERVER["REQUEST_METHOD"] =="POST")
{
    $email = strip_tags(trim( $_POST['email']));
    $pass = strip_tags(trim( $_POST['pass']));


    if(empty($email)){
        $emailErrors ="Nhập email";
    }
    if(empty($pass)){
        $passErrors ="Nhập password";
    }
    // $query = $pdo->prepare("SELECT * FROM user WHERE email=? AND password_hash=?");
    // $query->execute(array($email,$pass));
    // $control = $query->fetch(PDO::FETCH_OBJ);
    // if ($control>0){
    //     $_SESSION["email"]=$email;
    //     header("Location:index1.php");
    //     echo "<h1>incorrect </h1>";
    // }
    // else echo "nottt ";

    // }
    
    $isuser =Auth::checkuser($pdo,$email,$pass);
    $_SESSION['user'] = $isuser;
    //echo var_dump($isuser);
    header('location:/index.php');

}
?>

<br>
<h2 class="w-50 m-auto"> Login </h2>
<br>

<form method ="post" class="w-50 m-auto">
    <div class = "mb-3">
        <label for="email" class="form-lable">Email:</label>
        <input class="form-control" id="email" name="email" value="<?=$email?>" />
        <span class="text-danger fw-bold"><?= $emailErrors?></span>
    </div>
    <div  class = "mb-3"> 
        <label for="pass" class="form-lable">PassWord:</label>
        <input  type="password" class="form-control" id="pass" name="pass" value="<?=$pass?>"/>
        <span class="text-danger fw-bold"><?=$passErrors?></span>
    </div  class = "mb-3">
    <button type="submit" class="btn btn-primary">Login</button>
    
</form>


