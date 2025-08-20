@component('mail::message')
# Booking Cancellation Notification

Dear {{ $booking->name }},

We regret to inform you that your booking scheduled for **{{ $booking->preferred_date->format('l, F j, Y') }} at {{ $booking->preferred_time }}** has been cancelled.

**Reason for cancellation:**  
{{ $booking->cancellation_reason }}

If you believe this is a mistake or would like to reschedule, please contact us.

@component('mail::button', ['url' => route('bookings.create')])
Book Another Appointment
@endcomponent

{{-- END OF BUTTON COMPONENT --}}

Thanks,  
{{ config('app.name') }}
@endcomponent