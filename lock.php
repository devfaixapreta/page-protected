<?php
require 'ClassLock.php';

$Lock = new ClassLock('KhasdjGdbfjdm', 'admin', 'admin', 20);
if (isset($_POST['form_page_protected'])) {
    $args_filter = ['form_page_protected' => FILTER_SANITIZE_STRING, 'username' => FILTER_SANITIZE_STRING, 'userpassword' => FILTER_SANITIZE_STRING];
    $lock_form = filter_input_array(INPUT_POST, $args_filter);

    if ($lock_form['form_page_protected'] === 'sair') {
        $Lock->logout();
    } else {
        if($Lock->login($lock_form['username'], $lock_form['userpassword'])){
            header('Refresh:0');
            die;
        }
    }
}

if (!$Lock->logged()) {
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
            <div style="position:absolute;width: 330px;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                <form style="display: flex; flex-direction: column;" method="POST" action="">
                    <p style="text-align: center;font-size: 1.5rem; letter-spacing: .01rem; line-height: 1.6rem;">Acesso restrito!!</p>

                    <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .3rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="text" name="username" placeholder="Usuário">
                    <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .3rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="password" name="userpassword" placeholder="Senha">
                    <input style="background-color: #0f66b1!important;padding: 7px 11px!important;font-size: 15px; border-radius: 1px; color: inherit; border: none;cursor: pointer;color: #fff;box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12); margin-top: 16px; margin-bottom: 20px!important;font-weight: 700;" name="form_page_protected" type="submit" value="entrar">
                    <span style="text-align: center"><?= $Lock->get_error(); ?></span>
                </form>
            </div>
        </body>
    </html>
    <?php
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

        </body>
    </html>
    <?php
}
