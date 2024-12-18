<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\User;

// Services
use App\Services\UserService;

// Repositories
use App\Repositories\UserRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\UserSearchRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * UserService instance to use various functions of UserService.
     *
     * @var \App\Services\UserService
     */
    protected $userService;

    /**
     * UserRepository instance to use various functions of UserRepository.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->userService = new UserService;
        $this->userRepository = new UserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $users = $this->userRepository->getPaginatedListOfUsers(20);

        if ($users)
            return view('backend.admin.user.index', compact('users'));
        else {
            Session::flash('failure', 'There is some problem in fetching users at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Search users.
     *
     * @param  \App\Http\Request\Backend\UserSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function search(UserSearchRequest $request)
    {
        $search = $request->validated();
        
        $users = $this->userRepository->getPaginatedListOfUsersByUsername($search['username'], 20);

        if ($users) {
            Session::flash('success', 'The users have been searched successfully.');

            return view('backend.admin.user.search-result', compact('users', 'search'));
        }
        else {
            Session::flash('failure', 'There is some problem in searching the user.');

            return redirect(route('user.index'));
        }
    }

    /**
     * Change blocking status of a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(User $user)
    {
        $update['is_blocked'] = !$user->is_blocked;
        
        if ($this->userRepository->updateUserByObject($update, $user))
            Session::flash('success', 'The user status is changed successfully.');
        else
            Session::flash('failure', 'There is some problem in changing the status of the user.');
        
        return redirect(route('user.index'));
    }

    /**
     * userDetailsDownloadCsv
     **/
    public function userDetailsDownloadCsv(Request $request)
    {
        # code...
        $id = !empty($request->id)?$request->id:25;
        $user = User::find($id);
        $filename = $user->username.'.csv';
        $basicColumns = array(
            $user->name,                
            $user->username,                
            $user->role->name,                
            $user->email,                
            $user->phone_number,            
            date('Y-m-d H:i a', strtotime($user->created_at))
        );
        $basicHeaders = array('Name', 'Username', 'Role',  'Email', 'Phone', 'Registered At');
        $other_details = $user->other_details;
        if(!empty($other_details)){
            $allKeys = $allValues = array();
            foreach($other_details as $key => $value){
                $allKeys[] = ucwords($key);
                $allValues[] = $value;
            }
            
            $basicColumns =  array_merge($basicColumns, $allValues);
            $basicHeaders = array_merge($basicHeaders,$allKeys);
           

        } 
        
        $dataArr[] = $basicColumns;
        // Set PHP headers for CSV output.
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
        
        // Clean up output buffer before writing anything to CSV file.
        ob_end_clean();
        // Create a file pointer with PHP.
        $output = fopen( 'php://output', 'w' );
        // Write headers to CSV file.
        fputcsv( $output, $basicHeaders );
        // // Loop through the prepared data to output it to CSV file.
        foreach( $dataArr as $data_item ){
            fputcsv( $output, $data_item );
        }

        // Close the file pointer with PHP with the updated output.
        fclose( $output );
        exit;

        
        
        

        
    }
}
