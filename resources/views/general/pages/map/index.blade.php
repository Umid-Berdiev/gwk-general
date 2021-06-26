@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
<style>
  #mapid {
    height: 80vh;
  }
</style>
@endsection

@section('content')
<div class="container-fluid" id="map-instance">
  <div class="row justify-content-center">
    <div v-if="isLoading" class="position-absolute d-inline my-auto" style="z-index: 1000; top: 50%; left: 45%;">
      <div class="spinner-grow" style="width: 5rem; height: 5rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <!-- there will be a map -->
    <div id="mapid"></div>

    <div id="map-right-sidebar" v-show="isShown" class="w-25 position-absolute bg-white h-100">
      <!-- accordion -->
      {{-- @include('gidrogeologiya.pages.map.accordion') --}}
    </div>
    <div id="map-right-sidebar-toggle-btn" class="position-absolute">
      <button class="btn btn-primary px-5 py-3" @click="isShown = !isShown">
        {{ __('messages.Фильтр') }}
      </button>
    </div>
  </div>
</div>
@endsection

@section('modal')

@endsection

@push('scripts')
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
  const mapInstance = new Vue({
      el:"#map-instance",
      data() {
        return {
          isLoading: false,
          isShown: false,
          tileProviders: [
            {
              name: "Openstreet харита",
              visible: true,
              attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
              url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            },
            {
              name: "Google харита",
              visible: false,
              url: "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}",
              attribution: "GoogleMaps",
            },
            {
              name: "Google харита (сунъний йўлдош)",
              visible: false,
              url: "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}",
              attribution: "GoogleSatellite",
            },
          ],

        }
      },
      methods: {
        initialMap() {
          map = L.map('mapid').setView([41.95949, 67.335205], 6);

          // let osmUrl = 'http://www.google.com/maps/vt?lyrs=m@189&gl=uz&x={x}&y={y}&z={z}',
          //   osmAttrib = 'Google maps street view',
          //   osm = new L.TileLayer(osmUrl, {
          //     maxZoom: 18, attribution: osmAttrib, scale: true, edit: false
          //   }),
          //   drawnItems = L.featureGroup().addTo(map);

          L.control.scale({
            imperial: false
          }).addTo(map);

          L.control.layers({
            'Схематичная карта': osm.addTo(map),
            "Спутниковая карта": L.tileLayer('http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}', {attribution:"Google maps satellite view"}),
          },
          {
            //
          },
          {
            position: 'topleft',
            collapsed: false
          }).addTo(map);

          map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.
        }
      }
    })
</script>
@endpush
