<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BaseController extends Controller
{
    public function createResponseArray($array = null)
    {
        $common =  array(
            'categories' => array(
                array(
                    'slug' => 'testing-stuff',
                    'title' => 'Testing stuff',
                    'count' => 13,
                ),
                array(
                    'slug' => 'another-cat',
                    'title' => 'Another cat',
                    'count' => 11,
                ),
            ),
            'years' => array(
                array(
                    'created' => 2004,
                    'count' => 13,
                ),
                array(
                    'created' => 2005,
                    'count' => 33,
                ),
                array(
                    'created' => 2006,
                    'count' => 57,
                ),
            ),
        );

        if (!empty($array)) {
            return array_merge_recursive($array, $common);
        }

        return $common;
    }

    /**
     * @return PostService
     */
    public function getPostService()
    {
        return $this->container->get('blog_main.service.post');
    }
}
