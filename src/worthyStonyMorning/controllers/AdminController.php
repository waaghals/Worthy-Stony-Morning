<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Controllers\BaseController;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class AdminController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function registerAction()
    {
        if (isset($_POST["submit"])) {
            $existingUser = Login::getUserByName($_POST["username"]);
            if (!is_null($existingUser)) {
                $this->error = "Gebruikersnaam bestaat al.";
            } else if ($_POST["password"] !== $_POST["password2"]) {
                $this->error = "Wachtwoorden komen niet overeen.";
            } else if (\strlen($_POST["password"]) < 4) {
                $this->error = "Wachtwoord is tekort.";
            } else if (!isset($_POST["tos"])) {
                $this->error = "U bent vergeten het vakje aan te vinken.";
            } else {
                /* @var $userFactory \Aggressiveswallow\Factories\UserFactory
                 * @var $repo \Aggressiveswallow\Repositories\GenericRepository
                 */
                $userFactory = Container::make("userFactory");
                $repo        = Container::make("genericRepository");
                $user        = $userFactory->createFromUserAndPass($_POST["username"],
                                                                   $_POST["password"]);
                $repo->create($user);

                $t               = new Template("common\message");
                $t->pageTitle    = "Registreren gelukt";
                $t->title        = "Registreren";
                $t->shortMessage = "gelukt";
                $t->description  = "U bent met success geregistreerd.";
                $t->class        = "success";
                return new Response($t, Response::HTTP_CREATED);
            }
        }
        return $this->showRegistrationForm();
    }

    public function loginAction()
    {

        if (isset($_POST["submit"]) && Login::isValidLogin($_POST["username"],
                                                           $_POST["password"])) {

            $this->session->user       = Login::getUserByName($_POST["username"]);
            $this->session->isLoggedIn = true;
            $this->session->regenerateId();

            $t               = new Template("common\message");
            $t->pageTitle    = "Inlogd";
            $t->title        = "Inloggen";
            $t->shortMessage = "gelukt";
            $t->description  = "U bent met success ingelogd.";
            $t->class        = "success";
            return new Response($t, Response::HTTP_OK);
        } elseif (isset($_POST["submit"])) {
            $this->error = "Gebruikersnaam of wachtwoord is verkeerd.";
        }

        return $this->showLoginForm();
    }

    public function logoutAction()
    {
        $this->session->isLoggedin = false;
        $this->session->destroy();
        $this->session->start();

        $t               = new Template("common\message");
        $t->pageTitle    = "Uitgelogd";
        $t->title        = "Uitloggen";
        $t->shortMessage = "gelukt";
        $t->description  = "U bent met success uitgelogd.";
        $t->class        = "success";
        return new Response($t, Response::HTTP_OK);
    }

    private function showRegistrationForm()
    {
        $t = new Template("accountViews/registration");
        if (!is_null($this->error)) {
            $t->error = $this->error;
        }

        return new Response($t, 200);
    }

    private function showLoginForm()
    {

        $t = new Template("accountViews/login");
        if (!is_null($this->error)) {
            $t->error = $this->error;
        }

        $this->error = false;

        return new Response($t, 200);
    }

}
