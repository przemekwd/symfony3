<?php

namespace GamesBundle\Controller;

use Exception;
use GamesBundle\Entity\Developer;
use GamesBundle\Service\DeveloperLogoUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="developer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $developers = $em->getRepository('GamesBundle:Developer')->findBy([], ['name' => 'ASC']);

        return $this->render('developer/index.html.twig', ['developers' => $developers]);
    }

    /**
     * Creates a new developer entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="developer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $developer = new Developer();
        $form = $this->createForm('GamesBundle\Form\DeveloperType', $developer)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'GamesBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
                ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoUpload = $this->container->get(DeveloperLogoUploader::class);
            $developer->setLogo($logoUpload->upload($developer->getLogo()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($developer);
            $em->flush();

            return $this->redirectToRoute('developer_index');
        }

        return $this->render('developer/new.html.twig', [
            'developer' => $developer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a developer entity.
     *
     * @param Developer $developer
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="developer_show")
     * @Method("GET")
     */
    public function showAction(Developer $developer)
    {
        $deleteForm = $this->createDeleteForm($developer, 'danger');

        return $this->render('developer/show.html.twig', [
            'developer' => $developer,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing developer entity.
     *
     * @param Request $request
     * @param Developer $developer
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="developer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Developer $developer)
    {
        try {
            $developer->setLogo(
                new File($this->getParameter('developer_logo_directory') . '/' . $developer->getLogo())
            );
        } catch (Exception $e) {
            $developer->setLogo('');
        }

        $deleteForm = $this->createDeleteForm($developer, 'default');
        $editForm = $this->createForm('GamesBundle\Form\DeveloperType', $developer)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'GamesBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
                ]]);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $logoUpload = $this->container->get(DeveloperLogoUploader::class);
            $developer->setLogo($logoUpload->upload($developer->getLogo()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('developer_index', ['id' => $developer->getId()]);
        }

        return $this->render('developer/edit.html.twig', [
            'developer' => $developer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a developer entity.
     *
     * @param Request $request
     * @param Developer $developer
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="developer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Developer $developer)
    {
        $form = $this->createDeleteForm($developer, 'danger');
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
     * @param string $class Class for delete button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Developer $developer, string $class)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('developer_delete', ['id' => $developer->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.delete', [], 'GamesBundle'),
                'attr' => [
                    'class' => 'btn btn-' . $class . ' pull-right',
                    'role' => 'button',
                ],
            ])
            ->getForm();
    }
}
