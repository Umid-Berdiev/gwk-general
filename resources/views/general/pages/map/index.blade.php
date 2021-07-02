@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
<style>
  #mapid {
    height: 80vh;
  }

  #map-right-sidebar-toggle-btn {
    z-index: 1002;
    right: 0;
    bottom: 0;
  }

  #map-right-sidebar {
    z-index: 1001;
    right: 0;
  }
</style>
@endsection

@section('content')
<div class="container-fluid" id="map-instance">
  <div v-if="isLoading" class="position-absolute d-inline my-auto" style="z-index: 1000; top: 50%; left: 45%;">
    <div class="spinner-grow" style="width: 5rem; height: 5rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="row justify-content-center">
    <!-- there will be a map -->
    <div class="col-12" id="mapid"></div>

    <div id="map-right-sidebar" v-show="isShown" class="col-3 position-absolute bg-white h-100">
      <!-- accordion -->
      @include('general.pages.map.accordion')
    </div>
    <div id="map-right-sidebar-toggle-btn" class="position-absolute">
      <button class="btn btn-primary" @click="isShown = !isShown">
        {{ __('messages.Фильтр') }}
      </button>
    </div>
  </div>
</div>
@endsection

@section('modal')
@include('general.pages.map.modal_groundwater')
@include('general.pages.map.modal_pumpstation')
@include('general.pages.map.modal_station')
@include('general.pages.map.modal_waterwork')
@include('general.pages.map.modal_well')
@endsection

@push('scripts')
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
  const mapInstance = new Vue({
    el: "#map-instance",
    data() {
      return {
        isLoading: false,
        isShown: false,
        tileProviders: [{
            name: "Openstreet харита",
            attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
          },
          {
            name: "Google харита",
            url: "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}",
            attribution: "GoogleMaps",
          },
          {
            name: "Google харита (сунъний йўлдош)",
            url: "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}",
            attribution: "GoogleSatellite",
          },
        ],
        checkedObjs: [],
        groundwaterInfo: null,
        map: null,
        arcgisToken: ""
      }
    },
    mounted() {
      const params = new URLSearchParams();
      params.append('username', 'webservice');
      params.append('password', 'webm@ster20');

      fetch('http://213.230.126.118:6080/arcgis/tokens/generateToken', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        // mode: 'cors', // no-cors, *cors, same-origin
        // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        // credentials: 'same-origin', // include, *same-origin, omit
        headers: {
          // 'Content-Type': 'application/json'
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        // redirect: 'follow', // manual, *follow, error
        // referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: params // body data type must match "Content-Type" header
      })
      .then(response => response.text())
      .then(data => {
        mapInstance.arcgisToken = data
      })
      .catch(error => console.log('Ошибка при получение токен ключа из АРГИС: ', error));

      this.initialMap()
    },
    methods: {
      initialMap() {
        const OpenstreetMapLayer = L.tileLayer(this.tileProviders[0].url, this.tileProviders[0].attribution);
        const googleMapLayer = L.tileLayer(this.tileProviders[1].url, this.tileProviders[1].attribution);
        const googleSatelliteLayer = L.tileLayer(this.tileProviders[2].url, this.tileProviders[2].attribution);

        this.map = L.map('mapid').setView([41.95949, 67.335205], 6);

        L.control.scale({
          imperial: false,
          metric: true
        }).addTo(this.map);

        L.control.layers({
          "Openstreet харита": OpenstreetMapLayer.addTo(this.map),
          "Google харита": googleMapLayer,
          "Google харита (сунъний йўлдош)": googleSatelliteLayer,
        }).addTo(this.map);
      },
      search() {
        this.isLoading = true;
        this.map.eachLayer(layer => {
          if (layer._path != undefined) layer.removeFrom(this.map);
        });

        if (this.checkedObjs.length > 0) {
          this.checkedObjs.forEach(obj => {
            this.fetchMapObjects(obj);
          })
        } else {
          alert('No object selected!');
          this.isLoading = false;
        }
      },
      fetchMapObjects(param) {
        if (param == 'groundwaters') {
          axios.get("{{ config('app.gidrogeologiyaApi') }}" + "/map/groundwaters", {
              params: {
                api_token: "{{ config('app.gidrogeologiyaApiKey') }}"
              }
            })
            .then(response => {
              let responseData = response.data;
              // console.log('ok: ', responseData);
              if (responseData.length > 0) {
                responseData.forEach(item => {
                  L.geoJSON(item, {
                      color: item.properties.favcolor
                    })
                    .bindTooltip(item.properties.name, {
                      permanent: false,
                      direction: 'center'
                    })
                    .addTo(mapInstance.map)
                    .on('click', () => {
                      mapInstance.isLoading = true;
                      axios.get("{{ config('app.gidrogeologiyaApi') }}" + "/map/groundwater", {
                          params: {
                            id: item.properties.id,
                            api_token: "{{ config('app.gidrogeologiyaApiKey') }}"
                          },
                          api_token: "{{ config('app.gidrogeologiyaApiKey') }}"
                        })
                        .then(response => {
                          groundwaterModal.groundwaterInfo = response.data;
                          $('#groundwaterModal').modal('show');
                          mapInstance.isLoading = false;
                        }).catch(error => alert('Нет данные по этому объекту'));
                    });
                });

                let minX = Math.min(responseData.find(item => item.properties.name === 'Центрально-Устюртское')?.geometry.coordinates[0][0][1]);
                let minY = Math.min(responseData.find(item => item.properties.name === 'Центрально-Устюртское')?.geometry.coordinates[0][0][0]);
                let maxX = Math.max(responseData.find(item => item.properties.name === 'Ош-Араванское')?.geometry.coordinates[0][0][1]);
                let maxY = Math.max(responseData.find(item => item.properties.name === 'Ош-Араванское')?.geometry.coordinates[0][0][0]);

                let bounds = L.latLngBounds(
                  [minX, minY],
                  [maxX, maxY]
                );

                // let bounds = L.latLngBounds(
                //   [responseData[0].geometry.coordinates[0][0][1], responseData[0].geometry.coordinates[0][0][0]],
                //   [responseData[responseData.length - 1].geometry.coordinates[0][0][1], responseData[responseData.length - 1].geometry.coordinates[0][0][0]]
                // );

                mapInstance.map.fitBounds(bounds);
              } else alert('Нет данные!');

              mapInstance.isLoading = false;

            }).catch(error => console.log('Ошибка при получения данные: ', error));
        }
        if (param == 'wells') {
          let wellObj;

          axios
            .get("{{ config('app.gidrogeologiyaApi') }}" + "/map/wells", {
              params: {
                api_token: "{{ config('app.gidrogeologiyaApiKey') }}"
              }
            })
            .then(response => {
              let responseData = response.data;

              if (responseData.length > 0) {
                responseData.forEach(item => {
                  wellObj = mapInstance.createGeoJSON(item);

                  L.geoJSON(wellObj, {
                    pointToLayer(feature, latlng) {
                      // let well_color = mapInstance.setColorByType(feature.properties.wells_type_id);
                      let well_state = feature.properties.is_active;
                      // const pulsatingIcon = mapInstance.generatePulsatingMarker(12, well_color, well_state);

                      L.circleMarker(latlng, {
                          radius: 5,
                          fillColor: "orange",
                          color: "#111",
                          weight: 1,
                          opacity: 1,
                          fillOpacity: 0.5,
                        })
                        .bindTooltip(feature.properties.cadaster_number, {
                          permanent: false,
                          direction: 'right'
                        })
                        .addTo(mapInstance.map)
                        .on('click', () => {
                          mapInstance.isLoading = true;
                          axios.get("{{ config('app.gidrogeologiyaApi') }}" + "/map/well", {
                              params: {
                                id: feature.properties.id,
                                api_token: "{{ config('app.gidrogeologiyaApiKey') }}"
                              }
                            })
                            .then(response => {
                              wellModal.wellInfo = response.data;

                              $('#wellModal').modal('show');
                              mapInstance.isLoading = false;
                            }).catch(error => console.log(error));
                        });
                    }
                  }).addTo(mapInstance.map);
                });

                // let minX = Math.min(...responseData.map(item => item.lat));
                // let minY = Math.min(...responseData.map(item => item.long));
                // let maxX = Math.max(...responseData.map(item => item.lat));
                // let maxY = Math.max(...responseData.map(item => item.long));

                // let bounds = L.latLngBounds(
                //   [minX, minY],
                //   [maxX, maxY]
                // );

                // mapInstance.map.fitBounds(bounds);
              } else alert('Нет данные!');

              mapInstance.isLoading = false;
            }).catch(error => console.log('Ошибка при получения данные Минеральные воды: ', error));
        }
        if (param == "stations") {
          axios
            .get("{{ config('app.gidrometApi') }}" + "/map/stations", {
              params: {
                api_token: "{{ config('app.gidrometApiKey') }}"
              }
            })
            .then((response) => {
              this.isLoading = false;
              let responseData = response.data;

              if (responseData.length > 0) {
                responseData.forEach((item) => {
                  let data = mapInstance.createGeoJSON(item);

                  L.geoJSON(data, {
                    pointToLayer(feature, latlng) {
                      L.circleMarker(latlng, {
                          radius: 5,
                          fillColor: "#0078ff",
                          color: "#111",
                          weight: 1,
                          opacity: 1,
                          fillOpacity: 0.5,
                        })
                        .bindTooltip(feature.properties.station_name, {
                          permanent: false,
                          direction: "right",
                        })
                        .addTo(mapInstance.map)
                        .on("click", () => {
                          stationModal.stationInfo = feature.properties;
                          $("#stationModal").modal("show");
                        });
                    },
                  }).addTo(mapInstance.map);
                });

                let minX = Math.min(...responseData.map(item => item.latitude));
                let minY = Math.min(...responseData.map(item => item.longitude));
                let maxX = Math.max(...responseData.map(item => item.latitude));
                let maxY = Math.max(...responseData.map(item => item.longitude));

                let bounds = L.latLngBounds(
                  [minX, minY],
                  [maxX, maxY]
                );

                mapInstance.map.fitBounds(bounds);
              } else alert("Нет данные!");
            })
            .catch((error) =>
              console.log("Ошибка при получения данные: ", error)
            );
        }
        if (param == "pumpstations") {
          fetch('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/1/query?' +
            'token=' + mapInstance.arcgisToken +
            '&text=%D0%B0' +
            '&geometryType=esriGeometryEnvelope' +
            '&inSR=4326' +
            '&spatialRel=esriSpatialRelEnvelopeIntersects' +
            '&outFields=*' +
            '&returnGeometry=true' +
            '&returnTrueCurves=false' +
            '&outSR=4326' +
            '&returnIdsOnly=false' +
            '&returnCountOnly=false' +
            '&returnZ=false' +
            '&returnM=false' +
            '&returnDistinctValues=false' +
            '&returnExtentsOnly=false' +
            '&f=geojson'
          )
          .then(response => response.json())
          .then(data => {
            if (data?.features.length > 0) {
              const geojson = L.geoJson(data, {
                pointToLayer (feature, latlng) {
                  let square = L.circleMarker(latlng, {
                    radius: 5,
                    color: "#ff7800",
                    weight: 1,
                    opacity: 1,
                    fillColor: "#ff7800",
                    fillOpacity: 0.7
                  })

                  square.on('click', function () {
                    axios.get("{{ config('app.minvodxozApi') }}" + "/map/pump-station", {
                        params: {
                          code: feature.properties.Кадас,
                          // start: mapInstance.year_star,
                          // finish: mapInstance.year_finish,
                          api_token: "{{ config('app.minvodxozApiKey') }}"
                        }
                      })
                      .then(response => {
                        if (response != null) {
                          pumpstationModal.pumpstationInfo = response.data.pump_station;
                          $('#pumpstationModal').modal('show');
                        }
                      }).catch(function (error) {
                        console.log(error);
                      })
                  });

                  mapInstance.map.getZoom() >= 11 && square.bindTooltip(feature.properties.Насос, {
                    permanent: true,
                    direction: 'right'
                  })

                  square.addTo(mapInstance.map)
                }
              })

              let minX = Math.min(...data.features.map(item => item.geometry.coordinates[1]));
              let minY = Math.min(...data.features.map(item => item.geometry.coordinates[0]));
              let maxX = Math.max(...data.features.map(item => item.geometry.coordinates[1]));
              let maxY = Math.max(...data.features.map(item => item.geometry.coordinates[0]));

              let bounds = L.latLngBounds(
                [minX, minY],
                [maxX, maxY]
              );

              mapInstance.map.fitBounds(bounds);
            } else alert('Нет данные!');

            mapInstance.isLoading = false;
          });
        }
        if (param == "waterworks") {
          fetch('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/0/query?' +
            'token=' + mapInstance.arcgisToken +
            '&text=%D0%B0' +
            '&geometryType=esriGeometryEnvelope' +
            '&inSR=4326' +
            '&spatialRel=esriSpatialRelEnvelopeIntersects' +
            '&outFields=*' +
            '&returnGeometry=true' +
            '&returnTrueCurves=false' +
            '&outSR=4326' +
            '&returnIdsOnly=false' +
            '&returnCountOnly=false' +
            '&returnZ=false' +
            '&returnM=false' +
            '&returnDistinctValues=false' +
            '&returnExtentsOnly=false' +
            '&f=geojson'
          )
          .then(response => response.json())
          .then(data => {
            if (data?.features.length > 0) {
              const geojson = L.geoJson(data, {
                pointToLayer (feature, latlng) {
                  let square = L.circleMarker(latlng, {
                    radius: 5,
                    color: "#ff0000",
                    weight: 1,
                    opacity: 1,
                    fillColor: "#ff0000",
                    fillOpacity: 0.7
                  })

                  square.on('click', function () {
                    axios.get("{{ config('app.minvodxozApi') }}" + "/map/waterwork", {
                        params: {
                          code: feature.properties.Кадас,
                          // start: mapInstance.year_star,
                          // finish: mapInstance.year_finish,
                          api_token: "{{ config('app.minvodxozApiKey') }}"
                        }
                      })
                      .then(response => {
                        if (response != null) {
                          waterworkModal.waterworkInfo = response.data.waterwork;
                          $('#waterworkModal').modal('show');
                        }
                      }).catch(function (error) {
                        console.log(error);
                      })
                  });

                  mapInstance.map.getZoom() >= 11 && square.bindTooltip(feature.properties.Насос, {
                    permanent: true,
                    direction: 'right'
                  })

                  square.addTo(mapInstance.map)
                }
              })

              let minX = Math.min(...data.features.map(item => item.geometry.coordinates[1]));
              let minY = Math.min(...data.features.map(item => item.geometry.coordinates[0]));
              let maxX = Math.max(...data.features.map(item => item.geometry.coordinates[1]));
              let maxY = Math.max(...data.features.map(item => item.geometry.coordinates[0]));

              let bounds = L.latLngBounds(
                [minX, minY],
                [maxX, maxY]
              );

              mapInstance.map.fitBounds(bounds);
            } else alert('Нет данные!');

            mapInstance.isLoading = false;
          });
        }
      },
      createGeoJSON(obj) {
        if (obj) {
          if (obj.long && obj.lat)
            return {
              "type": "Feature",
              "properties": {
                ...obj
              },
              "geometry": {
                "type": "Point",
                "coordinates": [parseFloat(obj.long), parseFloat(obj.lat)]
              }
            };
          else if (obj.longitude && obj.latitude)
            return {
              "type": "Feature",
              "properties": {
                ...obj
              },
              "geometry": {
                "type": "Point",
                "coordinates": [parseFloat(obj.longitude), parseFloat(obj.latitude)]
              }
            };
          else {
            // console.log('obj without latlong: ', obj);
            if (obj.code) this.errorStr += `${obj.code}\n`;
            if (obj.cadaster_number) this.errorStr += `${obj.cadaster_number}\n`;
          }
        } else return alert('Невозможно создать geoJSON формат!');
      }
    }
  });

  let groundwaterModal = new Vue({
    el:'#groundwaterModal',
    data() {
      return {
        groundwaterInfo: null,
      }
    },

    methods: {
      getRegions(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_region) {
              if (!str.includes(arr[i].uz_region.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_region.nameRu
                else str += arr[i].uz_region.nameRu + ', '
              }
            }
          }
        }
        return str
      }
    },
  });

  let pumpstationModal = new Vue({
    el:'#pumpstationModal',
    data() {
      return {
        pumpstationInfo: null,
      }
    },

    methods: {
      getRegions(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_region) {
              if (!str.includes(arr[i].uz_region.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_region.nameRu
                else str += arr[i].uz_region.nameRu + ', '
              }
            }
          }
        }
        return str
      }
    },
  });

  let waterworkModal = new Vue({
    el:'#waterworkModal',
    data() {
      return {
        waterworkInfo: null,
      }
    },

    methods: {
      getRegions(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_region) {
              if (!str.includes(arr[i].uz_region.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_region.nameRu
                else str += arr[i].uz_region.nameRu + ', '
              }
            }
          }
        }
        return str
      }
    },
  });

  let stationModal = new Vue({
    el:'#stationModal',
    data() {
      return {
        stationInfo: null,
      }
    },

    methods: {
      getRegions(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_region) {
              if (!str.includes(arr[i].uz_region.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_region.nameRu
                else str += arr[i].uz_region.nameRu + ', '
              }
            }
          }
        }
        return str
      }

    },
  });

  let wellModal = new Vue({
    el:'#wellModal',
    data() {
      return {
        wellInfo: null,
      }
    },

    methods: {
      getRegions(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_region) {
              if (!str.includes(arr[i].uz_region.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_region.nameRu
                else str += arr[i].uz_region.nameRu + ', '
              }
            }
          }
        }
        return str
      },

      getDistricts(arr) {
        let str = ''
        if(arr) {
          for (let i = 0; i < arr.length; i ++) {
            if (arr[i].uz_district) {
              if (!str.includes(arr[i].uz_district.nameRu)) {
                if(i == arr.length - 1) str += arr[i].uz_district.nameRu
                else str += arr[i].uz_district.nameRu + ', '
              }
            }
          }
        }
        return str
      }

    },
  });

  $('.map-collapse').on('show.bs.collapse', function () {
    $(this).parent().find(".bi-plus").removeClass("bi-plus").addClass("bi-dash");
  }).on('hide.bs.collapse', function () {
    $(this).parent().find(".bi-dash").removeClass("bi-dash").addClass("bi-plus");
  });
</script>
@endpush
