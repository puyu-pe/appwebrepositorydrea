<?php

use App\Http\Controllers\Backoffice\GeneralController as BackGeneralOffice;
use App\Http\Controllers\Backoffice\UserController as BackUserController;
use App\Http\Controllers\Backoffice\DirectionController as BackDirectionController;
use App\Http\Controllers\Backoffice\GradeController as BackGradeController;
use App\Http\Controllers\Backoffice\SubjectController as BackSubjectController;
use App\Http\Controllers\Backoffice\ContactController as BackContactController;
use App\Http\Controllers\Backoffice\TypeExamController as BackTypeExamController;
use App\Http\Controllers\Backoffice\ExamController as BackExamController;
use App\Http\Controllers\Backoffice\AnswerController as BackAnswerController;
use App\Http\Controllers\Backoffice\ResourceController as BackResourceController;

use App\Http\Controllers\Frontoffice\GeneralController as FrontGeneralOffice;
use App\Http\Controllers\Frontoffice\UserController as FrontUserController;
use App\Http\Controllers\Frontoffice\ContactController as FrontContactController;
use App\Http\Controllers\Frontoffice\TypeExamController as FrontTypeExamController;
use App\Http\Controllers\Frontoffice\ExamController as FrontExamController;
use App\Http\Controllers\Frontoffice\ExamRatingController as FrontExamRatingController;

use App\Http\Controllers\Backoffice\DownloadController;

use Illuminate\Support\Facades\Route;

Route::get('/',[FrontGeneralOffice::class, 'actionWelcome'])->middleware('GenericMiddleware:/');
Route::get('/',[FrontGeneralOffice::class, 'actionWelcome'])->middleware('GenericMiddleware:/');
Route::get('panel',[BackGeneralOffice::class, 'actionWelcomeDashboard'])->middleware('GenericMiddleware:panel');
Route::get('panel/totals',[BackGeneralOffice::class, 'actionGetExamTotals'])->middleware('GenericMiddleware:panel');
Route::get('panel/totalsBySubject',[BackGeneralOffice::class, 'actionGetExamTotalsBySubject'])->middleware('GenericMiddleware:panel');
Route::get('panel/topViewed',[BackGeneralOffice::class, 'actionGetTopMostViewed'])->middleware('GenericMiddleware:panel');
Route::get('panel/topQualified',[BackGeneralOffice::class, 'actionGetTopQualified'])->middleware('GenericMiddleware:panel');

Route::get('sistema/generarbackup',[BackGeneralOffice::class, 'actionBackupDatabase'])->middleware('GenericMiddleware:sistema/generarbackup');
Route::get('sistema/descargar',[BackGeneralOffice::class, 'actionDownloadExam'])->middleware('GenericMiddleware:sistema/descargar');

Route::match(['get','post'],'general/contacto',[FrontContactController::class,'actionInsert'])->middleware('GenericMiddleware:general/contacto');
Route::get('contacto/mostrar/{currentPage}',[BackContactController::class,'actionGetAll'])->middleware('GenericMiddleware:contacto/mostrar');
Route::post('contacto/responder',[BackContactController::class,'actionReply'])->middleware('GenericMiddleware:contacto/responder');

Route::get('usuario/mostrar/{currentPage}',[BackUserController::class,'actionGetAll'])->middleware('GenericMiddleware:usuario/mostrar');
Route::get('usuario/estado/{idUser}',[BackUserController::class,'actionChangeStatus'])->middleware('GenericMiddleware:usuario/estado');
Route::post('usuario/rol',[BackUserController::class, 'actionChangeRole'])->middleware('GenericMiddleware:usuario/rol');
Route::get('usuario/salir',[BackUserController::class,'actionLogout'])->middleware('GenericMiddleware:usuario/salir');
Route::get('usuario/eliminar/{idUser}',[BackUserController::class, 'actionDelete'])->middleware('GenericMiddleware:usuario/eliminar');
Route::match(['get','post'],'usuario/acceder',[FrontUserController::class,'actionLogin'])->middleware('GenericMiddleware:usuario/acceder');
Route::match(['get','post'],'usuario/registrar',[FrontUserController::class,'actionRegister'])->middleware('GenericMiddleware:usuario/registrar');
Route::match(['get', 'post'], 'usuario/editar',[FrontUserController::class, 'actionEdit'])->middleware('GenericMiddleware:usuario/editar');
Route::post('usuario/cambiar',[FrontUserController::class, 'actionChange'])->middleware('GenericMiddleware:usuario/cambiar');
Route::match(['get','post'],'usuario/recuperar',[FrontUserController::class,'actionRecuperate'])->middleware('GenericMiddleware:usuario/recuperar');
Route::match(['get','post'],'usuario/resetear/{token}',[FrontUserController::class,'actionReset'])->middleware('GenericMiddleware:usuario/resetear');

Route::get('tipoexamen/mostrar/{currentPage}',[BackTypeExamController::class,'actionGetAll'])->middleware('GenericMiddleware:tipoexamen/mostrar');
Route::match(['get', 'post'], 'tipoexamen/insertar',[BackTypeExamController::class,'actionInsert'])->middleware('GenericMiddleware:tipoexamen/insertar');
Route::post('tipoexamen/editar',[BackTypeExamController::class,'actionEdit'])->middleware('GenericMiddleware:tipoexamen/editar');
Route::get('tipoexamen/eliminar/{idTypeExam}',[BackTypeExamController::class,'actionDelete'])->middleware('GenericMiddleware:tipoexamen/eliminar');

Route::get('tipoexamen/{acronymTypeExam}/{currentPage}',[FrontTypeExamController::class,'actionViewTypeExam'])->middleware('GenericMiddleware:tipoexamen/acroninmo');

Route::get('curso/mostrar/{currentPage}',[BackSubjectController::class,'actionGetAll'])->middleware('GenericMiddleware:curso/mostrar');
Route::match(['get', 'post'], 'curso/insertar',[BackSubjectController::class,'actionInsert'])->middleware('GenericMiddleware:curso/insertar');
Route::post('curso/editar',[BackSubjectController::class,'actionEdit'])->middleware('GenericMiddleware:curso/editar');
Route::get('curso/eliminar/{idSubject}',[BackSubjectController::class,'actionDelete'])->middleware('GenericMiddleware:curso/eliminar');

Route::get('grado/mostrar/{currentPage}',[BackGradeController::class,'actionGetAll'])->middleware('GenericMiddleware:grado/mostrar');
Route::match(['get', 'post'], 'grado/insertar',[BackGradeController::class,'actionInsert'])->middleware('GenericMiddleware:grado/insertar');
Route::post('grado/editar',[BackGradeController::class,'actionEdit'])->middleware('GenericMiddleware:grado/editar');
Route::get('grado/eliminar/{idSubject}',[BackGradeController::class,'actionDelete'])->middleware('GenericMiddleware:grado/eliminar');

Route::get('direccion/mostrar/{currentPage}',[BackDirectionController::class,'actionGetAll'])->middleware('GenericMiddleware:direccion/mostrar');
Route::match(['get', 'post'], 'direccion/insertar',[BackDirectionController::class,'actionInsert'])->middleware('GenericMiddleware:direccion/insertar');
Route::post('direccion/editar',[BackDirectionController::class,'actionEdit'])->middleware('GenericMiddleware:direccion/editar');
Route::get('direccion/eliminar/{idSubject}',[BackDirectionController::class,'actionDelete'])->middleware('GenericMiddleware:direccion/eliminar');

Route::get('examen/mostrar/{currentPage}',[BackExamController::class,'actionGetAll'])->middleware('GenericMiddleware:examen/mostrar');
Route::match(['get', 'post'], 'examen/insertar',[BackExamController::class,'actionInsert'])->middleware('GenericMiddleware:examen/insertar');
Route::post('examen/editar',[BackExamController::class,'actionEdit'])->middleware('GenericMiddleware:examen/editar');
Route::get('examen/eliminar/{idExam}',[BackExamController::class,'actionDelete'])->middleware('GenericMiddleware:examen/eliminar');
Route::get('examen/verarchivo/{idExam}',[BackExamController::class,'actionViewExam'])->middleware('GenericMiddleware:examen/verarchivo');
Route::get('examen/estado/{idUser}',[BackExamController::class,'actionChangeState'])->middleware('GenericMiddleware:examen/estado');
Route::get('examen/ver/{codeExam}',[FrontExamController::class,'actionGetExam'])->middleware('GenericMiddleware:examen/ver');
Route::post('examen/calificar',[FrontExamRatingController::class,'actionInsert'])->middleware('GenericMiddleware:examen/calificar');

Route::post('download/selected', [DownloadController::class, 'packZipFile'])->name('GenericMiddleware:download/selected');
Route::any('download/zip/{filename}', [DownloadController::class, 'downloadZipFile'])->name('GenericMiddleware:download/zip');

Route::post('respuesta/insertar',[BackAnswerController::class,'actionInsert'])->middleware('GenericMiddleware:respuesta/insertar');

Route::post('recurso/insertar',[BackResourceController::class,'actionInsert'])->middleware('GenericMiddleware:recurso/insertar');
Route::get('recurso/eliminar/{idResource}',[BackResourceController::class,'actionDelete'])->middleware('GenericMiddleware:recurso/eliminar');
Route::get('recurso/verarchivo/{idResource}',[BackResourceController::class,'actionViewResource'])->middleware('GenericMiddleware:recurso/verarchivo');
