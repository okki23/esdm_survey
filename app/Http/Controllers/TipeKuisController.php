<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TipeKuis;
use App\Transformer\TipeKuisTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TipeKuisController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * get the user list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $fractal = new Manager();
        $perPage = (int) request()->get('per_page', 10);
        $sortField = (string) request()->get('sort_field', 'id');
        $sortOrder = (string) request()->get('sort_order', 'desc');
        $query = TipeKuis::select('*');
        if ($request->get('nama_tipe')) {
            $query = $query->where('kode_unit', 'like', '%'.$request->get('kode_unit').'%');
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new TipeKuisTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = TipeKuis::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new TipeKuisTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'nama_tipe' => ['required', 'unique:tipe_kuis'],
            'status' => ['required', 'boolean'],
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new TipeKuis();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new TipeKuisTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'nama_tipe' => ['required', Rule::unique('unit')->ignore($id)],
            'nama_unit' => ['required', Rule::unique('unit')->ignore($id)]
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new TipeKuis();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new TipeKuisTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new TipeKuis();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = TipeKuis::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new TipeKuisTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}