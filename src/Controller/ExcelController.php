<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\File;
use App\Form\MyFileType;
use App\Service\UpdateService;

class ExcelController extends AbstractController
{
    /**
     * @Route("/import/excel")
     * @param Request $request
     * @param UpdateService $updateService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function fileAddNewAction(UpdateService $updateService, Request $request){
        $file = new File();

        $form = $this->createForm(MyFileType::class, $file);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var File $readyFile */
            $readyFile = $file->getFile();
            $fileName = 'data.xlsx';

            // $readyFile->move(
            //     $this->getParameter('files_directory'),
            //     $fileName
            // );

            $readyFile->move(
                'uploads/',
                $fileName
            );

            $file->setFile($fileName);
            $updateService->updateTableFromFile();

            return $this->redirectToRoute('label');
        }

        return $this->render('default/form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/download/sample")
     */
    public function sampleDownloadAction(){
        return $this->file('pildymo_pvz.xlsx', 'pildymo-pavyzdys.xlsx');
    }
}
