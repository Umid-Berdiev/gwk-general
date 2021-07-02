<div class="modal fade" id="wellModal" tabindex="-1" role="dialog" aria-labelledby="wellModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header p-md-2">
        <h6 class="modal-title" id="wellModalLabel"><b>Скважины</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#home" role="tab"
              aria-controls="home" aria-selected="true">Реестр</a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table small table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Параметры</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <template v-if="wellInfo">
                  <tr>
                    <td>Год ввода информации</td>
                    <td>@{{ wellInfo.year ? wellInfo.year : '' }}</td>
                  </tr>
                  <tr>
                    <td>Тип cкважины</td>
                    <td>@{{ wellInfo.well_type ? wellInfo.well_type.name : '' }}</td>
                  </tr>
                  <tr>
                    <td>Авторский номер</td>
                    <td>@{{ wellInfo.number_auther }}</td>
                  </tr>
                  <tr>
                    <td>Кадастровый номер</td>
                    <td>@{{ wellInfo.cadaster_number }}</td>
                  </tr>
                  <tr>
                    <td>Область</td>
                    <td>@{{ getRegions(wellInfo.well_attrs) }}</td>
                  </tr>
                  <tr>
                    <td>Район</td>
                    <td>@{{ getDistricts(wellInfo.well_attrs) }}</td>
                  </tr>
                  <tr>
                    <td>Месторождение подземных вод</td>
                    <td>@{{ wellInfo.place_birth ? wellInfo.place_birth.name : '' }}</td>
                  </tr>
                  <tr>
                    <td>Северная широта</td>
                    <td>@{{ wellInfo.lat }}</td>
                  </tr>
                  <tr>
                    <td>Восточная долгота</td>
                    <td>@{{ wellInfo.long }}</td>
                  </tr>
                  <tr>
                    <td>Местоположение</td>
                    <td>@{{ wellInfo.location }}</td>
                  </tr>
                  <tr>
                    <td>Абсолютная отметка</td>
                    <td>@{{ wellInfo.absolute_mark }}</td>
                  </tr>
                  <tr>
                    <td>Год начала наблюдений</td>
                    <td>@{{ wellInfo.year_drilling }}</td>
                  </tr>
                  <tr>
                    <td>Диаметр обсадки, мм</td>
                    <td>@{{ wellInfo.casing_diameter }}</td>
                  </tr>
                  <tr>
                    <td>Интервал установки фильтра, м</td>
                    <td>@{{ wellInfo.filter_interval_from + ' - ' + wellInfo.filter_interval_up }}</td>
                  </tr>
                  <tr>
                    <td>Геологический возраст водоносного горизонта</td>
                    <td>@{{ wellInfo.geologic_age }}</td>
                  </tr>
                  <tr>
                    <td>Литологический разрез</td>
                    <td>@{{ wellInfo.age_lithology }}</td>
                  </tr>
                  <tr>
                    <td>Статический уровень, м</td>
                    <td>@{{ wellInfo.static_level }}</td>
                  </tr>
                  <tr>
                    <td>Целевое использование</td>
                    <td>@{{ wellInfo.intended ? wellInfo.intended.name : '' }}</td>
                  </tr>
                  <tr v-show="wellInfo.well_type && wellInfo.well_type.id != 5">
                    <td>Лимит водоотбора</td>
                    <td>@{{ wellInfo.water_withdrawal_limit }}</td>
                  </tr>
                  <tr v-show="wellInfo.well_type && wellInfo.well_type.id != 5">
                    <td>Динамический уровень, м</td>
                    <td>@{{ wellInfo.dynamic_level }}</td>
                  </tr>
                  <tr v-show="wellInfo.well_type && wellInfo.well_type.id != 5">
                    <td>Расход, л/с</td>
                    <td>@{{ wellInfo.comsuption }}</td>
                  </tr>
                  <tr>
                    <td>Минерализация, г/л</td>
                    <td>@{{ wellInfo.mineralization }}</td>
                  </tr>
                  <tr>
                    <td>Жесткость мг-экв/л</td>
                    <td>@{{ wellInfo.rigidity }}</td>
                  </tr>
                </template>
                <template v-else>
                  <h5>Для этого объекта инфо не найдено!</h5>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
