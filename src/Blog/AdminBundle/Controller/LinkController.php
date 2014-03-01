<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Link;
use Blog\MainBundle\Controller\BaseController;

class LinkController extends BaseController
{
    /**
     * @Route("/admin/link", name="list_links")
     * @Template("BlogAdminBundle:Link:listing.html.twig")
     */
    public function listingAction(Request $request)
    {
        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/link/new", name="new_link")
     * @Template("BlogAdminBundle:Link:new.html.twig")
     */
    public function newLinkAction(Request $request)
    {
        $linkService = $this->getLinkService();

        if ($request->getMethod() == 'POST') {
            $link = new Link();

            $link->setTitle($request->get('title'));
            $link->setUrl($request->get('url'));

            $linkService->saveLink($link);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.link_created')
            );

            return $this->redirect($this->generateUrl('list_links'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/link/edit/{linkId}", name="edit_link")
     * @Template("BlogAdminBundle:Link:edit.html.twig")
     */
    public function editLinkAction(Request $request, $linkId)
    {
        $linkService = $this->getLinkService();
        $link = $linkService->getlinkById($linkId);

        if ($request->getMethod() == 'POST') {
            $link->setTitle($request->get('title'));
            $link->setUrl($request->get('url'));
            $linkService->saveLink($link);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.changes_saved')
            );
        }

        return $this->createResponseArray(
            array(
                'link' => $link,
            )
        );
    }

    /**
     * @Route("/admin/link/delete/{linkId}", name="delete_link")
     * @Template("BlogAdminBundle:Link:delete.html.twig")
     */
    public function deleteLinkAction(Request $request, $linkId)
    {
        $linkService = $this->getLinkService();
        $link = $linkService->getLinkById($linkId);

        if ($request->getMethod() == 'POST') {
            $linkService->deleteLink($link);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.link_deleted')
            );

            return $this->redirect($this->generateUrl('list_links'));
        }

        return $this->createResponseArray(
            array(
                'link' => $link,
            )
        );
    }
}
