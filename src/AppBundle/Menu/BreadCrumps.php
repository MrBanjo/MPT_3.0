<?php

namespace AppBundle\Menu;

use Symfony\Component\HttpFoundation\Request;

  class BreadCrumps
  {

    public function CreateBreadCrumpsAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        // Simple example
        $breadcrumbs->addItem("Home", $this->get("router")->generate("index"));

        // Example without URL
        $breadcrumbs->addItem("Some text without link");

    }
 
}