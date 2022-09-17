<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pengajar;
use App\Transformer\PengajarTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PengajarController extends Controller
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
        $filterGroups = (array) request()->get('filterGroups', []);
        $query = Pengajar::select('*');
        if ($request->get('nik')) {
            $query = $query->where('nik', 'like', '%'.$request->get('nik').'%');
        }
        if ($request->get('kode_pengajar')) {
            $query = $query->where('kode_pengajar', 'like', '%'.$request->get('kode_pengajar').'%');
        }
        if ($request->get('nama_pengajar')) {
            $query = $query->where('nama_pengajar', 'like', '%'.$request->get('nama_pengajar').'%');
        }
        if ($request->get('email')) {
            $query = $query->where('email', 'like', '%'.$request->get('email').'%');
        }
        if ($request->get('id_unit')) {
            $query = $query->where('id_unit', '=', $request->get('id_unit'));
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new PengajarTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = Pengajar::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new PengajarTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'nik' => ['required', 'unique:pengajar'],
            'nama_pengajar' => ['required'],
            'kode_pengajar' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'id_unit' => ['required', 'numeric']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new Pengajar();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new PengajarTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'nik' => ['required', Rule::unique('pengajar')->ignore($id)],
            'kode_pengajar' => ['required'],
            'nama_pengajar' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'id_unit' => ['required', 'numeric'],
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new Pengajar();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new PengajarTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new Pengajar();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = Pengajar::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new PengajarTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}