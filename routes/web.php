<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TypeExamController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::get('/',[GeneralController::class, 'actionWelcome'])->middleware('GenericMiddleware:/');
Route::get('panel',[GeneralController::class, 'actionWelcomeDashboard'])->middleware('GenericMiddleware:panel');
Route::get('sistema/generarbackup',[GeneralController::class, 'actionBackupDatabase'])->middleware('GenericMiddleware:sistema/generarbackup');
Route::get('sistema/descargar',[GeneralController::class, 'actionDownloadExam'])->middleware('GenericMiddleware:sistema/descargar');

Route::match(['get','post'],'general/contacto',[ContactController::class,'actionInsert'])->middleware('GenericMiddleware:general/contacto');
Route::get('contacto/mostrar/{currentPage}',[ContactController::class,'actionGetAll'])->middleware('GenericMiddleware:contacto/mostrar');

Route::match(['get','post'],'usuario/acceder',[UserController::class,'actionLogin'])->middleware('GenericMiddleware:usuario/acceder');
Route::get('usuario/salir',[UserController::class,'actionLogout'])->middleware('GenericMiddleware:usuario/salir');
Route::match(['get','post'],'usuario/insertar',[UserController::class,'actionInsert'])->middleware('GenericMiddleware:usuario/insertar');
Route::match(['get','post'],'usuario/registrar',[UserController::class,'actionRegister'])->middleware('GenericMiddleware:usuario/registrar');
Route::get('usuario/mostrar/{currentPage}',[UserController::class,'actionGetAll'])->middleware('GenericMiddleware:usuario/mostrar');
Route::match(['get', 'post'], 'usuario/editar',[UserController::class, 'actionEdit'])->middleware('GenericMiddleware:usuario/editar');
Route::post('usuario/cambiar',[UserController::class, 'actionChange'])->middleware('GenericMiddleware:usuario/cambiar');
Route::get('usuario/estado/{idUser}',[UserController::class,'actionChangeStatus'])->middleware('GenericMiddleware:usuario/estado');
Route::post('usuario/rol',[UserController::class, 'actionChangeRole'])->middleware('GenericMiddleware:usuario/rol');
Route::get('usuario/eliminar/{idUser}',[UserController::class, 'actionDelete'])->middleware('GenericMiddleware:usuario/eliminar');
Route::match(['get','post'],'usuario/recuperar',[UserController::class,'actionRecuperate'])->middleware('GenericMiddleware:usuario/recuperar');

Route::get('tipoexamen/mostrar/{currentPage}',[TypeExamController::class,'actionGetAll'])->middleware('GenericMiddleware:tipoexamen/mostrar');
Route::match(['get', 'post'], 'tipoexamen/insertar',[TypeExamController::class,'actionInsert'])->middleware('GenericMiddleware:tipoexamen/insertar');
Route::post('tipoexamen/editar',[TypeExamController::class,'actionEdit'])->middleware('GenericMiddleware:tipoexamen/editar');
Route::get('tipoexamen/eliminar/{idTypeExam}',[TypeExamController::class,'actionDelete'])->middleware('GenericMiddleware:tipoexamen/eliminar');
Route::get('tipoexamen/{acronymTypeExam}/{currentPage}',[TypeExamController::class,'actionViewTypeExam'])->middleware('GenericMiddleware:tipoexamen/acroninmo');

Route::get('curso/mostrar/{currentPage}',[SubjectController::class,'actionGetAll'])->middleware('GenericMiddleware:curso/mostrar');
Route::match(['get', 'post'], 'curso/insertar',[SubjectController::class,'actionInsert'])->middleware('GenericMiddleware:curso/insertar');
Route::post('curso/editar',[SubjectController::class,'actionEdit'])->middleware('GenericMiddleware:curso/editar');
Route::get('curso/eliminar/{idSubject}',[SubjectController::class,'actionDelete'])->middleware('GenericMiddleware:curso/eliminar');

Route::get('grado/mostrar/{currentPage}',[GradeController::class,'actionGetAll'])->middleware('GenericMiddleware:grado/mostrar');
Route::match(['get', 'post'], 'grado/insertar',[GradeController::class,'actionInsert'])->middleware('GenericMiddleware:grado/insertar');
Route::post('grado/editar',[GradeController::class,'actionEdit'])->middleware('GenericMiddleware:grado/editar');
Route::get('grado/eliminar/{idSubject}',[GradeController::class,'actionDelete'])->middleware('GenericMiddleware:grado/eliminar');

Route::get('direccion/mostrar/{currentPage}',[DirectionController::class,'actionGetAll'])->middleware('GenericMiddleware:direccion/mostrar');
Route::match(['get', 'post'], 'direccion/insertar',[DirectionController::class,'actionInsert'])->middleware('GenericMiddleware:direccion/insertar');
Route::post('direccion/editar',[DirectionController::class,'actionEdit'])->middleware('GenericMiddleware:direccion/editar');
Route::get('direccion/eliminar/{idSubject}',[DirectionController::class,'actionDelete'])->middleware('GenericMiddleware:direccion/eliminar');

Route::get('examen/mostrar/{currentPage}',[ExamController::class,'actionGetAll'])->middleware('GenericMiddleware:examen/mostrar');
Route::match(['get', 'post'], 'examen/insertar',[ExamController::class,'actionInsert'])->middleware('GenericMiddleware:examen/insertar');
Route::match(['get', 'post'], 'examen/registrar',[ExamController::class,'actionRegister'])->middleware('GenericMiddleware:examen/registrar');
Route::post('examen/editar',[ExamController::class,'actionEdit'])->middleware('GenericMiddleware:examen/editar');
Route::get('examen/eliminar/{idSubject}',[ExamController::class,'actionDelete'])->middleware('GenericMiddleware:examen/eliminar');
Route::get('examen/verarchivo/{idEgress}',[ExamController::class,'actionViewExam'])->middleware('GenericMiddleware:examen/verarchivo');
Route::get('examen/estado/{idUser}',[ExamController::class,'actionChangeState'])->middleware('GenericMiddleware:examen/estado');
Route::get('examen/ver/{codeExam}',[ExamController::class,'actionGetExam'])->middleware('GenericMiddleware:examen/ver');

//Route::match(['get','post'],'cuestionario/registrar',[QuestionController::class,'actionRegister'])->middleware('GenericMiddleware:cuestionario/registrar');

?>
