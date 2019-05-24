<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
         //$repo=$this->getDoctrine()->getRepository(Article::class);
         $articles=$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=>$articles
        ]);
    }

    /**
     * @Route("/",name="home")
     */

     public function home()
     {
         return $this->render('blog/home.html.twig');
     }
     

      /**
       * @Route("/blog/new",name="blog_create")
       */
      public function create(Request $request,ObjectManager $manager){

         $article=new Article();
         $form=$this->createFormBuilder($article)
                         ->add('title')
                         ->add('content')
                         ->add('image')                        
                         ->getForm();
        
      
        return $this->render('blog/create.html.twig',[

          'formArticle'=>$form->createView() 
        ]);
      }


     /**
      * @Route("/blog/{id}",name="blog_show")
      */

      public function show($id)
      {
            $repo=$this->getDoctrine()->getRepository(Article::class);
            $article=$repo->find($id);
           return $this->render('blog/show.html.twig',[

             'article'=>$article
           ]);
      }
     
}
