@extends('adminlte::page')

@section('title', 'SIGER - Sistema Gerenciador de Reservas de Equipamentos')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
  
    <style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">

  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif

    
    
      
      <form method="post" action="{{ route('reservas.store') }}">
      {{ csrf_field() }}
         
         
          <div class="form-group">
         <label for="turno">Turno:</label> 
         {!!
                  Form::select('turno',[
                                  '09:00' =>'09:00',
                              	  '10:00' =>'10:00'  ,
                                  '18:00' =>'18:00',
                                ],
                               ['placeholder' => 'Selecione o turno'], ['class' => 'form-control'],);
         !!}
         </div>
          <div class="form-group">
              
             
              <label for="dtagendamento">Data de agendamento:</label>
              {!!
				Form::date('dtagendamento', \Carbon\Carbon::now(),['class' => 'form-control']);

              !!}
          </div>
	  
          <div class="form-group">
           <label for="equipamentos_id">Equipamentos:</label>

            {!!
            Form::select(
                'equipamentos_id',
                $equipamentos->pluck('descricao','id'),
                old('equipamentos_id') ?? request()->get('equipamentos_id'),
                ['placeholder' =>'Selecione o equipamento'  ,   'class' => 'form-control',
                'required' => 'required'
                ]
            )
        !!}

          </div>
          
          <button type="submit" class="btn btn-primary">Confirmar</button>
      </form>
  </div>
</div>

@stop