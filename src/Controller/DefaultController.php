<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'titulo' => "Pagina Inicial",
            // 'mensage' => "Aprendendo passar variaveis para os templates twig",
            //  'frutas' => ['banana', 'laranja', 'abacate'],
        ]);
    }
}
