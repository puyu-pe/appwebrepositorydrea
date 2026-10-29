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
use App\Http\Controllers\Backoffice\TestimonyController as BackTestimonyController;

use App\Http\Controllers\Frontoffice\GeneralController as FrontGeneralOffice;
use App\Http\Controllers\Frontoffice\UserController as FrontUserController;
use App\Http\Controllers\Frontoffice\ContactController as FrontContactController;
use App\Http\Controllers\Frontoffice\TypeExamController as FrontTypeExamController;
use App\Http\Controllers\Frontoffice\ExamController as FrontExamController;
use App\Http\Controllers\Frontoffice\ExamRatingController as FrontExamRatingController;
use App\Http\Controllers\Frontoffice\SubjectController as FrontSubjectController;
use App\Http\Controllers\Frontoffice\GradeController as FrontGradeController;
use App\Http\Controllers\Frontoffice\AnswerController as FrontAnswerController;
use App\Http\Controllers\Frontoffice\TestimonyController as FrontTestimonyController;

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
Route::get('contacto/listar/{currentPage?}',[BackContactController::class,'actionGetAll'])->middleware('GenericMiddleware:contacto/listar');
Route::get('contacto/mostrar/{currentPage}', function($currentPage)
{
    return redirect('contacto/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:contacto/mostrar');
Route::post('contacto/responder',[BackContactController::class,'actionReply'])->middleware('GenericMiddleware:contacto/responder');
Route::match(['get', 'post'], 'contacto/eliminar/{idContact}',[BackContactController::class,'actionDelete'])->middleware('GenericMiddleware:contacto/eliminar');

Route::get('usuario/listar/{currentPage?}',[BackUserController::class,'actionGetAll'])->middleware('GenericMiddleware:usuario/listar');
Route::get('usuario/mostrar/{currentPage}', function($currentPage)
{
    return redirect('usuario/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:usuario/mostrar');
Route::match(['get', 'post'], 'usuario/estado/{idUser}',[BackUserController::class,'actionChangeStatus'])->middleware('GenericMiddleware:usuario/estado');
Route::post('usuario/rol',[BackUserController::class, 'actionChangeRole'])->middleware('GenericMiddleware:usuario/rol');
Route::get('usuario/salir',[BackUserController::class,'actionLogout'])->middleware('GenericMiddleware:usuario/salir');
Route::match(['get', 'post'], 'usuario/eliminar/{idUser}',[BackUserController::class, 'actionDelete'])->middleware('GenericMiddleware:usuario/eliminar');
Route::match(['get','post'],'usuario/acceder',[FrontUserController::class,'actionLogin'])->middleware('GenericMiddleware:usuario/acceder');
Route::match(['get','post'],'usuario/registrar',[FrontUserController::class,'actionRegister'])->middleware('GenericMiddleware:usuario/registrar');
Route::match(['get', 'post'], 'usuario/editar',[FrontUserController::class, 'actionEdit'])->middleware('GenericMiddleware:usuario/editar');
Route::post('usuario/cambiar',[FrontUserController::class, 'actionChange'])->middleware('GenericMiddleware:usuario/cambiar');
Route::match(['get','post'],'usuario/recuperar',[FrontUserController::class,'actionRecuperate'])->middleware('GenericMiddleware:usuario/recuperar');
Route::match(['get','post'],'usuario/resetear/{token}',[FrontUserController::class,'actionReset'])->middleware('GenericMiddleware:usuario/resetear');

Route::get('tipoexamen/listar/{currentPage?}',[BackTypeExamController::class,'actionGetAll'])->middleware('GenericMiddleware:tipoexamen/listar');
Route::get('tipoexamen/mostrar/{currentPage}', function($currentPage)
{
    return redirect('tipoexamen/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:tipoexamen/mostrar');
Route::match(['get', 'post'], 'tipoexamen/insertar',[BackTypeExamController::class,'actionInsert'])->middleware('GenericMiddleware:tipoexamen/insertar');
Route::post('tipoexamen/editar',[BackTypeExamController::class,'actionEdit'])->middleware('GenericMiddleware:tipoexamen/editar');
Route::match(['get', 'post'], 'tipoexamen/eliminar/{idTypeExam}',[BackTypeExamController::class,'actionDelete'])->middleware('GenericMiddleware:tipoexamen/eliminar');

Route::get('tipoexamen/{acronymTypeExam}/listar/{currentPage?}',[FrontTypeExamController::class,'actionViewTypeExam'])->middleware('GenericMiddleware:tipoexamen/acroninmo/listar');
Route::get('tipoexamen/{acronymTypeExam}/{currentPage}', function($acronymTypeExam, $currentPage)
{
    $queryString = request()->server->get('QUERY_STRING');
    return redirect('tipoexamen/'.$acronymTypeExam.'/listar'.($currentPage == 1 ? '' : '/'.$currentPage).($queryString ? '?'.$queryString : ''));
})->middleware('GenericMiddleware:tipoexamen/acroninmo');

Route::get('curso/listar/{currentPage?}',[BackSubjectController::class,'actionGetAll'])->middleware('GenericMiddleware:curso/listar');
Route::get('curso/mostrar/{currentPage}', function($currentPage)
{
    return redirect('curso/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:curso/mostrar');
Route::match(['get', 'post'], 'curso/insertar',[BackSubjectController::class,'actionInsert'])->middleware('GenericMiddleware:curso/insertar');
Route::post('curso/editar',[BackSubjectController::class,'actionEdit'])->middleware('GenericMiddleware:curso/editar');
Route::match(['get', 'post'], 'curso/eliminar/{idSubject}',[BackSubjectController::class,'actionDelete'])->middleware('GenericMiddleware:curso/eliminar');

Route::get('curso/{codeSubject}/listar/{currentPage?}',[FrontSubjectController::class,'actionViewSubject'])->middleware('GenericMiddleware:curso/codigo/listar');
Route::get('curso/{codeSubject}/{currentPage}', function($codeSubject, $currentPage)
{
    $queryString = request()->server->get('QUERY_STRING');
    return redirect('curso/'.$codeSubject.'/listar'.($currentPage == 1 ? '' : '/'.$currentPage).($queryString ? '?'.$queryString : ''));
})->middleware('GenericMiddleware:curso/codigo');

Route::get('grado/listar/{currentPage?}',[BackGradeController::class,'actionGetAll'])->middleware('GenericMiddleware:grado/listar');
Route::get('grado/mostrar/{currentPage}', function($currentPage)
{
    return redirect('grado/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:grado/mostrar');
Route::match(['get', 'post'], 'grado/insertar',[BackGradeController::class,'actionInsert'])->middleware('GenericMiddleware:grado/insertar');
Route::post('grado/editar',[BackGradeController::class,'actionEdit'])->middleware('GenericMiddleware:grado/editar');
Route::match(['get', 'post'], 'grado/eliminar/{idGrade}',[BackGradeController::class,'actionDelete'])->middleware('GenericMiddleware:grado/eliminar');

Route::get('grado/{codeGrade}/listar/{currentPage?}',[FrontGradeController::class,'actionViewGrade'])->middleware('GenericMiddleware:grado/codigo/listar');
Route::get('grado/{codeGrade}/{currentPage}', function($codeGrade, $currentPage)
{
    $queryString = request()->server->get('QUERY_STRING');
    return redirect('grado/'.$codeGrade.'/listar'.($currentPage == 1 ? '' : '/'.$currentPage).($queryString ? '?'.$queryString : ''));
})->middleware('GenericMiddleware:grado/codigo');

Route::get('direccion/listar/{currentPage?}',[BackDirectionController::class,'actionGetAll'])->middleware('GenericMiddleware:direccion/listar');
Route::get('direccion/mostrar/{currentPage}', function($currentPage)
{
    return redirect('direccion/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:direccion/mostrar');
Route::match(['get', 'post'], 'direccion/insertar',[BackDirectionController::class,'actionInsert'])->middleware('GenericMiddleware:direccion/insertar');
Route::post('direccion/editar',[BackDirectionController::class,'actionEdit'])->middleware('GenericMiddleware:direccion/editar');
Route::match(['get', 'post'], 'direccion/eliminar/{idSubject}',[BackDirectionController::class,'actionDelete'])->middleware('GenericMiddleware:direccion/eliminar');

Route::get('examen/listar/{currentPage?}',[BackExamController::class,'actionGetAll'])->middleware('GenericMiddleware:examen/listar');
Route::get('examen/mostrar/{currentPage}', function($currentPage)
{
    return redirect('examen/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:examen/mostrar');
Route::match(['get', 'post'], 'examen/insertar',[BackExamController::class,'actionInsert'])->middleware('GenericMiddleware:examen/insertar');
Route::post('examen/editar',[BackExamController::class,'actionEdit'])->middleware('GenericMiddleware:examen/editar');
Route::post('examen/eliminar/{idExam}',[BackExamController::class,'actionDelete'])->middleware('GenericMiddleware:examen/eliminar');
Route::get('examen/verarchivo/{idExam}',[BackExamController::class,'actionViewExam'])->middleware('GenericMiddleware:examen/verarchivo');
Route::post('examen/estado/{idExam}',[BackExamController::class,'actionChangeState'])->middleware('GenericMiddleware:examen/estado');
Route::get('examen/ver/{codeExam}',[FrontExamController::class,'actionGetExam'])->middleware('GenericMiddleware:examen/ver');
Route::post('examen/calificar',[FrontExamRatingController::class,'actionInsert'])->middleware('GenericMiddleware:examen/calificar');

Route::post('download/selected', [DownloadController::class, 'packZipFile'])->name('GenericMiddleware:download/selected');
Route::any('download/zip/{filename}', [DownloadController::class, 'downloadZipFile'])->name('GenericMiddleware:download/zip');

Route::post('respuesta/insertar',[BackAnswerController::class,'actionInsert'])->middleware('GenericMiddleware:respuesta/insertar');
Route::post('respuesta/registrar',[FrontAnswerController::class,'actionRegister'])->middleware('GenericMiddleware:respuesta/registrar');

Route::post('recurso/insertar',[BackResourceController::class,'actionInsert'])->middleware('GenericMiddleware:recurso/insertar');
Route::post('recurso/eliminar/{idResource}',[BackResourceController::class,'actionDelete'])->middleware('GenericMiddleware:recurso/eliminar');
Route::get('recurso/verarchivo/{idResource}',[BackResourceController::class,'actionViewResource'])->middleware('GenericMiddleware:recurso/verarchivo');

Route::match(['get','post'],'general/testimonio',[FrontTestimonyController::class,'actionInsert'])->middleware('GenericMiddleware:general/testimonio');
Route::get('testimonio/listar/{currentPage?}',[BackTestimonyController::class,'actionGetAll'])->middleware('GenericMiddleware:testimonio/listar');
Route::get('testimonio/mostrar/{currentPage}', function($currentPage)
{
    return redirect('testimonio/listar'.($currentPage == 1 ? '' : '/'.$currentPage).(request()->getQueryString() ? '?'.request()->getQueryString() : ''));
})->middleware('GenericMiddleware:testimonio/mostrar');
Route::match(['get', 'post'], 'testimonio/estado/{idTestimony}',[BackTestimonyController::class,'actionChangeState'])->middleware('GenericMiddleware:testimonio/estado');
Route::match(['get', 'post'], 'testimonio/eliminar/{idTestimony}',[BackTestimonyController::class,'actionDelete'])->middleware('GenericMiddleware:testimonio/eliminar');
Route::post('testimonio/editar',[BackTestimonyController::class,'actionEdit'])->middleware('GenericMiddleware:testimonio/editar');
