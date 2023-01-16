<?php

namespace App\Controller;

use App\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request): Response
    {
        $formulaire = $this->createForm(NewsletterType::class);



        // traitement de l'envoie du formulaire :
        //1. regarder à partir du formulaire
        // si des données sont à lire dans l'objet request
       $formulaire->handleRequest($request);
       // 2. Si je trouve des données et que le formulaire
       // on a cliqué sur envoyé
       if ($formulaire->isSubmitted() && $formulaire->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original $task variable has also been updated
           $task = $formulaire->getData();

           // ... perform some action, such as saving the task to the database

           return $this->render('newsletter/newsletter_envoye.html.twig', [
            'data' => $task
        ]);
       }


       return $this->renderForm('newsletter/index.html.twig', [
        'formulaire' => $formulaire
       ]);
    }
}