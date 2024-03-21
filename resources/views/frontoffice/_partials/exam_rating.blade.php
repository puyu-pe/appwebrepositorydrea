<div class="it-evn-details-rate mb-15 rate-start-container" data-id-exam="{{ $idExam }}">
    <span>
        @for ($i = 1; $i <= 5; $i++)
            <i data-value="{{ $i }}"
                class="{{ $i <= floor($ratingAvg) ? 'fa-sharp fa-solid' : 'fa-regular' }} fa-star rate-start"></i>
        @endfor

        ({{ $ratingAvg }})

    </span>
</div>

<script src="{{ asset('assets/frontoffice/viewResources/exam/rate.js?x=' . env('CACHE_LAST_UPDATE')) }}"></script>
