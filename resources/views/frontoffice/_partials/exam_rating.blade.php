<div class="it-evn-details-rate mb-15 rate-start-container" data-id-exam="{{ $idExam }}"
    data-logging={{ Session::get('firstName') ? 1 : 0 }}>
    <span>
        @for ($i = 1; $i <= 5; $i++)
            <i data-value="{{ $i }}"
                class="{{ $i <= floor($ratingAvg) ? 'fa-sharp fa-solid' : 'fa-regular' }} fa-star rate-start"></i>
        @endfor
    </span>
    <span class="avgContainer ml-3">
        ({{ $ratingAvg }})
    </span>
</div>

@if ($qualifiable)
    <script src="{{ asset('assets/frontoffice/viewResources/exam/rate.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
@endif
