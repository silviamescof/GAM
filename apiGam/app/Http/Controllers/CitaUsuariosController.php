<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CitaUsuario;
use App\Models\Experiencia;

class CitaUsuariosController extends Controller
{
 /**
 * @OA\Post(
 *     path="/crear-cita",
 *     summary="Crear cita",
 *     description="Crear una nueva cita en la base de datos.",
 *     operationId="crearCita",
 *     tags={"Citas"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la cita a crear",
 *         @OA\JsonContent(
 *             required={"dni_consumidor", "dni_proveedor", "id_experiencia"},
 *             @OA\Property(property="dni_consumidor", type="string", example="12345678A", description="DNI del consumidor"),
 *             @OA\Property(property="dni_proveedor", type="string", example="87654321B", description="DNI del proveedor asociado a la experiencia"),
 *             @OA\Property(property="id_experiencia", type="integer", example=1, description="ID de la experiencia asociada a la cita"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Cita creada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Cita creada exitosamente"),
 *             @OA\Property(property="id_cita", type="integer", example=1, description="ID de la cita recién creada"),
 *             @OA\Property(property="id_experiencia", type="integer", example=1, description="ID de la experiencia asociada a la cita"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Error de validación"),
 *             @OA\Property(property="errores", type="object", description="Detalles de los errores de validación", ref="#/components/schemas/ValidationError"),
 *         ),
 *     ),
 * )
 */
public function crearCita(Request $request)
{
    // Validar los datos del formulario antes de insertarlos en la base de datos
    $request->validate([
        'dni_consumidor' => 'required|string',
        'dni_proveedor' => 'required|string',
        'id_experiencia' => 'required|integer',
    ]);

    // Verificar que el DNI del proveedor corresponda al DNI asociado a la experiencia
    $experiencia = Experiencia::where('id_experiencia', $request->input('id_experiencia'))->first();

    if ($experiencia && $experiencia->dni_proveedor === $request->input('dni_proveedor')) {
        // Cambiar el estado de la experiencia a "reservada"
        Experiencia::where('id_experiencia', $request->input('id_experiencia'))
        ->update(['estado_experiencia' => 'reservada']);
        // Crear una nueva instancia del modelo Cita y asignar los valores
        $nuevaCita = new CitaUsuario();
        $nuevaCita->dni_consumidor = $request->input('dni_consumidor');
        $nuevaCita->id_experiencia = $request->input('id_experiencia');

        // Guardar la cita en la base de datos
        $nuevaCita->save();

        // Puedes devolver una respuesta adecuada, como el ID de la cita y la ID de la experiencia recién creadas
        return response()->json([
            'mensaje' => 'Cita creada exitosamente',
            'id_cita' => $nuevaCita->id_cita,
            'id_experiencia' => $nuevaCita->id_experiencia,
        ], 201);
    } else {
        // Devolver un error indicando que el DNI del proveedor no coincide con el DNI asociado a la experiencia
        return response()->json(['mensaje' => 'Error de validación', 'errores' => ['dni_proveedor' => 'El DNI del proveedor no se corresponde con la experiencia o la experiencia no existe en la base de datos']], 422);
    }
}


}
