@extends('adminlte::page')

@section('title', 'SIGER - Sistema Gerenciador de Reservas de Equipamentos')

@section('content_header')
    <h1>Reservas de Equipamentos</h1>
@stop

@section('content')
  
<style>
  .uper {
    margin-top: 40px;
  }


  * {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
    
    
<div class="card uper">
  <div class="card-header">
    <div class="topnav">
      <a class="active" href='javascript:create.submit()'>Reservar</a>
    <a  href="{{ route('reservas.index')}}">Voltar</a>
   <div class="search-container">
   
   
   </div>
  </div>
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

    
    
      
      <form  name="create" method="post" action="{{ route('reservas.store') }}">
      {{ csrf_field() }}
         
         
          <div class="form-group">
         <label for="horario">Horário de agendamento:</label> 
         {!!
                  Form::select('horario',[
                                  '09:00:00' =>'09:00',
                              	  '10:00:00' =>'10:00'  ,
                                  '18:00:00' =>'18:00',
                                  '00:00:00' =>'00:00',
                                ],
                               ['placeholder' => 'Selecione o turno'], ['class' => 'form-control'],);
         !!}
         </div>
          <div class="form-group">
              
             
              <label for="dt_agendamento">Data de agendamento:</label>
              {!!
				Form::date('dt_agendamento', \Carbon\Carbon::now(),['class' => 'form-control']);

              !!}
          </div>
	  
          <div class="form-group">
           <label for="equipamentos_id">Equipamentos:</label>
        


{!!
              

         
         Form::select(
                'equipamentos_id',
                $equipamentos=\App\Models\Equipamentos::select(
                  DB::raw('CONCAT(descricao, " Etiqueta: ", etiqueta) AS juncao, id'))
                 ->pluck('juncao', 'id'), 
                old('equipamentos_id') ?? request()->get('equipamentos_id'),
                ['placeholder' =>'Selecione o equipamento'  ,   'class' => 'form-control',
                'required' => 'required'
                ]);

        !!}

          </div>
          
          
      </form>
  </div>
</div>

@stop
