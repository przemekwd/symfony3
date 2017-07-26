<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Service\PostImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BlogBundle\View\Post as PostView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("post")
 */
class PostController extends Controller
{
    /**
     * All posts.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('BlogBundle:Post')->findBy([], ['created' => 'DESC']);

        return $this->render('blog/post/index.html.twig', ['posts' => $posts]);
    }

    /**
     * Creates a new post entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('BlogBundle\Form\PostType', $post)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'BlogBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
                ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $imageUpload = $this->container->get(PostImageUploader::class);
            $post->setImage($imageUpload->upload($post->getImage()));
            $post->setUser($user);
            $post->setCreated(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('blog/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

}
