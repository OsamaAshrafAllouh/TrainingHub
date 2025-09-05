@extends('Dashboard.master')

@section('title')
    Attended to Program
@endsection

@section('css')

@endsection

@section('content')
    <div class="card">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Google Calendar
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-light-primary font-weight-bold" data-toggle="modal"
                       data-target="#attendanceModal">
                        <i class="ki ki-plus "></i> Add Attended
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="kt_calendar"></div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add attendance form -->
                    <form id="attendanceForm" method="POST" action="{{ route('add.attendance') }}">
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                            </select>
                        </div>
                        <input type="hidden" id="programId" name="program_id" value="{{ $program->id }}">
                        <input type="hidden" id="program" name="program" value="{{ $program }}">
                        <input type="hidden" id="traineeId" name="trainee_id"
                               value="{{ \App\Models\Trainee::where('email', Auth()->user()->email)->value('id') }}">
                        <input type="hidden" id="date" name="date" value="{{ date('Y-m-d') }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection


@section('js')

    <script>
        var KTCalendarBasic = function () {
            var programStart = "{{ $program->start_date }}";
            var programEnd = "{{ $program->end_date }}";
            var name = "{{ $program->name }}";
            return {
                // main function to initiate the module
                init: function () {
                    var calendarEl = document.getElementById('kt_calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'googleCalendar'],

                        isRTL: KTUtil.isRTL(),
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },

                        displayEventTime: false, // don't show the time column in list view

                        height: 800,
                        contentHeight: 780,
                        aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                        views: {
                            dayGridMonth: {buttonText: 'month'},
                            timeGridWeek: {buttonText: 'week'},
                            timeGridDay: {buttonText: 'day'}
                        },

                        defaultView: 'dayGridMonth',

                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        navLinks: true,


                        events: [
                            {
                                title: '{{ $program->name }} Program Start',
                                start: '{{ $program->start_date }}',
                                allDay: true,
                                className: 'bg-warning'
                            },
                            {
                                title: '{{ $program->name }} Program End',
                                start: '{{ $program->end_date }}',
                                allDay: true,
                                className: 'bg-warning'
                            },
                                @php
                                    $start = \Carbon\Carbon::parse($program->start_date);
                                    $end = \Carbon\Carbon::today(); // Get today's date
                                    $date = $start;
                                    $name = json_encode($program->name);
                                    while ($date < $end && $start != $end) {
                                        $attendance = $attendances->where('date', $date->toDateString())->first();
                                        if (!$attendance) {
                                            echo "{\n";
                                            echo "    title: 'Absent',\n";
                                            echo "    start: '".$date->toDateString()."',\n";
                                            echo "    allDay: true,\n";
                                            echo "    className: 'bg-danger'\n";
                                            echo "},\n";
                                        }
                                        $date->addDay();
                                    }
                                @endphp
                                @foreach($attendances as $attendance)
                            {
                                title: '{{$attendance->status}}',
                                start: '{{ $attendance->date }}',
                                allDay: true,
                                className: '{{ $attendance->status == "present" ? "bg-info" : "bg-danger" }}'
                            },
                            @endforeach
                        ],
                        // Add event button click
                        customButtons: {
                            addEventButton: {
                                text: 'Add Event',
                                click: function () {
                                    var dateStr = prompt('Enter a date (YYYY-MM-DD):');
                                    var date = new Date(dateStr + 'T00:00:00'); // Convert to ISO format

                                    if (!isNaN(date.valueOf())) {
                                        calendar.addEvent({
                                            title: 'Attendance',
                                            start: date,
                                            allDay: true
                                        });
                                    } else {
                                        alert('Invalid date. Please try again.');
                                    }
                                }
                            }
                        },

                        loading: function (bool) {
                            // Handle loading state
                        },

                        eventRender: function (info) {
                            // Handle event rendering
                        },

                        // Handle click on a date
                        dateClick: function (info) {
                            var clickedDate = info.date;
                            if (clickedDate < programStart || clickedDate > programEnd) {
                                return false;
                            } else {
                                // Set the attendance date in the modal and open it
                                $("#attendanceDate").val(clickedDate.format('YYYY-MM-DD'));
                                $("#attendanceModal").modal("show");
                            }
                        }
                    });

                    calendar.render();
                }
            };
        }();
        jQuery(document).ready(function () {
            KTCalendarBasic.init();
        });
    </script>
@endsection
