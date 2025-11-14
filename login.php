<?php
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = $_POST['email']; 
    $senha = $_POST['senha'];
    if($email == 'admin@tcc.com' && $senha == 'admin123'){
        $_SESSION['user'] = $email;
        header('Location: index.php'); 
        exit;
    } else {
        $erro = 'Credenciais inválidas';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login</title>
<style>

body.login {
    margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, Helvetica, sans-serif;
    background: #f6f9fc;
    position: relative; 
    overflow: hidden;
}


body.login .logo-background {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 2000px;         
    height: 2000px;
    transform: translate(-50%, -50%);
    background: url('/monitoramento_costeiro_grupo03_FINAL/assets/img/logo.png') no-repeat center center;
    background-size: contain; 
    opacity: 0.08;           
    z-index: 1;               
}


body.login form {
    position: relative;
    z-index: 2;               
    background: rgba(255,255,255,0.95);
    padding: 40px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}


body.login form input {
    display: block;
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

body.login form button {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    background-color: #0b4560;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}

body.login form button:hover {
    background-color: #0b67a3;
}

/
body.login p {
    color: red;
    margin-bottom: 15px;
    font-size: 14px;
}


@media (max-width: 600px) {
    body.login .logo-background {
        width: 600px;
        height: 600px;
    }
    body.login form {
        width: 90%;
        padding: 30px;
    }
}
</style>
</head>
<body class="login">

  
  <div class="logo-background"></div>

  
  <form method="post">
  <h2 style="color:#0b4560;">Login</h2>
      <?php if(isset($erro)) echo "<p>$erro</p>"; ?>
      <input type="email" name="email" placeholder="E-mail" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button>Entrar</button>
  </form>

</body>
</html>

