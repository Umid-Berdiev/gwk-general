@extends('layouts.master')
@section('content')
  <main id="main" class="py-3">
    <div class="container">
      <div class="row my-3">
        <div class="col-3">
          <div class="card text-white bg-danger">
            <div class="card-body text-center">
              <h3 class="card-title">{{ 1 }}</h3>
              <p class="card-text">{{ __('messages.Gidromet') }}</p>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card text-white bg-success">
            <div class="card-body text-center">
              <h3 class="card-title">{{ 2 }}</h3>
              <p class="card-text">{{ __('messages.Minvodxoz') }}</p>
            </div>
          </div>
        </div>
        <div class="col-3">
          <div class="card text-white bg-warning">
            <div class="card-body text-center">
              <h3 class="card-title">{{ 3 }}</h3>
              <p class="card-text">{{ __('messages.Gidrogeologiya') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="panel panel-default">
          <div class="panel-heading"></div>
          <div class="panel-body">
            {{ __('messages.Gidromet') }}, {{__('messages.Количество данных, полученных за последние 10 дней')}}
            <canvas id="Gidromet" height="280" width="600"></canvas>
            <br>
            {{ __('messages.Minvodxoz') }}, {{__('messages.Количество данных, полученных за последние 10 дней')}}
            <canvas id="Minvadxoz" height="280" width="600"></canvas>
            <br>
            {{ __('messages.Gidrogeologiya') }}, {{__('messages.Количество данных, полученных за последние 10 дней')}}
            <canvas id="Geologiya" height="280" width="600"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script>
    var date_gidro = <?php echo json_encode($dataGidro['date']?? []); ?>;
    var count_gidro = <?php echo json_encode($dataGidro['count'] ?? []); ?>;


    var date_min = <?php echo json_encode($dataMin['date'] ?? []); ?>;
    var count_min = <?php echo json_encode($dataMin['count'] ?? []); ?>;

    var date_geo = <?php echo json_encode($dataGeo['date'] ?? []); ?>;
    var count_geo = <?php echo json_encode($dataGeo['count'] ?? []); ?>;

    var barChartData_Gidro = {
      labels: date_gidro,
      datasets: [{
        label: 'Гидромет',
        backgroundColor: "#68d47c",
        data: count_gidro
      }]
    };

    var barChartData_minvadxoz = {
      labels: date_min,
      datasets: [{
        label: 'Минвадхоз',
        backgroundColor: "#f5a2c3",
        data: count_min
      }]
    };


    var barChartData = {
      labels: date_geo,
      datasets: [{
        label: 'Гидрогеология',
        backgroundColor: "#91abd9",
        data: count_geo
      }]
    };




    window.onload = function () {

      var ctx_2 = document.getElementById("Gidromet").getContext("2d");
      window.myBar = new Chart(ctx_2, {
        type: 'bar',
        data: barChartData_Gidro,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
              borderColor: '#c1c1c1',
              borderSkipped: 'bottom'
            }
          },
          responsive: true,
          title: {
            display: true,
            text: ''
          }
        }
      });

      /********* Minvadxoz *******/
      var ctx_3 = document.getElementById("Minvadxoz").getContext("2d");
      window.myBar = new Chart(ctx_3, {
        type: 'bar',
        data: barChartData_minvadxoz,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
              borderColor: '#c1c1c1',
              borderSkipped: 'bottom'
            }
          },
          responsive: true,
          title: {
            display: true,
            text: ''
          }
        }
      });

      /********* Geologiya *******/
      var ctx = document.getElementById("Geologiya").getContext("2d");
      window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
              borderColor: '#c1c1c1',
              borderSkipped: 'bottom'
            }
          },
          responsive: true,
          title: {
            display: true,
            text: ''
          }
        }
      });

    };
  </script>
@endsection

@section('css')
  <style type="text/css">
    .card {
      box-shadow: 5px 5px grey;
    }
  </style>
@endsection
