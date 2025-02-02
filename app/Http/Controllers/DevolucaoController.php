<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\EquipamentosController;
use App\Models\Devolucao;
use App\Models\Reservas;
use App\Models\Equipamentos;
use App\Models\User;
use App\Repositories\Contracts\EquipamentosRepositoryInterface;
use App\Repositories\Contracts\ReservasRepositoryInterface;
use App\Repositories\Contracts\DevolucaoRepositoryInterface;
use PDF;
use DB;

class DevolucaoController extends Controller
{
    /**
     * Display a listing of the resource. n
     *
     * @return \Illuminate\Http\Response
     */
   
   
    public function __construct(DevolucaoRepositoryInterface $repo,ReservasRepositoryInterface $repore, EquipamentosRepositoryInterface $repoeq )
    {
            $this->repo=$repo;
            $this->repore=$repore;
            $this->repoeq=$repoeq;
    }
   
     public function index()
    {
       //Este método serve para exibição da tela de devolução de equipamento, no caso está exibindo em ordem decrescente, e só exibe os contéudos se caso existir reservas
       
        $devolucao = $this->repo->getAll();
        return view('devolucao.index', compact('devolucao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Este médoto serve para exibir a tela que efetua a ação do registro de devolução nesse caso só irá apresentar uma lista apenas com equipamentos que estiver com o status Indisponível
        $devolucao= $this->repo->getTodos();
        $equipamentos =$this->repore->getReservados();
        return view('devolucao.create')->withEquipamentos($equipamentos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
            $request->validate( [
            'reservas_id'   => 'required',         
            'obs'           => 'required|max:190',
            'data'          => 'required|date|date_format:Y-m-d|after_or_equal:'.\Carbon\Carbon::now()->format('Y-m-d'),
            'hora'          => 'required',
        ],
        
        [   
            'obs.required'=> 'O campo observações deve ser preenchido obrigatóriamente',
            'data.after_or_equal' =>'Data inválida',
            'reservas_id.required'=> 'Selecione o equipamento a ser devolvido',
            'hora.required' =>'Insira a hora',   
        ]);                  
               
            $devolucao = $this->repo->create([
            'reservas_id'           => $request->get('reservas_id'),
            'obs'                   => $request->get('obs'),
            'data'                  => $request->get('data'),
            'hora'                  => $request->get('hora'),
            'user_id'               => auth()->user()->id,
           
          ]);
       
                  
                          

             
                  
                $reservas = $this->repore->getById($devolucao->reservas_id);
                $reservas->is_devolvido= true;
                $reservas->save(); 
                $equipamentos = $this->repoeq->getById($devolucao->reservas->equipamentos_id);
                $equipamentos->status='Indisponível';
                $equipamentos->save();
                alert()->success('Equipamento devolvido com sucesso');
                return redirect('/devolucao');
               
              
               
           
         
             
        
          
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generatePDF()

    {
        
        $devolucao=$this->repo->getAll();
        $pdf = PDF::loadView('devolucao/devolucaoPDF',['devolucao'=> $devolucao])->setPaper('a4', 'landscape');
        return $pdf->download('devolucao.pdf');

    }

    public function busca (Request $request)
    {
        $search= date( 'Y-m-d' , strtotime($request->pesquisar));    
        $devolucao = Devolucao::where('data', 'LIKE', '%'.$search.'%')->count();
        if($devolucao==0){
            alert()->error('Não existe equipamentos devolvidos de acordo com a data selecionada');
            return redirect('/devolucao');
        }
        else{

            $devolucao = Devolucao::where('data', 'LIKE', '%'.$search.'%')->paginate();
            return view('devolucao.index', compact('devolucao','search'));

            }
    }
   
}


//a
