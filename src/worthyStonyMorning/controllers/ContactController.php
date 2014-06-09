<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Controllers\BaseController;
use WorthyStonyMorning\Helpers\MessageHelper;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class ContactController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if (isset($_POST["submit"])) {
            $validator = Container::make("contactValidator");
            if (!$validator->isValid($_POST)) {
                $this->errors = $validator->getMessages();
            } else {
                return $this->sendMail($_POST["contact_email"],
                                       $_POST["contact_name"],
                                       $_POST["contact_message"]);
            }
        }
        return $this->showContactForm($_POST);
    }

    private function showContactForm($post_data = array())
    {
        $t = new Template("contactViews/contactForm");

        $repo  = Container::make("genericRepository");
        $query = Container::make("singlePageQuery");
        $query->setPageName("contact");
        $page  = $repo->read($query);

        $t->content = $page->getContent();

        if (!empty($this->errors)) {
            $t->errors = $this->errors;
        }

        $t->data = $post_data;
        if (is_null($post_data)) {
            $t->data = array();
        }

        $t->pageTitle = "Bericht verzenden";

        return new Response($t);
    }

    private function sendMail($sender, $senderName, $message)
    {

        $cleanName    = \filter_var($senderName, \FILTER_SANITIZE_STRING);
        $cleanMessage = \filter_var($message, \FILTER_SANITIZE_STRING);
        $fromHeader   = sprintf("From: %s <%s>" . "\r\n", $cleanName, $sender);
        $subject      = "Nieuw bericht via WWF website";

        if (\mail(ADMIN_EMAIL, $subject, $cleanMessage, $fromHeader)) {
            $success = "Uw bericht is verzonden naar de beheerder van deze website."
                    . "We nemen zo spoedig mogelijk contact met u op.";
            return MessageHelper::success("Bericht", "verzonden", $success);
        }

        $error = "Uw bericht kon door een server fout niet worden verstuurd";
        return MessageHelper::error("Bericht", "foutmelding", $error);
    }

}
