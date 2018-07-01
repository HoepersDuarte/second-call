<?php
session_start();
require_once 'app/cfg/routes.php';
require_once 'app/cfg/manager.php';

require_once PATH_APP . '/controller/halfController.php';
require_once PATH_APP . '/controller/matterController.php';
require_once PATH_APP . '/controller/secondCallController.php';
require_once PATH_APP . '/controller/testController.php';
require_once PATH_APP . '/controller/userController.php';

require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('app/view');
$twig = new Twig_Environment($loader, array());

$action = isset($_GET['action']) ? $_GET['action'] : null;

$header = $twig->load('requires/header.html');
$menu = $twig->load('requires/menu.html');
$footer = $twig->load('requires/footer.html');

$requires = array('header' => $header, 'menu' => $menu, 'footer' => $footer);
////////// ----> login/cadastro
if ($action == null || $action == "login") {
    session_destroy();
    echo $twig->render('pages/login.html', array('requires' => $requires));
}
//
elseif ($action == "cadastro") {
    session_destroy();
    echo $twig->render('pages/cadastro.html', array('requires' => $requires));
}
//
elseif ($action == "logar") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $userController = new UserController();
    $response = $userController->logar($email, $password);

    if ($response != false || $response != null || $response != '') {
        echo $twig->render('pages/segundasChamadas.html', array('requires' => $requires, 'session' => $_SESSION['session']));
    } else {
        echo $twig->render('pages/login.html', array('requires' => $requires, 'session' => 'fail'));
    }
}
//
elseif ($action == "logof") {
    session_destroy();
    echo $twig->render('pages/login.html', array('requires' => $requires));
}
//
elseif ($action == "cadastrar") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $phone = $_POST['phone'];
    $token = $_POST['token'];

    $userController = new UserController();
    $response = $userController->register($name, $email, $password, $passwordConfirm, $phone, $token);

    if ($response != false || $response != null || $response != '') {
        $response = 'registered';
    } //
    else {
        $response = 'fail';
    }

    echo $twig->render('pages/cadastro.html', array('response', $response, 'requires' => $requires));
}

////////// ----> semestres
elseif ($action == "semestres") {
    $halfController = new HalfController();
    $findAll = $halfController->findHalf();
    echo $twig->render('pages/semestres.html', array('findAll' => $findAll));
}
//
elseif ($action == "cadastrarSemestre") {
    $name = $_POST['name'];
    $response = $halfController->register($name);

    $halfController = new HalfController();
    $findAll = $halfController->findHalf();

    if ($response != false || $response != null || $response != '') {
        $response = 'registered';
    } //
    else {
        $response = 'fail';
    }

    echo $twig->render('pages/semestres.html', array('response' => $response, 'findAll' => $findAll));
}

////////// ----> materias
elseif ($action == "materias") {

    $matterController = new MatterController();
    $findAll = $matterController->findMatter();

    $halfController = new HalfController();
    $findSelect = $halfController->findHalf();

    echo $twig->render('pages/materias.html', array('findAll' => $findAll, 'findSelect' => $findSelect));
}
//
elseif ($action == "cadastrarMateria") {
    $name = $_POST['name'];
    $time = $_POST['time'];
    $idHalf = $_POST['idHalf'];

    $matterController = new MatterController();
    $response = $matterController->register($name, $time, $idHalf);
    $findAll = $matterController->findMatter();

    $halfController = new HalfController();
    $findSelect = $halfController->findHalf();

    if ($response != false || $response != null || $response != '') {
        $response = 'registered';
    } //
    else {
        $response = 'fail';
    }

    echo $twig->render('pages/materias.html', array('response' => $response, 'findAll' => $findAll, 'findSelect' => $findSelect));
}
//
elseif ($action == "addMateria") {
    $token = $_POST['token'];

    $matterController = new MatterController();
    $findAll = $matterController->findMatter();

    $halfController = new HalfController();
    $findSelect = $halfController->findHalf();

    $responseAdd = false;
    if ($responseAdd != false || $responseAdd != null || $responseAdd != '') {
        $responseAdd = 'registered';
    } //
    else {
        $responseAdd = 'fail';
    }
    echo $twig->render('pages/materias.html', array('responseAdd' => $responseAdd, 'findAll' => $findAll, 'findSelect' => $findSelect));
}
////////// ----> provas
elseif ($action == "provas") {

    $testController = new TestController();
    $findAll = $testController->findTest();

    $matterController = new MatterController();
    $findSelect = $matterController->findMatter();

    echo $twig->render('pages/provas.html', array('findAll' => $findAll, 'findSelect' => $findSelect));
}
//
elseif ($action == "cadastrarProva") {

    $name = $_POST['name'];
    $idMatter = $_POST['idMatter'];

    $testController = new TestController;
    $response = $testController->register($name, $idMatter);
    $findAll = $testController->findTest();

    if ($response != false || $response != null || $response != '') {
        $response = 'registered';
    } //
    else {
        $response = 'fail';
    }

    $matterController = new MatterController();
    $findSelect = $matterController->findMatter();

    echo $twig->render('pages/provas.html', array('response' => $response, 'findAll' => $findAll, 'findSelect' => $findSelect));
}

////////// ----> segundasChamadas
// Nomeclatura dos status
// 1 = pendente
// 2 = recusado
// 3 = aprovado pelo coordenador
// 4 = aprovado e remarcado pelo professor
elseif ($action == "segundasChamadas") {
    $secondCallController = new SecondCallController;
    $findAll = $secondCallController->findSecondCall();

    $testController = new TestController;
    $findSelect = $testController->findTest();

    echo $twig->render('pages/segundasChamadas.html', array('findAll' => $findAll, 'findSelect' => $findSelect));
}
//
elseif ($action == "cadastrarSegundaChamada") {
    $description = $_POST['description'];
    $idTest = $_POST['idTest'];
    $archive = $_FILES;

    $secondCallController = new SecondCallController;
    $response = $secondCallController->register($description, $idTest, $archive);
    $findAll = $secondCallController->findSecondCall();

    $testController = new TestController;
    $findSelect = $testController->findTest();

    if ($response != false || $response != null || $response != '') {
        $response = 'registered';
    } //
    else {
        $response = 'fail';
    }

    echo $twig->render('pages/segundasChamadas.html', array('response' => $response, 'findAll' => $findAll, 'findSelect' => $findSelect));
}
//
elseif ($action == "aprovarSegundaChamada") {
    $idSecondCall = $_GET['id'];

    $secondCallController = new SecondCallController;
    $secondCallController->approves($idSecondCall);
    $findAll = $secondCallController->findSecondCall();

    $testController = new TestController;
    $findSelect = $testController->findTest();

    echo $twig->render('pages/segundasChamadas.html', array('findAll' => $findAll, 'findSelect' => $findSelect));

}
//
elseif ($action == "reprovarSegundaChamada") {
    $idSecondCall = $_GET['id'];

    $secondCallController = new SecondCallController;
    $secondCallController->disapprove($idSecondCall);
    $findAll = $secondCallController->findSecondCall();

    $testController = new TestController;
    $findSelect = $testController->findTest();

    echo $twig->render('pages/segundasChamadas.html', array('findAll' => $findAll, 'findSelect' => $findSelect));

}
//
elseif ($action == "remarcarProva") {
    $idSecondCall = $_GET['id'];

    echo $twig->render('pages/remarcarProva.html', array('idSecondCall' => $idSecondCall));

}
//
elseif ($action == "updateSegundaChamada") {
    $local = $_POST['local'];
    $date = $_POST['date'];
    
    $secondCallController = new SecondCallController;
    $response = $secondCallController->updateSecondCall();

    echo $twig->render('pages/remarcarProva.html', array('response' => $response, 'idSecondCall' => $idSecondCall));
}
