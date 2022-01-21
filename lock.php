<?php
require 'ClassLock.php';

$Lock = new ClassLock('KhasdjGdbfjdm', 'admin', 'admin', 20);

if (!$Lock->logged()) {
    require 'login.php';
    die();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
        <head>
            <meta charset="UTF-8" >
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Acesso Restrito</title>
        </head>
        <body>
            <div style="border: 1px solid white;position: fixed;top: 0; left: 0; height: 25px; width: 100%;z-index: 500000;display: flex;background-color: black; color: white;align-content: center;">
                <div style="line-height:25px;width: 100%;margin: 0!important; text-align: center;font-size: 11px!important;"># # ACESSO PROTEGIDO POR SENHA # #</div>
                <form method="POST" action="" style="">
                    <input style="text-transform: uppercase;cursor: pointer ;margin: 0!important;padding:2px 15px!important;line-height: 15px;background-color: gold;color: #002a80;color: black;" type="submit" name="form_page_protected" value="sair">
                </form>
            </div>
            <div style="margin-top: 25px;"></div>
            <?php

            function require_content() {
                $link_url = trim(strip_tags(filter_input(INPUT_GET, 'r', FILTER_SANITIZE_URL)));
                $url = explode('/', $link_url);
                $url[0] = (!empty($url[0]) ? $url[0] : 'index');
                $file = $url[0];
                $link = (isset($url[1]) ? $url[1] : null);
                if (file_exists(__DIR__ . '/page/' . $file . '.php')) {
                    require __DIR__ . '/page/' . $file . '.php';
                } elseif (file_exists('page/' . $file . '/' . $link . '.php')) {
                    require 'page/' . $file . '/' . $link . '.php';
                } else {
                    require 'page/' . '404.php';
                }
            }

            require_content();
            ?>
        </body>
    </html>
    <?php
}
