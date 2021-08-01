<?php


namespace App\Controller;


use App\Entity\Reader;
use App\Form\Type\ReaderTimerSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function dashboard()
    {
        $readers = $this->getDoctrine()->getRepository(Reader::class)->findAll();

        $data = ['readers'=>$readers];
        $form = $this->createForm(ReaderTimerSettingsType::class,$data);

        return $this->render('index.html.twig',['form'=>$form->createView()]);
    }
}
