<?php
/**
 * Sidebar pour la gestion des services du serveur
 *
 * @author Olivier <sabinus52@gmail.com>
 *
 * @package Olix
 * @subpackage ServerBundle
 */

namespace Olix\ServerBundle\Sidebar;

use Olix\AdminBundle\Factory\SidebarItem;
use Symfony\Component\Security\Core\SecurityContext;


class ServerSidebar
{

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $context;


    /**
     * Constructeur
     * 
     * @param SecurityContext $context
     */
    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }


    /**
     * Construit le menu supplémentaire de la gestion des services du serveur
     * 
     * @param SidebarItem $sidebar Sidebar d'origine à completer
     */
    public function build(SidebarItem $sidebar)
    {
        if (!$this->context->isGranted('ROLE_SUPER_ADMIN')) return;
        
        $server = $sidebar->addChild('olix_server', array(
            'label' => 'Gestion du serveur',
            'icon'  => 'fa fa-server fa-fw',
        ));
        $server->addChild('olix_server_monit', array(
            'label' => 'Gestion des services',
            'icon'  => 'fa fa-circle fa-fw',
            'route' => 'olix_server_monit',
        ));
    }

}