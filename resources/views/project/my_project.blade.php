@extends('layouts.app')

@section('title', 'โครงงานของฉัน | ศูนย์จัดการโครงงาน')
@section('header_title', 'โครงงานของฉัน')

@push('styles')
<style>
    /* =========================================
       Page Header Styles
       ========================================= */
    .page-header-wrapper {
        margin-bottom: 24px;
        padding-top: 10px;
    }
    .page-overline {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: #bfa054; /* สีทอง/เหลืองเข้ม */
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .page-title {
        font-size: 26px;
        font-weight: 700;
        color: #222;
        margin: 0 0 6px 0;
    }
    .page-subtitle {
        font-size: 14.5px;
        color: #777;
        margin: 0;
    }

    /* =========================================
       Main Card Styles
       ========================================= */
    .project-card {
        background-color: #fdfcf9; /* สีพื้นหลังครีมอ่อนๆ */
        border: 1px solid #f0ebe1;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    /* Top Section (Header of Card) */
    .pc-top {
        padding: 32px;
        border-bottom: 1px solid #f0ebe1;
        position: relative;
    }
    .pc-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .status-badge {
        background-color: #e6f4ea;
        color: #1e7e34;
        font-size: 13px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .project-code {
        font-size: 13px;
        color: #888;
        font-family: monospace;
    }
    .project-icon-box {
        position: absolute;
        top: 32px;
        right: 32px;
        width: 64px;
        height: 64px;
        background-color: #fdf1d9;
        border: 1px solid #f6e3bd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a87b28;
    }
    .pc-title {
        font-size: 22px;
        font-weight: 700;
        color: #222;
        margin: 0 0 10px 0;
        max-width: 85%;
        line-height: 1.4;
    }
    .pc-desc {
        font-size: 15px;
        color: #666;
        margin: 0;
        max-width: 85%;
    }

    /* Bottom Section (Two Columns) */
    .pc-bottom {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
    }
    .pc-left {
        padding: 32px;
        border-right: 1px solid #f0ebe1;
    }
    .pc-right {
        padding: 32px;
    }

    /* Left Column Details */
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #222;
        margin: 0 0 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }
    .info-item label {
        display: block;
        font-size: 13px;
        color: #888;
        margin-bottom: 4px;
    }
    .info-item span {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: #333;
    }

    /* Keyword Box */
    .keyword-box {
        background-color: #f6f4f0;
        border: 1px solid #ebe7e0;
        border-radius: 10px;
        padding: 16px 20px;
    }
    .keyword-box-title {
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
    }
    .keyword-tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .tag-pill {
        background-color: #e9e6df;
        color: #444;
        font-size: 13px;
        padding: 4px 12px;
        border-radius: 20px;
    }

    /* Right Column (Members) */
    .btn-add {
        background: none;
        border: none;
        color: #8a1d2d;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: inherit;
    }
    .btn-add:hover {
        text-decoration: underline;
    }
    .person-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }
    .person-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .person-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: #555;
    }
    .av-1 { background-color: #eed6aa; }
    .av-2 { background-color: #e8d1bc; }
    .av-3 { background-color: #e6c8ae; }
    .av-4 { background-color: #dfbec3; }

    .person-name {
        font-size: 14.5px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .person-role {
        font-size: 12px;
        color: #888;
        margin: 0;
    }
    .btn-icon {
        background: none;
        border: none;
        color: #aaa;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: 0.2s;
    }
    .btn-icon:hover {
        background-color: #ffeeee;
        color: #d32f2f;
    }
    .btn-icon-edit:hover {
        background-color: #f0f0f0;
        color: #333;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .pc-bottom { grid-template-columns: 1fr; }
        .pc-left { border-right: none; border-bottom: 1px solid #f0ebe1; }
        .project-icon-box { display: none; }
    }
</style>
@endpush

@section('content')
<main class="main">

    <!-- Title Section -->
    <div class="page-header-wrapper">
        <div class="page-overline">Project Profile</div>
        <h2 class="page-title">โครงงานของฉัน</h2>
        <p class="page-subtitle">รายละเอียดโครงงาน สมาชิก และอาจารย์ที่ปรึกษา</p>
    </div>

    <!-- Main Card -->
    <div class="project-card">

        <!-- ส่วนบน: ข้อมูลหลัก -->
        <div class="pc-top">
            <div class="pc-meta">
                <span class="status-badge">กำลังดำเนินการ</span>
                <span class="project-code">CP-2568-014</span>
            </div>

            <!-- Icon มุมขวาบน -->
            <div class="project-icon-box">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    <line x1="9" y1="13" x2="15" y2="13" stroke-linecap="round"></line>
                </svg>
            </div>

            <h3 class="pc-title">ระบบจัดการโครงงานนักศึกษาสำหรับภาควิชาวิศวกรรมคอมพิวเตอร์</h3>
            <p class="pc-desc">เว็บแอปพลิเคชันสำหรับติดตามความก้าวหน้า นัดหมาย และจัดการเอกสารของโครงงานวิศวกรรม</p>
        </div>

        <!-- ส่วนล่าง: แบ่ง 2 คอลัมน์ -->
        <div class="pc-bottom">

            <!-- คอลัมน์ซ้าย: ข้อมูลโครงงาน -->
            <div class="pc-left">
                <h4 class="section-title">ข้อมูลโครงงาน</h4>

                <div class="info-grid">
                    <div class="info-item">
                        <label>สาขาวิชา</label>
                        <span>วิศวกรรมคอมพิวเตอร์</span>
                    </div>
                    <div class="info-item">
                        <label>ปีการศึกษา</label>
                        <span>2568 • ภาคเรียนที่ 1</span>
                    </div>
                    <div class="info-item">
                        <label>เริ่มดำเนินการ</label>
                        <span>15 มกราคม 2568</span>
                    </div>
                    <div class="info-item">
                        <label>กำหนดส่งโครงงาน</label>
                        <span>30 เมษายน 2568</span>
                    </div>
                </div>

                <!-- กล่องคำสำคัญ -->
                <div class="keyword-box">
                    <div class="keyword-box-title">คำสำคัญ</div>
                    <div class="keyword-tags">
                        <span class="tag-pill">ระบบสารสนเทศ</span>
                        <span class="tag-pill">React</span>
                        <span class="tag-pill">การจัดการโครงงาน</span>
                    </div>
                </div>
            </div>

            <!-- คอลัมน์ขวา: สมาชิกและที่ปรึกษา -->
            <div class="pc-right">

                <!-- สมาชิกโครงงาน -->
                <h4 class="section-title">
                    สมาชิกโครงงาน
                    <button class="btn-add">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"></path></svg>
                        เพิ่มสมาชิก
                    </button>
                </h4>

                <div class="person-list">
                    <!-- หัวหน้าโครงงาน -->
                    <div class="person-item">
                        <div class="person-info">
                            <div class="avatar av-1">ปจ</div>
                            <div>
                                <p class="person-name">น.ส.ปาริฉัตร ใจดี</p>
                                <p class="person-role">หัวหน้าโครงงาน</p>
                            </div>
                        </div>
                        <!-- หัวหน้าไม่มีปุ่มลบ -->
                    </div>

                    <!-- สมาชิกคนที่ 2 -->
                    <div class="person-item">
                        <div class="person-info">
                            <div class="avatar av-2">นพ</div>
                            <div>
                                <p class="person-name">นายนภฤต พูนผล</p>
                                <p class="person-role">สมาชิก</p>
                            </div>
                        </div>
                        <button class="btn-icon" title="ลบสมาชิก">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>
                        </button>
                    </div>

                    <!-- สมาชิกคนที่ 3 -->
                    <div class="person-item">
                        <div class="person-info">
                            <div class="avatar av-3">นแ</div>
                            <div>
                                <p class="person-name">นายพีรณัฐ แสงทอง</p>
                                <p class="person-role">สมาชิก</p>
                            </div>
                        </div>
                        <button class="btn-icon" title="ลบสมาชิก">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- อาจารย์ที่ปรึกษา -->
                <h4 class="section-title">อาจารย์ที่ปรึกษา</h4>

                <div class="person-list" style="margin-bottom: 0;">
                    <div class="person-item">
                        <div class="person-info">
                            <div class="avatar av-4">กศ</div>
                            <div>
                                <p class="person-name">ผศ.ดร.กิตติศักดิ์ วัฒนศรี</p>
                            </div>
                        </div>
                        <button class="btn-icon btn-icon-edit" title="แก้ไข">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
