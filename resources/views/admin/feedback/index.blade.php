

@extends('admin.layouts.app')

@section('main')
@include('admin.layouts.top-nav')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered user_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Submited By</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Up Vote</th>
                        <th>Down Vote</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
