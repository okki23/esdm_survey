<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\JadwalKuis;
use App\Transformer\JadwalKuisTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class JadwalKuisController extends Controller
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
        $query = JadwalKuis::select('*');
        if ($request->get('id_template_survey_kuis')) {
            $query = $query->where('id_template_survey_kuis', 'like', '%'.$request->get('id_template_survey_kuis').'%');
        }
        if ($request->get('tgl_kuis_mulai')) {
            $query = $query->where('tgl_kuis_mulai', 'like', '%'.$request->get('tgl_kuis_mulai').'%');
        }
        if ($request->get('tgl_kuis_selesai')) {
            $query = $query->where('tgl_kuis_selesai', '=', $request->get('tgl_kuis_selesai'));
        }
        if ($request->get('id_pic')) {
            $query = $query->where('id_pic', '=', $request->get('id_pic'));
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new JadwalKuisTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = JadwalKuis::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new JadwalKuisTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {

            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_template_survey_kuis' => ['required'],
            'tgl_kuis_mulai' => ['required'],
            'tgl_kuis_selesai' => ['required'],
            'id_pic' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new JadwalKuis();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new JadwalKuisTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_template_survey_kuis' => ['required'],
            'tgl_kuis_mulai' => ['required'],
            'tgl_kuis_selesai' => ['required'],
            'id_pic' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new JadwalKuis();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new JadwalKuisTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new JadwalKuis();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = JadwalKuis::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new JadwalKuisTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}
