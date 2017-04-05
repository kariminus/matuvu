<?php

namespace UserBundle\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class ManageUser
{
    private $em;
    private $formFactory;
    private $router;

    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * Lists all user entities.
     *
     */
    public function userIndex ()
    {
        return $this->em->getRepository('UserBundle:User')->findAll();
    }
    /**
     * Deletes a user entity.
     *
     */
    public function userDelete ($id)
    {
        $user = $this->em->getRepository('UserBundle:User')->find($id);
        if ($user === null) {
            return $this->router->generate('admin_user_index');
        }
        $this->em->remove($user);
        $this->em->flush();

        return $this->router->generate('admin_user_index');
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function userEdit ($user)
    {
        $request = $this->requestStack->getCurrentRequest();

        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }
        return [$user, $form];
    }

}