<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/shows", name="shows")
     * @Template()
     */
    public function showsAction(Request $request , $page = 1)
    {
        $showsPerPages = 7;

        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:TVShow');

        $selectedPage = $request->query->get('page');

        if( !empty($selectedPage))
            $page = $selectedPage;
        
        $shows = $repo->paginateShows($page, $showsPerPages);

        $totalPages = ceil(count($shows) / $showsPerPages);        
        $pagination = [];

        for($i = 0; $i < $totalPages; $i++){
            $pagination[$i] = $i + 1;
        }

        
        return [
            'shows' => $shows,
            'pages' => $pagination,
            'page'  => $page
        ];
    }

    /**
     * @Route("/show/{id}", name="show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:TVShow');

        return [
            'show' => $repo->find($id)
        ];        
    }

    /**
     * @Route("/calendar", name="calendar")
     * @Template()
     */
    public function calendarAction()
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:TVShow');

        return [
            'shows' => $repo->findAll()
        ];
    }

    /**
     * @Route("/search", name="search")
     * @Template()
     */
     public function searchAction(Request $request)
    {
        $search_content = $request->request->get('term');
        
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:TVShow');
            
        return [
            'shows' => $repo->myTvShowsBySearch($search_content) ,
            'search_content' => $search_content
        ];
        
    }


    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        return [];
    }
}
