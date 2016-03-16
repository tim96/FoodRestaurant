<?php

namespace Tim\FoodRestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TimFoodRestaurantBundle:Default:index.html.twig');
    }
}
