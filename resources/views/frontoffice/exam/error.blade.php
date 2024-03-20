@extends('frontoffice.layout')
@section('generalBody')
    <div class="it-breadcrumb-area it-breadcrumb-bg" data-background="{{asset('assets/frontoffice/img/breadcrumb/breadcrumb.jpg')}}">
        <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="it-breadcrumb-content z-index-3 text-center">
                    <div class="it-breadcrumb-title-box">
                    <h3 class="it-breadcrumb-title">Error</h3>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <section class="cart-area pt-120 pb-120">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <h2 style="font-weight: bold; color: red;">{{$message}}</h2>
                </div>
            </div>
        </div>
    </section>
@endsection
