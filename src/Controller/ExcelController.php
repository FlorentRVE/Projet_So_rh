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
    // ================ EXPORTATION DES DONNEES AU FORMAT XLSX ================

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

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Fonction');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Téléphone');
        $sheet->setCellValue('F1', 'Motif');
        $sheet->setCellValue('G1', 'Récupération');
        $sheet->setCellValue('H1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getFonction());
            $sheet->setCellValue('D'.$row, $attestation->getEmail());
            $sheet->setCellValue('E'.$row, $attestation->getTelephone());
            $sheet->setCellValue('F'.$row, $attestation->getMotif());
            $sheet->setCellValue('G'.$row, $attestation->getRecuperation());
            $sheet->setCellValue('H'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'attestation_employeur-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:J1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:J1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:J1')
            ->getFont()
            ->setSize(13)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:J1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Fonction');
        $sheet->setCellValue('D1', 'Numéro');
        $sheet->setCellValue('E1', 'Position');
        $sheet->setCellValue('F1', 'Voie');
        $sheet->setCellValue('G1', 'Commune');
        $sheet->setCellValue('H1', 'Code postal');
        $sheet->setCellValue('I1', 'Fait à');
        $sheet->setCellValue('J1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getFonction());
            $sheet->setCellValue('D'.$row, $attestation->getNumero());
            $sheet->setCellValue('E'.$row, $attestation->getPosition());
            $sheet->setCellValue('F'.$row, $attestation->getVoie());
            $sheet->setCellValue('G'.$row, $attestation->getCommune());
            $sheet->setCellValue('H'.$row, $attestation->getCommune()->getCodePostal());
            $sheet->setCellValue('I'.$row, $attestation->getFaitA());
            $sheet->setCellValue('J'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'changement_adresse-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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
            ->getStyle('A1:E1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:E1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:E1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:E1')
            ->getFont()
            ->setSize(13)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:E1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Fonction');
        $sheet->setCellValue('D1', 'Fait à');
        $sheet->setCellValue('E1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getFonction());
            $sheet->setCellValue('D'.$row, $attestation->getFaitA());
            $sheet->setCellValue('E'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'changement_compte-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Fonction');
        $sheet->setCellValue('D1', 'Montant accompte en chiffres');
        $sheet->setCellValue('E1', 'Montant accompte en lettres');
        $sheet->setCellValue('F1', 'Motif');
        $sheet->setCellValue('G1', 'Fait à');
        $sheet->setCellValue('H1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getFonction());
            $sheet->setCellValue('D'.$row, $attestation->getAccompteChiffre());
            $sheet->setCellValue('E'.$row, $attestation->getAccompteLettre());
            $sheet->setCellValue('F'.$row, $attestation->getMotif());
            $sheet->setCellValue('G'.$row, $attestation->getFaitA());
            $sheet->setCellValue('H'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'demande_accompte-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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
            ->getStyle('A1:K1')
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

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Fonction');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Téléphone');
        $sheet->setCellValue('F1', 'Motif');
        $sheet->setCellValue('G1', 'Récupération');
        $sheet->setCellValue('H1', 'Période du');
        $sheet->setCellValue('I1', 'Période au');
        $sheet->setCellValue('J1', 'Fait à');
        $sheet->setCellValue('K1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getFonction());
            $sheet->setCellValue('D'.$row, $attestation->getEmail());
            $sheet->setCellValue('E'.$row, $attestation->getTelephone());
            $sheet->setCellValue('F'.$row, $attestation->getMotif());
            $sheet->setCellValue('G'.$row, $attestation->getRecuperation());
            $sheet->setCellValue('H'.$row, $attestation->getDateDu()->format('m/Y'));
            $sheet->setCellValue('I'.$row, $attestation->getDateAu()->format('m/Y'));
            $sheet->setCellValue('J'.$row, $attestation->getFaitA());
            $sheet->setCellValue('K'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'demande_bulletin_salaire-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->setSize(13)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Téléphone');
        $sheet->setCellValue('E1', 'Question pour');
        $sheet->setCellValue('F1', 'Question');
        $sheet->setCellValue('G1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getEmail());
            $sheet->setCellValue('D'.$row, $attestation->getTelephone());
            $sheet->setCellValue('E'.$row, $attestation->getQuestionPour());
            $sheet->setCellValue('F'.$row, $attestation->getQuestion());
            $sheet->setCellValue('G'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'question_rh-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
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
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('0F172A')
        ;

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($columns as $column) {
            $spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($column)
                ->setWidth(25)
            ;
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF')
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->setBold(true)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFont()
            ->setSize(13)
        ;

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:G1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
        ;
        // ==========================

        $sheet->setCellValue('A1', 'Demandeur');
        $sheet->setCellValue('B1', 'Service');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Téléphone');
        $sheet->setCellValue('E1', 'Rendez-vous avec');
        $sheet->setCellValue('F1', 'Message');
        $sheet->setCellValue('G1', 'Fait le');

        $row = 2;
        foreach ($attestations as $attestation) {
            $sheet->setCellValue('A'.$row, $attestation->getDemandeur()->getUsername());
            $sheet->setCellValue('B'.$row, $attestation->getService());
            $sheet->setCellValue('C'.$row, $attestation->getEmail());
            $sheet->setCellValue('D'.$row, $attestation->getTelephone());
            $sheet->setCellValue('E'.$row, $attestation->getRdvAvec());
            $sheet->setCellValue('F'.$row, $attestation->getMessage());
            $sheet->setCellValue('G'.$row, $attestation->getFaitLe()->format('d-m-Y'));

            ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'rendez_vous_rh-'.date('d-m-Y-H-i-s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');

        $writer->save('php://output');
        exit;
    }
}
