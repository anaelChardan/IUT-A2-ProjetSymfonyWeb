<?php
/**
 * 
 * Created by Sébastien Morel.
 * Aka: Ananas
 * Date: 12-13-2014
 * Time: 19:38
 * 
 * Copyright ${PROJECT_AUTHOR} 2014
 */
 

namespace ProjetWeb\ClassiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompositeurController extends Controller {
    public function indexAction() {
        $contexte = "Tous";
        $repoComposer = $this->getDoctrine()->getRepository('ProjetWebClassiqueBundle:Composer');
        $query = $repoComposer->createQueryBuilder('c')
                                    ->join('c.codeMusicien','m')
                                    ->select('m')
                                    ->orderBy('m.nomMusicien','ASC')
                                    ->getQuery();
        $resultat = $query->getResult();
        $compositeur = array();
        //Methode lente du dictinct mais pour l'instant rien trouvé d'autre
        foreach($resultat as $compo) {
            //if (!in_array($compo->getCodeMusicien(),$compositeur))
                $compositeur[] = $compo->getCodeMusicien();
        }

        return $this->render('ProjetWebClassiqueBundle:Musicien:index.html.twig',array('liste'=>$compositeur, 'contexte'=>$contexte));
    }

    public function initialAction($initial){
        $contexte = "avec initiale";
        $repoMusicien = $this->getDoctrine()->getRepository('ProjetWebClassiqueBundle:Musicien');
        $query = $repoMusicien->createQueryBuilder('m')
                              ->where('m.nomMusicien LIKE :init')
                              ->setParameter('init', $initial.'%')
                              ->orderBy('m.nomMusicien', 'ASC')
                              ->getQuery();
        $musicien = $query->getResult();
        return $this->render('ProjetWebClassiqueBundle:Musicien:index.html.twig',array('liste'=>$musicien, 'contexte'=>$contexte,'initial'=>$initial));
    }
} 