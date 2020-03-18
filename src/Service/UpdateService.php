<?php

namespace App\Service;

use App\Entity\XLabel;
use Doctrine\ORM\EntityManagerInterface;

class UpdateService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateTableFromFile() {
        $this->deleteAllLabels();

        $inputFileName = 'uploads/data.xlsx';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $sheet = $reader->load($inputFileName);

        $num = '2';
        while ($sheet->getActiveSheet()->getCell('A'.$num)->getValue()){
            $price = $sheet->getActiveSheet()->getCell('A'.$num)->getValue();
            $fabric = $sheet->getActiveSheet()->getCell('B'.$num)->getValue();
            $struct = $sheet->getActiveSheet()->getCell('C'.$num)->getValue();
            $width = $sheet->getActiveSheet()->getCell('D'.$num)->getValue();
            $country = $sheet->getActiveSheet()->getCell('E'.$num)->getValue();
            $info = $sheet->getActiveSheet()->getCell('F'.$num)->getValue();
            $symbols = $sheet->getActiveSheet()->getCell('G'.$num)->getValue();

            $label = new XLabel();
            $label->setPrice($price);
            $label->setFabric($fabric);
            $label->setStructure($struct);
            $label->setWidth($width);
            $label->setCountry($country);
            $label->setInfo($info);
            $label->setSymbols($symbols);

            $connectionService = new ConnectionService();
            $ip = $connectionService->getRealIp();
            $label->setOwnerIp($ip);

            $this->entityManager->persist($label);
            $num++;
        }
        $this->entityManager->flush();
    }

    private function deleteAllLabels(){
        $connectionService = new ConnectionService();
        $ip = $connectionService->getRealIp();
        $labels = $this->entityManager->getRepository(XLabel::class)->findBy(array('ownerIp' => $ip));

        foreach ($labels as $label){
            $this->entityManager->remove($label);
        }
        $this->entityManager->flush();
    }
}