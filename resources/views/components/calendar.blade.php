@props([
    'events' => [],
    'editable' => false,
    'selectable' => false,
    'height' => '600px',
    'initialView' => 'dayGridMonth',
    'headerToolbar' => [
        'left' => 'prev,next today',
        'center' => 'title',
        'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
    ]
])

@php
    $calendarId = 'calendar_' . uniqid();
@endphp

<div id="{{ $calendarId }}" style="height: {{ $height }}"></div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('{{ $calendarId }}');
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: '{{ $initialView }}',
            headerToolbar: @json($headerToolbar),
            events: @json($events),
            editable: {{ $editable ? 'true' : 'false' }},
            selectable: {{ $selectable ? 'true' : 'false' }},
            dayMaxEvents: true,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            eventClick: function(info) {
                calendarEl.dispatchEvent(new CustomEvent('eventClick', {
                    detail: info.event
                }));
            },
            dateClick: function(info) {
                calendarEl.dispatchEvent(new CustomEvent('dateClick', {
                    detail: info
                }));
            },
            select: function(info) {
                calendarEl.dispatchEvent(new CustomEvent('select', {
                    detail: info
                }));
            },
            eventDrop: function(info) {
                calendarEl.dispatchEvent(new CustomEvent('eventDrop', {
                    detail: {
                        event: info.event,
                        oldEvent: info.oldEvent,
                        delta: info.delta,
                        revert: info.revert
                    }
                }));
            },
            eventResize: function(info) {
                calendarEl.dispatchEvent(new CustomEvent('eventResize', {
                    detail: {
                        event: info.event,
                        oldEvent: info.oldEvent,
                        startDelta: info.startDelta,
                        endDelta: info.endDelta,
                        revert: info.revert
                    }
                }));
            }
        });

        calendar.render();

        // Make calendar instance available globally
        window.calendars = window.calendars || {};
        window.calendars['{{ $calendarId }}'] = calendar;
    });
</script>

<style>
.fc-toolbar-title {
    font-size: 1.25rem !important;
    font-weight: 600 !important;
}

.fc-button-primary {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}

.fc-button-primary:hover {
    background-color: #5c636a !important;
    border-color: #565e64 !important;
}

.fc-button-primary:disabled {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}

.fc-button-primary:not(:disabled):active,
.fc-button-primary:not(:disabled).fc-button-active {
    background-color: #565e64 !important;
    border-color: #51585e !important;
}

.fc-day-today {
    background-color: rgba(13, 110, 253, 0.05) !important;
}

.fc-event {
    border: none !important;
    padding: 2px 4px !important;
    font-size: 0.875rem !important;
}

.fc-event-time {
    font-weight: 600 !important;
}

.fc-list-event-time {
    font-weight: 600 !important;
}

.fc-list-event-dot {
    border-color: currentColor !important;
}

.fc-day-grid-event {
    margin: 1px 5px 0 !important;
}

.fc-timeGridWeek-view .fc-event,
.fc-timeGridDay-view .fc-event {
    border-radius: 4px !important;
    margin: 1px 1px 0 !important;
}

.fc-more-popover {
    border-radius: 6px !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.fc-popover-header {
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
}

.fc-popover-body {
    padding: 0.5rem 0.75rem !important;
}
</style>
@endpush