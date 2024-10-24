@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Assistant')</th>
                                    <th>@lang('Login at')</th>
                                    <th>@lang('IP')</th>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Browser | OS')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loginLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$log->assistant->name }}</span>
                                            <br>
                                            <span class="small"> <a
                                                    href="{{ route('admin.assistant.detail', $log->assistant_id) }}"><span>@</span>{{ @$log->assistant->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ showDateTime($log->created_at) }} <br> {{ diffForHumans($log->created_at) }}
                                        </td>
                                        <td>{{ $log->assistant_ip }} </td>
                                        <td>{{ __($log->city) }} <br> {{ __($log->country) }}</td>
                                        <td>
                                            {{ __($log->browser) }} <br> {{ __($log->os) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? '') }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($loginLogs->hasPages())
                    <div class="card-footer py-4 d-flex justify-content-between flex-row-reverse">
                        Showing {{ $loginLogs->firstItem() }} to {{ $loginLogs->lastItem() }}
                        of total {{$loginLogs->total()}} entries
                        @php echo paginateLinks($loginLogs) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search here" />
@endpush
