<?php


namespace App\Services;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Utilisateur;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PretSubscriber implements EventSubscriberInterface
{

    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>['getAuthenticatedClient', EventPriorities::PRE_WRITE]
        ];
    }

    public function getAuthenticatedClient(ViewEvent $event){

        $entity = $event->getControllerResult();//recupere l'entité qui a declenché l'évenement
        $method = $event->getRequest()->getMethod();//récupere la methode invoquée dans la request
        $client = $this->token->getToken()->getUser();//récupere le client actuellement connecté

        if($entity instanceof Utilisateur){

            if ($method == "POST"){
                $entity->setClient($client); //on ecrit l'adhérent dans la propriété adhérent de l'entity utilisateur
            }
        }

        return;
    }
}