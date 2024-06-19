<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



use Illuminate\Http\Request;
use App\Models\Experiencia;

class ExperienciasController extends Controller
{
/*************************************************************************************************
 * ******************************C O N S U L T A R************************************************
 * ***********************************************************************************************
*/
/**
 * @OA\Get(
 *     path="/todas-las-experiencias-filtro",
 *     summary="Obtener todas las experiencias",
 *     description="Devuelve todas las experiencias con estado activa si no existe ningun filtro,
 *                  si lo hay, las devuelve filtradas.",
 *     operationId="getExperiencias",
 *     tags={"Experiencias"},
 *       @OA\Parameter(
 *         name="fecha",
 *         in="query",
 *         description="Fecha de la experiencia (formato: YYYY-MM-DD).",
 *         required=false,
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Parameter(
 *         name="tipo_experiencia",
 *         in="query",
 *         description="ID del tipo de experiencia.",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="codigo_postal",
 *         in="query",
 *         description="Código postal de la experiencia.",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de experiencias",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Experiencia")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     )
 * )
 */
    public function todasLasExperienciasFiltradas(Request $request)
{
    // Obtener los parámetros de la solicitud
    $fecha = $request->query('fecha');
    $tipoExperiencia = $request->query('tipo_experiencia');
    $codigoPostal = $request->query('codigo_postal');

    // Iniciar la consulta de experiencias sin ejecutarla con get() al final
    $query = DB::table('experiencias')
        ->join('usuarios', 'experiencias.dni_proveedor', '=', 'usuarios.dni')
        ->join('tipos_experiencia', 'experiencias.tipo', '=', 'tipos_experiencia.id_tipo_experiencia')
        ->join('localidades', 'experiencias.codigo_postal_experiencia', '=', 'localidades.codigo_postal')
        ->select('experiencias.*', 'usuarios.*', 'tipos_experiencia.*', 'localidades.*');

        $query->where('estado_experiencia', '=', 'activa');

    // Aplicar filtros según los parámetros recibidos
    if ($fecha) {
        $query->where('experiencias.fecha_experiencia', '=', $fecha);
    }

    if ($tipoExperiencia) {
        $query->where('experiencias.tipo', '=', $tipoExperiencia);
    }

    if ($codigoPostal) {
        $query->where('experiencias.codigo_postal_experiencia', '=', $codigoPostal);
    }

    // Obtener el resultado de la consulta
    $experiencias = $query->get();
    
    if ($experiencias->isEmpty()) {
        return response()->json(['mensaje' => 'No se encontraron experiencias'], 404);
    }

    // Aquí puedes formatear el resultado según tus necesidades antes de devolverlo
    $responseArray = [];

    foreach ($experiencias as $experiencia) {
        $fechaNacimiento = $experiencia->fecha_nacimiento; 
        $edad = Carbon::parse($fechaNacimiento)->age;

        $responseArray[] = [
            'id_experiencia' => $experiencia->id_experiencia,
            'estado_experiencia' => $experiencia->estado_experiencia,
            'titulo_experiencia' => $experiencia->titulo_experiencia,
            'descripcion_experiencia' => $experiencia->descripcion_experiencia,
            'lugar_partida' => $experiencia->lugar_partida,
            'coste_estimado' => $experiencia->coste_estimado,
            'fecha_experiencia' => $experiencia->fecha_experiencia,
            'tipo_experiencia' => [
                'id_tipo_experiencia' => $experiencia->id_tipo_experiencia,
                'nombre_tipo' => $experiencia->nombre_tipo,
                'estilo' => $experiencia->estilo,
                'lugares_interes' => $experiencia->lugares_interes,
            ],
            'localidad' => [
                'codigo_postal' => $experiencia->codigo_postal,
                'nombre_localidad' => $experiencia->nombre_localidad,
                'provincia_localidad' => $experiencia->provincia_localidad,
                'pais_localidad' => $experiencia->pais_localidad,
            ],
            'usuario' => [
                'dni' => $experiencia->dni_proveedor,
                'nombre_usuario' => $experiencia->nombre_usuario,
                'apellidos' => $experiencia->apellidos,
                'edad' => $edad,
                'sobre_mi' => $experiencia->sobremi,
                'telefono' => $experiencia->telefono,
                'email' => $experiencia->email,                
            ],
        ];
    }

    return response()->json($responseArray, 200);
}

/**
 * @OA\Get(
 *     path="/api/consultar-experiencia",
 *     summary="Consultar experiencia por ID",
 *     description="Consulta una experiencia en la base de datos por su ID.",
 *     operationId="consultarExperiencia",
 *     tags={"Experiencias"},
 *     @OA\Parameter(
 *         name="id_experiencia",
 *         in="query",
 *         required=true,
 *         description="ID de la experiencia a consultar",
 *         @OA\Schema(type="integer", example=1),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Experiencia encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Experiencia encontrada"),
 *             @OA\Property(property="experiencia", type="object", description="Datos de la experiencia encontrada", ref="#/components/schemas/Experiencia"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Experiencia no encontrada",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Experiencia no encontrada"),
 *         ),
 *     ),
 * )
 */
public function consultarExperiencia(Request $request)
{
    $idExperiencia = $request->query('id_experiencia');

    // Realizar INNER JOIN con tipos_experiencia
    $experiencia = DB::table('experiencias')
        ->join('tipos_experiencia', 'experiencias.tipo', '=', 'tipos_experiencia.id_tipo_experiencia')
        ->where('experiencias.id_experiencia', $idExperiencia)
        ->select('experiencias.*', 'tipos_experiencia.*')
        ->first();

    if ($experiencia) {
        // Experiencia encontrada
        return response()->json(['mensaje' => 'Experiencia encontrada', 'experiencia' => $experiencia], 200);
    } else {
        // Experiencia no encontrada
        return response()->json(['mensaje' => 'Experiencia no encontrada'], 404);
    }
}

/*************************************************************************************************
 * **************************************C R E A R************************************************
 * ***********************************************************************************************
*/
/**
 * @OA\Post(
 *     path="/api/experiencias",
 *     summary="Insertar una nueva experiencia",
 *     description="Crea y guarda una nueva experiencia en la base de datos.",
 *     operationId="insertarExperiencia",
 *     tags={"Experiencias"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la nueva experiencia",
 *         @OA\JsonContent(
 *             required={"titulo_experiencia", "descripcion_experiencia", "lugar_partida", "coste_estimado", "fecha_experiencia", "tipo_experiencia", "codigo_postal_experiencia", "dni_proveedor"},
 *             @OA\Property(property="titulo_experiencia", type="string"),
 *             @OA\Property(property="descripcion_experiencia", type="string"),
 *             @OA\Property(property="lugar_partida", type="string"),
 *             @OA\Property(property="coste_estimado", type="number"),
 *             @OA\Property(property="fecha_experiencia", type="string", format="date"),
 *             @OA\Property(property="tipo_experiencia", type="integer"),
 *             @OA\Property(property="codigo_postal_experiencia", type="string"),
 *             @OA\Property(property="dni_proveedor", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Experiencia insertada correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="id_experiencia", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 */
public function insertarExperiencia(Request $request){
    
    // Validar los datos del formulario antes de insertarlos en la base de datos
    $request->validate([
        'titulo_experiencia' => 'required|string',
        'descripcion_experiencia' => 'required|string',
        'lugar_partida' => 'required|string',
        'coste_estimado' => 'required|numeric',
        'fecha_experiencia' => 'required|date',
        'tipo_experiencia' => 'required|integer',
        'codigo_postal_experiencia' => 'required|string',
        'dni_proveedor' => 'required|string',
        
    ]);

    // Crear una nueva instancia del modelo Experiencia y asignar los valores
    $experiencia = new Experiencia();
    $experiencia->titulo_experiencia = $request->input('titulo_experiencia');
    $experiencia->descripcion_experiencia = $request->input('descripcion_experiencia');
    $experiencia->lugar_partida = $request->input('lugar_partida');
    $experiencia->coste_estimado = $request->input('coste_estimado');
    $experiencia->fecha_experiencia = $request->input('fecha_experiencia');
    $experiencia->tipo = $request->input('tipo_experiencia');
    $experiencia->codigo_postal_experiencia = $request->input('codigo_postal_experiencia');
    $experiencia->dni_proveedor = $request->input('dni_proveedor');
    $experiencia->estado_experiencia = 'activa';

    // Guardar la experiencia en la base de datos
    $experiencia->save();

    // Puedes devolver una respuesta adecuada, como el ID de la experiencia recién creada
    return response()->json(['message' => 'Experiencia insertada correctamente', 'id_experiencia' => $experiencia->id], 201);

}
/*************************************************************************************************
 * ******************************A C T U A L I Z A R**********************************************
 * ***********************************************************************************************
*/
/*
@OA\Get(
    *     path="/cambiar-estado",
    *     summary="Cambiar el estado de una experiencia a inactiva",
    *     description="Actualiza el estado de una experiencia a 'reservada' en la base de datos.",
    *     operationId="cambiarEstadoExperiencia",
    *     tags={"Experiencias"},
    *     @OA\Parameter(
    *         name="id_experiencia",
    *         in="query",
    *         description="ID de la experiencia a la que se cambiará el estado.",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Estado de la experiencia cambiado a inactiva",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Experiencia no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string")
    *         )
    *     )
    * )
    */
public function cambiarEstadoExperiencia(Request $request){

    $id_experiencia = $request->input('id_experiencia');

    // Cambiar el estado de la experiencia a "inactiva"
    Experiencia::where('id_experiencia', $id_experiencia)
        ->update(['estado_experiencia' => 'reservada']);

    return response()->json(['message' => 'Estado de la experiencia cambiado a inactiva'], 200);

}
    
}
