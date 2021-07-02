<div class="accordion">
  <!-- Общий параметры поиска -->
  <div class="card">
    <div class="card-header" id="headingOne">
      <button class="btn btn-block d-flex" type="button" data-toggle="collapse" data-target="#first-collapse"
        aria-controls="first-collapse">
        <span>{{ __('messages.Gidromet') }}</span>
        <span class="ml-auto"><i class="bi bi-plus"></i></span>
      </button>
    </div>
    <div id="first-collapse" class="collapse map-collapse" aria-labelledby="headingOne">
      <div class="card-body">
        <div class="form-check">
          <input id="my-input3" class="form-check-input" type="checkbox" v-model="checkedObjs" value="stations">
          <label for="my-input3" class="form-check-label">{{ __('messages.stations') }}</label>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingTwo">
      <button class="btn btn-block d-flex" type="button" data-toggle="collapse" data-target="#second-collapse"
        aria-controls="second-collapse">
        <span>{{ __('messages.Minvodxoz') }}</span>
        <span class="ml-auto"><i class="bi bi-plus"></i></span>
      </button>
    </div>
    <div id="second-collapse" class="collapse map-collapse" aria-labelledby="headingTwo">
      <div class="card-body">
        <div class="form-check">
          <input id="my-input4" class="form-check-input" type="checkbox" v-model="checkedObjs" value="pumpstations">
          <label for="my-input4" class="form-check-label">{{ __('messages.pumpstations') }}</label>
        </div>
        <div class="form-check">
          <input id="my-input5" class="form-check-input" type="checkbox" v-model="checkedObjs" value="waterworks">
          <label for="my-input5" class="form-check-label">{{ __('messages.waterworks') }}</label>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingThree">
      <button class="btn btn-block d-flex" type="button" data-toggle="collapse" data-target="#third-collapse"
        aria-controls="third-collapse">
        <span>{{ __('messages.Gidrogeologiya') }}</span>
        <span class="ml-auto"><i class="bi bi-plus"></i></span>
      </button>
    </div>
    <div id="third-collapse" class="collapse map-collapse" aria-labelledby="headingThree">
      <div class="card-body">
        <div class="form-check">
          <input id="my-input1" class="form-check-input" type="checkbox" v-model="checkedObjs" value="groundwaters">
          <label for="my-input1" class="form-check-label">{{ __('messages.groundwaters') }}</label>
        </div>
        <div class="form-check">
          <input id="my-input2" class="form-check-input" type="checkbox" v-model="checkedObjs" value="wells">
          <label for="my-input2" class="form-check-label">{{ __('messages.wells') }}</label>
        </div>
      </div>
    </div>
  </div>

  <br>
  <div class="container">
    <div class="row">
      <div class="col-auto mb-1">
        <button class="btn btn-outline-primary btn-sm" @click.prevent="search" name="submit_btn">
          {{ __('messages.Submit') }}
        </button>
      </div>
    </div>
  </div>
</div>
