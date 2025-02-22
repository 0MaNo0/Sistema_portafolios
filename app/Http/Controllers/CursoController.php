<?php

namespace App\Http\Controllers;
use App\Models\CargaAcademica;
use App\Models\PresentacionPortafolio;
use App\Models\Contenido;
use App\Models\Evaluaciones;
use App\Models\Curso;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($curso)
    {
        if(Auth::user()->TipoUsuario == 'docente'){
            $curso = Curso::find($curso);
            

            if (!$curso) {
                abort(404); // Manejar el caso en que el curso no se encuentre
            }

            // Recuperar datos de PresentacionPortafolio
            $presentacionPortafolio = PresentacionPortafolio::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            // Recuperar datos de Contenido
            $contenido = Contenido::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            // Recuperar datos de Evaluaciones
            $evaluaciones = Evaluaciones::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            return view('cursos.show', compact('curso', 'presentacionPortafolio', 'contenido', 'evaluaciones'));
        }else{
            $curso = Curso::find($curso)
            ->select('IDCurso', 'NombreCurso', 'Creditos', 'TipoClase', 'IDCargaAcademica')
            ->first();
            $docente = CargaAcademica::where('IDCargaAcademica',$curso->IDCargaAcademica)
            ->join('users', 'carga_academicas.IDDocente', '=', 'users.id')
            ->select('Nombre')
            ->first();
            if (!$curso) {
                abort(404); // Manejar el caso en que el curso no se encuentre
            }
            // Recuperar datos de PresentacionPortafolio
            $presentacionPortafolio = PresentacionPortafolio::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            // Recuperar datos de Contenido
            $contenido = Contenido::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            // Recuperar datos de Evaluaciones
            $evaluaciones = Evaluaciones::where('IDCargaAcademica', $curso->IDCargaAcademica)->first();

            return view('cursos.show', compact('curso', 'docente', 'presentacionPortafolio', 'contenido', 'evaluaciones'));
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}



    /*public function show($id)
    {
        $curso = Curso::where('IDCurso', $id)
        ->join('users', 'cursos.IDDocente', '=', 'users.id')
        ->select('users.Nombre', 'cursos.IDCurso', 'cursos.NombreCurso', 'cursos.Creditos', 'cursos.TipoClase')
        ->get();
        //Curso::where('IDCurso', $id)->get();// Obtener el curso desde la base de datos usando el modelo correspondiente
        dd($curso);
        // Devolver la vista con los datos del curso
        return view('cursos.show', ['curso' => $curso]);
    }*/

