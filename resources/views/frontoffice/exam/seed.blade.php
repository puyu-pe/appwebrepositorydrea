@extends('frontoffice.layout')
@section('generalBody')
    {{ csrf_field() }}

    <div class="it-breadcrumb-area it-breadcrumb-bg"
         data-background="{{ asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="it-breadcrumb-content z-index-3 text-center">
                        <div class="it-breadcrumb-title-box">
                            <h3 class="it-breadcrumb-title">{{ $tExam->ttypeexam->nameTypeExam }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-course-details-area pt-120 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="it-course-details-wrap">
                        <div class="it-evn-details-thumb mb-35"
                             style="text-align: center; background: #DEDEDE; padding: 10px">

                            <img src="{{ asset('storage/exam-img/' . $tExam->idExam . '.jpg') }}"
                                 alt="Vista previa"
                                 style="width: 250px; box-shadow: #0A0909  0px 0px 10px; border-radius: 10px; border: 2px solid #0A0909"
                            >
                        </div>
                        @include('frontoffice._partials.exam_rating', [
                            'containerClass' => 'it-evn-details-rate mb-15',
                            'qualifiable' => true,
                            'idExam' => $tExam->idExam,
                            'ratingAvg' => $rating->avg,
                        ])
                        <h4 class="it-evn-details-title mb-0 pb-5">{{ $tExam->nameExam }}</h4>
                        <div class="postbox__meta">
                            <span><i class="fa-light fa-file-invoice"></i>{{ $tExam->totalPageExam }} páginas</span>
                            <span><i class="fa-light fa-calendar"></i>{{ $tExam->created_at->format('d-m-Y') }} - F.
                                publicación</span>
                            <span><i class="fa-light fa-star"></i><div class="spanRatingCount">{{ $rating->count }} calificaciónes</div></span>
                        </div>
                        <div class="it-course-details-nav pb-60">
                            <nav>
                                <div class="nav nav-tab" role="tablist">
                                    @foreach (explode('__7SEPARATOR7__', $tExam->keywordExam) as $index => $keywordExam)
                                        <button type="button">{{ $keywordExam }}</button>
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                        <div class="it-course-details-content">
                            <div class="it-evn-details-text mb-40">
                                <h6 class="it-evn-details-title-sm pb-5">Descripción de la evaluación.</h6>
                                <p>{{ $tExam->descriptionExam }}</p>
                                @if (Session::get('idUser'))
                                    <button class="it-btn w-80 text-center" data-bs-toggle="modal"
                                            data-bs-target="#mdlAnswerRegister">
                                        Registro de respuestas
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                  stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                                  stroke-miterlimit="10"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                @endif

                                @if($tExam->register_answer == '1')
                                    <button class="it-btn w-80 text-center" id="btnModalResponse"
                                            onclick="$('#dvAnswer').show();">
                                        Ver respuestas
                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor"
                                                  stroke-width="1.5"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                                  stroke-miterlimit="10"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="row">
                        <div class="it-evn-sidebar-box it-course-sidebar-box">
                            <div class="it-evn-sidebar-list mb-20">
                                <ul>
                                    <li><span>Nro visitas: </span> <span>{{ $tExam->view_counter }}</span></li>
                                    <li><span>Nro descargas: </span> <span>12</span></li>
                                    <li><span>Año de evaluación: </span> <span>{{ $tExam->yearExam }}</span></li>
                                    @if($tResourceTable)
                                        <li><span>Tabla de especificaciones: </span>
                                            <a class="btn btn-info text-center"
                                               href="{{ url('recurso/verarchivo/' . $tResourceTable->idResource) }}?x={{ $tResourceTable->updated_at }}"
                                               target="_blank">
                                                Ver
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <a class="it-btn w-100 text-center"
                               href="{{ url('examen/verarchivo/' . $tExam->idExam) }}?x={{ $tExam->updated_at }}"
                               target="_blank">
                            <span>
                                Ver evaluación
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1.24023L16 7.24023L11 13.2402" stroke="currentcolor" stroke-width="1.5"
                                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M1 7.24023H16" stroke="currentcolor" stroke-width="1.5"
                                          stroke-miterlimit="10"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            </a>
                        </div>
                    </div>
                    <br>
                    @if($tResourceMaterial->isNotEmpty())
                        <div class="row">
                            <div class="it-evn-sidebar-box it-course-sidebar-box">
                                <div class="it-evn-sidebar-list mb-20">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Materiales de refuerzo</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tResourceMaterial as $key =>$tResourceMaterialExam)
                                            <tr>
                                                <td class="text-center">
                                                    <div>{{ 'Material de refuerzo '.($key+1) }}</div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a class="btn btn-info text-center"
                                                           href="{{ url('recurso/verarchivo/' . $tResourceMaterialExam->idResource) }}?x={{ $tResourceMaterialExam->updated_at }}"
                                                           target="_blank">
                                                            Ver
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-xl-9 col-lg-8">
                    @if($tExam->register_answer == 1)
                        @if($tAnswersGroupedByUser->isNotEmpty())
                            <div class="row" id="dvAnswer" style="display: none;">
                                <div class="accordion" id="accordionExample">
                                    @foreach($tAnswersGroupedByUser as $idUser => $answers)
                                        <div class="accordion-item">
                                            @php
                                                $user = $answers->first()->tuser;
                                                $firstName = $user->firstName;
                                                $surName = $user->surName;
                                            @endphp

                                            <h2 class="accordion-header" id="heading{{$user->idUser}}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$user->idUser}}" aria-expanded="true" aria-controls="collapse{{$user->idUser}}">
                                                    {{ $firstName }} {{ $surName }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{$user->idUser}}" class="accordion-collapse collapse" aria-labelledby="heading{{$user->idUser}}" data-bs-parent="#accAnswers">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>N° de pregunta</th>
                                                            <th>Descripción de la respuesta</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($answers as $tanswer_value)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <div>{{ $tanswer_value->numberAnswer }}</div>
                                                                </td>
                                                                <td>
                                                                    <div>{{ $tanswer_value->descriptionAnswer }}</div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="row" id="dvAnswer" style="display: none;">
                                <div class="col-xl-12 col-lg-12">
                                    <h5 class="it-sv-details-title-sm" style="font-weight: bold;">
                                        No se registró respuestas para la evaluación
                                    </h5>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="mdlAnswerRegister" data-backdrop="" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlAnswerRegisterLabel">Registro de respuestas a la evaluación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        @include('backoffice.answer.insert', [
                            'tExam' => $tExam,
                            'tAnswer' => $tAnswer,
                            'maxNumberAnswer' => $tExam->number_question,
                        ])
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
