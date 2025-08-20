@component('mail::message')
# Response to Your Contact Message

Dear {{ $contact->name }},

Thank you for contacting us. Here is our response to your message:

> "{{ $contact->message }}"

**Our Response:**  
{{ $contact->admin_response }}

If you have any further questions, please don't hesitate to contact us again.

Thanks,  
{{ config('app.name') }}
@endcomponent