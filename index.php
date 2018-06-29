<?php 
    require_once 'app/cfg/routes.php';
    require_once 'app/cfg/manager.php';
    require_once PATH_APP . '/controller/halfController.php';
    require_once PATH_APP . '/controller/loginController.php';
    require_once PATH_APP . '/controller/matterController.php';
    require_once PATH_APP . '/controller/secondCallController.php';
    require_once PATH_APP . '/controller/testController.php';
    require_once PATH_APP . '/controller/userController.php';


    require_once 'vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('app/view');
    $twig = new Twig_Environment($loader, array());

    $action = isset($_GET['action']) ? $_GET['action'] : NULL;    

    if($action == null || $action == "login")
        echo $twig->render('login/login.html', array('name' => 'login'));

    elseif($action == "cadastro")
        echo $twig->render('login/cadastro.html', array('name' => 'cadastro'));

    elseif($action == "logar") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginController = new LoginController();
        $response = $loginController->logar($email, $password);
        if ($response != false || $response != null || $response != '' ) {
            echo $twig->render('login/login.html', array('entrou' => true, 'userName' => $_SESSION['user.name']));
        }
        else {
            echo $twig->render('login/login.html', array('error' => true));
        }
    } 


    
    

?>