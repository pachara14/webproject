<aside class="sidebar">
    <div class="brand">
    <a class="logo" href="" target="_blank">
        <img src="https://en.rmutr.ac.th/cpe/wp-content/uploads/2026/01/CPE-logo250x250.png"
             alt="CPE RMUTR Logo">
    </a>
        <div><b>ระบบจัดการโครงงาน</b><small>CPE · RMUTR · ENGINEERING</small></div>
    </div>
    <div class="project">
        <small>พื้นที่ทำงาน</small>
        <strong>โครงงานวิศวกรรม 1/2568</strong>
        <span>สาขาวิชาวิศวกรรมคอมพิวเตอร์</span>
    </div>
    <nav class="nav">
        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="ico">⊞</span>ภาพรวม</a>
        <a class="{{ request()->routeIs('myproject') ? 'active' : '' }}" href="{{ route('myproject') }}"><span class="ico">▣</span>โครงงานของฉัน</a>
        <a href="#"><span class="ico">〽</span>ความก้าวหน้า</a>
        <a href="#"><span class="ico">▤</span>ข้อเสนอแนะ </a>
    </nav>
    <form class="logout" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ออกจากระบบ</button>
    </form>
</aside>
