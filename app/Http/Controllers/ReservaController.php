<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listar_reserva = Reserva::join('estados', 'reservas.intEst', '=', 'estados.intIdEstdo')
            ->select(
                'reservas.varNom',
                'reservas.varApe',
                'reservas.varEmai',
                'reservas.intTel',
                'reservas.dateRes',
                'reservas.timeRes',
                'reservas.varLugar',
                'reservas.intCant',
                'reservas.varCom',
                'estados.varEstado'
            )
            ->get();
        return $listar_reserva;
    }
    public function verificarreserva(Request $request)
    {
        $validar =  array('mensaje' => "", "errores" => array());
        $regla = [
            'varNom' => 'required|max:255',
            'varApe' => 'required|max:255',
            'varCodeReserva' => 'required',
        ];
        $messages = [
            'varNom.required' => 'Ingrese su nombre.',
            'varApe.required' => 'Ingrese su apellido.',
            'varCodeReserva.required' => 'Ingrese el codigo de reserva'
        ];
        $validator = \Validator::make($request->all(), $regla, $messages);
        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            for($i=0;count($errors)>$i;$i++){
                $validar['errores'][] .=$errors[$i];
            }
            
            //dd($validar);
            return response()->json($validar);
        } else {
            //dd($request->input('varNom'),$request->input('varApe'),$request->input('varCodeReserva'));
            $listar_reserva = Reserva::join('estados', 'reservas.intEst', '=', 'estados.intIdEstdo')
                ->where('reservas.varNom', '=', trim($request->input('varNom')))
                ->where('reservas.varApe', '=', trim($request->input('varApe')))
                ->where('reservas.varCodeReserva', '=', trim($request->input('varCodeReserva')))
                ->select(
                    'estados.varEstado'
                )
                ->get();
                $validar['mensaje']=$listar_reserva;    
            return $validar;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar =  array('mensaje' => "", "errores" => array());
        $regla = [
            'varNom' => 'required|max:255',
            'varApe' => 'required|max:255',
            'varEmai' => 'required|max:255|email',
            'intTel' => 'required|numeric',
            'dateRes' => 'required|date',
            'timeRes' => 'required',
            'varLugar' => 'required',
            'intCant' => 'required|numeric'
        ];
        $messages = [
            'varNom.required' => 'Ingrese su nombre.',
            'varApe.required' => 'Ingrese su apellido.',
            'varEmai.required' => 'Ingrese su email.',
            'varEmai.email' => 'El campo debe ser email',
            'intTel.required' => 'Ingrese su número telefónico',
            'intTel.numeric' => 'El campo debe ser numerico',
            'dateRes.required' => 'Ingrese la fecha de reservación',
            'dateRes.date' => 'El campo debe ser una fecha',
            'timeRes.required' => 'Ingrese la hora de reservación',
            'varLugar.required' => 'Seleccione el lugar de la reservación',
            'intCant.required' => 'Ingrese la cantidad de personas',
            'intCant.numeric' => 'El campo debe ser numerico'
        ];
        $validator = \Validator::make($request->all(), $regla, $messages);
        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            for($i=0;count($errors)>$i;$i++){
                $validar['errores'][] .=$errors[$i];
            }
            //dd($validar);
            return response()->json($validar);
        } else {
            try {
                date_default_timezone_set('America/Lima');
                $fecha_registro = date("Y-m-d H:i:s");
                $reserva = new Reserva;
                $reserva->varNom = $request->input('varNom');
                $reserva->varApe = $request->input('varApe');
                $reserva->varEmai = $request->input('varEmai');
                $reserva->intTel = $request->input('intTel');
                $reserva->dateRes = $request->input('dateRes');
                $reserva->timeRes = $request->input('timeRes');
                $reserva->varLugar = $request->input('varLugar');
                $reserva->intCant = $request->input('intCant');
                if ($request->input('varCom')) {
                    $reserva->varCom = $request->input('varCom');
                }else {
                    $reserva->varCom = '';
                }
                $reserva->dateResF = $fecha_registro;
                $reserva->intEst = 1;
                $reserva->varCodeReserva = md5($request->input('varNom') . $request->input('varApe'));
                $reserva->save();
                $validar['mensaje']='';    
            } catch (Exception $e) {
                report($e);
                return false;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function Confirmar(Request $request)
    {
        $regla = [
            'intIdRes' => 'required|numeric',
            'intEst' => 'required|numeri'
        ];
        $messages = [
            'intIdRes.required' => 'Ingrese el id',
            'intIdRes.numeric' => 'El campo debe ser numerico',
            'intEst.required' => 'Ingrese el id del estado',
            'intEst.numeric' => 'El campo debe ser numerico'

        ];
        $validator = \Validator::make($request->all(), $regla, $messages);
        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            return response()->json($errors);
        } else {
            try {
                date_default_timezone_set('America/Lima');
                $reserva = Reserva::find((int) $request->input('intIdRes'));
                $reserva->intIdEstdo = (int) $request->input('intEst');
                $reserva->save();
            } catch (Exception $e) {
                report($e);
                return false;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
    public function validar_registro(Request $request)
    {
    }
}
