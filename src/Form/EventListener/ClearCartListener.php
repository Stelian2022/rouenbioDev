<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use App\Manager\CartManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClearCartListener implements EventSubscriberInterface
{
    private CartManager $cartManager;
   

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    /**
     * Removes all items from the cart when the clear button is clicked.
     *
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if (!$cart instanceof Order) {
            return;
        }

        // Is the clear button clicked?
        if (!$form->get('clear')->isClicked()) {
            return;
        }
        $this->cartManager->clearCart($cart);
        // Clears the cart
        $cart->removeItems();
        
    }
}