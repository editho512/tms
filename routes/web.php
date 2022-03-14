<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// --------------------- TARIFS --------------------//
// -------------------- RESERVATIONS -------------- //

Route::get('/reservation', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservation');

Route::post('/reservation/accept/{reservation}', [App\Http\Controllers\ReservationController::class, 'accept'])->name('reservation.accept');

Route::get('/reservation/reject/{reservation}', [App\Http\Controllers\ReservationController::class, 'reject'])->name('reservation.reject');

Route::get('/reservation/livrer/{reservation}', [App\Http\Controllers\ReservationController::class, 'livrer'])->name('reservation.livrer');

Route::get('/reservation/voir/{reservation}', [App\Http\Controllers\ReservationController::class, 'voir'])->name('reservation.voir');



// -------------------- RESERVATIONS -------------- //

// --------------------- TARIFS --------------------//
Route::post('/Tarif/enregistrer-tarif', [App\Http\Controllers\TarifController::class, 'enregistrerTarif'])->name('transporteur.tarif.save');

Route::post('/Tarif/categorie/ajouter/{categorie}', [App\Http\Controllers\TarifController::class, 'ajouterCategorie'])->name('tarif.categorie.ajouter');

Route::get('/Tarif/categorie/trouver/{categorie}', [App\Http\Controllers\TarifController::class, 'trouverCategorie'])->name('tarif.categorie.trouver');

Route::get('/Tarif/voir/{ZoneTransporteur}', [App\Http\Controllers\TarifController::class, 'voirZoneTransporteur'])->name('tarif.voir');

Route::get('/Tarif/supprimer/{ZoneTransporteur}', [App\Http\Controllers\TarifController::class, 'supprimer'])->name('tarif.supprimer');

Route::get('/Tarif/modifier/{ZoneTransporteur}', [App\Http\Controllers\TarifController::class, 'modifier'])->name('tarif.modifier');

Route::post('/Tarif/ajouter', [App\Http\Controllers\TarifController::class, 'ajouter'])->name('tarif.ajouter');

Route::get('/Tarif', [App\Http\Controllers\TarifController::class, 'index'])->name('tarif');

Route::get('/trajet-search', [App\Http\Controllers\TarifController::class, 'trajetSearch'])->name('trajet.search');


// --------------------- TARIFS --------------------//

// --------------------- ZONE DE TRAVAIL -----------//
Route::get('/Zone-travail/categorie/supprimer/{departCategorie}', [App\Http\Controllers\ZoneController::class, 'supprimerCategorie'])->name('zone.categorie.supprimer');

Route::post('/Zone-travail/categorie/modifier/{departCategorie}', [App\Http\Controllers\ZoneController::class, 'modifierCategorie'])->name('zone.categorie.modifier');

Route::get('/Zone-travail/categorie/trouver/{departCategorie}', [App\Http\Controllers\ZoneController::class, 'trouverItineraire'])->name('zone.categorie.trouver');

Route::post('/Zone-travail/categorie/ajouter', [App\Http\Controllers\ZoneController::class, 'ajouterCategorie'])->name('zone.categorie.ajouter');

Route::get('/Zone-travail/voir/{zone}', [App\Http\Controllers\ZoneController::class, 'voirZone'])->name('zone.voir');

Route::get('/Zone-travail/supprimer/{zone}', [App\Http\Controllers\ZoneController::class, 'supprimer'])->name('zone.supprimer');

Route::post('/Zone-travail/edit/{zone}', [App\Http\Controllers\ZoneController::class, 'edit'])->name('zone.edit');

Route::get('/Zone-travail/modifier/{zone}', [App\Http\Controllers\ZoneController::class, 'modifier'])->name('zone.modifier');

Route::post('/Zone-travail/ajouter', [App\Http\Controllers\ZoneController::class, 'ajouter'])->name('zone.ajouter');

Route::get('/Zone-travail', [App\Http\Controllers\ZoneController::class, 'index'])->name('zone');


// --------------------- ZONE DE TRAVAIL -----------//

// Route pour les clients

Route::prefix('client')->group(function() {

    // Page de recherche de transport
    Route::get('/', [ClientController::class, 'search'])->name('client.search');

    // Faire un recherche sql dans la base de données pour afficher les transporteurs disponibles
    Route::post('/',[ClientController::class, 'postSearch'])->name('client.post.search');

    // Gerer la listes des villes pour que le client puisse facilement les selectionner
    Route::post('/do-search', [ClientController::class, 'doSearch'])->name('client.do-search');

    Route::get('/mes-historiques-transport', [ClientController::class, 'historique'])->name('client.transport.history');

    Route::post('/reserver', [ReservationController::class, 'reserver'])->name('client.reserver');

    Route::post('/update-reservation/{reservation}', [ReservationController::class, 'updateReservation'])->name('client.reservation.update');

    Route::get('/annuler-reservation/{reservation}', [ClientController::class, 'annulerReservation'])->name('client.reservation.annuler');

});


// --------------------- CARBURANTS ---------------//

Route::get('/Carburant/delete/{carburant}/{type?}',  [App\Http\Controllers\CarburantController::class, 'delete'])->name("carburant.delete");

Route::patch('/Carburant/update/{carburant}', [App\Http\Controllers\CarburantController::class, 'update'])->name('carburant.update');

Route::get('/Carburant/modifier/{carburant}', [App\Http\Controllers\CarburantController::class, 'modifier'])->name('carburant.modifier');

Route::post('/Carburant/ajouter', [App\Http\Controllers\CarburantController::class, 'add'])->name('carburant.ajouter');


//----------------------- TRAJETS -----------------//

Route::prefix('trajet')->group(function() {

    Route::get('/delete/{trajet}/{type?}',  [App\Http\Controllers\TrajetController::class, 'delete'])->name("trajet.delete");

    Route::patch('/update/{trajet}', [App\Http\Controllers\TrajetController::class, 'update'])->name('trajet.update');

    Route::get('/modifier/{trajet}', [App\Http\Controllers\TrajetController::class, 'modifier'])->name('trajet.modifier');

    Route::post('/ajouter', [App\Http\Controllers\TrajetController::class, 'add'])->name('trajet.ajouter');

    Route::get('/voir/{trajet}',  [App\Http\Controllers\TrajetController::class, 'voir'])->name("trajet.voir");

    Route::get('/supprimer/{trajet}',  [App\Http\Controllers\TrajetController::class, 'supprimer'])->name("trajet.supprimer");

});

// ---------------------- CHAUFFEURS ------------- //

Route::get('/Chauffeur/delete/{chauffeur}/{type?}',  [App\Http\Controllers\ChauffeurController::class, 'delete'])->name("chauffeur.delete");

Route::patch('/Chauffeur/update/{chauffeur}', [App\Http\Controllers\ChauffeurController::class, 'update'])->name('chauffeur.update');

Route::get('/Chauffeur/modifier/{chauffeur}', [App\Http\Controllers\ChauffeurController::class, 'modifier'])->name('chauffeur.modifier');

Route::post('/Chauffeur/ajouter', [App\Http\Controllers\ChauffeurController::class, 'add'])->name('chauffeur.ajouter');

Route::get('/Chauffeur', [App\Http\Controllers\ChauffeurController::class, 'index'])->name('chauffeur.liste');


// --------------------- CAMIONS -----------------//
Route::get('/Camion', [App\Http\Controllers\CamionController::class, 'index'])->name('camion.liste');

Route::middleware(['admin'])->group(function () {
    //
    Route::get('/Camion/voir/{camion}/{tab?}',  [App\Http\Controllers\CamionController::class, 'voir'])->name("camion.voir");

    Route::get('/Camion/delete/{camion}/{type?}',  [App\Http\Controllers\CamionController::class, 'delete'])->name("camion.delete");

    Route::get('/Camion/supprimer/{camion}',  [App\Http\Controllers\CamionController::class, 'supprimer'])->name("camion.supprimer");

    Route::patch('/Camion/update/{camion}', [App\Http\Controllers\CamionController::class, 'update'])->name('camion.update');

    Route::get('/Camion/modifier/{camion}', [App\Http\Controllers\CamionController::class, 'modifier'])->name('camion.modifier');

    Route::post('/Camion/ajouter', [App\Http\Controllers\CamionController::class, 'add'])->name('camion.ajouter');
});





// --------------------- UTILISATEUR -------------//

Route::prefix('Utilisateur')->middleware('super-admin')->group(function () {

    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('utilisateur.liste');

    Route::delete('/delete/{user}', [App\Http\Controllers\UserController::class, 'delete'])->name('utilisateur.delete');

    Route::patch('/update/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('utilisateur.update');

    Route::get('/afficher/{user}', [App\Http\Controllers\UserController::class, 'afficher'])->name('utilisateur.afficher');

    Route::post('/ajouter', [App\Http\Controllers\UserController::class, 'add'])->name('utilisateur.ajouter');

});

// --------------------- UTILISATEUR -------------//
