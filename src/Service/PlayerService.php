<?php

namespace App\Service;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PlayerService implements PlayerServiceInterface
{
    private EntityManagerInterface $em;
    private PlayerRepository $playerRepository;

    public function __construct(EntityManagerInterface $em, PlayerRepository $cr)
    {
        $this->em = $em;
        $this->playerRepository = $cr;
    }

    public function create(string $data): Player
    {
        $player = new Player();
        $player
            ->setCreationDate(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ->setModification(new \DateTime());
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Player $player)
    {
        if (null === $player->getFirstname() ||
            null === $player->getLastName() ||
            null === $player->getEmail() ||
            null === $player->getIdentifier() ||
            null === $player->getMirian() ||
            null === $player->getCreationDate() ||
            null === $player->getModification()) {
            throw new UnprocessableEntityHttpException('Missing data for Entity -> ' . json_encode($player->toArray()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submit(Player $player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
    }

    public function getAll(): array
    {
        $playersFinal = [];
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }

        return $playersFinal;
    }

    public function update(Player $player): Player
    {
        $player
            ->setFirstname('Maë')
            ->setLastname('MARTIN')
            ->setEmail('mae311010@gmail.com')
            ->setMirian(0)
            ->setPlayerId(1)
            ->setModification(new \DateTime());

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    public function delete(Player $player): bool
    {
        $this->em->remove($player);
        $this->em->flush();
        return true;
    }
}