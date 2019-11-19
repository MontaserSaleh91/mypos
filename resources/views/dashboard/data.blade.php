@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.data')</h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active">@lang('site.data')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">@lang('site.year')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('site.month')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">@lang('site.day')</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
           
           
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">@lang('site.date')</th>
                        <th scope="col">@lang('site.purchase')</th>
                        <th scope="col">@lang('site.profit')</th>
                        <th scope="col">@lang('site.total')</th>
                      </tr>
                </thead>
                <tbody>
            @foreach ($sales_data_year as $data)
                  <tr>
                    <th scope="row">{{ $data->year }}</th>
                    <td>{{ $data->purchase }}</td>
                    <td>{{ $data->profit }}</td>
                    <td>{{ $data->price }}</td>
                  </tr>
                @endforeach
             </tbody>
            </table>
           
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">@lang('site.date')</th>
                        <th scope="col">@lang('site.purchase')</th>
                        <th scope="col">@lang('site.profit')</th>
                        <th scope="col">@lang('site.total')</th>
                      </tr>
                </thead>
                <tbody>
            @foreach ($sales_data_month as $data)
                  <tr>
                    <th scope="row">{{ $data->year }} - {{ $data->month }}</th>
                    <td>{{ $data->purchase }}</td>
                    <td>{{ $data->profit }}</td>
                    <td>{{ $data->price }}</td>
                  </tr>
                @endforeach
             </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" >
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">@lang('site.date')</th>
                    <th scope="col">@lang('site.purchase')</th>
                    <th scope="col">@lang('site.profit')</th>
                    <th scope="col">@lang('site.total')</th>
                  </tr>
                </thead>
                <tbody>
            @foreach ($sales_data_day as $data)
                  <tr>
                    <th scope="row">{{ $data->year }} - {{ $data->month }} - {{ $data->day }}</th>
                    <td>{{ $data->purchase }}</td>
                    <td>{{ $data->profit }}</td>
                    <td>{{ $data->price }}</td>
                  </tr>
                @endforeach
             </tbody>
            </table>
        </div>
      </div>

  

      </div>
    </section>
</div>

@endsection

@push('scripts')

<script>
    $(function () {
      $('#pills-tab li:last-child a').tab('show')
    })
  </script>

   
@endpush