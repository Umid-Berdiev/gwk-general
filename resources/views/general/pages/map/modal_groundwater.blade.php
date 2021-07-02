<div class="modal fade" id="groundwaterModal" tabindex="-1" role="dialog" aria-labelledby="groundwaterModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="groundwaterModalLabel"><b>Месторождение подземных вод</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 0!important;">
        <table class="table table-bordered small">
          <thead class="thead-dark">
            <tr>
              <th>Параметры</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <template v-if="groundwaterInfo">
              <tr>
                <td>Год ввода информации</td>
                <td>@{{ groundwaterInfo.year }}</td>
              </tr>
              <tr>
                <td>Кадастровый номер</td>
                <td>@{{ groundwaterInfo.code }}</td>
              </tr>
              <tr>
                <td>Название месторождения</td>
                <td>@{{ groundwaterInfo.name }}</td>
              </tr>
              <tr>
                <td>Геологический возраст водоносного горизонта</td>
                <td>@{{ groundwaterInfo.geol_index }}</td>
              </tr>
              <tr>
                <td>Ресурсы подземных вод, тыс.м&sup3;/сут</td>
                <td>@{{ groundwaterInfo.groundwater_resource }}</td>
              </tr>
              <tr>
                <td>Утверждённые запасы подземных вод, тыс.м&sup3;</td>
                <td>@{{ groundwaterInfo.approved_groundwater_reserves }}</td>
              </tr>
              <tr>
                <td>Отбор из утверждённых запасов подземных вод, тыс.м&sup3;</td>
                <td>@{{ groundwaterInfo.selection_from_approved_groundwater_reserves }}</td>
              </tr>
              <tr>
                <td>Область</td>
                <td>@{{ getRegions(groundwaterInfo.place_birth_attrs) }}</td>
              </tr>
              <tr>
                <td>Примечание</td>
                <td>@{{ groundwaterInfo.comment }}</td>
              </tr>
            </template>
            <template v-else>
              <h5>Для этого объекта инфо не найдено!</h5>
            </template>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
