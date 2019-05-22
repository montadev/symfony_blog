<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
      public function create(Request $request,ObjectManager $manager,ValidatorInterface $validator){

         if($request->request->count() > 0)
         {
                $article=new Article();
                
                $article->setTitle($request->get('title'))
                         ->setContent($request->get('content'))
                         ->setImage("http://placehold.it/350x150");
                         
               
                

                
                   $manager->persist($article);
                   $manager->flush();   
                   
                   return $this->redirectToRoute('blog_show',['id'=>$article->getId()]);
         }
        
      
        return $this->render('blog/create.html.twig');
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
