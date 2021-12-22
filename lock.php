<?php
//Senha de acesso para ser configurada
$LOCK_KEYS = ['user' => 'admin', 'pass' => 'admin123'];

//Alterar o valor para cada projeto
define('LOCK_SESSION_PAGE', 'KhasdjGdbfjdm_43das');

//Texto Informativo na págida ne login
$LOCK_TEXT_LOGIN = "Acesso restrito!!";


//===========================================================
$LOCK_SESSION_USER = LOCK_SESSION_PAGE . md5(@$_SERVER['REMOTE_ADDR'] . @$_SERVER['HTTP_USER_AGENT']);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$args_filter = ['sair' => FILTER_SANITIZE_STRING, 'username' => FILTER_SANITIZE_STRING, 'userpassword' => FILTER_SANITIZE_STRING, 'token' => FILTER_SANITIZE_STRING];
$lock_form = filter_input_array(INPUT_POST, $args_filter);

if (isset($lock_form['sair']) && $lock_form['sair'] === 'sair') {
    session_unset();
    $_SESSION[LOCK_SESSION_PAGE] = false;
} elseif (isset($lock_form['token']) && isset($_SESSION['LOCK_TOKEN']) && $lock_form['token'] == $_SESSION['LOCK_TOKEN'] && isset($lock_form['username']) && $lock_form['username'] === $LOCK_KEYS['user'] && isset($lock_form['userpassword']) && $lock_form['userpassword'] === $LOCK_KEYS['pass']) {
    $_SESSION[LOCK_SESSION_PAGE] = true;
    $_SESSION['LOCK_SESSION'] = $LOCK_SESSION_USER;
}

if (!isset($_SESSION['LOCK_SESSION']) || $_SESSION['LOCK_SESSION'] !== $LOCK_SESSION_USER) {
    session_unset();
    $_SESSION[LOCK_SESSION_PAGE] = false;
}

if (!isset($_SESSION[LOCK_SESSION_PAGE]) || $_SESSION[LOCK_SESSION_PAGE] === false) {
    $_SESSION['LOCK_TOKEN'] = md5(time());
    ?>
    <div style="position:absolute;width: 330px;top: 50%;left: 50%;transform: translate(-50%, -50%);">
        <form style="display: flex; flex-direction: column;" method="POST" action="">
            <p style="text-align: center;font-size: 1.5rem; letter-spacing: .01rem; line-height: 1.6rem;"><?= $LOCK_TEXT_LOGIN; ?></p>
            <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .4rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="text" name="username" placeholder="Usuário">
            <input style="margin-bottom: 9px; color: #0a0a0a;  font-size: 1rem; letter-spacing: .01rem; line-height: 1.6rem; padding: .4rem .3rem; border: 1px solid #cacaca; background-color: #fefefe; border-radius: 0; height: 2.35rem;" type="password" name="userpassword" placeholder="Senha">
            <input style="background-color: #0f66b1!important;padding: 7px 11px!important;font-size: 15px; border-radius: 1px; color: inherit; border: none;cursor: pointer;color: #fff;box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12); margin-top: 16px; margin-bottom: 20px!important;font-weight: 700;" type="submit" value="entrar">
            <input type="hidden" name="token" value="<?= $_SESSION['LOCK_TOKEN']; ?>">
        </form>
    </div>
    <?php
    die();
} else {
    ?>
    <div style="border: 1px solid white;position: fixed;top: 0; left: 0; height: 25px; width: 100%;z-index: 500000;display: flex;background-color: black; color: white;align-content: center;">
        <div style="line-height:25px;width: 100%;margin: 0!important; text-align: center;font-size: 11px!important;"># # ACESSO PROTEGIDO POR SENHA # #</div>
        <form method="POST" action="" style="">
            <input style="text-transform: uppercase;cursor: pointer ;margin: 0!important;padding:2px 15px!important;line-height: 15px;background-color: gold;color: #002a80;color: black;" type="submit" name="sair" value="sair">
        </form>
    </div>
    <div style="margin-top: 25px;"></div>
    <?php
}
