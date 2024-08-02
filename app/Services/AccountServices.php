<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use DataTables;

class AccountServices
{
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }
    public function loaddata(){
        $data = $this->repository->loadData();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('full_name', function($row) {
                return $row->first_name.' '.$row->last_name;
            })
            ->addColumn('email', function($row) {
                return $row->user->email;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.accountdetail', ['id' => $row->id]).'" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm mr-1">View</a>';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" data-action="toggle" class="btn btn-sm btn-primary toggle-status">';
                $btn .= $row->is_active ? 'Deactivate' : 'Activate';
                $btn .= '</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true); 
    }
    public function store($input){
        foreach($input['addaccount'] as $key=>$val){
            $this->repository->store($val);
        }
        return; 
    }
    public function changestatus($request){
        $account = $this->repository->changestatus($request);
        if ($account) {
            $account->is_active = $account->is_active ? 0 : 1;
            $account->save();
            return response()->json(['success' => 'Account status updated successfully.']);
        }
    }
}