<div class="modal fade" id="waterworkModal" tabindex="-1" role="dialog" aria-labelledby="waterworkModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="waterworkModalLabel"><b>Гидроузел</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <template v-if="waterworkInfo">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Кадастровый номер</th>
                <td v-text="waterworkInfo.code"></td>
              </tr>
              <tr>
                <th>Название</th>
                <td v-text="waterworkInfo.name"></td>
              </tr>
              <tr>
                <th>Русло реки</th>
                <td v-text="waterworkInfo.waterbody_id"></td>
              </tr>
              <tr>
                <th>Местоположение</th>
                <td v-text="waterworkInfo.location"></td>
              </tr>
              <tr>
                <th>Источник воды</th>
                <td v-text="waterworkInfo.water_source"></td>
              </tr>
              <tr>
                <th>Функция</th>
                <td v-text="waterworkInfo.waterwork_func?.name"></td>
              </tr>
              <tr>
                <th>Водопользователи</th>
                <td v-text="waterworkInfo.water_users"></td>
              </tr>
              <tr>
                <th>Класс капитализации</th>
                <td v-text="waterworkInfo.class_capital?.name"></td>
              </tr>
              <tr>
                <th>Тип гидроузела</th>
                <td v-text="waterworkInfo.water_work_type?.name"></td>
              </tr>
              <tr>
                <th>Максимальная высота плотины (м)</th>
                <td v-text="waterworkInfo.dam_max_height"></td>
              </tr>
              <tr>
                <th>Пропускной способность (м3/с)</th>
                <td v-text="waterworkInfo.throughput_capacity"></td>
              </tr>
              <tr>
                <th>Дата начало эксплуатации</th>
                <td v-text="waterworkInfo.launch_date"></td>
              </tr>
              <tr>
                <th>Пользователь - организация</th>
                <td v-text="waterworkInfo.wateruser_orgs"></td>
              </tr>
              <tr>
                <th>Балансовый стоимость (тыс.сум)</th>
                <td v-text="waterworkInfo.book_value"></td>
              </tr>
              <tr>
                <th>Примечание</th>
                <td v-text="waterworkInfo.comment"></td>
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
