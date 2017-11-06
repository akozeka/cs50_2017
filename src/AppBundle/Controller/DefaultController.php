<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Office;
use AppBundle\Entity\OfficeCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//        $manager = $this->getDoctrine()->getManager();
//
//        $category = $manager->find(OfficeCategory::class, 11);
//        $offices = $manager->getRepository(Office::class)->findAll();
//
//        foreach ($offices as $office) {
//            dump($office->categories->count());
//            foreach ($office->categories as $category) {
//            }
//        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
