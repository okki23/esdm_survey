<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Evaluasi;
use App\Transformer\EvaluasiTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EvaluasiController extends Controller
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
        $query = Evaluasi::select('*');
        if ($request->get('id_kategori')) {
            $query = $query->where('id_kategori', '=', $request->get('id_kategori'));
        }
        if ($request->get('judul_evaluasi')) {
            $query = $query->where('judul_evaluasi', 'like', '%'.$request->get('judul_evaluasi').'%');
        }
        if ($request->get('id_diklat')) {
            $query = $query->where('id_diklat', '=', $request->get('id_diklat'));
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new EvaluasiTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = Evaluasi::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new EvaluasiTransformer);
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
            'judul_evaluasi' => ['required'],
            'id_diklat' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new Evaluasi();
        $query = $query->fill($input);
        $query->save();

        // if (isset($input['pertanyaan']) && $input['pertanyaan'] !== null && !empty($input['pertanyaan'])) {
        //     $dt_addon = [];
        //     foreach ($input['pertanyaan'] as $k => $v) {
        //         $dt_addon[] = [
        //             'id_evaluasi_pertanyaan' => $query->id,
        //             'id_aspek_pertanyaan' => $['id_aspek_pertanyaan'],
        //             'id_template_pertanyaan' => $v['id_template_pertanyaan'],
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now(),
        //         ];
        //     }

        //     Addon::insert($dt_addon);
        // }

        $fractal = new Manager();
        $resource = new Item($query, new EvaluasiTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_kategori' => ['required'],
            'judul_evaluasi' => ['required'],
            'id_diklat' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new Evaluasi();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new EvaluasiTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new Evaluasi();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = Evaluasi::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new EvaluasiTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}