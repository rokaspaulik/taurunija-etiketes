<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\XLabel;
use App\Service\ConnectionService;
use App\Service\UpdateService;
use App\Utils\LabGenerator;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LabelController extends AbstractController
{
    /**
     * @Route("/", name="label")
     * @param ConnectionService $connectionService
     */
    function labelAction(ConnectionService $connectionService){
        $ip = $connectionService->getRealIp();
        $labels = $this->getDoctrine()->getRepository(XLabel::class)->findBy(['ownerIp' => $ip]);

        return $this->render('default/label.html.twig', [
            'labels' => $labels
        ]);
    }

    /**
     * @Route("/edit/{id}")
     * @param $id
     * @param ConnectionService $connectionService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function labelEditAction($id, ConnectionService $connectionService, Request $request){
        $ip = $connectionService->getRealIp();
        $label = $this->getDoctrine()->getRepository(XLabel::class)->find($id);

        if($label == null){
            return $this->redirectToRoute('label');
        }

        if($label->getOwnerIp() != $ip){
            return $this->redirectToRoute('label');
        }

        $form = $this->createFormBuilder($label)
            ->add('price', MoneyType::class, array('label' => 'Kaina'))
            ->add('width', TextType::class, array('label' => 'Plotis/Ilgis/Aukštis (p/i/a)'))
            ->add('country', TextType::class, array('label' => 'Šalis'))
            ->add('fabric', TextType::class, array('label' => 'Medžiaga'))
            ->add('structure', TextType::class, array('label' => 'Sudėtis'))
            ->add('info', TextType::class, array('label' => 'Info'))
            ->add('symbols', TextType::class, array('label' => 'Simbolių kodas'))
            ->add('submit', SubmitType::class, array('label' => 'Išsaugoti', 'attr' => array(
                'class' => 'btn btn-success btn-block btn-lg',
            )))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $price = $form['price']->getData();
            $width = $form['width']->getData();
            $country = $form['country']->getData();
            $fabric = $form['fabric']->getData();
            $structure = $form['structure']->getData();
            $info = $form['info']->getData();
            $symbols = $form['symbols']->getData();
            $label->setPrice(number_format($price,2));
            $label->setWidth($width);
            $label->setCountry($country);
            $label->setFabric($fabric);
            $label->setStructure($structure);
            $label->setSymbols($symbols);
            $label->setInfo($info);

            $em = $this->getDoctrine()->getManager();
            $em->persist($label);
            $em->flush();

            return $this->redirectToRoute('label');
        }

        return $this->render('default/labelForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/generate/excel")
     * @param ConnectionService $connectionService
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function xlsxGetAction(ConnectionService $connectionService){
        $ip = $connectionService->getRealIp();
        $labels = $this->getDoctrine()->getRepository(XLabel::class)->findBy(array('ownerIp' => $ip));

        $generator = new LabGenerator();

        foreach ($labels as $label){
            $price = $label->getPrice();
            $fabric = $label->getFabric();
            $structure = $label->getStructure();
            $country = $label->getCountry();
            $width = $label->getWidth();
            $symbols = $label->getSymbols();
            $info = $label->getInfo();

            $generator->generateLabel($price, $fabric, $structure, $country, $width, $symbols, $info);
        }

        $generator->saveLabels();

        return $this->file('etiket.xlsx', 'etiket.xlsx');
    }

    /**
     * @Route("/delete/{id}")
     * @param $id
     * @param ConnectionService $connectionService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function labelDeleteAction($id, ConnectionService $connectionService){
        $ip = $connectionService->getRealIp();
        $label = $this->getDoctrine()->getRepository(XLabel::class)->find($id);

        if($label == null){
            return $this->redirectToRoute('label');
        }
        if($label->getOwnerIp() != $ip){
            return $this->redirectToRoute('label');
        }else{
            $em = $this->getDoctrine()->getManager();
            $em->remove($label);
            $em->flush();

            return $this->redirectToRoute('label');
        }
    }

    /**
     * @Route("/refresh")
     * @param UpdateService $updateService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function importExcelAction(UpdateService $updateService){
        $updateService->updateTableFromFile();

        return $this->redirectToRoute('label');
    }

    /**
     * @Route("/delselected")
     * @return Response
     */
    public function deleteSelectedAction(Request $request){
        $ids = $request->query->all();
        $em = $this->getDoctrine()->getManager();

        foreach ($ids as $id){
            if($id != 'null'){
                $label = $this->getDoctrine()->getRepository(XLabel::class)->find($id);
                $em->remove($label);
            }
        }
        $em->flush();

        return $this->redirectToRoute('label');
    }
}
