<?php

class ClassLock {

    public $session_name = "lock_";
    public $expiry = 86400; // 24 horas
    public $user;
    public $_error = null;

    /**
     * @param string $session_name Nome para SESSION LOCK
     * @param string $user Nome para acesso
     * @param string $password Senha para acesso
     * @param int $expiry Tempo de Session em segundos
     */
    public function __construct(string $session_name, string $user, string $password, int $expiry = null) {
        $this->session_name .= $session_name;
        $this->expiry = is_null($expiry) ? $this->expiry : $expiry;
        $this->user['user'] = $user;
        $this->user['password'] = $password;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Faz login com usuario e senha
     * @param type $user nome de acesso
     * @param type $password senha de acesso
     * return boolean
     */
    public function login(string $user, string $password) {
        $user = strip_tags($user);
        $password = strip_tags($password);
        if ($this->is_equals($this->user['user'], $user) && $this->is_equals($this->user['password'], $password)) {
            $_SESSION[$this->session_name]['logged'] = true;
            $_SESSION[$this->session_name]['user'] = $this->sessionUser();
            $_SESSION[$this->session_name]['expiry'] = time();
            return true;
        }
        $this->_error = "Usuário ou Senha incorreto";
        return false;
    }

    public function get_error(){
        if(!is_null($this->_error)){
            return $this->_error;
        }
    }
    /**
     * Verifica se existe SESSION['logged'] e se tem usuario logado
     * @return boolean true: logado, false: não logado
     */
    public function logged() {
        return ($this->is_sessionLogged() && $this->is_sessionExpiry() && $this->is_sessionUser()) ? true : false;
    }

    /**
     * Apaga os dados da session login
     */
    public function logout() {
        if (isset($_SESSION[$this->session_name])) {
            unset($_SESSION[$this->session_name]);
        }
    }

    /**
     * Verifica se existe a SESSION[logged]
     * @return boolean
     */
    private function is_sessionLogged() {
        return isset($_SESSION[$this->session_name]['logged']) && $_SESSION[$this->session_name]['logged'] ? true : false;
    }

    /**
     * Verifica se a SESSION está válida ou expirada
     * @return boolean true: valida, false: expirada
     */
    private function is_sessionExpiry() {
        echo time() - $_SESSION[$this->session_name]['expiry'];
        return isset($_SESSION[$this->session_name]['expiry']) && time() - $_SESSION[$this->session_name]['expiry'] < $this->expiry ? true : false;
    }

    /**
     * Verifica se existe session[user] e se ela esta correta com o usuario
     * @return boolean
     */
    private function is_sessionUser() {
        return isset($_SESSION[$this->session_name]['user']) && $this->is_equals($_SESSION[$this->session_name]['user'], $this->sessionUser()) ? true : false;
    }

    /**
     * Retorna os dados unicos do usuario
     * @return string
     */
    private function sessionUser() {
        return md5($this->session_name . @$_SERVER['REMOTE_ADDR'] . @$_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Verifica se as strings são iguais
     * @param string $string1
     * @param string $string2
     * @return boolean
     */
    private function is_equals(string $string1, string $string2) {
        return $string1 === $string2 ? true : false;
    }

}
