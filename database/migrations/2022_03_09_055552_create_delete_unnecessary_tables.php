<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleteUnnecessaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('approval_plot_attrs');
      Schema::dropIfExists('approval_plot_type_water_use');
      Schema::dropIfExists('approval_plots');
      Schema::dropIfExists('canals_attrs');
      Schema::dropIfExists('canals');
      Schema::dropIfExists('canal_functions');
      Schema::dropIfExists('collectors_attrs');
      Schema::dropIfExists('collectors');
      Schema::dropIfExists('colleсtorFunctions');
      Schema::dropIfExists('cover_types');
      Schema::dropIfExists('created_day_reports');
      Schema::dropIfExists('dannyes');
      Schema::dropIfExists('data__atters');
      Schema::dropIfExists('extremal_data');
      Schema::dropIfExists('gidrogeologiya_dashboards');
      Schema::dropIfExists('gidromet_contacts');
      Schema::dropIfExists('gidromet_dashboard_stats');
      Schema::dropIfExists('gidromet_decades');
      Schema::dropIfExists('gidromet_max_values');
      Schema::dropIfExists('gidromet_min_values');
      Schema::dropIfExists('mineral_water');
      Schema::dropIfExists('minvodxoz_contacts');
      Schema::dropIfExists('minvodxoz_dashboard_stats');
      Schema::dropIfExists('minvodxoz_dashboard_stats_local_type');
      Schema::dropIfExists('minvodxoz_dashboard_stats_type');
      Schema::dropIfExists('mountain_ranges_attrs');
      Schema::dropIfExists('mountain_ranges');
      Schema::dropIfExists('newtemplate_headers');
      Schema::dropIfExists('newtemplate_objects');
      Schema::dropIfExists('newtemplates');
      Schema::dropIfExists('objects_items');
      Schema::dropIfExists('objects_olchovs');
      Schema::dropIfExists('otchets');
      Schema::dropIfExists('plots_deposits_attrs');
      Schema::dropIfExists('plots_deposits');
      Schema::dropIfExists('polygon_coords');
      Schema::dropIfExists('q_izmerennyes');
      Schema::dropIfExists('rasxod_vodies');
      Schema::dropIfExists('reportnew_values');
      Schema::dropIfExists('reportnews');
      Schema::dropIfExists('shablonatters');
      Schema::dropIfExists('shablons');
      Schema::dropIfExists('stat_information');
      Schema::dropIfExists('stat_itxb_forms');
      Schema::dropIfExists('stat_water_sources');
      Schema::dropIfExists('stat_used_waters');
      Schema::dropIfExists('stat_itxb_objects');
      Schema::dropIfExists('stat_water_forms');
      Schema::dropIfExists('stat_reports');
      Schema::dropIfExists('stat_objects');
      Schema::dropIfExists('tablitsa1s');
      Schema::dropIfExists('tablitsa2s');
      Schema::dropIfExists('tablitsa3s');
      Schema::dropIfExists('tablitsa4s');
      Schema::dropIfExists('tablitsa5s');
      Schema::dropIfExists('tablitsa6s');
      Schema::dropIfExists('tablitsa7s');
      Schema::dropIfExists('template_bodies');
      Schema::dropIfExists('template_body_atters');
      Schema::dropIfExists('template_form_atters');
      Schema::dropIfExists('template_forms');
      Schema::dropIfExists('template_headers');
      Schema::dropIfExists('template_orgs');
      Schema::dropIfExists('template_types');
      Schema::dropIfExists('uz_punkts');
      Schema::dropIfExists('uz_streets');
      Schema::dropIfExists('ximsostav_vodies');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
