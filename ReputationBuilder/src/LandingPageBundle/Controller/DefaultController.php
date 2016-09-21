<?php

namespace LandingPageBundle\Controller;

use Doctrine\ORM\EntityManager;
use LandingPageBundle\Entity\Register;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('LandingPageBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function registerAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        $hasEmail = $em->getRepository(Register::class)->findOneBy(
            ['email' => $request->request->get('email')]
        );

        if (!$hasEmail) {
	    /** @var  $newRegister */
            $newRegister = new Register();
            $newRegister->setEmail($request->request->get('email'));
            $em->persist($newRegister);
            $em->flush();
            $this->get("session")->getFlashBag()->add("notice", "Thanks for registering.  Look for an email in a few weeks reguarding early registration and 3 month trial!");
        } else {
	     $this->get("session")->getFlashBag()->add("notice", "You're all set, email was already added");

	}

        return $this->forward('LandingPageBundle:Default:index');
    }
}
