<div class="modal fade" id="stationModal" tabindex="-1" role="dialog" aria-labelledby="stationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <table class="table table-striped table-bordered">
          <tbody>
            <template v-if="stationInfo">
              <tr>
                <th scope="col">Код станции</th>
                <td v-text="stationInfo.station_code"></td>
              </tr>
              <tr>
                <th scope="col">Наименование</th>
                <td v-text="stationInfo.station_name"></td>
              </tr>
              <tr>
                <th scope="col" class="text-left">Широта</th>
                <td v-text="stationInfo.latitude"></td>
              </tr>
              <tr>
                <th scope="col" class="text-left">Долгота</th>
                <td v-text="stationInfo.longitude"></td>
              </tr>
            </template>
            <template v-else>
              <h5>Для этого объекта инфо не найдено!</h5>
            </template>
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">
          {{ __('Закрыть') }}
        </button>
      </div>
    </div>
  </div>
</div>
