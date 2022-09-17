<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Jabatan;
use App\Transformer\JabatanTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
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
        $query = Jabatan::select('*');
        if ($request->get('jabatan')) {
            $query = $query->where('jabatan', 'like', '%'.$request->get('jabatan').'%');
        }
        if ($request->get('status')) {
            $active = $request->get('status') === 'aktif' ? 1 : 0;
            $query = $query->where('status', '=', $active);
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new JabatanTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = Jabatan::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new JabatanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'jabatan' => ['required', 'unique:jabatan'],
            'status' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new Jabatan();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new JabatanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'jabatan' => ['required', Rule::unique('jabatan')->ignore($id)],
            'status' => ['required']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new Jabatan();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new JabatanTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new Jabatan();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = Jabatan::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new JabatanTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}