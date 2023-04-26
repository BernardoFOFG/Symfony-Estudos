<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriaController extends AbstractController
{
    public function index(CategoriaRepository $categoriaRepository)
    {
        // buscar no bd todas as categorias
        $data['categorias'] = $categoriaRepository->findAll();
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig', $data);
    }

    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        //$em = é o objeto que vai auxiliar a execução de ações no BD
        $msg = "";
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // salvar a nova categoria no bd
            $em->persist($categoria); // salvar na memoria
            $em->flush(); // executa para o db;
            $msg = "Categoria adicionada com sucesso";
            return $this->redirectToRoute('categoria');
        }
        $data['titulo'] = "Adicionar nova categoria";
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }

    public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository): Response
    {
        $msg = "";
        $categoria = $categoriaRepository->find($id); // retorna a categoria pelo $id;
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // fazendo o UPDATE da categoria no BD 
            $msg = "Categoria atualizado com sucesso!";
            return $this->redirectToRoute('categoria');
        }
        $data['titulo'] = "Editar categoria";
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }
    public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository): Response
    {
        $categoria = $categoriaRepository->find($id); // retorna a categoria pelo $id;
        $em->remove($categoria); // remove a categoria a nivel de memoria;
        $em->flush(); // remove a categoria do bd; 

        // redirecionar a aplicação para a pagina de categoria_index
        return $this->redirectToRoute('categoria');
    }
}
