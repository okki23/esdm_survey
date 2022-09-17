<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AspekPertanyaan;
use App\Transformer\AspekPertanyaanTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AspekPertanyaanController extends Controller
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
        $query = AspekPertanyaan::select('*');
        if ($request->get('id_kategori')) {
            $query = $query->where('id_kategori', '=', $request->get('id_kategori'));
        }
        if ($request->get('id_tipe_kuis')) {
            $query = $query->where('id_tipe_kuis', '=', $request->get('id_tipe_kuis'));
        }
        if ($request->get('pertanyaan')) {
            $query = $query->where('pertanyaan', 'like', '%'.$request->get('pertanyaan').'%');
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new AspekPertanyaanTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = AspekPertanyaan::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new AspekPertanyaanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_kategori' => ['required'],
            'pertanyaan' => ['required'],
            'id_tipe_kuis' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new AspekPertanyaan();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new AspekPertanyaanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_kategori' => ['required'],
            'pertanyaan' => ['required'],
            'id_tipe_kuis' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new AspekPertanyaan();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new AspekPertanyaanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new AspekPertanyaan();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = AspekPertanyaan::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new AspekPertanyaanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}