<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localidad;

class LocalidadesController extends Controller
{
/*************************************************************************************************
* **************************************C R E A R************************************************
* ***********************************************************************************************
*/
/**
 * @OA\Post(
 *      path="/insertar-localidad",
 *      tags={"Localidades"},
 *      summary="Insertar o encontrar una localidad",
 *      description="Inserta una nueva localidad o encuentra una existente por código postal.",
 *      operationId="insertarLocalidad",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Datos de la localidad",
 *          @OA\JsonContent(
 *              required={"codigo_postal", "nombre_localidad", "provincia_localidad", "pais_localidad"},
 *              @OA\Property(property="codigo_postal", type="string", example="23747", description="Código postal de la localidad"),
 *              @OA\Property(property="nombre_localidad", type="string", example="Vegas de Triana", description="Nombre de la localidad"),
 *              @OA\Property(property="provincia_localidad", type="string", example="Jaén", description="Provincia de la localidad"),
 *              @OA\Property(property="pais_localidad", type="string", example="España", description="País de la localidad"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Operación exitosa",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Localidad insertada o encontrada correctamente"),
 *              @OA\Property(property="codigo_postal", type="string", example="23747", description="Código postal de la localidad insertada o encontrada"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Error de validación",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Error de validación"),
 *              @OA\Property(property="errors", type="object", example={"codigo_postal": {"El código postal es requerido."}}),
 *          ),
 *      ),
 * )
 */
    public function insertarLocalidad(Request $request)
    {
        // Validar los datos del formulario antes de insertarlos en la base de datos
        $request->validate([
            'codigo_postal' => 'required|string',
            'nombre_localidad' => 'required|string',
            'provincia_localidad' => 'required|string',
            'pais_localidad' => 'required|string',
            // Agrega aquí las reglas de validación adicionales según tus necesidades
        ]);

        // Buscar una localidad existente por clave primaria
        $codigoPostal = $request->input('codigo_postal');  // Reemplaza con el código postal que estás buscando

        // Buscar por código postal
        $localidad = Localidad::where('codigo_postal', $codigoPostal)->first();

        // Si no se encuentra, crear una nueva instancia
        if (!$localidad) {
            $localidad = new Localidad();
            $localidad->codigo_postal = $codigoPostal;
            // Asigna otros valores si es necesario
            $localidad->nombre_localidad = $request->input('nombre_localidad');
            $localidad->provincia_localidad = $request->input('provincia_localidad');
            $localidad->pais_localidad = $request->input('pais_localidad');
            $localidad->save();
        }

        // Puedes devolver una respuesta adecuada, como el ID de la localidad creada o encontrada
        return response()->json(['message' => 'Localidad insertada o encontrada correctamente', 'codigo_postal' => $localidad->codigo_postal], 200);
    }
/*************************************************************************************************
 * ******************************C O N S U L T A R************************************************
 * ***********************************************************************************************
*/
/**
 * @OA\Get(
 *      path="/consultar-localidades",
 *      tags={"Localidades"},
 *      summary="Consultar localidades",
 *      description="Consulta todas las localidades o una específica por código postal.",
 *      operationId="consultarLocalidades",
 *      @OA\Parameter(
 *          name="codigo_postal",
 *          in="query",
 *          description="Código postal de la localidad a consultar",
 *          required=false,
 *          @OA\Schema(type="string", example="23747"),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Operación exitosa",
 *          @OA\JsonContent(
 *              @OA\Property(property="localidades", type="array", @OA\Items(ref="#/components/schemas/Localidad")),
 *              @OA\Property(property="localidad", type="object", ref="#/components/schemas/Localidad"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Localidad no encontrada",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Localidad no encontrada"),
 *          ),
 *      ),
 * )
 */
    public function consultarLocalidades(Request $request)
    {
        // Verificar si se proporcionó un código postal en la solicitud
        $codigoPostal = $request->input('codigo_postal');

        if ($codigoPostal) {
            // Si hay un código postal, devolver los datos de la localidad específica
            $localidad = Localidad::where('codigo_postal', $codigoPostal)->first();

            if (!$localidad) {
                return response()->json(['message' => 'Localidad no encontrada'], 404);
            }

            return response()->json(['localidad' => $localidad], 200);
        } else {
            // Si no se proporciona un código postal, devolver todas las localidades
            $localidades = Localidad::all();

            return response()->json(['localidades' => $localidades], 200);
        }
    }
}
