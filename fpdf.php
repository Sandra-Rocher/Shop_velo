<?php


//Il faut require le dossier fpdf185 téléchargé par zip, et ouvert ici dans notre dossier, pour pouvoir l'appeler
//fpdf.php fait 2000 lignes : il pré_définis tout le pdf
require('fpdf/fpdf.php');


//Petit calcul pour la TVA plus bas
$sum = $details[0]["prix_ttc"] - $details[0]["prix_ht"];

//Transforme la date au format jour/mois/année
$date = date_create($details[0]['dateFact']);
$date_fact = date_format($date, 'd/m/Y');


//A appeller ou pas, il cuztomise en dur la facture
class PDF extends FPDF
{

// En-tête
    function Header()
    {

        //Titre : SetTitle(string title [, boolean isUTF8]) 
        //Indique si la chaîne est encodée en ISO-8859-1 (false) ou en UTF-8 (true). Valeur par défaut : false.
        $this->SetTitle('La pedale Joyeuse');
    }


    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
         $this->SetY(-15);

        // Police Arial italique 8
        //Font family = arial, b = gras (chaîne vide : normal, i = italique, u = souligné) font size = 8
         $this->SetFont('Arial','I',8);

        //Numéro de page
         //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
         //Texte divers
        $this->Cell(0,5,'Retour et échange des produits neufs, non utilisés, sous 15 jours, plus d\'informations sur www.la-pedale-joyeuse.com',0,1,'C');
        $this->Cell(0,5,'Merci pour votre visite',0,1,'C');
    }
}


$pdf = new PDF('P','mm','A4');
//Addpage = (obligatoire), ajoute une nouvelle page au document.
$pdf->AddPage();
//Détermine la taille et la police avant de l'afficher en dessous dans une cell
$pdf->SetFont('Arial','B',17);
//Couleur du titre : rouge
$pdf->SetTextColor(255,0,0);
//Couleur du contour du rectangle : rouge
$pdf->SetDrawColor(220, 53, 69);
//Trace le rectangle (autour de la société) : abcisse coin sup gauche, ordonnée coin sup gauche, largeur, hauteur
$pdf->Rect(8, 8 ,95, 55,);
$pdf->Cell(90,10,'La Pédale Joyeuse', 0, 0);
//Remet la couleur noire aux reste du texte jusqu'au prochain SetTextColor
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',11);

$pdf->Cell(100,10,'Facture N°'.$details[0]['idFact'], 0, 1, 'R');
$pdf->Cell(190,10,'Date : '.$date_fact, 0, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,8,'Adresse : 3 rue des cyclistes 13100 Aix En Provence', 0, 0);
$pdf->Cell(90,8,'Vendeur : '.$details[0]['personnelPrenom'], 0, 1, 'R');

$pdf->Cell(50,8,'Tel : 04 94 25 47 89', 0, 1);
$pdf->Cell(50,8,'Email : pdj@gmail.fr', 0, 1);
$pdf->Cell(50,8,'Siret : 478 9654 785 12', 0, 1);

$pdf->Ln(15);

$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(255,0,0);
//Trace le rectangle (autour du client) : abcisse coin sup gauche, ordonnée coin sup gauche, largeur, hauteur
$pdf->Rect(120, 75 ,85, 55,);
$pdf->Cell(190,10,'Client :', 0, 1, 'R');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,8,''.$details[0]['nom'].' '.$details[0]['clientPrenom'], 0, 1, 'R');
$pdf->Cell(190,8,'Adresse : '.$details[0]['adresse1'].' '.$details[0]['adresse2'], 0, 1, 'R');
$pdf->Cell(190,8,'CP/Ville : '.$details[0]['code_postal'].' '.$details[0]['ville'], 0, 1, 'R');
$pdf->Cell(190,8,'Telephone : '.$details[0]['telephone'], 0, 1, 'R');
$pdf->Cell(190,8,'Email : '.$details[0]['email'], 0, 1, 'R');

$pdf->Ln(15);

//Color en rouge la cellule
$pdf->SetFillColor(220, 53, 69);
//Color en rouge le contour de la cellule ou je dirais true sur $fill pour qu'elle s'affiche
$pdf->SetDrawColor(220, 53, 69);
$pdf->Cell(30, 10, 'Référence', 1, 0, 'C', true);
$pdf->Cell(90, 10, 'Désignation', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Quantité', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Prix unitaire HT', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'TVA', 1, 1, 'C', true);

//Boucle pour le détail de chaque lignes de la facture si plusieurs articles
foreach ($details as $detail) {
    $pdf->Cell(30, 10, $detail['reference'], 1, 0, 'C');
    $pdf->Cell(90, 10, $detail['designation'], 1, 0, 'C');
    $pdf->Cell(20, 10, $detail['quantite'], 1, 0, 'C');
    $pdf->Cell(30, 10, ''.$detail['price_ht'].' €', 1, 0, 'C');
    $pdf->Cell(20, 10, ''.(($detail['id_tva']*100)-100).' %', 1, 1, 'C');
 }

$pdf->Ln(25);

$pdf->Cell(140, 10, '', 0, 0, 'C');
$pdf->Cell(25, 10, 'Total HT', 1, 0, 'C');
$pdf->Cell(25, 10, ''.$details[0]["prix_ht"].' €', 1, 1, 'C');

$pdf->Cell(140, 10, '', 0, 0, 'C');
$pdf->Cell(25, 10, 'Total TVA', 1, 0, 'C');
$pdf->Cell(25, 10, ''.$sum.' €', 1, 1, 'C');

$pdf->Cell(140, 10, '', 0, 0, 'C');
$pdf->Cell(25, 10, 'Total TTC', 1, 0, 'C');
$pdf->Cell(25, 10, ''.$details[0]["prix_ttc"].' €', 1, 1, 'C');


//Création du Nom du fichier
$nom = 'Facture-'.$details[0]['idFact'].'-'.$details[0]['nom'].'-'.$details[0]['clientPrenom'].'.pdf';
//Envoie le document : Création du pdf
$pdf->Output($nom, 'I');


?>