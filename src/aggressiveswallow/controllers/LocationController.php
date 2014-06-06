<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Aggressiveswallow\Controllers;

use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Models\Location;
use Aggressiveswallow\Models\Address;
use Aggressiveswallow\Models\MenuItem;
use Aggressiveswallow\Tools\Template;
use Aggressiveswallow\Tools\Container;

/**
 * Description of Location
 *
 * @author Patrick
 */
class LocationController
        extends BaseController {

    public function addAction() {
        $t = new Template("locationViews\add");
        $t->pageTitle = "Toevoegen";
        if (isset($_POST["submit"])) {
            $errors = $this->getErrors($_POST);

            if (is_null($errors)) {
                //Form filled successfull
                $locationFactory = Container::make("locationFactory");
                $addressFactory = Container::make("addressFactory");
                $location = $locationFactory->create($_POST);
                $address = $addressFactory->create($_POST);
                $location->setAddress($address);

                $menuItem = $this->getMenuItemFromForm($_POST["category"]);

                $location->setMenuItem($menuItem);

                $repo = Container::make("genericRepository");
                $newLocation = $repo->create($location);

                $t = new Template("common/message");
                $t->pageTitle = "Woning toegevoegd";
                $t->title = "woning";
                $t->shortMessage = "toegevoegd";
                $t->class = "success";
                $text = "De woning op %s is successvol toegevoegd.";
                $t->description = sprintf($text, $newLocation->getAddress()->getFullStreetName());

                return new Response($t);
            } else {
                $t->error = $errors;
            }

            //return new ErrorResponse("Create action not yet implented.", Response::HTTP_NOT_IMPLEMENTED);
        }
        return new Response($t);
    }

    public function showAction($locationId) {
        $repository = Container::make("GenericRepository");

        $locationQuery = Container::make("SingleLocationQuery");
        $locationQuery->setId((int) $locationId);

        /* @var $location \Aggressiveswallow\Models\Location */
        $location = $repository->read($locationQuery);

        if (is_null($location)) {
            return new ErrorResponse("Requested location does not exists.");
        }

        $breadcrumsQuery = Container::make("breadcrumsQuery");
        $breadcrumsQuery->setMenuItem($location->getMenuItem());
        $breadcrums = $repository->read($breadcrumsQuery);
        $lastBreadcrum = new MenuItem();
        $lastBreadcrum->setName($location->getAddress()->getFullStreetName());
        $lastBreadcrum->setUri(sprintf("/location/show/locationId=%s/#", $locationId));
        $breadcrums[] = $lastBreadcrum;

        $t = new Template("locationViews/showLocation");
        $t->location = $location;
        $t->breadcrums = $breadcrums;
        $t->pagetitle = $location->getAddress()->getFullStreetName();
        $t->cart = $this->session->cart;

        return new Response($t, 200);
    }

    public function editAction($locationId = null) {
        return new ErrorResponse("Update action not yet implented.", Response::HTTP_NOT_IMPLEMENTED);
    }

    public function deleteAction($locationId = null) {
        return new ErrorResponse("Delete action not yet implented.", Response::HTTP_NOT_IMPLEMENTED);
    }

    private function getMenuItemFromForm($data) {
        return unserialize(
                gzinflate(
                        base64_decode(
                                $data
                        )
                )
        );
    }

    private function getErrors($postData) {
        if (strlen($postData["address_street"]) < 1) {
            return "Straat naam is te kort";
        }

        if (strlen($postData["address_housenumber"]) < 1) {
            return "Huisnummer is te kort";
        }

        if (strlen($postData["address_zipcode"]) < 6) {
            return "Postcode is te kort";
        }

        if (strlen($postData["address_city"]) < 1) {
            return "Plaats is te kort";
        }

        if (strlen($postData["location_description"]) < 10) {
            return "Omschrijving moet minimaal 10 tekens lang zijn.";
        }

        //   if ($postData["location_newbuild"] != 0 || $postData["location_newbuild"] != 1) {
        //       return "Ongeldige waarde voor nieuwbouw.";
        //   }

        if (!in_array($postData["location_energylabel"], array("a", "b", "c", "d"))) {
            return "Ongeldige waarde voor energie label.";
        }

        return null;
    }

}
