<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Diklat;
use App\Transformer\DiklatTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DiklatController extends Controller
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
        $query = Diklat::select('*');
        if ($request->get('judul_diklat')) {
            $query = $query->where('judul_diklat', 'like', '%'.$request->get('judul_diklat').'%');
        }
        if ($request->get('tgl_pelaksanaan_awal')) {
            $query = $query->whereDate('tgl_pelaksanaan_awal', '=', $request->get('tgl_pelaksanaan_awal'));
        }
        if ($request->get('tgl_pelaksanaan_selesai')) {
            $query = $query->whereDate('tgl_pelaksanaan_selesai', '=', $request->get('tgl_pelaksanaan_selesai'));
        }
        if ($request->get('tempat_diklat')) {
            $query = $query->where('tempat_diklat', 'like', '%'.$request->get('tempat_diklat').'%');
        }
        if ($request->get('jenis_diklat')) {
            $query = $query->where('jenis_diklat', 'like', '%'.$request->get('jenis_diklat').'%');
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new DiklatTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = Diklat::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new DiklatTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'judul_diklat' => ['required', 'unique:diklat'],
            'tgl_pelaksanaan_awal' => ['required','date'],
            'tgl_pelaksanaan_selesai' => ['required','date'],
            'tempat_diklat' => ['required'],
            'jenis_diklat' => ['required'],
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new Diklat();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new DiklatTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'judul_diklat' => ['required', Rule::unique('diklat')->ignore($id)],
            'tgl_pelaksanaan_awal' => ['required','date'],
            'tgl_pelaksanaan_selesai' => ['required','date'],
            'tempat_diklat' => ['required'],
            'jenis_diklat' => ['required'],
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new Diklat();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new DiklatTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new Diklat();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = Diklat::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new DiklatTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}