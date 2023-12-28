<?php

namespace App\Controller;

use App\Repository\AttestationEmployeurRepository;
use App\Repository\ChangementAdresseRepository;
use App\Repository\ChangementCompteRepository;
use App\Repository\DemandeAccompteRepository;
use App\Repository\DemandeBulletinSalaireRepository;
use App\Repository\QuestionRHRepository;
use App\Repository\RendezVousRHRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/excel')]
class ExcelController extends AbstractController
{
    #[Route('/attestation_employeur', name: 'app_excel_attestation_employeur', methods: ['GET'])]
    public function excelExportAttestationEmployeur(Request $request, AttestationEmployeurRepository $ar): Response
    {
        
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Fonction');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Téléphone');
        $sheet->setCellValue('G1', 'Motif');
        $sheet->setCellValue('H1', 'Récupération');
        $sheet->setCellValue('I1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getFonction());
            $sheet->setCellValue('E'.$row, $attestation->getEmail());
            $sheet->setCellValue('F'.$row, $attestation->getTelephone());
            $sheet->setCellValue('G'.$row, $attestation->getMotif());
            $sheet->setCellValue('H'.$row, $attestation->getRecuperation());
            $sheet->setCellValue('I'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'attestation_employeur-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/changement_adresse', name: 'app_excel_changement_adresse', methods: ['GET'])]
    public function excelExportChangementAdresse(Request $request, ChangementAdresseRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:J1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:K1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:K1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:K1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:K1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Fonction');
        $sheet->setCellValue('E1', 'Numéro');
        $sheet->setCellValue('F1', 'Position');
        $sheet->setCellValue('G1', 'Voie');
        $sheet->setCellValue('H1', 'Commune');
        $sheet->setCellValue('I1', 'Code postal');
        $sheet->setCellValue('J1', 'Fait à');
        $sheet->setCellValue('K1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getFonction());
            $sheet->setCellValue('E'.$row, $attestation->getNumero());
            $sheet->setCellValue('F'.$row, $attestation->getPosition());
            $sheet->setCellValue('G'.$row, $attestation->getVoie());
            $sheet->setCellValue('H'.$row, $attestation->getCommune());
            $sheet->setCellValue('I'.$row, $attestation->getCommune()->getCodePostal());
            $sheet->setCellValue('J'.$row, $attestation->getFaitA());
            $sheet->setCellValue('K'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'changement_adresse-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/changement_compte', name: 'app_excel_changement_compte', methods: ['GET'])]
    public function excelExportChangementCompte(Request $request, ChangementCompteRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:F1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:F1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:F1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:F1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:F1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Fonction');
        $sheet->setCellValue('E1', 'Fait à');
        $sheet->setCellValue('F1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getFonction());
            $sheet->setCellValue('E'.$row, $attestation->getFaitA());
            $sheet->setCellValue('F'.$row, $attestation->getFaitLe());

        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'changement_compte-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/demande_accompte', name: 'app_excel_demande_accompte', methods: ['GET'])]
    public function excelExportDemandeAccompte(Request $request, DemandeAccompteRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:I1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Fonction');
        $sheet->setCellValue('E1', 'Montant accompte en chiffres');
        $sheet->setCellValue('F1', 'Montant accompte en lettres');
        $sheet->setCellValue('G1', 'Motif');
        $sheet->setCellValue('H1', 'Fait à');
        $sheet->setCellValue('I1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getFonction());
            $sheet->setCellValue('E'.$row, $attestation->getAccompteChiffre());
            $sheet->setCellValue('F'.$row, $attestation->getAccompteLettre());
            $sheet->setCellValue('G'.$row, $attestation->getMotif());
            $sheet->setCellValue('H'.$row, $attestation->getFaitA());
            $sheet->setCellValue('I'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'demande_accompte-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/demande_bulletin_salaire', name: 'app_excel_demande_bulletin_salaire', methods: ['GET'])]
    public function excelExportDemandeBulletinSalaire(Request $request, DemandeBulletinSalaireRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:L1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:L1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:L1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:L1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:L1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Fonction');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Téléphone');
        $sheet->setCellValue('G1', 'Motif');
        $sheet->setCellValue('H1', 'Récupération');
        $sheet->setCellValue('I1', 'Période du');
        $sheet->setCellValue('J1', 'Période au');
        $sheet->setCellValue('K1', 'Fait à');
        $sheet->setCellValue('L1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getFonction());
            $sheet->setCellValue('E'.$row, $attestation->getEmail());
            $sheet->setCellValue('F'.$row, $attestation->getTelephone());
            $sheet->setCellValue('G'.$row, $attestation->getMotif());
            $sheet->setCellValue('H'.$row, $attestation->getRecuperation());
            $sheet->setCellValue('I'.$row, $attestation->getDateDu());
            $sheet->setCellValue('J'.$row, $attestation->getDateAu());
            $sheet->setCellValue('K'.$row, $attestation->getFaitA());
            $sheet->setCellValue('L'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'demande_bulletin_salaire-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/question_rh', name: 'app_excel_question_rh', methods: ['GET'])]
    public function excelExportQuestionRh(Request $request, QuestionRHRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Téléphone');
        $sheet->setCellValue('F1', 'Question pour');
        $sheet->setCellValue('G1', 'Question');
        $sheet->setCellValue('H1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getEmail());
            $sheet->setCellValue('E'.$row, $attestation->getTelephone());
            $sheet->setCellValue('F'.$row, $attestation->getQuestionPour());
            $sheet->setCellValue('G'.$row, $attestation->getQuestion());
            $sheet->setCellValue('H'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'question_rh-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }

    #[Route('/rendez_vous_rh', name: 'app_excel_rendez_vous_rh', methods: ['GET'])]
    public function excelExportRendezVousRh(Request $request, RendezVousRHRepository $ar): Response
    {
        $searchTerm = $request->query->get('searchTerm');
        $attestations = $ar->getDataFromSearch($searchTerm);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ======= STYLING ============
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }
    
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFont()
            ->setSize(13)
        ;
        
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:H1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Service');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Téléphone');
        $sheet->setCellValue('F1', 'Rendez-vous avec');
        $sheet->setCellValue('G1', 'Message');
        $sheet->setCellValue('H1', 'Fait le');

        $row=2;
        foreach ($attestations as $attestation) {

            $sheet->setCellValue('A'.$row, $attestation->getNom());
            $sheet->setCellValue('B'.$row, $attestation->getPrenom());
            $sheet->setCellValue('C'.$row, $attestation->getService());
            $sheet->setCellValue('D'.$row, $attestation->getEmail());
            $sheet->setCellValue('E'.$row, $attestation->getTelephone());
            $sheet->setCellValue('F'.$row, $attestation->getRdvAvec());
            $sheet->setCellValue('G'.$row, $attestation->getMessage());
            $sheet->setCellValue('H'.$row, $attestation->getFaitLe());
        
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'rendez_vous_rh-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');

        $writer->save('php://output');
        exit();

    }
}



