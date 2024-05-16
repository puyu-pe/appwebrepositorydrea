<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswer;
use App\Models\TDirection;
use App\Models\TDocument;
use App\Models\TResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TRole;
use App\Models\TSubject;
use App\Models\TTypeExam;
use App\Models\TUserExam;
use App\Validation\ExamValidation;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExamController extends Controller
{
	public function actionGetAll(Request $request, $currentPage)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		$status = stristr(session('roleUser'), TRole::ROLE['REGISTER']);
		$paginate = !$status ? PlatformHelper::preparePaginate(TExam::with(['tSubject', 'tGrade', 'tTypeExam'])
			->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam, yearExam, keywordExam, stateExam, number_question, numberEvaluation), ?, 77)=1', [$searchParameter])
			->orderby('created_at', 'desc'), 7, $currentPage) :
			PlatformHelper::preparePaginate(TExam::with(['tSubject', 'tGrade', 'tTypeExam'])
				->whereRaw('register_answer = ? AND stateExam = ?', [TExam::REGISTER_RESPONSE['YES'], TExam::STATUS['PUBLIC']])
				->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam, yearExam, keywordExam, stateExam, number_question, numberEvaluation), ?, 77)=1', [$searchParameter])
				->orderby('created_at', 'desc'), 7, $currentPage);

		return view(
			'backoffice/exam/getall',
			[
				'listTExam' => $paginate['listRow'],
				'currentPage' => $paginate['currentPage'],
				'quantityPage' => $paginate['quantityPage'],
				'searchParameter' => $searchParameter
			]
		);
	}

	public function actionInsert(Request $request)
	{
		if ($_POST) {
            try
            {
				DB::beginTransaction();

				$this->_so->mo->listMessage = (new ExamValidation())->validationInsert($request);

				if ($this->_so->mo->existsMessage()) {
					DB::rollBack();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/insertar');
				}

				$status = stristr(session('roleUser'), TRole::ROLE['ADMIN']) || stristr(session('roleUser'), TRole::ROLE['SUPERVISOR']);

				$tTypeExam = TTypeExam::find($request->input('selectTypeExam'));
				$tSubject = TSubject::find($request->input('selectSubject'));
				$tGrade = TGrade::find($request->input('selectGrade'));
				$tDirection = TDirection::find($request->input('selectDirectionExam'));
				$tDocument = TDocument::whereRaw('key_document=?', ['exam'])->first();

                if ($request->input('txtDescriptionOtherEvaluation') == '' && $tTypeExam->acronymTypeExam == TTypeExam::OTHER_TYPE_EXAM){
                    return PlatformHelper::redirectError(['Ingrese el nombre de la evaluación.'], 'examen/insertar');
                }

				$tNumberExam = $tTypeExam->numberExecuteYear > 1 ? $request->input('numberEvaluationExecute') . '° ' : '';
				$tSiteExam = !$tDirection ? '' : (' ' . $tDirection->nameRegion);
                $title_exam = $tTypeExam->acronymTypeExam != TTypeExam::OTHER_TYPE_EXAM ?
                    $tNumberExam . 'Evaluación ' . strtoupper($tTypeExam->acronymTypeExam) :
                    $request->input('txtDescriptionOtherEvaluation');

				$tExam = new TExam();

				$tExam->idExam = uniqid();

				$tExam->idTypeExam = $request->input('selectTypeExam');
				$tExam->idGrade = $request->input('selectGrade');
				$tExam->idSubject = $request->input('selectSubject');
				$tExam->idDirection = $request->input('selectDirectionExam') == 'General' ? null : $request->input('selectDirectionExam');
				$tExam->codeExam = $tDocument->number_document + 1;
				$tExam->nameExam = $title_exam . $tSiteExam . ' ' . $tSubject->nameSubject . ' ' . $tGrade->descriptionGrade;
				$tExam->descriptionExam = trim($request->input('txtDescriptionExam'));
				$tExam->name_type_exam = $request->input('txtDescriptionOtherEvaluation') != '' ?
                    trim($request->input('txtDescriptionOtherEvaluation')) : null;
				$tExam->totalPageExam = $request->input('txtTotalPageExam');
				$tExam->yearExam = $request->input('txtYearExam');
				$tExam->numberEvaluation = $request->input('numberEvaluationExecute');
				$tExam->number_question = $request->input('selectRegisterAnswer') == TExam::REGISTER_RESPONSE['NO'] ? 0 : $request->input('txtResponseExamPermit');
				$tExam->stateExam = $status ? TExam::STATUS['PUBLIC'] : TExam::STATUS['HIDDEN'];
				$tExam->keywordExam = implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
				$tExam->extensionExam = strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
				$tExam->register_answer = $request->input('selectRegisterAnswer');
				$tExam->dateExam = date('Y-m-d');

				$tExam->save();

				$tUserExam = new TUserExam();

				$tUserExam->idUserExam = uniqid();
				$tUserExam->idUser = session('idUser');
				$tUserExam->idExam = $tExam->idExam;
				$tUserExam->typeFunctionExam = 'Registro';
				$tUserExam->dataExam = $this->convertArray($tExam);
				$tUserExam->dateUserExam = date('Y-m-d');

				$tUserExam->save();

				$tDocument->number_document = $tDocument->number_document + 1;

				$tDocument->save();

				$filename = $tExam->idExam . '.' . $tExam->extensionExam;
				$request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $filename);

				$pdfPath = storage_path('app/file/exam/' . $filename);
				$imagick = new Imagick($pdfPath . '[0]');
				$imagick->scaleImage(250, 0);
				$imagick->setResolution(72, 72);

				$imagick->setImageFormat('jpg');
				$imageData = $imagick->getImageBlob();
				Storage::disk('exam-img')->put($tExam->idExam . '.jpg', $imageData);

                if ($request->hasFile('fileTableResource'))
                {
                    $tResource = new TResource();

                    $tResource->idResource = uniqid();
                    $tResource->idExam = $tExam->idExam;
                    $tResource->namecompleteResource = 'Tabla especificacion '.$tExam->nameExam;
                    $tResource->type = TResource::TYPE_RESOURCE['TABLE'];
                    $tResource->extension = strtolower($request->file('fileTableResource')->getClientOriginalExtension());

                    $tResource->save();

                    $filename = $tResource->idResource . '.' . $tResource->extension;
                    $request->file('fileTableResource')->move(storage_path('/app/public/resource/'), $filename);
                }

                if ($request->hasFile('fileResource'))
                {
                    $files = $request->file('fileResource');
                    foreach ($files as $key => $file) {
                        $tResource = new TResource();

                        $tResource->idResource = uniqid();
                        $tResource->idExam = $tExam->idExam;
                        $tResource->namecompleteResource = 'Material ' . date('Y-m-d_H:i:s') . ' ' . ($key+1) . ' ' . $tExam->nameExam;
                        $tResource->type = TResource::TYPE_RESOURCE['MATERIAL'];
                        $tResource->extension = strtolower($file->getClientOriginalExtension());

                        $tResource->save();

                        $filename = $tResource->idResource . '.' . $tResource->extension;
                        $file->move(storage_path('/app/public/resource/'), $filename);
                    }
                }

				if ($request->has('txtValueResponseExam')) {
					foreach ($request->input('txtValueResponseExam') as $number => $valueResponse) {
						$tAnswer = new TAnswer();

						$tAnswer->idAnswer = uniqid();
						$tAnswer->idExam = $tExam->idExam;
						$tAnswer->idUser = session('idUser');
						$tAnswer->numberAnswer =  $number + 1;
						$tAnswer->descriptionAnswer = $valueResponse == '' ? '' : $valueResponse;

						$tAnswer->save();
					}
				}

				DB::commit();

				return PlatformHelper::redirectCorrect(['Inserción realizada correctamente.'], 'examen/insertar');
			} catch (\Exception $e) {
				DB::rollBack();

				return PlatformHelper::redirectError([$e->getMessage()], 'examen/insertar');
			}
		}

		$tTypeExam = TTypeExam::all();
		$tSubject = TSubject::all();
		$tGrade = TGrade::all();
		$tDirection = TDirection::all();

		return view(
			'backoffice/exam/insert',
			[
				'tTypeExam' => $tTypeExam,
				'tSubject' => $tSubject,
				'tGrade' => $tGrade,
				'tDirection' => $tDirection
			]
		);
	}

	public function actionEdit(Request $request)
	{
		if ($request->has('hdIdExam')) {
			try
            {
				DB::beginTransaction();

				$this->_so->mo->listMessage = (new ExamValidation())->validationEdit($request);

				if ($this->_so->mo->existsMessage()) {
					DB::rollBack();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'examen/mostrar/1');
				}

				$tTypeExam = TTypeExam::find($request->input('selectTypeExam'));
				$tSubject = TSubject::find($request->input('selectSubject'));
				$tGrade = TGrade::find($request->input('selectGrade'));
				$tDirection = TDirection::find($request->input('selectDirectionExam'));

                if ($request->input('txtDescriptionOtherEvaluation') == '' && $tTypeExam->acronymTypeExam == TTypeExam::OTHER_TYPE_EXAM){
                    return PlatformHelper::redirectError(['Ingrese el nombre de la evaluación.'], 'examen/insertar');
                }

				$tNumberExam = $tTypeExam->numberExecuteYear > 1 ? $request->input('numberEvaluationExecute') . '° ' : '';
				$tSiteExam = !$tDirection ? '' : (' ' . $tDirection->nameRegion);
                $title_exam = $tTypeExam->acronymTypeExam != TTypeExam::OTHER_TYPE_EXAM ?
                    $tNumberExam . 'Evaluación ' . strtoupper($tTypeExam->acronymTypeExam) :
                    $request->input('txtDescriptionOtherEvaluation');

				$tExam = TExam::find($request->input('hdIdExam'));

				$tExam->idTypeExam = $request->input('selectTypeExam');
				$tExam->idGrade = $request->input('selectGrade');
				$tExam->idSubject = $request->input('selectSubject');
				$tExam->idDirection = $request->input('selectDirectionExam') == 'General' ? null : $request->input('selectDirectionExam');
				$tExam->nameExam = $title_exam . $tSiteExam . ' ' . $tSubject->nameSubject . ' ' . $tGrade->descriptionGrade;
				$tExam->descriptionExam = trim($request->input('txtDescriptionExam'));
                $tExam->name_type_exam = $request->input('txtDescriptionOtherEvaluation') != '' ?
                    trim($request->input('txtDescriptionOtherEvaluation')) : null;
				$tExam->totalPageExam = $request->input('txtTotalPageExam');
				$tExam->yearExam = $request->input('txtYearExam');
				$tExam->numberEvaluation = $request->input('numberEvaluationExecute');
				$tExam->number_question = $request->input('selectRegisterAnswer') == TExam::REGISTER_RESPONSE['NO'] ? 0 : $request->input('txtResponseExamPermit');
				$tExam->keywordExam = implode('__7SEPARATOR7__', $request->input('selectKeywordExam'));
				$tExam->register_answer = $request->input('selectRegisterAnswer');

				$tExam->save();

				$tUserExam = new TUserExam();

				$tUserExam->idUserExam = uniqid();
				$tUserExam->idUser = session('idUser');
				$tUserExam->idExam = $tExam->idExam;
				$tUserExam->typeFunctionExam = 'Modificación';
				$tUserExam->dataExam = $this->convertArray($tExam);
				$tUserExam->dateUserExam = date('Y-m-d');

				$tUserExam->save();

				if ($request->hasFile('fileExamExtension')) {
					$tExam = TExam::find($tExam->idExam);

					$directoryFiles = storage_path('app/file/exam/' . $tExam->idExam . '.' . $tExam->extensionExam);

					if ($tExam->extensionExam != '' && file_exists($directoryFiles)) {
						$direccionLink = storage_path('app/file/exam/' . $tExam->idExam . '.' . $tExam->extensionExam);

						unlink($direccionLink);
					}

					$tExam->extensionExam = strtolower($request->file('fileExamExtension')->getClientOriginalExtension());
					$tExam->updated_at = date('Y-m-d H:i:s');

					$tExam->save();

					$request->file('fileExamExtension')->move(storage_path('/app/file/exam/'), $tExam->idExam . '.' . $tExam->extensionExam);

					$filePath = $tExam->idExam . '.jpg';
					if (Storage::disk('exam-img')->exists($filePath)) {
						Storage::disk('exam-img')->delete($filePath);
					}

					$filename = $tExam->idExam . '.' . $tExam->extensionExam;
					$pdfPath = storage_path('app/file/exam/' . $filename);
					$imagick = new Imagick($pdfPath . '[0]');
					$imagick->scaleImage(250, 0);
					$imagick->setResolution(72, 72);

					$imagick->setImageFormat('jpg');
					$imageData = $imagick->getImageBlob();
					Storage::disk('exam-img')->put($tExam->idExam . '.jpg', $imageData);
				}

                if ($request->hasFile('fileTableResource'))
                {
                    $tResourceTable = TResource::whereRaw('idExam = ? AND type = ?', [$tExam->idExam, TResource::TYPE_RESOURCE['TABLE']])->first();

                    if (!$tResourceTable)
                    {
                        $tResource = new TResource();

                        $tResource->idResource = uniqid();
                        $tResource->idExam = $tExam->idExam;
                        $tResource->namecompleteResource = 'Tabla de especificacion '.$tExam->nameExam;
                        $tResource->type = TResource::TYPE_RESOURCE['TABLE'];
                        $tResource->extension = strtolower($request->file('fileTableResource')->getClientOriginalExtension());

                        $tResource->save();

                        $filename = $tResource->idResource . '.' . $tResource->extension;
                        $request->file('fileTableResource')->move(storage_path('/app/public/resource/'), $filename);
                    }
                    else
                    {
                        $directoryResource = storage_path('app/public/resource/' . $tResourceTable->idResource . '.' . $tResourceTable->extension);

                        if ($tResourceTable->extension != '' && file_exists($directoryResource))
                            unlink($directoryResource);

                        $tResourceTable->namecompleteResource = 'Tabla de especificacion '.$tExam->nameExam;
                        $tResourceTable->extension = strtolower($request->file('fileTableResource')->getClientOriginalExtension());
                        $tResourceTable->updated_at = date('Y-m-d H:i:s');

                        $tResourceTable->save();

                        $filename = $tResourceTable->idResource . '.' . $tResourceTable->extension;
                        $request->file('fileTableResource')->move(storage_path('/app/public/resource/'), $filename);
                    }
                }

				DB::commit();

				return PlatformHelper::redirectCorrect(['Cambios guardado correctamente.'], 'examen/mostrar/1');
			} catch (\Exception $e) {
				DB::rollBack();

				return PlatformHelper::redirectError([$e->getMessage()], 'examen/mostrar/1');
			}
		}

		$tExam = TExam::find($request->input('idExam'));

		$tTypeExam = TTypeExam::all();
		$tSubject = TSubject::all();
		$tGrade = TGrade::all();
		$tDirection = TDirection::all();

		if ($tExam == null) {
			return PlatformHelper::ajaxDataNoExists();
		}

		return view(
			'backoffice/exam/edit',
			[
				'tExam' => $tExam,
				'tTypeExam' => $tTypeExam,
				'tSubject' => $tSubject,
				'tGrade' => $tGrade,
				'tDirection' => $tDirection
			]
		);
	}

	public function actionViewExam($idExam)
	{
		try {
			$tExam = TExam::find($idExam);

			if (!$tExam) {
				$message = 'No se encontró el archivo perteneciente a la evaluación';

				return view(
					'frontoffice/exam/error',
					[
						'message' => $message
					]
				);
			}

			if (($tExam && $tExam->stateExam != TExam::STATUS['PUBLIC']) &&
				!stristr(session('roleUser'), TRole::ROLE['ADMIN']) && !stristr(session('roleUser'), TRole::ROLE['SUPERVISOR'])
			) {
				$message = 'El archivo de esta evaluación no está disponible por el momento.';

				return view(
					'frontoffice/exam/error',
					[
						'message' => $message
					]
				);
			}

			$fileName = preg_replace(['/ /', '/[\/\\\\]/', '/\./'], ['_', '', ''], $tExam->nameExam);

			$directoryFiles = storage_path('/app/file/exam/' . $tExam->idExam . '.' . $tExam->extensionExam);

			$response = new BinaryFileResponse($directoryFiles);
			$response->setContentDisposition('inline', $fileName . '.' . $tExam->extensionExam);

			BinaryFileResponse::trustXSendfileTypeHeader();

			return $response;
		} catch (\Exception $e) {
			$message = 'No se encontró el documento pdf de la evaluación mencionada, consulte al administrador del sistema.';
			return view(
				'frontoffice/exam/error',
				[
					'message' => $message
				]
			);
		}
	}

	public function actionDelete($idExam)
	{
		try {
			$tExam = TExam::find($idExam);

			if ($tExam && $tExam->stateExam == TExam::STATUS['PUBLIC']) {
				return PlatformHelper::redirectError(['No puede eliminar una evaluación que está publicada.'], 'examen/mostrar/1');
			}

			$directoryFiles = storage_path('app/file/exam/' . $tExam->idExam . '.' . $tExam->extensionExam);

			if ($tExam->extensionExam != '' && file_exists($directoryFiles)){
				unlink($directoryFiles);
			}

			$filePath = $tExam->idExam . '.jpg';
			if (Storage::disk('exam-img')->exists($filePath)) {
				Storage::disk('exam-img')->delete($filePath);
			}

			DB::delete('delete from texam where idExam = ?', [$idExam]);
            $tResource = TResource::where('idExam', $idExam)->get();
            if ($tResource){
                foreach ($tResource as $resource)
                {
                    $directoryFiles = storage_path('app/public/resource/' . $resource->idResource . '.' . $tExam->extension);

                    if ($tExam->extension != '' && file_exists($directoryFiles)) {
                        unlink($directoryFiles);
                    }
                }
                TResource::where('idExam', $idExam)->delete();
            }

			return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/mostrar/1');
		} catch (\Exception $e) {
			DB::rollBack();

			return PlatformHelper::redirectCorrect([$e->getMessage()], 'examen/mostrar/1');
		}
	}

	public function actionChangeState($idExam)
	{
		try {
			DB::beginTransaction();

			$tExam = TExam::find($idExam);

			$valueStatus = $tExam->stateExam;

			$tExam->stateExam = $valueStatus == TExam::STATUS['PUBLIC'] ? TExam::STATUS['HIDDEN'] : TExam::STATUS['PUBLIC'];

			$tExam->save();

			DB::commit();

			return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'examen/mostrar/1');
		} catch (\Exception $e) {
			DB::rollBack();

			return PlatformHelper::redirectError([$e->getMessage()], 'examen/mostrar/1');
		}
	}

	private function convertArray($data)
	{
		$tExamData = array(
			'idExam' => $data->idExam,
			'idTypeExam' => $data->idTypeExam,
			'idGrade' => $data->idGrade,
			'idSubject' => $data->idSubject,
			'idDirection' => $data->idDirection,
			'codeExam' => $data->codeExam,
			'nameExam' => $data->nameExam,
			'descriptionExam' => $data->descriptionExam,
			'totalPageExam' => $data->totalPageExam,
			'yearExam' => $data->yearExam,
			'stateExam' => $data->stateExam,
			'keywordExam' => $data->keywordExam,
			'extensionExam' => $data->extensionExam,
			'register_answer' => $data->register_answer,
			'created_at' => $data->created_at,
			'updated_at' => $data->updated_at,
		);

		return json_encode($tExamData);
	}
}
