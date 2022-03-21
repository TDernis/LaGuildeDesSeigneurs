<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerApiHtmlType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\PlayerServiceInterface;


/**
 * @Route("/player/api-html")
 */
class PlayerApiHtmlController extends AbstractController
{

    public function __construct(private HttpClientInterface $client)
    {
    }

    #[Route("/", name:"player_api_html_index", methods:["GET"])]
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'http://caddy/player/index'
        );
        return $this->render('player_api_html/index.html.twig', [
            'players' => $response->toArray(),
        ]);
    }

   


    // /**
    //  * @Route("/new", name="player_api_html_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {

    //     $player = array();
    //     $form = $this->createForm(PlayerApiHtmlType::class, $player);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $response = $this->client->request(
    //             'POST',
    //             'http://localhost:80/player/create',
    //             [
    //                 'json' => $request->request->all()['player_api_html'],
    //             ]
    //         );

    //         return $this->redirectToRoute('player_api_html_show', array(
    //             'identifier' => $response->toArray()['identifier'],
    //         ));
    //     }

    //     return $this->renderForm('player_api_html/new.html.twig', [
    //         'player' => $player,
    //         'form' => $form,
    //     ]);
    // }


    #[Route("/{identifier}", name:"player_api_html_show", methods:["GET"])]
    public function show(string $identifier): Response
    {
        $response = $this->client->request(
            'GET',
            'http://caddy/player/display/' . $identifier
        );
        return $this->render('player_api_html/show.html.twig', [
            'player' => $response->toArray(),
        ]);
    }

    // /**
    //  * @Route("/{identifier}/edit", name="player_api_html_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, string $identifier): Response
    // {

    //     $response = $this->client->request(
    //         'GET',
    //         'http://localhost:80/player/display/' . $identifier
    //     );
    //     $player = $response->toArray();

    //     $form = $this->createForm(PlayerApiHtmlType::class, $player);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $this->client->request(
    //             'PUT',
    //             'http://localhost:80/player/modify/' . $identifier,
    //             [
    //                 'json' => $request->request->all()['player_api_html'],
    //                 'body' => json_encode($request->request->all()['player_api_html']),
    //             ]
    //         );

    //         return $this->redirectToRoute('player_api_html_show', array(
    //             'identifier' => $identifier,
    //         ));
    //     }

    //     return $this->renderForm('player_api_html/edit.html.twig', [
    //         'player' => $player,
    //         'form' => $form,
    //     ]);
    // }

    // /**
    //  * @Route("/{identifier}", name="player_api_html_delete", methods={"POST"})
    //  */
    // public function delete(Request $request, string $identifier): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $identifier, $request->request->get('_token'))) {
    //         $this->client->request(
    //             'DELETE',
    //             'http://localhost:80/player/delete/' . $identifier,
    //         );
    //     }

    //     return $this->redirectToRoute('player_api_html_index', [], Response::HTTP_SEE_OTHER);
    // }
}
