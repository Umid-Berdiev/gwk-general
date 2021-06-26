<div class="row mb-3">
  <div class="col-auto ml-auto">
    <button onclick="exportExcel()" type="button" class="btn btn-info btn-sm">
      {{ __('messages.Export') }}
    </button>
    {{-- <button >Export table to excel xlsx</button> --}}
  </div>
</div>

@push('scripts')
<script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
  function exportExcel() {
    const elt = document.getElementById("exportable_table");
    const wb = XLSX.utils.table_to_book(elt, {
      sheet: "Sheet JS"
    });
    return XLSX.writeFile(wb, `table-export-${new Date().getTime()}.xlsx`);
  }
</script>
@endpush
