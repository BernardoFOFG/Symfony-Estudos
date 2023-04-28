<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProdutoController extends AbstractController
{
    public function index(EntityManagerInterface $em, ProdutoRepository $produtoRepository)
    {
        // restringir o usuário para só exibir essa tela se tiver logado
        $this->denyAccessUnlessGranted('ROLE_USER');
        // busca os produtos cadastrados
        $data['produtos'] = $produtoRepository->findAll();
        $data['titulo'] = 'Gerenciar Produtos';

        return $this->render("produto/index.html.twig", $data);
    }

    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //salva o produto no BD
            $em->persist($produto);
            $em->flush();

            return $this->redirectToRoute('produto');
        }

        $data['titulo'] = "Adicionar novo produto";
        $data['form'] = $form;

        return $this->renderForm('produto/form.html.twig', $data);
    }
    public function editar($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository): Response
    {
        $produto = $produtoRepository->find($id);
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //salva o produto no BD
            $em->persist($produto);
            $em->flush();

            return $this->redirectToRoute('produto');
        }

        $data['titulo'] = "Editar novo produto";
        $data['form'] = $form;

        return $this->renderForm('produto/form.html.twig', $data);
    }

    public function excluir($id, EntityManagerInterface $em, ProdutoRepository $produtoRepository): Response
    {
        $produto = $produtoRepository->find($id); // retorna a produto pelo $id;
        $em->remove($produto); // remove a produto a nivel de memoria;
        $em->flush(); // remove a produto do bd; 

        // redirecionar a aplicação para a pagina de produto_index
        return $this->redirectToRoute('produto');
    }
}
