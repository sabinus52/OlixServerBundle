<?php
/**
 * Controller de la gestion du package COLLECTD
 *
 * @author Olivier <sabinus52@gmail.com>
 *
 * @package Olix
 * @subpackage ServerBundle
 */

namespace Olix\ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;


class CollectdController extends Controller
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
        
        // Charge la configuration des services monitoré
        $yaml = new Parser();
        $values = $yaml->parse(file_get_contents($this->get('kernel')->getRootDir().'/config/'.$this->getParameter('olix_server.collectd_file')));
        //var_dump($values);
        
        // Affichage de la page
        return $this->container->get('olix.admin')->render('OlixServerBundle:Collectd:index.html.twig', 'olix_server_collectd', array(
            'graphs' => $values,
            'timespan' => $this->getRequest()->get('timespan', 'hour'),
        ));
    }


    /**
     * Retourne le graph de monitoring
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function graphAction ()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }
        
        // Lecture des paramètres
        $request = $this->get('request');
        $host = $request->get('host');
        $plugin = $request->get('plugin');
        $pinst = $request->get('pinst');
        $type = $request->get('type');
        $tinst = $request->get('tinst');
        $timespan = $request->get('timespan');
        
        // Construction de la querystring
        $request = $this->get('request');
        $qs = 'host='.$host;
        $qs.= '&plugin='.$plugin;
        $qs.= '&plugin_instance='.(($pinst == 'void') ? '' : $pinst);
        $qs.= '&type='.$type;
        $qs.= '&type_instance='.(($tinst == 'void') ? '' : $tinst);
        $qs.= '&timespan='.$timespan;
        
        return new Response(file_get_contents($this->getParameter('olix_server.collectd_host').'?'.$qs), 200, array('Content-Type' => 'image/png'));
    }

}