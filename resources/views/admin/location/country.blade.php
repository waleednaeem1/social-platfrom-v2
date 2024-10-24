@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Abbreviation')</th>
                                    <th>@lang('Phone Code')</th>
                                    <th>@lang('Capital')</th>
                                    <th>@lang('Status')</th>
                                    {{-- <th>@lang('Action')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allCountries as $country)
                                    <tr>
                                        <td>{{ $allCountries->firstItem() + $loop->index }}</td>
                                        <td>{{ __($country->id) }}</td>
                                        <td>{{ __($country->name) }}</td>
                                        <td>{{ __($country->iso3) }}</td>
                                        <td>{{ __($country->phonecode) }}</td>
                                        <td>{{ __($country->capital) }}</td>
                                        <td>{{ __($country->flag) }}</td>
                                        {{-- <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary editBtn cuModalBtn"
                                                data-resource="{{ $country }}" data-modal_title="@lang('Edit Country')"
                                                data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? '') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($allCountries->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($allCountries) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <!--Cu Modal -->
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.department.location.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />

    {{-- <button type="button" class="btn btn-sm btn-outline--primary h-45 cuModalBtn" data-modal_title="@lang('Add New Location')">
        <i class="las la-plus"></i>@lang('Add New')
    </button> --}}
@endpush
