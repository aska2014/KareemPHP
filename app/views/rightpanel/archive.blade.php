<h2 id="archive_title">Blog Arcihve</h2>
<div id="archive">
    <ul class="year">
        @foreach($archiveYears as $year)
        <li style="margin-bottom:20px;"><a href="{{ EasyURL::blogArchive($year) }}">{{ $year }} ({{ $year->getCount() }})</a><div class="arrow_img"></div>
            @foreach($year->getMonths() as $month)
            <ul class="month">
                <li><a href="{{ EasyURL::blogArchive($year, $month) }}">{{ $month->format('F') }} ({{ $month->getCount() }})</a></li>
            </ul>
            @endforeach
        </li>
        @endforeach
    </ul>
</div>