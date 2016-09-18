<?php

namespace LandingPageBundle\Controller;

use Doctrine\ORM\EntityManager;
use LandingPageBundle\Entity\Register;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var EntityManager  */
    protected $em;

    /**
     * DefaultController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('LandingPageBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @param EntityManager $em
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function registerAction(Request $request, EntityManager $em)
    {
        $hasEmail = $this->em->getRepository(Register::class)->findOneBy(
            ['email' => $request->request->get('email')]
        );

        if ($hasEmail) {
            // throw error.  Email already associated with account.
            // return
        }

        /** @var  $newRegister */
        $newRegister = new Register();
        $newRegister->setEmail($request->request->get('email'));
        $em->persist($newRegister);
        $em->flush();


    }
}
