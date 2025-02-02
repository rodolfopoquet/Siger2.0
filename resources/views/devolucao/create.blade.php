@extends('adminlte::page')

@section('title', 'SIGER - Sistema Gerenciador de Reservas')

@section('content_header')
    <h1>Devoluções de equipamentos</h1>
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
      <a class="active" href='javascript:create.submit()'>Confirmar devolução</a>
    <a  href="{{ route('devolucao.index')}}">Voltar</a>
   <div class="search-container">
   
   
   </div>
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
      <br>
      <br>
      <p>Observação: Os equipamentos serão exibidos de acordo com a data e hora de agendamento  </p>

      <form  name ="create" method="post" action="{{ route('devolucao.store') }}">
        @csrf
        <div class="form-group">
             
        
             
             <label for="reservas_id">Equipamento reservado:</label>

             {!!
            Form::select(
                'reservas_id',
                 $equipamentos->pluck('equipamentos.descricao','id'),
                old('reservas_id') ?? request()->get('reservas_id'),
                ['placeholder'=>'Selecione o equipamento', 'class' => 'form-control']
            )
        !!}

        <div class="form-group">
 		<label for="hora">Hora da devolução:</label>
        	<input type="time"  class="form-control" name="hora" />
	  </div>


               </div>
	      <label for="data">Data da devolução:</label>
       
        {!!
				Form::date('data', \Carbon\Carbon::now(),['class' => 'form-control']);

              !!}
          </div>
       

     <div class="form-group">
 		<label for="obs">Observações:</label>
        	<textarea id="obs" class="form-control" name="obs"></textarea>
	 
      
      
      </form>
  </div>
</div>

@stop
