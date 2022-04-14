<?php

namespace Drupal\commerce_rec\Controller;
use Drupal\Core\Controller\ControllerBase;


class VariationListController extends ControllerBase{

    public function productVariations()
    {
        # code...
        $parameter = \Drupal::routeMatch()->getParameter('commerce_product');
        dd($parameter->id());

    }
}