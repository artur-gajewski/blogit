<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Update;
use Blog\MainBundle\Controller\BaseController;

class UpdateController extends BaseController
{
    /**
     * @Route("/admin/update", name="list_updates")
     * @Template("BlogAdminBundle:Update:listing.html.twig")
     */
    public function listingAction(Request $request)
    {
        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/update/new", name="new_update")
     * @Template("BlogAdminBundle:Update:new.html.twig")
     */
    public function newUpdateAction(Request $request)
    {
        $updateService = $this->getUpdateService();

        if ($request->getMethod() == 'POST') {
            $update = new Update();

            $update->setContent($request->get('content'));
            $updateService->saveUpdate($update);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.update_created')
            );

            return $this->redirect($this->generateUrl('list_updates'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/update/edit/{updateId}", name="edit_update")
     * @Template("BlogAdminBundle:Update:edit.html.twig")
     */
    public function editUpdateAction(Request $request, $updateId)
    {
        $updateService = $this->getUpdateService();
        $update = $updateService->getupdateById($updateId);

        if ($request->getMethod() == 'POST') {
            $update->setContent($request->get('content'));
            $updateService->saveUpdate($update);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.changes_saved')
            );
        }

        return $this->createResponseArray(
            array(
                'update' => $update,
            )
        );
    }

    /**
     * @Route("/admin/update/delete/{updateId}", name="delete_update")
     * @Template("BlogAdminBundle:Update:delete.html.twig")
     */
    public function deleteUpdateAction(Request $request, $updateId)
    {
        $updateService = $this->getUpdateService();
        $update = $updateService->getUpdateById($updateId);

        if ($request->getMethod() == 'POST') {
            $updateService->deleteUpdate($update);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.update_deleted')
            );

            return $this->redirect($this->generateUrl('list_updates'));
        }

        return $this->createResponseArray(
            array(
                'update' => $update,
            )
        );
    }
}
