<?php 

    require_once 'app/cfg/routes.php';
    require_once 'app/cfg/manager.php';

    require_once PATH_APP . '/controller/halfController.php';
    require_once PATH_APP . '/controller/matterController.php';
    require_once PATH_APP . '/controller/secondCallController.php';
    require_once PATH_APP . '/controller/testController.php';
    require_once PATH_APP . '/controller/userController.php';
    
    $halfController = new HalfController();
    $matterController = new MatterController();
    $secondCallController = new SecondCallController();
    $testController = new TestController();
    $userController = new UserController();


    require_once 'vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('app/view');
    $twig = new Twig_Environment($loader, array());

    $action = isset($_GET['action']) ? $_GET['action'] : NULL;    

    if($action == null || $action == "login")
        echo $twig->render('login/login.html', array());

    elseif($action == "cadastro")
        echo $twig->render('login/cadastro.html', array('name' => 'cadastro'));

    elseif($action == "logar") {
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $response = $userController->logar($email, $password);

        if ($response != false || $response != null || $response != '' ) {
            echo $twig->render('login/login.html', array('response' => 'sim', 'userName' => $_SESSION['user.name']));
        }
        else {
            echo $twig->render('login/login.html', array('response' => 'nao'));
        }
    }

    elseif($action == "cadastrar") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $phone = $_POST['phone'];
        $token = $_POST['token'];
        
        $response = $userController->register($name, $email, $password, $passwordConfirm, $phone, $token);

        if ($response != false || $response != null || $response != '' ) {
            echo $twig->render('login/cadastro.html', array('response' => 'sim'));
        }
        else {
            echo $twig->render('login/cadastro.html', array('response' => 'nao'));
        }
        
    }


    
    

?>