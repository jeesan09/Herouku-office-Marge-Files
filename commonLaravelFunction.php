use Illuminate\Support\Facades\Validator;
use App\Traits\AuthUser;
use JWTAuth;


    use AuthUser;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


         public function index()
    {
        return ReportComment::orderBy('id', 'DESC')->get();
    }



public function formValidation($request) {
        $rules = [
        'name' => 'required',
        'code' => 'required',
        'address' => 'required',
      /*  'thana_id' => 'required',
        'district_id' => 'required',
        'division_id' => 'required',
        'office_type' => 'required',*/
        ]; 
       

        $storeMsg = '';
        $n = 1;

        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            $msg = $validator->errors()->all();
            foreach($msg as $message){
                $storeMsg .= "(".$n.")".$message." ";
                $n++;
            }
            return $storeMsg;
        }

    }


    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $data['address'] = $request->address;
        $data['post_id'] = $request->post_id;
        $data['thana_id'] = $request->thana_id;
        $data['district_id'] = $request->district_id;
        $data['division_id'] = $request->division_id;
        $data['office_type'] = $request->office_type;
        $data['created_by'] = $this->getUserId();

        //return print_r($data);


        $success = Branches::create($data);
        if ($success) {
            return response()->json(array('id' => $success->id, 'status' => 1, 'message' => 'Data saved successfully!'));
        } 
        else {
            return response()->json(array('id' => 0, 'status' => 0, 'message' => 'Data does\'n saved successfully!'));
        } 
    }


public function update(Request $request, Branches $branches)
    {
        $data = Branches::find($request['id']);
        $data['name'] = $request['name'];
        $data['code'] = $request['code'];
        $data['address'] = $request['address'];
         $data['post_id'] = $request['post_id'];
         $data['thana_id'] = $request['thana_id'];
         $data['district_id'] = $request['district_id'];
         $data['division_id'] = $request['division_id'];
         $data['office_type'] = $request['office_type'];
        
        if ($data->save()) {
            return response()->json(array('status' => 1, 'message' => 'Data updated successfully!'));
        } 
        else {
            return response()->json(array('status' => 0, 'message' => 'Update failed!'));
        }

    }




     public function destroy($id)
    {
       if (Branches::find($id)->delete()) {
            return response()->json(array('status' => 1, 'message' => 'Data deleted successfully!'));
        } 
        else {
            return response()->json(array('status' => 0, 'message' => 'Delete failed!'));
        }
    }