@extends('Dashboard.master')

@section('title')
    Accepted Trainee
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">All Trainee accepted in this Program</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('programs.index')}}"
                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4">
                    <i class="la la-retweet"></i> Back
                </a>

                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>education</th>
                    <th>gpa</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>payment</th>
                    <th>Language</th>
                    <th>Actions</th>
                    <th>Documents</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trainees as $trainee)
                    <tr data-entry-id="{{ $trainee->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$trainee->trainee->first_name}} {{$trainee->trainee->last_name}}</td>
                        <td>{{$trainee->trainee->email}}</td>
                        <td>{{$trainee->trainee->phone}}</td>
                        <td>{{$trainee->trainee->education}}</td>
                        <td>{{$trainee->trainee->gpa}}</td>
                        <td>{{$trainee->trainee->address}}</td>
                        <td>{{$trainee->trainee->city}}</td>


                        <td data-entry-id="{{ $trainee->trainee->id }}" class="datatable-cell status-cell">
                             <span style="width: 108px;">
                                 <span
                                     class="label font-weight-bold label-lg label-light-{{ $trainee->trainee->is_approved == '1' ? 'primary' : 'danger' }} label-inline">
                                     {{ $trainee->trainee->is_approved == 1 ? 'Approved' : 'Not Approved' }}
                                 </span>
                             </span>
                        </td>
                        <td>{{$trainee->trainee->payment}}</td>
                        <td>{{$trainee->trainee->language}}</td>
                        <td>
                            <a href="{{ route('trainees.show', $trainee->id) }}"
                               class="btn btn-sm btn-clean btn-icon"
                               title="Show details">
                                <i class="la la-eye"></i>
                            </a>
                        </td>
                        <td>
                            @if($trainee->trainee->cv)
                                <a href="{{ $trainee->trainee->cv}}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download CV</a>
                            @endif

                            @if($trainee->trainee->certification)
                                <a href="{{ $trainee->trainee->certification }}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download Certification</a>
                            @endif

                            @if(count($trainee->trainee->otherFile ?? []) > 0)
                                @foreach($trainee->trainee->otherFile as $otherFileUrl)
                                    <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank"
                                       rel="noopener noreferrer">Related File</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>

@endsection


@section('js')

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

@endsection
