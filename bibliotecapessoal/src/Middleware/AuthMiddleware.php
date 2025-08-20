<?php
class AuthMiddleware {
    public function handle($request, $next) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login.php');
            exit();
        }
        return $next($request);
    }
}
?>