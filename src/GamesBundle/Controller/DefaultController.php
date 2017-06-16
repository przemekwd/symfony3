<?php

namespace GamesBundle\Controller;

use GamesBundle\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    /**
     * @Route("/games")
     */
    public function indexAction()
    {
        return $this->render('GamesBundle:Default:index.html.twig');
    }

    /**
     * @Route("/games/add")
     */
    public function addAction(Request $request)
    {
        $game = new Game();

        $form = $this->createFormBuilder($game)
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
            ])
            ->add('year', ChoiceType::class, [
                'choices' => array_combine(range(date('Y'), 1970), range(date('Y'), 1970)),
                'required' => true,

            ])
            ->add('save', SubmitType::class, ['label' => 'Add game'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();
        }

        return $this->render('GamesBundle:Default:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
