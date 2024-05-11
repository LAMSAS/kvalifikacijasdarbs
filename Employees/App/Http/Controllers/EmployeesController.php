<?php

namespace Modules\Employees\App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Clients\App\Models\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Employees\App\Models\Employee;
use App\Http\Controllers\FileUploadController;
use Modules\EmployeeTeams\App\Models\EmployeeTeam;

class EmployeesController extends Controller
{
    public $_aimx = [
        'name' => 'Employees',
        'title' => 'Employees', 
        'description' => 'employee list',
        'icon' => 'ti ti-users',
        'color' => 'purple',
        'module' => 'employees',
        'code' => 'employees',
        'urlBase' => 'employees', 
        'jsFiles' => ['/assets/js/aim-list.js'],
        'cssFiles' => [],
    ];

    public $_listPerPageDefault = 30;
    public $_listSortModeDefault = "asc";

    private $placeholder = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiIHZpZXdCb3g9IjAgMCAxMDAwIDEwMDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8ZGVzYz5DcmVhdGVkIHdpdGggRmFicmljLmpzIDMuNS4wPC9kZXNjPgo8ZGVmcz4KPC9kZWZzPgo8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDApIi8+CjxnIHRyYW5zZm9ybT0ibWF0cml4KDM3Ljg3ODggMCAwIDM3Ljg3ODggNTAwLjAwMDEgNTAwLjAwMDEpIiBpZD0iMTUyMjAiPgo8ZyBzdHlsZT0iIiB2ZWN0b3ItZWZmZWN0PSJub24tc2NhbGluZy1zdHJva2UiPgoJCTxnIHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMCAwKSI+CjxwYXRoIHN0eWxlPSJzdHJva2U6IG5vbmU7IHN0cm9rZS13aWR0aDogMjsgc3Ryb2tlLWRhc2hhcnJheTogbm9uZTsgc3Ryb2tlLWxpbmVjYXA6IHJvdW5kOyBzdHJva2UtZGFzaG9mZnNldDogMDsgc3Ryb2tlLWxpbmVqb2luOiByb3VuZDsgc3Ryb2tlLW1pdGVybGltaXQ6IDQ7IGlzLWN1c3RvbS1mb250OiBub25lOyBmb250LWZpbGUtdXJsOiBub25lOyBmaWxsOiBub25lOyBmaWxsLXJ1bGU6IG5vbnplcm87IG9wYWNpdHk6IDE7IiB0cmFuc2Zvcm09IiB0cmFuc2xhdGUoLTEyLCAtMTIpIiBkPSJNIDAgMCBoIDI0IHYgMjQgSCAwIHoiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L2c+CgkJPGcgdHJhbnNmb3JtPSJtYXRyaXgoMSAwIDAgMSAzLjAwNSAtNCkiPgo8cGF0aCBzdHlsZT0ic3Ryb2tlOiByZ2IoMjA2LDIxMSwyMjQpOyBzdHJva2Utd2lkdGg6IDI7IHN0cm9rZS1kYXNoYXJyYXk6IG5vbmU7IHN0cm9rZS1saW5lY2FwOiByb3VuZDsgc3Ryb2tlLWRhc2hvZmZzZXQ6IDA7IHN0cm9rZS1saW5lam9pbjogcm91bmQ7IHN0cm9rZS1taXRlcmxpbWl0OiA0OyBpcy1jdXN0b20tZm9udDogbm9uZTsgZm9udC1maWxlLXVybDogbm9uZTsgZmlsbDogbm9uZTsgZmlsbC1ydWxlOiBub256ZXJvOyBvcGFjaXR5OiAxOyIgdHJhbnNmb3JtPSIgdHJhbnNsYXRlKC0xNS4wMDUsIC04KSIgZD0iTSAxNSA4IGggMC4wMSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjwvZz4KCQk8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxIDAgMCAxIDAgMCkiPgo8cGF0aCBzdHlsZT0ic3Ryb2tlOiByZ2IoMjA2LDIxMSwyMjQpOyBzdHJva2Utd2lkdGg6IDI7IHN0cm9rZS1kYXNoYXJyYXk6IG5vbmU7IHN0cm9rZS1saW5lY2FwOiByb3VuZDsgc3Ryb2tlLWRhc2hvZmZzZXQ6IDA7IHN0cm9rZS1saW5lam9pbjogcm91bmQ7IHN0cm9rZS1taXRlcmxpbWl0OiA0OyBpcy1jdXN0b20tZm9udDogbm9uZTsgZm9udC1maWxlLXVybDogbm9uZTsgZmlsbDogbm9uZTsgZmlsbC1ydWxlOiBub256ZXJvOyBvcGFjaXR5OiAxOyIgdHJhbnNmb3JtPSIgdHJhbnNsYXRlKC0xMiwgLTEyKSIgZD0iTSA3IDMgaCAxMSBhIDMgMyAwIDAgMSAzIDMgdiAxMSBtIC0wLjg1NiAzLjA5OSBhIDIuOTkxIDIuOTkxIDAgMCAxIC0yLjE0NCAwLjkwMSBoIC0xMiBhIDMgMyAwIDAgMSAtMyAtMyB2IC0xMiBjIDAgLTAuODQ1IDAuMzQ5IC0xLjYwOCAwLjkxIC0yLjE1MyIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjwvZz4KCQk8ZyB0cmFuc2Zvcm09Im1hdHJpeCgxIDAgMCAxIC0yLjUgMS4xNjUxKSI+CjxwYXRoIHN0eWxlPSJzdHJva2U6IHJnYigyMDYsMjExLDIyNCk7IHN0cm9rZS13aWR0aDogMjsgc3Ryb2tlLWRhc2hhcnJheTogbm9uZTsgc3Ryb2tlLWxpbmVjYXA6IHJvdW5kOyBzdHJva2UtZGFzaG9mZnNldDogMDsgc3Ryb2tlLWxpbmVqb2luOiByb3VuZDsgc3Ryb2tlLW1pdGVybGltaXQ6IDQ7IGlzLWN1c3RvbS1mb250OiBub25lOyBmb250LWZpbGUtdXJsOiBub25lOyBmaWxsOiBub25lOyBmaWxsLXJ1bGU6IG5vbnplcm87IG9wYWNpdHk6IDE7IiB0cmFuc2Zvcm09IiB0cmFuc2xhdGUoLTkuNSwgLTEzLjE2NTEpIiBkPSJNIDMgMTYgbCA1IC01IGMgMC45MjggLTAuODkzIDIuMDcyIC0wLjg5MyAzIDAgbCA1IDUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L2c+CgkJPGcgdHJhbnNmb3JtPSJtYXRyaXgoMSAwIDAgMSA2LjY2NSAyLjE2NSkiPgo8cGF0aCBzdHlsZT0ic3Ryb2tlOiByZ2IoMjA2LDIxMSwyMjQpOyBzdHJva2Utd2lkdGg6IDI7IHN0cm9rZS1kYXNoYXJyYXk6IG5vbmU7IHN0cm9rZS1saW5lY2FwOiByb3VuZDsgc3Ryb2tlLWRhc2hvZmZzZXQ6IDA7IHN0cm9rZS1saW5lam9pbjogcm91bmQ7IHN0cm9rZS1taXRlcmxpbWl0OiA0OyBpcy1jdXN0b20tZm9udDogbm9uZTsgZm9udC1maWxlLXVybDogbm9uZTsgZmlsbDogbm9uZTsgZmlsbC1ydWxlOiBub256ZXJvOyBvcGFjaXR5OiAxOyIgdHJhbnNmb3JtPSIgdHJhbnNsYXRlKC0xOC42NjUsIC0xNC4xNjUpIiBkPSJNIDE2LjMzIDEyLjMzOCBjIDAuNTc0IC0wLjA1NCAxLjE1NSAwLjE2NiAxLjY3IDAuNjYyIGwgMyAzIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPC9nPgoJCTxnIHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMCAwKSI+CjxwYXRoIHN0eWxlPSJzdHJva2U6IHJnYigyMDYsMjExLDIyNCk7IHN0cm9rZS13aWR0aDogMjsgc3Ryb2tlLWRhc2hhcnJheTogbm9uZTsgc3Ryb2tlLWxpbmVjYXA6IHJvdW5kOyBzdHJva2UtZGFzaG9mZnNldDogMDsgc3Ryb2tlLWxpbmVqb2luOiByb3VuZDsgc3Ryb2tlLW1pdGVybGltaXQ6IDQ7IGlzLWN1c3RvbS1mb250OiBub25lOyBmb250LWZpbGUtdXJsOiBub25lOyBmaWxsOiBub25lOyBmaWxsLXJ1bGU6IG5vbnplcm87IG9wYWNpdHk6IDE7IiB0cmFuc2Zvcm09IiB0cmFuc2xhdGUoLTEyLCAtMTIpIiBkPSJNIDMgMyBsIDE4IDE4IiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPC9nPgo8L2c+CjwvZz4KPC9zdmc+";

    public function _initListModel()
    {
        $this->_listModel = new Employee;
    }
    public function _searchFilterScope($data, $filters)
    {
        $filterCount = 0;
        foreach ($filters as $filter) {
            if (!empty($filter['like'])) {
                $filterCount++;
            }
            if (!is_array($filter) && $filter != "") {
                $filterCount++;
            }
        }
        
        $search = $filterCount > 0 ? "" : $data['search'];
        
        return [
            "search" => $search,
            "searchFilters" => [],
            "filters" => $filters,
            "filterCount" => $filterCount
        ];
    }
    public function list(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $this->_buildData($request);
        $this->_listOnRun();
        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_list', $this->page);
    }
    public function onSetFilters($request)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        
        $filters = $request->input('filters');
        
        if ($filters && is_array($filters)) {
            Session::put($this->_aimx['code'].'_list_search', null);
            Session::put($this->_aimx['module'].'_'.$this->_aimx['code'].'_filters', $filters);
        }
    
        $this->_sentToFirstPage = true;
        return $this->onRefresh($request);
    }
    
    public function onShowFilters()
    {
        $filters = Session::get($this->_aimx['module'].'_'.$this->_aimx['code'].'_filters', []);
        $departments = Employee::select('department')->groupBy('department')->get();
        $positions = Employee::select('position')->groupBy('position')->get();
        $is_active = Employee::select('is_active')->groupBy('is_active')->get();
        $names = Employee::select('first_name')->groupBy('first_name')->get();
    
        return [
            '#aim-filter-body' => view($this->_aimx['module'].'::'.$this->_aimx['code'].'_list_filters', [
                'filters' => $filters,
                'departments' => $departments,
                'positions' => $positions,
                'is_active' => $is_active,
                'names' => $names
            ])->render()
        ];
    }
    
    

    public function import(Request $request)
    {
        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_import', $this->page);
    }

    public function profile(Request $request, $id, $tab = "overview")
    {
        $auth = $this->auth("employees.access_employees", function () use ($id) {
            return Employee::find($id);
        });
        if (!$auth['ok']) {
            return $auth['x'];
        }
        $employee = $auth['item'];
        // $viewData = [
        //     "employee" => $employee,
        // ];
    
        $clients = Client::all();
        $tabs = ["overview", "contacts", "interactions"];
        if (!in_array($tab, $tabs)) {
            $tab = "overview";
        }
        $this->_aimx['title'] = $employee->title;
        $userList = User::select(['id', 'name'])->get();
    

        $teams = EmployeeTeam::all();

        // avatar
        $File = new FileUploadController();
        $avatarbase64 = $File->getImage('Employees', $employee->id, 'Avatar', 1);

        $avatar_uploaded = false;
        if ($avatarbase64 == true) {
            $avatar_uploaded = true;
        }
        else {
            $avatarbase64 = $this->placeholder;
        }
        return view('employees::employees_profile', [
            'tab' => $tab,
            'employee' => $employee,
            'aimx' => $this->_aimx,
            'userList' => $userList,
            'clients' => $clients,
            'avatar_uploaded' => $avatar_uploaded,
            'avatar_b64' => $avatarbase64,
            'teams' => $teams,
        ]);
    }

    public function onAction(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".manage_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $post = $request->input();
        $action = $post['action'];
        $employeeId = $post['employee_id'];
        $employee = Employee::find($employeeId);
        if (method_exists($this, "action_" . $action)) {
            return $this->{"action_" . $action}($auth, $post, $employee, $request);
        }
        return $this->toast("error", "Action not found");

    }
    private function action_change_team($auth, $post, $employee , $request)
    {
       
        $employee = Employee::find($employee->id);
        if (!$employee) {
            return $this->toast("Employee not found");
        }
        $team_id = $request->input('team_id');
        $employee->team_id = $team_id;
        $employee->save();
        $employee_count = Employee::where('team_id', $team_id)->count();
        $team = EmployeeTeam::find($team_id);
        if (!$team) {
            return $this->toast("Team not found");
        }
        $team->employee_count = $employee_count;
        $team->save();
    
        return $this->toast("Team updated successfully");
    }
    private function action_update_profile($auth, $post, $employee , Request $request)
    {

        $employee = Employee::find($employee->id);
        if (!$employee) {
            return $this->toast("error", "Employee not found");
        }
        $data = $request->input('data');
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string | max:255',
            'status' => 'required|integer| max:1',
            'position' => 'required | string | max:255',
            'address' => 'required | string | max:255',
            'phone' => 'required | string | max:255',
            'email' => 'required | email | max:255',

        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toast($error, 'error');
            }
        }
        $employee->first_name = $data['first_name'];
        $employee->last_name = $data['last_name'];
        $employee->is_active = $data['status'];
        $employee->position = $data['position'];
        $employee->address = $data['address'];
        $employee->phone = $data['phone'];
        $employee->email = $data['email'];
        $employee->save();
    
        return $this->toast("Profile updated successfully");
    }
    
    public function onSaveAvatar (Request $request) {
        
        $file = $request->file('file');
        $modelType = 'Employees';
        $modelId = $request->input('modelId');
        $disk = 'local';
        $public = 1;
        $contentType = 'Avatar';

        if ($file) {
            $res = $this->uploadAvatar($file, $modelType, $modelId, $disk, $public, $contentType);
            return $res;
        }
        else {
            $res = $this->deleteAvatar($modelType, $modelId, $contentType, $disk, $public);
            return $res;
        }
    }

    private function uploadAvatar($file, $modelType, $modelId, $disk, $public, $contentType)
    {
        $fileUpload = new FileUploadController();
        $data = $fileUpload->store($file, $modelType, $modelId, $disk, $public, $contentType);
        $dataDecoded = $data;
        $isUploaded = isset($dataDecoded['original']['file_name']);

        if ($isUploaded) {
            $image = $fileUpload->getImage('Employees', $modelId, 'Avatar', 1);

            if (isset($image)) {
                $changeView = view('employees::partials.avatar_control_change')->render();
                return [
                    '#avatarcontainer' => 
                    "<div class='position-relative rounded-circle'>
                        <img src='".$image."' class='shadow-warning bg-secondary-subtle' style='width:100%; height:100%;
                    object-fit: cover; border-radius: 15%;' id='avatar_img'>
                    <button id='deleteButton' class='btn position-absolute top-0 end-1 translate-middle p-0 mt-1' type='submit'
                        data-request='onSaveAvatar' style='transform: translate(50%, 50%);'>
                    <i class='ti ti-xbox-x fs-5'></i>
                    </button>
                </div>",
                '#avatar_controls' => $changeView,
                '#aim-toast' => $this->toast('Image uploaded successfully!', 'success')['#aim-toast'],
            ];
        } else {
            $view = view('employees::partials.avatar_control_upload')->render();

            return [
                '#aim-toast' => $this->toast('Image uploaded unsuccessfully! Could not find uploaded image.', 'success')['#aim-toast'],
                '#avatar_controls' => $view,
            ];
        }
    }
}

public function changeAvatar($modelType, $modelId, $contentType, $disk, $public, $image, $file)
{
    $fileUpload = new FileUploadController();
    $data = $fileUpload->store($file, $modelType, $modelId, $disk, $public, $contentType);
    $isUploaded = isset($data['original']['file_name']);
    if ($isUploaded){
        $image = $fileUpload->getImage('Employees', $modelId, 'Avatar', 1);

        if (isset($image)){
            $deleteView = view('employees::partials.avatar_control_delete')->render();
            $view = view('employees::partials.avatar_control_change')->render();
            return [
                '#avatarcontainer' => "<div class='position-relative rounded-circle'><img src='" . $image . "' style='width:100%; height:100%; object-fit: cover; border-radius: 15%;' id='avatar_img' />" . $deleteView . "</div>",
                '#avatar_controls' => $view,
                '#result' => '',
            ];
        }
        else {
            $view = view('employees::partials.avatar_control_upload')->render();
            return [
                '#aim-toast' => $this->toast('Image uploaded unsuccessfully! Could not find uploaded image.', 'success')['#aim-toast'],
                '#avatar_controls' => $view,
            ];
        }
    }
    else {
        $view = view('employees::partials.avatar_control_upload')->render();
        return [
            '#result' => $data['error'],
            '#avatar_controls' => $view,
        ];
    }
}

    private function deleteAvatar( $modelType, $modelId, $contentType, $disk, $public) {

        $fileUpload = new FileUploadController();
        $res = $fileUpload->deleteFile($modelType, $modelId, $contentType, $disk, $public);
        
        $view = view('employees::partials.avatar_control_upload')->render();

        
        
        return [
            '#aim-toast' => $this->toast('Profile image deleted successfully.', 'success')['#aim-toast'],
            '#avatarcontainer' => "<div class='position-relative rounded-circle'><img src='" . $this->placeholder . "' class='shadow-warning bg-secondary-subtle' ' style='width:100%; height:100%; object-fit: cover; border-radius: 15%;' id='avatar_img' />",
            '#avatar_controls' => $view,
            '#result' => '',
        ];
    } 
    
    }