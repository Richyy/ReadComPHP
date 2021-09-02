<?php


namespace App\Controller;


use App\Entity\Reader;
use App\Form\Type\ReaderTimerSettingsType;
use App\Message\ReadComCommand;
use App\Tail\PHPTail;
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
        $reader = $this->getReader((int)$id);
        if ($reader) {
            $entityManager = $this->getDoctrine()->getManager();
            $reader->setConnectionStatus(Reader::READER_CONNECTING);
            $entityManager->persist($reader);
            $entityManager->flush();

            $obj = new \stdClass();
            $obj->readerId = $reader->getId();
            $obj->readerIp = $reader->getIp();
            $obj->timingPoint = $reader->getTimingPoint();
            $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_CONNECT, $obj));
            return new JsonResponse(['result' => true]);
        }
        return new JsonResponse(['result' => false]);
    }

    /**
     * @Route("/disconnect/{id}", name="disconnect", options={"expose"=true})
     */
    public function disconnectFromReader($id)
    {
        $reader = $this->getReader((int)$id);
        if ($reader) {
            $entityManager = $this->getDoctrine()->getManager();
            $reader->setConnectionStatus(Reader::READER_DISCONNECTING);
            $entityManager->persist($reader);
            $entityManager->flush();

            $obj = new \stdClass();
            $obj->readerId = $reader->getId();
            $obj->readerIp = $reader->getIp();
            $obj->timingPoint = $reader->getTimingPoint();
            $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_DISCONNECT, $obj));
            return new JsonResponse(['result' => true]);
        }
        return new JsonResponse(['result' => false]);
    }

    /**
     * @Route("/update/{id}", methods={"POST"}, name="update", options={"expose"=true})
     */
    public function updateReader($id, Request $request)
    {
        $reader = $this->getReader((int)$id);
        if ($reader) {
            $changedField = $request->get('change');
            $readerInput = $request->get('reader');
            $entityManager = $this->getDoctrine()->getManager();
            switch ($changedField) {
                case "ip":
                    $reader->setIp($readerInput['ip']);
                    break;
                case "timingPoint":
                    $reader->setTimingPoint($readerInput['timingPoint']);
                    break;
            }
            $entityManager->persist($reader);
            $entityManager->flush();

            $obj = new \stdClass();
            $obj->readerId = $reader->getId();
            $obj->readerIp = $reader->getIp();
            $obj->changedField = $changedField;
            $obj->timingPoint = $reader->getTimingPoint();
            $this->dispatchMessage(new ReadComCommand(ReadComCommand::COMMAND_TYPE_UPDATE, $obj));
            return new JsonResponse(['result' => true]);
        }
        return new JsonResponse(['result' => false]);
    }

    /**
     * @Route("/logLines", name="getLogLines", options={"expose"=true})
     */
    public function getLogLines(Request $request)
    {
        return new JsonResponse($this->getPhpTail()->getNewLines($request->get('lastSize')));
    }


    private function getPhpTail()
    {
        return new PHPTail($this->getParameter('kernel.logs_dir') . DIRECTORY_SEPARATOR . "csharp.log");
    }
    /**
     * @param int $id
     * @return Reader|null
     */
    private function getReader(int $id)
    {
        return $this->getDoctrine()->getRepository(Reader::class)->find($id);
    }
}
