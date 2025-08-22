@component('mail::message')
# New Collaborator Request

**Organization:** {{ $collaborator->organization }}  
**Contact Name:** {{ $collaborator->contact_name }}  
**Email:** {{ $collaborator->email }}  

**Message:**  
{{ $collaborator->message }}

Thanks,  
{{ config('app.name') }}
@endcomponent
