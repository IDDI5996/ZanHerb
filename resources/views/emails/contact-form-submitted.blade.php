@component('mail::message')
# New Contact Form Submission

You have received a new contact form submission:

**Name:** {{ $contact->name }}  
**Email:** {{ $contact->email }}  
**Message:**  
{{ $contact->message }}

@component('mail::button', ['url' => route('admin.contacts.show', $contact)])
View in Admin Panel
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent