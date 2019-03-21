<?php
/**
 * Created by PhpStorm.
 * User: BPOGGI
 * Date: 08/03/2019
 * Time: 10:25
 */

namespace App\Service;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;
    private $requestStack;
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createBreadcrumbMenu()
    {
        $menu = $this->factory->createItem('root');
        // cet item sera toujours affiché
        $menu->addChild('Home', array('route' => 'home'));
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');

        switch($route){
            case "adminsettings":
                $menu->addChild('Admin_settings', array('route' => $route));
                break;
            case "historique_index":
                $menu->addChild('Historique', array('route' => $route));
                break;
            case "home":
                break;
            case "product_index":
                $menu->addChild('Product', array('route' => $route));
                break;
            case "product_new":
                $menu->addChild('Product', array('route' => $route));
                $menu->addChild('New Product', array('route' => $route));
                break;
            case "product_show":
                $url = $request->getUri();
                break;
            case "product_edit":
                break;
            case "product_tag_index":
                $menu->addChild('Product_tag', array('route' => $route));
                break;
            case "product_tag_new":
                $menu->addChild('New Product Tag', array('route' => $route));
                break;
            case "product_tag_show":
                $url = $request->getUri();
                break;
            case "product_tag_edit":
                break;
            case "profile_product":
                break;
            case "profile_review":
                break;
            case "profile_account":
                break;
            case "profile_password":
                break;
            case "review_index":
                $menu->addChild('Review', array('route' => $route));
                break;
            case "review_new":
                $menu->addChild('New Review', array('route' => $route));
                break;
            case "review_show":
                $url = $request->getUri();
                break;
            case "review_edit":
                break;
            case "support":
                break;
            case "support_list":
                break;
            case "user_index":
                $menu->addChild('User', array('route' => $route));
                break;
            case "user_new":
                $menu->addChild('User', array('route' => $route))
                ->addChild('New User', array('route' => $route));
                break;
            case "user_show":
                $url = $request->getUri();
                break;
            case "user_edit":
                break;

        }

        return $menu;
    }
}