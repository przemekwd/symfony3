<?php

namespace GamesBundle\Controller;

use GamesBundle\Entity\Game;
use GamesBundle\Service\GameCoverUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Game controller.
 *
 * @Route("game")
 */
class GameController extends Controller
{
    /**
     * Lists all game entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('GamesBundle:Game')->findBy([], ['name' => 'ASC']);

        return $this->render('game/index.html.twig', ['games' => $games]);
    }

    /**
     * Creates a new game entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="game_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm('GamesBundle\Form\GameType', $game)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'GamesBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
                ]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coverUploader = $this->container->get(GameCoverUploader::class);
            $game->setCover($coverUploader->upload($game->getCover()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_index', ['id' => $game->getId()]);
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a game entity.
     *
     * @param Game $game
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="game_show")
     * @Method("GET")
     */
    public function showAction(Game $game)
    {
        $deleteForm = $this->createDeleteForm($game, 'danger');

        return $this->render('game/show.html.twig', [
            'game' => $game,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing game entity.
     *
     * @param Request $request
     * @param Game $game
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="game_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Game $game)
    {
        try {
            $game->setCover(
                new File($this->getParameter('game_cover_directory') . '/' . $game->getCover())
            );
        } catch (FileNotFoundException $e) {
            $game->setCover('');
        }

        $deleteForm = $this->createDeleteForm($game, 'default');
        $editForm = $this->createForm('GamesBundle\Form\GameType', $game)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'GamesBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
                ]]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $coverUploader = $this->container->get(GameCoverUploader::class);
            $game->setCover($coverUploader->upload($game->getCover()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index', ['id' => $game->getId()]);
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a game entity.
     *
     * @param Request $request
     * @param Game $game
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game, 'danger');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     * @param string $class Class for delete button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game, string $class)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', ['id' => $game->getId()]))
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
