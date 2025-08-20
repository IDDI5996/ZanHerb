@component('mail::message')
@if($isUserCopy)
# Booking Confirmation
Thank you for booking with us! Here are your details:
@else
# New Booking Notification
You have received a new booking:
@endif

**Name:** {{ $booking->name }}  
**Email:** {{ $booking->email }}  
**Phone:** {{ $booking->phone }}  
**Condition:** {{ $booking->condition }}  
**Preferred Date:** {{ $booking->preferred_date->format('F j, Y') }}  
**Preferred Time:** {{ $booking->preferred_time }}

@if($isUserCopy)
We'll contact you shortly to confirm your appointment.  
If you need to make any changes, please contact us.
@else
You can view this booking in the admin dashboard:
@component('mail::button', ['url' => route('admin.bookings.show', $booking)])
View Booking
@endcomponent
@endif

Thanks,  
{{ config('app.name') }}
@endcomponent