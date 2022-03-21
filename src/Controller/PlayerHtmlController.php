<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerHtmlType;
use App\Service\PlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PlayerServiceInterface;

#[Route('/player/html')]
class PlayerHtmlController extends AbstractController
{


    public function __construct(private PlayerServiceInterface $playerService)
    {
    }


    #[Route('/', name: 'app_player_html_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('player_html/index.html.twig', [
            'players' => $this->playerService->getAll(),
        ]);
    }

    
    // #[Route('/new', name: 'app_player_html_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $player = new Player();
    //     $form = $this->createForm(PlayerHtmlType::class, $player);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->playerService->createFromHtml($player);
    //         return $this->redirectToRoute('app_player_html_show', array('id' => $player->getId(),));
    //     }

    //     return $this->renderForm('player_html/new.html.twig', [
    //         'player' => $player,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_player_html_show', methods: ['GET'])]
    public function show(Player $player): Response
    {
        return $this->render('player_html/show.html.twig', [
            'player' => $player,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_player_html_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(PlayerHtmlType::class, $player);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->playerService->modifyFromHtml($player);
    //         return $this->redirectToRoute('app_player_html_index', array('id' => $player->getId(),));
    //     }

    //     return $this->renderForm('player_html/edit.html.twig', [
    //         'player' => $player,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_player_html_delete', methods: ['POST'])]
    // public function delete(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $player->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($player);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_player_html_index', [], Response::HTTP_SEE_OTHER);
    // }
}
