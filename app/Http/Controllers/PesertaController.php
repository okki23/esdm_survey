<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Peserta;
use App\Transformer\PesertaTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PesertaController extends Controller
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
        $query = Peserta::select('*');
        if ($request->get('nomor_peserta')) {
            $query = $query->where('nomor_peserta', 'like', '%'.$request->get('nomor_peserta').'%');
        }
        if ($request->get('nama_peserta')) {
            $query = $query->where('nama_peserta', 'like', '%'.$request->get('nama_peserta').'%');
        }
        if ($request->get('email')) {
            $query = $query->where('email', 'like', '%'.$request->get('email').'%');
        }
        if ($request->get('telp')) {
            $query = $query->where('telp', 'like', '%'.$request->get('telp').'%');
        }
        if ($request->get('id_unit')) {
            $query = $query->where('id_unit', '=', $request->get('id_unit'));
        }
        $query = $query->orderBy($sortField, $sortOrder);
        $query = $query->paginate($perPage);
        $datas = $query->getCollection();

        $resource = new Collection($datas, new PesertaTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($query));
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function getDetail($id) {
        $data = Peserta::find($id);
        if ($data) {
            $fractal = new Manager();
            $resource = new Item($data, new PesertaTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {

            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function create(Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_unit' => ['required'],
            'nomor_peserta' => ['required'],
            'nama_Peserta' => ['required'],
            'email' => ['required', 'email'],
            'telp' => ['required', 'numeric']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $input = $request->all();
        $query = new Peserta();
        $query = $query->fill($input);
        $query->save();

        $fractal = new Manager();
        $resource = new Item($query, new PesertaTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }

    public function update($id, Request $request) {
        $data = $request->json()->all();
        $rule = [
            'id_unit' => ['required'],
            'nomor_peserta' => ['required'],
            'nama_Peserta' => ['required'],
            'email' => ['required', 'email'],
            'telp' => ['required', 'numeric']
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        $query = new Peserta();
        $query = $query->find($id);
        if ($query) {
            $input = $request->all();
            $query = $query->fill($input);
            $query->save();

            $fractal = new Manager();
            $resource = new Item($query, new PesertaTransformer);
            $res = $fractal->createData($resource)->toArray();

            return response()->json($res, 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy($id, Request $request) {
        $query = new Peserta();
        $query = $query->where('id', $id);
        $query = $query->delete();
        $query_trashed = Peserta::withTrashed()->find($id);
        $fractal = new Manager();
        $resource = new Item($query_trashed, new PesertaTransformer);
        $res = $fractal->createData($resource)->toArray();

        return response()->json($res, 200);
    }
}
