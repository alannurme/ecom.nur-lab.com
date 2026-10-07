@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 h6">{{translate('Database Backups')}}</h5>
                <a href="{{ route('backups.create') }}" class="btn btn-primary btn-sm">
                    <i class="las la-plus"></i> {{translate('Create New Backup')}}
                </a>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('File Name')}}</th>
                            <th>{{translate('File Size')}}</th>
                            <th>{{translate('Created Date')}}</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($backups as $key => $backup)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $backup['name'] }}</td>
                                <td>{{ $backup['size'] }}</td>
                                <td>{{ $backup['date'] }}</td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('backups.download', $backup['name']) }}" title="{{ translate('Download') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" href="{{ route('backups.destroy', $backup['name']) }}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ translate('No Backups Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
