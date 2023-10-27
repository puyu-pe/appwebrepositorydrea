@extends('template.layout')
@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1-1">
            <div class="row">
                <div class="col-md-12 text-center">
                    @foreach($tTypeExam as $value)
                        <div class="examContainerCard">
                            <div class="examContainerCardCoverImage">
                                <img src="{{asset('img/logo/typeexam/'.$value->idTypeExam.'.'.$value->extensionImageType.'?x='.$value->updated_at)}}" height="70" width="70">
                            </div>
                            <div class="examContainerCardTitle">
                                <a href="{{url('tipoexamen/'.$value->acronymTypeExam.'/1')}}">
                                    {{$value->nameTypeExam}}
                                </a>
                            </div>
                            <div class="examContainerCardDescription">
                                <div style="font-size: 15px;">{{$value->descriptionTypeExam}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
