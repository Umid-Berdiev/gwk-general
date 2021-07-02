<div class="modal fade" id="pumpstationModal" tabindex="-1" role="dialog" aria-labelledby="pumpstationModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pumpstationModalLabel"><b>НАСОСНАЯ СТАНЦИЯ</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <template v-if="pumpstationInfo">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Кадастровый номер</th>
                <td v-text="pumpstationInfo.code"></td>
              </tr>
              <tr>
                <th>Название</th>
                <td v-text="pumpstationInfo.name"></td>
              </tr>
              <tr>
                <th>Местоположение</th>
                <td v-text="pumpstationInfo.location"></td>
              </tr>
              <tr>
                <th>Источник воды</th>
                <td v-text="pumpstationInfo.water_source"></td>
              </tr>
              <tr>
                <th>Класс капитализации</th>
                <td v-text="pumpstationInfo.pumpstation_class?.name"></td>
              </tr>
              <tr>
                <th>Основная функция</th>
                <td v-text="pumpstationInfo.pumpstation_function?.name"></td>
              </tr>
              <tr>
                <th>Максимальный расход воды (м3/с)</th>
                <td v-text="pumpstationInfo.max_wateruse"></td>
              </tr>
              <tr>
                <th>Высота подъема (м)</th>
                <td v-text="pumpstationInfo.lift_height"></td>
              </tr>
              <tr>
                <th>Количество агрегатов (шт)</th>
                <td v-text="pumpstationInfo.aggregates_n"></td>
              </tr>
              <tr>
                <th>Установленная мощность (кВт)</th>
                <td v-text="pumpstationInfo.capacity"></td>
              </tr>
              <tr>
                <th>Дата начало эксплуатации</th>
                <td v-text="pumpstationInfo.launch_date"></td>
              </tr>
              <tr>
                <th>Пользователь - организация</th>
                <td v-text="pumpstationInfo.wateruser_orgs"></td>
              </tr>
              <tr>
                <th>Балансовый стоимость (тыс.сум)</th>
                <td v-text="pumpstationInfo.book_value"></td>
              </tr>
              <tr>
                <th>Примечание</th>
                <td v-text="pumpstationInfo.comment"></td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
