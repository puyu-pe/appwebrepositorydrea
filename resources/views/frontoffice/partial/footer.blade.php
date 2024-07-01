<div class="it-footer-area it-footer-bg black-bg pt-120 pb-70"
     data-background="{{asset('assets/frontoffice/img/footer/bg-1-1.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-50">
                <div class="it-footer-widget footer-col-1">
                    <div class="it-footer-logo pb-25">
                        <a href="index-html"><img src="{{asset('img/logo.png')}}" alt=""></a>
                    </div>
                    <div class="it-footer-text pb-5">
                        <p>
                            Proporciona a estudiantes y docentes un acceso fácil y organizado a evaluaciones,
                            permitiéndoles practicar y prepararse de manera efectiva
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-50">
                <div class="it-footer-widget footer-col-2">
                    <h4 class="it-footer-title">Evaluaciones</h4>
                    <div class="it-footer-list">
                        <ul>
                            @foreach ($menuTypeExamItem as $item)
                                <li><a href="{{url('tipoexamen/'.$item->acronymTypeExam.'/1')}}"><i class="fa-regular fa-angle-right"></i>{{strtoupper($item->acronymTypeExam != 'other' ? $item->acronymTypeExam : 'otros')}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 mb-50">
                <div class="it-footer-widget footer-col-3">
                    <h4 class="it-footer-title">Enlaces:</h4>
                    <div class="it-footer-list">
                        <ul>
                            <li><a href="https://www.dreapurimac.gob.pe/" target="_blank"><i
                                        class="fa-regular fa-angle-right"></i>DREA</a></li>
                            <li><a href="https://www.gob.pe/minedu" target="_blank"><i
                                        class="fa-regular fa-angle-right"></i>MINEDU</a></li>
                            <li><a href="https://www.gob.pe/cne" target="_blank"><i
                                        class="fa-regular fa-angle-right"></i>CNE</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-50">
            </div>
        </div>
    </div>
</div>
