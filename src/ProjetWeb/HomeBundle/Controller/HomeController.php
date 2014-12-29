<?php
namespace ProjetWeb\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class HomeController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Cache(smaxage=3600)
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/about", name="aboutpage")
     * @Cache(smaxage=3600)
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
}