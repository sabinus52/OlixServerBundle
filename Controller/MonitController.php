<?php
/**
 * Controller de la gestion du package MONIT
 *
 * @author Olivier <sabinus52@gmail.com>
 *
 * @package Olix
 * @subpackage ServerBundle
 */

namespace Olix\ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class MonitController extends Controller
{

    /**
     * Page d'accueil
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction ()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }
        
        
        
        // Affichage de la page
        return $this->container->get('olix.admin')->render('OlixServerBundle:Monit:index.html.twig', 'olix_server_monit', array(
        ));
    }

}