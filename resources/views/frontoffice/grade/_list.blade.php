<div class="row">
    <table class="table table-responsive">
        <tr>
            <th class="align-top">
                <label class="d-flex align-items-start">
                    <input type="checkbox" id="selectAll" name="SelectAll" class="ml-10"
                           style="width: 30px; height: 30px;">
                    <i class="fa fa-download ml-0 mt-0 text-success" style="font-size: 27px"
                       title="SELECCIONAR TODO"></i>
                </label>
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
        @foreach ($listTExam as $value)
            <tr>
                <td>
                    <input type="checkbox" id="result[]" name="result[]"
                           value="{{$value->idExam}}" class="mt-10 ml-10"
                           style="width: 30px; height: 30px;">
                </td>
                <td>
                    <h4 class="it-course-title mb-0">
                        <a href="{{ url('examen/ver/' . $value->codeExam) }}">
                            {{ $value->nameExam }}
                        </a>
                    </h4>
                </td>
                <td>{{ $value->tTypeExam->nameTypeExam ?? '-' }}</td>
                <td>{{ $value->tSubject->nameSubject ?? '-' }}</td>
                <td>{{ $value->tGrade->descriptionGrade ?? '-' }}</td>
                <td>{{ $value->yearExam }}</td>
                <td>
                    {{ $value->totalPageExam == 1 ? $value->totalPageExam . ' páginas' : $value->totalPageExam . ' páginas' }}
                </td>
                <td>
                    <a href="{{ url('examen/ver/' . $value->codeExam) }}" class="btn btn-primary">
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
        <button id="downloadBtn" style="display:none;" class="btn btn-primary btn-success">
            <i class="fa fa-download"></i>
            Descargar archivos
        </button>
    </div>
    <div class="col-8">
        {!! ViewHelper::renderPaginationFrontExams(
            'grado/'.$codeGrade.'/listar',
            $quantityPage,
            $currentPage,
            $filtersData,
        ) !!}
    </div>
</div>
