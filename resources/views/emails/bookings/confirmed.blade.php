@component('mail::message')
# Booking Confirmation

Dear {{ $booking->name }},

Your booking has been confirmed for **{{ $booking->preferred_date->format('l, F j, Y') }} at {{ $booking->preferred_time }}**.

Here are your booking details:
- Name: {{ $booking->name }}
- Email: {{ $booking->email }}
- Phone: {{ $booking->phone }}
- Condition: {{ $booking->condition }}
- Date: {{ $booking->preferred_date->format('F j, Y') }}
- Time: {{ $booking->preferred_time }}

If you need to make any changes, please contact us.

Thanks,  
{{ config('app.name') }}
@endcomponent