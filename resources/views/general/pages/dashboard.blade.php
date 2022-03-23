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
          <div class="panel-heading">{{__('messages.Количество данных, полученных за последние 10 дней')}}</div>
          <div class="panel-body">
            <canvas id="Gidromet" height="280" width="600"></canvas>
            <canvas id="Minvadxoz" height="280" width="600"></canvas>
            <canvas id="Geologiya" height="280" width="600"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script>
    var date_gidro = <?php echo json_encode($dataGidro['date']); ?>;
    var count_gidro = <?php echo json_encode($dataGidro['count']); ?>;

    var date = <?php echo json_encode($dataGeo['date'] ?? []); ?>;
    var count = <?php echo json_encode($dataGeo['count'] ?? []); ?>;

    var date = <?php echo json_encode($dataMin['date'] ?? []); ?>;
    var count = <?php echo json_encode($dataMin['count'] ?? []); ?>;


    var barChartData_Gidro = {
      labels: date_gidro,
      datasets: [{
        label: 'Гидромет',
        backgroundColor: "#84c3e3",
        data: count_gidro
      }]
    };

    var barChartData = {
      labels: date,
      datasets: [{
        label: 'Гидрогеология',
        backgroundColor: "#84c3e3",
        data: count
      }]
    };

    var barChartData_minvadxoz = {
      labels: date,
      datasets: [{
        label: 'Минвадхоз',
        backgroundColor: "#84c3e3",
        data: count
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
