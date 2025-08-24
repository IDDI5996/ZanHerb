
@switch($category)
    @case('Clinical & Therapeutic Care')
        <i class="fas fa-stethoscope"></i>
    @break
    
    @case('Health Education & Training')
        <i class="fas fa-graduation-cap"></i>
    @break
    
    @case('Research & Innovation')
        <i class="fas fa-flask"></i>
    @break
    
    @case('Community Empowerment & Partnerships')
        <i class="fas fa-hands-helping"></i>
    @break
    
    @case('ZanHerb Remedies')
        <i class="fas fa-mortar-pestle"></i>
    @break
    
    @default
        <i class="fas fa-heart"></i>
@endswitch