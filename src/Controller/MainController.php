<?php


namespace App\Controller;


use App\Entity\Reader;
use App\Form\Type\ReaderTimerSettingsType;
use App\Message\ReadComCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="dashboard", options={"expose"=true})
     */
    public function dashboard()
    {
        $readers = $this->getDoctrine()->getRepository(Reader::class)->findAll();
        $readerRows = [];
        foreach ($readers as $reader) {
            $readerRows[$reader->getId()] = $reader;
        }
        $data = ['readers' => $readerRows];
        $form = $this->createForm(ReaderTimerSettingsType::class, $data);

        return $this->render('index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/connect/{id}", name="connect", options={"expose"=true})
     */
    public function connectToReader($id)
    {
        $obj = new \stdClass();
        $obj->readerIp = $id;
        $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_CONNECT, $obj));
        return new JsonResponse(['result' => true]);
    }

    /**
     * @Route("/disconnect/{id}", name="disconnect", options={"expose"=true})
     */
    public function disconnectFromReader($id)
    {
        $obj = new \stdClass();
        $obj->readerIp = $id;
        $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_DISCONNECT, $obj));
        return new JsonResponse(['result' => true]);
    }

    /**
     * @Route("/update/{id}", methods={"POST"}, name="update", options={"expose"=true})
     */
    public function updateReader($id, Request $request)
    {
        $obj = new \stdClass();
        $obj->readerIp = $id;
        $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_DISCONNECT, $obj));
        return new JsonResponse(['result' => true]);
    }
}
