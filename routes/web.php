<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AproposController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Newsletter\NewsletterController;
use App\Http\Controllers\CompagnieController;
use App\Http\Controllers\InformationsController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ConsulterReservationController;
use App\Http\Controllers\AdministrateurController;

use App\Http\Controllers\PointVenteController;
use App\Http\Controllers\PointVenteCinetPayController;
use App\Http\Controllers\PointVenteCinetPayCallbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Routage d'accueil / Résultat / Départ du jour / Connexion
Route::get('/', [AccueilController::class, 'welcome'])->name('welcome');
Route::get('/accueil', [AccueilController::class, 'accueil'])->name('accueil');
Route::get('/se-connecter', [AccueilController::class, 'SeConnecter'])->name('seconnecter');

//Routage de contact
Route::get('/nous-contactez', [ContactController::class, 'contact'])->name('contact');
Route::post('/envoi-email', [ContactController::class, 'envoiemail'])->name('envoiemail');

//Routage à propos
Route::get('/notre-entreprise', [AproposController::class, 'Apropos'])->name('apropos');

//Routage de newsletter
Route::post('/envoi-newsletter', [NewsletterController::class, 'newslettersend'])->name('newslettersend');

//Routage des informations
Route::get('/comment-reserver-son-ticket', [InformationsController::class, 'CommentReserverserTicket'])->name('comment.reserver');

//Routage d'inscription
Route::get('/devenir-distributeur-agree',[InscriptionController::class, 'Inscription'])->name('register.distributeur');

//Consultation des réservations
Route::get('/consulter-ma-reservation',[ConsulterReservationController::class, 'ConsulterReservation'])->name('consulter.reservation');
Route::get('/ma-reservation',[ConsulterReservationController::class, 'Consultation'])->name('consulter.resultat');
Route::get('/imprimer-ticket/{facture_id}',[ConsulterReservationController::class, 'ImprimerTicket'])->name('imprimer.ticket');

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

//Routage des points de vente
Route::get('/point-de-vente/reserver-un-ticket',[PointVenteController::class, 'ReserverTicket'])->name('pointvente.reserver.ticket');
Route::get('/point-de-vente/reserver-un-ticket/resultat-recherche',[PointVenteController::class, 'ResultatRechercheVoyage'])->name('pointvente.resultat.recherche');
Route::get('/point-de-vente/reservation/{depart_id}-{depart}',[PointVenteController::class, 'FaireReservation'])->name('pointvente.reservation');
Route::get('/point-de-vente/liste-des-tickets', [PointVenteController::class, 'ListeReservation'])->name('pointvente.reservations');
Route::get('/point-de-vente/modifier-mon-compte', [PointVenteController::class, 'ModifierMonCompte'])->name('modifier.compte');
Route::post('/save-modifier-compte', [PointVenteController::class, 'SaveModifierMonCompte'])->name('save.modifier.compte');
Route::get('/point-de-vente/changer-mot-de-passe', [PointVenteController::class, 'ChangerMotePasse'])->name('changer.motpasse');
Route::post('/change-password', [PointVenteController::class, 'SaveChangerMotePasse'])->name('save.change.motpasse');
Route::get('/point-de-vente/message', [PointVenteController::class, 'Message'])->name('message');
Route::post('/point-de-vente/annuler-reservation/{facture_id}', [PointVenteController::class, 'AnnulerReservation'])->name('annuler.reservation');
Route::post('/initierpaiementcinetpay', [PointVenteCinetPayController::class, 'initierPaiementCinetPay'])->name('initierPaiementCinetPay');
Route::post('/pointventenotify', [PointVenteCinetPayCallbackController::class, 'pointventenotify'])->name('pointventenotify');
Route::post('/pointventeretour', [PointVenteCinetPayCallbackController::class, 'pointventeretour'])->name('pointventeretour');
Route::get('/pointventepaiementaconfirmer', [PointVenteCinetPayCallbackController::class, 'PointVentePaiementAConfirmer'])->name('PointVentePaiementAConfirmer');
Route::get('/pointvente_paiement_reussie', [PointVenteCinetPayCallbackController::class, 'pointvente_paiement_reussie'])->name('pointvente_paiement_reussie');
Route::get('/pointvente_paiement_echoue', [PointVenteCinetPayCallbackController::class, 'pointvente_paiement_echoue'])->name('pointvente_paiement_echoue');
Route::post('/point-de-vente/ticket-export-excel', [PointVenteController::class, 'FactureExportExcel'])->name('pointvente.ticket-export.excel');
Route::post('/point-de-vente/ticket-export-pdf', [PointVenteController::class, 'FactureExportPDF'])->name('pointvente.ticket-export.pdf');


//Routage des compagnies
Route::get('compagnie/tickets-du-jours', [CompagnieController::class, 'TicketduJours'])->name('compagnie.tickets.jours');
Route::get('compagnie/historique-des-tickets', [CompagnieController::class, 'HistoriqueTickets'])->name('compagnie.historique.ticktes');
Route::get('compagnie/ticket-export-pdf', [CompagnieController::class, 'TicketduJoursExportPDF'])->name('compagnie.ticket-export.pdf');
Route::get('compagnie/ticket-export-excel', [CompagnieController::class, 'TicketduJoursExportExcel'])->name('compagnie.ticket-export.excel');
Route::post('compagnie/tickets-export-pdf', [CompagnieController::class, 'TicketExportPDF'])->name('compagnie.tickets-export.pdf');
Route::post('compagnie/tickets-export-excel', [CompagnieController::class, 'TicketExportExcel'])->name('compagnie.tickets-export.excel');





// Routage administrateur
Route::post('admin/save-compagnie', [AdministrateurController::class, 'SaveCompagnie'])->name('admin.save.compagnie');
Route::get('admin/gestion-des-compagnies', [AdministrateurController::class, 'ListeCompagnie'])->name('admin.liste.compagnie');
Route::get('admin/supprimer-compagnie/{compagnie_id}', [AdministrateurController::class, 'SupprimerCompagnie'])->name('admin.supprimer.compagnie');
Route::get('admin/details-compagnie/{compagnie_id}-{titre}', [AdministrateurController::class, 'DetailsCompagnie'])->name('admin.details.compagnie');
Route::post('admin/save-gare/{compagnie_id}', [AdministrateurController::class, 'SaveGare'])->name('admin.save.gare');
Route::get('admin/supprimer-gare/{gare_id}', [AdministrateurController::class, 'SupprimerGare'])->name('admin.supprimer.gare');
Route::post('admin/save-vehicule/{compagnie_id}', [AdministrateurController::class, 'SaveVehicule'])->name('admin.save.vehicule');
Route::get('admin/supprimer-vehicule/{vehicule_id}', [AdministrateurController::class, 'SupprimerVehicule'])->name('admin.supprimer.vehicule');


Route::get('admin/gestion-des-gares', [AdministrateurController::class, 'ListeGare'])->name('admin.liste.gare');
Route::post('admin/save-une-gare', [AdministrateurController::class, 'SaveGareCompagnie'])->name('admin.save.gare');
Route::get('admin/supprimer-gare/{gare_id}', [AdministrateurController::class, 'SupprimerGareCompagnie'])->name('admin.supprimer.gare');
Route::get('admin/gestion-des-vehicules', [AdministrateurController::class, 'ListeVehicule'])->name('admin.liste.vehicule');
Route::post('admin/save-une-vehicule', [AdministrateurController::class, 'SaveVehiculeCompagnie'])->name('admin.save.vehicule');
Route::get('admin/supprimer-vehicule/{vehicule_id}', [AdministrateurController::class, 'SupprimerVehiculeCompagnie'])->name('admin.supprimer.vehicule');
Route::get('admin/gestion-des-lignes', [AdministrateurController::class, 'ListeLigne'])->name('admin.liste.ligne');
Route::post('admin/save-une-ligne/{compagnie_id}', [AdministrateurController::class, 'SaveLigneCompagnie'])->name('admin.save.ligne');
Route::post('admin/modifier-une-ligne/{ligne_id}', [AdministrateurController::class, 'SaveModifierLigneCompagnie'])->name('admin.modifier.ligne');
Route::get('admin/supprimer-ligne/{ligne_id}', [AdministrateurController::class, 'SupprimerLigneCompagnie'])->name('admin.supprimer.ligne');



Route::get('admin/gestion-des-tarifs', [AdministrateurController::class, 'ListeTarif'])->name('admin.liste.tarif');
Route::post('admin/save-une-tarif', [AdministrateurController::class, 'SaveTarifCompagnie'])->name('admin.save.tarif');
Route::post('admin/modifier-une-tarif/{tarif_id}', [AdministrateurController::class, 'SaveModifierTarifCompagnie'])->name('admin.modifier.tarif');
Route::get('admin/supprimer-tarif/{tarif_id}', [AdministrateurController::class, 'SupprimerTarifCompagnie'])->name('admin.supprimer.tarif');







Route::get('admin/gestion-des-departs', [AdministrateurController::class, 'ListeDepart'])->name('admin.liste.depart');
Route::post('admin/save-une-depart', [AdministrateurController::class, 'SaveDepartCompagnie'])->name('admin.save.depart');
Route::post('admin/modifier-une-depart/{depart_id}', [AdministrateurController::class, 'SaveModifierDepartCompagnie'])->name('admin.modifier.depart');
Route::get('admin/supprimer-depart/{depart_id}', [AdministrateurController::class, 'SupprimerDepartCompagnie'])->name('admin.supprimer.depart');