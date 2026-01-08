@foreach ($Consult->get_consulting_Aria($CatID, $ZoneID) as $Zone)
    {{ $Zone['L3']->Name }}
    @foreach ($Zone['WorkerSkill'] as $WorkerSkill)
       {{ $WorkerSkill->UserName }}
    @endforeach
@endforeach
