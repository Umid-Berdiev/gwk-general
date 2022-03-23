@extends('layouts.master')
@section('content')
  <div class="py-3">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <h6 class="text-uppercase " style="color: #007bff;">
                {{ __('messages.История') }} - {{getDataEchangeName($selected_element)}}
              </h6>
            </div>
            <div class="col-md-9">
              <a href="{{route('exchange.instance.element.data',['selected_instance' => $selected_instance , 'selected_element' => $selected_element ,'selected_date' => $selected_date ,'action' => $action])}}" class="btn btn-sm btn-warning" style="float: right">
                {{ __('messages.Назад') }}
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table class="table table-striped">
              <thead>
              <tr>
                <td>#</td>
                <td>Тип</td>
                <td>Дата</td>
              </tr>
              </thead>
              <tbody>
              @foreach($logs as  $key=>$value)
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>
                    {{getDataEchangeName($selected_element)}}
                  </td>
                  <td>{{date('d.m.Y H:i',strtotime($value->created_at))}}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
            {{ $logs->withQueryString()->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
