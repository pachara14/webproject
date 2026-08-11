// document.addEventListener('DOMContentLoaded', function () {

//     const calendarEl = document.getElementById('calendar');

//     const calendar = new FullCalendar.Calendar(calendarEl, {

//         locale: 'th',
//         initialView: 'dayGridMonth',
//         height: 550,

//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title',
//             right: ''
//         },

//         // events: '/calendar/events',
//         events: window.calendarEventsUrl,

//         eventClick: function(info) {
//             alert(info.event.title);
//         }

//     });

//     calendar.render();

// });
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "th",
        initialView: "dayGridMonth",
        height: 550,
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "",
        },
        events: window.calendarEventsUrl,

        // เปลี่ยนจาก alert() เป็น SweetAlert2
        eventClick: function (info) {
            // ป้องกันไม่ให้เด้งไปลิงก์อื่น (ถ้า event มี URL)
            info.jsEvent.preventDefault();
            console.log("ข้อมูล Event ทั้งหมด:", info.event);

            // ถ้าอยากดูข้อมูลที่ส่งมาจาก Backend (เช่นจาก Controller)
            console.log("ข้อมูล Extended Props:", info.event.extendedProps);
            // จัดรูปแบบวันที่ให้เป็นภาษาไทย
            const lecturer = info.event.extendedProps.lecturer || "ไม่มีข้อมูลผู้สอน";

            const eventDate = info.event.start.toLocaleDateString("th-TH", {
                year: "numeric",
                month: "long",
                day: "numeric",
            });

            const description =
                info.event.extendedProps.description ||
                "ไม่มีรายละเอียดเพิ่มเติม";

            // แสดง Popup SweetAlert2
            Swal.fire({
                title: info.event.title,
                html: `
                    <div style="text-align: left; margin-top: 10px; font-size: 15px; line-height: 1.6;">
                        <p><b>วันที่:</b> ${eventDate}</p>
                        <p><b>ผู้สอน:</b> ${lecturer}</p>

                        <hr style="border:0; border-top:1px solid #eee; margin:15px 0;">
                        <p><b>รายละเอียด:</b><br>${description}</p>
                    </div>
                `,
                icon: "info",
                confirmButtonText: "ปิดหน้าต่าง",
                confirmButtonColor: "#3b82f6",
                showCloseButton: true,
                focusConfirm: false,
                customClass: {
                    title: "prompt-font",
                },
            });
        },
    });

    calendar.render();
});
