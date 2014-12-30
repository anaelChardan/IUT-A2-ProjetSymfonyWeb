<?php
namespace ProjetWeb\ClassiqueBundle\Controller;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use ProjetWeb\ClassiqueBundle\Entity\Instrument;
use ProjetWeb\ClassiqueBundle\Entity\Musicien;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InterpreteController extends Controller
{

    /**
     * @param int $page
     *
     * @return array
     * @Route("/interpretes/{page}", requirements={"page" ="\d+"}, defaults={"page"=1}, name="interpretesindex")
     * @Template()
     * @Cache(smaxage=3600)
     */
    public function indexAction($page = 1)
    {
        $contexte = "Tous";
        $pager    = $this->getDoctrine()->getRepository("ProjetWebClassiqueBundle:Musicien")->findAllInterpreteAdapter(
        );

        /** @var Pagerfanta $pager */
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return compact('pager', 'contexte');
    }

    /**
     * @Route("/interpretes/initial/{initial}/{page}", requirements={"initial" = "\S", "page" ="\d+"}, defaults={"initial"= "A", "page"=1}, name="interpretesinitial")
     * @Template("ProjetWebClassiqueBundle:Interprete:index.html.twig")
     * @Cache(smaxage=3600)
     */
    public function initialAction($initial, $page = 1)
    {
        $contexte = "avec initiale";
        $pager    = $this->getDoctrine()
                         ->getRepository("ProjetWebClassiqueBundle:Musicien")
                         ->findInterpreteByInitialAdapter($initial);

        $pager->setMaxPerPage(15);
        $pager->setCurrentPage($page);

        return compact('pager', 'contexte', 'initial');
    }

    /**
     * @Route("/interpretes/naissance/{naissance}/{page}", requirements={"naissance" = "\d+", "page" ="\d+"}, defaults={"naissance"= 1900, "page"=1}, name="interpretesnaissance")
     * @Template("ProjetWebClassiqueBundle:Interprete:index.html.twig")
     * @Cache(smaxage=3600)
     */
    public function naissanceAction(Request $request, $naissance, $page = 1)
    {
        $defaultData = array( 'naissance' => '' );


        $formulaire = $this->createFormBuilder($defaultData)
                           ->add('naissance', 'text', array( 'label' => 'Naissance : ' ))
                           ->add('go', 'submit')
                           ->getForm();

        $formulaire->handleRequest($request);

        if ($formulaire->isValid()) {
            // Les données sont un tableau avec les clés "name";
            $data = $formulaire->getData();
            $year = $data['naissance'];

            if (!is_numeric($year) || strlen($year) > 4) {
                $this->get('session')->getFlashBag()->add('warning', "La date de naissance de l'Interprete que vous avez indiquée n'est pas valide
                , elle doit être numérique et ne pas dépasser les 4 chiffres");
                return $this->redirect($this->generateUrl('interpretesnaissance', array( 'naissance' => 1900 )));
            }

            return $this->redirect($this->generateUrl('interpretesnaissance', array( 'naissance' => $year )));
        }

        $contexte = "par année de naissance";
        $fin      = $naissance + 10;
        $pager    = $this->getDoctrine()
                         ->getRepository("ProjetWebClassiqueBundle:Musicien")
                         ->findInterpreteByNaissanceAdapter($naissance);

        $pager->setMaxPerPage(15);
        $pager->setCurrentPage($page);

        $form = $formulaire->createView();
        return compact('pager', 'contexte', 'naissance', 'fin', 'form');
    }

    /**
     * @Route("/interpretes/search", name="interpretessearch")
     * @Cache(smaxage=3600)
     * @Method( {"GET"})
     */
    public function searchAction(Request $request)
    {

        $pattern     = $request->query->get('query');
        $results     = $this->getDoctrine()
                            ->getRepository("ProjetWebClassiqueBundle:Musicien")
                            ->findInterpreteByPattern(
                                $pattern
                            );
        $suggestions = array();
        /** @var Musicien $result */
        foreach ($results as $result) {
            $suggestions[] = array( 'value' => $result->getNomMusicien().' '.$result->getPrenomMusicien(), 'data' => $result->getCodeMusicien() );
        }

        return new JsonResponse(array( "suggestions" => $suggestions ));
    }

    /**
     * @param
     *
     * @return
     * @Route("/interprete/{codeMusicien}", requirements={"codeMusicien"="\d+"}, name="interpreteview")
     * @Template()
     */
    public function viewAction(Musicien $musicien)
    {
        $image = $this->generateUrl('musicienimage', array( 'codeMusicien' => $musicien->getCodeMusicien() ));

        return compact('musicien', 'image');
    }

    /**
     * @param Instrument $instrument
     * @Route("/interpretes/instrument/{codeInstrument}/{page}", requirements={ "codeInstrument" = "\d+","page"="\d+" }, defaults={"page"=1}, name="interpretesinstrument")
     * @Template()
     */
    public function instrumentAction(Instrument $instrument, $page = 1)
    {

        $pager       = $this->getDoctrine()
                            ->getRepository("ProjetWebClassiqueBundle:Musicien")
                            ->findInterpreteByInstrumentAdapter($instrument);

        $interpretesPaged = $pager->setMaxPerPage(10)
                                  ->setCurrentPage($page)
                                  ->getCurrentPageResults();

        return compact('pager', 'interpretesPaged', 'instrument');
    }
}