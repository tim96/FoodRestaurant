<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 3/20/2016
 * Time: 5:42 PM
 */

namespace Tim\FoodRestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontendController extends Controller
{
    /**
     * @Route("/changeLanguage/{name}", name="change_language")
     *
     * @param string $name
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeLanguageAction($name = 'en', Request $request)
    {
        $locale = substr($name, 0, 2);
        $request->getSession()->set('_locale', $locale);
        $request->setLocale($locale);

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
