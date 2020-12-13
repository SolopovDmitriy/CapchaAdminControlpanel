<?php

namespace MyAdmApp {

    use MyApp\MethodExecuter as Mexec;
    use MyApp\View;

    class AdminController extends Mexec
    {
        private $header = [];
        private $content = [];
        private $footer = [];

        public function index()
        {
            if (UserAuth::isAuth()) {
                View::Render(ADM_VIEWS_PATH . "header" . EXT, null, $this->header);
                View::Render(ADM_VIEWS_PATH . "template" . EXT, ADM_PAGES_PATH . "main" . EXT, $this->content);
                View::Render(ADM_VIEWS_PATH . "footer" . EXT, null, $this->footer);
            } else {
                $this->loginin();
            }
        }

        public function loginin()
        {
            View::Render(ADM_VIEWS_PATH . "header" . EXT, null, $this->header);
            View::Render(ADM_VIEWS_PATH . "template" . EXT, ADM_PAGES_PATH . "loginin" . EXT, $this->content);
            View::Render(ADM_VIEWS_PATH . "footer" . EXT, null, $this->footer);
        }

        public function register()
        {
            View::Render(ADM_VIEWS_PATH . "header" . EXT, null, $this->header);
            View::Render(ADM_VIEWS_PATH . "template" . EXT, ADM_PAGES_PATH . "register" . EXT, $this->content);
            View::Render(ADM_VIEWS_PATH . "footer" . EXT, null, $this->footer);
        }

        public function logout()
        {
            UserAuth::userSessionDestroy();
//            header('Location: /controlpanel/admin'); // original
            header('Location: /' . ADM_FOLDER . '/admin'); // my code
            exit;
        }

        public function checkuser()
        {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email = htmlspecialchars(trim($_POST['email']));
                $password = htmlspecialchars(trim($_POST['password']));
                $password = hash("sha256", $password);

                $userM = new UserModel();
                $user = $userM->checkUser($email, $password);

                if ($user == null) {
                    $this->content['error'] = "В доступе отказано, попробуйте ещё";
                    $this->loginin();
                } else {
                    //session_start();
                    $_SESSION['login'] = $user['login'];
                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    header('Location: /controlpanel/admin');
                    exit;
                }
            }
        }
    }
}