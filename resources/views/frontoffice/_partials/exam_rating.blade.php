<span>
    @for ($i = 0; $i < floor($rating->avg); $i++)
        <i class="fa-sharp fa-solid fa-star"></i>
    @endfor

    @for ($i = 0; $i < 5 - floor($rating->avg); $i++)
        <i class="fa-regular fa-star"></i>
    @endfor
    ({{ $rating->avg }})
</span>
