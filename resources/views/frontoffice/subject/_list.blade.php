<div class="row">
    <table class="table table-responsive">
        <tr>
            <th class="align-top">
                <div class="d-flex align-items-start">
                    <input type="checkbox" id="subject-exam-select-all" name="selectAllExams" class="ml-10 js-exam-select-all"
                           style="width: 30px; height: 30px;">
                    <label for="subject-exam-select-all" class="visually-hidden">Seleccionar todos los exámenes</label>
                    <label for="subject-exam-select-all">
                        <i class="fa fa-download ml-0 mt-0 text-success" style="font-size: 27px" aria-hidden="true"
                           title="SELECCIONAR TODO"></i>
                    </label>
                </div>
            </th>
            <th>Titulo</th>
            <th>Tipo de evaluación</th>
            <th>Curso</th>
            <th>Grado</th>
            <th>Año</th>
            <th>Páginas</th>
            <th></th>
        </tr>

        @if ($listTExam->isEmpty())
            <tr>
                <td colspan="8">
                    <center>
                        <h5 class="mt-10">No se encontraron resultados.</h5>
                    </center>
                </td>
            </tr>
        @endif
        @foreach ($listTExam as $exam)
            <tr>
                <td>
                    <input type="checkbox" id="subject-exam-select-{{ $exam->idExam }}" name="selectedExamIds[]"
                           value="{{ $exam->idExam }}" class="mt-10 ml-10 js-exam-select"
                           style="width: 30px; height: 30px;">
                    <label for="subject-exam-select-{{ $exam->idExam }}" class="visually-hidden">Seleccionar examen: {{ $exam->nameExam }}</label>
                </td>
                <td>
                    <h4 class="it-course-title mb-0">
                        <a href="{{ url('examen/ver/' . $exam->codeExam) }}">
                            {{ $exam->nameExam }}
                        </a>
                    </h4>
                </td>
                <td>{{ $exam->tTypeExam->nameTypeExam ?? '-' }}</td>
                <td>{{ $exam->tSubject->nameSubject ?? '-' }}</td>
                <td>{{ $exam->tGrade->descriptionGrade ?? '-' }}</td>
                <td>{{ $exam->yearExam }}</td>
                <td>
                    {{ $exam->totalPageExam == 1 ? $exam->totalPageExam . ' páginas' : $exam->totalPageExam . ' páginas' }}
                </td>
                <td>
                    <a href="{{ url('examen/ver/' . $exam->codeExam) }}" class="btn btn-primary">
                        Ver detalles
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<div class="row">
    <div class="col-4">
        <input type="hidden" id="downloadUrl" value="{{ url('download/selected') }}">
        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
        <button type="button" id="downloadBtn" style="display:none;" class="btn btn-primary btn-success"
                aria-busy="false">
            <i class="fa fa-download" aria-hidden="true"></i>
            <span class="download-label">Descargar archivos</span>
        </button>
    </div>
    <div class="col-8">
        {!! ViewHelper::renderPaginationFrontExams(
            'curso/'.$codeSubject.'/listar',
            $quantityPage,
            $currentPage,
            $filtersData,
        ) !!}
    </div>
</div>
