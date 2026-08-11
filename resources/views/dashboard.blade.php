@extends('layouts.app')

@section('title', 'ภาพรวม | ศูนย์จัดการโครงงาน')
@section('header_title', 'รายงานการทำงาน')

@section('content')
<main class="main">
    <section class="hero">
        <div>
            <p class="date"><?php echo date('วันที่ j F Y'); ?> · ภาคการศึกษาที่ 1/2568</p>
            <h2>สวัสดี {{ auth()->user()->first_name ?? 'นักศึกษา' }} {{ auth()->user()->last_name ?? '' }}</h2>
        </div>
        <!-- <div class="status"><i>▣</i>
            <div><small>สถานะโครงงาน</small><b>กำลังดำเนินการ</b></div>
        </div> -->
    </section>

    </section>
    <section class="metrics">
            <!-- <article class="metric">
                <div class="icon amber">〽</div>
                <p>ความก้าวหน้าโครงงาน</p>
                <h3>68%</h3><small>เพิ่มขึ้น 12% จากเดือนก่อน</small>
            </article>
            <article class="metric">
                <div class="icon green">♧</div>
                <p>รายการความก้าวหน้า</p>
                <h3>3 รายการ</h3><small>2 รายการผ่านการอนุมัติ</small>
            </article>
            <article class="metric">
                <div class="icon pink">▤</div>
            <p>ข้อเสนอแนะที่ต้องอ่าน</p>
            <h3>1 รายการ</h3><small>อัปเดตล่าสุดเมื่อวานนี้</small>
        </article>
        <article class="metric">
            <div class="icon purple">▦</div>
            <p>นัดหมายถัดไป</p>
            <h3>28 มี.ค.</h3><small>อีก 2 วัน · เวลา 13:30 น.</small>
        </article> -->
    </section>

    <section class="lower">
        <!-- <article class="panel">
            <header class="panel-head">
                <div>
                    <h3>ความคืบหน้าล่าสุด</h3><small>ติดตามสถานะการดำเนินงานของโครงงาน</small>
                </div><a href="#">ดูทั้งหมด →</a>
            </header>
            <div class="progress-list">
                <div class="task">
                    <div class="step">03</div>
                    <div><b>พัฒนาระบบต้นแบบ</b>
                        <p>พัฒนาหน้าจอการจัดการโครงงานและระบบแจ้งเตือน</p><time>24 มี.ค. 2568</time>
                    </div><span class="tag wait">รอตรวจสอบ</span>
                </div>
                <div class="task">
                    <div class="step">02</div>
                    <div><b>ออกแบบสถาปัตยกรรมระบบ</b>
                        <p>จัดทำ ER Diagram และโครงสร้างฐานข้อมูลเบื้องต้น</p><time>08 มี.ค. 2568</time>
                    </div><span class="tag">อนุมัติแล้ว</span>
                </div>
                <div class="task">
                    <div class="step">01</div>
                    <div><b>ศึกษาปัญหาและรวบรวมความต้องการ</b>
                        <p>สัมภาษณ์ผู้ใช้งานและสรุปขอบเขตของระบบ</p><time>18 ก.พ. 2568</time>
                    </div><span class="tag">อนุมัติแล้ว</span>
                </div>
            </div>
        </article> -->
        <article class="panel">
            <header class="panel-head">
                <div>
                    <h3>ปฏิทินนสอบโครงาน</h3>
                    <small>ติดตามกำหนดการสอบโครงาน</small>
                </div>

                <a href="{{ route('project.events') }}">ดูทั้งหมด →</a>
            </header>

            <div id="calendar"></div>
        </article>
    </section>

    <article class="panel notice">
        <div class="icon">♧</div>
        <div><b>แจ้งเตือนจากระบบ</b>
            <p>กำหนดส่งบทที่ 3 ภายในวันที่ 5 เมษายน 2568 · เหลือเวลา 10 วัน</p>
        </div>
    </article>
</main>
@endsection

<!-- แทรก Script ปฏิทินเฉพาะหน้านี้เท่านั้น -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
@endpush
