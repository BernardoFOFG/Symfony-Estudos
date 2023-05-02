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
    public function index(Request $request, CategoriaRepository $categoriaRepository)
    {
        // restringir o usuário para só exibir essa tela se tiver logado
        $this->denyAccessUnlessGranted('ROLE_USER');
        // buscar no bd todas as categorias
        $descricaocategoria = $request->query->get('nome');
        $data['categorias'] = is_null($descricaocategoria) ? $categoriaRepository->findAll() : $categoriaRepository->findProdutoByLikeNome($descricaocategoria);
        $data['descricaocategoria'] = $descricaocategoria;
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig', $data);
    }

    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        //$em = é o objeto que vai auxiliar a execução de ações no BD
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // salvar a nova categoria no bd
            $em->persist($categoria); // salvar na memoria
            $em->flush(); // executa para o db;
            return $this->redirectToRoute('categoria');
        }
        $data['titulo'] = "Adicionar nova categoria";
        $data['form'] = $form;

        return $this->renderForm('categoria/form.html.twig', $data);
    }

    public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository): Response
    {
        $categoria = $categoriaRepository->find($id); // retorna a categoria pelo $id;
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // fazendo o UPDATE da categoria no BD 
            return $this->redirectToRoute('categoria');
        }
        $data['titulo'] = "Editar categoria";
        $data['form'] = $form;

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
