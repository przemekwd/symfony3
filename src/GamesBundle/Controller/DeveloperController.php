<?php

namespace GamesBundle\Controller;

use GamesBundle\Entity\Developer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Developer controller.
 *
 * @Route("developer")
 */
class DeveloperController extends Controller
{
    /**
     * Lists all developer entities.
     *
     * @Route("/", name="developer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $developers = $em->getRepository('GamesBundle:Developer')->findAll();

        return $this->render('GamesBundle:developer/index.html.twig', array(
            'developers' => $developers,
        ));
    }

    /**
     * Creates a new developer entity.
     *
     * @Route("/new", name="developer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $developer = new Developer();
        $form = $this->createForm('GamesBundle\Form\DeveloperType', $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($developer);
            $em->flush();

            return $this->redirectToRoute('developer_show', array('id' => $developer->getId()));
        }

        return $this->render('GamesBundle:developer/new.html.twig', array(
            'developer' => $developer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a developer entity.
     *
     * @Route("/{id}", name="developer_show")
     * @Method("GET")
     */
    public function showAction(Developer $developer)
    {
        $deleteForm = $this->createDeleteForm($developer);

        return $this->render('GamesBundle:developer/show.html.twig', array(
            'developer' => $developer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing developer entity.
     *
     * @Route("/{id}/edit", name="developer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Developer $developer)
    {
        $deleteForm = $this->createDeleteForm($developer);
        $editForm = $this->createForm('GamesBundle\Form\DeveloperType', $developer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('developer_edit', array('id' => $developer->getId()));
        }

        return $this->render('GamesBundle:developer/edit.html.twig', array(
            'developer' => $developer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a developer entity.
     *
     * @Route("/{id}", name="developer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Developer $developer)
    {
        $form = $this->createDeleteForm($developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($developer);
            $em->flush();
        }

        return $this->redirectToRoute('developer_index');
    }

    /**
     * Creates a form to delete a developer entity.
     *
     * @param Developer $developer The developer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Developer $developer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('developer_delete', array('id' => $developer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
