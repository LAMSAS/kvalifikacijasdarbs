<?php

namespace Modules\EmployeeTeams\App\Http\Controllers;

use App\Models\SystemFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Employees\App\Models\Employee;
use App\Http\Controllers\FileUploadController;
use Modules\EmployeeTeams\App\Models\EmployeeTeam;
use Modules\EmployeeTeams\App\Models\EmployeeTeamType;

class EmployeeTeamsController extends Controller
{

    public $_listWithRelations = [
        'teamType',
        'employee'
    ];
    public $_aimx = [
        'name' => 'EmployeeTeams', // Section name
        'title' => 'Employee Teams', // Header title
        'description' => 'EmployeeTeams list',
        'icon' => 'ti ti-users-group',
        'color' => 'purple',
        'module' => 'employeeteams',
        'code' => 'employeeteams', // List or Profile main object
        'urlBase' => 'employeeteams', // URI #1
        'jsFiles' => ['/assets/js/aim-list.js'],
        'cssFiles' => [],
    ];
    public $_listPerPageDefault = 30;
    public $_listSortModeDefault = "asc";

    public function _initListModel()
    {
        $this->_listModel = new EmployeeTeam;
    }
    public function _searchFilterScope($data, $filters)
    {
        $filterCount = 0;
        foreach ($filters as $filter) {
            if (!empty($filter['like'])) {
                $filterCount++;
            }
            if (!empty($filter['is'])) {
                $filterCount++;
            }
            if (!empty($filter['min'])) {
                $filterCount++;
            }
            if (!empty($filter['max'])) {
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

        $this->_initListModel();
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
        $employeeTeamsTypes = EmployeeTeamType::all();
        $employees = EmployeeTeam::with('employee')->get();
        $allManagers = EmployeeTeam::query()->groupBy('manager_id')->select('manager_id')->with('employee')->get();

        return [
            '#aim-filter-body' =>  view($this->_aimx['module'].'::'.$this->_aimx['code'].'_list_filters', [
                'filters' => $filters,
                'employeeTeamsTypes' => $employeeTeamsTypes,
                'employees' => $employees,
                'allManagers' => $allManagers

            ])->render()
        ];
    }




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employeeteams::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id, $tab = "overview")
    {
        $allManagers = EmployeeTeam::query()->groupBy('manager_id')->select('manager_id')->with('employee')->get();
        $allTeamTypes = EmployeeTeamType::all();
        return view('employeeteams::employeeteams_create', [
            'tab' => $tab,
            'aimx' => $this->_aimx,
            'allManagers' => $allManagers,
            'allTeamTypes' => $allTeamTypes
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function onStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data.title' => 'required|string|max:255',
            'data.manager_id' => 'required|exists:employees,id',
            'data.team_type_id' => 'required|exists:employee_team_types,id',
            'data.is_active' => 'required|boolean',

        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toast($error);
            }
        }

        $title = $request->input('data.title');
        $manager_id = $request->input('data.manager_id');
        $team_type_id = $request->input('data.team_type_id');
        $is_active = $request->input('data.is_active');

        $existingTeam = EmployeeTeam::query()->where('title', $title)->
            where('manager_id', $manager_id)->
            where('team_type_id', $team_type_id)->get();

        if ($existingTeam->count()){
            return $this->toast("Error! Team already exists.");
        }

        $newTeam = new EmployeeTeam;
        $newTeam->title = $title;
        $newTeam->manager_id= $manager_id;
        $newTeam->team_type_id = $team_type_id;
        $newTeam->is_active = $is_active;

        if($newTeam->save()){
            return $this->redirect('/employees-teams');
        }
        return $this->toast("Team not created!", 'error');

    }

    public function profile(Request $request, $id, $tab = "overview")
    {
        $auth = $this->auth("employeeteams.manage_employeeteams", function () use ($id) {
            return EmployeeTeam::query()->where('id', $id)->with('employee')->with('teamType')->first();
        });
        if (!$auth['ok']) {
            return $auth['x'];
        }
        $team = $auth['item'];
        $employee = $team->employee;
    
        $allTeamTypes = EmployeeTeamType::all();
        $allManagers = EmployeeTeam::query()->groupBy('manager_id')->select('manager_id')->with('employee')->get();
        $avatars = [];
        foreach($allManagers as $manager) {
            $avatar = SystemFile::where('model_id', $manager->manager_id)->where('model_type', 'Employees')->where('content_type', 'resized_Avatar')->first();
            if ($avatar){
                $avatars[$manager->manager_id] = $avatar->file_name;
            }
        }

    
        // avatar
        $File = new FileUploadController();
        $avatarbase64 = $File->getImage('Employees', $employee->id, 'Avatar', 1);
        
        $avatar_uploaded = false;
        if ($avatarbase64 == true) {
            $avatar_uploaded = true;
        }
        
        return view('employees::employees_profile', [
            'tab' => $tab,
            'team' => $team,
            'allTeamsTypes' => $allTeamTypes,
            'allManagers' => $allManagers,
            'aimx' => $this->_aimx,
            'avatar_uploaded' => $avatar_uploaded,
            'avatarbase64' => $avatarbase64,
            'avatar_b64' => $avatarbase64,
            'avatars' => $avatars
        ]);
    }
    public function onAction(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $post = $request->input();
        $action = $request->input('action');
        $teamId = $request->input('team_id');
        $team = EmployeeTeam::find($teamId);
        if (!$team) {
            return $this->toast("error", "Team not found");
        }
        if (method_exists($this, "action_" . $action)) {
            return $this->{"action_" . $action}($auth, $post, $team);
        }
        return $this->toast("error", "Action not found");
    }
    private function action_update_profile($auth, $post, $team)
{   
    $validator = Validator::make($post, [
        'data.title' => 'required|string',
        'data.initials' => 'required|string',
        'data.is_active' => 'required|boolean',
        'data.color' => 'required|integer|exists:employee_team_types,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }
    $data = $post['data'];
    $team->title = $data['title'];
    $team->initials = $data['initials'];
    $team->is_active = $data['is_active'] !== '' ? $data['is_active'] : null;
    $team->team_type_id = $data['color'];
    $team->save();

    return $this->toast("success", "Profile updated successfully");
}

    private function action_open_profile($auth, $post, $team)
    {
        // if (isset($post['manager_id'])) {
        //     return $this->toast("error", "Manager not found");
        // }
        
        return $this->redirect("/employees/profile/".$post['manager_id']);
    }

    
    


    public function onUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'data.title' => 'string|max:255',
            'data.manager_id' => 'exists:employees,id',
            'data.is_active' => 'boolean',

        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toast($error);
            }
        }

        $previousUrl = url()->previous();
        $id = explode('/', $previousUrl);
        $id = end($id);

        $title = $request->input('data.title');
        $manager_id = $request->input('data.manager_id');
        $is_active = $request->input('data.is_active');

        $team = EmployeeTeam::find($id);

        if ($team) {
            $team->title = $title;
            $team->manager_id = $manager_id;
            $team->is_active = $is_active;
            $team->save();

            return $this->toast("Updated!");
        } else {
            return $this->toast("Team not found!");
        }
    }

    public function onDelete(Request $request)
    {
        $auth = $this->auth("employeeteams.manage_employeeteams");
        if (!$auth['ok']) {
            return $auth['x'];
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toast($error);
            }
        }

        $id = $request->input('id');

        $deleted = EmployeeTeam::destroy($id);

        if($deleted) {
            return $this->redirect('/employees-teams');
        }
        return $this->toast("Failed to delete the record.");
    }
    public function onSaveAvatar (Request $request) {
        
        $file = $request->file('file');
        $modelType = 'Employees';
        $modelId = $request->input('modelId');
        $disk = 'local';
        $public = 1;
        $contentType = 'Avatar';

        //uploading a file
        if ($file) {
            $res = $this->uploadAvatar($file, $modelType, $modelId, $disk, $public, $contentType);
            return $res;
        }
        //deleting file
        else {
            $res = $this->deleteAvatar($modelType, $modelId, $contentType, $disk, $public);
            return $res;
        }
    }
    

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('employeeteams::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('employeeteams::edit');
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}