<?php
require 'ClassLock.php';

$args_filter = ['sair_page_protected' => FILTER_SANITIZE_STRING, 'username' => FILTER_SANITIZE_STRING, 'userpassword' => FILTER_SANITIZE_STRING, 'csrf_token' => FILTER_SANITIZE_STRING];
$lock_form = filter_input_array(INPUT_POST, $args_filter);

$Lock = new ClassLock('KhasdjGdbfjdm', 'admin', 'admin', 20);

if (isset($lock_form['sair_page_protected']) && $lock_form['sair_page_protected'] === 'sair') {
    $Lock->logout();
} elseif (isset($lock_form['csrf_token']) && isset($_SESSION['csrf_token']) && $lock_form['csrf_token'] === $_SESSION['csrf_token'] && isset($lock_form['username']) && isset($lock_form['userpassword'])) {
    $Lock->login($lock_form['username'], $lock_form['userpassword']);
}

if (!$Lock->logged()) {
    $_SESSION['csrf_token'] = md5(time());
    ?>
    <div style="position:absolute;width: 330px;top: 50%;left: 50%;transform: translate(-50%, -50%);">
        <form style="display: flex; flex-direction: column;" method="POST" action="">
            <p style="text-align: center;font-size: 1.5rem; letter-spacing: .01rem; line-height: 1.6rem;">Acesso restrito!!</p>
           
            <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .4rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="text" name="username" placeholder="Usuário">
            <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .4rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="password" name="userpassword" placeholder="Senha">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input style="background-color: #0f66b1!important;padding: 7px 11px!important;font-size: 15px; border-radius: 1px; color: inherit; border: none;cursor: pointer;color: #fff;box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12); margin-top: 16px; margin-bottom: 20px!important;font-weight: 700;" type="submit" value="entrar">
             <span style="text-align: center"><?= $Lock->get_error(); ?></span>
        </form>
    </div>
    <?php
    die();
} else {
    ?>
    <div style="border: 1px solid white;position: fixed;top: 0; left: 0; height: 25px; width: 100%;z-index: 500000;display: flex;background-color: black; color: white;align-content: center;">
        <div style="line-height:25px;width: 100%;margin: 0!important; text-align: center;font-size: 11px!important;"># # ACESSO PROTEGIDO POR SENHA # #</div>
        <form method="POST" action="" style="">
            <input style="text-transform: uppercase;cursor: pointer ;margin: 0!important;padding:2px 15px!important;line-height: 15px;background-color: gold;color: #002a80;color: black;" type="submit" name="sair_page_protected" value="sair">
        </form>
    </div>
    <div style="margin-top: 25px;"></div>
    <?php
}
