<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TemplatePertanyaan;
use App\Models\Addon;
use Carbon\Carbon;
use App\Transformer\TemplatePertanyaanTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TemplatePertanyaanController extends Controller
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
        $query = TemplatePertanyaan::select('*');
        if ($request->get('id_kategori')) {
            $query = $query->where('id_kategori', '=', $request->get('id_kategori'));
        }
        if ($request->get('id_aspek_pertanyaan')) {
            $query = $query->where('id_aspek_pertanyaan', '=', $request->get('id_aspek_pertanyaan'));
        }
        if ($request->get('pertanyaan')) {
            $query = $query->where('pertanyaan', 'like', '%'.$request->get('pertanyaan').'%');
        }
        if ($request->get('id_tipe_kuis')) {
            $query = $query->where('id_tipe_kuis', '=', $request->get('id_tipe_kuis'));
        }
        if ($request->get('is_required')) {
            $query = $query->where('is_required', '=', $request->get('is_required'));
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new TemplatePertanyaanTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = TemplatePertanyaan::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new TemplatePertanyaanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_aspek_pertanyaan' => ['required', 'numeric'],
            'id_tipe_kuis' => ['required', 'numeric'],
            'pertanyaan' => ['required'],
            'is_required' => ['boolean']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new TemplatePertanyaan();
        $query = $query->fill($input);
        $query->save();
        
        if ($input['addon'] !== null) {
            $dt_addon = [];
            foreach ($input['addon'] as $k => $v) {
                $dt_addon[] = [
                    'id_template_pertanyaan' => $query->id,
                    'addon' => $v,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            Addon::insert($dt_addon);
        }

        $fractal = new Manager();
        $resource = new Item($query, new TemplatePertanyaanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_aspek_pertanyaan' => ['required', 'numeric'],
            'id_tipe_kuis' => ['required', 'numeric'],
            'pertanyaan' => ['required'],
            'is_required' => ['boolean']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new TemplatePertanyaan();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            if ($input['addon'] !== null) {
                Addon::where('id_template_pertanyaan', $id)->delete();
                $dt_addon = [];
                foreach ($input['addon'] as $k => $v) {
                    $dt_addon[] = [
                        'id_template_pertanyaan' => $query->id,
                        'addon' => $v,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
    
                Addon::insert($dt_addon);
            }

            $fractal = new Manager();
            $resource = new Item($query, new TemplatePertanyaanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new TemplatePertanyaan();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = TemplatePertanyaan::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new TemplatePertanyaanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}