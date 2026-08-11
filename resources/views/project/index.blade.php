@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('public/css/project_schedule.css') }}">
@push('styles')

@endpush

@section('content')
<main class="main">
    <div class="schedule-panel">

        <!-- ส่วนหัวและปุ่มออกรายงาน -->
        <div class="schedule-header">
            <div class="schedule-title">
                <h2>กำหนดการเรียนและการสอบวิชาโครงงาน</h2>
                <p>แสดงรายการนัดหมาย กำหนดการส่งงาน และการสอบทั้งหมด</p>
            </div>

            <!-- ปุ่มออกรายงาน (เบื้องต้นใส่เป็นคำสั่ง Print หน้าเว็บ คุณสามารถเปลี่ยน onclick เป็น href เพื่อเรียก Route สร้าง PDF ได้) -->
            <button type="button" class="btn-export" onclick="window.print()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                ออกรายงาน PDF
            </button>
        </div>

        <!-- ส่วนตารางข้อมูล -->
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="8%">ครั้งที่</th>
                        <th width="15%">วันที่</th>
                        <th width="40%">หัวข้อ</th>
                        <th width="17%">ผู้สอน</th>
                        <th width="20%">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->week_no }}</td>
                        <td>{{ $schedule->start_date }}</td>
                        <td>
                            <span class="topic-title">{{ $schedule->title }}</span>
                            <span class="topic-desc">{{ $schedule->description }}</span>
                        </td>
                        <td>{{ $schedule->lecturer }}</td>
                        <td class="text-note">{{ $schedule->note }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</main>
@endsection
