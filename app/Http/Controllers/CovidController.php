<?php

namespace App\Http\Controllers;

use App\Models\Covid;
use Illuminate\Http\Request;

class CovidController extends Controller
{
    //untuk melihat seluruh data
    public function index()
    {
        $covid = Covid::get();

        $message = $covid->isEmpty()
        ?  'Data is Empty'
        :   'Get all response';

        return response()->json([
            'message' => $message,
            'data' => $covid
        ], 200);
    }

    //untuk menambah data
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'in_date_at' => ['required', 'string'],
            'out_date_at' => ['required', 'string'],
        ]);

        $covid = Covid::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at,
        ]);

        return response()->json([
            'message' => 'Resource is added successfuly',
            'data' => $covid,
        ], 201);
    }

    //untuk melihat dengan detail get by id
    public function show(String $id)
    {
        $covid = Covid::where('id', $id)->first();

        if (!$covid) {
            return response()->json([
                'message' => 'Resource Not Found',
                'data' => $covid,
            ], 404);

            return response()->json([
                'message' => 'Get Detail Resource',
                'data' => $covid,
            ], 200);
        }
    }

    //untuk mengudate data
    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'in_date_at' => ['required', 'string'],
            'out_date_at' => ['required', 'string'],
        ]);

        $covid = Covid::where('id', $id)->first();

        if (!$covid) {
            return response()->json([
                'message' => 'Resource Not Found',
                'data' => $covid,
            ], 404);
        }

        $covid->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'in_date_at' => $request->in_date_at,
            'out_date_at' => $request->out_date_at,
        ]);

        return response()->json([
            'message' => 'Resource is update successfuly',
            'data' => $covid
        ], 200);
    }

    //untuk menghapus data
    public function destroy(String $id)
    {
        $covid = Covid::where('id', $id)->first();

        if (!$covid) {
            return response()->json([
                'message' => 'Resource Not Found',
                'data' => $covid,
            ], 404);
        }

        $covid->delete();

        return response()->json([
            'message' => 'Resource is delete successfuly',
            'data' => $covid
        ], 200);
    }


    public function search($name)
    {

        $covid = Covid::where('name', 'like', '%' . $name .'%')->get();

        if (!$covid->IsEmpty()) {
            return response()->json([
                'message' => 'Resource Not Found',
                'data' => $covid,
            ], 404);
        }

        return response()->json([
            'message' => 'Get searched resource',
            'total' => $covid->count(),
            'data' => $covid
        ], 200);

    }

    public function getPositiveResources()
    {
        // Mengambil semua resource yang positif
        $positiveResources = Covid::where('status', 'positive')->get();

        // Mengembalikan response dengan total dan data jika resource ditemukan
        return response()->json([
            'message' => 'Get positive resource',
            'total' => $positiveResources->count(),
            'data' => $positiveResources,
        ], 200);
    }

    public function getRecorvedResources()
    {
        // Mengambil semua resource yang positif
        $recorvedResources = Covid::where('status', 'recorved')->get();

        // Mengembalikan response dengan total dan data jika resource ditemukan
        return response()->json([
            'message' => 'Recorved patients found',
            'total' => $recorvedResources->count(),
            'data' => $recorvedResources,
        ], 200);
    }

    public function getDeadResources()
{
    // Mengambil pasien yang statusnya dead
    $deadPatients = Covid::where('status', 'dead')->get();

    // Mengembalikan response dengan total dan data pasien yang ditemukan
    return response()->json([
        'message' => 'Dead patients found',
        'total' => $deadPatients->count(),
        'data' => $deadPatients,
    ], 200);


}



}
