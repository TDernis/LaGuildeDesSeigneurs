<?php
namespace App\Listener;
use App\Event\CharacterEvent;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface{
    public static function getSubscribedEvents(){
        return array(CharacterEvent::CHARACTER_CREATED => 'characterCreated');
    }
    public function characterCreated($event){
        $character = $event->getCharacter();
        $character->setIntelligence(250);

        $startDate = new DateTime('2022-03-07 00:00:00');
        $endDate = new DateTime('2022-03-10 00:00:00');

        $actualDate = new DateTime();

        if($actualDate >= $startDate && $actualDate <= $endDate) {
            $character->setLife(20);
        }

    }
}