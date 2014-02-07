<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Category;

class CategoryController extends BaseController
{
    /**
     * @Route("/admin/category", name="list_categories")
     * @Template("BlogMainBundle:Category:listing.html.twig")
     */
    public function listingAction(Request $request)
    {
        return $this->createResponseArray();
    }
}
