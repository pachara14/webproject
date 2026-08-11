<header class="topbar">
    <div>
        <div class="crumb">ระบบจัดการโครงงานนักศึกษา</div>
        <h1>@yield('header_title', 'รายงานการทำงาน')</h1>
    </div>
    <div class="user">
        <span class="bell">♧</span>
        <div class="avatar">
            @if(auth()->user()->profile_image)
                <img src="{{ auth()->user()->profile_image }}" alt="profile">
            @else
                {{ mb_substr(auth()->user()->first_name ?? 'น', 0, 1) }}
            @endif
        </div>
        <div>
            <b>{{ (auth()->user()->first_name ?? 'ผู้ใช้') }} {{ auth()->user()->last_name ?? '' }}</b>
            <small>นักศึกษา</small>
        </div>
    </div>
</header>
