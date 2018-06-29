<?php
session_start();
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

$action = isset($_GET['action']) ? $_GET['action'] : null;

////////// ----> login/cadastro
if ($action == null || $action == "login") {
    session_destroy();
    echo $twig->render('login/login.html', array());
}
//
elseif ($action == "cadastro") {
    session_destroy();
    echo $twig->render('login/cadastro.html', array('name' => 'cadastro'));
}
//
elseif ($action == "logar") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $response = $userController->logar($email, $password);

    if ($response != false || $response != null || $response != '') {
        echo $twig->render('pages/segundasChamadas.html', array('userName' => $_SESSION['name'], 'type' => $_SESSION['type']));
    } else {
        echo $twig->render('login/login.html', array('response' => 'false'));
    }
}
//
elseif ($action == "logof") {
    session_destroy();
    echo $twig->render('login/login.html', array());
}
//
elseif ($action == "cadastrar") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $phone = $_POST['phone'];
    $token = $_POST['token'];

    $response = $userController->register($name, $email, $password, $passwordConfirm, $phone, $token);

    if ($response != false || $response != null || $response != '') {
        echo $twig->render('login/cadastro.html', array('response' => 'sim'));
    } //
    else {
        echo $twig->render('login/cadastro.html', array('response' => 'nao'));
    }

}

////////// ----> segundasChamadas
elseif ($action == "segundasChamadas") {
    echo $twig->render('pages/segundasChamadas.html', array('type' => $_SESSION['type']));
}

////////// ----> materias
elseif ($action == "materias") {

    $response = $matterController->findMatter();

    $responseSelect = $halfController->findHalf();

    echo $twig->render('pages/materias.html', array('response' => $response, 'responseSelect' => $responseSelect));
}
//
elseif ($action == "cadastrarMateria") {
    $name = $_POST['name'];
    $time = $_POST['time'];
    $idHalf = $_POST['idHalf'];

    $response = $matterController->findMatter();

    $responseRes = $matterController->register($name, $time, $idHalf);

    if ($responseRes != false || $responseRes != null || $responseRes != '') {
        echo $twig->render('pages/materias.html', array('tryCad' => 'sim', 'response' => $response));
    } //
    else {
        echo $twig->render('pages/materias.html', array('tryCad' => 'nao', 'response' => $response));
    }
}

////////// ----> semestres
elseif ($action == "semestres") {
    $response = $halfController->findHalf();
    echo $twig->render('pages/semestres.html', array('response' => $response));
}
//
elseif ($action == "cadastrarSemestre") {
    $response = $halfController->findHalf();

    $name = $_POST['name'];

    $responseRes = $halfController->register($name);

    if ($responseRes != false || $responseRes != null || $responseRes != '') {
        echo $twig->render('pages/semestres.html', array('tryCad' => 'sim', 'response' => $response));
    } //
    else {
        echo $twig->render('pages/semestres.html', array('tryCad' => 'nao', 'response' => $response));
    }
}
