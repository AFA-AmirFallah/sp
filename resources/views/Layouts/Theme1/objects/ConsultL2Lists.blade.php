
@foreach ($Consult->get_consulting_Zone($CatID) as $Zone )

   <a onclick="l2laoding({{ $CatID }},{{ $Zone->L2ID }})">{{ $Zone->Name }}</a> 
    
@endforeach