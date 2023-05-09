<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    } 

    #[Route('', name: 'app_post')]
    public function index(Request $request){
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->HandleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute('app_post');
        }
        
        return $this->render('post/index.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    /*#[Route('/post/{id}', name: 'app_post')]
    public function index($id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        $custom_post = $this->em->getRepository(Post::class)->findPost($id);
        return $this->render('post/index.html.twig', [
            'post' => $post,
            'custom_post' => $custom_post
        ]);
    }

    #[Route('/insert/post', name: 'insert_post')]
    public function insert(){
        $post = new Post(title: 'Post insertado por medio del constructor', type: 'Opinión', description: 'Hola mundo', file: 'prueba.jpg', url: 'hola-mundo');
        $user = $this->em->getRepository(User::class)->find(id: 1);
        $post->setUser($user);
        $this->em->persist($post);
        $this->em->flush();#Imprescindible ya que provoca el cambio en la BD.
        return new JsonResponse(['success' => true]);#Esto aparece distinto en pantalla en el tutorial. Si sale el mensaje entre corchetes es porque se cargó el nuevo post. Chequear la base de datos para ver si se cargó un nuevo post.
    }

    #[Route('/update/post', name: 'insert_post')]
    public function update(){
        $post = $this->em->getRepository(Post::class)->find(id: 3);
        $post->setTitle('Título actualizado');#Como el post ya existe en la BD, no es necesario incluir el persist().
        $this->em->flush();#Imprescindible ya que provoca el cambio en la BD.
        return new JsonResponse(['success' => true]);#Esto aparece distinto en pantalla en el tutorial. Si sale el mensaje entre corchetes es porque se cargó el nuevo post. Chequear la base de datos para ver si se cargó un nuevo post.
    }

    #[Route('/remove/post', name: 'insert_post')]
    public function remove(){
        $post = $this->em->getRepository(Post::class)->find(id: 16);
        $this->em->remove($post);#Como el post ya existe en la BD, no es necesario incluir el persist().
        $this->em->flush();#Imprescindible ya que provoca el cambio en la BD.
        return new JsonResponse(['success' => true]);#Esto aparece distinto en pantalla en el tutorial. Si sale el mensaje entre corchetes es porque se cargó el nuevo post. Chequear la base de datos para ver si se cargó un nuevo post.
    }*/
}
