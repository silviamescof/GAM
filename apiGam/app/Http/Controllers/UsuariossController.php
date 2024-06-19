<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class UsuariossController extends Controller
{
/*************************************************************************************************
 * ******************************C O N S U L T A R************************************************
 * ***********************************************************************************************
*/
    /**
 * @OA\Post(
 *     path="/api/consultar-usuario",
 *     summary="Consultar usuario",
 *     description="Consulta un usuario en la base de datos por su DNI y verifica la contraseña.",
 *     operationId="consultarUsuario",
 *     tags={"Usuarios"},
 *     @OA\Parameter(
 *         name="dni",
 *         in="query",
 *         required=true,
 *         description="DNI del usuario",
 *         @OA\Schema(type="string", example="12345678A"),
 *     ),
 *     @OA\Parameter(
 *         name="password",
 *         in="query",
 *         required=true,
 *         description="Contraseña del usuario",
 *         @OA\Schema(type="string", example="contrasena123"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inicio de sesión exitoso",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Inicio de sesión exitoso"),
 *             @OA\Property(property="usuario", type="object", description="Datos del usuario logeado", ref="#/components/schemas/Usuario"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciales incorrectas",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Credenciales incorrectas"),
 *         ),
 *     ),
 * )
 */
    public function consultarUsuario(Request $request)
    {
        $dniUsuario = $request->input('dni');
        $password = $request->input('password');

        // Buscar el usuario en la base de datos por nombre de usuario
        $usuario = Usuario::where('dni', $dniUsuario)->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && Hash::check($password, $usuario->password)) {
            
            return response()->json(['mensaje' => 'Inicio de sesión exitoso', 'usuario' => $usuario], 200);

        } else {

            return response()->json(['mensaje' => 'Credenciales incorrectas'], 401);
        }
    }
    /**
 * @OA\Get(
 *     path="/api/consultar-usuario-por-dni",
 *     summary="Consultar usuario por DNI",
 *     description="Consulta un usuario en la base de datos por su DNI.",
 *     operationId="consultarUsuarioPorDni",
 *     tags={"Usuarios"},
 *     @OA\Parameter(
 *         name="dni",
 *         in="query",
 *         required=true,
 *         description="DNI del usuario a consultar",
 *         @OA\Schema(type="string", example="12345678A"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Usuario encontrado"),
 *             @OA\Property(property="usuario", type="object", description="Datos del usuario encontrado", ref="#/components/schemas/Usuario"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuario no encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Usuario no encontrado"),
 *         ),
 *     ),
 * )
 */
public function consultarUsuarioPorDni(Request $request)
{
    $dniUsuario = $request->query('dni');

    // Buscar el usuario en la base de datos por DNI
    $usuario = Usuario::where('dni', $dniUsuario)->first();

    if ($usuario) {
        // Usuario encontrado
        return response()->json(['mensaje' => 'Usuario encontrado', 'usuario' => $usuario], 200);
    } else {
        // Usuario no encontrado
        return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
    }
}

/*************************************************************************************************
 * **************************************C R E A R************************************************
 * ***********************************************************************************************
*/
/**
 * @OA\Post(
 *     path="/api/crear-usuario",
 *     summary="Crear usuario",
 *     description="Crear un nuevo usuario en la base de datos.",
 *     operationId="crearUsuario",
 *     tags={"Usuarios"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del usuario a crear",
 *         @OA\JsonContent(
 *             required={"dni", "nombre_usuario", "password", "fecha_nacimiento", "sobremi", "apellidos", "direccion", "codigo_postal_usuario", "telefono", "email"},
 *             @OA\Property(property="dni", type="string", example="12345678A", description="DNI del nuevo usuario"),
 *             @OA\Property(property="nombre_usuario", type="string", example="ejemplo_usuario", description="Nombre de usuario del nuevo usuario"),
 *             @OA\Property(property="password", type="string", example="contrasena123", description="Contraseña del nuevo usuario"),
 *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1990-01-01", description="Fecha de nacimiento del nuevo usuario (YYYY-MM-DD)"),
 *             @OA\Property(property="sobremi", type="string", example="Descripción personal del nuevo usuario"),
 *             @OA\Property(property="apellidos", type="string", example="Ejemplo Apellidos", description="Apellidos del nuevo usuario"),
 *             @OA\Property(property="direccion", type="string", example="Calle Ejemplo 123", description="Dirección del nuevo usuario"),
 *             @OA\Property(property="codigo_postal_usuario", type="string", example="12345", description="Código postal del nuevo usuario"),
 *             @OA\Property(property="telefono", type="string", example="123456789", description="Número de teléfono del nuevo usuario"),
 *             @OA\Property(property="email", type="string", format="email", example="usuario@example.com", description="Correo electrónico del nuevo usuario"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuario registrado exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="mensaje", type="string", example="Usuario registrado exitosamente"),
 *             @OA\Property(property="id_usuario", type="integer", example=1, description="ID del nuevo usuario registrado"),
 *         ),
 *     ),
 * )
 */
    public function crearUsuario(Request $request)
{
     // Validar los datos del formulario antes de insertarlos en la base de datos
     $request->validate([
        'dni' => 'required|string',
        'nombre_usuario' => 'required|string',
        'password' => 'required|string',
        'fecha_nacimiento' => 'required|date',
        'sobremi' => 'required|string',
        'apellidos' => 'required|string',
        'direccion' => 'required|string',
        'codigo_postal_usuario' => 'required|string',
        'telefono' => 'required|string',
        'email' => 'required|email',
       
    ]);

    // Hashear la contraseña antes de almacenarla en la base de datos
    $contrasenaHasheada = Hash::make($request->input('password'));

    // Formatear la fecha utilizando Carbon
    $fechaFormateada = Carbon::createFromFormat('Y-m-d', $request->input('fecha_nacimiento'))->format('Y-m-d');

    // Crear una nueva instancia del modelo Usuario y asignar los valores
    $nuevoUsuario = new Usuario();
    $nuevoUsuario->dni = $request->input('dni');
    $nuevoUsuario->nombre_usuario = $request->input('nombre_usuario');
    $nuevoUsuario->password = $contrasenaHasheada;
    $nuevoUsuario->fecha_nacimiento = $fechaFormateada;
    $nuevoUsuario->sobremi = $request->input('sobremi');
    $nuevoUsuario->apellidos = $request->input('apellidos');
    $nuevoUsuario->direccion = $request->input('direccion');
    $nuevoUsuario->codigo_postal_usuario = $request->input('codigo_postal_usuario');
    $nuevoUsuario->telefono = $request->input('telefono');
    $nuevoUsuario->email = $request->input('email');

    $nuevoUsuario->save();

    return response()->json(['mensaje' => 'Usuario registrado exitosamente', 'id_usuario' => $nuevoUsuario->id], 201);
}
}
