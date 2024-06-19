<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDeExperiencia;

class TipoDeExperienciasController extends Controller
{
/*************************************************************************************************
 * ******************************C O N S U L T A R************************************************
 * ***********************************************************************************************
*/
    /**
 * @OA\Get(
 *      path="/consultar-tipos-experiencias",
 *      tags={"Tipos de Experiencias"},
 *      summary="Consultar tipos de experiencias",
 *      description="Consulta todos los tipos de experiencias o uno específico por ID.",
 *      operationId="consultarTiposExperiencias",
 *      @OA\Parameter(
 *          name="id_tipo_experiencia",
 *          in="query",
 *          description="ID del tipo de experiencia a consultar",
 *          required=false,
 *          @OA\Schema(type="integer", example=1),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Operación exitosa",
 *          @OA\JsonContent(
 *              @OA\Property(property="tipos_experiencias", type="array", @OA\Items(ref="#/components/schemas/TipoExperiencia")),
 *              @OA\Property(property="tipo_experiencia", type="object", ref="#/components/schemas/TipoExperiencia"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Tipo de experiencia no encontrado",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Tipo de experiencia no encontrado"),
 *          ),
 *      ),
 * )
 */
public function consultarTiposExperiencias(Request $request)
{
    // Verificar si se proporcionó un ID del tipo de experiencia en la solicitud
    $idTipoExperiencia = $request->input('id_tipo_experiencia');

    if ($idTipoExperiencia) {
        // Si se proporciona un ID del tipo de experiencia, devolver ese tipo de experiencia específico
        $tipoExperiencia = TipodeExperiencia::where('id_tipo_experiencia', $idTipoExperiencia)->first();


        if (!$tipoExperiencia) {
            return response()->json(['message' => 'Tipo de experiencia no encontrado'], 404);
        }

        return response()->json(['tipo_experiencia' => $tipoExperiencia], 200);
    } else {
        // Si no se proporciona un ID, devolver todos los tipos de experiencias
        $tiposExperiencias = TipodeExperiencia::all();

        return response()->json(['tipos_experiencias' => $tiposExperiencias], 200);
    }
}

}
